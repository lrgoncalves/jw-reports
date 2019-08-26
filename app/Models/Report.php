<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'publisher_id',
        'yearmonth',
        'hours',
        'placements',
        'videos',
        'return_videos',
        'bible_studies',
    ];
}
