<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Unit;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Picqer\Barcode\BarcodeGeneratorHTML;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve the 'row' query parameter, defaulting to 10 if not provided
        $row = (int) request('row', 10);

        // Validate that 'row' is an integer between 1 and 100
        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        // Fetch products with related category and unit, apply filtering and sorting, and paginate the results
        $products = Product::with(['category', 'unit'])
                ->filter(request(['search']))
                ->sortable()
                ->paginate($row)
                ->appends(request()->query());

        // Return the view with the paginated products
        return view('products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create', [
            'categories' => Category::all(),
            'units' => Unit::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());

        /**
         * Handle upload image
         */
        if($request->hasFile('product_image')){
            $file = $request->file('product_image');
            $filename = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();

            $file->storeAs('products/', $filename, 'public');
            $product->update([
                'product_image' => $filename
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Generate a barcode
        $generator = new BarcodeGeneratorHTML();

        $barcode = $generator->getBarcode($product->product_code, $generator::TYPE_CODE_128);

        return view('products.show', [
            'product' => $product,
            'barcode' => $barcode,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', [
            'categories' => Category::all(),
            'units' => Unit::all(),
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->except('product_image'));

        /**
         * Handle upload an image
         */
        if($request->hasFile('product_image')){

            // Delete Old Photo
            if($product->product_image){
                unlink(public_path('storage/products/') . $product->product_image);
            }

            // Prepare New Photo
            $file = $request->file('product_image');
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();

            // Store an image to Storage
            $file->storeAs('products/', $fileName, 'public');

            // Save DB
            $product->update([
                'product_image' => $fileName
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        /**
         * Delete photo if exists.
         */
        if($product->product_image){
            unlink(public_path('storage/products/') . $product->product_image);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product has been deleted!');
    }

    /**
     * Handle export data products.
     */
    public function import()
    {
        return view('products.import');
    }

    public function handleImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx',
        ]);

        $the_file = $request->file('file');

        try{
            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range( 2, $row_limit );
            $column_range = range( 'J', $column_limit );
            $startcount = 2;
            $data = array();
            foreach ( $row_range as $row ) {
                $data[] = [
                    'product_name' => $sheet->getCell( 'A' . $row )->getValue(),
                    'category_id' => $sheet->getCell( 'B' . $row )->getValue(),
                    'unit_id' => $sheet->getCell( 'C' . $row )->getValue(),
                    'product_code' => $sheet->getCell( 'D' . $row )->getValue(),
                    'stock' => $sheet->getCell( 'E' . $row )->getValue(),
                    'buying_price' => $sheet->getCell( 'F' . $row )->getValue(),
                    'selling_price' =>$sheet->getCell( 'G' . $row )->getValue(),
                    'product_image' =>$sheet->getCell( 'H' . $row )->getValue(),
                ];
                $startcount++;
            }

            Product::insert($data);

        } catch (Exception $e) {
            // $error_code = $e->errorInfo[1];
            return redirect()
                ->route('products.index')
                ->with('error', 'There was a problem uploading the data!');
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Data product has been imported!');
    }


    /**
     * Handle the export of product data to an Excel file.
     */
    function export()
    {
        // Retrieve all products and sort them by product name
        $products = Product::all()->sortBy('product_name');

        // Initialize an array with the column headers for the Excel export
        $product_array[] = array(
            'Product Name',
            'Category Id',
            'Unit Id',
            'Product Code',
            'Stock',
            'Buying Price',
            'Selling Price',
            'Product Image',
        );

        // Add each product to the data array
        foreach($products as $product) {
            $product_array[] = array(
                $product->product_name,
                $product->category_id,
                $product->unit_id,
                $product->product_code,
                $product->stock,
                $product->buying_price,
                $product->selling_price,
                $product->product_image,
            );
        }

        // Call the method to export the data to an Excel file
        $this->exportExcel($product_array);
    }

    /**
     * Convert product data to an Excel file and initiate download.
     * 
     * @param array $products - The array of products to export
     */
    public function exportExcel($products)
    {
        // Increase maximum execution time and memory limit to handle large data
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');

        try {
            // Create a new instance of Spreadsheet
            $spreadSheet = new Spreadsheet();
            $sheet = $spreadSheet->getActiveSheet();

            // Add styles to the headers
            $headerStyle = [
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFFF00',
                    ],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ];

            // Apply styles to the headers
            $sheet->fromArray($products, NULL, 'A1');
            $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

            // Auto-size columns based on content
            foreach(range('A', $sheet->getHighestColumn()) as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            // Create a new sheet for additional information
            $infoSheet = $spreadSheet->createSheet();
            $infoSheet->setTitle('General Information');
            $infoSheet->setCellValue('A1', 'Export Date');
            $infoSheet->setCellValue('B1', date('Y-m-d H:i:s'));
            $infoSheet->setCellValue('A2', 'Total Products');
            $infoSheet->setCellValue('B2', count($products) - 1); // Including header

            // Create a writer to generate an Excel file in .xls format
            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="products.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean(); // Clean output buffer to avoid unwanted characters
            $Excel_writer->save('php://output'); // Save the Excel file to output stream (download)
            exit(); // End script to avoid any additional output
        } catch (Exception $e) {
            // In case of an exception, simply return without doing anything
            return;
        }
    }
}