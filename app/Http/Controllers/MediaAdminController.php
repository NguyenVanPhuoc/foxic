<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\MediaCat;
use App\Media;
use App\MediaComic;
use App\User;

class MediaAdminController extends Controller
{
  public function index(){
    $media = Media::orderBy('updated_at', 'desc')->paginate(14);
    return view('backend.media.list',['media'=>$media]);
  }

  public function create(){
    return view('backend.media.create');
  }
  public function store(Request $request){
    $file = $request->file('file');
    $image_of = (isset($request->image_of) && $request->image_of != '') ? $request->image_of : 'system';
    if($file){
      $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
      $file_name = $file->getClientOriginalName();
      $imageName = explode(".", $file_name);
      $file_url = str_slug(str_random(4)."_".$imageName[0]).".".$imageName[1];
      if(in_array($imageName[1], $allowTypes)):
        $file->move("public/uploads/",$file_url);
        $user = Auth::User();
        $media = new Media();
        $media->image_path = $file_url;
        $media->type = "image"; 
        $media->image_of = $image_of; 
        $media->title = $imageName[0];
        if($request->category != "") $media->cat_ids = $request->category;
        $media->user_id = $user->id;
        $media->save();
      else:
        return response()->json(['msg'=>'error','html'=>"Chỉ up ảnh ('jpg', 'png', 'jpeg', 'gif')"]);
      endif;
    }
    if($request->ajax()){
        $html = '';
        $limit = 27;
        //$list_media = Media::where('image_of', 'system')->where('user_id',$user->id)->offset(0)->limit($limit)->latest()->get();
        $list_media = Media::where('user_id',$user->id)->offset(0)->limit($limit)->latest()->get();

        if($list_media):   
          $html = view('backend.media.list_template', ['list_media'=>$list_media])->render();
        endif;
        return response()->json(['msg'=>'success','html'=>$html]);
    }
    return $request->category;
  }
  public function edit($id){
    $media = Media::find($id);
    $mediaCat = MediaCat::orderBy('position', 'desc')->paginate(14);
    return view('backend.media.edit',['media'=>$media, 'mediaCat'=>$mediaCat]);
  }
  public function update(Request $request, $id){
    $message = "error";
    if($request->ajax()):
      $categories = json_decode($request->categories);
      $media = Media::find($id);
      $media->cat_ids = implode(",",$categories);
      if($request->title != "") $media->title = $request->title;
      $media->save();
      $message = "success";
    endif;
    return $message;
  }
  public function delete($id){
    $media = Media::where('user_id', Auth::id())->find($id);
    $path = public_path() . '/uploads/' . $media->image_path; 
    if(file_exists($path)) {
      unlink($path);
      $media->delete();
      return redirect()->route('media')->with('success','Xóa thành công');
    }
    return 'error';
  }
  //delete one file with ajax
  public function deleteMediaSingle(Request $resquest){
    if($resquest->ajax()){
      $media = Media::where('user_id', Auth::id())->find($resquest->id);
      $path = public_path() . '/uploads/' . $media->image_path; 
      if(file_exists($path)) {
        unlink($path);
        $media->delete();
      }
      return 'success';
    }
    return 'error';
  }
  //deleteAll
  public function deleteAll(Request $resquest){
    $message = "error";
    if($resquest->ajax()){
      $items = json_decode($resquest->items);
      if(count($items)>0){
        foreach ($items as $item) {
          $media = Media::where('user_id', Auth::id())->find($item);
          $path = public_path() . '/uploads/' . $media->image_path; 
          if(file_exists($path)) {
          unlink($path);
          $media->delete();
          }
        }
      }
      $message = "success";
    }
    return $message;
  }
  //load media
  /*public function loadMedia(Request $request){
    if(Auth::check()):
      $user = Auth::user();
      $limit = 27;   
      $media_UsedID = MediaComic::pluck('media_id')->toArray();  //get list media id used in media comic
      $total = Media::whereNotIn('id', $media_UsedID)->where('user_id',$user->id)->limit($limit)->latest()->count();
      $list_media = Media::whereNotIn('id', $media_UsedID)->where('user_id',$user->id)->limit($limit)->latest()->get();
      if($list_media):   
        $html = view('backend.media.list_template', ['list_media'=>$list_media])->render();   
      endif;
      return response()->json(['message'=>'success','html'=>$html,'total'=>$total,'limit'=>$limit,'current'=>count($list_media)]);
    endif;
    return;
  }  */
  public function loadMedia(Request $request){
    if(Auth::check()):
      $user = Auth::user();
      $limit = 27;   
      //$media_UsedID = MediaComic::pluck('media_id')->toArray();  //get list media id used in media comic
      $total = Media::where('user_id',$user->id)->limit($limit)->latest()->count();
      $list_media = Media::where('user_id',$user->id)->limit($limit)->latest()->get();
      if($list_media):   
        $html = view('backend.media.list_template', ['list_media'=>$list_media])->render();   
      endif;
      return response()->json(['message'=>'success','html'=>$html,'total'=>$total,'limit'=>$limit,'current'=>count($list_media)]);
    endif;
    return;
  } 
  //load by cat
  public function loadMediaByCat(Request $resquest){
    $message = "error";
    if($resquest->ajax() && Auth::check()){
      $user = Auth::user();
      $limit = 27;      
      if($resquest->catId!="" && $resquest->s!=""):
        $total = Media::whereRaw("find_in_set($resquest->catId,cat_ids)")->where('title','like','%'.$resquest->s.'%')->where('user_id',$user->id)->count();      
        $media = Media::whereRaw("find_in_set($resquest->catId,cat_ids)")->where('title','like','%'.$resquest->s.'%')->where('user_id',$user->id)->offset(0)->limit($limit)->latest()->get();
      elseif($resquest->catId!=""):
        $total = Media::whereRaw("find_in_set($resquest->catId,cat_ids)")->where('user_id',$user->id)->count();      
        $media = Media::whereRaw("find_in_set($resquest->catId,cat_ids)")->where('user_id',$user->id)->offset(0)->limit($limit)->latest()->get();
      else:
        $total = Media::where('user_id',$user->id)->count();      
        $media = Media::where('user_id',$user->id)->limit($limit)->latest()->get();
      endif;
      if($media):
        $message = "success";
        $html = '';
        foreach ($media as $item):
        $path = url('/').'/image/'.$item->image_path.'/150/100';
        $html .='<li id="image-'.$item->id.'"><div class="wrap"><img src="'.$path.'" alt="'.$item->image_path.'" data-date="'.$item->updated_at.'" data-image="'.url('public/uploads').'/'.$item->image_path.'" /></div></li>';
        endforeach;        
      endif;
      return response()->json(['message'=>'success','html'=>$html,'total'=>$total,'limit'=>$limit,'current'=>count($media)]);
    }
    return $message;
  }
  //search media cat
  /*public function searchCatMedia(Request $resquest){
    $message = "error";
    if($resquest->ajax() && Auth::check()){
      $user = Auth::user();
      if($resquest->s!=""):
        $mediaCat = MediaCat::where('title','like','%'.$resquest->s.'%')->where('user_id',$user->id)->get();
      else:
        $mediaCat = MediaCat::where('user_id',$user->id)->get();
      endif;
      if($mediaCat):
        $message = "success";
        $html = '';
        foreach ($mediaCat as $item):
        $html .='<a hef="#'.$item->slug.'" data-value="'.$item->id.'">'.$item->title.'</a>';
        endforeach;        
      endif;
      return response()->json(['message'=>'success','html'=>$html]);
    }
    return $message;
  }*/
  //search key
  public function searchMedia(Request $request){
    $message = "error";
    $html = '';
    if($request->ajax() && Auth::check()){
      $user = Auth::user();
      $limit = 27;
      
      $media_UsedID = MediaComic::pluck('media_id')->toArray();  
      $list_media = Media::whereNotIn('id', $media_UsedID)->where('user_id',$user->id);
      $total = Media::whereNotIn('id', $media_UsedID)->where('user_id',$user->id);

      if(isset($request->catId) && $request->catId != ''){
        $list_media = $list_media->whereRaw("find_in_set($request->catId,cat_ids)");
        $total = $total->whereRaw("find_in_set($request->catId,cat_ids)");
      }
      if(isset($request->s) && $request->s != ''){
        $list_media = $list_media->where('title','like','%'.$request->s.'%');
        $total = $total->where('title','like','%'.$request->s.'%');
      }
      if(isset($request->image_of) && $request->image_of != ''){
        $list_media = $list_media->where('image_of', $request->image_of);
        $total = $total->where('image_of', $request->image_of);
      }

      $list_media = $list_media->limit($limit)->latest()->get();
      $total = $total->count(); 

      if($list_media):   
        $html = view('backend.media.list_template', ['list_media'=>$list_media])->render();   
      endif;
      return response()->json(['message'=>'success','html'=>$html,'total'=>$total,'limit'=>$limit,'current'=>count($list_media)]);
    }
    return $message;
  }

  //load more media
  public function loadMorePage(Request $request){
    $html = '';
    $message = 'error';
    $user = Auth::user();
    $s = (isset($request->s)) ? $request->s : '';
    $catId = (isset($request->c)) ? $request->catId : '';
    $image_of = (isset($request->image_of)) ? $request->image_of : '';
    $current = (isset($request->current)) ? $request->current : 1;
    $limit = 27;
    $skip = 0;

    $media_UsedID = MediaComic::pluck('media_id')->toArray();  
    $list_media = Media::whereNotIn('id', $media_UsedID)->where('user_id',$user->id);
    $total = Media::whereNotIn('id', $media_UsedID)->where('user_id',$user->id);

    if($catId != ''){
      $list_media = $list_media->whereRaw("find_in_set($request->catId,cat_ids)");
      $total = $total->whereRaw("find_in_set($request->catId,cat_ids)");
    }
    if($s != ''){
      $list_media = $list_media->where('title','like','%'.$request->s.'%');
      $total = $total->where('title','like','%'.$request->s.'%');
    }
    if($image_of != ''){
      $list_media = $list_media->where('image_of', $request->image_of);
      $total = $total->where('image_of', $request->image_of);
    }

    $total = $total->count(); 
    if($total > $current){
      $list_media = $list_media->skip($current)->limit($limit)->latest()->get();
      $current += count($list_media);

      if($list_media):   
          $html = view('backend.media.list_template', ['list_media'=>$list_media])->render();   
          $message = 'success';
      endif;
    }
    
    return response()->json(['message'=>$message,'html'=>$html,'total'=>$total,'limit'=>$limit,'current'=>$current]);      
  }
}