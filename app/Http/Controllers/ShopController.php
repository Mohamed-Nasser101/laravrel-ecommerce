<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->category){
            $products = Product::whereHas('Categories',function($q){
                $q->where('slug',request()->category);
            })->get();
        }else{
            $products = Product::inRandomOrder()->take(12)->get();  
        }

        if(request()->sort === 'asc'){
            $products = $products->sortBy('price');
        }elseif(request()->sort === 'desc'){
            $products = $products->sortByDesc('price');
        }
        $categories = Category::all();
        return view('shop')->with([
            'products'=> $products,
            'categories' => $categories,
            'categoryName' => request()->category ?? 'featured'
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug',$slug)->firstOrFail();
        $mightAlsoLike = Product::where('slug','!=',$slug)->mightAlsoWanted(4);
        return view('product',[
            'product' => $product,
            'mightAlsoLike' => $mightAlsoLike
            ]);
    }
}
