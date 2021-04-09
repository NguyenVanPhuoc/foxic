<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaComic extends Model
{	
	protected $table = 'media_comics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'media_id','image_of'
    ];
}
