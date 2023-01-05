<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Selection extends Model
{
    use HasFactory;

    protected $fillable = ['order', 'postion', 'date_only', 'player_id'];

    public function game()
    {
        return $this->hasOne(GamePlayer::class, 'nba_game_id', 'nba_game_id');
    }

    public function gamePlayer()
    {
        return $this->hasOne(GamePlayer::class, 'player_id', 'player_id');
    }

    public function player()
    {
        return $this->hasOne(Player::class, 'nba_player_id', 'player_id');
    }

    public function history()
    {
        return $this->belongsTo(History::class);
    }

    public function scopeOfGameId($query, $gameId)
    {
        return $query->where('nba_game_id', $gameId);
    }

    public function scopeOfDate($query, $date)
    {
        return $query->where('date_only', $date);
    }
}
