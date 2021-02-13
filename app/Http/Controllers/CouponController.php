<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;

class CouponController extends Controller
{

    public function store(Request $request)
    {
       $coupon = Coupon::findByCode($request->input('coupon_code'));
       
       if(!$coupon){
           return redirect()->back()->withErrors('coupon does not exist');
       }
       session()->put('coupon',[
           'name' => $coupon->code,
           'discount'=> $coupon->discount(Cart::subtotal()),
        //    'id' => $coupon->id
       ]);
       return redirect()->back()->with('success_message','coupon applied');
    }

    public function destroy()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success_message','coupon deleted');
    }
}
