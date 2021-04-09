<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Seo;
use App\Withdrawal;
use App\Notifications\SendMailWithdrawal;
use App\Media;
use App\User;
use Validator;

class WithdrawalAdminController extends Controller
{
	public function index(Request $request){
        $user = Auth::user();
        if(check_editor()){
            $withdrawals = Withdrawal::where('user_id', $user->id)->latest()->paginate(14);
        }else{
		  $withdrawals = Withdrawal::latest()->paginate(14);
        }
		$data = [];
		$data ['withdrawals'] = $withdrawals;
		return view('backend.withdrawals.list', $data);
	}

	public function create(){
		return view('backend.withdrawals.create');
	}

	public function store(Request $request){
		$list_rules = [];
        $list_rules['title'] = 'required';
		$validator = Validator::make($request->all(), $list_rules);
		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $withdrawal = new Withdrawal;
        $withdrawal->title = $request->title;
        $withdrawal->point = $request->point;
        $withdrawal->user_id = Auth::id();
        $withdrawal->status = 'pending';
        $content = array();
        $content['name'] = $request->Username;
        $content['phone'] = $request->Numberphone;
        $content['nameBank'] = $request->Namebank;
        $withdrawal->content = json_encode($content, JSON_UNESCAPED_UNICODE);
        $withdrawal->save();
        return response()->json(['success' => 'Create Complete', 'url' => route('createWithdrawalAdmin')]);
	}

	public function edit($id){
		$withdrawal = Withdrawal::findOrFail($id);
		$data = [];
        $data['withdrawal'] = $withdrawal;
		return view('backend.withdrawals.edit', $data );
		
	}

	public function update($id, Request $request){
        $withdrawal = Withdrawal::findOrFail($id);
        $list_rules = [];
        $list_rules['title'] = 'required';
        $validator = Validator::make($request->all(), $list_rules);
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $withdrawal['author_id'] = Auth::id();
        $withdrawal->update($request->only('title','image','author_id','status'));
        $user= User::where('id',$withdrawal->user_id)->first();
        if($user->point >= $withdrawal->point && $withdrawal->point > 50){
            $number = $user->point - $withdrawal->point;
            User::where('id', $user->id)->update(['point' => $number]); 
        }
        $user->notify(new SendMailWithdrawal($withdrawal));

        return response()->json(['success' => 'Update to success.', 'url' => route('editWithdrawalAdmin', $id)]);
	}

	public function delete($id){
        $item = Withdrawal::findOrFail($id);
        $item->delete();
        return redirect()->route('withdrawalsAdmin')->with('success','Deleted Successful');
	}

	public function deleteAll(Request $request){
        if($request->ajax()){
            $items = json_decode($request->items);
            $withdrawals = Withdrawal::latest()->paginate(14);
            $data = [];
            $data['withdrawals'] = $withdrawals;
            return response()->json(['msg' => 'success', 'html' => view('backend.withdrawals.list', $data)->render()]);
        }
        return response()->json(['msg' => 'error']);
	}

	
}