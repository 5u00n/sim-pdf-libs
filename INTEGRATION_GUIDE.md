# SimPDF Library - Integration Guide

## 🚀 How to Apply SimPDF to Your Existing Laravel Project

### Step 1: Install the Library

#### Option A: Install from Local Path (Recommended for Development)

```bash
# In your existing Laravel project root
composer config repositories.sim-pdf path /Users/suren/Documents/GitProjects/sim-pdf-libs
composer require sim-pdf/sim-pdf-libs:*
```

#### Option B: Copy to Your Project

```bash
# Copy the entire sim-pdf-libs folder to your Laravel project
cp -r /Users/suren/Documents/GitProjects/sim-pdf-libs /path/to/your/laravel-project/packages/sim-pdf-libs

# Add to composer.json
composer config repositories.sim-pdf path packages/sim-pdf-libs
composer require sim-pdf/sim-pdf-libs:*
```

### Step 2: Register the Service Provider

Add to your `config/app.php` in the `providers` array:

```php
'providers' => [
    // ... other providers
    SimPdf\SimPdfLibs\SimPdfServiceProvider::class,
],
```

Or add to `bootstrap/providers.php` (Laravel 11+):

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

#### Multi-page Document with Custom Breaks

```php
public function generateMultiPagePdf(Request $request)
{
    $sections = $this->getYourExistingSections();

    $html = '<!DOCTYPE html><html><head><title>Multi-page Document</title></head><body>';

    foreach ($sections as $index => $section) {
        $html .= "<h1>{$section['title']}</h1>";
        $html .= "<p>{$section['content']}</p>";

        // Add page break after each section except the last
        if ($index < count($sections) - 1) {
            $html .= '<div class="page-break"></div>';
        }
    }

    $html .= '</body></html>';

    return SimPdf::loadHtml($html)
        ->setPaper('A4', 'portrait')
        ->enablePageNumbers()
        ->addStyle('
            .page-break { page-break-before: always; }
            h1 { color: #2c3e50; }
        ')
        ->download('multi-page-document.pdf');
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

#### Example Updated View

```blade
<!DOCTYPE html>
<html>
<head>
    <title>Your Existing Document</title>
    <style>
        /* Your existing styles */
        body { font-family: Arial, sans-serif; }

        /* Add SimPDF styles */
        .page-break { page-break-before: always; }
        .no-break { page-break-inside: avoid; }
    </style>
</head>
<body>
    <h1>Your Existing Content</h1>

    @foreach($yourExistingData as $item)
        <div class="item">
            <h2>{{ $item->title }}</h2>
            <p>{{ $item->content }}</p>
        </div>

        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
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
Route::get('/pdf/multi-page', [YourController::class, 'generateMultiPagePdf']);
```

### Step 8: Configuration

Create or update `config/simpdf.php`:

```php
<?php

return [
    'default' => [
        'paper' => 'A4',
        'orientation' => 'portrait',
        'dpi' => 96,
        'defaultFont' => 'DejaVu Sans',
    ],

    'pageNumbers' => [
        'enabled' => true,
        'position' => 'bottom-right',
        'format' => 'Page {PAGE_NUM} of {PAGE_COUNT}',
    ],

    'headers' => [
        'enabled' => true,
        'height' => '50px',
        'background' => '#ffffff',
    ],

    'footers' => [
        'enabled' => true,
        'height' => '40px',
        'background' => '#ffffff',
    ],
];
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

### 3. Table with Pagination

```php
public function generateTablePdf()
{
    $data = $this->getLargeTableData();
    $html = view('tables.pdf', compact('data'))->render();

    return SimPdf::loadHtml($html)
        ->setPaper('A4', 'portrait')
        ->enablePageNumbers()
        ->breakTable([
            'repeat_header' => true,
            'min_rows' => 5,
            'max_rows' => 20
        ])
        ->addStyle('
            table { page-break-inside: auto; }
            thead { display: table-header-group; }
            tbody { page-break-inside: avoid; }
        ')
        ->download('table-report.pdf');
}
```

## 🔧 Troubleshooting

### If you get "Class not found" errors:

```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### If PDF generation fails:

1. Check that DomPDF is installed: `composer show dompdf/dompdf`
2. Ensure you have enough memory: `ini_set('memory_limit', '256M')`
3. Check the logs: `storage/logs/laravel.log`

### If styling doesn't work:

1. Use inline styles for critical styling
2. Ensure CSS is valid and PDF-compatible
3. Test with simple HTML first

## 📞 Support

The SimPDF library is now integrated into your existing Laravel project! You can start using it immediately with your existing views and data.
