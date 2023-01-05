<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'shutdown_start_date' => 'datetime:Y-m-d',
        'shutdown_end_date' => 'datetime:Y-m-d',
    ];
}
