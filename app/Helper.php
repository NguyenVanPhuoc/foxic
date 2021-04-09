<?php
use App\User;
use App\UserMetas;
use App\Options;
use App\Pages;
use App\Media;
use App\Prices;
use App\Seo;
use App\Menu;
use App\MenuMetas;
use App\MediaCat;
use App\MediaComic;
use App\CatMeta;
use Carbon\Carbon;
use App\Request;
use App\Metas;
use App\Category;
use App\Slide;
include('helpers/User.php');
include('helpers/CategoryComic.php');
include('helpers/TypeComic.php');
include('helpers/Comic.php');
include('helpers/Chap.php');
include('helpers/articles.php');
include('helpers/Payment.php');
include('helpers/Notice.php');

if (! function_exists('getPage')) {
	function getPage($slug){
		return url('/p').'/'.$slug;
	}
}
if(! function_exists('get_slide')) {
    function get_slide($id) {
        return Slide::select('title','content')->where('id',$id)->first();
    }
}
if (! function_exists('postType')) {
	function postType($slug){
		$postTypes = array("article","articleCat","page");
		foreach ($postTypes as $item) {
			if($item=="article"){
				$result = Article::findBySlug($slug);
				if($result){
					return $item;
					break;
				}
			}
			if($item=="articleCat"){
				$result = ArticleCat::findBySlug($slug);
				if($result){
					return $item;
					break;
				}
			}
			if($item=="page"){
				$result = Pages::findBySlug($slug);
				if($result){
					return $item;
					break;
				}
			}
		}
		return;
	}
}
/**
 * option
 */
if (! function_exists('getLogo')) {
	function getLogo(){
		$option = Options::select('logo')->first();
		if($option->logo){
			$image = Media::find($option->logo);
			if($image)
				return imageAuto($image->id,'logo'); 
		}
		return;
	}
}
if (! function_exists('getLogoLight')) {
	function getLogoLight(){
		$option = Options::select('logo_light')->first();
		if($option->logo_light){
			$image = Media::find($option->logo_light);
			if($image)
				return imageAuto($image->id,'logo_light'); 
		}
		return;
	}
}
if (! function_exists('getLogoChap')) {
	function getLogoChap(){
		$option = Options::select('logo_viewer_chap')->first();
		if($option->logo_viewer_chap){
			$image = Media::find($option->logo_viewer_chap);
			if($image)
				return imageAuto($image->id,'logo_viewer_chap'); 
		}
		return;
	}
}
if (! function_exists('favicon')) {
	function favicon(){
		$option = Options::select('favicon')->first();
		if($option->favicon){
			$image = Media::find($option->favicon);
			if($image)
				return url('/public/uploads').'/'.$image->image_path;
		}
		return;
	}
}
if (! function_exists('mailSystem')) {
    function mailSystem(){
        $option = Options::select('email')->first();
        if($option->email){
			return $option->email;
		}
		return;
    }
}
if (! function_exists('copyright')) {
	function copyright(){
		$option = Options::select('copyright')->first();
        if($option->copyright) return $option->copyright;
		return;
	}
}
if (! function_exists('tokenApi')) {
	function tokenApi(){
		$option = Options::select('token_api')->first();
        if($option->token_api) return $option->token_api;
		return;
	}
}
if (! function_exists('address')) {
	function address(){
		$option = Options::select('address')->first();
        if($option->address) return $option->address;
		return;
	}
}
if (! function_exists('phone')) {
	function phone(){
		$option = Options::select('phone')->first();
        if($option->phone) return $option->phone;
		return;
	}
}
if (! function_exists('nameCompany')) {
	function nameCompany(){
		$option = Options::select('title')->first();
        if($option->title) return $option->title;
		return;
	}
}
if (! function_exists('latMap')){
	function latMap() {
		$option = Options::select('lag')->first();
        if($option->lag) return $option->lag;
		return;
	}
}
if (! function_exists('logMap')){
	function logMap() {
		$option = Options::select('log')->first();
        if($option->log) return $option->log;
		return;
	}
}
if (! function_exists('listTag')) {
	function listTag(){
		$option = Options::select('tag_list')->first();
        if($option->tag_list) return $option->tag_list;
		return;
	}
}
if (! function_exists('address')) {
	function address(){
		$option = Options::select('address')->first();
        if($option->address) return $option->address;
		return;
	}
}
if (! function_exists('facebook')) {
	function facebook(){
		$option = Options::select('facebook')->first();
        if($option->facebook) return $option->facebook;
		return;
	}
}
if (! function_exists('social')) {
	function social(){
		$option = Options::select('facebook','youtube','google','twitter','instagram')->first();
		$html = '<ul class="social-list list-unstyled">';
		if($option->facebook!="" || $option->facebook!=null)
			$html .= '<li><a href="'.$option->facebook.'" target="_blank"><i class="fab fa-facebook-f"></i></a></li>';
		if($option->google!="" || $option->google!=null)
			$html .= '<li><a href="'.$option->google.'" target="_blank"><i class="fab fa-google-plus-g"></i></a></li>';
		if($option->youtube!="" || $option->youtube!=null)
			$html .= '<li><a href="'.$option->youtube.'" target="_blank"><i class="fab fa-youtube"></i></a></li>';
		if($option->twitter!="" || $option->twitter!=null)
			$html .= '<li><a href="'.$option->twitter.'" target="_blank"><i class="fab fa-twitter"></i></a></li>';
		if($option->instagram!="" || $option->instagram!=null)
			$html .= '<li><a href="'.$option->instagram.'" target="_blank"><i class="fab fa-instagram"></i></a></li>';
		$html .= '</ul>';
		return $html;
	}
}
if (! function_exists('socicalCs')) {
	function socicalCs() {
		$option = Options::select('facebook','instagram')->first();
		$html = '<ul class="social-list list-unstyled flex item-center content-end">';
			if($option->facebook!="" || $option->facebook!=null)
				$html .= '<li><a href="'.$option->facebook.'" target="_blank" class="flex item-center"><i class="fab fa-facebook-f"></i><span>Toomics<br>Facebook</span></a></li>';
			if($option->instagram!="" || $option->instagram!=null)
				$html .= '<li><a href="'.$option->instagram.'" target="_blank" class="flex item-center"><i class="fab fa-instagram"></i><span>Toomics<br>Instagram</span></a></li>';
		$html .= '</ul>';
		return $html;
	}
}
/**
 * Socail share
 */
if (! function_exists('socialShare')) {
	function socialShare($url, $title){	
		$shares = Share::load($url, $title)->services('facebook', 'gplus', 'twitter');
		$html = '';
		foreach($shares as $key => $value):
			switch ($key) {
				case 'facebook':
					$icon = '<i class="fab fa-facebook-f"></i>';
					break;
				case 'gplus':
					$icon = '<i class="fab fa-google-plus-g"></i>';
					break;	
				default:
					$icon = '<i class="fab fa-twitter"></i>';
					break;
			}
			$html .= '<li><a href="'.$value.'" class="'.$key.'" target="_blank">'.$icon.'</a></li>';
		endforeach;		
		return $html;
	}
}
/**
 * media
 */
if (! function_exists('getMedia')) {
	function getMedia($id){
		$result =  Media::find($id);
		if($result)
			return $result;
		return;
	}
}
if (! function_exists('media')) {
	function media(){
		$user = Auth::User();
		$media = Media::where('user_id',$user->id)->latest()->get();
		$html = "";
		if(count($media)>0):
			$html .="<ul class='list-media'>";
			foreach ($media as $item) {
				$path = url('/').'/image/'.$item->image_path.'/150/100';
				$html .= '<li id="image-'.$item->id.'"><div class="wrap"><img src="'.$path.'" alt="'.$item->image_path.'" data-date="'.$item->updated_at.'" data-image="'.url('public/uploads').'/'.$item->image_path.'" /></div></li>';
			}
			$html .= "</ul>";
		endif;
		return $html;
	}
}
if (! function_exists('getMediaCats')) {
	function getMediaCats(){
		return MediaCat::orderBy('position', 'asc')->get();
	}
}
if (! function_exists('getMediaCat')) {
	function getMediaCat($id){
		return MediaCat::find($id);
	}
}
/**
 * custom image
 * @var string url, width, height, alt
 * @return string url
 */
if (! function_exists('image')) {
	function image($id='', $w, $h, $alt){
		$image = Media::find($id);
		if(!empty($image))
			$html = '<img src="'.url('').'/image/'.$image->image_path.'/'.$w.'/'.$h.'" alt="'.$alt.'"/>';
		else
			$html = '<img src="/image/noimage.png/'.$w.'/'.$h.'" alt="'.$alt.'"/>';
		return $html;
	}
}
//image auto
if (! function_exists('imageAuto')) {
	function imageAuto($id, $alt){
		$image = Media::find($id);
		if(!empty($image))
			$html = '<img src="/public/uploads/'.$image->image_path.'" alt="'.$alt.'">';
		else
			$html = '<img src="/public/uploads/noimage.png" alt="'.$alt.'"/>';
		return $html;
	}
}
//image auto
if (! function_exists('getImgUrl')) {
	function getImgUrl($id){
		$image = Media::find($id);
		if(!empty($image))
			$imgUrl = url('/public/uploads').'/'.$image->image_path;
		else
			$imgUrl = url('/public/uploads/noimage.png');
		return $imgUrl;
	}
}
if (! function_exists('getImgUrlConfig')) {
	function getImgUrlConfig($id,$w,$h){
		$image = Media::find($id);
		if(!empty($image))
			$imgUrl = url('/image').'/'.$image->image_path.'/'.$w.'/'.$h;
		else
			$imgUrl = url('/image') . '/noimage.png'.'/'.$w.'/'.$h;
		return $imgUrl;
	}
}
//image auto
if (! function_exists('imageAuto')) {
	function imageAuto($id, $alt){
		$image = Media::find($id);
		if(!empty($image))
			$html = '<img src="'.url('/public/uploads').'/'.$image->image_path.'" alt="'.$alt.'">';
		else
			$html .= '<img src="'.url('/public/uploads/noimage.png').'" alt="'.$alt.'"/>';
		return $html;
	}
}
/**
* create tracking order
*/
if (! function_exists('tracking')) {
	function tracking(){
		return substr(base64_encode(sha1(uniqid())), 0, 4).str_replace('/', '', date('d/m/y'));
		// return substr(base64_encode(sha1(mt_rand())), 0, 10);
	}
}

//number format
if (! function_exists('currency')) {
	function currency($number){
		return number_format($number,'0',',',',').'<small>đ</small>';
	}
}
if (! function_exists('currencyNew')) {
	function currencyNew($number){
		return number_format($number,'0',',','.').'<small>vnđ</small>';
	}
}
if (! function_exists('numberFormat')) {
	function numberFormat($number){         
		return number_format($number,0,",",",");
	}
}
/**
 * order status
 */
if (! function_exists('getStatus')) {
	function getStatus($code){
		switch ($code) {
			case 1:
				return "Chờ duyệt";
				break;
			case 2:
				return "Đã duyệt";
				break;
			case 3:
				return "Lưu nháp";
				break;			
			default:
				return "Hủy";
				break;
		}
	}
}
if (! function_exists('getStatusHtml')) {
	function getStatusHtml($id,$status){
		if($status != ''){
			$value = $status;
			$title = getStatus($status);
			$class = ' class="active"';
		}else{			
			$value = 2;
			$title = getStatus(2);
		}
		$html = '<a href="#" class="dropdown-toggle" id="'.$id.'" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-value="'.$value.'">'.$title.'</a>';
		$html .='<div class="dropdown-menu" aria-labelledby="'.$id.'">';
		$html .='<ul class="list-item dropdown-parent">';
		for($i=1; $i<5; $i++){
			if($i==$value)
				$html .='<li><a href="#" data-value="'.$i.'" class="active">'.getStatus($i).'</a></li>';	
			else
				$html .='<li><a href="#" data-value="'.$i.'">'.getStatus($i).'</a></li>';
		}
		$html .='</ul>';
		$html .='</div>';
		return $html;
	}
}
if (! function_exists('getStatusPro')) {
	function getStatusPro($code){
		switch ($code) {
			case 0:
				return "Hết hàng";
				break;
			case 1:
				return "Còn hàng";
				break;
		}
	}
}
if (! function_exists('getStatusProHtml')) {
	function getStatusProHtml($id,$status){ 
		$title = getStatusPro($status);
		$html = '<a href="#" class="dropdown-toggle" id="'.$id.'" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-value="'.$status.'">'.$title.'</a>';
		$html .='<div class="dropdown-menu" aria-labelledby="'.$id.'">';
			$html .='<ul class="list-item dropdown-parent">';
			for($i=0; $i<=1; $i++){
				if($i == $status)
					$html .='<li><a href="#" data-value="'.$i.'" class="active">'.getStatusPro($i).'</a></li>';	
				else
					$html .='<li><a href="#" data-value="'.$i.'">'.getStatusPro($i).'</a></li>';
			}
			$html .='</ul>';
		$html .='</div>';
		return $html;
	}
}
//get user by ID
if (! function_exists('getUser')) {
	function getUser($id){
		$result = User::find($id);
		if($result)
			return $result;
		return;        
	}
}
/*if (! function_exists('getUserMeta')) {
	function getUserMeta($id){
		$result = UserMetas::where('user_id',$id)->first();
		if($result)
			return $result;
		return;
	}
}*/
if (! function_exists('getUserMeta')) {
	function getUserMeta($id, $meta_key){
		$result = UserMetas::where(['user_id' => $id, 'meta_key' => $meta_key])->first();
		if($result)
			return $result;
		else return false;
	}
}
if (! function_exists('getRoleHtml')) {
	function getRoleHtml($level=null){		
		$roles = array('admin' =>'Ban quản trị', 'editor'=>'Biên tập viên', 'member'=>'Thành viên');
		$html ='<select name="role">';
		$html .='<option value="">--Chọn--</option>';
		foreach ($roles as $key => $value) {
			if($key == $level)
				$checked = ' selected';
			else
				$checked = '';
			$html .='<option value="'.$key.'"'.$checked.'>'.$value.'</option>';	
		}
		$html .='</select>';
		return $html;
	}
}
if (! function_exists('getRoleName')) {
	function getRoleName($role){		
		$roles = array('admin' =>'Ban quản trị', 'editor'=>'Biên tập viên', 'member'=>'Thành viên');
		foreach($roles as $key => $value){
			if($key==$role){
				return $value;
			}
		}
		return;
	}
}
if (! function_exists('getAmount')) {
	function getAmount($user_id){
		$amount = UserMetas::where('user_id',$user_id)->pluck('amount')->first();
		if($amount)
			return $amount;
		else
			return 0;
	}
}
if (! function_exists('updateAmount')) {
	function updateAmount($user_id, $amount){
		if(Auth::check()):
			$userMeta = UserMetas::where('user_id',$user_id)->first();
			if(!$userMeta){
				$userMeta = new UserMetas;
			}			
			$userMeta->amount = $amount;
			$userMeta->user_id = $user_id;
			return $userMeta->save();
		endif;
		return;
	}
}
//get page by id
if (! function_exists('getPageMetas')) {
	function getPageMetas($id){
		return Pages::find($id);
	}
}

//date convert
if (! function_exists('dateConvert')) {
	function dateConvert($date){
		return date('Y-m-d',strtotime($date));
	}
}
//date convert
if (! function_exists('customDateConvert')) {
	function customDateConvert($date){
		return date('d-m-Y',strtotime($date));
	}
}
//date show
if (! function_exists('dateShow')) {
	function dateShow($date){
		return date('d/m/Y H:i:s',strtotime($date));
	}
}
// date chap
if(! function_exists('dateChap')){
	function dateChap($date){
		return date('M d, Y',strtotime($date));
	}
}
//date show
if (! function_exists('dateServerOpen')) {
	function dateServerOpen($date){
		return date('d/m H:i',strtotime($date));
	}
}

//number format
if (! function_exists('removeDot')) {
	function removeDot($number){
		return str_replace(".","",$number);
	}
}
//number format (comma)
if (! function_exists('removeComma')) {
	function removeComma($number){
		return str_replace(",","",$number);
	}
}
//routes
if (! function_exists('get_routes')) {
	function get_routes(){        
		return TourCat::orderBy('position', 'asc')->get();
	}
}
if (! function_exists('get_route')) {
	function get_route($id){
		return TourCat::find($id);
	}
}
/**
 * meta cat
 */
if (! function_exists('get_catMetaByCatId')) {
	function get_catMetaByCatId($cat_id){        
		$result = CatMeta::where("cat_id",$cat_id)->select('title','slug','id','icon')->orderBy('position','asc')->get();
		if($result)
			return $result;
		return;
	}
}
//get name ids
if (! function_exists('get_titleByIds')) {
	function get_titleByIds($ids, $type){
		$list_ids = explode(",", $ids);
		$list = array();
		$count = 0;
		switch ($type) {
			case 'route':
			foreach ($list_ids as $id) {
				$type = get_route($id);
				if($type){
					$list[$count] = $type->title;
					$count++;    
				}
			}
			break;
			case 'category':
			foreach ($list_ids as $id) {
				$type = get_category($id);
				if($type){
					$list[$count] = $type->title;
					$count++;    
				}
			}
			break;            
			default:
			$list = array();
			break;
		}         
		return $list;
	}
}
/**
 * SEO
 */
if (! function_exists('get_seo')) {
	function get_seo($post_id, $type){        
		$seo = Seo::where('post_id',$post_id)->where('type',$type)->first();
		if($seo) return $seo;
		return;
	}
}
/**
 * Menu
 */
if (! function_exists('menuType')) {
	function menuType($type=null){        
		$html ='<div class="dropdown show type col-md-5">';
		$html .= '<a class="dropdown-toggle" href="#" role="button" id="dropdown-type" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.getNameType($type).'</a>';            
		$html .= '<div class="dropdown-menu" aria-labelledby="dropdown-type">';
		$html .='<div class="list-item">';
		if($type == "home")
			$html .= '<a href="#home" data-value="trang chủ" class="active">Trang chủ</a>';
		else
			$html .= '<a href="#home" data-value="trang chủ">Trang chủ</a>';
		if($type == "page")
			$html .= '<a href="#page" data-value="trang nội dung" class="active">Trang nội dung</a>';
		else
			$html .= '<a href="#page" data-value="trang nội dung">Trang nội dung</a>';
		if($type == "blog")
			$html .= '<a href="#blog" data-value="blog" class="active">Blog</a>';
		else
			$html .= '<a href="#blog" data-value="blog">Blog</a>';
		if($type == "category")
			$html .= '<a href="#category" data-value="Danh mục" class="active">Danh mục blog</a>';
		else
			$html .= '<a href="#category" data-value="Danh mục">Danh mục blog</a>';
		if($type == "link")
			$html .= '<a href="#link" data-value="link chỉ định" class="active">Link chỉ định</a>';
		else
			$html .= '<a href="#link" data-value="link chỉ định">Link chỉ định</a>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		return $html;
	}
}
//get sub menu
if (! function_exists('getSubMenu')) {
	function getSubMenu($id){
		return MenuMetas::where('parent',0)->where('menu_id',$id)->orderBy('position','asc')->get();
	}
}
if (! function_exists('get_childrenMenu')) {
	function get_childrenMenu($id){
		return MenuMetas::where('parent',$id)->orderBy('position','asc')->get();
	}
}
//get name type
if (! function_exists('getNameType')) {
	function getNameType($type){        
		switch ($type) {
			case 'home':
			$text = "Trang chủ";
			break;
			case 'page':
			$text = "Trang nội dung";
			break;
			case 'product':
			$text = "Sản phẩm";
			break;
			case 'products':
			$text = "Tất cả sản phẩm";
			break;
			case 'collection':
			$text = "Danh mục sản phẩm";
			break;
			case 'blog':
			$text = "Blog";
			break;

			default:
			$text = "Link chỉ định";
			break;
		}
		return $text;
	}
}
if (! function_exists('get_link')) {
	function get_link($id){
		$menuMeta = MenuMetas::find($id);
		switch ($menuMeta->type) {
			case 'home':
				$html = url('/');
				break;
			case 'page':
				$object = Pages::find($menuMeta->value);
				$html = $object->slug;
				break;
			case 'blog':
				$object = Article::find($menuMeta->value);
				$html = $object->slug;
				break;
			case 'category':
				$object = ArticleCat::find($menuMeta->value);
				$html = $object->slug;
				break;
			case 'link':
			$html = url($menuMeta->value);
			break;
			default:
				$html = "#";
				break;
		}
		return $html;
	}
}
//get menu
if (! function_exists('get_parentMenu')) {
	function get_parentMenu($id){
		return Menu::find($id);
	}
}
//get submenu by id
if (! function_exists('get_menu')) {
	function get_menu($id){
		return MenuMetas::where('menu_id',$id)->where('parent',0)->orderBy('position', 'asc')->get();
	}
}
//limit string
if (! function_exists('str_limit')) {
	function str_limit($str, $number){
		return str_limit($str, $number, '...');
	}
}
/**
 * views
 */
if (! function_exists('set_view')) {
	function set_view($id){
		$blog = Article::find($id);
		$blog->view = $blog->view + 1;
		$blog->save();
		return $blog->view;
	}
}
//remove delimiter
if (! function_exists('removeDelimiter')) {
	function removeDelimiter($str){
		$search  = array('.',',');
    	$replace = array('','');
		return str_replace($search, $replace, $str);
	}
}
/**
 * like
 */
if (! function_exists('checkLike')) {
	function checkLike($comic_id, $user_id){
		return Like::where('comic_id',$comic_id)->where('user_id',$user_id)->count();
	}
}
//remove
if (! function_exists('removeLike')) {
	function removeLike($id, $user_id){
		$like = Like::where('id',$id)->where('user_id',$user_id)->first();
		if($like){
			return $like->delete();
		}
		return;
	}
}
//get menu left
if(!function_exists('getMenuLeft')){
	function getMenuLeft(){
		$menu = getSubMenu(21);
		return $menu;
	}
}
//get menu right
if(!function_exists('getMenuRight')){
	function getMenuRight(){
		$menu = getSubMenu(29);
		return $menu;
	}
}

// get banner buy package VIP
if( ! function_exists('getBannerBuyPackageVip')){
	function getBannerBuyPackageVip(){
		return Metas::find(12)->content;
	}
}

// convert time elapsed
if( ! function_exists('timeElapsedString')){
	function timeElapsedString($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'năm',
			'm' => 'tháng',
			'w' => 'tuần',
			'd' => 'ngày',
			'h' => 'giờ',
			'i' => 'phút',
			's' => 'giây',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v;
			} else {
				unset($string[$k]);
			}
		}
		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' trước' : 'vừa nãy';
	}
}
/**
* get list category article
* @param false
* @return list category
*/
if (!function_exists('getListCatArticle')) {
    function getListCatArticle() {
        return Category::select('title','slug')->orderBy('title','asc')->get();
    }
}