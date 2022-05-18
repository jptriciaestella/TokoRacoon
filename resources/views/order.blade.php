@extends('layouts.app')

@section('content')

<div style="margin:80px"></div>

@if(Session::get('success'))
    <div class = "container">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{Session::get('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

<div class="container">
    <div class="row">
        <!-- BEGIN INVOICE -->
        <div class="card p-5">
            <div class="d-grid">
                <div class="grid-body">
                    <div class="invoice-title">
                        <div class="row">
                            <div class="col-sm">
                                <img src="https://cdn.picpng.com/raccoon/photo-raccoon-23858.png" alt="" height="75">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm">
                                <h2>INVOICE<br>
                                <span class="small">Order #{{$order->id}}</span></h2>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm">
                            <address>
                                <strong>Shipped To:</strong><br>
                                {{$order->name_address}}<br>
                                {{$address[0]}}<br>
                                @for($i = 1; $i < count($address); $i++)
                                    {{$address[$i]}}
                                    @if($i != count($address)-1)
                                        {{__(',')}}
                                    @endif
                                @endfor
                                ZIP: {{$order->postal_code}}
                            </address>
                        </div>
                        <div class="col-sm">
                            <address>
                                <strong>Billed To:</strong><br>
                                {{Auth::user()->name}}<br>
                                {{Auth::user()->email}}<br>
                                Phone: {{Auth::user()->phoneNo}}
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <address>
                                <strong>Order Date:</strong><br>
                                {{$order->created_at}}
                            </address>
                        </div>
                        <div class="col-sm">
                            <address>
                                <strong>Payment Method:</strong><br>
                                Cash On Delivery<br>
                            </address>
                        </div>
                    </div>
                    <div style="margin:20px"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>ORDER SUMMARY</h3>
                            <table class="table table-striped">
                                <thead>
                                    <tr class="line">
                                        <td><strong>#</strong></td>
                                        <td class="text-center"><strong>PRODUCT NAME</strong></td>
                                        <td class="text-center"><strong>PRICE</strong></td>
                                        <td class="text-center"><strong>QUANTITY</strong></td>
                                        <td class="text-right"><strong>SUBTOTAL</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="d-flex">
                                            <div style="margin:10px"></div>
                                            <img src="{{asset('storage/'.$product->image)}}" alt="Product" style="width:70px !important;">
                                            <div style="margin:20px"></div>
                                            <div>
                                                <strong>{{$product->name}}</strong><br>
                                                @foreach ($product->category as $category)
                                                    @if ($loop->last)
                                                        {{$category->category_name}}
                                                    @else
                                                        {{$category->category_name}},
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="text-center">Rp. {{number_format($product->price, 2)}}</td>
                                        <td class="text-center">{{$product->pivot->quantity}}</td>
                                        <td class="text-right">Rp. {{number_format($product->price*$product->pivot->quantity, 2)}}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="text-right"><strong>Subtotal</strong></td>
                                        <td class="text-right"><strong>Rp. {{number_format($order->total-$order->tax, 2)}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="text-right"><strong>Taxes</strong></td>
                                        <td class="text-right"><strong>Rp. {{number_format($order->tax, 2)}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                        </td><td class="text-right"><strong>Total</strong></td>
                                        <td class="text-right"><strong>Rp. {{number_format($order->total, 2)}}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>									
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-5">
                        <div>
                            <p>Ordered From<br><strong>Toko Racoon</strong></p>
                        </div>
                        @if(Auth::user()->role == "admin" && $order->status == "In Progress")
                            <div>
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#deliverOrder">Deliver Order</button>
                            </div>
                        @elseif(Auth::user()->role == "admin" && $order->status == "In Delivery")
                            <div>
                                <button class="btn btn-outline-primary disabled">Delivered</button>
                            </div>
                        @elseif(Auth::user()->role == "user" && $order->status == "In Delivery")
                            <div>
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#finishOrder">Finish Order</button>
                            </div>
                        @elseif($order->status == "Completed")
                            <div>
                                <button class="btn btn-outline-success disabled">Completed</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- END INVOICE -->
        <div style="margin:80px"></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deliverOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog" style="height:100vh!important;">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Deliver Order #{{$order->id}}?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            This action cannot be undone! The status of this order will change into "In Delivery".
        </div>
        <div class="modal-footer">
            <form action="{{ route('orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('Patch')
                <div class="d-flex">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <div style="margin:3px"></div>
                    <button type="submit" class="btn btn-primary">Deliver</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>


<div class="modal fade" id="finishOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog" style="height:100vh!important;">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Finish Order #{{$order->id}}?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            This action cannot be undone! The status of this order will change into "Completed".
        </div>
        <div class="modal-footer">
            <form action="{{ route('orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('Patch')
                <div class="d-flex">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <div style="margin:3px"></div>
                    <button type="submit" class="btn btn-primary">Complete</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>

@endsection('content')