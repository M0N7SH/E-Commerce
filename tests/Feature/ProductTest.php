<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_product()
    {
        // Create a product
        $productData = [
            'name' => 'Test Product',
            'price' => 100.00,
            'description' => 'Test description',
            'stock' => 50,
        ];

        $response = $this->post('/products', $productData);

        // Assert the product is created in the database
        $this->assertDatabaseHas('products', $productData);

        // Assert the response redirects to the product index or show page
        $response->assertRedirect('/products');
    }
}
