<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medical extends Model
{
    protected $table = 'medical';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'title', 'translation', 'example'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
