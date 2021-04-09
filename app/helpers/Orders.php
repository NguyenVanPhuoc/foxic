<?php 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use App\User;
use App\UserMetas;
use App\Orders;
use App\OrderDetails;
use App\Carts;
use App\CartDetails;

//get status item of order
if(! function_exists('getStatusOrder')){
	function getStatusOrder($status){
		$text = '';
		$color = '';
		switch ($status) {

			case 'pending':
				$text = 'Chờ duyệt';
				$color = 'orange';
				break;
			case 'taking':
				$text = 'Đang lấy hàng';
				$color = 'blue';
				break;
			case 'delivering':
				$text = 'Đang giao hàng';
				$color = 'gray';
				break;
			case 'success':
				$text = 'Hoàn thành';
				$color = 'green';
				break;
			case 'cancel':
				$text = 'Hủy';
				$color = 'red';
				break;
			case 'fail':
				$text = 'GD thất bại';
				$color = 'red';
				break;
			default:
				break;
		}
		$html = '<span class="status '. $color .'">'. $text .'</span>';
		return $html;
	}
}

//get list option status order
if(!function_exists('getOptionStatusOrder')){
	function getOptionStatusOrder($select = ''){
		
		$array = array(
					array('status' => 'pending', 'text' => 'Chờ duyệt'),
					array('status' => 'taking', 'text' => 'Đang lấy hàng'),
					array('status' => 'delivering', 'text' => 'Đang giao hàng'),
					array('status' => 'success', 'text' => 'Hoàn thành'),
					array('status' => 'cancel', 'text' => 'Hủy')
				);
		$html = '';
		foreach($array as $item){
			$selected = '';
			if($select == $item['status']) $selected = 'selected';
			$html .= '<option value="'. $item['status'] .'" '. $selected .'>'.$item['text'].'</option>';
		}
		return $html;
	}
}

//creat order
if(!function_exists('createOrder')){
	function createOrder($name, $phone, $email, $address, $note, $payment){

		$user = Auth::User();
		$user_id = '';
		if(!$user){ //if user no login
            $cart_type = 'session'; 
            if(isset($_COOKIE['cart'])){
                $cookie = $_COOKIE['cart'];
                $carts = json_decode($cookie, true);
            }

        } 
        else{ //if user login 
        	$user_id = $user->id;
            $cart_type = 'database'; 
            $cart = Carts::where('user_id', $user->id)->first();
            if($cart){
                $carts = CartDetails::where('cart_id', $cart->id)->get();
            }

        }
		/*$cart = Carts::where('user_id', $user->id)->first();
        $carts = CartDetails::join('products', 'cart_details.product_id', '=', 'products.id')
                            ->where('cart_details.cart_id', $cart->id)
                            ->select('cart_details.qty', 'cart_details.product_id', 'products.price_sale', 'products.title', 'products.image')
                            ->distinct()->get();*/
        $totalPrice = getTotalPriceInCart();
                            
		$order = new Orders;
		$code = tracking();
        $existCode = Orders::where('code', $code)->first();

        while($existCode){ //check if exist -> create new code
            $code = tracking();
            $existCode = Orders::where('code', $code)->first();
        }
        $order = new Orders;
        $order->code = $code;
        $order->name = $name;
        $order->phone = $phone;
        $order->email = $email;
        $order->address = $address;
        $order->total_price = $totalPrice;
        $order->status = 'pending';
        $order->status_delivery = 'pending';
        $order->payment = $payment;
        $order->note = $note;
        if($user)
        	$order->user_id = $user->id;
        if($order->save()){
        	foreach ($carts as $item) {
        		$detail = (object)$item;
				$pro = getProduct($detail->product_id);
                //create order detail
                $orderDetail = new OrderDetails;
                $orderDetail->qty = $detail->qty;
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $detail->product_id;
                $orderDetail->save();
            }
            $orderSend = Orders::select('id', 'code')->find($order->id);
            return $orderSend;
        }
        return;
	}
}
//creat order for App
if(!function_exists('createOrderApp')){
	function createOrderApp($products, $totalPrice, $name, $phone, $email, $address, $note, $payment){
		$code = tracking();
        $existCode = Orders::where('code', $code)->first();
        while($existCode){
            $code = tracking();
            $existCode = Orders::where('code', $code)->first();
        }
        $order = new Orders;
        $order->code = $code;
        $order->name = $name;
        $order->phone = $phone;
        $order->email = $email;
        $order->address = $address;
        $order->total_price = $totalPrice;
        $order->status = 'pending';
        $order->status_delivery = 'pending';
        $order->payment = $payment;
        $order->note = $note;
        // $order->user_id = '';            
        if($order->save()){
            foreach ($products as $item) {                    
                $orderDetail = new OrderDetails;
                $orderDetail->qty = $item['quantity'];
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $item['id'];
                $orderDetail->save();
            }                            
            mailOrder($order->code);
            return $order->code;
        }
        return;
	}
}
//send mail order
if(! function_exists('mailOrder')){
	function mailOrder($code_order){
		$user = Auth::User();

		$order = Orders::where('code', $code_order)->first();
		$name = $order->name;
	    $phone = $order->phone;
	    $email = $order->email;
	    $address = $order->address;
	    $totalPrice = $order->total_price;
	    $note = $order->note;

	    //if order already exist
	    if($order):
	    	$orderDetail = OrderDetails::join('products', 'order_details.product_id', '=', 'products.id')
	    								->where('order_id', $order->id)
	    								->select('order_details.qty', 'order_details.product_id', 'products.price_sale', 'products.title', 'products.image')
	                            		->distinct()->get();

	    	//add to content send mail customer
	        $content = '<p>Đơn hàng đang được duyệt. Cám ơn quý khách</p>';
	        $content .= '<p><strong>Mã đơn hàng: </strong>'.$code_order.'<p>';
	        $content = '<h4 style="color: #c9141b;">THÔNG TIN NGƯỜI ĐẶT HÀNG</h4>';
	        $content .= '<p><strong>Họ tên: </strong>'.$name.'<p>';
	        $content .= '<p><strong>Email: </strong>'.$email.'<p>';
	        $content .= '<p><strong>Số điện thoại: </strong>'.$phone.'<p>';
	        $content .= '<p><strong>Ngày đặt hàng: </strong>'.date('d/m/Y').'<p>';
	        $content .= '<p><strong>Địa chỉ: </strong>'.$address.'<p>';
	        $content .= '<p><strong>Ghi chú: </strong>'.$note.'<p>';
	        $content .= '<h4 style="color: #c9141b;">THÔNG TIN ĐƠN HÀNG</h4>';
	        $content .= '<table style="border-collapse: collapse;">';
	        $content .= '<tr>';
	        $content .= '<th style="border: 1px solid #ddd; padding: 8px;">Hình ảnh</th>';
	        $content .= '<th style="border: 1px solid #ddd; padding: 8px;">Tên sản phẩm</th>';
	        $content .= '<th style="border: 1px solid #ddd; padding: 8px;">Đơn giá</th>';
	        $content .= '<th style="border: 1px solid #ddd; padding: 8px;">Số lượng</th>';
	        $content .= '<th style="border: 1px solid #ddd; padding: 8px;">Thành tiền</th></tr>';

	        //add to content send mail admin
	        $admin_content = '<p><strong>Mã đơn hàng: </strong>'.$code_order.'<p>';
	        $admin_content .= '<h4 style="color: #c9141b;">THÔNG TIN NGƯỜI ĐẶT HÀNG</h4>';
	        $admin_content .= '<p><strong>Họ tên: </strong>'.$name.'<p>';
	        $admin_content .= '<p><strong>Email: </strong>'.$email.'<p>';
	        $admin_content .= '<p><strong>Số điện thoại: </strong>'.$phone.'<p>';
	        $admin_content .= '<p><strong>Ngày đặt hàng: </strong>'.date('Y-m-d').'<p>';
	        $admin_content .= '<p><strong>Địa chỉ: </strong>'.$address.'<p>';
	        $admin_content .= '<p><strong>Ghi chú: </strong>'.$note.'<p>';
	        $admin_content .= '<h4 style="color: #c9141b;">THÔNG TIN ĐƠN HÀNG</h4>';
	        $admin_content .= '<table style="border-collapse: collapse;">';
	        $admin_content .= '<tr>';
	        $admin_content .= '<th style="border: 1px solid #ddd; padding: 8px;">Hình ảnh</th>';
	        $admin_content .= '<th style="border: 1px solid #ddd; padding: 8px;">Tên sản phẩm</th>';
	        $admin_content .= '<th style="border: 1px solid #ddd; padding: 8px;">Đơn giá</th>';
	        $admin_content .= '<th style="border: 1px solid #ddd; padding: 8px;">Số lượng</th>';
	        $admin_content .= '<th style="border: 1px solid #ddd; padding: 8px;">Thành tiền</th></tr>';

	        foreach ($orderDetail as $item) {
	            //add to content send mail customer
	            //image($item->image, 100, 100, $item->title);
	            $content .= '<tr>';
	                //$content .= '<td style="border: 1px solid #ddd; padding: 8px;">'.image($item->image, 100, 100, $item->title).'</td>';
	                $content .= '<td style="border: 1px solid #ddd; padding: 8px;">';
	                    $content .= '<img src="'. getImgUrlConfig($item->image, 100, 100) .'" alt="'. $item->title .'"/>';
	                $content .= '</td>';

	                $content .= '<td style="border: 1px solid #ddd; padding: 8px;">'.$item->title.'</td>';
	                $content .= '<td style="border: 1px solid #ddd; padding: 8px;">'.currency($item->price_sale).'</td>';
	                $content .= '<td style="border: 1px solid #ddd; padding: 8px;">'.$item->qty.'</td>';
	                $content .= '<td style="border: 1px solid #ddd; padding: 8px;">'. currency(($item->price_sale)*($item->qty)) .'</td>';
	            $content .= '</tr>';

	            //add to content send mail admin
	            $admin_content .= '<tr>';
	                $admin_content .= '<td style="border: 1px solid #ddd; padding: 8px;">';
	                    $admin_content .= '<img src="'. getImgUrlConfig($item->image, 100, 100) .'" alt="'. $item->title .'"/>';
	                $admin_content .= '</td>';
	                $admin_content .= '<td style="border: 1px solid #ddd; padding: 8px;">'.$item->title.'</td>';
	                $admin_content .= '<td style="border: 1px solid #ddd; padding: 8px;">'.currency($item->price_sale).'</td>';
	                $admin_content .= '<td style="border: 1px solid #ddd; padding: 8px;">'.$item->qty.'</td>';
	                $admin_content .= '<td style="border: 1px solid #ddd; padding: 8px;">'. currency(($item->price_sale)*($item->qty)) .'</td>';
	            $admin_content .= '</tr>';
	                                   
	        } 

	        $content .= '<tr><td colspan="4" style="border: 1px solid #ddd; padding: 8px; text-align:right; font-weight: bold;">Tổng cộng</td><td style="border: 1px solid #ddd; padding: 8px;">'.currency($totalPrice).' </td></tr>';
	        $content .= '</table>';

	        $admin_content .= '<tr><td colspan="4" style="border: 1px solid #ddd; padding: 8px; text-align:right; font-weight: bold;">Tổng cộng</td><td style="border: 1px solid #ddd; padding: 8px;">'.currency($totalPrice).' </td></tr>';
	        $admin_content .= '</table>';  

	        $data = array( 'email' => $email, 'name' => $name, 'from' => $email, 'content'=> $content);
	        Mail::send( 'mails.order', compact('data'), function( $message ) use ($data)
	        {
	            $message->to( $data['email'] )
	                    ->from( $data['from'])
	                    ->subject( 'Thông tin đơn hàng' );
	        });
	        $data_admin = array( 'email' => mailSystem(), 'name' => $name, 'from' => $email, 'content'=> $admin_content);
	        Mail::send( 'mails.admin.order', compact('data_admin'), function( $message ) use ($data_admin)
	        {
	            $message->to( $data_admin['email'] )
	                    ->from( $data_admin['from'])
	                    ->subject( 'Thông tin đơn hàng' );
	        });
	    endif;	
	}
}

//Update status order
if(!function_exists('updateStatusOrder')){
	function updateStatusOrder($code_order, $status){
		$order = Orders::where('code', $code_order)->first();
    	$order->status = $status;
    	$order->save();
	}
}


//set session payment
if(! function_exists('setSessionPayment')){
	function setSessionPayment($status){
		Session::put('payment_result', $status);
	}
}

//forget session payment
if(! function_exists('forgetSessionPayment')){
	function forgetSessionPayment(){
		Session::forget('payment_result');
	}
}

//get session payment
if(! function_exists('getSessionPayment')){
	function getSessionPayment(){
		$status = '';
		if(Session::has('payment_result'))
			$status = Session('payment_result');
		return $status;
	}
}