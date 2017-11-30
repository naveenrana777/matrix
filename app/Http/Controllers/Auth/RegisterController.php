<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
    	$check = User::where(['email'=>$data['email']])->count();
    	if($check == 1){
    		return Redirect::back()->withErrors(['These credentials do not match our records']);
    	}
    	else{
	        return User::create([
	            'firstname' 	=> $data['firstname'],
	            'lastname'  	=> $data['lastname'],
	            'email'     	=> $data['email'],
	            'password'  	=> bcrypt($data['password']),
	            'website'   	=> $data['website'],
	            'phone' 		=> $data['phone'],
	            'membership' 	=> $data['membership'],
	            'user_token' 	=> str_random(60),
	            'status'     	=> 0,
	            'role'       	=> 2
	        ]);
    	}
        
    }


  

}
