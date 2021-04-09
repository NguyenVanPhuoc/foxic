<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class CategoryPayment extends Model
{
    

    protected $table = 'category_payment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'title', 'image','description'
    ];
    public function payments()
    {
        return $this->hasMany('App\Payment', 'pay_id', 'id');
    }

}
