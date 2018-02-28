<?php

namespace Larasoft\PasswordExpiry\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckPasswordExpired
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
        $user = $request->user();

        if ($user->isPasswordExpired()) {
            $token = str_random(60);
            DB::table('password_resets')->insert([
                'email' => $user->email,
                'token' => bcrypt($token),
                'created_at' => Carbon::now()
            ]);

//            $message = $user->getPasswordExpiryMessage();

            $url = url(config('app.url').route('password.reset', $token, false));

            $user->notify(new ResetPassword($token));

            auth()->logout();

//            flash($message)->info();

            return redirect()->to($url);
        }

        return $next($request);
    }
}
