<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page with product listings and cart.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all products to display on the home page
        $products = Product::all();

        // Return the home view with the products data
        return view('home', compact('products'));
    }
}
