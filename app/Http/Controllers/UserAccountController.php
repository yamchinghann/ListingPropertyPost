<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAccountController extends Controller
{
    public function create()
    {
        return inertia('UserAccount/Create');
    }
    public function store(Request $request){
        $user = User::create($request->validate([
            'name' => 'required',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|min:8|confirmed'
        ]));
       /* $user = User::make($request->validate([
            'name' => 'required',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|min:8|confirmed'
        ]));//this is a user model, but it's not yet stored to the database but need to call save then it store DB
        $user->password = Hash::make($user->password);
        $user->save();/*/ //must save first* //no need at all as user model had did for it
        Auth::login($user);//authenticate the user;
        event(new Registered($user));

        return redirect()->route('listing.index')->with('success', 'Account created');
    }
}
