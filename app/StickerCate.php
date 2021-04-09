<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class StickerCate extends Model {

    use Sluggable;
    use SluggableScopeHelpers;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable() {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $table = 'sticker_cates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'amount'
    ];

    public function stickers() {
        return $this->hasMany('App\Sticker', 'cate_id', 'id');
    }

    public function users() {
        return $this->belongsToMany('App\User', 'sticker_cate_user', 'cate_id', 'user_id');
    }

    public function userCanUse($user_id) {
        if($this->amount <= 0) return TRUE;
        else {
           $cate = $this->users()->where('user_id', $user_id)->get();
            if(count($cate) > 0) return TRUE;
                else return FALSE; 
        }  
    }

    /**
     * Scope a query
     *
     */
    public function scopeHasStickers($query) {
        return $query->has('stickers');
    }
}
