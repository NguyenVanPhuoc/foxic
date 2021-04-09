<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Media extends Model
{
	protected $fillable = [
        'image_path','title','type','cat_ids','user_id', 
    ];
}
