@extends('layouts.app')

@section('content')

<div style="margin:80px"></div>

<div class="products-header">
    @if(Auth::user()->role == "admin")
        <h2 class="text-center py-3" style="margin-bottom:20px">All Orders</h2>
    @else
        <h2 class="text-center py-3" style="margin-bottom:20px">My Orders</h2>
    @endif
</div>

<div style="margin:40px"></div>

<div>
    @foreach ($datas as $order)
    <div class="container">
        <div class="card">
            <div class = "card-body">
                <div class="card-title d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Order ID: </strong> {{ $order->id }}
                        <span style="margin:0 20px"></span>
                        <strong>Placed: </strong> {{ $order->created_at }}
                    </div>
                    @if ($order->status == "Completed")
                        <div class="btn btn-outline-success disabled">{{$order->status}}</div>
                    @elseif ($order->status == "In Progress")
                        <div class="btn btn-outline-secondary disabled">{{$order->status}}</div>
                    @elseif ($order->status == "In Delivery")
                        <div class="btn btn-outline-primary disabled">{{$order->status}}</div>
                    @endif
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center" style="width:70%">
                        <img src="{{('/storage/').$order->product[0]->image}}" alt="Product1" class="border-primary rounded" height="200px">
                        <div style="margin-left:20px;">
                            <h4><a class="link-secondary text-decoration-none" href="{{ route ('ViewProduct', $order->product[0]->id) }}">{{ $order->product[0]->name }}</a></h4>
                            <span>{{ $order->product[0]->pivot->quantity }} item × Rp. {{number_format($order->product[0]->price,2)}}</span>
                            <div>
                                @if(count($order->product)>1)
                                    <br>
                                    &emsp;+{{count($order->product)-1}} other items
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="d-flex" style="height: 200px;margin: 10px;">
                        <div class="vr"></div>
                    </div>
                    <div style="width:20%">
                    @if(Auth::user()->role == "admin")
                        <h4>Total Income</h4>
                    @else
                        <h4>Total Shopping</h4>
                    @endif
                        <h5 class="fw-normal">Rp. {{number_format($order->total,2)}}</h5>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a class="link-primary text-decoration-none" href="{{ route('orders.show', $order->id) }}" >
                    <h5 style="margin:20px 0;">Order Details &#8594;</h5>
                </a>
            </div>
        </div>

        <div style="margin:40px"></div>

    </div> <!-- end order-container -->
    @endforeach
</div>

<div style="margin:100px"></div>
@endsection('content')