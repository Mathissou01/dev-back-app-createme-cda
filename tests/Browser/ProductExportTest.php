<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductExportTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testExportProducts()
    {
        // Create categories and units for test products
        $category = Category::factory()->create();
        $unit = Unit::factory()->create();

        // Seed the database with test data (10 products)
        Product::factory()->count(10)->create([
            'category_id' => $category->id,
            'unit_id' => $unit->id,
        ]);

        $this->browse(function (Browser $browser) {
            // Access the products page
            $browser->visit('/products')
                    // Click on the export button by its CSS class
                    ->click('.btn.btn-warning.add-list.my-1')
                    // Wait for the download file to be available
                    ->waitForDownload('products.xls')
                    // Verify that the file was downloaded successfully
                    ->assertDownloaded('products.xls');
        });
    }
}

