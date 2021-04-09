<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;


class CategoryComic extends Model
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

    protected $table = 'category_comics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'title', 'slug', 'desc', 'icon', 'image'
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

    public function showTitle($length=null) {
        if($length != null) return str_limit(strip_tags($this->title),$length, '...');
            else return strip_tags($this->title);    
    }

}
