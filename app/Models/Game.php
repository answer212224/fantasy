<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Game extends Model
{
    use HasFactory;
    use Notifiable;

    protected $guarded = [];

    public function routeNotificationForSlack($notification)
    {
        return env('SLACK_NOTIFICATION_WEBHOOK');
    }

    public function scopeOfDate($query, $date)
    {
        return $query->where('date_only', $date);
    }

    public function gamePlayers()
    {
        return $this->hasMany(GamePlayer::class);
    }
}
