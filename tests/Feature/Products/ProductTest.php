<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_products_can_be_indexed()
    {
        $response = $this->get('/products');
        $response->assertStatus(200);
    }

    public function test_product_can_be_shown()
    {
        $product = Product::factory()->create();
        $response = $this->get('products/' . $product->getkey());
        $response->assertStatus(200);
    }

    public function test_product_can_be_stored()
    {
        $attributes = [
            'sku' => 'Test_produst',
            'name' => 'Test name',
            'price' => 800,
        ];
        $response = $this->post('/products', $attributes);
        $response->assertStatus(201);
         

        $this->assertDatabaseHas('products', $attributes);
    }

    public function test_product_can_be_updated()
    {
        $product = Product::factory()->create();
        $attributes = [
            'sku' => 'Test_produst2',
            'name' => 'Test name',
            'price' => 800,
        ];

        $response = $this->patch('/products/' . $product->getKey(), $attributes);
        $response->assertStatus(202);
        $this->assertDatabaseHas('products', array_merge(
            ['id' =>$product->getKey()], $attributes
        ));
    }

    public function test_product_can_be_destroyed()
    {
        $product = Product::factory()->create();
        $response = $this->delete('/products/' . $product->getKey());
        $response->assertStatus(204);

        $this->assertDatabaseMissing('products', ['id' => $product->getkey()]);
    }
}
