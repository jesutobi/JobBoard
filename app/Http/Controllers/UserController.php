<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //Show register form
    public function register(){
        return view('users.register');
    }
    //create new user
    public function store(Request $request){

        $formfields = $request->validate([
        'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        
        ]);

        //  hash password
        $formfields['password'] = bcrypt($formfields['password']) ;

        // create user
        $user = User::create($formfields);

        // login
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in');
    }

     // Log account out
    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message','you have been logged out!!');
        
    }
    // Authenticate user
    public function authenticate(Request $request){
        $formfields = $request->validate([
        
            'email' => ['required', 'email'],
            'password' => 'required'
        
        ]);
        if(auth()->attempt($formfields)){
            $request->session()->regenerate();
            return redirect('/')->with('message','you are now logged in!!');
        }

        return back()->withErrors(['email' => 'invalid credentials'])->onlyInput('email');
        
    }
    // show login form
    public function login(){
         return view('users.login'); 
       
    }
}
