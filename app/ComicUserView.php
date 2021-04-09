<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComicUserView extends Model
{
	protected $table = 'comic_user_view';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'current_date', 'user_id','comic_id'
    ];
}
