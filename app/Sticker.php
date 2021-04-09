<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sticker extends Model {

    protected $table = 'stickers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'image_path', 'cate_id'
    ];

    public function cate() {
        return $this->belongsTo('App\StickerCate', 'cate_id', 'id');
    }

    public function show_sticker($w=35, $h=35) {
        if(explode('.',$this->image_path)[1] != 'gif')
            return '<img src="/image/'.$this->image_path.'/'.$w.'/'.$h.'" alt="'.$this->title.'"/>';
        else 
            return '<img src="/public/uploads/'.$this->image_path.'" alt="'.$this->title.'" style="max-width: '.$w.'px; max-height: '.$h.'px">';
    }

}
