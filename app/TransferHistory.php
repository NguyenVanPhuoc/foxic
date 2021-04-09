<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TransferHistory extends Model
{
    protected $table = 'transfer_history';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'user_id', 'point', 'month'
    ];
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
