<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;
use App\Comic;

class User extends Authenticatable
{
    use Notifiable;
    use Sluggable;
    use SluggableScopeHelpers;
    use HasRoles;

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','slug', 'phone', 'email', 'birthday', 'sex', 'address','introduce','password', 'level', 'level_id','remember_token', 'rental', 'coin', 'point', 'type_author', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
    /**
     * Get the metas of user
     */
    public function metas(){
        return $this->hasMany('App\UserMetas', 'user_id', 'id');
    }
    public function comics()
    {
        return $this->hasMany('App\Comic', 'user_id', 'id');
    }
    public function actions()
    {
        return $this->hasManyThrough('App\Action', 'App\Comic', 'user_id', 'comic_id', 'id');
    }
    public function views()
    {
        return $this->hasManyThrough('App\ViewMonth', 'App\Comic', 'user_id', 'comic_id', 'id');
    }
    public function transfers()
    {
        return $this->hasMany('App\TransferHistory', 'user_id', 'id');
    }

    public function socials() {
        return $this->hasOne('App\SocialAccount', 'user_id', 'id');
    }

    public function sticker_cates() {
        return $this->belongsToMany('App\StickerCate', 'sticker_cate_user', 'user_id', 'cate_id');
    }

    public function hasSticker($sticker_id) {
        $res = $this->sticker_cates()->whereHas('stickers', function($query) use ($sticker_id) {
            return $query->where('stickers.id', $sticker_id);
        })->orWhere('sticker_cates.amount', '<=', 0)->get();
        if(count($res) > 0) return TRUE;
            else return FALSE;
    }

    /**
     * Update User point
     * @param $point
     */
    public function updatePoint($point) {
        $this->point += $point;
        $this->save();
    }

    public function get_avatar($w=45, $h=45) {
        return image($this->image, $w, $h, $this->show_name());
    }
    
    public function show_name($length=null) {
        if($length != null) return str_limit(strip_tags($this->name),$length, '...');
            else return strip_tags($this->name);
    }
}
