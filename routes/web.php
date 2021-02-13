<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SaveToLaterController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CouponController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [LandingPageController::class,'index'])->name('landing-page');
Route::get('/shop', [ShopController::class,'index'])->name('shop.index');
Route::get('/shop/{product}', [ShopController::class,'show'])->name('shop.show');
Route::get('/cart', [CartController::class,'index'])->name('cart.index');
Route::post('/cart', [CartController::class,'store'])->name('cart.store');
Route::delete('/cart/{product}', [CartController::class,'destroy'])->name('cart.destroy');
Route::patch('/cart/{product}', [CartController::class,'update'])->name('cart.update');

Route::post('/cart/SwitchSaveForLater/{product}',[CartController::class,'switchToSave'])->name('cart.forLater');

Route::post('/saveForlater/{product}', [SaveToLaterController::class,'moveToCart'])->name('saveForlater.moveToCart');
Route::delete('/saveForlater/{product}', [SaveToLaterController::class,'destroy'])->name('saveForlater.destroy');

Route::get('/checkout',[CheckoutController::class,'index'])->name('checkout.index');
Route::post('/checkout',[CheckoutController::class,'store'])->name('checkout.store');


Route::get('/thankyou', function(){
    if(! session()->has('success_message')){
        return redirect('/');
    }
    return view('thankyou');
})->name('confirmation');
Route::resource('coupon',CouponController::class)->only('store','destroy');
