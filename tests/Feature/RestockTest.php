<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Fragrance;
use App\Models\Product;

class RestockTest extends TestCase
{
    use RefreshDatabase;

    public function testFragranceQuery()
    {
        // Setup: Create a product and a corresponding fragrance
        $product = Product::factory()->create();
        $fragrance = Fragrance::factory()->create(['product_id' => $product->id]);

        // Act: Call the restock endpoint with the product_id
        $response = $this->postJson('/api/restock', ['product_id' => $product->id, 'total_weight' => 500]);

        // Assert: Check if the fragrance was found and used correctly
        $response->assertStatus(200);
        $this->assertDatabaseHas('restocks', [
            'product_id' => $product->id,
            'fragrance_id' => $fragrance->branch_id
        ]);
    }

    public function testFragranceNotFound()
    {
        // Setup: Create a product without a corresponding fragrance
        $product = Product::factory()->create();

        // Act: Call the restock endpoint with the product_id
        $response = $this->postJson('/api/restock', ['product_id' => $product->id, 'total_weight' => 500]);

        // Assert: Check if the response indicates fragrance not found
        $response->assertStatus(400)
                ->assertJson(['message' => 'Fragrance not found']);
    }
}
