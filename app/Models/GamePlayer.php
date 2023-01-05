<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamePlayer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeOfDate($query, $date)
    {
        return $query->where('date_only', $date);
    }

    public function scopeOfGameId($query, $gameId)
    {
        return $query->where('game_id', $gameId);
    }

    public function selections()
    {
        return $this->hasMany(Selection::class, 'player_id', 'player_id');
    }

    public function player()
    {
        return $this->hasOne(Player::class, 'nba_player_id', 'player_id');
    }
}
