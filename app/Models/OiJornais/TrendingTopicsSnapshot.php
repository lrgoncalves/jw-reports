<?php

namespace App\Models\OiJornais;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Carbon\Carbon;

class TrendingTopicsSnapshot extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'trending_v2';

    protected $fillable = [
        "datetime", 
        "items"
    ];
    
    protected $dates = ["datetime"];
  
    public static function insert($trending)
    {  
        $date =  Carbon::now()->toDateTimeString();
        self::create([
            'datetime' => $date,
            'items' =>  $trending->all()
        ]);
    }
}

