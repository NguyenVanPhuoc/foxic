<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\CategoryPayment;
use App\Payment;
use App\Media;
use Validator;

class PaymentAdminController extends Controller
{
	public function index(Request $request){
		$s = $request->s;
        if($s!=""):
            $payment = Payment::where('title','like','%'.$s.'%')->latest()->paginate(14);
        else:
           $payment = Payment::latest()->paginate(14);
        endif;
		$data = [];
		$data ['payment'] = $payment;
		$data ['s'] = $s;
		return view('backend.payment.list', $data);
	}

	public function create(){
		$cate= CategoryPayment::orderBy('created_at','desc')->get();
		return view('backend.payment.create', ['cate'=>$cate]);
	}

	public function store(Request $request){
		$list_rules = [];
        $list_rules['title'] = 'required';
		$validator = Validator::make($request->all(), $list_rules);
		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $payment = new Payment;
        $payment->title = $request->title;
        $payment->amount = $request->amount;
        $payment->pay_id = $request->pay_id;
        $payment->package = $request->package;
        $payment->save();
        return response()->json(['success' => 'Create Complete', 'url' => route('createPaymentAdmin')]);
	}

	public function edit($id){
		$payment = Payment::findOrFail($id);
		$cate= CategoryPayment::orderBy('created_at','desc')->get();
		$data = [];
        $data['payment'] = $payment;
        $data['cate'] = $cate;
		return view('backend.payment.edit', $data );
		
	}

	public function update($id, Request $request){
        $payment = Payment::findOrFail($id);
        $list_rules = [];
        $list_rules['title'] = 'required';
        $validator = Validator::make($request->all(), $list_rules);
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $payment->update($request->only('title', 'amount', 'pay_id', 'package'));
        return response()->json(['success' => 'Update to success.', 'url' => route('editPaymentAdmin', $id)]);
	}

	public function delete($id){
        $item = Payment::findOrFail($id);
        $item->delete();
        return redirect()->route('paymentsAdmin')->with('success','Deleted Successful');
	}

	public function deleteAll(Request $request){
        if($request->ajax()){
            $items = json_decode($request->items);
            if(count($items)>0){
                Payment::destroy($items);
            }
            $payment = Payment::latest()->paginate(14);
            $data = [];
            $data['payment'] = $payment;
            return response()->json(['msg' => 'success', 'html' => view('backend.payment.table', $data)->render()]);
        }
        return response()->json(['msg' => 'error']);
	}

	
}