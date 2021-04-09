<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use App\Sticker;

class Comment extends Model {

    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'comic_id', 'content', 'type', 'parent_id',  'status'
    ];

    public static function stripXSS() {
        $sanitized = static::cleanArray(Input::get());
        Input::merge($sanitized);
    }
    public static function cleanArray($array) {
        $result = array();
        foreach ($array as $key => $value) {
            $key = strip_tags($key);
            if (is_array($value)) {
                $result[$key] = static::cleanArray($value);
            } else {
                $result[$key] = trim(strip_tags($value));
            }
       }
       return $result;
    }

    public function comic() {
        return $this->belongsTo('App\Comic', 'comic_id', 'id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function children() {
        return $this->hasMany('App\Comment', 'parent_id', 'id');
    }

    public function parent() {
        return $this->hasOne('App\Comment', 'id', 'parent_id');
    }

    public function isSticker() {
        return $this->type == 'sticker';
    }

    public function showStickerComment($w=60, $h=60) {
        $sticker = Sticker::find($this->content);
        if($sticker/* && Auth::user()->hasSticker($sticker->id)*/) return $sticker->show_sticker($w,$h);
            else return 'Sticker has removed!';
    }

    public function showComment() {
        return strip_tags($this->content);
    }

    /**
     * Scope a query to published
     *
     */
    public function scopePublished($query) {
        return $query->where('status', 'published');
    }

    public function scopeSticker($query) {
        return $query->where('type', 'sticker');
    }

}
