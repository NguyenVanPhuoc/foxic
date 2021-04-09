<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Options;
use App\Media;
use App\User;

class OptionsAdminController extends Controller
{
    public function index(){
        $option = Options::find(2);
        return view('backend.option.system',['option'=>$option]);
    }
    public function updateSystem(Request $request){
        $option = Options::find(2);
        if($request->logo != "") $option->logo = $request->logo;
        if($request->logo_light != "") $option->logo_light = $request->logo_light;
        if($request->logo_chap != "") $option->logo_viewer_chap = $request->logo_chap;
        if($request->favicon != "") $option->favicon = $request->favicon;
        $option->title = $request->title;
        $option->slogan = $request->slogan;
        $option->phone = $request->phone;
        $option->email = $request->email;
        $option->address = $request->address;
        $option->facebook = $request->facebook;
        $option->copyright = $request->copyright;
        $option->token_api = $request->token_api;
        $option->content_vip_package = $request->content_vip_package;
        $option->desc_vip_package = $request->desc_vip_package;
        if($request->mobiAddress != "") $option->mobiAddress = $request->mobiAddress;
        if($request->lag != "") $option->lag = $request->lag;
        if($request->log != "") $option->log = $request->log;
        if($request->website != "") $option->website = $request->website;
        $option->tag_list = $request->tag_list;
        if( $option->save()){
            return redirect()->route('setting')->with('success', 'Sửa thành công');
        }
    }    
    public function media(Request $request){
        if($request->ajax()){
            $html = media();
            return json_encode($html);
        }
        return 'error';
    }
}