<?php

namespace App\Models;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Event extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'eventos_v2';


    /**
     * Funcionalidade de buscar no mongo as noticias mais acessadas no periodo de 24 horas
     *
     * @param integer $limit
     * @return void
     */
    public static function getTrendingTopicsNewsIds( $limit = 10)
    {
        $last24Hours = Carbon::now()->subHours(24);
        // $last24Hours = Carbon::createFromFormat('Y-m-d', '2018-12-01');

        $eventos = self::where('action', 'news')->where('datetime', '>=', $last24Hours)->get(); 
        $grouped = $eventos->map(function ($item, $key) {
            return ['id' => $item["news"]["id"]];
        });

        $occurrences = $grouped->where('id', '!=', '')->groupBy('id')->map(function ($item) {
            return $item->count();
        });
        
        $trendingTopics = $occurrences->sort()->reverse()->take( $limit ); 

        TrendingTopicsSnapshot::insert($trendingTopics);
    
        return $trendingTopics; 
    }

    public static function getNewsById($newsId)
    {
        $last24Hours = Carbon::now()->subHours(24);
        // $date = new \MongoDB\BSON\UTCDateTime($last24Hours);
        $date = null;

        return self::raw(function ($collection) use ($newsId, $date) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'action' => 'news',
                        'news.id' => $newsId,
                        // 'datetime' => ['$gte' => $date]
                    ],
                ]
            ]);
        });
    }


}
