<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;

class CartController extends Controller
{
    /**
     * Add a product to the shopping cart.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addToCart($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Get the current cart from the session, or initialize an empty array
        $cart = Session::get('cart', []);

        // Check if the product already exists in the cart
        if (isset($cart[$id])) {
            // Increment the quantity if the product is already in the cart
            $cart[$id]['quantity']++;
        } else {
            // Add new product to the cart with quantity of 1
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'description' => $product->description,
            ];
        }

        // Save the updated cart back to the session
        Session::put('cart', $cart);

        // Redirect back to the product page or cart page with a success message
        return redirect()->route('products.index')->with('success', 'Product added to cart!');
    }

    /**
     * View the contents of the shopping cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCart()
    {
        // Get the cart from the session
        $cart = Session::get('cart', []);

        // Calculate the total price of items in the cart
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Return the view and pass cart data and total price
        return view('cart.view', compact('cart', 'total'));
    }

    /**
     * Remove a product from the shopping cart.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeFromCart($id)
    {
        // Get the cart from the session
        $cart = Session::get('cart', []);

        // Check if the product exists in the cart
        if (isset($cart[$id])) {
            // Remove the product from the cart
            unset($cart[$id]);
        }

        // Save the updated cart back to the session
        Session::put('cart', $cart);

        // Redirect back to the cart with a success message
        return redirect()->route('cart.view')->with('success', 'Product removed from cart!');
    }

    public function checkout()
    {
        // Get the cart from the session
        $cart = Session::get('cart', []);

        // If the cart is empty, redirect to the product page with a message
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }

        // Calculate the total price of the items in the cart
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Pass the cart data and total price to the checkout view
        return view('cart.checkout', compact('cart', 'total'));
    }

    /**
     * Process the checkout (e.g., create an order, process payment).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function processCheckout(Request $request)
    {
        // Get the cart from the session
        $cart = Session::get('cart', []);
    
        // If the cart is empty, redirect back to the product page with an error message
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }
    
        // Validate the checkout form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required|string|max:500',
            // Additional fields as needed
        ]);
    
        // Create an order in the database (you have the new order schema)
        $order = new \App\Models\Order();
        
        $order->id = rand(1, 1000);
        $order->name = $validated['name']; // Name from the form
        $order->email = $validated['email']; // Email from the form
        $order->address = $validated['address']; // Address from the form
        $order->total_price = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart)); // Calculate the total price of the cart
        $order->status = 'pending'; // Set the initial status
        $order->items = json_encode($cart); // Store the cart items as a JSON string
        $order->save();
    
        // Process the payment here (integrate payment gateway like Stripe or PayPal)
        // Note: You can add your payment processing logic here
    
        // Clear the cart after successful checkout
        session(['order' => $order]);
        Session::forget('cart');
    
        // Redirect to a success page
        return redirect()->route('order.success')->with('success', 'Your order has been placed!');
    }
}