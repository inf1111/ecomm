@extends('layouts.app')


@section('content')


    <div class="site-section block-3 site-blocks-2 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 site-section-heading text-center pt-4">
                    <h2>Featured Products</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="nonloop-block-3 owl-carousel">

                        @foreach($products as $product)

                            <div class="item">
                                <div class="block-4 text-center">
                                    <figure class="block-4-image">
                                        <a href="{{ route("show-product", ["product_id" => $product->id]) }}">
                                            <img src="{{ Storage::url($product->image) }}" alt="Image placeholder" class="img-fluid">
                                        </a>
                                    </figure>
                                    <div class="block-4-text p-4">
                                        <h3><a href="{{ route("show-product", ["product_id" => $product->id]) }}">{{ $product->name }}</a></h3>
                                        <p class="mb-0">{{ $product->description }}</p>
                                        <p class="text-primary font-weight-bold">${{ $product->price }}</p>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection