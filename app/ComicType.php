<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComicType extends Model
{
    protected $table = 'comic_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'comic_id', 'type_id'
    ];
}
