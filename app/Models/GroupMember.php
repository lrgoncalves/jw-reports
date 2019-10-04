<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    protected $fillable = [
        'group_id',
        'householder_id',
        'name',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function householder()
    {
        return $this->belongsTo(Publisher::class);
    }
}
