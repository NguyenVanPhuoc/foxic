<?php 
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserMetas extends Model {
	protected $fillable = [
        'meta_key', 'value', 'user_id',
    ];

    /**
     * Get the user of meta
     */
    public function user() {
        return $this->belongsTo('App\UserMetas', 'user_id', 'id');
    }
}
