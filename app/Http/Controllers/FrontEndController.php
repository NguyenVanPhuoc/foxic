<?php
namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use App\Events\DemoPusherEvent;

class FrontEndController extends Controller
{
	public function getPusher(){
     // gọi ra trang view demo-pusher.blade.php
		return view("demo-pusher");
	}
	public function fireEvent(){
     // Truyền message lên server Pusher		
		$message = '<div class="item">';
			$message .= '<h4>Khách hàng vừa book<strong>Hà Nội</strong></h4>';
			$message .= '<div class="info">';
			$message .= '<img src="http://taxi.developworld.com.vn/image/PXQr_1.png/150/88" alt="Maza 5">';
			$message .= '<ul>';
			$message .= '<li>Nội bài - Hà Nội</li>';
			$message .= '<li>Tên: Mỹ Duyên</li>';
			$message .= '<li>DT: 090xxx5882 - Giá:<strong>344.000 đ</strong></li>';
			$message .= '</ul>';
			$message .= '</div>';
		$message .= '</div>';		
		event(new DemoPusherEvent($message));
		return "Message has been sent.";
	}
}
