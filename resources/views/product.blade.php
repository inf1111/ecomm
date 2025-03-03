@extends('layouts.app')


@section('content')

    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0"><a href="{{ route('show-index') }}">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">{{ $product->name }}</strong></div>
            </div>
        </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img src="{{ Storage::url($product->image) }}" alt="Image" class="img-fluid">
          </div>
          <div class="col-md-6">
            <h2 class="text-black">{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
            <p><strong class="text-primary h4">${{ $product->price }}</strong></p>

              @auth()

                @livewire('add-to-cart', ['product' => $product])

              @endauth

          </div>
        </div>
      </div>
    </div>

@endsection