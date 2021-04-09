<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserComic extends Model
{
	protected $table = 'user_comics';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'comic_id', 'chap_id', 'user_id'
    ];
}
