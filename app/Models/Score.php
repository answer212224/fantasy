<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeOfDate($query, $date)
    {
        return $query->where('date_only', $date);
    }

    public function scoreGames()
    {
        return $this->hasMany(ScoreGame::class);
    }
}
