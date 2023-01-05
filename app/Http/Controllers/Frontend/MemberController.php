<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\History;
use App\Models\Selection;
use App\Models\PlayerInfo;
use App\Models\Player;
use App\Models\Schedule;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function index()
    {
        //TODO date_only

        $tomorrow = today()->addDay()->format('Y/m/d');
        // $tomorrow = today()->subMonths(3)->addDay()->format('Y/m/d');
        $today = today()->format('Y-m-d');
        // $today = today()->subMonths(3)->format('Y-m-d');
        $setting = Setting::first();
        $schedulDate = today()->addDay();

        $isShutdown = $schedulDate->between($setting->shutdown_start_date, $setting->shutdown_end_date);

        if ($isShutdown) {
            $schedulDate = '2021-09-25';
        }


        $all = Schedule::with(['homeTeam.players.postions', 'awayTeam.players.postions', 'homeTeam.players.playerInfo', 'awayTeam.players.playerInfo', 'homeTeam.players.team', 'awayTeam.players.team'])->where('local_time', '!=', 'TBD')->whereDate('date_only', $schedulDate)->get();

        $injuredPlayers = PlayerInfo::injured()->get();
        $injuredPlayers->transform(function ($player) {
            return "$player->player_id";
        });


        $member = Member::with(['histories' => function ($q) use ($setting) {
            $q->where('histories.year', '=', $setting->year)
                ->where('histories.type', '=', $setting->type)
                ->with('selections');
        }])->find(session('member_id'));

        $prevPredict = null;
        $previousPrediction = null;
        $todayHistory = null;
        $memberTotal = 0;

        $historyObjects = $member->histories->sortByDesc('date_only')->values();


        if ($historyObjects->isNotEmpty()) {
            $previousPrediction = $historyObjects->first()->selections->map(function ($selsection) {
                return "$selsection->player_id";
            });
            $prevPredict = Carbon::createFromFormat('Y-m-d', $historyObjects->first()->date_only)->subDay()->format('Y-m-d');

            $memberScores = $historyObjects->pluck('total');

            $memberTotal = $memberScores->sum();


            // $members = Member::with(['histories' => function ($q) use ($setting) {
            //     $q->where('histories.year', '=', $setting->year)
            //         ->where('histories.type', '=', $setting->type);
            // }])->get();

            // $totals = $members->map(function ($member) {
            //     $totals = $member->histories->pluck('total');
            //     return $totals->sum();
            // });

            // $totalRank = collect($totals->all())->sortDesc()->values();

            // $rank =  $totalRank->search($memberTotal) + 1;

            $todayHistory = $historyObjects->firstWhere('date_only', $today);

            $historyObjects->transform(function ($item) {
                $date = Carbon::createFromFormat('Y-m-d', $item->date_only)->format('Y-m-d');
                return [
                    'id' => "$item->id",
                    'date' => $date,
                ];
            });
        }

        $homeTeams = $all->map(function ($item) {
            return $item->homeTeam;
        });

        $awayTeams = $all->map(function ($item) {
            return $item->awayTeam;
        });

        $teams = $homeTeams->merge($awayTeams);

        $players = $teams->map(function ($team) {
            return $team->players;
        });

        $players = $players->collapse();

        $nba = $players->transform(function ($player) {
            $postions = collect($player->postions->all());
            $postionsArray = $postions->map(function ($item) {
                return $item->Uctitle;
            })->toArray();
            $teamAbbr = collect($player->team)->get('team_abbr_en');
            $rating = collect($player->playerInfo)->get('rate');
            return [
                'playerId' => "$player->nba_player_id",
                'firstName' => $player->first_name,
                'lastName' => $player->last_name,
                'jerseyNo' => "$player->jersey",
                'code' => $player->player_code,
                'rating' => "$rating",
                'team' => $teamAbbr,
                'position' => $postionsArray,
            ];
        });



        $nba = $nba->filter(function ($value) {
            return $value['rating'] != "";
        });

        $nba = $nba->values();

        $playState = $nba->isNotEmpty();

        $date = [
            'today' => $today,
            'prevPredict' => $prevPredict
        ];

        return view('frontend.member', compact('member', 'tomorrow', 'playState', 'previousPrediction', 'injuredPlayers', 'historyObjects', 'date', 'nba', 'todayHistory', 'memberTotal', 'setting'));
    }

    public function store(Request $request)
    {
        $setting =  Setting::find(1);
        $member = Member::find(session('member_id'))->load('histories');

        $year = $setting->year;
        $type = $setting->type;
        //TODO date_only
        // $date_only = today()->subMonths(3)->addDay()->format('Y-m-d');

        $date_only = today()->addDay()->format('Y-m-d');

        $playerIds = $request->input('players.*.playerID');
        $playerinfos = PlayerInfo::ofPlayerIds($playerIds)->get();
        $rates = $playerinfos->pluck('rate');
        $totalRate = $rates->sum();


        if ($totalRate > 430) {
            return 'rate大於430';
        }

        if (now()->hour < 6) {
            return '請在台灣時間早上06:00~23:59選擇隔天出賽的球員。';
        }

        $validator = Validator::make($request->all(), [
            'players.*.playerID' => 'required|exists:App\Models\Player,nba_player_id',
            'players.*.position' => 'required|bail|alpha',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $history = $member->histories()->firstOrCreate(
            [
                'date_only' => $date_only,
            ],
            [
                'year' => $year,
                'type' => $type,
                'ip' => getIp(),
            ]
        );

        $history->selections()->updateOrCreate(
            [
                'order' => 0
            ],
            [
                'postion' => 'G',
                'player_id' => $playerIds[0],
                'date_only' => $date_only
            ]
        );
        $history->selections()->updateOrCreate(
            [
                'order' => 1
            ],
            [
                'postion' => 'G',
                'player_id' => $playerIds[1],
                'date_only' => $date_only
            ]
        );
        $history->selections()->updateOrCreate(
            [
                'order' => 2
            ],
            [
                'postion' => 'F',
                'player_id' => $playerIds[2],
                'date_only' => $date_only
            ]
        );
        $history->selections()->updateOrCreate(
            [
                'order' => 3
            ],
            [
                'postion' => 'F',
                'player_id' => $playerIds[3],
                'date_only' => $date_only
            ]
        );
        $history->selections()->updateOrCreate(
            [
                'order' => 4
            ],
            [
                'postion' => 'C',
                'player_id' => $playerIds[4],
                'date_only' => $date_only
            ]
        );

        return 'ok';
    }

    public function search(Request $request)
    {
        // 不存在ID / 非數字 - 導到404
        // 只有member自己才能看的到屬於自己的記錄


        $validator = Validator::make($request->all(), [
            'id' => [
                'required',
                'integer',
                Rule::exists('histories')->where(function ($query) {
                    $query->where('member_id', session('member_id'));
                }),
            ],
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $history = History::find($request->id);
        $scopeDateHistories = History::ofDate($history->date_only)->orderBy('total', 'desc')->get();
        $totals =  $scopeDateHistories->pluck('total');

        $rank = $totals->search($history->total);

        $selections = $history->selections()->with(['player.postions', 'player.team', 'gamePlayer' => function ($q) use ($history) {
            $q->where('game_players.date_only', '=', $history->date_only)->get();
        }])->get();


        $players = $selections->map(function ($item) {
            $player_id = $item->player_id;
            $assist = optional($item->gamePlayer)->assist;
            $block = optional($item->gamePlayer)->block;
            $point = optional($item->gamePlayer)->point;
            $steal = optional($item->gamePlayer)->steal;
            $turnover = optional($item->gamePlayer)->turnover;
            $reb = optional($item->gamePlayer)->reb;
            $postions = optional(optional($item->player)->postions)->pluck('title');

            return [
                'player_id' => $player_id,
                'position' => $postions,
                'region' => optional(optional($item->player)->team)->conference,
                'assists' => $assist ? "$assist" : "0",
                'jersey' => Str::of(optional($item->player)->jersey),
                'lastname' => optional($item->player)->last_name,
                'firstname' => optional($item->player)->first_name,
                'blocks' => $block ? "$block" : "0",
                'rebs' => $reb ? "$reb" : "0",
                'scores' => $item->score,
                'turnovers' => $turnover ? "$turnover" : "0",
                'steals' => $steal ? "$steal" : "0",
                'points' => $point ? "$point" : "0",
                'teamAbbr' => optional(optional($item->player)->team)->team_abbr_en,
            ];
        });

        return response(
            [
                'rank' => $rank + 1,
                'date' => Carbon::createFromFormat('Y-m-d', $history->date_only)->format('Y-m-d'),
                'players' => $players,
            ]
        );
    }
}
