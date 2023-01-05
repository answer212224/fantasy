<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class History extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = ['date_only', 'year', 'type', 'ip', 'total'];


    public function routeNotificationForSlack($notification)
    {
        return env('SLACK_NOTIFICATION_WEBHOOK');
    }

    public function scopeOfDate($query, $gameId)
    {
        return $query->where('date_only', $gameId);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOfYear($query, $year)
    {
        return $query->where('year', $year);
    }

    public function selections()
    {
        return $this->hasMany(Selection::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class)->select(['id', 'name', 'fb', 'email']);
    }
}
