<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Payment extends Model
{
    

    protected $table = 'payment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'title', 'pay_id', 'amount', 'package'
    ];
    public function catPayment()
    {
        return $this->belongsTo('App\CategoryPayment', 'pay_id', 'id');
    }

}
