<?php

namespace App\Models\TimBanca;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Event extends Eloquent
{
    protected $connection = 'mongodb_timbanca';
    protected $collection = 'eventos_v2';

    public static function getMagazinesFeatures()
    {
        $lastHours = Carbon::now()->subHours(env('TRENDING_TOPICS_LAST_HOURS', 72));
        $date = new \MongoDB\BSON\UTCDateTime($lastHours);

        return self::raw(function ($collection) use ($date) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'action' => [
                            '$in' => [
                                'magazine_read',
                                'magazine_download'
                            ]
                        ],
                        'datetime' => ['$gte' => $date]
                    ],
                ],[
                    '$group' => [
                        '_id' => [
                            'user_id' => '$user.id',
                            'magazine_id' => '$magazine.publication_id'
                        ],
                        'count' => [
                            '$sum' => 1
                        ]
                    ]
                ],[
                    '$sort' => [
                        'count' => -1
                    ]
                ]
            ]);
        });
    }
}
