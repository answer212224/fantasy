<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $connection = 'nba_backend_2020';
    public function scopeTomorrow($query)
    {
        // TODO date_only
        return $query->where('date_only', Carbon::tomorrow()->format('Y-m-d'));
        return $query->where('date_only', today()->subMonths(3)->addDay()->format('Y-m-d'));
        return $query->where('date_only', '2021-07-02');
    }

    public function scopeLocalTime($query)
    {
        return $query->where('local_time', '!=', 'TBD');
    }

    public function scopeOfDate($query, $date)
    {
        return $query->where('date_only', $date);
    }

    public function homeTeam()
    {
        return $this->hasOne(NbaTeam::class, 'nba_team_id', 'home_team');
    }
    public function awayTeam()
    {
        return $this->hasOne(NbaTeam::class, 'nba_team_id', 'away_team');
    }
}
