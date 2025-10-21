# SimPDF Library - Final Integration Guide

## 🚀 How to Apply SimPDF to Your Existing Laravel Project

**Repository:** [https://github.com/5u00n/sim-pdf-libs](https://github.com/5u00n/sim-pdf-libs)

### Step 1: Install the Library

#### Option A: Install from Git Repository (Recommended)

```bash
# In your existing Laravel project root
composer config repositories.sim-pdf vcs https://github.com/5u00n/sim-pdf-libs
composer require sim-pdf/sim-pdf-libs:dev-main
```

#### Option B: Install as Git Submodule

```bash
# Add as Git submodule to your project
git submodule add https://github.com/5u00n/sim-pdf-libs.git packages/sim-pdf-libs

# Add to composer.json
composer config repositories.sim-pdf path packages/sim-pdf-libs
composer require sim-pdf/sim-pdf-libs:*
```

#### Option C: Manual Git Clone

```bash
# Clone the repository manually
git clone https://github.com/5u00n/sim-pdf-libs.git packages/sim-pdf-libs

# Add to composer.json
composer config repositories.sim-pdf path packages/sim-pdf-libs
composer require sim-pdf/sim-pdf-libs:*
```

### Step 2: Register the Service Provider

#### For Laravel 9-10 (config/app.php):

```php
'providers' => [
    // ... other providers
    SimPdf\SimPdfLibs\SimPdfServiceProvider::class,
],
```

#### For Laravel 11+ (bootstrap/providers.php):

```php
return [
    // ... other providers
    SimPdf\SimPdfLibs\SimPdfServiceProvider::class,
];
```

### Step 3: Publish Configuration (Optional)

```bash
php artisan vendor:publish --provider="SimPdf\SimPdfLibs\SimPdfServiceProvider" --tag="config"
```

### Step 4: Use in Your Existing Code

#### Basic Usage in Controllers

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimPdf\SimPdfLibs\Facades\SimPdf;

class YourExistingController extends Controller
{
    public function generatePdf(Request $request)
    {
        // Your existing data
        $data = $this->getYourExistingData();

        // Convert your existing view to PDF
        $html = view('your-existing-view', $data)->render();

        return SimPdf::loadHtml($html)
            ->setPaper('A4', 'portrait')
            ->enablePageNumbers()
            ->download('document.pdf');
    }
}
```

#### Advanced Usage with Headers/Footers

```php
public function generateAdvancedPdf(Request $request)
{
    $data = $this->getYourExistingData();
    $html = view('your-existing-view', $data)->render();

    return SimPdf::loadHtml($html)
        ->setPaper('A4', 'portrait')
        ->enablePageNumbers([
            'position' => 'bottom-right',
            'format' => 'Page {PAGE_NUM} of {PAGE_COUNT}'
        ])
        ->setHeader('<h3>Your Company Header</h3>', [
            'height' => '60px',
            'background' => '#f8f9fa'
        ])
        ->setFooter('<p>© 2024 Your Company</p>', [
            'height' => '40px',
            'background' => '#f8f9fa'
        ])
        ->addWatermark('DRAFT', [
            'opacity' => 0.1,
            'font-size' => '48px'
        ])
        ->download('advanced-document.pdf');
}
```

### Step 5: Update Your Existing Views

#### Add CSS Classes for Page Breaks

In your existing Blade templates, add these CSS classes:

```css
/* Add to your existing CSS or in a <style> tag */
.page-break {
  page-break-before: always;
}

.no-page-break {
  page-break-inside: avoid;
}

.break-before {
  page-break-before: always;
}

.break-after {
  page-break-after: always;
}
```

### Step 6: Replace Existing PDF Generation

#### If you're using other PDF libraries (like barryvdh/laravel-dompdf):

**Before:**

```php
use Barryvdh\DomPDF\Facade\Pdf;

$pdf = Pdf::loadView('your-view', $data);
return $pdf->download('document.pdf');
```

**After:**

```php
use SimPdf\SimPdfLibs\Facades\SimPdf;

$html = view('your-view', $data)->render();
return SimPdf::loadHtml($html)
    ->enablePageNumbers()
    ->download('document.pdf');
```

### Step 7: Add Routes

Add to your `routes/web.php`:

```php
Route::get('/pdf/generate', [YourController::class, 'generatePdf']);
Route::get('/pdf/advanced', [YourController::class, 'generateAdvancedPdf']);
```

## 🎯 Quick Installation Commands

```bash
# 1. Install from Git
composer config repositories.sim-pdf vcs https://github.com/5u00n/sim-pdf-libs
composer require sim-pdf/sim-pdf-libs:dev-main

# 2. Clear caches
composer dump-autoload
php artisan config:clear
php artisan cache:clear

# 3. Test the installation
php artisan tinker
>>> SimPdf::loadHtml('<h1>Test</h1>')->output();
```

## 🎯 Common Use Cases

### 1. Invoice Generation

```php
public function generateInvoice($invoiceId)
{
    $invoice = Invoice::find($invoiceId);
    $html = view('invoices.pdf', compact('invoice'))->render();

    return SimPdf::loadHtml($html)
        ->setPaper('A4', 'portrait')
        ->enablePageNumbers()
        ->setHeader('<h3>Invoice #' . $invoice->number . '</h3>')
        ->setFooter('<p>Thank you for your business!</p>')
        ->download('invoice-' . $invoice->number . '.pdf');
}
```

### 2. Report Generation

```php
public function generateReport(Request $request)
{
    $data = $this->getReportData($request);
    $html = view('reports.pdf', $data)->render();

    return SimPdf::loadHtml($html)
        ->setPaper('A4', 'portrait')
        ->enablePageNumbers()
        ->setHeader('<h3>Monthly Report - ' . date('F Y') . '</h3>')
        ->setFooter('<p>Generated on ' . date('Y-m-d H:i:s') . '</p>')
        ->addWatermark('CONFIDENTIAL')
        ->download('monthly-report.pdf');
}
```

### 3. Large Table Export

```php
public function exportTable()
{
    $data = $this->getLargeTableData();
    $html = view('tables.pdf', compact('data'))->render();

    return SimPdf::loadHtml($html)
        ->breakTable(['repeat_header' => true])
        ->enablePageNumbers()
        ->download('table-export.pdf');
}
```

## 🔧 Troubleshooting

### If you get "Class not found" errors:

```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### If Git clone fails:

1. Check your Git installation: `git --version`
2. Verify the repository URL is correct: [https://github.com/5u00n/sim-pdf-libs](https://github.com/5u00n/sim-pdf-libs)
3. Ensure you have access to the repository
4. Try cloning manually: `git clone https://github.com/5u00n/sim-pdf-libs.git`

## 📞 Support

The SimPDF library is now integrated into your existing Laravel project! You can start using it immediately with your existing views and data.

**Repository:** [https://github.com/5u00n/sim-pdf-libs](https://github.com/5u00n/sim-pdf-libs)

## 🚀 Next Steps

1. **Install the library** using the commands above
2. **Update your existing controllers** to use SimPdf facade
3. **Add page breaks** to your existing views where needed
4. **Configure headers and footers** for your documents
5. **Test with your existing data** to ensure everything works
6. **Deploy to production** with confidence!

The SimPDF library is production-ready and will enhance your existing Laravel application with powerful PDF generation capabilities.
