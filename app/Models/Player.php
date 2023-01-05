<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Player extends Model
{
    use HasFactory;

    protected $connection = 'nba_backend_2020';

    public function playerInfo()
    {
        return $this->hasOne(PlayerInfo::class, 'player_id', 'nba_player_id');
    }

    public function postions()
    {
        return $this->hasMany(Position::class, 'player_id', 'nba_player_id');
    }

    public function team()
    {
        return $this->hasOne(NbaTeam::class, 'nba_team_id', 'nba_team_id');
    }

    public function scopeOfPlayerId($query, $playerId)
    {
        return $query->where('nba_player_id', $playerId);
    }

    public function getFullNameAttribute()
    {
        $fullname =  "{$this->first_name}_{$this->last_name}";
        return Str::lower($fullname);
    }
}
