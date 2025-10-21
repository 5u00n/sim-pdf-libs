<?php

/**
 * Installation script to add SimPDF to your existing Laravel project
 */

echo "SimPDF Library - Installation to Existing Project\n";
echo "==================================================\n\n";

// Check if we're in a Laravel project
if (!file_exists('artisan')) {
    echo "❌ Error: This doesn't appear to be a Laravel project.\n";
    echo "Please run this script from your Laravel project root directory.\n";
    exit(1);
}

echo "✅ Laravel project detected.\n";

// Get the current project path
$projectPath = getcwd();
$gitRepository = 'https://github.com/5u00n/sim-pdf-libs.git';

echo "📁 Project path: {$projectPath}\n";
echo "🌐 Git repository: {$gitRepository}\n\n";

// Step 1: Clone SimPDF from Git repository
echo "Step 1: Cloning SimPDF library from Git repository...\n";

$targetPath = $projectPath . '/packages/sim-pdf-libs';
if (!is_dir('packages')) {
    mkdir('packages', 0755, true);
}

if (is_dir($targetPath)) {
    echo "⚠️  SimPDF already exists in packages/sim-pdf-libs\n";
    echo "   Removing existing version...\n";
    exec("rm -rf {$targetPath}");
}

// Clone the repository
$cloneCommand = "git clone {$gitRepository} {$targetPath}";
exec($cloneCommand, $output, $returnCode);

if ($returnCode === 0 && is_dir($targetPath)) {
    echo "✅ SimPDF library cloned successfully\n";
} else {
    echo "❌ Failed to clone SimPDF library\n";
    echo "   Make sure you have Git installed and the repository URL is correct\n";
    echo "   You can also manually clone: git clone {$gitRepository} packages/sim-pdf-libs\n";
    exit(1);
}

// Step 2: Update composer.json
echo "\nStep 2: Updating composer.json...\n";

$composerJsonPath = $projectPath . '/composer.json';
if (!file_exists($composerJsonPath)) {
    echo "❌ composer.json not found\n";
    exit(1);
}

$composerJson = json_decode(file_get_contents($composerJsonPath), true);

// Add repository
if (!isset($composerJson['repositories'])) {
    $composerJson['repositories'] = [];
}

$composerJson['repositories']['sim-pdf'] = [
    'type' => 'path',
    'url' => './packages/sim-pdf-libs'
];

// Add requirement
if (!isset($composerJson['require'])) {
    $composerJson['require'] = [];
}

$composerJson['require']['sim-pdf/sim-pdf-libs'] = '*';

file_put_contents($composerJsonPath, json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "✅ composer.json updated\n";

// Step 3: Update config/app.php
echo "\nStep 3: Updating Laravel configuration...\n";

$configAppPath = $projectPath . '/config/app.php';
if (file_exists($configAppPath)) {
    $configApp = file_get_contents($configAppPath);
    
    // Add service provider
    if (strpos($configApp, 'SimPdf\\SimPdfLibs\\SimPdfServiceProvider') === false) {
        $configApp = str_replace(
            "'providers' => [",
            "'providers' => [\n        SimPdf\\SimPdfLibs\\SimPdfServiceProvider::class,",
            $configApp
        );
        
        file_put_contents($configAppPath, $configApp);
        echo "✅ Service provider added to config/app.php\n";
    } else {
        echo "✅ Service provider already exists in config/app.php\n";
    }
} else {
    echo "⚠️  config/app.php not found (Laravel 11+ might use bootstrap/providers.php)\n";
    
    // Try bootstrap/providers.php for Laravel 11+
    $providersPath = $projectPath . '/bootstrap/providers.php';
    if (file_exists($providersPath)) {
        $providers = file_get_contents($providersPath);
        
        if (strpos($providers, 'SimPdf\\SimPdfLibs\\SimPdfServiceProvider') === false) {
            $providers = str_replace(
                'return [',
                "return [\n    SimPdf\\SimPdfLibs\\SimPdfServiceProvider::class,",
                $providers
            );
            
            file_put_contents($providersPath, $providers);
            echo "✅ Service provider added to bootstrap/providers.php\n";
        } else {
            echo "✅ Service provider already exists in bootstrap/providers.php\n";
        }
    }
}

// Step 4: Create example controller
echo "\nStep 4: Creating example controller...\n";

$controllerPath = $projectPath . '/app/Http/Controllers/SimPdfController.php';
$controllerContent = '<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimPdf\SimPdfLibs\Facades\SimPdf;

class SimPdfController extends Controller
{
    /**
     * Basic PDF generation example
     */
    public function basic()
    {
        $html = \'<h1>Hello from SimPDF!</h1><p>This is a basic PDF generated with SimPDF library.</p>\';
        
        return SimPdf::loadHtml($html)
            ->setPaper(\'A4\', \'portrait\')
            ->enablePageNumbers()
            ->download(\'basic-document.pdf\');
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
            <title>Advanced PDF</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .page-break { page-break-before: always; }
                .highlight { background: #fff3cd; padding: 15px; border-radius: 5px; }
            </style>
        </head>
        <body>
            <h1>Advanced PDF Document</h1>
            <p>This demonstrates advanced SimPDF features.</p>
            
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
            ->download(\'advanced-document.pdf\');
    }
    
    /**
     * Generate PDF from your existing data
     */
    public function fromData(Request $request)
    {
        // Example: Get your existing data
        $data = [
            \'title\' => \'Sample Report\',
            \'items\' => [
                [\'name\' => \'Item 1\', \'price\' => 100],
                [\'name\' => \'Item 2\', \'price\' => 200],
                [\'name\' => \'Item 3\', \'price\' => 300],
            ]
        ];
        
        $html = view(\'simpdf.sample\', $data)->render();
        
        return SimPdf::loadHtml($html)
            ->setPaper(\'A4\', \'portrait\')
            ->enablePageNumbers()
            ->setHeader(\'<h3>Sample Report</h3>\')
            ->setFooter(\'<p>Generated on \' . date(\'Y-m-d H:i:s\') . \'</p>\')
            ->download(\'sample-report.pdf\');
    }
}';

file_put_contents($controllerPath, $controllerContent);
echo "✅ Example controller created: app/Http/Controllers/SimPdfController.php\n";

// Step 5: Create example view
echo "\nStep 5: Creating example view...\n";

$viewDir = $projectPath . '/resources/views/simpdf';
if (!is_dir($viewDir)) {
    mkdir($viewDir, 0755, true);
}

$viewPath = $viewDir . '/sample.blade.php';
$viewContent = '<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .page-break { page-break-before: always; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #3498db; color: white; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>Generated on: {{ date(\'Y-m-d H:i:s\') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item[\'name\'] }}</td>
                <td>${{ $item[\'price\'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>';

file_put_contents($viewPath, $viewContent);
echo "✅ Example view created: resources/views/simpdf/sample.blade.php\n";

// Step 6: Add routes
echo "\nStep 6: Adding example routes...\n";

$routesPath = $projectPath . '/routes/web.php';
if (file_exists($routesPath)) {
    $routes = file_get_contents($routesPath);
    
    if (strpos($routes, 'SimPdfController') === false) {
        $newRoutes = "\n// SimPDF Example Routes\n";
        $newRoutes .= "Route::get('/pdf/basic', [App\\Http\\Controllers\\SimPdfController::class, 'basic']);\n";
        $newRoutes .= "Route::get('/pdf/advanced', [App\\Http\\Controllers\\SimPdfController::class, 'advanced']);\n";
        $newRoutes .= "Route::get('/pdf/sample', [App\\Http\\Controllers\\SimPdfController::class, 'fromData']);\n";
        
        file_put_contents($routesPath, $routes . $newRoutes);
        echo "✅ Example routes added to routes/web.php\n";
    } else {
        echo "✅ Example routes already exist in routes/web.php\n";
    }
}

// Step 7: Create configuration file
echo "\nStep 7: Creating configuration file...\n";

$configPath = $projectPath . '/config/simpdf.php';
if (!file_exists($configPath)) {
    $configContent = file_get_contents($simpdfPath . '/config/simpdf.php');
    file_put_contents($configPath, $configContent);
    echo "✅ Configuration file created: config/simpdf.php\n";
} else {
    echo "✅ Configuration file already exists: config/simpdf.php\n";
}

echo "\n🎉 Installation completed successfully!\n\n";
echo "Next steps:\n";
echo "1. Run: composer install\n";
echo "2. Run: php artisan config:clear\n";
echo "3. Run: php artisan cache:clear\n";
echo "4. Visit: http://your-app.test/pdf/basic\n";
echo "5. Visit: http://your-app.test/pdf/advanced\n";
echo "6. Visit: http://your-app.test/pdf/sample\n\n";
echo "The SimPDF library is now integrated into your existing Laravel project!\n";
echo "Check the example controller and view to see how to use it with your data.\n";
