<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

class Chap extends Model
{
    //use Sluggable;
    use SluggableScopeHelpers;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    { 
        return [
            'slug' => [
                'source' => 'slug'
            ]
        ];
    }
    protected $table = 'chaps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'chap', 'short_chap', 'title', 'slug', 'content', 'position', 'book_id', 'rental', 'point','status'
    ];

    public static function getMessageRule(){
        return [
            'chap.required' => 'Vui lòng nhập chương!',
            //'chap.unique' => 'Chương đã tổn tại!',
            'short_chap.required' => 'Vui lòng nhập chương rút gọn!',
            //'short_chap.unique' => 'Chương rút gọn đã tồn tại!',
            'title.required' => 'Vui lòng nhập tên chương!',
            'content.required' => 'Vui lòng nhập nội dung chương!',
        ];
    }

    public function book()
    {
        return $this->belongsTo('App\Book', 'book_id', 'id');
    }
     public function scopeStatus($query) {
        return $query->where('status', 'public');
    }

    public static function stripXSS() {
        $sanitized = static::cleanArray(Input::get());
        Input::merge($sanitized);
    }
    public static function cleanArray($array) {
        $result = array();
        foreach ($array as $key => $value) {
            if($key == 'content') $result[$key] = $value;
            else{
                $key = strip_tags($key);
                if (is_array($value)) {
                    $result[$key] = static::cleanArray($value);
                } else {
                    $result[$key] = trim(strip_tags($value));
                }            
            }
       }
       return $result;
    }

    public function showTitle($length=null) {
        if($length != null) return str_limit(strip_tags($this->title),$length, '...');
            else return strip_tags($this->title);    
    }

}
