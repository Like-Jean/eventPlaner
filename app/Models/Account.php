<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $timestamps = false;
    protected $dateFormat = 'U';

    //The events that hosted by the user
    public function hostEvent()
    {
        return $this->hasMany('App\Models\Event');
    }

    //The events that the user has participated
    public function participatedEvent()
    {
        return $this->belongsToMany('App\Models\Event');
    }
}
