<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

//    protected function attemptLogin(Request $request)
//    {
//        $user = \App\Models\User::where('email', $request->get('email'))->first();
//        if ($user){
//            $sessions = DB::table('sessions')->where('user_id',$user->id)->exists();
//            if ($sessions){
//                session()->put('is_logged_in','this user is already logged in with another Device');
//                return redirect()->route('home.index');
//            }
//        }
//
//        return $this->guard()->attempt(
//            $this->credentials($request), $request->boolean('remember')
//        );
//    }
}
