<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Pages;
use App\Metas;
use Carbon\Carbon;
use App\Comic;
use App\Chap;
use App\CategoryComic;
use App\TypeComic;
use App\Writer;
use App\ComicCat;
use App\ComicType;
use App\ComicWriter;
use App\Options;
use App\UserComic;
use App\Like;
use App\User;
use App\Article;
use App\Category;
use App\Notice;

class PagesController extends Controller
{
    public function index(){
        $data = [];
        $user = Auth::User();
        $page = Pages::findOrFail(1);
        $seo = get_seo($page->id,'page');
        $catHotId = Metas::findOrFail(13)->content;
        $catNewId = Metas::findOrFail(19)->content;
        $catFullId = Metas::findOrFail(20)->content;  
        $catMonopolyId = Metas::findOrFail(21)->content; 
        $catNovelId = Metas::findOrFail(22)->content; 
        $readChaps = '';
        $recentlyReads = '';
        $comicCatHot = '';
        $comicCatNew = '';
        $comicCatFull = '';
        $comicMonopoly = '';
        $comicCatHot = getListComicInCatV1($catHotId);
        $comicCatNew = Comic::status()->select('comics.id as id', 'comics.title as title','comics.image as image', 'comics.slug as slug','comics.end as end', 'comics.chap_up as chap_up')
                        ->orderBy('comics.chap_up','desc')  
                        ->limit(6)->get();
        $comicCatFull = getListComicInCatV1($catFullId);
        $comicMonopoly = getListComicInCatV1($catMonopolyId);
        $comicNovel = getListComicInCatV1($catNovelId);
        $comicVotes = Comic::status()->orderBy('votes','desc')->limit(5)->get();
        $comicRandom = Comic::inRandomOrder()->status()->limit(6)->get();
        $new_review = Article::where('status','public')->latest()->limit(6)->get(); 
        $slide = get_slide(1);              
        $data['user'] = $user;
        $data['page'] = $page;
        $data['seo'] = $seo;
        $data['catHotId'] = $catHotId;
        $data['catFullId'] = $catFullId;
        $data['catNewId'] = $catNewId;
        $data['catMonopolyId'] = $catMonopolyId;
        $data['catNovelId'] = $catNovelId;
        $data['comicCatHot'] = $comicCatHot;
        $data['comicCatNew'] = $comicCatNew;
        $data['comicCatFull'] = $comicCatFull;
        $data['comicMonopoly'] = $comicMonopoly;
        $data['comicNovel'] = $comicNovel;
        $data['comicVotes'] = $comicVotes;
        $data['comicRandom'] = $comicRandom;
        $data['new_review'] = $new_review;
        $data['slide'] = $slide;
        return view('index',$data);
    }
    public function loadTypeHot(Request $request){
        if($request->ajax()){
            $html = '';
            $catHotId = Metas::findOrFail(13)->content;  
            $typeComic = $request->type_hot;
            $comicCatHot = Comic::query();
            $comicCatHot = $comicCatHot->join('comic_cats','comics.id','=','comic_cats.comic_id')
                        ->join('category_comics','category_comics.id','=','comic_cats.cat_id')
                        ->join('comic_types','comics.id','=','comic_types.comic_id')
                        ->join('type_comics','type_comics.id','=','comic_types.type_id')
                        ->where('comic_cats.cat_id',$catHotId);
            if($typeComic != 'tat-ca') $comicCatHot = $comicCatHot->where('type_comics.slug',$typeComic);
            $comicCatHot = $comicCatHot->distinct()
                        ->select('comics.title as title','comics.slug as slug','comics.image as image','comics.rating as rating')
                        ->orderBy('comics.rating','desc')
                        ->limit(13)
                        ->get();
            if ($comicCatHot->isNotEmpty()) {
                $count = 0;
                foreach ($comicCatHot as $comic) {
                    $count ++;
                    if ($count == 1) {
                        $html .= '<div class="item top-'.$count.'">';
                            $html .= '<a href="'.route('listChap',$comic->slug).'">';
                                if ($comic->end == 1) $html .= '<span class="full-label"></span>';
                                $html .= image($comic->image,265,396 ,$comic->title);
                                $html .= '<div class="title">';
                                    $html .= '<h3>'.$comic->title.'</h3>';
                                $html .= '</div>';
                            $html .= '</a>';
                        $html .= '</div>';
                    }else{
                        $html .= '<div class="item top-'.$count.'">';
                            $html .= '<a href="'.route('listChap',$comic->slug).'">';
                                if ($comic->end == 1) $html .= '<span class="full-label"></span>';
                                $html .= image($comic->image,129,192 ,$comic->title);
                                $html .= '<div class="title">';
                                    $html .= '<h3>'.$comic->title.'</h3>';
                                $html .= '</div>';
                            $html .= '</a>';
                        $html .= '</div>';
                    }
                }
            }
            return response()->json(['message'=>'success','html'=>$html]);
        }
        return response()->json(['message'=>'error']);
    }
    public function loadTypeNew(Request $request){
        if($request->ajax()){
            $html = '';
            $catHotId = Metas::findOrFail(19)->content;  
            $typeComic = $request->type_hot;
            $comicCatNew = Comic::query();
            $comicCatNew = $comicCatNew->join('comic_cats','comics.id','=','comic_cats.comic_id')
                        ->join('category_comics','category_comics.id','=','comic_cats.cat_id')
                        ->join('comic_types','comics.id','=','comic_types.comic_id')
                        ->join('type_comics','type_comics.id','=','comic_types.type_id')
                        ->where('comic_cats.cat_id',$catHotId);
            if($typeComic != 'tat-ca') $comicCatNew = $comicCatNew->where('type_comics.slug',$typeComic);
            $comicCatNew = $comicCatNew->distinct()
                        ->select('comics.id as id','comics.title as title','comics.slug as slug','comics.image as image','comics.end as end', 'comics.chap_up as chap_up')
                        ->orderBy('comics.chap_up','desc')
                        ->limit(20)
                        ->get();
            if ($comicCatNew->isNotEmpty()) {
                foreach ($comicCatNew as $comic) {
                    $html .= '<div class="item row">';
                        $html .= '<div class="comic-title col-md-5">';
                            $html .= '<span class="glyphicon glyphicon-chevron-right"></span>';
                            $html .= '<h4><a href="'.route('listChap',$comic->slug).'">'.$comic->title.'</a></h4>';
                            if (checkComicHot($comic->id)) { $html .= '<span class="label-title label-hot"></span>'; }
                            if (checkComicNew($comic->id)) { $html .= '<span class="label-title label-new"></span>'; }
                            if (checkComicFull($comic->id)) { $html .= '<span class="label-title label-full"></span>'; }
                            // if ($comic->end == 1)  { $html .= '<span class="label-title label-full"></span>'; }
                            
                        $html .= '</div>';
                        $html .= '<div class="comic-type col-md-3">'.getObjSlugTitleTypeInComic($comic->id).'</div>';
                        $chap = getLatestChapByComicId($comic->id);
                        $text = ''; 
                        if ($chap) {
                            $text .= '<a href="#">'.$chap->chap.'</a>';
                        }else{
                            $text .= 'Chưa có';
                        }
                        $html .= '<div class="comic-chap col-md-2">'.$text.'</div>';
                        $html .= '<div class="comic-created col-md-2">'.timeElapsedString($comic->chap_up).'</div>';
                    $html .= '</div>';
                }
            }
            return response()->json(['message'=>'success','html'=>$html]);
        }
        return response()->json(['message'=>'error']);
    }
    public function ongoing(Request $request){
        $data = [];
        $user = Auth::User();
        $page = Pages::findOrfail(22);
        $seo = get_seo($page->id,'page');
        $timeUp = $request->time_up;
        $comicOngings = Comic::query();
        if($timeUp != '') $comicOngings = $comicOngings->where('time_up',$timeUp);
        $comicOngings = $comicOngings->select('id','title','slug','image','time_up')->get();
        $status = '';
        if (!$user) {
            if(isset($_COOKIE['family_safe']) && $_COOKIE['family_safe'] != ''){
                $status = $_COOKIE['family_safe'];
            }
        }else {
            $status = $user->status_safe;
        }
        $data['page'] = $page;
        $data['seo'] = $seo;
        $data['comicOngings'] = $comicOngings;
        $data['status'] = $status;
        return view('ongoings.list', $data);
    }
    public function ranking(Request $request){
        $data = [];
        $user = Auth::User();
        $page = Pages::findOrfail(23);
        $seo = get_seo($page->id,'page');
        $status = '';
        $types = TypeComic::select('slug','title')->get();
        $typePlus = $request->type_plus;
        $comicRatings = Comic::query();
        $comicRatings = $comicRatings->join('comic_types','comics.id','=','comic_types.comic_id')
                        ->join('type_comics','type_comics.id','=','comic_types.type_id')
                        ->join('chaps','comics.id','=','chaps.comic_id');
        if($typePlus != '') $comicRatings = $comicRatings->where('type_comics.slug',$typePlus);
        $comicRatings = $comicRatings->distinct()
                        ->select('comics.id as id','comics.slug as slug','comics.title as title','comics.image as image','comics.time_up as time_up','comics.rating as rating')
                        ->orderBy('chaps.rating','desc')->get();
        if (!$user) {
            if(isset($_COOKIE['family_safe']) && $_COOKIE['family_safe'] != ''){
                $status = $_COOKIE['family_safe'];
            }
        }else {
            $status = $user->status_safe;
        }
        $data['page'] = $page;
        $data['seo'] = $seo;
        $data['types'] = $types;
        $data['comicRatings'] = $comicRatings;
        $data['status'] = $status;
        return view('rankings.list', $data);
    }
    public function faqs(){
        $data = [];
        $page = Pages::findOrFail(12);
        $seo = get_seo($page->id,'page');
        $data['page'] = $page;
        $data['seo'] = $seo;
        return view("faqs",$data);
    }
    public function favorite(){
        $data = [];
        $page = Pages::findOrFail(24);
        $seo = get_seo($page->id,'page');
        $user = Auth::user();
        $status = '';
        $listFavorites = '';
        if ($user) {
            $listFavorites = Comic::join('likes','comics.id','=','likes.comic_id')
            ->join('users','users.id','=','likes.user_id')
            ->where('likes.user_id',$user->id)
            ->distinct()
            ->select('comics.id as id', 'comics.title as title' ,'comics.image as image', 'likes.created_at as created_at')
            ->get();
            $status = $user->status_safe;
        }
        $data['page'] = $page;
        $data['seo'] = $seo;
        $data['listFavorites'] = $listFavorites;
        $data['status'] = $status;
        return view('dynamicPages.favorite', $data);
    }
    public function history(){
        $data = [];
        $user = Auth::User();
        $page = Pages::findOrFail(5);
        $seo = get_seo($page->id,'page');        
        $readChaps = '';
        $recentlyReads = '';
        $status = '';
        $time = '';
        //if user no login
        if(!$user){
            if(isset($_COOKIE['comic']) && $_COOKIE['family_safe'] != ''){
                $cookie = $_COOKIE['comic'];
                $readChaps = json_decode($cookie, true);
                $arrComic = [];
                if($readChaps){
                    foreach ($readChaps as $item) {
                        $arrComic[] = $item['comic_id'];
                        $arrComic['time'] = $item['time'];
                    }
                    $recentlyReads = Comic::whereIn('id',$arrComic)->get();
                    $time = $arrComic['time'];
                }
            } 
            if(isset($_COOKIE['family_safe']) && $_COOKIE['family_safe'] != ''){
                $status = $_COOKIE['family_safe'];
            }
        }else{ //if user login 
            $recentlyReads = Comic::join('user_comics','user_comics.comic_id','=','comics.id')
                            ->join('users','users.id','=','user_comics.user_id')
                            ->where('user_comics.user_id',$user->id)
                            ->distinct()
                            ->select('comics.id as id', 'comics.title as title' ,'comics.image as image', 'user_comics.created_at as created_at')
                            ->get();
            $status = $user->status_safe;
        }
        $data['page'] = $page;
        $data['seo'] = $seo;
         $data['recentlyReads'] = $recentlyReads;
        $data['time'] = $time;
        $data['status'] = $status;
        return view('dynamicPages.history', $data);
    }
    /**
    * Display content contact page
    */ 
    public function contact(){
        $page = Pages::findOrFail(15);
        return view("contact",['page'=>$page]);
    }
    public function updateContact(Request $request){
        $message = "error";
        if($request->ajax()):
            //mail admin
            $content = '<ul>';
            $content .= '<li>Fullname: '.$request->name.'</li>';
            $content .= '<li>Phone: '.$request->phone.'</li>';
            $content .= '<li>Email: '.$request->email.'</li>';
            $content .= '<li>Email: '.$request->subject.'</li>';
            $content .= '<li>Message: '.$request->message.'</li>';
            $content .= '</ul>';
            $data = array( 'email' => $request->email, 'name' => $request->name, 'from' => mailSystem(), 'message'=> $content);
            Mail::send( 'mails.admin.contact', compact('data'), function( $message ) use ($data){
                $message->to($data['from'])
                        ->from( $data['email'], $data['name'] )
                        ->subject('[Contact from Truyenfull] - '.$data['name']);
            });
            //mail customer
            $data = array( 'email' => $request->email, 'from' => mailSystem(),'name' => $request->name);
            Mail::send( 'mails.contact', compact('data'), function( $message ) use ($data){
                $message->to($data['email'])
                        ->from( $data['email'], $data['name'] )
                        ->subject('[Truyenfull] Thank you for responding!');
            });
            $message = 'Thank you for submitting your request to Truyenfull, we will get back to you as soon as possible.';
        endif;
        return $message;
    }
    public function type(Request $request, $slug){
        $type = postType($slug);
        if($type):
            switch ($type) {
            case 'article':
                $data = [];
                $blog = Article::findBySlug($slug);
                $seo = get_seo($blog->id,'article');
                $otherArticles = Article::where('id','<>',$blog->id)
                        ->where('cat_id',$blog->cat_id)
                        ->latest()->paginate(5);
                $data['blog'] = $blog;
                $data['seo'] = $seo;
                $data['otherArticles'] = $otherArticles;
                return view('articles.detail',$data);
                break;
            case 'articleCat':
                $data = [];
                $cat = ArticleCat::findBySlug($slug);
                $seo = get_seo($cat->id,'category');
                $data['cat'] = $cat;
                $data['seo'] = $seo;
                return view('articles.list_by_cat',$data);
                break;
            default:
                $data = [];
                $page = Pages::findBySlug($slug);
                $seo = get_seo($page->id,'page');
                $data['page'] = $page;
                $data['seo'] = $seo;
                return view("page",$data);
                break;
            }
        else:
            switch ($slug) {
                case 'login':
                    if(Auth::check()){
                        $user = Auth::User();
                        if($user->level == "admin")
                            return redirect('admin');
                        else
                            return redirect()->back();
                    }        
                    return view('login');
                    break;
                case 'logout':
                    Auth::logout();
                    return redirect(url('/'));
                    break;
                case 'register':
                    if(Auth::check()){
                        $user = Auth::User();
                        if($user->level == "admin")
                            return redirect('admin');
                        else
                            return redirect()->back();
                    }
                    return view('register');
                    break;
                case 'forgot-password':
                    if(Auth::check()){
                        $user = Auth::User();
                        if($user->level == "admin")
                            return redirect('admin');
                        else
                            return redirect()->back();
                    }
                    return view('forgotPassword');
                    break;
                case 'retake-password':
                    if(Auth::check()){
                        $user = Auth::User();
                        if($user->level == "admin")
                            return redirect('admin');
                        else
                            return redirect()->back();
                    }
                    return view('retakePassword');
                    break;
                case 'check-otp':
                    if(Auth::check()){
                        $user = Auth::User();
                        if($user->level == "admin")
                            return redirect('admin');
                        else
                            return redirect()->back();
                    }
                    return view('checkOtp');
                    break;
                case 'tim-kiem':
                    if($request->f!=""){
                        if($request->f=="alpha-test")
                            $f = "server_alpha";
                        else
                            $f = "server_open";
                    }
                    if($request->s !="" && $request->type !=""):
                        $number = Article::where('title','like','%'.$request->s.'%')->where('cat_id',$request->type)->count();
                        if($request->f=="")
                            $blog = Article::where('title','like','%'.$request->s.'%')->where('cat_id',$request->type)->latest()->paginate(14);
                        else
                            $blog = Article::where('title','like','%'.$request->s.'%')->where('cat_id',$request->type)->orderBy($f,'desc')->paginate(14);
                    elseif($request->s):
                        $number = Article::where('title','like','%'.$request->s.'%')->count();
                        if($request->f=="")
                            $blog = Article::where('title','like','%'.$request->s.'%')->latest()->paginate(14);
                        else
                            $blog = Article::where('title','like','%'.$request->s.'%')->orderBy($f,'desc')->paginate(14);
                    elseif($request->s):
                        $number = Article::where('cat_id',$request->type)->count();
                        if($request->f=="")
                            $blog = Article::where('cat_id',$request->type)->latest()->paginate(14);
                        else
                            $blog = Article::where('cat_id',$request->type)->orderBy($f,'desc')->paginate(14);
                    else:
                        $number = Article::all()->count();
                        if($request->f=="")
                            $blog = Article::latest()->paginate(14);
                        else
                            $blog = Article::orderBy($f,'desc')->paginate(14);
                    endif;
                    return view('articles.search',['blog'=>$blog, 's'=>$request->s, 'type'=>$request->type, 'number'=>$number, 'f'=>$request->f]);
                    break;
                case 'admin':
                    if(Auth::check()){
                        $user = Auth::User();
                        if($user->level == "admin"){
                            $articles = Article::orderBy('created_at', 'desc')->paginate(14);
                            return view('backend.articles.list',['articles'=>$articles]);
                        }
                        else
                            return redirect()->back();
                    }
                    return redirect('/');
                    break;   
                
                default:
                    return view('errors.404');
                    break;

            }
            // return view('errors.404');
        endif;
    }
    public function getPage($slug){
        $page = Pages::join('seos','seos.post_id','=','pages.id')
        ->select('pages.id as id','pages.slug as slug','pages.title as title','content','seos.key as key','seos.value as value')
        ->where('pages.slug', $slug)->first(); 
        if ($page) {
            return view('page',['page'=>$page]); 
        }else{
            return view('errors.404');
        }       	
    }
    public function detailArticle($slug){
        $article= Article::findBySlugOrFail($slug);
        $cat_id = $article->cate_id[0];
        $list_article = Article::whereRaw('json_contains(cate_id, \'["' . $cat_id . '"]\')')
                            ->where('id','!=',$article->id)
                            ->where('status','public')->inRandomOrder()->limit(3)->get();
        $seo = get_seo($article->id, 'article');
        $data = [];  
        $data['article'] = $article;
        $data['list_article'] = $list_article;
        $data ['typeComic'] = 'comicCat';
        $data['seo'] = $seo;
        return view('articles.detail',$data);
    }
    public function cateArticle($slug){  
        $data = [];  
        $cate = Category::findBySlugOrFail($slug);
        $list_article = getListArticleInCat($cate->id);
        $data ['cate'] = $cate;
        $data ['list_article'] = $list_article;        
        $data ['typeComic'] = 'comicCat';
        $seo = get_seo($cate->id, 'category');
        $data['seo'] = $seo;
        return view('articles.list', $data);
    }
    public function indexNotice(){
        if(Auth::check()){
            $user=Auth::User();     
            $list_notice= getListNoticeByUserId($user->id);
            $data = [];  
            $data['list_notice'] = $list_notice;
            return view('notices.list',$data);
        }else{  
            return view('errors.404');
        }
    }
    public function detailNotice($slug){
        if(Auth::check()){
            $user=Auth::User();
            $notice= Notice::findBySlugOrFail($slug);
            readingNotification($notice->id, $user->id);       
            $data = [];  
            $data['notice'] = $notice;
            return view('notices.detail',$data);
        }else{  
            return view('errors.404');
        }
    }
}