<?php

namespace App\Http\Controllers;
use App\product;
use App\category;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Cart::restore(Auth::user()->id);

        $categories = category::all();

        if (request()->category) {
            $products = product::with('category')->whereHas('category', function ($query) {
                $query->where('category_name', request()->category);
            })->orderBy('stock', 'desc')->get();
        }else {
            $products = product::orderBy('stock', 'desc')->orderBy('id', 'desc')->get();
        }

        if (request()->sort == 'low_high') {
            $products = $products->sortBy('price');
        } elseif (request()->sort == 'high_low') {
            $products = $products->sortByDesc('price');
        }

        return view('home')->with([
        'datas' => $products,
        'categories' => $categories]);
    }
}
