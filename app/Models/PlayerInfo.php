<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerInfo extends Model
{
    use HasFactory;

    protected $connection = 'nba_backend_2020';

    public function scopeInjured($query)
    {
        return $query->where('status', 'injured');
    }

    public function scopeOfPlayerIds($query, $PlayerIds)
    {
        return $query->whereIn('player_id', $PlayerIds);
    }
}
