<?php

namespace App\Jobs;

use App\Models\Member;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessRanking implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    { }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $setting = Setting::first();

        $members = Member::withSum(['histories' => function ($q) use ($setting) {
            $q->where('histories.year', $setting->year)
                ->where('histories.type', $setting->type);
        }], 'total')->get();

        $sorted = $members->sortByDesc('histories_sum_total')->values();

        $sorted->each(function ($sort, $key) {
            $sort->update(['rank' => $key + 1]);
        });

        Log::debug('ProcessRanking');
    }
}
