<?php

namespace App\Models\HubeApp;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class EventV2 extends Eloquent
{
    protected $connection = 'mongodb_hubeapp';
    protected $collection = 'eventos_v2';

    public static function getMagazinesFeatures(Carbon $dtEnd)
    {   
        $dtIni = clone $dtEnd;
        $dtIni->subDay(1);
        
        $dateIni = new \MongoDB\BSON\UTCDateTime($dtIni);
        $dateEnd = new \MongoDB\BSON\UTCDateTime($dtEnd);

        return self::raw(function ($collection) use ($dateIni, $dateEnd) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'action' => [
                            '$in' => [
                                'magazine_read',
                                'magazine_download'
                            ]
                        ],
                        'datetime' => [
                            '$gte' => $dateIni, 
                            '$lt' => $dateEnd
                        ]
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

    public function getActiveUsers(Carbon $inDate, Carbon $enDate)
    {
        $initialDate = new \MongoDB\BSON\UTCDateTime($inDate);
        $ed = clone $enDate;
        $ed->addDays(1);
        $endDate = new \MongoDB\BSON\UTCDateTime($ed);

        $results = self::raw(function ($collection) use ($initialDate, $endDate) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'datetime' => [
                            '$gte' => $initialDate,
                            '$lt' => $endDate
                        ],
                        'action' => 'access',
                    ],
                ],
                [
                    '$group' => [
                        '_id' => [
                            'userid' => '$user.id',
                            'plan' => '$plan.name'
                        ]
                    ],
                ],
                [
                    '$group' => [
                        '_id' => ['plan' => '$_id.plan'],
                        'count' => ['$sum' => 1]
                    ],
                ],
            ]);
        });

        return $results;

    }
}
