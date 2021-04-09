<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;

class Comic extends Model
{
    use Sluggable;
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
                'source' => 'title'
            ]
        ];
    }
    protected $table = 'comics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'title_original', 'slug', 'desc',  'source', /*'end',*/ 'image', 'chap_up', 'user_id', 'rating', 'votes', 'mature','au_status', 'status'
    ];

    public static function getMessageRule(){
        return [
            'title.required' => 'Vui lòng nhập tên truyện!',
            'title.unique' => 'Trên truyện đã tổn tại!',
            'desc.required' => 'Vui lòng nhập mô tả truyên!',
            'type.required' => 'Vui lòng chọn thể loại truyện!',
            'writer.required' => 'Vui lòng chọn tên tác giả!',
        ];
    }

    public static function stripXSS() {
        $sanitized = static::cleanArray(Input::get());
        Input::merge($sanitized);
    }
    public static function cleanArray($array) {
        $result = array();
        foreach ($array as $key => $value) {
            if($key == 'desc') $result[$key] = $value;
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

    public function books()
    {
        return $this->hasMany('App\Book', 'comic_id', 'id');
    }
    public function chaps() {
        return $this->hasManyThrough('App\Chap','App\Book', 'comic_id', 'book_id', 'id');
    }
    /**
     * Scope a query to status.
     *
     */
    public function scopeStatus($query) {
        return $query->where('status', 'public');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function actions()
    {
        return $this->hasMany('App\Action', 'comic_id', 'id');
    }
    public function views()
    {
        return $this->hasMany('App\ViewMonth', 'comic_id', 'id');
    }

    public function comments() {
        return $this->hasMany('App\Comment', 'comic_id', 'id');
    }

    public function showTitle($length=null) {
        if($length != null) return str_limit(strip_tags($this->title),$length, '...');
            else return strip_tags($this->title);    
    }
}
