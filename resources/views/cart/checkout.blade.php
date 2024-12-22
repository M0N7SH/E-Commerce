@extends('layouts.app')
@vite('resources/scss/app.scss')
@section('title', 'Checkout')

@section('content')
    <div class="container">
        <h2>Checkout</h2>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('processCheckout') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h3>Your Cart</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $item)
                                <tr>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>${{ number_format($item['price'], 2) }}</td>
                                    <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h4>Total: ${{ number_format($total, 2) }}</h4>
                </div>

                <div class="col-md-6">
                    <h3>Billing Information</h3>
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" class="form-control" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Place Order</button>
                </div>
            </div>
        </form>
        <hr>

        <!-- Product Suggestions Section -->
        <h3>Product Suggestions</h3>
        <div>
            <input type="text" id="productNameInput" class="form-control" placeholder="Enter a product name">
            <button id="suggestButton" class="btn btn-secondary mt-2">Get Suggestions</button>
        </div>
        <div id="suggestions" class="mt-3">
            <!-- Suggestions will be displayed here -->
        </div>
    </div>

    <script>
    document.getElementById('suggestButton').addEventListener('click', async function () {
    const productName = document.getElementById('productNameInput').value;

    if (!productName) {
        alert('Please enter a product name');
        return;
    }

    try {
        const response = await fetch('https://api.google.com/generative-ai', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer YOUR_API_KEY'  // Add your API key here
            },
            body: JSON.stringify({
                model: 'gemini-1.5-flash',
                prompt: `Suggest three products similar to ${productName}`
            })
        });

        // Check if the response is okay (200 status)
        if (response.ok) {
            const data = await response.json();
            const suggestions = data.suggestions;
            const suggestionsDiv = document.getElementById('suggestions');
            suggestionsDiv.innerHTML = ''; // Clear previous suggestions

            if (suggestions && suggestions.length > 0) {
                suggestions.forEach(product => {
                    const suggestion = document.createElement('div');
                    suggestion.textContent = `${product.name} - $${product.price}`;
                    suggestionsDiv.appendChild(suggestion);
                });
            } else {
                suggestionsDiv.innerHTML = '<p>No suggestions found.</p>';
            }
        } else {
            console.error('Failed to fetch data:', response.statusText);
            alert('An error occurred while fetching product suggestions.');
        }

    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while fetching product suggestions.');
    }
});

    </script>
@endsection
