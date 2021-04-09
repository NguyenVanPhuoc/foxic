<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComicCat extends Model
{
    protected $table = 'comic_cats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'comic_id', 'cat_id'
    ];
}
