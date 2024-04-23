<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class Email2FA
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
        $user = auth()->user();

        if(auth()->check() && $user->email2fa_secret)
        {
            if(Carbon::parse($user->email2fa_secret_expires_at)->lt(now()))
            {
                $user->resetTwoFactorCode();
                auth()->logout();

                return redirect()->route('login')
                    ->withMessage(__('The two factor code has expired. Please login again.'))->withType("danger");
            }

            if(!$request->is('2fa*'))
            {
                return redirect()->route('2fa.index');
            }
        }

        return $next($request);
    }
}
