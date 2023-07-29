<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function create(){
        return inertia('Auth/Login');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request){

        //behind of Auth::attempt will use array key of the array to validate in User model; such as check email in User DB
        if (!Auth::attempt($request->validate([//Auth attempt will check whether user provided credential is correct
            'email' => 'required|string|email', //if the data is valid then return boolean indicate success authenticate
            'password' => 'required|string'
        ]), true)){//second paramt-Remember me will authenticate user in cookie so user can always login without re-fillup detail,
            //but mostly we allow user to check whether remember me or not but now we fix it
            throw ValidationException::withMessages([
                'email' => 'Authentication Failed!'
            ]);
        }
        $request->session()->regenerate();//regenerating session for avoiding session fixation attack
        //return redirect()->intended();//it will default redirect to homepage (/)
        return redirect()->intended('/listing');
    }

    public function destroy(Request $request){
        Auth::logout();
        $request->session()->invalidate();//destroy session
        $request->session()->regenerateToken();//regenerate CSRF token
        return redirect()->route('listing.index');
    }
}
