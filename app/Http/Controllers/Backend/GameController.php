<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\Schedule;
use App\Models\Score;
use App\Models\ScoreGame;
use App\Models\Setting;
use App\Models\Weight;
use App\Notifications\GameNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::orderBy('date_only', 'desc')->paginate('10');
        $games = $games->setPath(env('APP_URL') . '/admin/games');
        return view('backend.games.index', compact('games'));
    }

    public function search(Request $request)
    {

        $games = Game::ofDate($request->date)->orderBy('date_only', 'desc')->paginate('10');
        $games = $games->setPath(env('APP_URL') . '/admin/games/search?date=' . $request->date);
        return view('backend.games.index', compact('games'));
    }

    public function players(Game $game)
    {
        $weight = Weight::find(1);
        $game = $game->load('gamePlayers.player');
        return view('backend.games.players', compact('game', 'weight'));
    }

    public function playersByGameId(Request $request, $id)
    {
        $weight = Weight::find(1);
        $game = Game::where('nba_game_id', $id)->first();
        if (empty($game)) return abort(404, 'Game not found');

        $game = $game->load('gamePlayers.player');
        return view('backend.games.players-guest', compact('game', 'weight'));
    }

    public function updateGame(Request $request)
    {

        if (isset($request->info['id'])) {
            $nbaGameId = $request->info['id'];
        } else {
            $nbaGameId = $request->game_id;
        }

        $all = self::fetch($nbaGameId);

        if ($all['state'] == false) {
            return response([
                'status' => false,
                'message' => $nbaGameId . ' invalid gameID or TBD'
            ]);
        }



        $dateUTC = Str::of($all['gameInfo']['date'])->explode('/');
        $dateUTC = Carbon::create($dateUTC[2], $dateUTC[0], $dateUTC[1]);
        $dateAsia = $dateUTC->addDay()->format('Y-m-d');
        $players = collect($all['players']);
        $players = $players->filter(function ($player) {
            return $player['gameMinutes'] > 0;
        });
        $players->transform(function ($player) use ($all, $dateAsia) {
            return [
                'nba_game_id' => $all['gameInfo']['id'],
                'player_id' => $player['playerId'],
                'date_only' => $dateAsia,
                'assist' => $player['assists'],
                'block' => $player['blocks'],
                'reb' => $player['rebounds'],
                'turnover' => $player['turnovers'],
                'steal' => $player['steals'],
                'point' => $player['points'],
            ];
        });



        $game = Game::where('nba_game_id', $nbaGameId)->first();

        if ($game) {
            $game->delete();
        }

        $game = Game::create([
            'nba_game_id' => $nbaGameId,
            'date_only' => $dateAsia,
            'status' => true
        ]);

        $game->gamePlayers()->createMany($players->all());

        // $gameIds = Schedule::where('date_only', $dateAsia)->get()->pluck('game_id');
        // $gameIds->each(function ($gameId) use ($dateAsia) {
        //     Game::firstOrCreate(
        //         ['nba_game_id' => $gameId],
        //         ['date_only' => $dateAsia]
        //     );
        // });

        Score::firstOrCreate(['date_only' => $dateAsia]);

        $data = [
            'status' => true,
            'message' => $nbaGameId . ' updated successful',
            'data' => $game->gamePlayers,
        ];

        return response()->json($data);
    }

    public function update(Request $request)
    {
        $response = $this->updateGame($request);
        if ($response->original['status']) session()->flash('success', $response->original['message']);
        else session()->flash('error', $response->original['message']);
        return back();
    }

    public static function fetch($id)
    {
        return Http::withHeaders([
            'x-api-key' => env('NBA_UDN_API_KEY')
        ])->get('https://nbafantasynd.udn.com/nba_data/matches/' . $id)->json();
    }
}
