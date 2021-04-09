<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Media;
use App\Reviewers;

class ReviewerAdminController extends Controller
{
   	public function index(){    	
    	$reviews = Reviewers::orderBy('updated_at', 'desc')->paginate(14);
    	return view('backend.reviews.list',['reviews'=>$reviews]);
    }
    
    public function store(){
    	return view('backend.reviews.create');
    }
    public function create(Request $request){
    	$message = "error";
        if($request->ajax()):
        	$reviewer = new Reviewers;
            $reviewer->name = $request->title;
        	$reviewer->slug = $request->title;
        	$reviewer->content = $request->content;
        	if($request->image!="") $reviewer->image = $request->image;
        	$reviewer->save();
            $message = "success";
        endif;
        return $message;
    }
    
    public function edit($id){
        $reviewer = Reviewers::find($id); 
    	return view('backend.reviews.edit',['reviewer'=>$reviewer]);
    }

    public function update(Request $request, $id){
    	 $message = "error";
        if($request->ajax()):
            $reviewer = Reviewers::find($id);
            $reviewer->name = $request->title;
            $reviewer->slug = $request->title;
            $reviewer->content = $request->content;
            if($request->image!="") $reviewer->image = $request->image;
            $reviewer->save();
            $message = "success";
        endif;
        return $message;     
    }  	
	public function delete($id){
    	$reviewer = Reviewers::find($id);
    	$reviewer->delete();
    	return redirect('/admin/reviews/')->with('success','Xóa thành công');
    }
}
