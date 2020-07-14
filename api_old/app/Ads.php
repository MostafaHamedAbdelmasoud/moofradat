<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    //
    protected $table = 'ads';

    public function type()
    {
        return $this->belongsTo('App\Ads_type');
    }
}
