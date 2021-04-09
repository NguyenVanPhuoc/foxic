<?php
namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;
use Validator, Input, Redirect; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\UserMetas;
use App\Media;
use Carbon\Carbon;
use App\Notice;
use App\Notifications\DataNotifications;

class UserController extends Controller
{
    public function username()  {
        return 'username';
    }
    public function getLogin() {
        return view('user.login');
    }
    public function postLogin(Request $request){
        if(Auth::attempt(['email'=>$request->username,'password'=>$request->password])){
            $user = Auth::User();
            if ($user->deactivate != 1) {
                if(isset($request->link)){
                    return redirect()->away($request->link);
                }elseif($user->hasRole(['BQT', 'Tác giả', 'Kiểm duyệt viên'])) {
                    return redirect()->route('indexAdmin');
                }else{
                    //diem danh + xu
                    $mytime = Carbon::now()->format('Y-m-d');
                    $muster = getUserMeta($user->id, 'muster');
                    if($muster){
                        $value = Carbon::now()->format('Y-m-d');
                        UserMetas::where('id', $muster->id)->update(['value' =>$value]);
                        if($muster->value != $mytime){
                            $xu= $user->coin + 2;
                            User::where('id', $user->id)->update(['coin' =>$xu]);
                            $request->session()->flash('modal_show', 'Chúc mừng ! Bạn đã hoàn thành nhiệm vụ +2 xu.');
                        }      
                    }else{
                        $value = Carbon::now()->format('Y-m-d');
                        UserMetas::create([
                            'user_id' => $user->id,
                            'meta_key' => 'muster',
                            'value' => $value,
                        ]);
                        $xu= $user->coin + 2;
                        User::where('id', $user->id)->update(['coin' =>$xu]);
                        $request->session()->flash('modal_show', 'Chúc mừng ! Bạn đã hoàn thành nhiệm vụ +2 xu.');
                    }
                    //end diem danh
                    return redirect()->route('home');
                } 
            }else{
                Auth::logout();
                $request->session()->flash('error', 'Đăng nhập thất bại');
            }
        }else{
            $request->session()->flash('error', 'Đăng nhập thất bại');
        }
        return redirect()->route('storeLoginCustomer');
    }
    public function getRegister() {
        return view('user.register');
    }
    public function postRegister(Request $request) {
        $rules = [
            'username'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:3|max:32',
            'confirmPassword'=>'required|same:password',
        ];
        $messages = [
            'username.required'=>'Vui lòng nhập Username',
            'email.required'=>'Vui lòng nhập Email',
            'email.email'=>"Email không đúng định dạng(ví dụ: lqviet.it@gmail.com)",
            'email.unique'=>'Email đã tồn tại',
            'password.required'=>'Bạn chưa nhập mật khẩu',
    		'password.min'=>'Mật khẩu ít nhất 3 kí tự',
    		'password.max'=>'Mật khẩu tối đa 32 kí tự',
    		'confirmPassword.required'=>'Bạn chưa nhập lại mật khẩu',
    		'confirmPassword.same'=>'Mật khẩu nhập lại chưa khớp'
        ];  
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()){
            $user = new User;
            $user->name = $request->username;
            $user->slug = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            if($request->role!=null) {
                $user->assignRole($request->role); 
            }else{
                $user->assignRole(5); 
            }
            if($user->save()){
                $role_id = $user->roles->first()->id;
                $notices = Notice::whereRaw('json_contains(role, \'["' . $role_id . '"]\')')->whereIn('type', ['1','3'])->get();
                foreach ($notices as $key => $notice) {
                    $user->notify(new DataNotifications($notice));
                }
                $content = '<ul>';
                $content .= '<li>Họ & tên: '.$request->username.'</li>';
                $content .= '<li>Email: '.$request->email.'</li>';
                $content .= '</ul>';
                $data = array( 'email' => $request->email, 'name' => $request->username, 'from' => $request->email , 'message'=> $content);
                //mail admin
                Mail::send( 'mails.admin.register', compact('data'), function( $message ) use ($data)
                {
                    $message->to( mailSystem() )
                            ->from( $data['email'], $data['name'])
                            ->subject('[Đăng ký thành viên] - '.$data['name']);
                });

                //mail to user
                $content_user = 'Bạn đã đăng ký thành công tài khoản tại<strong>'.nameCompany().'<strong>';
                $data_user = array( 'email' => $request->email, 'name' => $request->username, 'from' => $request->email , 'message'=> $content_user);

                Mail::send( 'mails.register', compact('data_user'), function( $message ) use ($data_user)
                {
                    $message->to( $data_user['email'] )
                            ->from( mailSystem() )
                            ->subject('[Thông báo] - '.nameCompany());
                });

            }
            $request->session()->flash('success', 'Đăng ký thành công');
            return redirect()->route('storeLoginCustomer');
        }else{
           $request->session()->flash('error', 'Đăng ký thất bại');
            return redirect()->route('storeRegisterCustomer');
        }
    }
    public function musterUser(Request $request) {
        $check = 0;
        if(Auth::check()){
            $mytime = Carbon::now()->format('Y-m-d');
            $user = Auth::user(); 
            $muster = getUserMeta($user->id, 'muster');
            if($muster) {
                $value = Carbon::now()->format('Y-m-d');
                UserMetas::where('id', $muster->id)->update(['value' =>$value]);
                if($muster->value != $mytime){
                    $xu= $user->coin + 2;
                    User::where('id', $user->id)->update(['coin' =>$xu]);
                    $check = 1;
                }      
            }else {
                $value = Carbon::now()->format('Y-m-d');
                UserMetas::create([
                    'user_id' => $user->id,
                    'meta_key' => 'muster',
                    'value' => $value,
                ]);
                $xu= $user->coin + 2;
                User::where('id', $user->id)->update(['coin' =>$xu]);
                $check = 1;
            } 
        }
        return response()->json(['check' => $check, 'link' => '']);
    }
}