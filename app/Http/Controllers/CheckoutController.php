<?php

namespace App\Http\Controllers;

use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;
use App\Mail\Mailing;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('checkout')->with([
            'subtotal' =>$this->getFinance()->get('subtotal'),
            'discount' =>$this->getFinance()->get('discount'),
            'tax'      =>$this->getFinance()->get('tax'),
            'total'    =>$this->getFinance()->get('total')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CheckoutRequest $request)
    {
        $contents = Cart::content()->map(function($item){
            return $item->model->slug.', '.$item->qty;
        })->values()->toJson();

        try {
            $charge = Stripe::charges()->create([
                'amount' => $this->getFinance()->get('total') / 100,
                'currency' => 'CAD',
                'source' => 'tok_visa',   //$request->stripeToken  for testing
                'description' => 'Order',
                'receipt_email' => $request->email,
                'metadata' => [
                    //change to Order ID after we start using DB
                    'contents' => $contents,
                    'quantity' => Cart::instance('default')->count(),
                ],
            ]);

            // SUCCESSFUL
            Cart::instance('default')->destroy();
            //Mail::sned(new Mailing());
            session()->forget('coupon');
            return redirect()->route('confirmation')->with('success_message', 'Thank you! Your payment has been successfully accepted!');
        } catch (CardErrorException $e) {
            return back()->withErrors('Error! ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getFinance(){
        $subtotal = Cart::subtotal();
        $discount = session()->get('coupon')['discount'] ?? 0 ;
        $newsubtotal = $subtotal - $discount ;
        $tax = $newsubtotal * (Config('cart.tax') / 100);
        $total = $newsubtotal + $tax ;

        return collect([
            'subtotal' =>$subtotal,
            'newsubtotal' => $newsubtotal,
            'discount' =>$discount,
            'tax'      =>$tax,
            'total'    =>$total
        ]);

    }
}
