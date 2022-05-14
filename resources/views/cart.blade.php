@extends('layouts.app')

@section('content')

<div style="margin:100px"></div>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container padding-bottom-3x mb-1">
    <!-- Alert-->
    @if(Session::get('success'))
        <div class = "container" id="successAlert" style="margin-top:-40px">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <img class="d-inline align-center" 
            src="https://www.freeiconspng.com/thumbs/success-icon/success-icon-10.png" width="18" height="18">
                <strong>Success!</strong> {{Session::get('success')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @elseif(Session::get('errors'))
        <div class = "container" style="margin-top:-40px">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <img class="d-inline align-center" 
                src="https://freepikpsd.com/file/2019/11/danger-icon-png-Images.png" width="18" height="18">
                    <strong>Error!</strong>{{Session::get('errors')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
        </div>
    @endif

    <div class = "container" id="quantityError" style="margin-top:-40px;display:none;">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <img class="d-inline align-center" 
        src="https://freepikpsd.com/file/2019/11/danger-icon-png-Images.png" width="18" height="18">
            <strong>Error!</strong> <span id="error-msg"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
   
    <div style="margin:50px"></div>

    <!-- Shopping Cart-->
    @if((Cart::count() > 0))
        <div class="table-responsive shopping-cart">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Subtotal</th>
                        <th class="text-center">Delete items</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (Cart::content() as $item)
                    <tr>
                        <td>
                            <div class="product-item">
                                <a class="product-thumb" href="{{ route ('ViewProduct', $item->model->id) }}">
                                    <img src="{{asset('storage/'.$item->model->image)}}" alt="Product">
                                </a>
                                <div class="product-info">
                                    <h4 class="product-title"><a href="{{ route ('ViewProduct', $item->model->id) }}">{{$item->model->name}}</a></h4>
                                    <span><em>Category:</em>
                                    @foreach ($item->model->category as $category)
                                        @if ($loop->last)
                                            {{$category->category_name}}
                                        @else
                                            {{$category->category_name}},
                                        @endif
                                    @endforeach
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="count-input col-lg-2">
                            <div class="input-group">
                                <input class="form-control quantity" type="number" id="quantity" name="quantity" 
                                min="1" value="{{$item->qty}}" max="{{$item->model->stock}}" onblur=enforceMinMax(this) 
                                data-id="{{ $item->rowId }}" data-productQuantity="{{ $item->model->stock}}">
                            </div>

                            </div>
                        </td>
                        <td class="text-center text-lg text-medium">Rp. {{number_format($item->subtotal,2)}}</td>
                        <td class="text-center">
                            <form action="{{ route('cart.destroy', $item->rowId) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="cart-options">
                                        <a class="remove-from-cart" href="#" data-toggle="tooltip" title="" data-original-title="Remove item"><i class="fa fa-trash"></i></a>
                                    </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="shopping-cart-footer column d-flex justify-content-end" style="padding:20px 0px;">
            <div class="d-flex flex-column align-items-end">
                <strong>ITEMS&ensp;{{Cart::count()}} : </strong>
                <strong>TAX (11%) : </strong>
                <strong>TOTAL : </strong>
            </div>
            <div class="d-flex flex-column" style="margin-left:50px;margin-right:50px">
                <span class="text-medium">&nbsp;Rp. {{Cart::subtotal()}}</span>
                <span class="text-medium">&nbsp;Rp. {{Cart::tax()}}</span>
                <span class="text-medium">&nbsp;Rp. {{Cart::total()}}</span>
            </div>
        </div>
        <div class="shopping-cart-footer">
            <div class="column"><a class="btn btn-outline-secondary" href="{{route('home')}}">&#8592 Back to Shopping</a></div>
            <div class="column">
                <a class="btn btn-outline-success" href="{{route('checkout.index')}}">&nbsp;Checkout &#8594 &nbsp;</a>
            </div>
        </div>
    @else
        <div>
            <h3>No items in cart!<br><br></h3>
            <div class="column"><a class="btn btn-outline-secondary" href="{{route('home')}}">&#8592 Back to Shopping</a></div>
        </div>
    @endif
</div>

<div style="margin:100px"></div>

@endsection

@section('extra-js')
    <script>
        function enforceMinMax(el){
            if(el.value != ""){
                if(parseInt(el.value) < parseInt(el.min)){
                    el.value = el.min;
                }
                else if(parseInt(el.value) > parseInt(el.max)){
                    el.value = el.max;
                    document.getElementById("successAlert").style.display = 'none';
                    document.getElementById("error-msg").innerHTML = "Maximum quantity exceeded. We currently do not have enough items in stock.";
                    document.getElementById("quantityError").style.display = 'block';
                }else{
                    updateQuantity();
                }
            }else{
                document.getElementById("successAlert").style.display = 'none';
                document.getElementById("error-msg").innerHTML = "Quantity can't be empty.";
                document.getElementById("quantityError").style.display = 'block';
                el.value = 1;
            }
        }
        function updateQuantity(){
            document.getElementById("body-html").classList.remove('body-animate');
            document.getElementById("quantityError").style.display = 'none';
            const classname = document.querySelectorAll('.quantity')
            Array.from(classname).forEach(function(element) {
                const id = element.getAttribute('data-id')
                const productQuantity = element.getAttribute('data-productQuantity')
                axios.patch(`/cart/${id}`, {
                    quantity: element.value,
                    productQuantity: productQuantity
                })
                .then(function (response) {
                    // console.log(response);
                    window.location.href = '{{ route('cart.index') }}'
                })
                .catch(function (error) {
                    // console.log(error);
                    window.location.href = '{{ route('cart.index') }}'
                });
            })
        }
        window.onload = function removeAnim(){
            document.getElementById("body-html").classList.remove('body-animate');
        }
    </script>
@endsection