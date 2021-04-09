<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Options extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logo','logo_light','logo_viewer_chap','favicon','title','slogan','phone','email','address','copyright','facebook','google','youtube','twitter','instagram', 'onepay_out_merchantID', 'onepay_out_secureSecret', 'onepay_out_accessCode', 'paypal_email', 'stripe_publishable_key', 'stripe_secret_key', 'token_api',
        'mobiAddress','website','lag','log','tag_list'
    ];
}