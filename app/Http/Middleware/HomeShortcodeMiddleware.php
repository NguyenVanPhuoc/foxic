<?php
namespace App\Http\Middleware;
use Closure;
use App\Pages;

class HomeShortcodeMiddleware
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
        $response = $next($request);

        if(!method_exists($response, 'content')):
            return $response;
        endif;
        
        $pages = Pages::all();
        $str = "<ul class='list-page'>";
        foreach ($pages as $page) {
            $str .= "<li>".$page->title."</li>";
        }        
        $str .= "</ul>";
        $content = str_replace('[shortcode_hello]',$str, $response->content());

        $response->setContent($content);

        return $response;
    }
}
