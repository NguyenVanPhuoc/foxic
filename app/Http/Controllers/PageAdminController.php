<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Pages;
use App\GroupMetas;
use App\Metas;
use App\User;
use App\Seo;
use Carbon\Carbon;
use App\Action;
use App\TransferHistory;
use App\Events\UpdateUserPoint;
use App\Notifications\SendMailMovePoint;
class PageAdminController extends Controller
{
    public function index(){
    	$pages = Pages::orderBy('updated_at', 'desc')->paginate(14);
        return view('backend.page.list',['pages'=>$pages]);
    }
    
    public function create(){
    	return view('backend.page.create');
    }

    public function store(Request $request){
    	$message = "error";
        if($request->ajax()){
        	$user = Auth::User();
        	$page = new Pages;
            $page->title = $request->title;
        	$page->slug = $request->title;
        	$page->content = $request->content;
        	$page->user_id = $user->id;
        	if($page->save()){
                $seo = new Seo;
                $seo->key = $request->metaKey;
                $seo->value = $request->metaValue;
                $seo->type = 'page';
                $seo->post_id = $page->id;
                $seo->save();
            }
            $message = "success";
        }
        return $message;
    }
    
    public function edit($id){
        $page = Pages::find($id);
        $seo = get_seo($id,'page');
    	return view('backend.page.edit',['page'=>$page, 'seo'=>$seo]);
    }

    public function update(Request $request, $id){
        $message = "error";
        if($request->ajax()){
            $page = Pages::find($id);
            $page->title = $request->title;
            $page->slug = $request->title;
            $page->content = $request->content;
            if($page->save()){
                $metaFields = json_decode($request->metaFields);
                if(count($metaFields)>0):
                    foreach ($metaFields as $item) {   
                        $meta = Metas::find($item->id);
                        $meta->content = $item->content;
                        $meta->save();
                    }
                endif;
                $seo = Seo::where('post_id',$id)->where('type','page')->first();
                if(!$seo){
                    $seo = new Seo;
                }
                $seo->key = $request->metaKey;
                $seo->value = $request->metaValue; 
                $seo->type = 'page';
                $seo->post_id = $id;
                $seo->save();
            }
            $message = "success";
        }
        return $message;
    }
	public function delete($id){
        $seo = Seo::where('post_id',$id)->where('type','page');
        if($seo) $seo->delete();
    	$page = Pages::find($id);
    	$page->delete();
    	return redirect()->route('pagesAdmin')->with('success','Delete success');
    }
    //deleteAll
    public function deleteAll(Request $request){        
        $message = "error";
        if($request->ajax()){
            $items = json_decode($request->items);
            if(count($items)>0){
                Pages::destroy($items);
            }
            $message = "success";
        }
        return $message;
    }
    public function statisticalAdmin(Request $request){
        $startDate = isset($request->startDate) ? date_format(date_create($request->startDate), 'Y-m').'-01' : Carbon::now()->format('Y-m').'-01';
        $endDate = isset($request->endDate) ? date_format(date_create($request->endDate), 'Y-m-t') : Carbon::now()->format('Y-m-d');
        $user_id = isset($request->user_id) ? $request->user_id : '';
        $comic_query = function ($query) {
            return $query->select('id','user_id', 'status')->where('status','public');
        };
        $action_query = function ($query) use ($startDate, $endDate) {
            if($startDate == '') return $query->select('actions.id', 'comic_id', 'point', 'type', 'rental_period')->whereDate('rental_period', '<=', $endDate);
            else return $query->select('actions.id','comic_id', 'point', 'type', 'rental_period')->whereDate('rental_period', '>=', $startDate)->whereDate('rental_period', '<=', $endDate);
        };
        $view_query = function ($query) use ($startDate, $endDate) {
            if($startDate == '') return $query->select('view_months.id', 'view_months.comic_id', 'current_month', 'view_month')->whereDate('current_month', '<=', $endDate);
            else return $query->select('view_months.id','view_months.comic_id', 'current_month', 'view_month')->whereDate('current_month', '>=', $startDate)->whereDate('current_month', '<=', $endDate);
        };
        $transfer_query = function ($query) use ($startDate, $endDate) {
            if($startDate == '') return $query->select('transfer_history.id', 'transfer_history.user_id','transfer_history.point', 'transfer_history.month')->whereDate('transfer_history.month', '<=', $endDate);
            else return $query->select('transfer_history.id', 'transfer_history.user_id','transfer_history.point', 'transfer_history.month')->whereDate('transfer_history.month', '>=', $startDate)->whereDate('transfer_history.month', '<=', $endDate);
        };
        $user = User::query();
        if(isset($user_id) && $user_id != '') $user = $user->where('users.id', $user_id);

        $user = $user->with(['comics'=>$comic_query, 'actions'=>$action_query, 'views'=>$view_query, 'transfers'=>$transfer_query])->whereHas('comics', $comic_query)->get(); 
        //dd($user[0]);
        $author = User::with(['comics'=>$comic_query])
                        ->whereHas('comics', $comic_query)->get();
        $data=[];
        $data['user']=$user;
        $data['author']=$author;
        $data['startDate']=$startDate;
        $data['endDate']=$endDate;
        $data['user_id']=$user_id;
        return view('backend.page.list_statis',$data);
    }
    public function movedPointAdmin(Request $request, $user_id, $fromMonth, $toMonth){
        $months = getPointByMonth($fromMonth,$toMonth);
        $sumPoint=0;
        $arrayMonth = array();
        foreach ($months as $key => $value) {
            $startDate = date_format(date_create($value), 'Y-m').'-01';
            $endDate = date_format(date_create($value), 'Y-m-t');
            $comic_query = function ($query) {
                return $query->select('id','user_id', 'status')->where('status','public');
            };
            $action_query = function ($query) use ($startDate, $endDate) {
                if($startDate == '') return $query->select('actions.id', 'comic_id', 'point', 'type', 'rental_period')->whereDate('rental_period', '<=', $endDate);
                else return $query->select('actions.id','comic_id', 'point', 'type', 'rental_period')->whereDate('rental_period', '>=', $startDate)->whereDate('rental_period', '<=', $endDate);
            };
            $view_query = function ($query) use ($startDate, $endDate) {
                if($startDate == '') return $query->select('view_months.id', 'view_months.comic_id', 'current_month', 'view_month')->whereDate('current_month', '<=', $endDate);
                else return $query->select('view_months.id','view_months.comic_id', 'current_month', 'view_month')->whereDate('current_month', '>=', $startDate)->whereDate('current_month', '<=', $endDate);
            };
            $user = User::with(['comics'=>$comic_query, 'actions'=>$action_query, 'views'=>$view_query])
                        ->whereHas('comics', $comic_query)->where('id', $user_id)->first(); 
            $current_month = strtotime('2021-02');
            $month = strtotime($value);
            if($current_month > $month){
                $point = $user->actions->whereIn('type',['buy','rental'])->sum('point');
                $donate = $user->actions->where('type','donate')->sum('point');
                $view = $user->views->sum('view_month');
                if($user->type_author == 'official'):
                    $sum = (50/100 * $point)+(70/100 * $donate);
                    $sumPoint = $sum + $sumPoint;
                elseif($user->type_author == 'unofficial'):
                    $sum = (40/100 * $point)+(50/100 * $donate);
                    $sumPoint = $sum + $sumPoint;
                elseif($user->type_author == 'unrestrained'):
                    $sum = $view/50;
                    $sumPoint = $sum + $sumPoint;
                endif;
                TransferHistory::create(['user_id'=>$user->id,'point'=>$sum,'month'=>$startDate]);
                event(new UpdateUserPoint($user,$sumPoint));
                $user->notify(new SendMailMovePoint($user));
                $arrayMonth[]='Tháng '.date_format(date_create($value), 'm-Y').' đã chuyển point thành công';
            }else{
                $arrayMonth[]='Tháng '.date_format(date_create($value), 'm-Y').' không được chuyển point';            
            }
        }
        $request->session()->flash('errorMonth', $arrayMonth);
        return redirect()->route('statisticalAdmin',['startDate'=>$fromMonth,'endDate'=>$toMonth, 'user_id'=>'']);
       

    }
}