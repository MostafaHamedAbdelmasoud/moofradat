<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slang extends Model
{
    protected $table = 'slang';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'sentence', 'translation'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
