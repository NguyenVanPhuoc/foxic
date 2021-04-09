<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Sticker;
use App\StickerCate;
use App\Events\UpdateUserPoint;

class StickerController extends Controller {

	public function listPackages(Request $request){
		$packages = StickerCate::with('stickers')->withCount('stickers')->hasStickers()->paginate(15);
		$data = [
			'sticker_packages' => $packages,
		];
		return view('members.list-stickers',$data);
	}

	public function buyPackage(Request $request, $package_id){
		$package = StickerCate::find($package_id);
		$user = Auth::user();
		if($package) {
			if($package->userCanUse(Auth::id())) {
				$request->session()->flash('error', 'Bạn đã có thể sử dụng gói stickers này!');
			}else{
				if($user->point < $package->amount) {
					$request->session()->flash('error', 'Bạn không đủ point để thêm gói này!');
				}else{
					$package->users()->attach($user->id, ['amount' => $package->amount]);
					event(new UpdateUserPoint($user, -$package->amount));
					$request->session()->flash('success', 'Thêm gói thành công!');
				}
			}
		}else $request->session()->flash('error', 'Gói stickers này không tồn tại!');
		return redirect()->back();
	}	
}