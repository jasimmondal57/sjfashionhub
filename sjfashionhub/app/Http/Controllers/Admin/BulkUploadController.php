<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\VariantType;
use App\Models\SizeChart;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use GuzzleHttp\Client;

class BulkUploadController extends Controller
{
    public function index()
    {
        return view('admin.bulk-upload.index');
    }

    public function downloadSample()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = [
            'A1' => 'name*',
            'B1' => 'brand*',
            'C1' => 'category_name*',
            'D1' => 'price*',
            'E1' => 'mrp',
            'F1' => 'description',
            'G1' => 'short_description',
            'H1' => 'size',
            'I1' => 'color',
            'J1' => 'material',
            'K1' => 'pattern',
            'L1' => 'gender',
            'M1' => 'age_group',
            'N1' => 'image_urls',
            'O1' => 'tags',
            'P1' => 'sku',
            'Q1' => 'stock_quantity',
            'R1' => 'weight',
            'S1' => 'dimensions',
            'T1' => 'gtin',
            'U1' => 'mpn',
            'V1' => 'google_product_category',
            'W1' => 'condition',
            'X1' => 'warranty_period',
            'Y1' => 'return_days',
            'Z1' => 'seo_title',
            'AA1' => 'seo_description',
            'AB1' => 'seo_keywords'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
            $sheet->getStyle($cell)->getFont()->setBold(true);
        }

        // Add sample data
        $sampleData = [
            [
                'Cotton Casual T-Shirt for Men',
                'SJ Fashion',
                'T-Shirts',
                '599',
                '999',
                'Premium quality cotton t-shirt perfect for casual wear. Comfortable fit with breathable fabric.',
                'Comfortable cotton t-shirt for everyday wear',
                'M,L,XL',
                'Blue,Black,White',
                'Cotton',
                'Solid',
                'male',
                'adult',
                'https://drive.google.com/file/d/1ABC123/view?usp=sharing,https://example.com/image2.jpg',
                'casual, cotton, comfortable, mens',
                'TSH-001',
                '100',
                '200',
                '30x20x2 cm',
                '1234567890123',
                'TSH-SJ-001',
                'Apparel & Accessories > Clothing > Shirts & Tops',
                'new',
                '6 months',
                '30',
                'Premium Cotton T-Shirt for Men - Comfortable & Stylish',
                'Shop premium cotton t-shirts for men. Comfortable, breathable, and stylish casual wear.',
                'cotton t-shirt, mens clothing, casual wear, comfortable'
            ]
        ];

        $row = 2;
        foreach ($sampleData as $data) {
            $col = 'A';
            foreach ($data as $value) {
                $sheet->setCellValue($col . $row, $value);
                $col++;
            }
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'AB') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'bulk_upload_sample_' . date('Y-m-d') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    public function downloadCurrentProducts()
    {
        $products = Product::with('category')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = [
            'A1' => 'id',
            'B1' => 'name*',
            'C1' => 'brand*',
            'D1' => 'category_name*',
            'E1' => 'price*',
            'F1' => 'mrp',
            'G1' => 'sale_price',
            'H1' => 'description',
            'I1' => 'short_description',
            'J1' => 'long_description',
            'K1' => 'sku',
            'L1' => 'stock_quantity',
            'M1' => 'size',
            'N1' => 'color',
            'O1' => 'material',
            'P1' => 'pattern',
            'Q1' => 'gender',
            'R1' => 'age_group',
            'S1' => 'weight',
            'T1' => 'dimensions',
            'U1' => 'gtin',
            'V1' => 'mpn',
            'W1' => 'condition',
            'X1' => 'availability',
            'Y1' => 'google_product_category',
            'Z1' => 'tags',
            'AA1' => 'image_urls',
            'AB1' => 'additional_images',
            'AC1' => 'seo_title',
            'AD1' => 'seo_description',
            'AE1' => 'seo_keywords',
            'AF1' => 'has_warranty',
            'AG1' => 'warranty_period',
            'AH1' => 'has_return_policy',
            'AI1' => 'return_days',
            'AJ1' => 'price_includes_tax',
            'AK1' => 'tax_rate',
            'AL1' => 'is_active',
            'AM1' => 'is_featured'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style headers
        $sheet->getStyle('A1:AM1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']],
            'borders' => ['allBorders' => ['borderStyle' => 'thin']]
        ]);

        // Add product data
        $row = 2;
        foreach ($products as $product) {
            $data = [
                $product->id,
                $product->name,
                $product->brand ?? '',
                $product->category->name ?? '',
                $product->price,
                $product->mrp ?? $product->price,
                $product->sale_price ?? '',
                $product->description ?? '',
                $product->short_description ?? '',
                $product->long_description ?? '',
                $product->sku,
                $product->stock_quantity ?? 0,
                $product->size ?? '',
                $product->color ?? '',
                $product->material ?? '',
                $product->pattern ?? '',
                $product->gender ?? '',
                $product->age_group ?? '',
                $product->weight ?? '',
                $product->dimensions ?? '',
                $product->gtin ?? '',
                $product->mpn ?? '',
                $product->condition ?? 'new',
                $product->availability ?? 'in stock',
                $product->google_product_category ?? '',
                is_array($product->tags) ? implode(',', $product->tags) : '',
                is_array($product->images) ? implode(',', $product->images) : '',
                is_array($product->additional_images) ? implode(',', $product->additional_images) : '',
                $product->seo_title ?? '',
                $product->seo_description ?? '',
                $product->seo_keywords ?? '',
                $product->has_warranty ? 'Yes' : 'No',
                $product->warranty_period ?? '',
                $product->has_return_policy ? 'Yes' : 'No',
                $product->return_days ?? 30,
                $product->price_includes_tax ? 'Yes' : 'No',
                $product->tax_rate ?? 18,
                $product->is_active ? 'Yes' : 'No',
                $product->is_featured ? 'Yes' : 'No'
            ];

            $col = 'A';
            foreach ($data as $value) {
                $sheet->setCellValue($col . $row, $value);
                $col++;
            }
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'AM') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'current_products_' . date('Y-m-d_H-i-s') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    public function uploadExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Remove header row
            $headers = array_shift($rows);

            $results = [
                'total' => count($rows),
                'success' => 0,
                'failed' => 0,
                'errors' => []
            ];

            foreach ($rows as $index => $row) {
                try {
                    $this->processExcelRow($row, $headers, $index + 2);
                    $results['success']++;
                } catch (\Exception $e) {
                    $results['failed']++;
                    $results['errors'][] = "Row " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            return back()->with('upload_results', $results);

        } catch (\Exception $e) {
            return back()->withErrors(['excel_file' => 'Error processing file: ' . $e->getMessage()]);
        }
    }

    public function bulkUpdateProducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Remove header row
            $headers = array_shift($rows);

            // Map headers to indices for flexible column order
            $headerMap = [];
            foreach ($headers as $index => $header) {
                $headerMap[strtolower(trim($header))] = $index;
            }

            $results = [
                'total' => count($rows),
                'updated' => 0,
                'created' => 0,
                'failed' => 0,
                'errors' => []
            ];

            foreach ($rows as $rowIndex => $row) {
                try {
                    // Skip empty rows
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    $this->processBulkUpdateRow($row, $headerMap, $results);

                } catch (\Exception $e) {
                    $results['failed']++;
                    $results['errors'][] = "Row " . ($rowIndex + 2) . ": " . $e->getMessage();
                }
            }

            return back()->with('bulk_update_results', $results);

        } catch (\Exception $e) {
            return back()->withErrors(['bulk_update_error' => 'Bulk update failed: ' . $e->getMessage()]);
        }
    }

    private function processExcelRow($row, $headers, $rowNumber)
    {
        // Map row data to headers
        $data = array_combine($headers, $row);

        // Validate required fields
        if (empty($data['name*']) || empty($data['brand*']) || empty($data['category_name*']) || empty($data['price*'])) {
            throw new \Exception("Missing required fields (name, brand, category, price)");
        }

        // Find or create category
        $category = Category::firstOrCreate(
            ['name' => $data['category_name*']],
            ['slug' => Str::slug($data['category_name*'])]
        );

        // Process image URLs (including Google Drive links)
        $imageUrls = [];
        if (!empty($data['image_urls'])) {
            $urls = explode(',', $data['image_urls']);
            foreach ($urls as $url) {
                $url = trim($url);
                if (!empty($url)) {
                    // Convert Google Drive share links to direct links
                    $imageUrls[] = $this->convertGoogleDriveUrl($url);
                }
            }
        }

        // Create product
        $product = Product::create([
            'name' => $data['name*'],
            'slug' => Str::slug($data['name*'] . '-' . uniqid()),
            'brand' => $data['brand*'],
            'category_id' => $category->id,
            'price' => (float) $data['price*'],
            'mrp' => !empty($data['mrp']) ? (float) $data['mrp'] : (float) $data['price*'],
            'description' => $data['description'] ?? '',
            'short_description' => $data['short_description'] ?? '',
            'size' => $data['size'] ?? '',
            'color' => $data['color'] ?? '',
            'material' => $data['material'] ?? '',
            'pattern' => $data['pattern'] ?? '',
            'gender' => $data['gender'] ?? '',
            'age_group' => $data['age_group'] ?? '',
            'images' => $imageUrls,
            'tags' => !empty($data['tags']) ? explode(',', $data['tags']) : [],
            'sku' => $data['sku'] ?? 'SKU-' . uniqid(),
            'stock_quantity' => !empty($data['stock_quantity']) ? (int) $data['stock_quantity'] : 0,
            'weight' => $data['weight'] ?? '',
            'dimensions' => $data['dimensions'] ?? '',
            'gtin' => $data['gtin'] ?? '',
            'mpn' => $data['mpn'] ?? '',
            'google_product_category' => $data['google_product_category'] ?? '',
            'condition' => $data['condition'] ?? 'new',
            'warranty_period' => $data['warranty_period'] ?? '',
            'return_days' => !empty($data['return_days']) ? (int) $data['return_days'] : 30,
            'seo_title' => $data['seo_title'] ?? $data['name*'],
            'seo_description' => $data['seo_description'] ?? '',
            'seo_keywords' => $data['seo_keywords'] ?? '',
            'is_active' => true
        ]);

        return $product;
    }

    private function processBulkUpdateRow($row, $headerMap, &$results)
    {
        // Get product ID from the row
        $productId = isset($headerMap['id']) ? $row[$headerMap['id']] : null;

        if (empty($productId)) {
            throw new \Exception("Product ID is required for bulk update");
        }

        // Find existing product
        $product = Product::find($productId);

        if (!$product) {
            throw new \Exception("Product with ID {$productId} not found");
        }

        // Extract data from row using header map
        $data = [];
        foreach ($headerMap as $header => $index) {
            $data[$header] = isset($row[$index]) ? $row[$index] : null;
        }

        // Validate required fields
        $name = $data['name*'] ?? $product->name;
        $brand = $data['brand*'] ?? $product->brand;
        $categoryName = $data['category_name*'] ?? $product->category->name;
        $price = $data['price*'] ?? $product->price;

        if (empty($name) || empty($brand) || empty($categoryName) || empty($price)) {
            throw new \Exception("Missing required fields (name, brand, category, price)");
        }

        // Find or create category
        $category = Category::firstOrCreate(
            ['name' => $categoryName],
            ['slug' => Str::slug($categoryName)]
        );

        // Process images
        $imageUrls = [];
        if (!empty($data['image_urls'])) {
            $urls = explode(',', $data['image_urls']);
            foreach ($urls as $url) {
                $url = trim($url);
                if (!empty($url)) {
                    $imageUrls[] = $this->convertGoogleDriveUrl($url);
                }
            }
        }

        // Process additional images
        $additionalImages = [];
        if (!empty($data['additional_images'])) {
            $urls = explode(',', $data['additional_images']);
            foreach ($urls as $url) {
                $url = trim($url);
                if (!empty($url)) {
                    $additionalImages[] = $this->convertGoogleDriveUrl($url);
                }
            }
        }

        // Process tags
        $tags = [];
        if (!empty($data['tags'])) {
            $tags = array_map('trim', explode(',', $data['tags']));
        }

        // Update product
        $updateData = [
            'name' => $name,
            'brand' => $brand,
            'category_id' => $category->id,
            'price' => (float) $price,
            'mrp' => !empty($data['mrp']) ? (float) $data['mrp'] : (float) $price,
            'sale_price' => !empty($data['sale_price']) ? (float) $data['sale_price'] : null,
            'description' => $data['description'] ?? $product->description,
            'short_description' => $data['short_description'] ?? $product->short_description,
            'long_description' => $data['long_description'] ?? $product->long_description,
            'sku' => $data['sku'] ?? $product->sku,
            'stock_quantity' => !empty($data['stock_quantity']) ? (int) $data['stock_quantity'] : $product->stock_quantity,
            'size' => $data['size'] ?? $product->size,
            'color' => $data['color'] ?? $product->color,
            'material' => $data['material'] ?? $product->material,
            'pattern' => $data['pattern'] ?? $product->pattern,
            'gender' => $data['gender'] ?? $product->gender,
            'age_group' => $data['age_group'] ?? $product->age_group,
            'weight' => $data['weight'] ?? $product->weight,
            'dimensions' => $data['dimensions'] ?? $product->dimensions,
            'gtin' => $data['gtin'] ?? $product->gtin,
            'mpn' => $data['mpn'] ?? $product->mpn,
            'condition' => $data['condition'] ?? $product->condition,
            'availability' => $data['availability'] ?? $product->availability,
            'google_product_category' => $data['google_product_category'] ?? $product->google_product_category,
            'tags' => !empty($tags) ? $tags : $product->tags,
            'images' => !empty($imageUrls) ? $imageUrls : $product->images,
            'additional_images' => !empty($additionalImages) ? $additionalImages : $product->additional_images,
            'seo_title' => $data['seo_title'] ?? $product->seo_title,
            'seo_description' => $data['seo_description'] ?? $product->seo_description,
            'seo_keywords' => $data['seo_keywords'] ?? $product->seo_keywords,
            'has_warranty' => isset($data['has_warranty']) ? (strtolower($data['has_warranty']) === 'yes') : $product->has_warranty,
            'warranty_period' => $data['warranty_period'] ?? $product->warranty_period,
            'has_return_policy' => isset($data['has_return_policy']) ? (strtolower($data['has_return_policy']) === 'yes') : $product->has_return_policy,
            'return_days' => !empty($data['return_days']) ? (int) $data['return_days'] : $product->return_days,
            'price_includes_tax' => isset($data['price_includes_tax']) ? (strtolower($data['price_includes_tax']) === 'yes') : $product->price_includes_tax,
            'tax_rate' => !empty($data['tax_rate']) ? (float) $data['tax_rate'] : $product->tax_rate,
            'is_active' => isset($data['is_active']) ? (strtolower($data['is_active']) === 'yes') : $product->is_active,
            'is_featured' => isset($data['is_featured']) ? (strtolower($data['is_featured']) === 'yes') : $product->is_featured,
        ];

        $product->update($updateData);
        $results['updated']++;

        return $product;
    }

    private function convertGoogleDriveUrl($url)
    {
        // Convert Google Drive share URL to direct download URL
        if (strpos($url, 'drive.google.com') !== false) {
            if (preg_match('/\/file\/d\/([a-zA-Z0-9-_]+)/', $url, $matches)) {
                $fileId = $matches[1];
                return "https://drive.google.com/uc?export=view&id=" . $fileId;
            }
        }
        return $url;
    }

    public function importShopify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shopify_store_url' => 'required|url',
            'shopify_access_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $client = new Client();
            $storeUrl = rtrim($request->shopify_store_url, '/');
            $accessToken = $request->shopify_access_token;

            // Test connection first
            $response = $client->get($storeUrl . '/admin/api/2023-10/products.json', [
                'headers' => [
                    'X-Shopify-Access-Token' => $accessToken,
                    'Content-Type' => 'application/json'
                ],
                'query' => ['limit' => 1]
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Failed to connect to Shopify store');
            }

            // Get all products using cursor-based pagination
            $allProducts = [];
            $limit = 50;
            $pageInfo = null;

            do {
                $queryParams = ['limit' => $limit];

                // Add cursor for subsequent requests
                if ($pageInfo) {
                    $queryParams['page_info'] = $pageInfo;
                }

                $response = $client->get($storeUrl . '/admin/api/2023-10/products.json', [
                    'headers' => [
                        'X-Shopify-Access-Token' => $accessToken,
                        'Content-Type' => 'application/json'
                    ],
                    'query' => $queryParams
                ]);

                $data = json_decode($response->getBody(), true);
                $products = $data['products'] ?? [];
                $allProducts = array_merge($allProducts, $products);

                // Get next page info from Link header
                $pageInfo = $this->getNextPageInfo($response->getHeader('Link'));

            } while (!empty($products) && $pageInfo);

            $results = [
                'total' => count($allProducts),
                'success' => 0,
                'failed' => 0,
                'errors' => []
            ];

            foreach ($allProducts as $shopifyProduct) {
                try {
                    $this->processShopifyProduct($shopifyProduct);
                    $results['success']++;
                } catch (\Exception $e) {
                    $results['failed']++;
                    $results['errors'][] = "Product '{$shopifyProduct['title']}': " . $e->getMessage();
                }
            }

            return back()->with('import_results', $results);

        } catch (\Exception $e) {
            return back()->withErrors(['shopify_error' => 'Shopify import failed: ' . $e->getMessage()]);
        }
    }

    private function processShopifyProduct($shopifyProduct)
    {
        // Smart category mapping based on multiple data sources
        $categoryName = $this->determineCategoryFromShopifyProduct($shopifyProduct);

        $category = Category::firstOrCreate(
            ['name' => $categoryName],
            ['slug' => Str::slug($categoryName)]
        );

        // Process images - download and store locally
        $imageUrls = [];
        if (!empty($shopifyProduct['images'])) {
            foreach ($shopifyProduct['images'] as $image) {
                $localImagePath = $this->downloadAndStoreImage($image['src']);
                if ($localImagePath) {
                    $imageUrls[] = $localImagePath;
                }
            }
        }

        // Get first variant for pricing
        $firstVariant = $shopifyProduct['variants'][0] ?? [];

        // Process tags
        $tags = !empty($shopifyProduct['tags']) ? explode(',', $shopifyProduct['tags']) : [];

        // Generate unique SKU
        $baseSku = $firstVariant['sku'] ?? 'SKU-' . uniqid();
        $sku = $this->generateUniqueSku($baseSku);

        // Check if product already exists by SKU or name
        $existingProduct = Product::where('sku', $sku)
            ->orWhere('name', $shopifyProduct['title'])
            ->first();

        if ($existingProduct) {
            // Update existing product instead of creating duplicate
            $existingProduct->update([
                'brand' => $shopifyProduct['vendor'] ?: 'Unknown',
                'category_id' => $category->id,
                'price' => (float) ($firstVariant['price'] ?? 0),
                'mrp' => (float) ($firstVariant['compare_at_price'] ?? $firstVariant['price'] ?? 0),
                'description' => strip_tags($shopifyProduct['body_html'] ?? ''),
                'short_description' => Str::limit(strip_tags($shopifyProduct['body_html'] ?? ''), 200),
                'images' => $imageUrls,
                'tags' => $tags,
                'stock_quantity' => (int) ($firstVariant['inventory_quantity'] ?? 0),
                'weight' => $firstVariant['weight'] ?? '',
                'gtin' => $firstVariant['barcode'] ?? '',
                'condition' => 'new',
                'seo_title' => $shopifyProduct['title'],
                'seo_description' => strip_tags($shopifyProduct['body_html'] ?? ''),
                'is_active' => $shopifyProduct['status'] === 'active'
            ]);
            return $existingProduct;
        }

        $product = Product::create([
            'name' => $shopifyProduct['title'],
            'slug' => Str::slug($shopifyProduct['title'] . '-' . uniqid()),
            'brand' => $shopifyProduct['vendor'] ?: 'Unknown',
            'category_id' => $category->id,
            'price' => (float) ($firstVariant['price'] ?? 0),
            'mrp' => (float) ($firstVariant['compare_at_price'] ?? $firstVariant['price'] ?? 0),
            'description' => strip_tags($shopifyProduct['body_html'] ?? ''),
            'short_description' => Str::limit(strip_tags($shopifyProduct['body_html'] ?? ''), 200),
            'images' => $imageUrls,
            'tags' => $tags,
            'sku' => $sku,
            'stock_quantity' => (int) ($firstVariant['inventory_quantity'] ?? 0),
            'weight' => $firstVariant['weight'] ?? '',
            'gtin' => $firstVariant['barcode'] ?? '',
            'condition' => 'new',
            'seo_title' => $shopifyProduct['title'],
            'seo_description' => strip_tags($shopifyProduct['body_html'] ?? ''),
            'is_active' => $shopifyProduct['status'] === 'active'
        ]);

        return $product;
    }

    /**
     * Extract next page info from Shopify Link header
     */
    private function getNextPageInfo($linkHeaders)
    {
        if (empty($linkHeaders)) {
            return null;
        }

        $linkHeader = is_array($linkHeaders) ? $linkHeaders[0] : $linkHeaders;

        // Parse Link header for next page
        if (preg_match('/<([^>]+)>;\s*rel="next"/', $linkHeader, $matches)) {
            $nextUrl = $matches[1];

            // Extract page_info parameter from URL
            if (preg_match('/page_info=([^&]+)/', $nextUrl, $pageMatches)) {
                return urldecode($pageMatches[1]);
            }
        }

        return null;
    }

    /**
     * Generate unique SKU by appending suffix if needed
     */
    private function generateUniqueSku($baseSku)
    {
        $sku = $baseSku;
        $counter = 1;

        // Keep checking until we find a unique SKU
        while (Product::where('sku', $sku)->exists()) {
            $sku = $baseSku . '-' . $counter;
            $counter++;
        }

        return $sku;
    }

    /**
     * Determine category from Shopify product data using multiple sources
     */
    private function determineCategoryFromShopifyProduct($shopifyProduct)
    {
        // Priority order for category determination:
        // 1. Product type (if meaningful)
        // 2. Tags analysis
        // 3. Title analysis
        // 4. Vendor/Brand analysis

        $productType = $shopifyProduct['product_type'] ?? '';
        $title = $shopifyProduct['title'] ?? '';
        $tags = $shopifyProduct['tags'] ?? '';
        $vendor = $shopifyProduct['vendor'] ?? '';

        // Skip generic product types
        $genericTypes = ['simple', 'variable', 'grouped', 'external', 'default', ''];

        // 1. Use product_type if it's meaningful
        if (!empty($productType) && !in_array(strtolower($productType), $genericTypes)) {
            return $this->cleanCategoryName($productType);
        }

        // 2. Analyze tags for category hints
        if (!empty($tags)) {
            $categoryFromTags = $this->extractCategoryFromTags($tags);
            if ($categoryFromTags) {
                return $categoryFromTags;
            }
        }

        // 3. Analyze title for category keywords
        $categoryFromTitle = $this->extractCategoryFromTitle($title);
        if ($categoryFromTitle) {
            return $categoryFromTitle;
        }

        // 4. Use vendor as category if nothing else works
        if (!empty($vendor) && $vendor !== 'My Store' && $vendor !== 'Default') {
            return $this->cleanCategoryName($vendor);
        }

        // 5. Default fallback
        return 'Uncategorized';
    }

    /**
     * Extract category from product tags
     */
    private function extractCategoryFromTags($tags)
    {
        $tagArray = explode(',', strtolower($tags));

        // Common category keywords in tags
        $categoryKeywords = [
            'blouse' => 'Blouses',
            'saree' => 'Sarees',
            'dress' => 'Dresses',
            'shirt' => 'Shirts',
            'top' => 'Tops',
            'bottom' => 'Bottoms',
            'kurta' => 'Kurtas',
            'kurti' => 'Kurtis',
            'lehenga' => 'Lehengas',
            'suit' => 'Suits',
            'jewelry' => 'Jewelry',
            'accessories' => 'Accessories',
            'footwear' => 'Footwear',
            'shoes' => 'Footwear',
            'bag' => 'Bags',
            'handbag' => 'Bags',
            'scarf' => 'Accessories',
            'dupatta' => 'Dupattas',
            'palazzo' => 'Palazzos',
            'jeans' => 'Jeans',
            'trouser' => 'Trousers',
            'skirt' => 'Skirts'
        ];

        foreach ($tagArray as $tag) {
            $tag = trim($tag);
            foreach ($categoryKeywords as $keyword => $category) {
                if (strpos($tag, $keyword) !== false) {
                    return $category;
                }
            }
        }

        return null;
    }

    /**
     * Extract category from product title
     */
    private function extractCategoryFromTitle($title)
    {
        $title = strtolower($title);

        // Category keywords in title
        $categoryKeywords = [
            'blouse' => 'Blouses',
            'saree' => 'Sarees',
            'dress' => 'Dresses',
            'shirt' => 'Shirts',
            'top' => 'Tops',
            'kurta' => 'Kurtas',
            'kurti' => 'Kurtis',
            'lehenga' => 'Lehengas',
            'suit' => 'Suits',
            'jewelry' => 'Jewelry',
            'necklace' => 'Jewelry',
            'earring' => 'Jewelry',
            'bracelet' => 'Jewelry',
            'ring' => 'Jewelry',
            'footwear' => 'Footwear',
            'shoes' => 'Footwear',
            'sandal' => 'Footwear',
            'heel' => 'Footwear',
            'bag' => 'Bags',
            'handbag' => 'Bags',
            'purse' => 'Bags',
            'wallet' => 'Bags',
            'dupatta' => 'Dupattas',
            'palazzo' => 'Palazzos',
            'jeans' => 'Jeans',
            'trouser' => 'Trousers',
            'pant' => 'Trousers',
            'skirt' => 'Skirts',
            'embroidered' => 'Embroidered Items',
            'cotton' => 'Cotton Wear',
            'silk' => 'Silk Wear'
        ];

        foreach ($categoryKeywords as $keyword => $category) {
            if (strpos($title, $keyword) !== false) {
                return $category;
            }
        }

        return null;
    }

    /**
     * Clean and format category name
     */
    private function cleanCategoryName($name)
    {
        // Remove special characters and clean up
        $name = preg_replace('/[^a-zA-Z0-9\s]/', '', $name);
        $name = trim($name);

        // Convert to title case
        return ucwords(strtolower($name));
    }

    public function importWooCommerce(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'woo_store_url' => 'required|url',
            'woo_consumer_key' => 'required|string',
            'woo_consumer_secret' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $client = new Client();
            $storeUrl = rtrim($request->woo_store_url, '/');
            $consumerKey = $request->woo_consumer_key;
            $consumerSecret = $request->woo_consumer_secret;

            // Test connection
            $response = $client->get($storeUrl . '/wp-json/wc/v3/products', [
                'auth' => [$consumerKey, $consumerSecret],
                'query' => ['per_page' => 1]
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Failed to connect to WooCommerce store');
            }

            // Get all products
            $allProducts = [];
            $page = 1;
            $perPage = 50;

            do {
                $response = $client->get($storeUrl . '/wp-json/wc/v3/products', [
                    'auth' => [$consumerKey, $consumerSecret],
                    'query' => [
                        'per_page' => $perPage,
                        'page' => $page
                    ]
                ]);

                $products = json_decode($response->getBody(), true);
                $allProducts = array_merge($allProducts, $products);
                $page++;

            } while (count($products) === $perPage);

            $results = [
                'total' => count($allProducts),
                'success' => 0,
                'failed' => 0,
                'errors' => []
            ];

            foreach ($allProducts as $wooProduct) {
                try {
                    $this->processWooCommerceProduct($wooProduct);
                    $results['success']++;
                } catch (\Exception $e) {
                    $results['failed']++;
                    $results['errors'][] = "Product '{$wooProduct['name']}': " . $e->getMessage();
                }
            }

            return back()->with('import_results', $results);

        } catch (\Exception $e) {
            return back()->withErrors(['woo_error' => 'WooCommerce import failed: ' . $e->getMessage()]);
        }
    }

    private function processWooCommerceProduct($wooProduct)
    {
        // Smart category determination for WooCommerce
        $categoryName = $this->determineCategoryFromWooProduct($wooProduct);

        $category = Category::firstOrCreate(
            ['name' => $categoryName],
            ['slug' => Str::slug($categoryName)]
        );

        // Process images - download and store locally
        $imageUrls = [];
        if (!empty($wooProduct['images'])) {
            foreach ($wooProduct['images'] as $image) {
                $localImagePath = $this->downloadAndStoreImage($image['src']);
                if ($localImagePath) {
                    $imageUrls[] = $localImagePath;
                }
            }
        }

        // Process tags
        $tags = [];
        if (!empty($wooProduct['tags'])) {
            foreach ($wooProduct['tags'] as $tag) {
                $tags[] = $tag['name'];
            }
        }

        // Get attributes for variants
        $attributes = [];
        if (!empty($wooProduct['attributes'])) {
            foreach ($wooProduct['attributes'] as $attribute) {
                $attributes[$attribute['name']] = implode(',', $attribute['options']);
            }
        }

        // Generate unique SKU
        $baseSku = $wooProduct['sku'] ?: 'SKU-' . uniqid();
        $sku = $this->generateUniqueSku($baseSku);

        // Check if product already exists
        $existingProduct = Product::where('sku', $sku)
            ->orWhere('name', $wooProduct['name'])
            ->first();

        if ($existingProduct) {
            // Update existing product
            $existingProduct->update([
                'brand' => $attributes['Brand'] ?? 'Unknown',
                'category_id' => $category->id,
                'price' => (float) $wooProduct['price'],
                'mrp' => (float) ($wooProduct['regular_price'] ?: $wooProduct['price']),
                'description' => strip_tags($wooProduct['description'] ?? ''),
                'short_description' => strip_tags($wooProduct['short_description'] ?? ''),
                'size' => $attributes['Size'] ?? '',
                'color' => $attributes['Color'] ?? '',
                'material' => $attributes['Material'] ?? '',
                'images' => $imageUrls,
                'tags' => $tags,
                'stock_quantity' => (int) ($wooProduct['stock_quantity'] ?? 0),
                'weight' => $wooProduct['weight'] ?? '',
                'dimensions' => $wooProduct['dimensions']['length'] . 'x' . $wooProduct['dimensions']['width'] . 'x' . $wooProduct['dimensions']['height'] ?? '',
                'condition' => 'new',
                'seo_title' => $wooProduct['name'],
                'seo_description' => strip_tags($wooProduct['short_description'] ?? ''),
                'is_active' => $wooProduct['status'] === 'publish'
            ]);
            return $existingProduct;
        }

        $product = Product::create([
            'name' => $wooProduct['name'],
            'slug' => Str::slug($wooProduct['name'] . '-' . uniqid()),
            'brand' => $attributes['Brand'] ?? 'Unknown',
            'category_id' => $category->id,
            'price' => (float) $wooProduct['price'],
            'mrp' => (float) ($wooProduct['regular_price'] ?: $wooProduct['price']),
            'description' => strip_tags($wooProduct['description'] ?? ''),
            'short_description' => strip_tags($wooProduct['short_description'] ?? ''),
            'size' => $attributes['Size'] ?? '',
            'color' => $attributes['Color'] ?? '',
            'material' => $attributes['Material'] ?? '',
            'images' => $imageUrls,
            'tags' => $tags,
            'sku' => $sku,
            'stock_quantity' => (int) ($wooProduct['stock_quantity'] ?? 0),
            'weight' => $wooProduct['weight'] ?? '',
            'dimensions' => $wooProduct['dimensions']['length'] . 'x' . $wooProduct['dimensions']['width'] . 'x' . $wooProduct['dimensions']['height'] ?? '',
            'condition' => 'new',
            'seo_title' => $wooProduct['name'],
            'seo_description' => strip_tags($wooProduct['short_description'] ?? ''),
            'is_active' => $wooProduct['status'] === 'publish'
        ]);

        return $product;
    }

    /**
     * Determine category from WooCommerce product data
     */
    private function determineCategoryFromWooProduct($wooProduct)
    {
        // 1. Use WooCommerce categories if available and meaningful
        if (!empty($wooProduct['categories'])) {
            $categoryName = $wooProduct['categories'][0]['name'];

            // Skip generic WooCommerce categories
            $genericCategories = ['uncategorized', 'default', 'simple', 'variable', 'grouped'];

            if (!in_array(strtolower($categoryName), $genericCategories)) {
                return $this->cleanCategoryName($categoryName);
            }
        }

        // 2. Fallback to title/tag analysis (reuse Shopify logic)
        $mockShopifyProduct = [
            'product_type' => '',
            'title' => $wooProduct['name'] ?? '',
            'tags' => implode(',', array_column($wooProduct['tags'] ?? [], 'name')),
            'vendor' => ''
        ];

        $categoryFromAnalysis = $this->determineCategoryFromShopifyProduct($mockShopifyProduct);

        if ($categoryFromAnalysis !== 'Uncategorized') {
            return $categoryFromAnalysis;
        }

        return 'Uncategorized';
    }

    /**
     * Download image from URL and store locally
     */
    private function downloadAndStoreImage($imageUrl)
    {
        try {
            // Skip if already a local path
            if (!str_starts_with($imageUrl, 'http://') && !str_starts_with($imageUrl, 'https://')) {
                return $imageUrl;
            }

            $client = new Client();
            $response = $client->get($imageUrl, [
                'timeout' => 30,
                'verify' => false // Skip SSL verification for problematic hosts
            ]);

            if ($response->getStatusCode() !== 200) {
                \Log::warning("Failed to download image: {$imageUrl}");
                return null;
            }

            // Get file extension from URL or content type
            $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
            if (!$extension) {
                $contentType = $response->getHeader('Content-Type')[0] ?? '';
                $extension = match($contentType) {
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/gif' => 'gif',
                    'image/webp' => 'webp',
                    default => 'jpg'
                };
            }

            // Generate unique filename
            $filename = 'imported_' . time() . '_' . uniqid() . '.' . $extension;

            // Store in products directory
            $path = 'products/' . $filename;
            Storage::disk('public')->put($path, $response->getBody());

            \Log::info("Image downloaded successfully: {$imageUrl} -> {$path}");

            return $path; // Return relative path for storage

        } catch (\Exception $e) {
            \Log::error("Failed to download image {$imageUrl}: " . $e->getMessage());
            return null;
        }
    }
}
