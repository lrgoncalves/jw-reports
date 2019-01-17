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
        $lastHours = Carbon::now()->subHours(env('TRENDING_TOPICS_LAST_HOURS', 72));
        // $lastHours = Carbon::createFromFormat('Y-m-d', '2018-12-01');

        $eventos = self::where('action', 'news')->where('datetime', '>=', $lastHours)->get(); 
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
        $lastHours = Carbon::now()->subHours(env('TRENDING_TOPICS_LAST_HOURS', 72));
        $date = new \MongoDB\BSON\UTCDateTime($lastHours);
        // $date = null;

        return self::raw(function ($collection) use ($newsId, $date) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'action' => 'news',
                        'news.id' => $newsId,
                        'news.publisherId' => ['$exists' => true],
                        'news.logo' => ['$exists' => true],
                        // 'datetime' => ['$gte' => $date]
                    ],
                ]
            ]);
        });
    }


}
