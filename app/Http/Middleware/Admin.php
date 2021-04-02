<?php
/**
 * Created by PhpStorm.
 * User: nimeshjayasankha
 * Date: 10/6/20
 * Time: 10:03 PM
 */

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle($request, Closure $next)
    {
        if(Auth::user()->user_role_iduser_role==1){

            return $next($request);
        }
        else{
            return redirect('/index');
        }
    }

}