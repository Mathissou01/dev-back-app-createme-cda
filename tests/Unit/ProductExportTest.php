<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_export()
    {
        // Create categories and units
        $category = Category::factory()->create();
        $unit = Unit::factory()->create();

        // Seed the database with test data
        Product::factory()->count(10)->create([
            'category_id' => $category->id,
            'unit_id' => $unit->id,
        ]);

        // Mock the response headers to capture output
        $this->withoutMiddleware();
        $this->withoutExceptionHandling();

        // Call the export method
        $response = $this->get(route('products.export'));

        // Assert the response status
        $response->assertStatus(200);

        // Assert headers for file download
        $this->assertStringContainsString(
            'application/vnd.ms-excel',
            $response->headers->get('Content-Type')
        );
        $this->assertStringContainsString(
            'attachment;filename="products.xls"',
            $response->headers->get('Content-Disposition')
        );

        // Save the response content to a temporary file
        $tempFile = tempnam(sys_get_temp_dir(), 'products') . '.xls';
        file_put_contents($tempFile, $response->getContent());

        // Load the generated Excel file
        $spreadsheet = IOFactory::load($tempFile);
        $sheet = $spreadsheet->getActiveSheet();

        // Assert the headers
        $expectedHeaders = [
            'Product Name',
            'Category Id',
            'Unit Id',
            'Product Code',
            'Stock',
            'Buying Price',
            'Selling Price',
            'Product Image',
        ];

        $actualHeaders = $sheet->rangeToArray('A1:H1')[0];
        $this->assertEquals($expectedHeaders, $actualHeaders);

        // Assert the data
        $products = Product::with(['category', 'unit'])->get();
        $rowIndex = 2; // Data starts from the second row

        foreach ($products as $product) {
            $expectedRow = [
                $product->product_name,
                $product->category_id,
                $product->unit_id,
                $product->product_code,
                $product->stock,
                $product->buying_price,
                $product->selling_price,
                $product->product_image,
            ];

            $actualRow = $sheet->rangeToArray("A{$rowIndex}:H{$rowIndex}")[0];
            $this->assertEquals($expectedRow, $actualRow);

            $rowIndex++;
        }

        // Clean up
        unlink($tempFile);
    }
}

