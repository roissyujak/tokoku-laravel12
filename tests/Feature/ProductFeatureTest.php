<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function validData(Category $category, array $override = []): array
    {
        return array_merge([
            'name'        => 'Keyboard Mechanical',
            'price'       => 750000,
            'stock'       => 50,
            'category_id' => $category->id,
        ], $override);
    }

    public function test_halaman_produk_bisa_diakses(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/products')->assertStatus(200);
    }

    public function test_halaman_produk_menampilkan_data(): void
    {
        $user     = User::factory()->create();
        $category = Category::factory()->create();
        Product::factory()->create([
            'name'        => 'Laptop Testing',
            'category_id' => $category->id,
            'is_active'   => true, // index hanya menampilkan produk aktif
        ]);

        $this->actingAs($user)->get('/products')
            ->assertStatus(200)
            ->assertSee('Laptop Testing');
    }

    public function test_guest_tidak_bisa_akses_produk(): void
    {
        $this->get('/products')->assertRedirect('/login');
    }

    public function test_produk_bisa_dibuat_oleh_admin(): void
    {
        $admin    = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $this->actingAs($admin)->post('/products', $this->validData($category))
            ->assertRedirect('/products');

        $this->assertDatabaseHas('products', [
            'name'    => 'keyboard mechanical', // disimpan lowercase oleh mutator
            'price'   => 750000,
            'user_id' => $admin->id,
        ]);
    }

    public function test_seller_bisa_membuat_produk(): void
    {
        $seller   = User::factory()->create(['role' => 'seller']);
        $category = Category::factory()->create();

        $this->actingAs($seller)->post('/products', $this->validData($category))
            ->assertRedirect('/products');

        $this->assertDatabaseHas('products', ['user_id' => $seller->id]);
    }

    public function test_customer_tidak_bisa_membuat_produk(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $category = Category::factory()->create();

        $this->actingAs($customer)->post('/products', $this->validData($category))
            ->assertForbidden();

        $this->assertDatabaseCount('products', 0);
    }

    public function test_validasi_nama_produk_wajib(): void
    {
        $admin    = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $this->actingAs($admin)
            ->post('/products', $this->validData($category, ['name' => '']))
            ->assertSessionHasErrors('name');
    }

    public function test_seller_hanya_bisa_mengubah_produk_miliknya(): void
    {
        $seller   = User::factory()->create(['role' => 'seller']);
        $other    = User::factory()->create(['role' => 'seller']);
        $category = Category::factory()->create();

        $own   = Product::factory()->create(['category_id' => $category->id, 'user_id' => $seller->id]);
        $alien = Product::factory()->create(['category_id' => $category->id, 'user_id' => $other->id]);

        $this->actingAs($seller)
            ->put("/products/{$own->id}", $this->validData($category))
            ->assertRedirect("/products/{$own->id}");

        $this->actingAs($seller)
            ->put("/products/{$alien->id}", $this->validData($category))
            ->assertForbidden();
    }

    public function test_hanya_admin_yang_bisa_menghapus_produk(): void
    {
        $seller   = User::factory()->create(['role' => 'seller']);
        $admin    = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        $product  = Product::factory()->create(['category_id' => $category->id, 'user_id' => $seller->id]);

        $this->actingAs($seller)->delete("/products/{$product->id}")->assertForbidden();
        $this->assertDatabaseHas('products', ['id' => $product->id]);

        $this->actingAs($admin)->delete("/products/{$product->id}")->assertRedirect('/products');
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_dashboard_admin_hanya_untuk_admin(): void
    {
        $admin    = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);

        $this->actingAs($admin)->get('/admin/dashboard')->assertStatus(200);
        $this->actingAs($customer)->get('/admin/dashboard')->assertForbidden();
    }
}
