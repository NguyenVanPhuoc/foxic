<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, Input, Redirect; 
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserMetas;
use App\Media;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\CatMeta;
use App\Orders;
use App\OrderDetails;
use DateTime;

class AuthenticationController extends Controller
{
    public function logout(){
        Auth::logout();
        return redirect(url('/'));
    }
    
    public function login(Request $request){
        if($request->key == tokenApi()):
            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
                $user = Auth::User();
                $data = array();
                return response()->json([
                    'status'=> 200,             
                    'data'=> $user->remember_token,
                    'msg'=>'OK'
                ]);
            }else{
                return response()->json([
                    'status'=> 404,
                    'msg'=>'error'
                ]);
            }
        else:
            return response()->json([
                'status'=> 500,
                'msg'=>'access denied'
            ]);
        endif;
    }     
    public function register(Request $request){
        if($request->key == tokenApi()):
            $data = array();       
            $data['email'] =  $request->email;            
            $validator = Validator::make($data,[                
                'email' => 'unique:users,email'
            ],[ 
                'email.unique'=>'Email đã tồn tại.',
            ]);
            if ($validator->passes()){
                $user = new User;
                $user->name = $request->name;
                $user->slug = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->remember_token = str_random(40).time();
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
                    $content_user = 'Bạn vừa đăng ký tài khoản thành công tại <strong>'.nameCompany().'<strong>';
                    $data_user = array( 'email' => $request->email, 'name' => $request->name, 'from' => $request->email , 'message'=> $content_user);
                    Mail::send( 'mails.register', compact('data_user'), function( $message ) use ($data_user)
                    {
                        $message->to( $data_user['email'] )
                                ->from( mailSystem() )
                                ->subject('[Thông báo] - '.nameCompany());
                    });
                    return response()->json([
                        'status'=> 200,             
                        'data'=> 'success',
                        'msg'=>'OK'
                    ]);
                }
                return response()->json([
                    'status'=> 500,
                    'msg'=>'system error'
                ]);
            }else{
               return response()->json([
                    'status'=> 404,
                    'msg'=>'validate error'
                ]);
            }
        else:
            return response()->json([
                'status'=> 500,
                'msg'=>'access denied'
            ]);
        endif;   
    }
    
    public function postResetPassword(Request $request){
        $this->validate($request,[
            'phone'=>'required',
            ],[
            'phone.required'=>'Vui lòng số điện thoại hoặc email'
            ]);
        $message = "<div class='alert alert-success'>Khôi phục thành công, mật khẩu mới đã chuyển vào email của bạn.</div>";
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
            $message = "<div class='alert alert-success'>Khôi phục thành công, mật khẩu mới đã chuyển vào email của bạn.</div>";
        }else{
            $message = "<div class='alert alert-danger'>Số điện thoại hoặc email <strong>".$request->phone."</strong> không tồn tại trong hệ thống.</div>";
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
            'oldPass.required'=>'Bạn chưa nhập mật khẩu cũ.',
            'newPass.required'=>'Bạn chưa nhập mật khẩu mới.',
            'confirmPass.required'=>'Bạn chưa nhập lại mật khẩu.',
        ]);
        $user = Auth::User();
        $checkPass = password_verify($request->oldPass, $user->password);
        if($checkPass){
            $user->password = bcrypt($request->newPass);
            $user->save();
            $request->session()->flash('success','Đổi mật khẩu thành công.');
        }else{            
            $request->session()->flash('error','Mật khẩu cũ không đúng.');
        }
        return redirect('/profile/password');
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
        $this->validate($request,[
            'name'=>'required',
            'sex'=>'required',
            ],[
            'name.required'=>'Bạn chưa nhập họ & tên',
            'sex.required'=>'Bạn chưa chọn giới tính'
        ]);
        $user = Auth::User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->sex = $request->sex;
        $user->address = $request->address;
        if($user->save()){
            $userMeta = UserMetas::where('user_id',$user->id)->first();
            if(empty($userMeta)){
                $userMeta = new UserMetas;
                $userMeta->user_id = $user->id;
            }
            $userMeta->about = $request->about;
            $userMeta->save();
        }
        $request->session()->flash('success', '<div class="alert alert-success">Cập nhật thành công</div>');
        return redirect('/profile/edit');        
    }    
    //media account
    public function mediaProfile(){
        $user = Auth::User();
        $media = Media::where('user_id',$user->id)->latest()->paginate(14);
        return view('members.media',['media'=>$media]);
    }    
    /*
    * retake password
    */
    public function forgotPassword(){
        return view('forgotPassword');
    }

    public function postForgotPassword(Request $request){
        $user = User::where('email', $request->email)->first();
        if($user){
            $otp = get_Otp();
            $user->otp = $otp;
            $user->save(); 
            $content = 'Mã xác thực của bạn là: <strong>'.$otp.'</strong>';
            $data = array( 'email' => $request->email, 'name' => $user->name, 'from' => 'lqviet.it@gmail.com', 'address'=>address(), 'content'=> $content);
            Mail::send( 'mails.sendOtp', compact('data'), function( $message ) use ($data)
            {
                $message->to( $data['email'] )
                        ->from( $data['from'], nameCompany() )
                        ->subject( 'Quên mật khẩu' );
            });
            $request->session()->flash('notify', array('status'=>'true', 'email'=>$request->email));
            return redirect('check-otp');
        }
        else{
            $request->session()->flash('notify', 'Email không tồn tại trong hệ thống.');
            return redirect('forgot-password');
        }

    }
    public function retakePassword(){
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
            return redirect()->route('retakePassword')->with('success',array('msg'=>'Đổi mật khẩu thành công!', 'email'=>$request->email));
        }
        else{
            $request->session()->flash('error', array('msg'=>'Xác nhận mật khẩu không khớp!', 'email'=>$request->email));
            return redirect()->route('retakePassword');
        }
        
    }

    //order
    public function order(Request $request){
        $date_from = $date_to = '';
        $arraySend =  array();
        $arraySend['date_from'] = $date_from;
        $arraySend['date_to'] = $date_to;

        if(isset($request->date_from) && $request->date_from !='')
            $date_from = DateTime::createFromFormat('d-m-Y', $request->date_from); 
            
        if(isset($request->date_to)) 
            $date_to = DateTime::createFromFormat('d-m-Y', $_GET['date_to']);
        
        $user = Auth::User();
        $orders = Orders::where('user_id', $user->id);
        

        if($date_from != ''){
            $orders = $orders->where('created_at', '>=', date_format($date_from, 'Y-m-d'));
            $arraySend['date_from'] = date_format($date_from, 'd-m-Y');
        }
            
        if($date_to != ''){
            $orders = $orders->where('created_at', '<=', date_format($date_to, 'Y-m-d'));
            $arraySend['date_to'] = date_format($date_to, 'd-m-Y');
        }
        $orders = $orders->latest()->paginate(15);

        $arraySend['user'] = $user;
        $arraySend['orders'] = $orders;
    
        return view('members.order', $arraySend);
    }

    public function orderDetail($code){
        $user = Auth::User();
        $order = Orders::where('code', $code)->first();
        $details = OrderDetails::join('products', 'order_details.product_id', '=', 'products.id')
                                    ->where('order_details.order_id', $order->id)
                                    ->select('order_details.qty', 'order_details.product_id', 'products.title','products.price_sale', 'products.image')
                                    ->get();
        return view('members.order_detail', ['user'=>$user, 'order'=>$order, 'details'=>$details]);
    }
}