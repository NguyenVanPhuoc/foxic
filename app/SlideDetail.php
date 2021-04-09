<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SlideDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'image', 'image_second', 'slide_id', 'position'
    ];
}
