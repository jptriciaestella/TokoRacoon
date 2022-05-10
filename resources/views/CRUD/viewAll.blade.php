@if ($datas->count() > 0)
    @foreach ($datas as $product)
        <div class="col">
            <a href="{{ route ('ViewProduct', $product->id) }}" class="text-decoration-none text-dark">
                <div class="card shadow-sm">
                    <img src="{{('/storage/').$product->image}}" alt="" width="100%" height="225" style="object-fit:cover">
                    <div class="card-body" style="height:175px; overflow-y:auto;">
                        <h4 class="card-title">{{ $product->name}}</h4>
                        <h5 class="card-text">Rp. {{$product->price}}</h5>
                        <p class="card-text" style="margin-bottom:15px !important;">{{$product->stock}} left</p>
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <small class="text-muted">
                            @foreach ($product->category as $category)
                                @if ($loop->last)
                                    {{$category->category_name}}
                                @else
                                    {{$category->category_name}},
                                @endif
                            @endforeach
                            </small>
                            <div class="d-flex">
                            @if(Auth::user()->role == "admin")
                                <a class="btn btn-sm btn-outline-success" href="{{ route ('UpdateForm', $product->id) }}">Edit</a>
                                <div style="margin:3px"></div>
                                <a class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal"> Delete </a>
                            @else
                                <a class="btn btn-sm btn-outline-success" href="">Add to cart</a>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

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
    @endforeach
@else
    <h1 class="flex w-100 text-center text-muted">
        No product available currently. Please check back later.
    </h1>
@endif
