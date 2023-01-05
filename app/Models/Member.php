<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function getWithWeeklyHistories()
    {
        return $this->with(['histories' => function ($q) {
            $q->where('date_only', '>=', Carbon::today()->subWeek());
        }])->get();
    }
}
