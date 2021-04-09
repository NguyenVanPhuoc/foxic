<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\MediaCat;
use App\Media;

class MediaCatAdminController extends Controller
{
	public function index(){
		$mediaCats = MediaCat::orderBy('position', 'asc')->paginate(14);
		return view('backend.media.list_cat',['mediaCats'=>$mediaCats]);
	}

	public function create(){
		return view('backend.media.create_cat');
	}

	public function store(Request $request){
		$message = "error";
		if($request->ajax()){
			$media = new MediaCat();
			$media->title = $request->title;
			$media->slug = $request->title;
			$media->save();
			$message = "success";
		}
		return $message;
	}

	public function edit($id){ 
		$mediaCat = MediaCat::findOrFail($id);
		return view('backend.media.edit_cat',['mediaCat'=>$mediaCat]);
	}
	public function update(Request $request, $id){
		$message = "error";
		if($request->ajax()){	
			$media = MediaCat::find($id);
			$media->title = $request->title;
			$media->slug = $request->title;
			$media->save();
			$message = "success";
		}
		return $message;
	}	

	public function delete($id) {
		$mediaCat = MediaCat::findOrFail($id);
		$mediaCat->delete();
		return redirect()->route('mediaCat')->with('success','Xóa thành công');
	}

	//deleteAll
	public function deleteAll(Request $resquest){
		$message = "error";
		if($resquest->ajax()){
			$items = json_decode($resquest->items);
			if(count($items)>0){
				foreach ($items as $item) {
					$media = Media::find($item);
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
	public function position(Request $request){
		$message = "error";
		if($request->ajax()):
			$routes = json_decode($request->routes);
			foreach ($routes as $item):
				$mediaCat = MediaCat::find($item->id);
				$mediaCat->position = $item->position;
				$mediaCat->save();
			endforeach;
			$message = "success";
		endif;
		return $message;
	}  
}