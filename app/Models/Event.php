<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $timestamps = true;
    protected $dateFormat = 'U';

    public function host()
    {
        return $this->belongsTo('App\Models\Account');
    }

    public function participants()
    {
        return $this->belongsToMany('App\Models\Account');
    }
}
