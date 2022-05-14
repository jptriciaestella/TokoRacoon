@extends('layouts.app')

@section('content')

<div style="margin:80px"></div>

<div class="container newPage">
    <form method="POST" action="{{ route('Update', $product->id) }}" enctype="multipart/form-data">
        <div class="card">
            <h3 class="card-header" style="padding:1rem">{{ __('Update Product') }}</h3>
            
                <div class="card-body px-5">
                    @csrf
                    @method('Patch')
                    <div style="margin:20px"></div>
                    <div class="form-row">
                        <div class="name mb-2 h5">{{ __('Product Name *') }}</div>
                        <div class="col-md-20">
                            <input id="name" type="text" class="form-control" name="name" placeholder="Enter Product Name" value="{{ old( 'name', $product->name) }}">

                            @error('name')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                
                    <hr style="margin: 1.5rem 0">

                    <div class="form-row">
                        <div class="name mb-2 h5">{{ __('Price *') }}</div>
                        <div class="col-md-20">
                        <input id="price" type="text" class="form-control" name="price" placeholder="Enter Product's Price" value="{{old('price', $product->price)}}">

                        @error('price')
                            <div class="text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                        </div>
                    </div>

                    <hr style="margin: 1.5rem 0">

                    <div class="form-row">
                        <div class="name mb-2 h5">{{ __('Stock *') }}</div>
                        <div class="col-md-20">
                            <input id="stock" type="text" class="form-control" name="stock" placeholder="Enter Product's Stock" value="{{old('stock', $product->stock)}}">

                            @error('stock')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <hr style="margin: 1.5rem 0">

                    <div class="form-row">
                        <div class="name mb-2 h5">{{ __('Category (Optional)') }}</div>
                        <div class="text-warning" style="margin: 5px 0px; font-size: 12px;">
                            The category will remain the same if you don't fill the following field.
                        </div>
                        <div class="col-md-20">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="category[]">
                                <label class="form-check-label" for="inlineCheckbox1">Beauty and Health</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="2"  name="category[]">
                                <label class="form-check-label" for="inlineCheckbox2">Technology</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="3" name="category[]">
                                <label class="form-check-label" for="inlineCheckbox3">Hobby</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="4" name="category[]">
                                <label class="form-check-label" for="inlineCheckbox4">Fashion</label>
                                </div>
                            @error('category')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <hr style="margin: 1.5rem 0">

                    <div class="form-row">
                        <div class="name mb-2 h5">{{ __('New Product Picture (Optional)') }}</div>
                        <div class="text-warning" style="margin: 5px 0px; font-size: 12px;">
                            The picture will remain the same if you don't fill the following field.
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control" id="image" name="image" onchange="previewImage()">
                        </div>
                        @error('image')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                        @enderror
                    </div>

                    <div style="margin:50px"></div>
                </div>

                <div class="card-footer d-flex flex-row-reverse" style="padding:1rem">
                        <button class="btn btn-warning" type="submit">Update Product</button>
                </div>
        </div>
    </form>
</div>

<div style="margin:60px"></div>

@endsection