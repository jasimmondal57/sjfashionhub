<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class DownloadExternalImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:download-external {--dry-run : Show what would be done without actually downloading}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download external images (Shopify, etc.) and store them locally';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->info('🔍 DRY RUN MODE - No files will be downloaded or modified');
        }

        $this->info('🔍 Scanning products for external images...');

        $products = Product::whereNotNull('images')->get();
        $totalProducts = $products->count();
        $processedProducts = 0;
        $downloadedImages = 0;
        $failedImages = 0;

        $this->info("Found {$totalProducts} products with images");

        $progressBar = $this->output->createProgressBar($totalProducts);
        $progressBar->start();

        foreach ($products as $product) {
            $hasExternalImages = false;
            $updatedImages = [];

            if (is_array($product->images)) {
                foreach ($product->images as $imageUrl) {
                    if (is_string($imageUrl) && $this->isExternalUrl($imageUrl)) {
                        $hasExternalImages = true;
                        
                        if ($dryRun) {
                            $this->line("\n📋 Would download: {$imageUrl}");
                            $updatedImages[] = $imageUrl; // Keep original in dry run
                        } else {
                            $localPath = $this->downloadAndStoreImage($imageUrl);
                            if ($localPath) {
                                $updatedImages[] = $localPath;
                                $downloadedImages++;
                                $this->line("\n✅ Downloaded: {$imageUrl} -> {$localPath}");
                            } else {
                                $updatedImages[] = $imageUrl; // Keep original if download failed
                                $failedImages++;
                                $this->line("\n❌ Failed: {$imageUrl}");
                            }
                        }
                    } else {
                        $updatedImages[] = $imageUrl; // Keep local images as-is
                    }
                }

                // Update product if it had external images and we're not in dry run mode
                if ($hasExternalImages && !$dryRun) {
                    $product->update(['images' => $updatedImages]);
                    $processedProducts++;
                }
            }

            $progressBar->advance();
        }

        $progressBar->finish();

        $this->newLine(2);
        
        if ($dryRun) {
            $this->info('📊 DRY RUN SUMMARY:');
            $this->info("Products scanned: {$totalProducts}");
            $externalImageCount = 0;
            foreach ($products as $product) {
                if (is_array($product->images)) {
                    foreach ($product->images as $imageUrl) {
                        if (is_string($imageUrl) && $this->isExternalUrl($imageUrl)) {
                            $externalImageCount++;
                        }
                    }
                }
            }
            $this->info("External images found: {$externalImageCount}");
            $this->info("\n🚀 Run without --dry-run to actually download the images");
        } else {
            $this->info('📊 DOWNLOAD SUMMARY:');
            $this->info("Products processed: {$processedProducts}");
            $this->info("Images downloaded: {$downloadedImages}");
            $this->info("Images failed: {$failedImages}");
            
            if ($downloadedImages > 0) {
                $this->info("\n🎉 Successfully downloaded {$downloadedImages} images to local storage!");
            }
            
            if ($failedImages > 0) {
                $this->warn("\n⚠️  {$failedImages} images failed to download. Check logs for details.");
            }
        }

        return Command::SUCCESS;
    }

    /**
     * Check if URL is external
     */
    private function isExternalUrl($url)
    {
        return is_string($url) && (str_starts_with($url, 'http://') || str_starts_with($url, 'https://'));
    }

    /**
     * Download image from URL and store locally
     */
    private function downloadAndStoreImage($imageUrl)
    {
        try {
            $client = new Client();
            $response = $client->get($imageUrl, [
                'timeout' => 30,
                'verify' => false // Skip SSL verification for problematic hosts
            ]);

            if ($response->getStatusCode() !== 200) {
                Log::warning("Failed to download image: {$imageUrl}");
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
            $filename = 'migrated_' . time() . '_' . uniqid() . '.' . $extension;
            
            // Store in products directory
            $path = 'products/' . $filename;
            Storage::disk('public')->put($path, $response->getBody());

            Log::info("Image migrated successfully: {$imageUrl} -> {$path}");
            
            return $path; // Return relative path for storage

        } catch (\Exception $e) {
            Log::error("Failed to download image {$imageUrl}: " . $e->getMessage());
            return null;
        }
    }
}
