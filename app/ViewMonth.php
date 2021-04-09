<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class ViewMonth extends Model
{
    

    protected $table = 'view_months';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'current_month', 'view_month', 'comic_id'
    ];
    
    public function comic()
    {
        return $this->belongsTo('App\Comic', 'comic_id', 'id');
    }
}
