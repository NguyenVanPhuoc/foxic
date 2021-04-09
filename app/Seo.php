<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class Seo extends Model
{
	protected $table = 'seos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'key', 'value', 'post_id', 'type'
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

    public static function addNew($meta_key, $meta_value, $post_id, $type){
    	$data = [];
    	$data['key'] = $meta_key;
    	$data['value'] = $meta_value;
    	$data['post_id'] = $post_id;
    	$data['type'] = $type;
        Seo::stripXSS();
    	$seo = Seo::create($data);
    	return $seo;
    }

    public static function updateSeo($meta_key, $meta_value, $post_id, $type){
    	$data = [];
    	$data['key'] = $meta_key;
    	$data['value'] = $meta_value;
    	$data['post_id'] = $post_id;
    	$data['type'] = $type;
        Seo::stripXSS();
    	$seo = Seo::where('type', $type)->where('post_id', $post_id)->first();
    	if(!$seo)
    		$seo = Seo::create($data);
    	$seo->update($data);
    	return $seo;
    }

}
