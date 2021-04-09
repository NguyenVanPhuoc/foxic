<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\StickerCate;
use App\Sticker;
use Validator;

class StickerAdminController extends Controller {

    public function index(){
        $stickers = Sticker::query();
        $keyword = isset($request->keyword) ? $request->keyword : '';
        if($keyword != '')
            $stickers = $stickers->where('title', 'like', '%'.$keyword.'%');
        $stickers = $stickers->with('cate:id,title')->latest()->paginate(12);
        $data = [
            'stickers' => $stickers,
            'keyword' => $keyword,
        ];
        return view('backend.stickers.list',$data);
    }

    public function create(){
        $data = [
            'cates' => StickerCate::select('id','title')->latest()->get(),
        ];
        return view('backend.stickers.create', $data);
    }

    public function store(Request $request){
        $file = $request->file('file');
        if($file){
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            $file_name = $file->getClientOriginalName();
            $imageName = explode(".", $file_name);
            $title = $request->title != '' ? $request->title : $imageName[0];
            $file_url = str_slug('stk_'.str_random(4)."_".$title).".".$imageName[1];
            if(in_array($imageName[1], $allowTypes)):
                $sticker = Sticker::create(['title'=>$title, 'cate_id'=>$request->cate_id, 'image_path'=>$file_url]);
                $file->move("public/uploads/",$sticker->image_path);
                return response()->json(['msg'=>'success','html'=>"Upload thành công!"]);
            else:
                return response()->json(['msg'=>'error','html'=>"Chỉ up ảnh ('jpg', 'png', 'jpeg', 'gif')"]);
            endif;
        }
    }

    public function edit($id){
        $sticker = Sticker::find($id);
        $cates = StickerCate::select('id', 'title')->get();
        return view('backend.stickers.edit',['sticker'=>$sticker, 'cates'=>$cates]);
    }
    public function update(Request $request, $id){
        $rules = [
            'title'=>'required',
            'cate_id'=>'required',
        ];
        $messages = [
            'title.required'=>'Please enter title!',
            'cate_id.required'=>'Please choose package!',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()):
            return redirect()->route('admin.sticker_edit',['id'=>$id])->withErrors($validator)->withInput();;
        else:
            $sticker = Sticker::findOrFail($id);
            if($sticker){
                $sticker->title = $request->title;
                $sticker->cate_id = $request->cate_id;
                $sticker->save();
                if($sticker->wasChanged()) {
                    $request->session()->flash('success', __('Update complete!'));
                }
            }else $request->session()->flash('error', __('Update errors!'));
            return redirect()->route('admin.sticker_edit',['id'=>$id]);
        endif;
    }

    public function delete(Request $request, $id){
        $sticker = Sticker::find($id);
        $path = public_path() . '/uploads/' . $sticker->image_path; 
        if(file_exists($path)) {
            unlink($path);
            $sticker->delete();
            $request->session()->flash('success', __('Delete complete!'));
        }else $request->session()->flash('error', __('Don\'t find this image path!'));
        return redirect()->route('admin.stickers');
    }

    public function deleteAll(Request $request){
        $message = 'error';
        if($request->ajax()){
            $items = json_decode($request->items);
            if(count($items)>0){
                foreach ($items as $item) {
                    $sticker = Sticker::find($item);
                    $path = public_path() . '/uploads/' . $sticker->image_path; 
                    if(file_exists($path)) {
                        unlink($path);
                        $sticker->delete();
                    }
                }
            }
            $message = 'success';
        }
        return $message;
        // return redirect()->route('admin.stickers');
    }
}