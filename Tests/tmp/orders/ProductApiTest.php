<?php

namespace Modules\Shop\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Shop\Models\Product;
use DataSDK\Categories\Models\Categories;
use App\Models\User; // <- importér din bruger-model
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(); // <- opret en autentificerbar bruger
    }

    public function test_it_can_list_products()
    {
        Product::factory()->count(3)->create();

        $response = $this->actingAs($this->user)->getJson(route('api.shop.products.index'));

        $response->assertStatus(200);
    }

    public function test_it_can_show_product()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)->getJson(route('api.shop.products.show', $product->id));

        $response->assertStatus(200);
    }

    public function test_it_can_create_product()
    {
        $category = Categories::factory()->create();

        $data = [
            'name' => 'Test Product',
            'description' => 'Test description',
            'slug' => 'test-product',
            'price' => 100.00,
            'category_id' => $category->id,
            'status' => 'active',
            'sorting' => 1,
        ];

        $response = $this->actingAs($this->user)->postJson(route('api.shop.products.store'), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('shop_products', ['slug' => 'test-product']);
    }

    public function test_it_can_update_product()
    {
        $product = Product::factory()->create();

        $data = ['name' => 'Updated Product'];

        $response = $this->actingAs($this->user)->putJson(route('api.shop.products.update', $product->id), $data);

        $response->assertStatus(200);

   
    }


    public function test_it_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)->deleteJson(route('api.shop.products.destroy', $product->id));

        $response->assertNoContent();

        $this->assertDatabaseMissing('shop_products', ['id' => $product->id]);
    }
}
