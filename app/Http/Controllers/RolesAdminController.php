<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\ParentRole;

class RolesAdminController extends Controller
{
    public function index(){
    	$roles = Role::orderBy('updated_at', 'desc')->paginate(14);
        return view('backend.role.list',['roles'=>$roles]);
    }
    
    public function create(){
        $data = [
            'permissions' => Permission::all()->sortBy('name')->groupBy('group'),
        ];
    	return view('backend.role.create',$data);
    }

    public function store(Request $request){
            $array_name=$request->permissions;
            $role = Role::create(['name' => $request->name]);
            $role->givePermissionTo($array_name);
            $request->session()->flash('success', 'Create success');
            return redirect()->route('storeRolesAdmin');
    }
    
    public function edit($id){
        $role = Role::findOrFail($id);
        $data = [
            'role' => $role,
            'permissions' => Permission::all()->sortBy('name')->groupBy('group'),
        ];
    	return view('backend.role.edit', $data);
    }

    public function update(Request $request, $id){
        $roles = Role::find($id);
        $roles->name = $request->name;
        $roles->save();
        $permissions=$request->permissions;
        //$permissions=Permission::whereIn('id',$ids)->get();
        $roles->syncPermissions($permissions);//edit
        $request->session()->flash('success', 'Edit success');
        return redirect()->route('editRolesAdmin',['id'=>$id]);
    }
    
	public function delete($id){
    	$roles = Role::find($id);
    	$roles->delete();
    	return redirect()->route('rolesAdmin')->with('success','Delete success');
    }

    //deleteAll
    public function deleteAll(Request $resquest){        
        $message = "error";
        $user = Auth::User();
        if($user->hasRole(['admin','editor','manager']) && $resquest->ajax()){
            $items = json_decode($resquest->items);
            if(count($items)>0){
                Role::destroy($items);
            }
            $message = "success";
        }
        return $message;
    }
}