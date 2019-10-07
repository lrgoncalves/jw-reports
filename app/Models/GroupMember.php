<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    protected $fillable = [
        'group_id',
        'publisher_id',
        'name',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
}
