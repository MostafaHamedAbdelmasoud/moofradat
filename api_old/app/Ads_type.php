<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ads_type extends Model
{
    //
    protected $table = 'ads_types';

    public function ads()
    {
        return $this->hasMany('App\Ads');
    }
}
