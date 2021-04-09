<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\GroupMetas;
use App\Metas;
use App\Pages;

class GroupMetaController extends Controller
{
    public function index(){
        $groupMetas = GroupMetas::orderBy('updated_at', 'desc')->paginate(14);
        return view('backend.groupmeta.list',['groupMetas'=>$groupMetas]);
    }
    
    public function create(){
        $pages = Pages::all();  
        return view('backend.groupmeta.create',['pages'=>$pages]);
    }

    public function store(Request $request){        
        $msg = "error";
        if($request->ajax()){
            $groupMeta = new GroupMetas;
            $groupMeta->title = $request->title;
            $groupMeta->slug = $request->title;
            $groupMeta->post_id = $request->object;
            if($groupMeta->save()){
                $metas = json_decode($request->metas);
                foreach ($metas as $item) {
                    $meta = new Metas;
                    $meta->title = $item->title;
                    $meta->slug = $item->title; 
                    $meta->type = $item->type;
                    $meta->width = (int)$item->width;
                    $meta->groupmeta_id = $groupMeta->id;
                    $meta->save();
                }
            }
            $msg = 'success';
        }
        return 'error';
    }
    
    public function edit($id){
        $groupMeta = GroupMetas::find($id);
        $pages = Pages::all();
        $metas = Metas::where('groupmeta_id','=',$groupMeta->id)->get();
        return view('backend.groupmeta.edit',['groupMeta'=>$groupMeta, 'pages'=>$pages, 'metas'=>$metas ]);
    }

    public function update(Request $request, $id){
        $msg = "error";
        if($request->ajax()){
            $groupMeta = GroupMetas::find($id);
            $groupMeta->title = $request->title;
            $groupMeta->post_id = $request->object;
            if($groupMeta->save()){
                $editMetas = json_decode($request->editMetas);
                $addMetas = json_decode($request->addMetas);
                $del_items = json_decode($request->delItems);
                //delete recores
                if(count($del_items)>0){
                    Metas::destroy($del_items);
                }
                if(count($editMetas)>0):
                    foreach ($editMetas as $item) {   
                        $meta = Metas::find($item->id);
                        $meta->title = $item->title;   
                        $meta->type = $item->type;
                        $meta->width = (int)$item->width;
                        $meta->save();
                    }
                endif;  
                if(count($addMetas)>0):
                    foreach ($addMetas as $item) {
                        $meta = new Metas;
                        $meta->title = $item->title;  
                        $meta->type = $item->type;
                        $meta->width = (int)$item->width;
                        $meta->groupmeta_id = $id;
                        $meta->save();
                    }
                endif;
                $msg = "success";
            }
        }
        return $msg;
    }
    public function deleteMeta(Request $request){
        if($request->ajax()){
            $meta = Metas::find($request->id);
            $meta->delete();
            return 'success';
        }        
        return 'error'; 
    }

    public function delete($id){
        $groupMeta = GroupMetas::findOrFail($id);
        $meta_ids = Metas::where('groupmeta_id','=',$groupMeta->id)->delete();
        $groupMeta->delete();
        return redirect()->route('metas')->with('success','Xóa thành công');
    }
}
