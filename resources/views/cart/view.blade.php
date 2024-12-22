@extends('layouts.app')
@vite('resources/scss/app.scss')
@section('title', 'Your Cart')

@section('content')
    <div class="container">
        <h2>Your Shopping Cart</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['description'] }}</td>
                            <td>${{ number_format($item['price'], 2) }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                            <td>
                                <a href="{{ route('cart.remove', $id) }}" class="btn btn-danger">Remove</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div>
                <h3>Total: ${{ number_format($total, 2) }}</h3>
            </div>

            <div>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Continue Shopping</a>
                <a href="{{ route('checkout') }}" class="btn btn-primary">Checkout</a>
            </div>
        @else
            <p>Your cart is empty.</p>
        @endif
    </div>
@endsection
