<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Member;
use App\Models\Player;
use App\Models\Score;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Prize;
use App\Models\Weight;
use App\Models\Award;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

use function PHPUnit\Framework\isEmpty;

class HomeController extends Controller
{

    public function __construct(Member $member, Setting $setting)
    {
        $this->member = $member;
        $this->setting = $setting;
    }

    public function index()
    {
        $member = session('member_id');
        $setting = $this->setting->first();
        $fantasyNews = $this->fetch('Fantasy', 5);
        $fantasyRankNew = $this->fetch('Fantasy排名', 1);
        if ($fantasyNews['state'] == true) {
            $fantasyNews = collect($fantasyNews['lists']);
        } else {
            $fantasyNews = collect([]);
        }

        if ($fantasyRankNew['state'] == true) {
            $fantasyRankNew = collect($fantasyRankNew['lists'][0] ?? null);
        } else {
            $fantasyRankNew = collect([]);
        }

        if (Cache::has('topPlayers')) {
            $topPlayers = Cache::get('topPlayers');
        } else {
            $topPlayers = $this->getTopPlayers();

            Cache::put('topPlayers', $topPlayers);
        }

        if (Cache::has('weeklyRankingMembers')) {
            $weeklyRankingMembers = Cache::get('weeklyRankingMembers');
        } else {
            $weeklyRankingMembers = $this->getWeeklyRanking();
            Cache::put('weeklyRankingMembers', $weeklyRankingMembers);
        }

        if (Cache::has('overallRankingMembers')) {
            $overallRankingMembers = Cache::get('overallRankingMembers');
        } else {
            $overallRankingMembers = $this->getOverallRanking();
            Cache::put('overallRankingMembers', $overallRankingMembers);
        }

        return view('frontend.index', compact('topPlayers', 'member', 'weeklyRankingMembers', 'overallRankingMembers', 'setting', 'fantasyNews', 'fantasyRankNew'));
    }

    public function info()
    {
        $member = session('member_id');
        $setting = $this->setting->first();
        if ($setting->prize_type == 'playoff') $prizes = Prize::whereIn('id', [1, 2, 3, 4])->get();
        if ($setting->prize_type == 'season') $prizes = Prize::whereIn('id', [5, 6, 7, 8, 9])->get();

        $weight = Weight::first();
        $setting = $this->setting->first();

        return view('frontend.info', compact('member', 'prizes', 'weight', 'setting'));
    }

    public function awards()
    {
        $setting = $this->setting->first();
        $member = session('member_id');
        $prizes = Prize::get();
        $awards = Award::with('awardDetails.member')->ofYear($setting->award_year)->get();

        $seasonRankingAwards = $awards->where('type', 'season')->firstWhere('cate', 'ranking');
        $seasonChampionAwards = $awards->where('type', 'season')->firstWhere('cate', 'champion');
        $seasonRoundAwards = $awards->where('type', 'season')->firstWhere('cate', 'round');

        $playoffRankingAwards = $awards->where('type', 'playoff')->firstWhere('cate', 'ranking');
        $playoffChampionAwards = $awards->where('type', 'playoff')->firstWhere('cate', 'champion');
        $playoffRoundAwards = $awards->where('type', 'playoff')->firstWhere('cate', 'round');

        return view('frontend.awards', compact('member', 'playoffRankingAwards', 'playoffChampionAwards', 'playoffRoundAwards', 'seasonRankingAwards', 'seasonChampionAwards', 'seasonRoundAwards', 'prizes', 'setting'));
    }

    public function getOverallRanking()
    {
        $setting = $this->setting->first();
        $historiesWithMember = History::with('member')->where('year', $setting->year)->where('type', $setting->type)->get();

        $historiesGroupByMembers = $historiesWithMember->groupBy('member_id');

        $historiesGroupByMembers->transform(function ($historiesGroupByMember) {
            $total = $historiesGroupByMember->pluck('total')->sum();
            return [
                'member' => $historiesGroupByMember->first()->member,
                'total' => $total,
                'now' => now()->format('Y-m-d h:i:s A')
            ];
        });
        $overallRankingMembers = $historiesGroupByMembers->sortByDesc('total')->take(10)->values();

        return $overallRankingMembers;
    }

    public function showOverallRanking()
    {
        return response()->json($this->getOverallRanking());
    }

    public function getWeeklyRanking()
    {
        $setting = $this->setting->first();
        //TODO date_only
        $historiesScopeWeeklyWithMembers = History::with('member')
            ->where('year', $setting->year)
            ->where('type', $setting->type)
            ->where('date_only', '>=', today()->startOfWeek()->format('Y-m-d'))
            ->where('date_only', '<=', today()->endOfWeek()->format('Y-m-d'))
            ->get();

        $historiesGroupByMembers = $historiesScopeWeeklyWithMembers->groupBy('member_id');

        $historiesGroupByMembers->transform(function ($historiesGroupByMember) {
            $total = $historiesGroupByMember->pluck('total')->sum();
            return [
                'member' => $historiesGroupByMember->first()->member,
                'total' => $total,
                'now' => now()->format('Y-m-d h:i:s A')
            ];
        });
        $weeklyRankingMembers = $historiesGroupByMembers->sortByDesc('total')->take(10)->values();

        return $weeklyRankingMembers;
    }

    public function getTopPlayers()
    {
        $setting = $this->setting->first();
        $historiesWithSelections = History::with('selections')->ofYear($setting->year)->ofType($setting->type)->get();
        $playerIds = $historiesWithSelections->pluck('selections.*.player_id');
        $topPlayersIds = $playerIds->collapse()->countBy()->sortDesc()->take(10)->keys();
        $topPlayers = Player::with(['team', 'postions'])->whereIn('nba_player_id', $topPlayersIds)->get();
        if ($topPlayers->isEmpty()) {
            $topPlayers = Player::with(['team', 'postions'])->whereIn('nba_player_id', [203992, 203991, 1628381, 1627739, 1628981, 201568, 1629164, 203524, 1628989, 1629631])->get();
        }
        return $topPlayers;
    }

    public function test(Request $request)
    {
        dd([
            "fullPath" => $request->fullUrl(),
            "url" => $request->url(),
            "path" => $request->path(),
            "requestURI" => $request->getRequestUri()
        ]);
    }

    public function fetch($tag, $limit)
    {
        $response = Http::get('https://nba.udn.com/api/more', [
            'channelId' => '2000',
            'tag' => $tag,
            'type' => 'fantasy',
            'limit' => $limit
        ]);

        return $response->json();
    }
}
