<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discharges extends Model
{
    protected $table = 'discharges';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','past', 'present', 'future'
    ];
    protected $hidden = ['created_at', 'updated_at'];
}
