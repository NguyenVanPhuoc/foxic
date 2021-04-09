<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComicArtist extends Model
{
   	protected $table = 'comic_artists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'comic_id', 'artist_id'
    ];
}
