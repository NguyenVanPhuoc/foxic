<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Seo;
use App\CategoryPayment;
use Validator;

class CategoryPaymentAdminController extends Controller
{
	public function index(){
		$cates = CategoryPayment::latest()->paginate(14);
		$data = [];
		$data ['cates'] = $cates;
		return view('backend.catPayments.list', $data);
	}

	public function create(){
		return view('backend.catPayments.create');
	}

	public function store(Request $request){
		$list_rules = [];
        $list_rules['title'] = 'required';
		$validator = Validator::make($request->all(), $list_rules);
		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $cate = CategoryPayment::create($request->only('title', 'description', 'image'));
        return response()->json(['success' => 'Create Complete', 'url' => route('createCatPaymentAdmin')]);
	}

	public function edit($id){
		$cate = CategoryPayment::findOrFail($id);
		$data = [];
		$data['cate'] = $cate;
		return view('backend.catPayments.edit', $data);
	}

	public function update($id, Request $request){
		$list_rules = [];
        $list_rules['title'] = 'required';
		$validator = Validator::make($request->all(), $list_rules);
		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all()]);
        $cate = CategoryPayment::where('id', $id)->update($request->only('title', 'description', 'image'));
        return response()->json(['success' => 'Update complete.']);

	}

	public function delete($id){
        $item = CategoryPayment::findOrFail($id);
        $item->delete();
        return redirect()->route('catPaymentsAdmin')->with('success','Deleted Successful');
	}

	public function deleteAll(Request $request){
        if($request->ajax()){
            $items = json_decode($request->items);
            if(count($items)>0){
                CategoryPayment::destroy($items);
            }
            $cates = CategoryPayment::latest()->paginate(14);
            $data = [];
            $data['cates'] = $cates;
            return response()->json(['msg' => 'success', 'html' => view('backend.catPayments.table', $data)->render()]);
        }
        return response()->json(['msg' => 'error']);
	}
}