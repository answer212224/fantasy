<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\GameController;
use App\Http\Controllers\Backend\ScoreController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WebHookController extends Controller
{
    public function __construct(HomeController $home, ScoreController $score, GameController $game)
    {
        $this->home = $home;
        $this->score = $score;
        $this->game = $game;
    }
    public function store(Request $request)
    {
        $dateUTC = Str::of($request->info['data']['gameInfo']['date'])->explode('/');
        $dateUTC = Carbon::create($dateUTC[2], $dateUTC[0], $dateUTC[1]);
        $dateAsia = $dateUTC->addDay()->format('Y-m-d');

        $this->game->updateGame($request);
        $this->score->total($dateAsia);
    }
}
