@extends('layouts.app')

@section('title', 'Home')
@vite('resources/scss/app.scss')
@section('content')
    <div class="container">
        <h1>Welcome to SimpleCart</h1>
        
        <!-- Display Product List -->
        <h2>Available Products</h2>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/150" alt="{{ $product->name }}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <p class="card-text">Price: ${{ $product->price }}</p>
                            <p class="card-text">Stock: {{ $product->stock }}</p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View Details</a>
                            <a href="{{ route('cart.add', $product->id) }}" class="btn btn-success">Add to Cart</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Cart and Checkout Links -->
        <div class="mt-4">
            <a href="{{ route('cart.view') }}" class="btn btn-info">View Cart</a>
            <a href="{{ route('checkout') }}" class="btn btn-warning">Checkout</a>
        </div>
    </div>
@endsection
