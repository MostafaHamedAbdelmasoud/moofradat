<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
 
    protected $table = 'formats';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','noun', 'verb', 'adjective', 'adverb'
    ];
    protected $hidden = ['created_at', 'updated_at'];
    
}
