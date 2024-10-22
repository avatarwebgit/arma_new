<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            $lastActivity = session('lastActivity', time());
            $inactivityDuration = time() - $lastActivity;

            if ($inactivityDuration > config('session.lifetime') * 60) {
                $this->logoutUser();
                return redirect('/login')->withErrors(['message' => 'شما به دلیل inactivity خارج شده‌اید.']);
            }

            session(['lastActivity' => time()]);
        } else {
            $this->logoutUser();
            return redirect('/login')->withErrors(['message' => 'شما به دلیل inactivity خارج شده‌اید.']);
        }

        return $next($request);
    }

    protected function logoutUser()
    {
        auth()->logout();
        session()->invalidate();
    }


}
