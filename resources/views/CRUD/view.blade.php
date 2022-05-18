@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6">
                @if($product->image)
                    <img class="card-img-top mb-5 mb-md-0 rounded" src="{{asset('storage/'.$product->image)}}" alt="" style="object-fit:cover">
                @else
                    <img class="card-img-top mb-5 mb-md-0 rounded border border-dark" src="https://st3.depositphotos.com/23594922/31822/v/600/depositphotos_318221368-stock-illustration-missing-picture-page-for-website.jpg" alt="" style="object-fit:cover">
                @endif
            </div>
            <div class="col-md-6">
                <div class="small mb-1">Last Updated:  {{$product->updated_at}}</div>
                <h1 class="display-4 fw-bolder">{{$product->name}}</h1>
                <h2 class="display-8 fw-bolder">Rp. {{number_format($product->price, 2)}}</h2>
                <div class="fs-2 mb-5">
                    <span>{{$product->stock}} left</span>
                </div>
                <p class="lead">
                    @foreach ($product->category as $category)
                        @if ($loop->last)
                            {{$category->category_name}}
                        @else
                            {{$category->category_name}},
                        @endif
                    @endforeach
                </p>
                <div class="d-flex">
                    @if(Auth::user()->role == "admin")
                        <a class="btn btn-outline-success flex-shrink-0" href="{{ route ('UpdateForm', $product->id) }}">Update</a>
                        <div style="margin:3px"></div>
                        <a class="btn btn-outline-danger flex-shrink-0" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</a>
                    @else
                        @if($product->stock > 0)
                        <form action="{{ route('cart.store', $product) }}" method="POST">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-outline-success flex-shrink-0">Add to Cart</button>
                        </form>
                        @else
                            <a class="btn btn-outline-danger flex-shrink-0 disabled">Sold Out</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<div style="margin:50px"></div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete {{$product->name}}?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            This action cannot be undone! 
            It's better to update the product stock then to delete the product completely, as deleting the product may affect order details. The order will show the correct Subtotal, Tax, and Total, but not all of the product listed if one of it is deleted.
        </div>
        <div class="modal-footer">
            <form action="{{route('DeleteProduct', $product->id)}}" method="POST">
                        @csrf
                        @method('Delete')
                <div class="d-flex">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <div style="margin:3px"></div>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
@endsection