<?php

namespace App\Http\Controllers;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\product;
use App\invoice;
use App\invoiceProduct;
use App\Http\Requests\checkoutRequest;

class checkoutController extends Controller
{
    public function index()
    {
        if (Cart::instance('default')->count() == 0) {
            return redirect()->route('home');
        }

        return view('checkout');
    }

    public function store(checkoutRequest $request)
    {
        // Check rare condition when there are less items available to purchase
        if ($this->productsAreNoLongerAvailable()) {
            return back()->withErrors('Sorry! One of the items in your cart is no longer avialble.');
        }

        $order = $this->addToInvoiceTables($request);
        $products = $order->product;

        $this->decreaseQuantities();

        Cart::instance('default')->destroy();
        Cart::store(Auth::user()->id);

        return redirect()->to('my-orders/'.$order->id)->with('success', 'Thank you! Your order has been sucessfully placed!');

    }

    protected function addToInvoiceTables($request)
    {
        // Insert into invoice table
        $fullName = $request->firstName . " " . $request->lastName;
        $address = $request->address . ", " . $request->city . ", " . $request->country;
        $intTax = doubleval(str_replace(",","",Cart::tax()));
        $intTotal = doubleval(str_replace(",","",Cart::total()));

        $order = invoice::create([
            'user_id' => auth()->user()->id,
            'name_address' => $fullName,
            'address' => $address,
            'postal_code' => $request->zip,
            'tax' => $intTax,
            'total' => $intTotal,
            'status' => "In Progress"
        ]);

        // Insert into invoice_product table
        foreach (Cart::content() as $item) {
            invoiceProduct::create([
                'invoice_id' => $order->id,
                'product_id' => $item->model->id,
                'quantity' => $item->qty,
                'subtotal' => $item->subtotal,
            ]);
        }

        return $order;
    }

    protected function decreaseQuantities()
    {
        foreach (Cart::content() as $item) {
            $product = product::find($item->model->id);

            $product->update(['stock' => $product->stock - $item->qty]);
        }
    }

    protected function productsAreNoLongerAvailable()
    {
        foreach (Cart::content() as $item) {
            $product = product::find($item->model->id);
            if ($product->stock < $item->qty) {
                return true;
            }
        }

        return false;
    }
}
