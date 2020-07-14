<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shortcut extends Model
{
    protected $table = 'shortcuts';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'shortcut', 'mean', 'translation'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
