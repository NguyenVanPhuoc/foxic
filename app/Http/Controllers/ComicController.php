<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Seo;
use App\Comic;
use App\CategoryComic;
use App\TypeComic;
use App\Writer;
use App\ComicCat;
use App\ComicType;
use App\ComicWriter;
use App\MediaComic;
use App\Media;
use App\Chap;
use App\Book;
use App\User;
use App\UserComic;
use App\ViewComic;
use App\ViewMonth;
use App\ComicUserView;
use App\Metas;
use App\UserMetas;
use App\Action;
use App\StickerCate;
use Carbon\Carbon;
use Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use DB;
use Mail;

class ComicController extends Controller {
    public function test(Request $request){
        $data = array( 'email' => 'vanphuoc260797@gmail.com', 'from' => 'phamnhu260797@gmail.com');
            Mail::send( 'mails.publish-comic', compact('data'), function( $message ) use ($data){
                $message->to($data['email'])
                        ->subject('[Contact to BiigHoliday]');
            });
    }
    // List for Cat & Type (all and FULL)
    public function comicCat($slug){  
        
        $data = [];  
        $current_cat = CategoryComic::findBySlugOrFail($slug);
        $comics = getListComicInCat($current_cat->id);
        $catHotId = Metas::select('content')->where('id',20)->first();
        if ($catHotId->content == $current_cat->id) {
            $data ['full'] = 'catFull';
        }else{
            $data ['full'] = 'not';
        }
        $data ['comic'] = $current_cat;
        $data ['comics'] = $comics;        
        $data ['typeComic'] = 'comicCat';
        $seo = get_seo($current_cat->id, 'category_comic');
        $data['seo'] = $seo;
        return view('comics.list', $data);
    }

    // List for new chap
    public function comicNewChap(){  
        $data = [];  
        $comics = Comic::status()->select('comics.id as id', 'comics.title as title','comics.image as image', 'comics.slug as slug','comics.end as end', 'comics.chap_up as chap_up')
                        ->orderBy('comics.chap_up','desc')  
                        ->limit(6)->paginate(10);
        $data ['comics'] = $comics;        
        return view('comics.list_new', $data);
    }

    public function comicCatFull($slug){  
        $data = [];         
        $current_cat = CategoryComic::findBySlugOrFail($slug);
        $catHotId = Metas::select('content')->where('id',20)->first();
        $comics = Comic::join('comic_cats','comics.id','=','comic_cats.comic_id')
                    ->where('comic_cats.cat_id', $current_cat->id)
                    ->whereIn('comic_cats.comic_id', function($query) use ($catHotId){
                        $query->select('comic_cats.comic_id')
                            ->from('comic_cats')
                            ->where('comic_cats.cat_id', $catHotId->content);
                    })
                    ->distinct()->select('comics.id as id', 'comics.title as title', 'comics.image as image', 'comics.slug as slug', 'comics.chap_up as chap_up')
                    ->orderBy('chap_up','desc')->paginate(16);                  
        $data ['comic'] = $current_cat;
        $data ['comics'] = $comics;
        $data ['full'] = 'full';
        $data ['typeComic'] = 'comicCat';
        $seo = get_seo($current_cat->id, 'category_comic');
        $data['seo'] = $seo;
        return view('comics.list', $data);
    }

    public function comicType($slug){  
        $data = [];  
        $type = TypeComic::findBySlugOrFail($slug);
        $comics = getListComicInType($type->id);
        $data ['comic'] = $type;
        $data ['comics'] = $comics;
        $data ['full'] = 'not';
        $data ['typeComic'] = 'comicType';
        $seo = get_seo($type->id, 'type_comic');
        $data['seo'] = $seo;
        return view('comics.list', $data);
    }

    public function comicTypeFull($slug){  
        $data = [];  
        $type = TypeComic::findBySlugOrFail($slug);
        $catHotId = Metas::select('content')->where('id',20)->first();
        $comics = Comic::join('comic_types','comics.id','=','comic_types.comic_id')
            ->join('comic_cats','comics.id','=','comic_cats.comic_id')
            ->where('comic_types.type_id',$type->id)->where('comic_cats.cat_id',$catHotId->content)
            ->distinct()->select('comics.id as id', 'comics.title as title', 'comics.image as image', 'comics.slug as slug', 'comics.chap_up as chap_up')
            ->orderBy('chap_up','desc')->paginate(16);
        $data ['comic'] = $type;
        $data ['comics'] = $comics;
        $data ['full'] = 'not';
        $data ['typeComic'] = 'comicType';
        $seo = get_seo($type->id, 'type_comic');
        $data['seo'] = $seo;
        return view('comics.list', $data);
    }

    // List Comic Writer
    public function comicWriter($slug){  
        $data = [];  
        $writer = Writer::findBySlugOrFail($slug);
        $comics = Comic::join('comic_writers','comics.id','=','comic_writers.comic_id')
                    ->where('comic_writers.writer_id', $writer->id)
                    ->distinct()->select('comics.id as id', 'comics.title as title', 'comics.image as image', 'comics.slug as slug', 'comics.chap_up as chap_up')
                    ->orderBy('chap_up','desc')->paginate(16);
        $data ['comic'] = $writer;
        $data ['comics'] = $comics;
        $data ['full'] = 'full';
        $data ['typeComic'] = 'comicWriter';
        $seo = get_seo($writer->id, 'comic_writer');
        $data['seo'] = $seo;
        return view('comics.list', $data);
    }

    // Comic Detail
    public function listChap($slug){
        $data = [];
        $comment_parent = function($query) {
                            $query->where('parent_id', 0)->latest()->limit(5)->published();
                        };
        $comment_query = function($query) {
                            $query->latest()->published();
                        };
        $comic = Comic::with(['comments'=>$comment_parent, 'comments.children'=>$comment_query, 'comments.user:id,name,image', 'comments.children.user:id,name,image'])
                    ->withCount(['comments'=>$comment_query])->where('slug', $slug)->first();
        $total_cmt_par = Comic::select('id')->withCount(['comments'=>function($query) {
                                        $query->where('parent_id', 0)->published();
                                    }])->where('slug', $slug)->first();
        if(!$comic):
            return redirect()->route('404');
        else:
            $book_chap=Comic::with(['books'=>function ($query) {
                                return $query->withCount(['chaps'=>function($query){
                                    return $query->where('chaps.status', 'public');
                                }]);
                            },'books.chaps'=>function ($query) {
                                return $query->select('id','chap','title','status','slug','short_chap','book_id','rental','point', 'created_at')->where('chaps.status', 'public');
                            }])->find($comic->id);
            //dd($book_chap);
            $books = Book::where('comic_id',$comic->id)
                    ->select('id','title')
                    ->orderBy('position','ASC')->paginate(50);
            $sticker_packages_count = StickerCate::with('stickers')->hasStickers()->count();
            $sticker_packages = StickerCate::with('stickers')
                                            ->hasStickers()
                                            ->whereHas('users',function($query) {
                                                return $query->where('user_id', Auth::id());
                                            })->orWhere('amount', '<=', 0)
                                            ->latest()->get();
            // if($comic->id == 102) dd(Auth::user()->hasSticker(3));
            $array_id=array();
            foreach ($books as $value) {
                $array_id[]=$value->id;
            }
            $chaps=Chap::whereIn('book_id',$array_id)->status()
                    ->select('slug','chap','title', 'position')
                    ->orderBy('position','ASC')->paginate(50);
                    //dd($chaps);
            if(isset($_COOKIE['rating_comic']) && $_COOKIE['rating_comic'] != '' ){
                $cookie = $_COOKIE['rating_comic'];
                $cookie = stripslashes($cookie);
                $comicArray = json_decode($cookie, true);            
                $check = false;
                foreach ($comicArray as $value) {
                    if ($value == $comic->id) {
                        $check = true;
                        break;
                    }
                }
                if($check) $readonly = 1;
                    else $readonly = 0;              
            }else{
                $readonly = 0;
            }
            if(Auth::check()){
                $user = Auth::user();
                $current_date = Carbon::now()->format('Y-m-d');
                $user_view = ComicUserView::where('comic_id',$comic->id)->where('user_id',$user->id)->first();
                $check = false;
                if($user_view){ 
                    if($current_date != $user_view->current_date){
                        ComicUserView::where('user_id',$user->id)->where('comic_id',$comic->id)->update(['current_date' => $current_date]);
                        $check=true;
                    }
                }else{
                    ComicUserView::firstOrCreate(['comic_id'=>$comic->id, 'user_id'=>$user->id ,'current_date'=>$current_date]);
                    $check=true; 
                }
                if($check){
                    $month = Carbon::now()->format('Y-m');
                    $views = ViewComic::where('comic_id',$comic->id)->first();
                    if($views != '') {
                        if ($current_date == $views->current_date) {$view_date = $views->view_date + 1;}
                            else {$view_date = 1;}
                        if($month == date('Y-m',strtotime($views->current_date))) {$view_month = $views->view_month + 1;}
                            else {$view_month = 1;}
                        $view_all = $views->view_all + 1;
                        ViewComic::where('comic_id', $views->comic_id)->update(['current_date' => $current_date, 'view_date' => $view_date, 'view_month' => $view_month, 'view_all' => $view_all]);
                        $view_months = ViewMonth::where('comic_id',$comic->id)->latest()->first();
                        if(date_format(date_create($view_months->current_month),'Y-m') != $month){
                            ViewMonth::create(['current_month' => $current_date,'view_month' => 1,'comic_id' => $comic->id]);
                        }else{    
                            ViewMonth::where('comic_id', $views->comic_id)->update(['view_month' => $view_month]);
                        }
                    }else{
                        ViewComic::create(['current_date' => $current_date, 'view_date' => 1, 'view_month' => 1, 'view_all' => 1, 'comic_id' => $comic->id]);
                        ViewMonth::create(['current_month' => $current_date,'view_month' => 1,'comic_id' => $comic->id]);
                    }
                }else{
                    $views = ViewComic::where('comic_id',$comic->id)->first();
                }
            }else{
               $views = false; 
            }
            $sames = getListComicSameWriter($comic->id);
            $data ['comic'] = $comic;
            $data ['sames'] = $sames;
            $data ['book_chap'] = $book_chap;
            $data ['readonly'] = $readonly;
            $data ['views'] = $views;
            $data ['chaps'] = $chaps;
            $data ['total_cmt_par'] = $total_cmt_par->comments_count;
            $data ['sticker_packages_count'] = $sticker_packages_count;
            $data ['sticker_packages'] = $sticker_packages;
            $seo = get_seo($comic->id, 'comic');
            $data['seo'] = $seo;
            return view('comics.listChap', $data);
        endif;
    }
    public function localStorage(Request $request){
        $chap_id = $request->chap_id; 
        $comic_id = $request->comic_id; 
        $html = '';
        $comic = Comic::select('id','slug')->find($comic_id);
        if($chap_id==null){
            $chap = $comic->chaps->where('chaps.status','public')->last();
            $html = '<a href="'.route('detailChap',['slugComic'=>$comic->slug,'slugChap'=>$chap->slug]).'" class="btn-read">'.__('Bắt đầu đọc').' <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>';

        }else{
            $chap = Chap::status()->select('id','book_id','slug', 'chap')->find($chap_id);
            $html = '<a href="'.route('detailChap',['slugComic'=>$comic->slug,'slugChap'=>$chap->slug]).'" class="btn-read">'.__('Đọc tiếp').' '.$chap->chap.'</a>';
        }
        return response()->json(['html' => $html]);
    }
    // Chap detail
    public function detailChap($slugComic,$slugChap){ 
        $data = [];
        $comic = Comic::findBySlugOrFail($slugComic);
        $comic_query = function ($query) use ($slugComic) {
            return $query->where('slug',$slugComic);
        };
        $chap = Chap::with(['book.comic'=>$comic_query])
                    ->whereHas('book.comic', $comic_query)->where('slug',$slugChap)->status()->first(); 
        if($chap){
            // history chaps
            if(Auth::check()) {
                $user = Auth::user();
                $comic_id = $comic->id;
                $chap_id = $chap->id;
                $chap_history = getUserMeta($user->id, 'chap_history');
                if($chap_history) {
                    $data = json_decode($chap_history->value);
                    $abc = 0;
                    if($data) {
                        foreach ($data as $key => $value){
                            $zzz = $value->comic_id;
                            if ($zzz == $comic_id) {
                                $data[$key]->time = Carbon::now()->format('Y-m-d H:i:s');
                                $data[$key]->chap_id = intval($chap_id);
                                $abc = 1;
                                break;
                            }
                        }
                    }
                    if($abc == 0) {
                        $list_chap = array();
                        $list_chap['comic_id'] = intval($comic_id);
                        $list_chap['chap_id'] = intval($chap_id);
                        $list_chap['time'] = Carbon::now()->format('Y-m-d H:i:s');
                        $data[]  =$list_chap;
                    }
                    UserMetas::where('id', $chap_history->id)->update(['value' => json_encode($data, JSON_UNESCAPED_UNICODE)]); 
                }else {
                    $data = array();
                    $list_chap = array();
                    $list_chap['comic_id'] = intval($comic_id);
                    $list_chap['chap_id'] = intval($chap_id);
                    $list_chap['time'] = Carbon::now()->format('Y-m-d H:i:s');
                    $data[] = $list_chap;
                    UserMetas::create([
                        'user_id' => $user->id,
                        'meta_key' => 'chap_history',
                        'value' => json_encode($data, JSON_UNESCAPED_UNICODE),
                    ]);
                }    
            }  
            //end history chaps 
            if(Auth::check()){
                $user = Auth::user();
                $buy = checkBuyChaps($chap->id, $user->id);
                $check = checkRentChaps($chap->id, $user->id);
            }else{
                $buy = 0;
                $check = 0;
                if($chap->point == 0){
                    if($chap->rental == 0){
                        $check = 1;
                        $buy = 1;
                    }else{
                        $check = 0;
                    } 
                }
            }
            if($chap->count() == 0) {
                return redirect()->route('chap403');          
            }else{
                if($buy == 0){
                    if($check == 1) {
                        $chaps = Chap::with(['book.comic'=>$comic_query])
                            ->whereHas('book.comic', $comic_query)
                            ->where('book_id', $chap->book_id)
                            ->status()
                            ->orderBy('position','ASC')->get();  
                        $prev = array();
                        $next = array();
                        foreach($chaps as $key=>$item):
                            if($item->slug == $chap->slug && $chaps->count() > 1):
                                if($key > 0) $prev[] = $chaps[$key-1];
                                if($key < $chaps->count()-1) $next[] = $chaps[$key+1];
                            endif;
                            
                        endforeach;            
                        // Save cookie reading chap
                        $check = false;
                        $tempComic = new \stdClass();
                        $array = array();
                        if(isset($_COOKIE['chap_comic']) && $_COOKIE['chap_comic'] != '' ){
                            $cookie = $_COOKIE['chap_comic'];
                            $cookie = stripslashes($cookie);
                            $zzz = json_decode($cookie, true);
                            foreach ($zzz as $key=>$value) {
                                if ($value['id'] == $comic->id) {
                                    $tempComic->chap = $chap->id;
                                    $tempComic->id = $comic->id;
                                    $array[] = $tempComic;
                                    $check = true;
                                    $pos = $key;
                                    break;
                                }
                            }
                            if($check == false) {
                                $tempComic->id = $comic->id;
                                $tempComic->chap = $chap->id;
                                $array[] = $tempComic; 
                                foreach ($zzz as $key=>$value) {
                                    $array[] = $zzz[$key];
                                }   
                            }else{
                                foreach ($zzz as $key=>$value) {
                                    if ($key != $pos) {
                                        $array[] = $zzz[$key];
                                    }
                                }
                            }
                        }else{
                            $tempComic->id = $comic->id;
                            $tempComic->chap = $chap->id;
                            $array[] = $tempComic;  
                        }
                        $json = json_encode($array, JSON_UNESCAPED_UNICODE);
                        setcookie('chap_comic', $json, time() + 86400*30, '/');
                        
                        // Get cookie Setting
                        if (isset($_COOKIE['readingSetting']) && $_COOKIE['readingSetting'] != '') {
                            $cookie = $_COOKIE['readingSetting'];
                            $cookie = stripslashes($cookie);
                            $setting = json_decode($cookie, true);
                            foreach ($setting as $key => $value) {
                                $data[$key] = $value;
                            }
                        }
                        $seo = get_seo($chap->id, 'chap');
                        $data ['comic'] = $comic;
                        $data ['chap'] = $chap;
                        $data ['chaps'] = $chaps;
                        $data ['prev'] = $prev;
                        $data ['next'] = $next;
                        $data ['seo'] = $seo;
                        return view('comics.detail', $data);
                    }else{ 
                        return redirect()->route('chap403');
                    }
                }else{
                    $chaps = Chap::with(['book.comic'=>$comic_query])
                            ->whereHas('book.comic', $comic_query)
                            ->where('book_id', $chap->book_id)
                            ->status()
                            ->orderBy('position','ASC')->get();  
                    $prev = array();
                    $next = array();
                    foreach($chaps as $key=>$item):
                        if($item->slug == $chap->slug && $chaps->count() > 1):
                            if($key > 0) $prev[] = $chaps[$key-1];
                            if($key < $chaps->count()-1) $next[] = $chaps[$key+1];
                        endif;
                        
                    endforeach;            
                    // Save cookie reading chap
                    $check = false;
                    $tempComic = new \stdClass();
                    $array = array();
                    if(isset($_COOKIE['chap_comic']) && $_COOKIE['chap_comic'] != '' ){
                        $cookie = $_COOKIE['chap_comic'];
                        $cookie = stripslashes($cookie);
                        $zzz = json_decode($cookie, true);
                        foreach ($zzz as $key=>$value) {
                            if ($value['id'] == $comic->id) {
                                $tempComic->chap = $chap->id;
                                $tempComic->id = $comic->id;
                                $array[] = $tempComic;
                                $check = true;
                                $pos = $key;
                                break;
                            }
                        }
                        if($check == false) {
                            $tempComic->id = $comic->id;
                            $tempComic->chap = $chap->id;
                            $array[] = $tempComic; 
                            foreach ($zzz as $key=>$value) {
                                $array[] = $zzz[$key];
                            }   
                        }else{
                            foreach ($zzz as $key=>$value) {
                                if ($key != $pos) {
                                    $array[] = $zzz[$key];
                                }
                            }
                        }
                    }else{
                        $tempComic->id = $comic->id;
                        $tempComic->chap = $chap->id;
                        $array[] = $tempComic;  
                    }
                    $json = json_encode($array, JSON_UNESCAPED_UNICODE);
                    setcookie('chap_comic', $json, time() + 86400*30, '/');
                   
                    // Get cookie Setting
                    if (isset($_COOKIE['readingSetting']) && $_COOKIE['readingSetting'] != '') {
                        $cookie = $_COOKIE['readingSetting'];
                        $cookie = stripslashes($cookie);
                        $setting = json_decode($cookie, true);
                        foreach ($setting as $key => $value) {
                            $data[$key] = $value;
                        }
                    }
                    $seo = get_seo($chap->id, 'chap');
                    $data ['comic'] = $comic;
                    $data ['chap'] = $chap;
                    $data ['chaps'] = $chaps;
                    $data ['prev'] = $prev;
                    $data ['next'] = $next;
                    $data ['seo'] = $seo;
                    return view('comics.detail', $data);
                }
            }  
        }else{
            return redirect()->route('listChap', ['slugComic'=>$comic->slug]);
        }  
    }
    public function searchComic(Request $request) {
        $data = [];          
        $key = $request->keyword;
        $comic = 'Tìm truyện với từ khoá: '.$key;
        $comics = Comic::join('comic_writers','comics.id','=','comic_writers.comic_id')
                    ->join('writers','comic_writers.writer_id','=','writers.id')
                    ->where('comics.title','like','%'.$key.'%')
                    ->orWhere('writers.title','like','%'.$key.'%')
                    ->distinct()->select('comics.id as id', 'comics.title as title', 'comics.image as image', 'comics.slug as slug', 'comics.chap_up as chap_up')
                    ->orderBy('comics.chap_up','desc')->paginate(16);
        $data ['comic'] = $comic;
        $data ['keyword'] = $key;
        $data ['comics'] = $comics;
        $data ['full'] = 'not';
        $data ['typeComic'] = 'comicSearch';
        return view('comics.list', $data);
    }
    // Ajax Star rate
    public function saveStarRate(Request $request){
        $comic_id = $request->id;
        $current_rate = $request->rate;
        $comic = Comic::findOrFail($comic_id);
        $rating = round(($comic->votes * $comic->rating + $current_rate)/($comic->votes + 1),3);
        $vote = $comic->votes + 1;
        $comicIDs = array();
        if (isset($_COOKIE['rating_comic']) && $_COOKIE['rating_comic'] != '') {
            $cookie = $_COOKIE['rating_comic'];
            $cookie = stripslashes($cookie);
            $comicIDs = json_decode($cookie, true);
        }
        $comicIDs[] = $comic_id;
        $json = json_encode($comicIDs, JSON_UNESCAPED_UNICODE);
        setcookie('rating_comic', $json, time() + 86400*30, '/');   
        $data_update = [
            'rating' => $rating,
            'votes' => $vote
        ];
        Comic::where('id', $comic_id)->update($data_update);
        return 'success';
    }
    // Ajax Load Search Results
    public function searchAjaxComic(Request $request){
        $key = $request->keyword;
        $comics = Comic::join('comic_writers','comics.id','=','comic_writers.comic_id')
                    ->join('writers','comic_writers.writer_id','=','writers.id')
                    ->where('comics.title','like','%'.$key.'%')
                    ->orWhere('writers.title','like','%'.$key.'%')
                    ->distinct()->select('comics.title as title', 'comics.slug as slug', 'comics.chap_up as chap_up')
                    ->orderBy('comics.chap_up','desc')->limit(6)->get(); 
        if (count($comics) >0 ) {
            $data['lists'] = $comics;
            $data['keyword'] = $key;
            $html = view('comics.loadAjaxSearch', $data)->render();                     
        }else{
            $html = 'Không tìm thấy kết quả phù hợp!';
        }  
        return $html;            
    }
    // Save COOKIE Setting
    public function saveSettingChap(Request $request){        
        $attr = $request->attr;
        $value = $request->value;
        $setting = new \stdClass();
        $zzz = array();
        if (isset($_COOKIE['readingSetting']) && $_COOKIE['readingSetting'] != '') {
            $cookie = $_COOKIE['readingSetting'];
            $cookie = stripslashes($cookie);
            $zzz = json_decode($cookie, true);
            foreach ($zzz as $key => $item) {
                $setting->$key = $item;
            }
            $setting->$attr = $value;
        }else{
            $setting->$attr = $value;
        }
        $json = json_encode($setting, JSON_UNESCAPED_UNICODE);
        setcookie('readingSetting', $json, time() + 86400, '/');        
        return $zzz;
    }
    // Rent chap
    public function rentChap(Request $request){      
        $chap_id = $request->chap_id;
        $rental = $request->rental;
        $rental_period = Carbon::now();
        if(Auth::check()) {
            $user = Auth::user();
            $number = $user->rental - $rental;
            User::where('id', $user->id)->update(['rental' => $number]); 
            $chap_query = function ($query) use ($chap_id) {
                return $query->where('chaps.id',$chap_id);
            };
            $comic = Comic::with(['chaps'=>$chap_query])
                        ->whereHas('chaps', $chap_query)->first(); 
            $rent = Action::where('user_id',$user->id)->where('chap_id',$chap_id)->where('type','rental')->first();
            if($rent){
                $mytime = Carbon::now()->format('Y-m-d H:i:s');
                $date = $rent->rental_period;
                $date_time = strtotime($mytime) - strtotime($date);
                if($date_time > 48*3600){   
                    Action::create(['user_id'=>$user->id, 'chap_id'=>$chap_id,'comic_id'=>$comic->id, 'point'=>$rental, 'rental_period'=>$rental_period, 'type'=>'rental']);
                }
            }else{
                Action::firstOrCreate(['user_id'=>$user->id, 'chap_id'=>$chap_id,'comic_id'=>$comic->id, 'point'=>$rental, 'rental_period'=>$rental_period, 'type'=>'rental']); 
            }
        }
    }
    // buy chap
    public function buyChap(Request $request){      
        $chap_id = $request->chap_id;
        $point = $request->point;
        $rental_period = Carbon::now();
        if(Auth::check()) {
            $user = Auth::user(); 
            $number = $user->point - $point;
            User::where('id', $user->id)->update(['point' => $number]); 
            $chap_query = function ($query) use ($chap_id) {
                return $query->where('chaps.id',$chap_id);
            };
            $comic = Comic::with(['chaps'=>$chap_query])
                        ->whereHas('chaps', $chap_query)->first(); 
            $buy = Action::where('user_id',$user->id)->where('chap_id',$chap_id)->where('type','buy')->first();
            if(!$buy){ 
                Action::firstOrCreate(['user_id'=>$user->id, 'chap_id'=>$chap_id,'comic_id'=>$comic->id, 'point'=>$point,'rental_period'=>$rental_period, 'type'=>'buy']); 
            }
        }
    }
    public function donateAuthor(Request $request){
        $comic_id = $request->comic_id;
        $point = $request->point;
        $rental_period = Carbon::now();
        $check=0;
        if(Auth::check()) {
            $user = Auth::user(); 
            if($user->point >= $point){
                $number = $user->point - $point;
                User::where('id', $user->id)->update(['point' => $number]); 
                Action::firstOrCreate(['user_id'=>$user->id,'comic_id'=>$comic_id, 'point'=>$point,'rental_period'=>$rental_period, 'type'=>'donate']); 
                $request->session()->flash('success', 'Cảm ơn bạn đã ủng hộ truyện.');
                $check=1;
            }else{
                $request->session()->flash('error', 'Số point trong tài khoản bạn không đủ để ủng hộ.');
                $check=0;
            }
        }
        return response()->json(['check' => $check]);
    }
    
}