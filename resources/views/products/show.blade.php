@extends('layouts.app')
@vite('resources/scss/app.scss')
@section('title', 'Product Details')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Product Details</h2>
                    </div>

                    <div class="card-body">
                        <!-- Product Information -->
                        <div class="product-details">
                            <h3>{{ $product->name }}</h3>
                            <p><strong>Description:</strong> {{ $product->description }}</p>
                            <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                            <p><strong>Stock:</strong> {{ $product->stock }}</p>
                        </div>

                        <!-- Back to Product List Button -->
                        <div class="mt-3">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
