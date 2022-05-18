<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\product;
use App\invoice;
use Illuminate\Http\Request;

class invoiceController extends Controller
{
    public function index()
    {
        if(Auth::user()->role != 'admin'){
            $invoices = auth()->user()->invoice()->with('product')->get(); // fix n + 1 issues
        }else{
            $invoices = invoice::all();
        }

        return view('orders', ['datas' => $invoices]);
    }

    public function show($id)
    {
        $order = invoice::find($id);

        if(Auth::user()->role != 'admin'){
            if (Auth::user()->id != $order->user_id) {
                return redirect(route('home'));
            }
        }

        $products = $order->product;
        $address = explode(' ,', $order->address);

        return view('order')->with([
            'order' => $order,
            'products' => $products,
            'address' => $address,
        ]);
    }

    public function update($id){
        $invoiceUpdate = invoice::where('id', '=', $id)->first();
        
        if($invoiceUpdate->status === 'In Progress' && Auth::user()->role === 'admin'){
            $invoiceUpdate->update([
                'status' => "In Delivery"
            ]);
            return redirect()->to('my-orders/'.$id)->with('success', 'The order has been delivered.');
        }elseif ($invoiceUpdate->status === 'In Delivery' && Auth::user()->role === 'user') {
            $invoiceUpdate->update([
                'status' => "Completed"
            ]);
            return redirect()->to('my-orders/'.$id)->with('success', 'Your order has been completed. Thank you for shopping with us.');
        }
    }
}
