<?php

namespace App\Http\Controllers;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\product;

use Illuminate\Http\Request;

class cartController extends Controller
{
    public function index()
    {
        if(Auth::user()->role != 'user'){
            return redirect('/');
        }

        return view('cart');
    }

    public function store(product $product)
    {
        $duplicates = Cart::search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id === $product->id;
        });

        if ($duplicates->isNotEmpty()) {
            session()->flash('success', 'Item is already in your cart, you can update the quantity!');
            return redirect()->route('cart.index');
        }

        Cart::add($product->id, $product->name, 1, $product->price)
            ->associate('App\product');

        session()->flash('success', 'Item was added to your cart!');

        Cart::store(Auth::user()->id);

        return redirect()->route('cart.index');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric'
        ]);

        if ($request->quantity > $request->productQuantity) {
            session()->flash('errors', 'We currently do not have enough items in stock.');
        }

        Cart::update($id, $request->quantity);

        Cart::store(Auth::user()->id);

        session()->flash('success', 'Quantity was updated successfully!');
        
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Cart::remove($id);

        Cart::store(Auth::user()->id);

        return back()->with('success', 'Item has been removed!');
    }
}
