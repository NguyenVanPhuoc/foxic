<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model {

    protected $table = 'social_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'provider', 'provider_id'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
