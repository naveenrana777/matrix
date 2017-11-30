<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }


    public function login(Request $request) {

        if ($request->ajax()) {
            $email = Input::get('email');
            $password = Input::get('password');
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                return "1";
            } else {
                return "AJAX Login Failed!";
            }
        } else {
            $email = Input::get('email');
            $password = Input::get('password');
            if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1])) {
                return redirect('/admin/sync');
            }
            return Redirect::back()->withErrors(['These credentials do not match our records']);
        }
    }


}
