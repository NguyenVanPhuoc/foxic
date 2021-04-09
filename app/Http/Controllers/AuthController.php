<?php
namespace App\Http\Controllers;
use Validator, Input, Redirect; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use App\UserMetas;
use App\Media;
use App\Payment;
use App\CategoryPayment;
use App\BuyChap;
use App\RentChap;
use App\Action;
use App\Chap;
use App\Comic;
use App\ChangeVote;
use Carbon\Carbon;
use DateTime;


class AuthController extends Controller
{
    public function login(Request $request){
        if(Auth::check()){
            $user = Auth::user();
            if($user->hasRole(['BQT', 'Tác giả', 'Kiểm duyệt viên']))
                return redirect()->route('indexAdmin');
            else
                return redirect()->route('home');
        }else{
            return view('login');
        }        
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
    public function postLogin(Request $request){
        if($request->ajax()){
            if(Auth::attempt(['email'=>$request->email,'password'=>$request->pass])){
                $user = Auth::User();
                if ($user->deactivate != 1) {
                    if($user->hasRole(['BQT', 'Tác giả', 'Kiểm duyệt viên'])) $url = route('indexAdmin');
                    else $url = route('home');
                    return response()->json(['message'=>'success','url'=>$url]);
                }else{
                    Auth::logout();
                    return response()->json(['message'=>'error']);
                }
            }else{
                return response()->json(['message'=>'error']);
            }
        }
    }
    public function register(){
        if(Auth::check()){
            return redirect()->route('home');
        }
        return view('register');
    }
    public function postRegister(Request $request){
        User::stripXSS();
        if($request->ajax()):
            $data = array();
            $data['_token'] = $request->token;
            $data['captcha'] =  $request->captcha;
            $data['email'] =  $request->email;
            $validator = Validator::make($data,[
                'captcha' => 'captcha',
                'email' => 'unique:users,email'
            ],[ 
                'captcha.captcha'=>'Captcha is not correct, please try another captcha!',
                'email.unique'=>'Email already exists!',
            ]);
            if ($validator->passes()){
                $user = new User;
                $user->name = $request->name;
                $user->slug = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->pass);
                $user->level = 'member'; 
                if($user->save()){
                    $content = '<ul>';
                    $content .= '<li>Họ & tên: '.$request->name.'</li>';
                    $content .= '<li>Email: '.$request->email.'</li>';
                    $content .= '</ul>';
                    $data = array( 'email' => $request->email, 'name' => $request->name, 'from' => $request->email , 'message'=> $content);

                    Mail::send( 'mails.admin.register', compact('data'), function( $message ) use ($data)
                    {
                        $message->to( mailSystem() )
                                ->from( $data['email'], $data['name'])
                                ->subject('[Đăng ký thành viên] - '.$data['name']);
                    });

                    //mail to user
                    $content_user = 'You have successfully registered an account at <strong>'.nameCompany().'<strong>';
                    $data_user = array( 'email' => $request->email, 'name' => $request->name, 'from' => $request->email , 'message'=> $content_user);

                    Mail::send( 'mails.register', compact('data_user'), function( $message ) use ($data_user)
                    {
                        $message->to( $data_user['email'] )
                                ->from( mailSystem() )
                                ->subject('[Thông báo] - '.nameCompany());
                    });
                }
                return response()->json(['message'=>'success']);
            }else{
               return response()->json(['message'=>'error','error'=>$validator->errors()->all()]);
            }
        endif;
    }
    
    public function postResetPassword(Request $request){
        $this->validate($request,[
            'phone'=>'required',
            ],[
            'phone.required'=>'Vui lòng số điện thoại hoặc email'
            ]);
        $message = "<div class='alert alert-success'>Successfully restored, the new password has been transferred to your email.</div>";
        $phone = trim($request->phone);
        $password = get_Otp();
        if(is_numeric($phone))
            $user = User::where("phone",$request->phone)->first();
        else
            $user = User::where("email",$request->phone)->first();
        
        if($user != NULL){
            $user->password = bcrypt($password);
            $user->save();
            $content = "Mật khẩu mới của bạn: ".$password;
            $data = array( 'email' => $user->email, 'name' => $user->name, 'from' => mailSystem(), 'address'=>address(), 'content'=> $content);
            Mail::send( 'mails.reset_password', compact('data'), function( $message ) use ($data)
            {
                $message->to( $data['email'] )
                        ->from( $data['from'], $data['name'] )
                        ->subject( 'Phục hồi mật khẩu' );
            });
            $message = "<div class='alert alert-success'>Successfully restored, the new password has been transferred to your email.</div>";
        }else{
            $message = "<div class='alert alert-danger'>Phone number or email <strong>".$request->phone."</strong> does not exist in the system.</div>";
        }
        
        return redirect('/reset')->with(['message'=>$message]); 
    }
    //change password
    public function editPassword(){
        $user = Auth::User();
        return view('members.password',['user'=>$user]);
    }    
    public function updatePassword(Request $request){
        $this->validate($request,[
            'oldPass'=>'required',
            'newPass'=>'required',
            'confirmPass'=>'required',
            ],[
            'oldPass.required'=>'You have not entered the old password!',
            'newPass.required'=>'You have not entered a new password!',
            'confirmPass.required'=>'You have not re-entered the password!',
        ]);
        $user = Auth::User();
        $checkPass = password_verify($request->oldPass, $user->password);
        if($checkPass){
            $user->password = bcrypt($request->newPass);
            $user->save();
            $request->session()->flash('success','Change password successfully!');
        }else{            
            $request->session()->flash('error','Old password is not correct!');
        }
        return redirect()->route('editPassword');
    }
    public function profile(){
        $user = Auth::User();
        return view('members.profile',['user'=>$user]);
    }
    public function editAccount(){
        $user = Auth::User();
        return view('members.profile_edit',['user'=>$user]);
    }
    public function updateAccount(Request $request){
        User::stripXSS();
        $this->validate($request,[
            'name'=>'required',
            'sex'=>'required',
            'birthday'=>'required',
            'address'=>'required'
            ],[
            'name.required'=>'Bạn chưa nhập họ & tên',
            'sex.required'=>'Bạn chưa chọn giới tính!',
            'birthday.required'=>'Bạn chưa nhập ngày sinh!',
            'address.required'=>'Bạn chưa nhập địa chỉ!'
        ]);
        $user = Auth::User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->birthday = $request->birthday;
        $user->sex = $request->sex;
        $user->address = $request->address;
        $user->introduce = $request->introduce;
        $user->save();
        $request->session()->flash('success', '<div class="alert alert-success">Cập nhật thành công</div>');
        return redirect()->route('editProfile');
    } 
    /*
    * retake password
    */
    public function forgotPassword(){
        return view('forgotPassword');
    }
    // public function postForgotPassword(Request $request){
    //     $user = User::where('email', $request->email)->first();
    //     if($user){
    //         $otp = get_Otp();
    //         $user->otp = $otp;
    //         $user->save(); 
    //         $content = 'Your authentication code is: <strong>'.$otp.'</strong>';
    //         $data = array( 'email' => $request->email, 'name' => $user->name, 'from' => 'lqviet.it@gmail.com', 'address'=>address(), 'content'=> $content);
    //         Mail::send( 'mails.sendOtp', compact('data'), function( $message ) use ($data)
    //         {
    //             $message->to( $data['email'] )
    //                     ->from( $data['from'], nameCompany() )
    //                     ->subject( 'Quên mật khẩu' );
    //         });
    //         $request->session()->flash('notify', array('status'=>'true', 'email'=>$request->email));
    //         return redirect('check-otp');
    //     }
    //     else{
    //         $request->session()->flash('notify', 'Email does not exist in the system!');
    //         return redirect('forgot-password');
    //     }

    // }
    public function postForgotPassword(Request $request){
        $this->validate($request,[
            'email'=>'required',
            ],[
            'email.required'=>'Vui lòng nhập email của bạn'
            ]);
        $message = "<div class='alert alert-success'>Khôi phục thành công, mật khẩu mới đã chuyển vào email của bạn.</div>";
        $password = Str::random(10);
        $user = User::where("email",$request->email)->first();
        if($user != NULL){
            $user->password = bcrypt($password);
            $user->save();
            $content = "Mật khẩu mới của bạn: ".$password;            
            $data = array( 'email' => $user->email, 'name' => $user->name, 'from' => mailSystem(), 'content'=> $content);
            Mail::send( 'mails.reset_password', compact('data'), function( $message ) use ($data)
            {
                $message->to( $data['email'] )
                        ->from( $data['from'], $data['name'] )
                        ->subject( 'Phục hồi mật khẩu' );
            });
            $message = "<div class='alert alert-success'>Khôi phục thành công, mật khẩu mới đã chuyển vào email của bạn.</div>";
        }else{
            $message = "<div class='alert alert-danger'>Email <strong>".$request->email."</strong> không tồn tại trong hệ thống.</div>";
        }
        return redirect()->route('storeLoginCustomer')->with(['message'=>$message]); 
    }
    public function addCoin(){
        $user = Auth::User();
        $cate = CategoryPayment::orderBy('created_at','asc')->get();
        $data = [];
        $data['user'] = $user;
        $data['cate'] = $cate;
        return view('members.add_coin',$data);
    }
     public function historyCoin(){
        $user = Auth::User();
        return view('members.history_coin',['user'=>$user]);
    }
     public function historyPoint(){
        $user = Auth::User();
        return view('members.history_point',['user'=>$user]);
    }
    public function historyChap(){
        $user = Auth::User();
        $list_history = UserMetas::where('user_id', $user->id)->where('meta_key', 'chap_history')->first();
        $data = [];
        $data['user'] = $user;
        $data['list_history'] = $list_history;
        return view('members.history_chap',$data);
    }
    public function buyChaps(){
        $user = Auth::User();
        $list_buy = Action::where('user_id', $user->id)->where('type', 'buy')->pluck('chap_id')->toArray();
        $chap_query = function ($query) use ($list_buy) {
            return $query->whereIn('chaps.id',$list_buy);
        };
        $comics = Comic::with(['chaps'=>$chap_query])
                    ->whereHas('chaps', $chap_query)->get(); 
        $data = [];
        $data['list_buy'] = $list_buy;
        $data['comics'] = $comics;
        return view('members.buy_chap',$data);
    }
    public function rentalChaps(){
        $user = Auth::User();
        $list_rental = Action::where('user_id', $user->id)->where('type','rental')->pluck('chap_id')->toArray();
        $chap_query = function ($query) use ($list_rental) {
            return $query->whereIn('chaps.id',$list_rental);
        };
        $comics = Comic::with(['chaps'=>$chap_query])
                    ->whereHas('chaps', $chap_query)->get(); 
        $data = [];
        $data['list_rental'] = $list_rental;
        $data['comics'] = $comics;
        return view('members.rental_chap',$data);
    }
    public function changeVotes(){
        $list_xu = ChangeVote::where('choose_point',0)->orderBy('created_at','asc')->get();
        $list_point = ChangeVote::where('choose_point',1)->orderBy('created_at','asc')->get();
        $data['list_xu'] = $list_xu;
        $data['list_point'] = $list_point;
        return view('members.change_votes',$data);
    }
    public function changeVoteXu(Request $request){
        $id = $request->id;
        if(Auth::check()) {
            $user = Auth::user(); 
            $votes = ChangeVote::find($id);
            $rental = $user->rental + $votes->vote;
            $html='';
            if($user->coin >= $votes->amount){
                $xu = $user->coin - $votes->amount;
                User::where('id', $user->id)->update(['rental' => $rental, 'coin' => $xu]); 
                $html .='<div class="alert alert-success"> Đổi phiếu thành công !!!</div>';
                return response()->json(['msg' => 'success', 'html' => $html]);
            }else{
                $html .='<div class="alert alert-danger"> Đổi phiếu thất bại. Vui lòng nạp thêm xu !!! </div>';
                return response()->json(['msg' => 'error', 'html' => $html]);
            }
        }
    }
    public function changeVotePoint(Request $request){
        $id = $request->id;
        if(Auth::check()) {
            $user = Auth::user(); 
            $votes = ChangeVote::find($id);
            $rental = $user->rental + $votes->vote;
            $html='';
            if($user->point >= $votes->amount){
                $point = $user->point - $votes->amount;
                User::where('id', $user->id)->update(['rental' => $rental, 'point' => $point]); 
                $html .='<div class="alert alert-success"> Đổi phiếu thành công !!!</div>';
                return response()->json(['msg' => 'success', 'html' => $html]);
            }else{
                $html .='<div class="alert alert-danger"> Đổi phiếu thất bại. Vui lòng nạp thêm point !!! </div>';
                return response()->json(['msg' => 'error', 'html' => $html]);
            }
        }
    }
    /*public function retakePassword(){
        return view('retakePassword');
    }

    public function postRetakePassword(Request $request){
        $email = $request->email;
        $password = $request->password;
        $re_password = $request->re_password;
        if($password == $re_password){
            $user = User::where('email', $email)->first();
            $user->password = Hash::make($password);
            $user->save(); 
            return redirect()->route('retakePassword')->with('success',array('msg'=>'Change password successfully!', 'email'=>$request->email));
        }
        else{
            $request->session()->flash('error', array('msg'=>'The password entered does not match!', 'email'=>$request->email));
            return redirect()->route('retakePassword');
        }
        
    }*/
    
}