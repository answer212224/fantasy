<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\HomeController;
use App\Jobs\ProcessRanking;
use App\Models\GamePlayer;
use App\Models\History;
use App\Models\Member;
use App\Models\Score;
use App\Models\Weight;
use App\Notifications\SendNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ScoreController extends Controller
{
    public function __construct(HomeController $home)
    {
        $this->home = $home;
    }

    public function index(History $history)
    {
        // $history = $history->where('date_only', '2021-10-26')->where('total', '>=', 350);
        // dd($history->get());
        // $history->notify(new SendNotification(''));

        $scores = Score::orderBy('date_only', 'desc')->paginate('10');
        return view('backend.scores.index', compact('scores'));
    }

    public function search(Request $request)
    {
        $scores = Score::ofDate($request->date)->orderBy('status')->get();
        return view('backend.scores.index', compact('scores'));
    }

    public function update(Request $request)
    {
        $response = $this->total($request->date);
        if ($response->original['status']) session()->flash('success', $response->original['message']);
        else session()->flash('error', $response->original['message']);
        return back();
    }

    public function total($date)
    {
        $score = Score::ofDate($date)->first();

        if (!$score) {
            return response([
                'status' => false,
                'message' => "game date: " . $date . " date of games update no need"
            ]);
        }
        $weight = Weight::first();

        $gamePlayers = GamePlayer::with(['selections' => function ($q) use ($date) {
            $q->where('date_only', $date);
        }])->where('date_only', $date)->get();
        $gamePlayers->each(function ($gamePlayer) use ($weight, $date) {
            $gamePlayer->selections()->where('date_only', $date)->update([
                'score' => $weight->assist * $gamePlayer->assist
                    + $weight->block * $gamePlayer->block
                    + $weight->point * $gamePlayer->point
                    + $weight->steal * $gamePlayer->steal
                    + $weight->turnover * $gamePlayer->turnover
                    + $weight->reb * $gamePlayer->reb
            ]);
        });

        $histories = History::with('selections')->where('date_only', $date)->get();

        $histories->each(function ($history) {
            $scores = $history->selections->pluck('score');
            $history->update([
                'total' =>  $scores->sum()
            ]);
        });

        $score->status = true;
        $score->save();

        // $filtered = $histories->where('total', '>=', 350)->first();

        // if ($filtered) {
        //     $filtered->notify(new SendNotification($filtered));
        // }

        $overallRanking = $this->home->getOverallRanking();
        $weeklyRanking = $this->home->getWeeklyRanking();

        ProcessRanking::dispatch();

        Notification::route('slack', env('SLACK_NOTIFICATION_WEBHOOK'))
            ->notify(new SendNotification($overallRanking));
        Notification::route('slack', env('SLACK_NOTIFICATION_WEBHOOK'))
            ->notify(new SendNotification($weeklyRanking));

        Cache::forget('overallRankingMembers');
        Cache::forget('weeklyRankingMembers');
        Cache::put('overallRankingMembers', $overallRanking);
        Cache::put('weeklyRankingMembers', $weeklyRanking);
        Log::info('積分風雲榜總排名 cache: ' . Cache::get('overallRankingMembers'));
        Log::info('積分風雲榜每周排名 cache: ' . Cache::get('weeklyRankingMembers'));

        return response([
            'status' => true,
            'message' => "game date: " . $date . " date of histories updated successful"
        ]);
    }

    public function overallRanking()
    {
        $overallRanking = $this->home->getOverallRanking();

        Cache::forget('overallRankingMembers');

        Cache::put('overallRankingMembers', $overallRanking);

        return response([
            'state' => true,
            'data' => $overallRanking
        ]);
    }

    public function weeklyRanking()
    {
        $weeklyRanking = $this->home->getWeeklyRanking();

        Cache::forget('weeklyRankingMembers');

        Cache::put('weeklyRankingMembers', $weeklyRanking);

        return response([
            'state' => true,
            'data' => $weeklyRanking
        ]);
    }
}
