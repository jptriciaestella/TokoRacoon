@extends('layouts.app')

@section('content')

<!-- VIEW PRODUCTS -->
    <div style="margin:30px"></div>
    @if(Session::get('success'))
        <div class = "container">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{Session::get('success')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="album py-5" id="view-books">
        
        <div class="container d-flex">
        <div style="padding-top:70px; width:30%">
            <h5 style="margin-bottom:20px">By Categories</h5>
            <ul class="list-unstyled" >
                @foreach ($categories as $category)
                    <li style="margin-bottom:10px">
                        <a class="text-reset text-decoration-none" href="{{ route('home', ['category' => $category->category_name])}}">
                            {{$category->category_name}}
                        </a>
                    </li>
                @endforeach
                <li style="margin-bottom:10px">
                        <br><br><br><br><br>
                        <a class="text-reset text-decoration-none" href="{{ route('home') }}">
                            Show All
                        </a>
                </li>
            </ul>
        </div>
        
        <div style="width:70%">
            <div class="d-flex align-items-center justify-content-between" style="margin-bottom:30px">
                <h2>
                @if(request()->category)
                    {{request()->category}}
                @else
                    All products
                @endif
                </h2>
                <div>
                    <strong>Price: </strong>
                    <a class="text-reset text-decoration-none" href="{{ route('home', ['category'=> request()->category, 'sort' => 'low_high']) }}">Low to High</a> |
                    <a class="text-reset text-decoration-none" href="{{ route('home', ['category'=> request()->category, 'sort' => 'high_low']) }}">High to Low</a>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <!-- ADD NEW PRODUCT -->
                @if(Auth::user()->role == "admin")
                    <a href = "{{route('create')}}" class="text-decoration-none">
                        <div class="col add">
                            <div class="card shadow-sm">
                                <img src="https://cdn.pixabay.com/photo/2017/04/20/07/07/add-2244771_960_720.png" alt="" width="100%" height="225" style="object-fit:cover">
                                <div class="card-body d-flex flex-column justify-content-center" style="height:175px;">
                                <h5 class="card-title text-dark">Click here to add a new product to the website.</h5>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif

                <!-- VIEW ALL Products -->
                @include('CRUD.viewAll')

                <div style="margin:100px"></div>
            </div>
        </div>
        
    </div>

@endsection
