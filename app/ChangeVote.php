<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ChangeVote extends Model
{


    protected $table = 'change_votes';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'title', 'vote', 'amount', 'choose_point'
    ];
}
