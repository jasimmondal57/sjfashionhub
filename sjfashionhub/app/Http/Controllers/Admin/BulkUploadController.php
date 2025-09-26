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

            // Get all products
            $allProducts = [];
            $page = 1;
            $limit = 50;

            do {
                $response = $client->get($storeUrl . '/admin/api/2023-10/products.json', [
                    'headers' => [
                        'X-Shopify-Access-Token' => $accessToken,
                        'Content-Type' => 'application/json'
                    ],
                    'query' => [
                        'limit' => $limit,
                        'page' => $page
                    ]
                ]);

                $data = json_decode($response->getBody(), true);
                $products = $data['products'] ?? [];
                $allProducts = array_merge($allProducts, $products);
                $page++;

            } while (count($products) === $limit);

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
        // Find or create category based on product type
        $category = Category::firstOrCreate(
            ['name' => $shopifyProduct['product_type'] ?: 'Uncategorized'],
            ['slug' => Str::slug($shopifyProduct['product_type'] ?: 'uncategorized')]
        );

        // Process images
        $imageUrls = [];
        if (!empty($shopifyProduct['images'])) {
            foreach ($shopifyProduct['images'] as $image) {
                $imageUrls[] = $image['src'];
            }
        }

        // Get first variant for pricing
        $firstVariant = $shopifyProduct['variants'][0] ?? [];

        // Process tags
        $tags = !empty($shopifyProduct['tags']) ? explode(',', $shopifyProduct['tags']) : [];

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
            'sku' => $firstVariant['sku'] ?? 'SKU-' . uniqid(),
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
        // Find or create category
        $categoryName = 'Uncategorized';
        if (!empty($wooProduct['categories'])) {
            $categoryName = $wooProduct['categories'][0]['name'];
        }

        $category = Category::firstOrCreate(
            ['name' => $categoryName],
            ['slug' => Str::slug($categoryName)]
        );

        // Process images
        $imageUrls = [];
        if (!empty($wooProduct['images'])) {
            foreach ($wooProduct['images'] as $image) {
                $imageUrls[] = $image['src'];
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
            'sku' => $wooProduct['sku'] ?: 'SKU-' . uniqid(),
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
}
