<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewComic extends Model
{
	protected $table = 'view_comics';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'current_date', 'view_date', 'view_month', 'view_all', 'comic_id'
    ];
}
