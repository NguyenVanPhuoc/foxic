<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\User;
use Spatie\Permission\Models\Role;
use App\Media;
use App\UserMetas;
use App\Level;

class UserController extends Controller
{
    public function index(Request $request){
        $role = $request->role;
        $s = $request->s;
        if($role!="" && $s!=""):
            $users = User::role($role)->where('name','like','%'.$s.'%')->latest()->paginate(14);
        elseif($role!="" && $s==""):
            $users = User::role($role)->latest()->paginate(14);
        elseif($s!="" && $role==""):
            $users = User::where('name','like','%'.$s.'%')->latest()->paginate(14);
        else:
            $users = User::latest()->paginate(14);
        endif;
    	return view('backend.user.list',['users'=>$users,'role'=>$role,'s'=>$s]);
    }

   //add user
    public function create(){
        $roles= Role::select('id','name')->get();
        $levels = Level::get();
        $data=[];
        $data['roles']=$roles;
        $data['levels']=$levels;
    	return view('backend.user.create', $data);
    }

    public function store(Request $request){
        User::stripXSS();
    	$this->validate($request,[
    		'name'=>'required',
            'email'=>'required|email|unique:users,email',
    		'phone'=>'required|unique:users,phone',
    		'password'=>'required|min:3|max:32',
            'confirmPassword'=>'required|same:password',
    		'role'=>'required',
            'amount'=>'numeric',
    	],[
    		'name.required'=>'Bạn chưa nhập họ & tên',
    		'email.required'=>'Bạn chưa nhập email',
    		'email.email'=>'Email không đúng định dạng(ví dụ: lqviet.it@gmail.com)',
            'email.unique'=>'Email đã tồn tại',
            'phone.required'=>'Nhập số điện thoại',
    		'phone.unique'=>'Số điện thoại đã tồn tại',
    		'password.required'=>'Bạn chưa nhập mật khẩu',
    		'password.min'=>'Mật khẩu ít nhất 3 kí tự',
    		'password.max'=>'Mật khẩu tối đa 32 kí tự',
    		'confirmPassword.required'=>'Bạn chưa nhập lại mật khẩu',
            'confirmPassword.same'=>'Mật khẩu nhập lại chưa khớp',
    		'role'=>'Vui lòng chọn vai trò.',
            'amount.numeric'=>'Số điểm phải là số.',
    	]);        
    	$user = new User;
        $user->name = $request->name;
    	$user->slug = $request->name;
    	$user->phone = $request->phone;
    	$user->email = $request->email;
        if($request->sex!="") $user->sex = $request->sex;    	
    	$user->password = bcrypt($request->password);
        $user->level_id = isset($request->levels) ? $request->levels : NULL;
        if($request->image!="") $user->image = $request->image;
        $user->assignRole($request->role);
        $user->type_author = $request->type_author;
    	if($user->save()){
            if($request->amount){updateAmount($user->id, $request->amount);}            
        }
    	$request->session()->flash('success', 'Thêm thành công');
        $levels = Level::get();
    	return view('backend.user.create',['levels'=>$levels]);
    }

    //edit user
    public function edit($id){
    	$user = User::find($id);
        $levels = Level::get();
        $roles= Role::select('id','name')->get();
        $name_role= $user->getRoleNames();
        $data = [];  
        $data ['user'] = $user;
        $data ['levels'] = $levels;
        $data ['roles'] = $roles;
        $data ['name_role'] = $name_role;
        if($user)
    	   return view('backend.user.edit',$data);
        return redirect()->route('users');
    }

    public function update(Request $request, $id){
        User::stripXSS();
    	$this->validate($request,[
            'name'=>'required',
            'sex'=>'required',
            'role'=>'required',
            'phone'=>'required',
    	],[
            'name.required'=>'Vui lòng nhập họ & tên.',
            'sex.required'=>'Vui lòng chọn giới tính.',
            'role.required'=>'Vui lòng chọn vai trò.',
            'phone.required'=>'Vui lòng nhập số điện thoại.',
    	]);
    	$user = User::find($id);
    	$user->name = $request->name;
    	$user->phone = $request->phone;    	
        $user->sex = $request->sex;
    	if(Auth::user()->hasRole('BQT')){
            $user->syncRoles($request->role);
        }
        // return $request->levels;
        $user->level_id = isset($request->levels) && $request->levels!= '' ? $request->levels : NULL;
        $user->type_author = $request->type_author;
    	if($request->changePassword=="on"){
    		$this->validate($request,[
	    		'password'=>'required|min:3|max:32',
	    		'confirmPassword'=>'required|same:password'
	    	],[
	    		'password.required'=>'Bạn chưa nhập mật khẩu',
	    		'password.min'=>'Mật khẩu ít nhất 3 kí tự',
	    		'password.max'=>'Mật khẩu tối đa 32 kí tự',
	    		'confirmPassword.required'=>'Bạn chưa nhập lại mật khẩu',
	    		'confirmPassword.same'=>'Mật khẩu nhập lại chưa khớp'
	    	]);
			$user->password = bcrypt($request->password);
    	}                
        if($request->image!="") $user->image = $request->image;
        if(Auth::user()->hasRole('BQT')){
            $user->syncRoles($request->role);
        }
        if($user->save()){
            $content = array();
            $content['name'] = $request->Username;
            $content['numberPhone'] = $request->Numberphone;
            $content['nameBank'] = $request->Namebank;
            $id_user = UserMetas::firstOrCreate(['meta_key'=>'bankinfo', 'user_id'=>$user->id]);
            $value = UserMetas::where('id',$id_user->id)->update(['value'=>json_encode($content, JSON_UNESCAPED_UNICODE)]);
        }
    	return redirect()->route('editAdmin',['id'=>$user->id])->with('success', 'Sửa thành công');
    }

    public function media(Request $request){
        if($request->ajax()){
            $html = media();
            return json_encode($html);
        }
        return 'error';
    }
    //delete user
    public function delete($id){
    	$user = User::find($id);
    	$user->delete();
    	return redirect()->route('users')->with('success','Xóa thành công');
    }
    //deleteAll
    public function deleteAll(Request $resquest){        
        $message = "error";
        $user = Auth::User();
        if($user->hasRole('BQT') && $resquest->ajax()){
            $items = json_decode($resquest->items);
            if(count($items)>0){
                User::destroy($items);
            }
            $message = "success";
        }
        return $message;
    }
    //edit user
    public function editUser(){
        $user = Auth::user();
        $data = [];  
        $data ['user'] = $user;
        return view('backend.user.edit_user',$data);
    }
    public function updateUser(Request $request, $id){
        User::stripXSS();
        $this->validate($request,[
            'name'=>'required',
            'sex'=>'required',
        ],[
            'name.required'=>'Vui lòng nhập họ & tên.',
            'sex.required'=>'Vui lòng chọn giới tính.',
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->phone = $request->phone;     
        $user->sex = $request->sex;
        if($request->image!="") $user->image = $request->image;
        if($request->changePassword=="on"){
            $this->validate($request,[
                'password'=>'required|min:3|max:32',
                'confirmPassword'=>'required|same:password'
            ],[
                'password.required'=>'Bạn chưa nhập mật khẩu',
                'password.min'=>'Mật khẩu ít nhất 3 kí tự',
                'password.max'=>'Mật khẩu tối đa 32 kí tự',
                'confirmPassword.required'=>'Bạn chưa nhập lại mật khẩu',
                'confirmPassword.same'=>'Mật khẩu nhập lại chưa khớp'
            ]);
            $user->password = bcrypt($request->password);
        }                
        if($user->save()){
            $content = array();
            $content['name'] = $request->Username;
            $content['numberPhone'] = $request->Numberphone;
            $content['nameBank'] = $request->Namebank;
            $id_user = UserMetas::firstOrCreate(['meta_key'=>'bankinfo', 'user_id'=>$user->id]);
            $value = UserMetas::where('id',$id_user->id)->update(['value'=>json_encode($content, JSON_UNESCAPED_UNICODE)]);
        }
        return redirect()->route('user')->with('success', 'Sửa thành công');
    }
}
