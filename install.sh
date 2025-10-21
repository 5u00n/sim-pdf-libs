#!/bin/bash

# SimPDF Library - One-Command Installer
# Makes SimPDF integration super easy!

echo "🚀 SimPDF Library - One-Command Installer"
echo "=========================================="
echo ""

# Check if we're in a Laravel project
if [ ! -f "artisan" ]; then
    echo "❌ Error: Not in a Laravel project"
    echo "Please run this from your Laravel project root"
    exit 1
fi

echo "✅ Laravel project detected!"
echo ""

# Install SimPDF
echo "📦 Installing SimPDF library..."

# Try Packagist first
if composer require sim-pdf/sim-pdf-libs 2>/dev/null; then
    echo "✅ Installed from Packagist!"
else
    # Fallback to Git
    echo "📡 Installing from Git repository..."
    composer config repositories.sim-pdf vcs https://github.com/5u00n/sim-pdf-libs
    composer require sim-pdf/sim-pdf-libs:dev-main
    echo "✅ Installed from Git repository!"
fi

echo ""

# Auto-configure Laravel
echo "⚙️  Configuring Laravel..."

# Check Laravel version
if [ -f "bootstrap/providers.php" ]; then
    # Laravel 11+
    if ! grep -q "SimPdf" bootstrap/providers.php; then
        sed -i '' 's/return \[/&\
    SimPdf\\SimPdfLibs\\SimPdfServiceProvider::class,/' bootstrap/providers.php
        echo "✅ Added to bootstrap/providers.php"
    else
        echo "✅ Already configured"
    fi
else
    # Laravel 9-10
    if ! grep -q "SimPdf" config/app.php; then
        sed -i '' 's/'\''providers'\'' => \[/&\
        SimPdf\\SimPdfLibs\\SimPdfServiceProvider::class,/' config/app.php
        echo "✅ Added to config/app.php"
    else
        echo "✅ Already configured"
    fi
fi

echo ""

# Clear caches
echo "🧹 Clearing caches..."
composer dump-autoload >/dev/null 2>&1
php artisan config:clear >/dev/null 2>&1
php artisan cache:clear >/dev/null 2>&1
echo "✅ Caches cleared!"

echo ""

# Create example controller
echo "📝 Creating example files..."

cat > app/Http/Controllers/SimPdfController.php << 'EOF'
<?php

namespace App\Http\Controllers;

use SimPdf\SimPdfLibs\Facades\SimPdf;

class SimPdfController extends Controller
{
    public function test()
    {
        $html = '<!DOCTYPE html><html><head><title>SimPDF Test</title></head><body><h1>🎉 SimPDF Works!</h1><p>If you can see this PDF, SimPDF is working correctly!</p></body></html>';
        return SimPdf::loadHtml($html)->download('test.pdf');
    }
}
EOF

# Add routes
if ! grep -q "SimPdfController" routes/web.php; then
    echo "" >> routes/web.php
    echo "// SimPDF Test Route" >> routes/web.php
    echo "Route::get('/simpdf/test', [App\\Http\\Controllers\\SimPdfController::class, 'test']);" >> routes/web.php
fi

echo "✅ Example files created!"

echo ""

# Success message
echo "🎉 SimPDF Successfully Installed!"
echo "================================="
echo ""
echo "📚 Quick Start:"
echo "1. Test: http://your-app.test/simpdf/test"
echo "2. Use: SimPdf::loadHtml(\$html)->download('file.pdf')"
echo ""
echo "📖 Docs: https://github.com/5u00n/sim-pdf-libs"
echo ""
echo "Happy PDF generating! 🚀"
