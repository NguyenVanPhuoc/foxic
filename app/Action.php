<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Action extends Model
{
    

    protected $table = 'actions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'user_id', 'chap_id', 'comic_id', 'point', 'rental_period', 'type'
    ];
    public function comic()
    {
        return $this->belongsTo('App\Comic', 'comic_id', 'id');
    }
}
