<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(){
         /*Listing::make([
             'beds' => 2, 'baths' => 2, 'area' => 100, 'city' => 'North', 'street' => 'Tinker st', 'street_nr' => 20, 'code' => 'TS', 'price' => 200_000
         ]);*/
        //dd(Listing::all());
        //dd(Auth::user());
        //dd(Auth::check());//use to check wheter the user is authenticated
        return inertia(
            'Index/Index',
            [
                'message' => 'Hello from Laravel'
            ]
        );
    }

    public function show(){
        return inertia('Index/Show');
    }
}
