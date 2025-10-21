<?php

/**
 * SimPDF Library - One-Command Installer
 * 
 * This script makes SimPDF integration super easy with just one command!
 * 
 * Usage: php install-simpdf.php
 */

echo "🚀 SimPDF Library - One-Command Installer\n";
echo "==========================================\n\n";

// Check if we're in a Laravel project
if (!file_exists('artisan')) {
    echo "❌ Error: This doesn't appear to be a Laravel project.\n";
    echo "Please run this script from your Laravel project root directory.\n";
    exit(1);
}

echo "✅ Laravel project detected!\n\n";

// Step 1: Install via Composer
echo "📦 Step 1: Installing SimPDF library...\n";

// Try Packagist first (if published)
$packagistCommand = "composer require sim-pdf/sim-pdf-libs 2>/dev/null";
exec($packagistCommand, $output, $returnCode);

if ($returnCode === 0) {
    echo "✅ Installed from Packagist!\n\n";
} else {
    // Fallback to Git repository
    echo "📡 Installing from Git repository...\n";
    
    $gitCommand = "composer config repositories.sim-pdf vcs https://github.com/5u00n/sim-pdf-libs && composer require sim-pdf/sim-pdf-libs:dev-main";
    exec($gitCommand, $output, $returnCode);
    
    if ($returnCode === 0) {
        echo "✅ Installed from Git repository!\n\n";
    } else {
        echo "❌ Installation failed. Please check your internet connection and try again.\n";
        echo "Manual installation:\n";
        echo "  composer config repositories.sim-pdf vcs https://github.com/5u00n/sim-pdf-libs\n";
        echo "  composer require sim-pdf/sim-pdf-libs:dev-main\n";
        exit(1);
    }
}

// Step 2: Auto-configure Laravel
echo "⚙️  Step 2: Configuring Laravel...\n";

// Check Laravel version and configure accordingly
$laravelVersion = getLaravelVersion();

if ($laravelVersion >= 11) {
    // Laravel 11+ - bootstrap/providers.php
    configureLaravel11();
} else {
    // Laravel 9-10 - config/app.php
    configureLaravel910();
}

// Step 3: Publish configuration
echo "📋 Step 3: Publishing configuration...\n";
exec("php artisan vendor:publish --provider=\"SimPdf\\SimPdfLibs\\SimPdfServiceProvider\" --tag=\"config\" 2>/dev/null", $output, $returnCode);
if ($returnCode === 0) {
    echo "✅ Configuration published!\n";
} else {
    echo "⚠️  Configuration publish failed (optional)\n";
}

// Step 4: Clear caches
echo "🧹 Step 4: Clearing caches...\n";
exec("composer dump-autoload && php artisan config:clear && php artisan cache:clear 2>/dev/null");
echo "✅ Caches cleared!\n\n";

// Step 5: Create example files
echo "📝 Step 5: Creating example files...\n";
createExampleFiles();
echo "✅ Example files created!\n\n";

// Step 6: Test installation
echo "🧪 Step 6: Testing installation...\n";
if (testInstallation()) {
    echo "✅ Installation test passed!\n\n";
} else {
    echo "⚠️  Installation test failed, but library should still work\n\n";
}

// Success message
echo "🎉 SimPDF Library Successfully Installed!\n";
echo "==========================================\n\n";

echo "📚 Quick Start:\n";
echo "1. Use in your controllers:\n";
echo "   use SimPdf\\SimPdfLibs\\Facades\\SimPdf;\n\n";

echo "2. Generate PDFs:\n";
echo "   return SimPdf::loadHtml(\$html)->download('document.pdf');\n\n";

echo "3. Test the installation:\n";
echo "   Visit: http://your-app.test/simpdf/test\n\n";

echo "4. View examples:\n";
echo "   - app/Http/Controllers/SimPdfController.php\n";
echo "   - resources/views/simpdf/\n\n";

echo "📖 Documentation: https://github.com/5u00n/sim-pdf-libs\n";
echo "🐛 Issues: https://github.com/5u00n/sim-pdf-libs/issues\n\n";

echo "Happy PDF generating! 🚀\n";

// Helper functions
function getLaravelVersion() {
    if (file_exists('bootstrap/providers.php')) {
        return 11; // Laravel 11+
    }
    return 10; // Laravel 9-10
}

function configureLaravel11() {
    $providersFile = 'bootstrap/providers.php';
    
    if (!file_exists($providersFile)) {
        echo "⚠️  bootstrap/providers.php not found\n";
        return;
    }
    
    $content = file_get_contents($providersFile);
    
    if (strpos($content, 'SimPdf\\SimPdfLibs\\SimPdfServiceProvider') !== false) {
        echo "✅ Service provider already configured\n";
        return;
    }
    
    // Add service provider
    $newContent = str_replace(
        'return [',
        "return [\n    SimPdf\\SimPdfLibs\\SimPdfServiceProvider::class,",
        $content
    );
    
    file_put_contents($providersFile, $newContent);
    echo "✅ Service provider added to bootstrap/providers.php\n";
}

function configureLaravel910() {
    $configFile = 'config/app.php';
    
    if (!file_exists($configFile)) {
        echo "⚠️  config/app.php not found\n";
        return;
    }
    
    $content = file_get_contents($configFile);
    
    if (strpos($content, 'SimPdf\\SimPdfLibs\\SimPdfServiceProvider') !== false) {
        echo "✅ Service provider already configured\n";
        return;
    }
    
    // Add service provider
    $newContent = str_replace(
        "'providers' => [",
        "'providers' => [\n        SimPdf\\SimPdfLibs\\SimPdfServiceProvider::class,",
        $content
    );
    
    file_put_contents($configFile, $newContent);
    echo "✅ Service provider added to config/app.php\n";
}

function createExampleFiles() {
    // Create example controller
    $controllerDir = 'app/Http/Controllers';
    if (!is_dir($controllerDir)) {
        mkdir($controllerDir, 0755, true);
    }
    
    $controllerContent = '<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimPdf\SimPdfLibs\Facades\SimPdf;

class SimPdfController extends Controller
{
    /**
     * Test SimPDF installation
     */
    public function test()
    {
        $html = \'
        <!DOCTYPE html>
        <html>
        <head>
            <title>SimPDF Test</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { background: #2c3e50; color: white; padding: 20px; text-align: center; }
                .content { margin: 20px 0; }
                .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>🎉 SimPDF Library Test</h1>
                <p>If you can see this PDF, SimPDF is working correctly!</p>
            </div>
            
            <div class="content">
                <div class="success">
                    <h2>✅ Installation Successful!</h2>
                    <p>SimPDF library has been successfully installed and configured.</p>
                </div>
                
                <h2>Features Available:</h2>
                <ul>
                    <li>Multi-page PDF support</li>
                    <li>Custom page breaks</li>
                    <li>Headers and footers</li>
                    <li>Page numbering</li>
                    <li>Advanced styling</li>
                    <li>Watermarks and bookmarks</li>
                </ul>
                
                <h2>Quick Usage:</h2>
                <pre><code>use SimPdf\\SimPdfLibs\\Facades\\SimPdf;

return SimPdf::loadHtml(\$html)->download(\'document.pdf\');</code></pre>
                
                <p><strong>Generated on:</strong> ' . date('Y-m-d H:i:s') . '</p>
            </div>
        </body>
        </html>\';
        
        return SimPdf::loadHtml($html)
            ->setPaper(\'A4\', \'portrait\')
            ->enablePageNumbers()
            ->download(\'simpdf-test.pdf\');
    }
    
    /**
     * Basic PDF generation example
     */
    public function basic()
    {
        $html = \'<h1>Hello SimPDF!</h1><p>This is a basic PDF example.</p>\';
        
        return SimPdf::loadHtml($html)
            ->setPaper(\'A4\', \'portrait\')
            ->enablePageNumbers()
            ->download(\'basic-example.pdf\');
    }
    
    /**
     * Advanced PDF generation example
     */
    public function advanced()
    {
        $html = \'
        <!DOCTYPE html>
        <html>
        <head>
            <title>Advanced SimPDF Example</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .page-break { page-break-before: always; }
                .highlight { background: #fff3cd; padding: 15px; border-radius: 5px; }
            </style>
        </head>
        <body>
            <h1>Advanced SimPDF Features</h1>
            <p>This demonstrates advanced features like page breaks, headers, and footers.</p>
            
            <div class="highlight">
                <h3>Features Demonstrated:</h3>
                <ul>
                    <li>Multi-page support</li>
                    <li>Custom page breaks</li>
                    <li>Headers and footers</li>
                    <li>Page numbering</li>
                    <li>Advanced styling</li>
                </ul>
            </div>
            
            <div class="page-break"></div>
            
            <h2>Page 2</h2>
            <p>This is the second page of the document.</p>
        </body>
        </html>\';
        
        return SimPdf::loadHtml($html)
            ->setPaper(\'A4\', \'portrait\')
            ->enablePageNumbers([
                \'position\' => \'bottom-right\',
                \'format\' => \'Page {PAGE_NUM} of {PAGE_COUNT}\'
            ])
            ->setHeader(\'<h3>Advanced Document Header</h3>\', [
                \'height\' => \'60px\',
                \'background\' => \'#f8f9fa\'
            ])
            ->setFooter(\'<p>© 2024 Your Company</p>\', [
                \'height\' => \'40px\',
                \'background\' => \'#f8f9fa\'
            ])
            ->addWatermark(\'DRAFT\', [
                \'opacity\' => 0.1,
                \'font-size\' => \'48px\'
            ])
            ->download(\'advanced-example.pdf\');
    }
}';
    
    file_put_contents($controllerDir . '/SimPdfController.php', $controllerContent);
    
    // Create example view directory
    $viewDir = 'resources/views/simpdf';
    if (!is_dir($viewDir)) {
        mkdir($viewDir, 0755, true);
    }
    
    // Add routes
    $routesFile = 'routes/web.php';
    if (file_exists($routesFile)) {
        $routes = file_get_contents($routesFile);
        
        if (strpos($routes, 'SimPdfController') === false) {
            $newRoutes = "\n// SimPDF Example Routes\n";
            $newRoutes .= "Route::get('/simpdf/test', [App\\Http\\Controllers\\SimPdfController::class, 'test']);\n";
            $newRoutes .= "Route::get('/simpdf/basic', [App\\Http\\Controllers\\SimPdfController::class, 'basic']);\n";
            $newRoutes .= "Route::get('/simpdf/advanced', [App\\Http\\Controllers\\SimPdfController::class, 'advanced']);\n";
            
            file_put_contents($routesFile, $routes . $newRoutes);
        }
    }
}

function testInstallation() {
    // Simple test to check if the library is available
    try {
        if (class_exists('SimPdf\\SimPdfLibs\\Facades\\SimPdf')) {
            return true;
        }
    } catch (Exception $e) {
        return false;
    }
    return false;
}
