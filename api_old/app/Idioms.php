<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Idioms extends Model
{
    //
    protected $table = 'idioms';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'title', 'translation', 'explain', 'example'
    ];
    protected $hidden = ['created_at', 'updated_at'];
}
