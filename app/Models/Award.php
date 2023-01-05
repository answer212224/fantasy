<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function awardDetails()
    {
        return $this->hasMany(AwardDetail::class);
    }

    public function scopeOfYear($query, $year)
    {
        return $query->where('year', $year);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
