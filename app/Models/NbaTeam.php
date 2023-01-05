<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NbaTeam extends Model
{
    use HasFactory;

    protected $connection = 'nba_backend_2020';

    public function players()
    {
        return $this->hasMany(Player::class, 'nba_team_id', 'nba_team_id');
    }

    public function HomeSchedules()
    {
        return $this->hasMany(Schedule::class, 'home_team', 'nba_team_id');
    }

    public function AwaySchedules()
    {
        return $this->hasMany(Schedule::class, 'away_team', 'nba_team_id');
    }

    public function getConferenceZHAttribute()
    {
        if($this->conference == 'west') return '西區';
        if($this->conference == 'east') return '東區';
    }
}
