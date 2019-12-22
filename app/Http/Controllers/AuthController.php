<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\VerifyPhone;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
       
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password ,"verify" =>  1]) )
            {
                 
                return redirect(route('home'));
            }   
            else 
            {
                 return view('auth.login')->withErrors('Error logging in!');
            }
        }
        return view('auth.login');
    }

    public function register(Request $request)
    {
        if($request->isMethod('post')){

            $request->validate([
                'email' => 'required|unique:users|max:255',
                'phone' => 'required|numeric',
                "password" => "required"
            ]);

            $request['password'] = bcrypt($request->password);
            $user = User::create($request->all());
            VerifyPhone::create([
                'code' => "2019" , 
                "user_id" => $user->id 
            ]);
            return redirect(route('verify' ,['user_id' => $user->id] ));
        }
        return view('auth.register');
    }

    public function verify(Request $request , $user_id)
    {
        if($request->isMethod('post')){
            $request->validate([
                "code" => "required"
            ]);
           $item = VerifyPhone::where('code' , $request->code)->where('user_id' , $user_id)->first();
            if(isset($item)){
                $user = User::find($user_id);
                $user->verify = 1;
                $user->save();
                return redirect(route('login'));
            }
            else{
                return "code is not coorect";
                
            }
        }
        return view('auth.verify' , ['user_id'=> $user_id]);
    }

    public function home()
    {
        return view('welcome');
    }
}
