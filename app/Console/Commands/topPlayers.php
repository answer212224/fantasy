<?php

namespace App\Console\Commands;

use App\Http\Controllers\Frontend\HomeController;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class topPlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'player:top';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get top10 Players cache';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(HomeController $home)
    {
        parent::__construct();
        $this->home = $home;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Cache::forget('topPlayer');
        Cache::put('topPlayers', $this->home->getTopPlayers());

        Log::info('最夯球員 cache: ' . Cache::get('topPlayers'));
    }
}
