<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Like extends Model
{
    protected $fillable = [
        'id', 'comic_id', 'user_id'
    ];
}
