<?php 
namespace App\Services;

use Laravel\Socialite\Contracts\User as ProviderUser;
use App\User;
use App\SocialAccount;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUser;

class SocialAccountService {

    public static function createOrGetUser(ProviderUser $providerUser, $social)  {
        $account = SocialAccount::whereProvider($social)
            ->whereProviderId($providerUser->getId())
            ->first();
        if ($account) return $account->user;
        else {
            $email = $providerUser->getEmail();
            if($email == null) return 'email_null';
            $account = new SocialAccount([
                'provider_id' => $providerUser->getId(),
                'provider' => $social
            ]);
            $user = User::whereEmail($email)->first();
            if (!$user) {
                $password = Str::random(15);
                $user = User::create([
                    'email' => $email,
                    'name' => $providerUser->getName(),
                    'password' => Hash::make($password),
                ]);
                $user->assignRole(5);
                Mail::to($user)->send(new NewUser($password));
            }
            $account->user()->associate($user);
            $account->save();
            return $user;
        }
    }
}