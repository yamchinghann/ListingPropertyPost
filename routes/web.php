<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationSeenController;
use App\Http\Controllers\RealtorListingAcceptOfferController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\RealtorListingController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [IndexController::class, 'index']);
Route::get('/hello', [IndexController::class, 'show']);
//authentication -if uer directly access /hello then it will not allow if not authenticated
Route::get('/hello', [IndexController::class, 'show'])->middleware('auth');//'auth' is come from middleware kernel.php middlewareAlias

//Controller Resource
//Route::resource('listing', ListingController::class)->only(['index', 'show', 'create', 'store']);//enable
//Route::resource('listing', ListingController::class)//disable
//Route::resource('listing', ListingController::class);
//Route::resource('listing', ListingController::class)->middleware('auth');//this will protect all route of listing
//here mean middleware will protect only create, store, edit, update and destroy and the rest will able to access
/*Route::resource('listing', ListingController::class)
    ->only('create', 'store', 'edit', 'update')->middleware('auth');
Route::resource('listing', ListingController::class)
    ->except('create', 'store', 'edit', 'update', 'destroy');*/
Route::resource('listing', ListingController::class)
    ->only(['index', 'show']);
Route::resource('listing.offer', ListingOfferController::class)->middleware('auth')
    ->only(['store']);

Route::resource('notification', NotificationController::class)
    ->only(['index']);

Route::put(
    'notification/{notification}/seen',
    NotificationSeenController::class
)->middleware('auth')->name('notification.seen');

Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');

Route::get('/email/verify', function (){
    return inertia('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');//allow authenticated user to verify

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();//if current id match with userPK id then it will fulfill means set it as verified

    return redirect()->route('listing.index')->with('success', 'Email was verified');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');//throttle can found from Middleware Kernel.php
//it used to limit visit the link 6 time in one minus

Route::resource('user-account', UserAccountController::class)->only(['create', 'store']);


//Controller Group Route
Route::prefix('realtor')->name('realtor.')->middleware(['auth', 'verified'])
    ->group(function(){
        Route::name('listing.restore')
            ->put(
                'listing/{listing}/restore',
                [RealtorListingController::class, 'restore']
            )->withTrashed();
        Route::resource('listing', RealtorListingController::class)
            //->only(['index', 'destroy', 'edit', 'update', 'create', 'store'])
            ->withTrashed();//withTrashed() - By default it will do that for the show, edit and update resource routes.
        //But alternatively, you can also pass a parameter to this wave crashed method** withTrashed(['index', 'edit']),
        // which would be an array where you would specify all the methods that should also include the softly deleted models when they
        //are performing the route model binding.
        Route::name('offer.accept')
            ->put(
                'offer/{offer}/accept',
                RealtorListingAcceptOfferController::class
            );

        Route::resource('listing.image', RealtorListingImageController::class)
            ->only(['create', 'store', 'destroy']);
    });
