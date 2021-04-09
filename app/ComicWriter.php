<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComicWriter extends Model
{
   	protected $table = 'comic_writers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'comic_id', 'writer_id'
    ];
}
