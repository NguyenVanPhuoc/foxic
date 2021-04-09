<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\ChangeVote;
use App\Seo;
use Validator;

class VoteAdminController extends Controller
{
	public function index(Request $request){
		$list_vote = ChangeVote::orderBy('created_at','asc')->paginate(14);
		$data = [];
		$data['list_vote'] = $list_vote;
		return view('backend.votes.list', $data);
	}
	public function create(){
		return view('backend.votes.create');
	}
	public function store(Request $request){
		$list_rules = [];
        $list_rules['title'] = 'required';
        $list_rules['vote'] = 'required';
        $list_rules['amount'] = 'required';
		$validator = Validator::make($request->all(), $list_rules);
		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $votes = ChangeVote::create($request->only('title','vote','amount','choose_point'));
        return response()->json(['success' => 'Add to success.', 'url' => route('createVoteAdmin')]);
	}

	public function edit($id){
		$votes = ChangeVote::findOrFail($id);
		$data = [];
		$data['votes'] = $votes;
		return view('backend.votes.edit', $data);
	}

	public function update($id, Request $request){
		$list_rules = [];
        $list_rules['title'] = 'required';
        $list_rules['vote'] = 'required';
        $list_rules['amount'] = 'required';

		$validator = Validator::make($request->all(), $list_rules);
		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        //update to DB
        $writer = ChangeVote::where('id', $id)->update($request->only('title','vote','amount','choose_point'));
        return response()->json(['success' => 'Update to success.']);

	}

	public function delete($id){
        $item = ChangeVote::findOrFail($id);
        $item->delete();
        return redirect()->route('votesAdmin')->with('success','Deleted Successful');
	}

	public function deleteAll(Request $request){
        if($request->ajax()){
            $items = json_decode($request->items);
            $list_vote = ChangeVote::latest()->paginate(14);
            $data = [];
            $data['list_vote'] = $list_vote;
            return response()->json(['msg' => 'success', 'html' => view('backend.votes.table', $data)->render()]);
        }
        return response()->json(['msg' => 'error']);
	}
}