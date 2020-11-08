<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'birthdate',
        'baptize_date',
        'phone_numbers',
        'anointed',
        'privilege',
        'pioneer_code',
        'householder_id',
        'group_id',
    ];

    protected $dates = [
        'birthdate',
        'baptize_date',
    ];

    public function householder()
    {
        return $this->belongsTo('App\Models\Publisher', 'id', 'householder_id');
        // return $this->belongsTo(Publisher::class);
    }

    public function address()
    {
        return $this->hasMany('App\Models\PublisherAddress');
    }

    public function serviceType()
    {
        return $this->hasMany('App\Models\PublisherServiceType');
    }

    public function members()
    {
        return $this->hasMany('App\Models\Publisher', 'householder_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    }

    public function fieldService()
    {
        return $this->hasMany('App\Models\FieldService');
    }

    public function unhealthy()
    {
        return $this->hasMany('App\Models\PublisherUnhealthy');
    }
}
