<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $table = 'words';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'title', 'translation', 'definition', 'examples'
    ];

    protected $hidden = ['created_at', 'updated_at'];
    protected $appends = ['word'];


    public function getWordAttribute()
    {
        return $this->title;
    }
}
