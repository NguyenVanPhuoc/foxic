<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\SocialAccountService;
use Socialite;
use Redirect;

class SocialController extends Controller {

    public function redirect($social) {
        return Socialite::driver($social)->redirect();
    }

    public function callback(Request $request, $social) {
        $user = SocialAccountService::createOrGetUser(Socialite::driver($social)->user(), $social);
        if($user == 'email_null') {
            $request->session()->flash('error', 'Social account don\'t update email yet!');
            return redirect()->route('storeLoginCustomer');
        }
        auth()->login($user);
        return redirect()->route('home');
    }

    public function deleteAppData(Request $request, $social) {
        return true;
    }
}