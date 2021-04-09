<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\StickerCate;
use Validator;

class StickerCateAdminController extends Controller {

	public function index(Request $request){
        $cates = StickerCate::query();
        $keyword = isset($request->keyword) ? $request->keyword : '';
        if($keyword != '')
            $cates = $cates->where('title', 'like', '%'.$keyword.'%');
        $cates = $cates->withCount('stickers')->latest()->paginate(12);
        $data = [
            'cates' => $cates,
            'keyword' => $keyword,
        ];
        return view('backend.stickers.list_cate',$data);
    }

    public function create(Request $request){
        return view('backend.stickers.create_cate');
    }

    public function store(Request $request){
        $rules = [
            'title'=>'required',
            'amount'=>'required',
        ];
        $messages = [
            'title.required'=>'Please enter title!',
            'amount.required'=>'Please enter price of sticker package!',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()):
            return redirect()->route('admin.sticker_cate_create')->withErrors($validator)->withInput();;
        else:
            $cate = StickerCate::create([
                'title'=>$request->title,
                'amount'=>$request->amount,
            ]);
            if($cate) $request->session()->flash('success', __('Create complete!'));
            	else $request->session()->flash('error', __('Create errors!'));
            return redirect()->route('admin.sticker_cate_create');
        endif;
    }

    public function edit(Request $request, $id){
        $cate = StickerCate::findOrFail($id);
        $data = [
            'cate' => $cate,
        ];
        return view('backend.stickers.edit_cate',$data);
    }

    public function update(Request $request, $id){
        $rules = [
            'title'=>'required',
            'amount'=>'required',
        ];
        $messages = [
            'title.required'=>'Please enter title!',
            'amount.required'=>'Please enter cost of sticker package!',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()):
            return redirect()->route('admin.sticker_cate_edit',['id'=>$id])->withErrors($validator)->withInput();;
        else:
            $cate = StickerCate::findOrFail($id);
            if($cate){
                $cate->title = $request->title;
                $cate->amount = $request->amount;
                $cate->save();
                if($cate->wasChanged()) {
                    $request->session()->flash('success', __('Update complete!'));
                }
            }else $request->session()->flash('error', __('Update errors!'));
            return redirect()->route('admin.sticker_cate_edit',['id'=>$id]);
        endif;
    }

    public function delete(Request $request, $id){
        $cate = StickerCate::findOrFail($id);
        $request->session()->flash('success', 'Delete Successful!');
        $cate->delete();
        return redirect()->route('admin.sticker_cates');
    }

    public function deleteAll(Request $request){
        $message = 'error';
       	$items = explode(",",$request->items);
        if(count($items)>0){
            // $request->session()->flash('success', 'Delete Successful!');
            $message = 'success';
            StickerCate::destroy($items);
        }else $message = 'error';
        // }else $request->session()->flash('error', 'Has error!');
        return $message;
    }
}