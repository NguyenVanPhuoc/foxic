<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminLogin
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
            if($user->hasRole(['BQT', 'Tác giả', 'Kiểm duyệt viên']))
                return $next($request);
            else
                return redirect()->route('home');
        }else{
            return redirect()->route('login');
        }
    }
}
