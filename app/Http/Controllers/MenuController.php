<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Menu;
use App\MenuMetas;
use App\User;
use App\Pages;
use App\ArticleCat;
use App\Article;

class MenuController extends Controller
{
	public function index(){
		$menus = Menu::latest()->paginate(5);
		return view('backend.menu.list',['menus'=>$menus]);
	}
	
	public function store(){
        return view('backend.menu.create');
    }	
	public function edit($id){
		$menu = Menu::find($id);
		return view('backend.menu.edit',['menu'=>$menu]);
	}
	
	public function create(Request $request){
        $user = Auth::User();
        $message = "error";
        $menu = new Menu;
        $menu->title = $request->title;
        $menu->slug = $request->title;                
        if($menu->save()):
            $metas = json_decode($request->metas);
            foreach ($metas as $item):
                $type = explode("#", $item->type);
                $menu_meta = new MenuMetas;                
                $menu_meta->title = $item->title;
                $menu_meta->slug = $item->title;
                $menu_meta->value = $item->value;
                $menu_meta->type = $type[1];
                $menu_meta->position = $item->position;
                $menu_meta->menu_id = $menu->id;
                $menu_meta->user_id = $user->id;
                $menu_meta->parent = 0;
                $menu_meta->save();
            endforeach;
            $message = "success";                   
        endif;
        return $message;
    }
    public function update(Request $request, $id){
		$user = Auth::User();
		$message = "error";
    	$menu = Menu::find($id);
        $menu->title = $request->title;
        $menu->slug = $request->title;
        if($menu->save()):
            $meta = json_decode($request->meta);
            $old_metas = json_decode($request->old_metas);
            $new_metas = json_decode($request->new_metas);
        	$del_items = json_decode($request->delItems);
            //delete recores
            if($del_items != null && count($request->delItems)>0){
                MenuMetas::destroy($del_items);
            }
            
            //update recores
            if(count($old_metas)>0){
                foreach ($old_metas as $item):
                    $type = explode("#", $item->type);
                    $menu_meta = MenuMetas::find($item->meta_id);
                    if($item->title != ""){
                        $menu_meta->title = $item->title;
                        $menu_meta->slug = $item->title;
                    }
                    else{
                        $menu_meta->title = "DSmart";
                        $menu_meta->slug = "dsmart";
                    }
                    if($item->target!="")
                        $menu_meta->target = $item->target;
                    else
                        $menu_meta->target = "_self";
                    $menu_meta->title_value = $item->title_value;
                    $menu_meta->value = $item->value;
                    $menu_meta->type = $type[1];
                    $menu_meta->position = $item->position;
                    $menu_meta->user_id = $user->id;
                    $menu_meta->save();
                endforeach;                
            }
            //new recores
    		if(count($new_metas)>0){
                foreach ($new_metas as $item):
                    $type = explode("#", $item->type);
                    $menu_meta = new MenuMetas;
                	if($item->title != ""){
                        $menu_meta->title = $item->title;
                        $menu_meta->slug = $item->title;
                    }
                    else{
                        $menu_meta->title = "DSmart";
                        $menu_meta->slug = "dsmart";
                    }
                    if($item->target!="")
                        $menu_meta->target = $item->target;
                    else
                        $menu_meta->target = "_self";
                    $menu_meta->title_value = $item->title_value;
                	$menu_meta->value = $item->value;
                	$menu_meta->type = $type[1];
                    $menu_meta->position = $item->position;
                	$menu_meta->menu_id = $menu->id;
                	$menu_meta->user_id = $user->id;
                	$menu_meta->parent = 0;
                	$menu_meta->save();
        		endforeach;                
            }            
    		$message = "success";                	
        endif;
		return $message;
	}
	public function loadType(Request $request){
		$html ='';
        switch ($request->type) {
                case '#blog':
                    $object = Article::orderBy('created_at','desc')->simplePaginate(5);
                    break;
                case '#category':
                    $object = ArticleCat::orderBy('position','asc')->simplePaginate(5);
                    break;
                case '#product':
                    $object = null;
                    break;                
                default:
                    $object = Pages::latest('created_at')->simplePaginate(5);
                    break;
        }
        return view('backend.menu.load', compact('object'));
	}
	//search
	public function search(Request $request){
		$html ='';
        switch ($request->type) {
                case '#blog':
                    $object = Article::latest('created_at')->where('title','like', '%'.$request->title.'%')->simplePaginate(5);
                    break;
                case '#category':
                    $object = ArticleCat::orderBy('position','asc')->where('title','like', '%'.$request->title.'%')->simplePaginate(5);
                    break;
                case '#product':
                    $object = null;
                    break;                 
                default:
                    $object = Pages::latest('created_at')->where('title','like', '%'.$request->title.'%')->simplePaginate(5);
                    break;
        }
        return view('backend.menu.load', compact('object'));
	}

    public function delete($id){
        $menu = Menu::find($id);
        $menu->delete();
        return redirect('/admin/menu')->with('success','Xóa menu thành công');
    }

    /**
     * sub menu
     */
    public function storeSubMenu($id){
        $menu = MenuMetas::find($id);
        return view('backend.menu.sub_menu',['menu'=>$menu]);
    }    
    public function createSubMenu(Request $request, $id){
        $user = Auth::User();
        $message = "error";
        if($request->ajax()):
            $menu = MenuMetas::find($id);
            $menu->title = $request->title;
            $menu->slug = $request->slug;
            if($menu->save()):
                $old_metas = json_decode($request->old_metas);
                $new_metas = json_decode($request->new_metas);
                $del_items = json_decode($request->delItems);

                //change parent value
                if(count($del_items)>0){
                    MenuMetas::destroy($del_items);
                }
                //update recores
                if(count($old_metas)>0){
                    foreach ($old_metas as $item):
                        $type = explode("#", $item->type);
                        $menu_meta = MenuMetas::find($item->meta_id);
                        if($item->title != ""){
                            $menu_meta->title = $item->title;
                            $menu_meta->slug = $item->title;
                        }
                        else{
                            $menu_meta->title = "DSmart";
                            $menu_meta->slug = "dsmart";
                        }
                        if($item->target!="")
                            $menu_meta->target = $item->target;
                        else
                            $menu_meta->target = "_self";
                        $menu_meta->title_value = $item->title_value;
                        $menu_meta->value = $item->value;
                        $menu_meta->type = $type[1];
                        $menu_meta->position = $item->position;
                        $menu_meta->user_id = $menu->user_id;
                        $menu_meta->save();
                    endforeach;                
                }
                if(count($new_metas)>0){
                    foreach ($new_metas as $item):
                        $menu_meta = new MenuMetas;
                        $type = explode("#", $item->type);
                        if($item->title != ""){
                            $menu_meta->title = $item->title;
                            $menu_meta->slug = $item->title;
                        }
                        else{
                            $menu_meta->title = "DSmart";
                            $menu_meta->slug = "dsmart";
                        }
                        if($item->target!="")
                            $menu_meta->target = $item->target;
                        else
                            $menu_meta->target = "_self";
                        $menu_meta->title_value = $item->title;
                        $menu_meta->value = $item->value;
                        $menu_meta->type = $type[1];
                        $menu_meta->parent = $id;
                        $menu_meta->position = $item->position;
                        $menu_meta->menu_id = $menu->menu_id;
                        $menu_meta->user_id = $menu->user_id;
                        $menu_meta->save();
                    endforeach;                
                }  
            endif;
        endif;
        return $message;
    }
}