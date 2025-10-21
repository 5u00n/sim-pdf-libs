<?php

/**
 * SimPDF Library Installation Script
 * 
 * This script helps you install and configure the SimPDF library
 * in your Laravel application.
 */

echo "SimPDF Library Installation Script\n";
echo "==================================\n\n";

// Check if we're in a Laravel project
if (!file_exists('artisan')) {
    echo "❌ Error: This doesn't appear to be a Laravel project.\n";
    echo "Please run this script from your Laravel project root directory.\n";
    exit(1);
}

echo "✅ Laravel project detected.\n";

// Check PHP version
if (version_compare(PHP_VERSION, '8.0.0', '<')) {
    echo "❌ Error: PHP 8.0 or higher is required. Current version: " . PHP_VERSION . "\n";
    exit(1);
}

echo "✅ PHP version check passed: " . PHP_VERSION . "\n";

// Check if Composer is available
if (!file_exists('composer.json')) {
    echo "❌ Error: composer.json not found. Please run 'composer init' first.\n";
    exit(1);
}

echo "✅ Composer project detected.\n";

// Check if the package is already installed
if (file_exists('vendor/sim-pdf/sim-pdf-libs')) {
    echo "✅ SimPDF library is already installed.\n";
} else {
    echo "📦 Installing SimPDF library...\n";
    
    // Add the package to composer.json
    $composerJson = json_decode(file_get_contents('composer.json'), true);
    
    if (!isset($composerJson['repositories'])) {
        $composerJson['repositories'] = [];
    }
    
    // Add local repository
    $composerJson['repositories'][] = [
        'type' => 'path',
        'url' => './sim-pdf-libs'
    ];
    
    if (!isset($composerJson['require'])) {
        $composerJson['require'] = [];
    }
    
    $composerJson['require']['sim-pdf/sim-pdf-libs'] = '*';
    
    file_put_contents('composer.json', json_encode($composerJson, JSON_PRETTY_PRINT));
    
    echo "✅ Added SimPDF to composer.json\n";
    echo "📦 Run 'composer install' to install the package.\n";
}

// Check if config file exists
if (!file_exists('config/simpdf.php')) {
    echo "📋 Publishing configuration file...\n";
    echo "Run: php artisan vendor:publish --provider=\"SimPdf\\SimPdfLibs\\SimPdfServiceProvider\" --tag=\"config\"\n";
} else {
    echo "✅ Configuration file already exists.\n";
}

// Check if views directory exists
if (!file_exists('resources/views/vendor/simpdf')) {
    echo "📋 Publishing views...\n";
    echo "Run: php artisan vendor:publish --provider=\"SimPdf\\SimPdfLibs\\SimPdfServiceProvider\" --tag=\"views\"\n";
} else {
    echo "✅ Views already published.\n";
}

// Create example controller
$controllerPath = 'app/Http/Controllers/PdfController.php';
if (!file_exists($controllerPath)) {
    echo "📝 Creating example controller...\n";
    
    $controllerContent = '<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimPdf\SimPdfLibs\Facades\SimPdf;

class PdfController extends Controller
{
    public function generateBasicPdf()
    {
        $html = \'<h1>Hello World</h1><p>This is a basic PDF generated with SimPDF.</p>\';
        
        return SimPdf::loadHtml($html)
            ->setPaper(\'A4\', \'portrait\')
            ->enablePageNumbers()
            ->download(\'basic-document.pdf\');
    }
    
    public function generateAdvancedPdf()
    {
        $html = \'
        <!DOCTYPE html>
        <html>
        <head><title>Advanced PDF</title></head>
        <body>
            <h1>Advanced PDF Document</h1>
            <p>This demonstrates advanced features.</p>
            
            <div class="page-break"></div>
            
            <h2>Page 2</h2>
            <p>This is the second page.</p>
        </body>
        </html>\';
        
        return SimPdf::loadHtml($html)
            ->setPaper(\'A4\', \'portrait\')
            ->enablePageNumbers([
                \'position\' => \'bottom-right\',
                \'format\' => \'Page {PAGE_NUM} of {PAGE_COUNT}\'
            ])
            ->setHeader(\'<h3>Company Header</h3>\')
            ->setFooter(\'<p>© 2024 Company Name</p>\')
            ->addWatermark(\'DRAFT\', [
                \'opacity\' => 0.3,
                \'font-size\' => \'48px\'
            ])
            ->download(\'advanced-document.pdf\');
    }
}';
    
    file_put_contents($controllerPath, $controllerContent);
    echo "✅ Example controller created at {$controllerPath}\n";
} else {
    echo "✅ Example controller already exists.\n";
}

// Create routes
$routesPath = 'routes/web.php';
if (file_exists($routesPath)) {
    $routesContent = file_get_contents($routesPath);
    
    if (strpos($routesContent, 'PdfController') === false) {
        echo "📝 Adding example routes...\n";
        
        $newRoutes = "\n// SimPDF Example Routes\n";
        $newRoutes .= "Route::get('/pdf/basic', [App\\Http\\Controllers\\PdfController::class, 'generateBasicPdf']);\n";
        $newRoutes .= "Route::get('/pdf/advanced', [App\\Http\\Controllers\\PdfController::class, 'generateAdvancedPdf']);\n";
        
        file_put_contents($routesPath, $routesContent . $newRoutes);
        echo "✅ Example routes added to {$routesPath}\n";
    } else {
        echo "✅ Example routes already exist.\n";
    }
}

echo "\n🎉 Installation completed!\n\n";
echo "Next steps:\n";
echo "1. Run: composer install\n";
echo "2. Run: php artisan vendor:publish --provider=\"SimPdf\\SimPdfLibs\\SimPdfServiceProvider\" --tag=\"config\"\n";
echo "3. Run: php artisan vendor:publish --provider=\"SimPdf\\SimPdfLibs\\SimPdfServiceProvider\" --tag=\"views\"\n";
echo "4. Visit: http://your-app.test/pdf/basic\n";
echo "5. Visit: http://your-app.test/pdf/advanced\n\n";
echo "For more examples, check the examples/ directory in the package.\n";
echo "For documentation, see README.md\n";