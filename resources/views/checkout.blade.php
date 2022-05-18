@extends('layouts.app')

@section('content')
  <div style="margin:20px"></div>

  <form action="{{ route('checkout.store') }}" method="POST">
    @csrf
    <div class="container">
      <img class="d-block mx-auto" src="https://t3.ftcdn.net/jpg/02/61/01/54/360_F_261015425_k1TBTS5ql0BvHIqLnVE9Oj4A0Gt7smNT.jpg" style="margin-top:50px;margin-bottom:-10px"alt="" height="72">
      <h2 class="text-center py-3" style="margin-bottom:20px">Order Confirmation</h2>
      <div class="row justify-content-between">
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Billing address</h4>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="firstName">First name</label>
              <input type="text" class="form-control" name="firstName" id="firstName" placeholder="John" value="{{old('firstName')}}" required>
              @error('firstName')
                  <div class="text-danger mt-2">
                      {{ $message }}
                  </div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label for="lastName">Last name</label>
              <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Doe" value="{{old('lastName')}}" required>
              @error('lastName')
                  <div class="text-danger mt-2">
                      {{ $message }}
                  </div>
              @enderror
            </div>
          </div>

          <div class="mb-3">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" id="address" value="{{old('address')}}" placeholder="Jl. Magadascar No. 10" required>
            @error('address')
                <div class="text-danger mt-2">
                    {{ $message }}
                </div>
            @enderror
          </div>

          <div class="row">
            <div class="col-md-5 mb-3">
              <label for="zip">Country</label>
              <input type="text" class="form-control" name="country" id="country" value="{{old('country')}}" placeholder="Indonesia" required>
              @error('country')
                <div class="text-danger mt-2">
                    {{ $message }}
                </div>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label for="zip">City</label>
                  <input type="text" class="form-control" name="city" id="city" value="{{old('city')}}" placeholder="Jakarta" required>
                  @error('city')
                    <div class="text-danger mt-2">
                        {{ $message }}
                    </div>
                  @enderror
            </div>
            <div class="col-md-3 mb-3">
              <label for="zip">Zip</label>
              <input type="text" class="form-control" name="zip" id="zip" value="{{old('zip')}}" placeholder="11440" required>
              @error('zip')
                <div class="text-danger mt-2">
                    {{ $message }}
                </div>
              @enderror
            </div>
          </div>
              <hr class="mb-4">
              <div class="text-secondary mt-2">
                <strong>Billing Information: </strong>We only provide Cash On Delivery (COD) Payment for now. Please prepare your payment when your order is in delivery.
              </div>
        </div>
      
        <div class="col-md-3 order-md-2">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your cart</span>
            <span class="badge badge-warning badge-pill">{{Cart::instance('default')->count()}}</span>
          </h4>
          <ul class="list-group mb-3">
            @foreach (Cart::content() as $item)
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                  <h6 class="my-0">{{$item->model->name}}</h6>
                  <small class="text-muted">Qty: {{$item->qty}}</small>
                </div>
                <span class="text-muted">Rp. {{number_format($item->subtotal,2)}}</span>
              </li>
            @endforeach
           
            <li class="list-group-item d-flex justify-content-between">
              <div class="d-flex flex-column align-items-end">
                    <strong>Subtotal : </strong>
                    <strong>Tax (11%) : </strong>
                    <strong>Total : </strong>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <span class="text-medium">Rp. {{Cart::subtotal()}}</span>
                    <span class="text-medium">Rp. {{Cart::tax()}}</span>
                    <span class="text-medium">Rp. {{Cart::total()}}</span>
              </div>
            </li>
          </ul>
          <button class="btn btn-warning btn-lg btn-block" style="margin-top:20px;width:100%;" type="submit">Proceed</button>
        </div>  
      </div>
    </div>
  </form>

  <div style="margin:180px"></div>
@endsection