<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $connection = 'nba_backend_2020';

    public function getUcTitleAttribute()
    {
        return ucfirst($this->title);
    }


    public function getZhTitleAttribute()
    {
        if($this->title == 'g') return '後衛';
        if($this->title == 'f') return '中鋒';
        if($this->title == 'c') return '前鋒';
    }

}
