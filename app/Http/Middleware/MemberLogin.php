<?php
namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class MemberLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->hasRole(['BQT', 'Tác giả', 'Kiểm duyệt viên','Độc giả']))
                return $next($request);
            else
                return redirect('/');
        }else{
            return redirect()->route('storeLoginCustomer');
        }
    }
}
