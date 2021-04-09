<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Products;
use App\Orders;
use App\OrderDetails;

class PaymentController extends Controller
{
    //order by atm
    /*
    * @param 
    *     - first_name 
    *     - last_name 
    *     - phone
    *     - email
    *     - note
    *     - array_product : list array product ['product_id', 'qty']
    * 
    */
    public static function orderByAtm(Request $request){
        $error = [];
        if($request->first_name == '')
            $error[] = 'Họ không được để trống';
        if($request->last_name == '')
            $error[] = 'Tên không được để trống';
        if($request->phone == '')
            $error[] = 'Số điện thoại không được để trống';
        if($request->email == '')
            $error[] = 'Email không được để trống';
        if(count($request->array_product))
            $error[] = 'Không có sản phẩm nào để thanh toán.';
        if(count($error) > 0){
            return response()->json([
                'status'=> 200,
                'success' => false,
                'error' => $error
            ]);
        }
        else{
            $email_admin = 'dangthituyethanh171195@gmail.com';
            $name = $request->first_name . ' ' . $request->last_name;
            $email = $request->email;
            $phone = $request->phone;
            $address = $request->address;
            $note = (isset($request->note)) ? $request->note : '';

            //create new order 
            $order = createOrderApi($array_product, $name, $phone, $email, $address, $note, 'atm');

            if($order){

                //set cookie for code
                Session::put('code_order', $order->code);

                //one pay 
                $options = onepayConfig();
                $SECURE_SECRET = $options->onepay_in_secureSecret;
                $_POST["vpc_Merchant"] = $options->onepay_in_merchantID;
                $_POST["vpc_MerchTxnRef"] = date('YmdHis');
                $_POST['vpc_OrderInfo'] = $order->code;
                $_POST['vpc_Amount'] = $totalSending;
                $_POST["vpc_AccessCode"] = $options->onepay_in_accessCode;
                $_POST["Title"] = "VPC 3-Party";
                $_POST["vpc_Version"] = "2";
                $_POST["vpc_Command"] = "pay";
                $_POST["vpc_Locale"] = "vn";
                $_POST["vpc_Currency"] = "VND";
                $_POST["vpc_TicketNo"] = $_SERVER ['REMOTE_ADDR'];
                $_POST["virtualPaymentClientURL"] = "https://mtf.onepay.vn/onecomm-pay/vpc.op";
                $_POST["vpc_ReturnURL"] = route('onepayInSuccess');
                $vpcURL = $_POST["virtualPaymentClientURL"] . "?";                
                unset($_POST["_token"]); 
                unset($_POST["virtualPaymentClientURL"]); 
                unset($_POST["submit"]);
                $stringHashData = "";
                ksort ($_POST);
                $appendAmp = 0;        
                Session::put('atmPay',0);
                foreach($_POST as $key => $value) {
                    // create the md5 input and URL leaving out any fields that have no value
                    // tạo chuỗi đầu dữ liệu những tham số có dữ liệu
                    if (strlen($value) > 0) {
                        // this ensures the first paramter of the URL is preceded by the '?' char
                        if ($appendAmp == 0) {
                            $vpcURL .= urlencode($key) . '=' . urlencode($value);
                            $appendAmp = 1;
                        } else {
                            $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
                        }
                        //$stringHashData .= $value; *****************************sử dụng cả tên và giá trị tham số để mã hóa*****************************
                        if ((strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
                            $stringHashData .= $key . "=" . $value . "&";
                        }
                    }
                }
                //*****************************xóa ký tự & ở thừa ở cuối chuỗi dữ liệu mã hóa*****************************
                $stringHashData = rtrim($stringHashData, "&");
                // Create the secure hash and append it to the Virtual Payment Client Data if
                // the merchant secret has been provided.
                // thêm giá trị chuỗi mã hóa dữ liệu được tạo ra ở trên vào cuối url
                if (strlen($SECURE_SECRET) > 0) {
                    //$vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($stringHashData));
                    // *****************************Thay hàm mã hóa dữ liệu*****************************
                    $vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*',$SECURE_SECRET)));
                }

                // FINISH TRANSACTION - Redirect the customers using the Digital Order
                // ===================================================================
                // chuyển trình duyệt sang cổng thanh toán theo URL được tạo ra

            }

            return response()->json([
                'status'=> 200, 
                'success'=>true, 
                'url_redirect'=>$vpcURL, 
                'order_code' => $order->code
            ]);

        }
    }

     //order by visa (onpay out)
    /*
    * @param 
    *     - first_name 
    *     - last_name 
    *     - phone
    *     - email
    *     - note
    *     - array_product : list array product ['product_id', 'qty']
    * 
    */
    public static function orderByVisa(Request $request){
        $error = [];
        if($request->first_name == '')
            $error[] = 'Họ không được để trống';
        if($request->last_name == '')
            $error[] = 'Tên không được để trống';
        if($request->phone == '')
            $error[] = 'Số điện thoại không được để trống';
        if($request->email == '')
            $error[] = 'Email không được để trống';
        if(count($request->array_product))
            $error[] = 'Không có sản phẩm nào để thanh toán.';
        if(count($error) > 0){
            return response()->json([
                'status'=> 200,
                'success' => false,
                'error' => $error
            ]);
        }
        else{
            $name = $request->first_name . ' ' . $request->last_name;
            $email = $request->email;
            $phone = $request->phone;
            $address = $request->address;
            $note = (isset($request->note)) ? $request->note : '';

            //create new order 
            $order = createOrderApi($array_product, $name, $phone, $email, $address, $note, 'atm');

            if($order){

                //set cookie for code
                Session::put('code_order', $order->code);

                //one pay 
                $options = onepayConfig();
                $SECURE_SECRET = $options->onepay_out_secureSecret;
                
                $data['vpc_Merchant'] = $options->onepay_out_merchantID;
                $data['vpc_AccessCode'] = $options->onepay_out_accessCode;
                $data['vpc_MerchTxnRef'] = date('YmdHis');
                $data['vpc_OrderInfo'] = $order->code;
                $data['vpc_TicketNo'] = $_SERVER['REMOTE_ADDR'];
                $data['vpc_Amount'] = $totalSending;
                $data['vpc_ReturnURL'] = route('onepayOutSuccess');
                $data['vpc_Command'] = "pay";
                $data['vpc_Version'] = "2";
                $data['Title'] = $order->code;
                $data['vpc_Locale'] = "en";
                $data['AgainLink']= route('home');
                
                $url = 'https://mtf.onepay.vn/vpcpay/vpcpay.op';

                $vpcURL = $url . "?";
                ksort ($data);
                $md5HashData = "";
                $appendAmp = 0;
                Session::put('visaPay',0);

                foreach($data as $key => $value) {
                    if (strlen($value) > 0) {
                        if ($appendAmp == 0) {
                            $vpcURL .= urlencode($key) . '=' . urlencode($value);
                            $appendAmp = 1;
                        } else {
                            $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
                        }
                        if ((strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
                            $md5HashData .= $key . "=" . $value . "&";
                        }
                    }
                }
                $md5HashData = rtrim($md5HashData, "&");
                if (strlen($SECURE_SECRET) > 0) {
                    $vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*',$SECURE_SECRET)));
                }

            }

            return response()->json([
                'status'=> 200, 
                'success'=>true, 
                'url_redirect'=>$vpcURL, 
                'order_code' => $order->code
            ]);

        }
    }

    //succesy for onpay vn
    public function statusPayment(Request $request){
        $error = [];
        if($request->order_code == '')
            $error[] = 'Vui lòng truyền vào mã order';
        if($request->status == '')
            $error[] = 'Vui lòng truyền vào trạng thái thanh toán. ("success" or "fail")';
        if($request->status != 'success' && $request->status != 'fail')
            $error[] = 'Trạng thái truyền vào không đúng, ("success" or "fail")';
        if(count($error) > 0){
            return response()->json([
                'status'=> 200,
                'success' => false,
                'error' => $error
            ]);
        }
        else{
            if($request->status == 'success') {
                updateStatusOrder($request->order_code, 'success');
                //send mail
                mailOrder($request->order_code);
            }
            else
                updateStatusOrder($request->order_code, 'fail');
        }
    }

    //order by cod
    /*
    * @param 
    *     - first_name 
    *     - last_name 
    *     - phone
    *     - email
    *     - note
    *     - array_product : list array product ['product_id', 'qty']
    * 
    */
	public function orderByCod(Request $request){
		$error = [];
        if($request->first_name == '')
            $error[] = 'Họ không được để trống';
        if($request->last_name == '')
            $error[] = 'Tên không được để trống';
        if($request->phone == '')
            $error[] = 'Số điện thoại không được để trống';
        if($request->email == '')
            $error[] = 'Email không được để trống';
        if(count($error) > 0){
            return response()->json([
                'status'=> 405,
                'data' => $error,
                'msg' => 'error validate'
            ]);
        }
        else{
            $name = $request->first_name . ' ' . $request->last_name;
            $email = $request->email;
            $phone = $request->phone;
            $address = $request->address;
            $note = (isset($request->note)) ? $request->note : '';
            $totalPrice = $request->total_price;
            $payment = 'cod';
            $products = $request->products;            

            //create new order 
            $order =  createOrderApp($products, $totalPrice, $name, $phone, $email, $address, $note, $payment);            
            //send mail
            return response()->json([
                'status'=> 200, 
                'data'=>$order,                
                'msg' => 'OK',
            ]);
        }
	}
    // public function testJson(){
    //     var_dump(json_decode())
    // })
	/*
	* payment by code
	* $params: 
	* 	- hoten, email, address, phone
	*  	- arrayPro[pro_id, qty]
	*/
	public function payment(Request $request){
		
		$error = [];
		if($request->name == '')
			$error[] = 'Họ tên không được để trống';
		if($request->address == '')
			$error[] = 'Địa chỉ không được để trống';
		if($request->phone == '')
			$error[] = 'Số điện thoại không được để trống';
		if($request->email == '')
			$error[] = 'Email không được để trống';
		if(count($request->arrayPro))
			$error[] = 'Không có sản phầm nào để thanh toán.';
		if(count($error) > 0)
			return response()->json([
				'status'=> 200,
				'success' => false,
				'error' => $error
			]);
		else{
			$user = Auth::user();

			$email_admin = 'dangthituyethanh171195@gmail.com';
			$name = $request->name;
			$email = $request->email;
			$phone = $request->phone;
			$address = $request->address;
			$note = (isset($request->note)) ? $request->note : '';

			$totalPrice = 0;
			$amount = getAmount($user->id);

			//total price 
			foreach($arrayPro as $array){
				$price_sale = getPriceSalePro($array['pro_id']);
				$totalPrice += $price_sale*$array['qty'];
			}

			//check point user with total price
			if($amount < $totalPrice){
                return response()->json([
					'status'=> 200,
					'success' => false,
					'error' => ['Số điểm không đủ. Vui lòng nạp thêm']
				]);
            }
            else{
            	//create order
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
                $order->note = $note;
                $order->user_id = $user->id;
                if($order->save()){
                    //add to content send mail customer
                    $content = '<p>Đơn hàng đang được duyệt. Cám ơn quý khách</p>';
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
                    $admin_content = '<h4 style="color: #c9141b;">THÔNG TIN NGƯỜI ĐẶT HÀNG</h4>';
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

                    foreach ($arrayPro as $array) {
                    	$product = getProduct($array['pro_id']);
                        //create order detail
                        $orderDetail = new OrderDetails;
                        $orderDetail->qty = $array['qty'];
                        $orderDetail->order_id = $order->id;
                        $orderDetail->product_id = $array['pro_id'];
                        $orderDetail->save();

                        //add to content send mail customer
                        $content .= '<tr>';
                            //$content .= '<td style="border: 1px solid #ddd; padding: 8px;">'.image($item->image, 100, 100, $item->title).'</td>';
                            $content .= '<td style="border: 1px solid #ddd; padding: 8px;">';
                                $content .= '<img src="'. getImgUrlConfig($product->image, 100, 100) .'" alt="'. $product->title .'"/>';
                            $content .= '</td>';

                            $content .= '<td style="border: 1px solid #ddd; padding: 8px;">'.$product->title.'</td>';
                            $content .= '<td style="border: 1px solid #ddd; padding: 8px;">'.currency($product->price_sale).'</td>';
                            $content .= '<td style="border: 1px solid #ddd; padding: 8px;">'.$array['qty'].'</td>';
                            $content .= '<td style="border: 1px solid #ddd; padding: 8px;">'. currency(($product->price_sale)*($array['qty'])) .'</td>';
                        $content .= '</tr>';

                        //add to content send mail admin
                        $admin_content .= '<tr>';
                            $admin_content .= '<td style="border: 1px solid #ddd; padding: 8px;">';
                                $admin_content .= '<img src="'. getImgUrlConfig($product->image, 100, 100) .'" alt="'. $product->title .'"/>';
                            $admin_content .= '</td>';
                            $admin_content .= '<td style="border: 1px solid #ddd; padding: 8px;">'.$product->title.'</td>';
                            $admin_content .= '<td style="border: 1px solid #ddd; padding: 8px;">'.currency($product->price_sale).'</td>';
                            $admin_content .= '<td style="border: 1px solid #ddd; padding: 8px;">'.$array['qty'].'</td>';
                            $admin_content .= '<td style="border: 1px solid #ddd; padding: 8px;">'. currency(($product->price_sale)*($array['qty'])) .'</td>';
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
                    $data_admin = array( 'email' => $email_admin, 'name' => $name, 'from' => $email, 'content'=> $admin_content);
                    Mail::send( 'mails.admin.order', compact('data_admin'), function( $message ) use ($data_admin)
                    {
                        $message->to( $data_admin['email'] )
                                ->from( $data_admin['from'])
                                ->subject( 'Thông tin đơn hàng' );
                    });
                    //minus point
                    updateAmount($user->id, $amount - $totalPrice);    

                    return response()->json([
						'status'=> 200,
						'success' => true
					]);      
                }
            }

		}
	}
}