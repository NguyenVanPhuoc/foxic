<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Slide;

class SlideAdminController extends Controller
{
	public function index(Request $request){
		$s = $request->s;
		$slides = Slide::latest()->paginate(15);
		return view('backend.slide.list',['slides'=>$slides,'s'=>$s]);
	}

	public function store(){    	
		return view('backend.slide.create');
	}

	public function create(Request $request){
		if($request->ajax()):
	        $slide = Slide::create([
				'title'=> $request->title,
				'content'=> $request->items
			]);
			$request->session()->flash('success', 'Thêm thành công');
			return 'success';
       	endif;
		$request->session()->flash('error', 'Vui lòng kiểm tra lại để biết thêm thông tin');
		return 'error';
	}

	public function edit($id){ 
		$slide = Slide::find($id);   	
		return view('backend.slide.edit',['slide'=>$slide]);
	}

	public function update(Request $request, $id){
		if($request->ajax()):
	        $slide = Slide::where('id',$id)->update([
				'title'=> $request->title,
				'content'=> json_encode($request->items)
			]);
			$request->session()->flash('success', 'Sửa thành công');
			return 'success';
       	endif;
		$request->session()->flash('error', 'Vui lòng kiểm tra lại để biết thêm thông tin');
		return 'error';
	}
	//change slug
     public function changeSlug(Request $request,$id){
        $message = 'error';
        if($request->ajax() && Auth::check()):
            Slide::where('id', $id)->update(['slug'=>$request->slug]);
            $message = $request->slug;
        endif;
        return $message;
    }
	public function delete(Request $request,$id) {
		// $mediaCat = Slide::findOrFail($id);
		// if($mediaCat->delete())
		// 	$request->session()->flash('success', '삭제 완료되었습니다');
		// else
		// 	$request->session()->flash('error', '삭제가 불가능합니다');
		return redirect()->route('slidesAdmin');
	}

	public function deleteChoose(Request $request){
		// $items = explode(",",$request->items);
		// if(count($items)>0){
		// 	$request->session()->flash('success', '삭제 완료되었습니다');
		// 	Slide::destroy($items);
		// }else{
		// 	$request->session()->flash('error', '삭제가 불가능합니다');
		// }
		return redirect()->route('slidesAdmin');
	}
}