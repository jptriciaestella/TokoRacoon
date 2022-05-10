<?php

namespace App\Http\Controllers;

use App\product;
use App\Http\Requests\productRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;

class productController extends Controller
{
    public function create(){
        return view('CRUD.create');
    }

    public function showForm(productRequest $request){
        $path = $request->file('image')->store('public/images');
        $path = substr($path, strlen('public/'));
        $product = product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'user_id' => Auth::user()->id,
            'image' => $path,
        ]);
        $product->category()->attach($request->category);

        session()->flash('success', 'Your product has been created.');

        return redirect(route('home'));
    }

    public function ViewAll(){
        $products = product::all();
        return view('CRUD.viewAll', ['datas' => $products]);
    }

    public function ViewProduct($id){
        $products = product::find($id);
        return view('CRUD.view', ['product' => $products]);
    }

    public function UpdateForm($id){
        $products = product::find($id);
        return view('CRUD.update', ['product' => $products]);
    }

    public function ShowUpdateForm(productRequest $request, $id){
        $productUpdate = product::where('id', '=', $id)->first();
        $path = $request->file('image')->store('public/images');
        $path = substr($path, strlen('public/'));
        if($productUpdate->image)
        {
            Storage::disk('public')->delete($productUpdate->image);
        }
        $productUpdate->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'user_id' => Auth::user()->id,
            'image' => $path,
        ]);
        $productUpdate->category()->sync($request->category);

        session()->flash('success', 'Your product has been updated.');

        return redirect(route('home'));
    }

    public function DeleteProduct($id){
        $ProductDelete = product::find($id);
        $ProductDelete->category()->detach();
        Storage::disk('public')->delete($ProductDelete->image);
        

        $ProductDelete->delete();

        session()->flash('success', 'Your product has been deleted.');

        return redirect(route('home'));
    }
}
