<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\History;
use App\Models\Member;
use App\Models\Prize;
use App\Models\Selection;
use App\Models\Setting;
use App\Models\User;
use App\Models\Weight;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        Member::truncate();
        History::truncate();
        Selection::truncate();

        User::truncate();

        Weight::truncate();
        Setting::truncate();
        Prize::truncate();
        Game::truncate();
        GamePlayer::truncate();

        Schema::enableForeignKeyConstraints();

        Member::factory(9)->has(
            History::factory(1)->has(
                Selection::factory(5)
            )
        )
            ->create();

        User::create([
            'name' => 'Liam Li',
            'email' => 'liam.li@udngroup.com',
            'password' => Hash::make('a32123212'),
        ]);

        Weight::create([
            'point' => 1,
            'reb' => 1.2,
            'assist' => 1.5,
            'steal' => 3,
            'block' => 3,
            'turnover' => -1
        ]);

        Setting::create([
            'year' => '2021',
            'type' => 'playoff',
            'award_year' => '2021'
        ]);

        Prize::create([
            'name' => '季後賽總排名第一名',
            'title' => 'NBA 球員版球衣 1 件',
            'img' => '2021-prize3.jpg'
        ]);
        Prize::create([
            'name' => '季後賽總排名前十名',
            'title' => '長傘 1 支',
            'img' => '2021-prize2.jpg'
        ]);
        Prize::create([
            'name' => '季後賽每周排名第一名',
            'title' => 'NBA 球衣 1 件',
            'img' => '2021-prize3.jpg'
        ]);
        Prize::create([
            'name' => '季後賽每輪排名第一名',
            'title' => 'NBA 外套 1 件',
            'img' => '2021-prize4.jpg'
        ]);
        Prize::create([
            'name' => '例行賽總排名第一名',
            'title' => 'NBA Store 特製麻將組 1 組',
            'img' => 'top.jpg'
        ]);
        Prize::create([
            'name' => '例行賽總排名第二名',
            'title' => 'NBA Store 線上禮券 NT$3000',
            'img' => 'top.jpg'
        ]);
        Prize::create([
            'name' => '例行賽總排名第三名',
            'title' => 'NBA Store 線上禮券 NT$2000',
            'img' => 'top.jpg'
        ]);
        Prize::create([
            'name' => '例行賽總排名第四名至第十名',
            'title' => 'NBA Store 線上禮券 NT$1000',
            'img' => 'top.jpg'
        ]);
        Prize::create([
            'name' => '例行賽每週排名第一名',
            'title' => 'NBA 球衣1件',
            'img' => 'top.jpg'
        ]);
    }
}
