<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\WhatsAppTemplate;

echo "Submitting WhatsApp templates to Meta for approval...\n\n";

// Get all draft templates
$draftTemplates = WhatsAppTemplate::where('status', 'draft')->get();

echo "Found " . $draftTemplates->count() . " draft templates to submit.\n\n";

foreach ($draftTemplates as $template) {
    echo "Submitting: {$template->display_name} (ID: {$template->id})...\n";
    
    try {
        $result = $template->submitToWhatsApp();
        
        if ($result['success']) {
            echo "  ✅ Submitted successfully! WhatsApp Template ID: {$result['template_id']}\n";
        } else {
            echo "  ❌ Failed: {$result['message']}\n";
        }
    } catch (\Exception $e) {
        echo "  ❌ Error: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
    sleep(2); // Rate limiting - wait 2 seconds between submissions
}

echo "========================================\n";
echo "Submission complete!\n";
echo "========================================\n";

// Show summary
$statusCounts = WhatsAppTemplate::select('status', \DB::raw('count(*) as count'))
    ->groupBy('status')
    ->pluck('count', 'status');

echo "\nTemplate Status Summary:\n";
foreach ($statusCounts as $status => $count) {
    echo "  {$status}: {$count}\n";
}

echo "\nNote: Templates are now in 'pending' status. They will be reviewed by Meta.\n";
echo "Check the WhatsApp Marketing dashboard to see when they are approved.\n";

