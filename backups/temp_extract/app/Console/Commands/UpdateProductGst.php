<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class UpdateProductGst extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:update-gst {rate=5 : The GST rate to set (default: 5%)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update GST rate for all products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $gstRate = $this->argument('rate');
        
        $this->info("Starting GST update process...");
        $this->info("Setting GST rate to: {$gstRate}%");
        
        // Get all products
        $products = Product::all();
        $totalProducts = $products->count();
        
        if ($totalProducts === 0) {
            $this->warn('No products found in the database.');
            return;
        }
        
        $this->info("Found {$totalProducts} products to update.");
        
        // Confirm before proceeding
        if (!$this->confirm("Are you sure you want to update GST rate to {$gstRate}% for all {$totalProducts} products?")) {
            $this->info('Operation cancelled.');
            return;
        }
        
        $bar = $this->output->createProgressBar($totalProducts);
        $bar->start();
        
        $updated = 0;
        $errors = 0;
        
        foreach ($products as $product) {
            try {
                $product->update([
                    'tax_rate' => $gstRate,
                    'price_includes_tax' => true // Ensure price includes tax
                ]);
                $updated++;
            } catch (\Exception $e) {
                $errors++;
                $this->error("\nError updating product ID {$product->id}: " . $e->getMessage());
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        
        $this->newLine(2);
        $this->info("GST update completed!");
        $this->info("✅ Successfully updated: {$updated} products");
        
        if ($errors > 0) {
            $this->error("❌ Errors encountered: {$errors} products");
        }
        
        $this->info("All products now have {$gstRate}% GST rate with price_includes_tax = true");
    }
}
