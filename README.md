# SimPDF Library

A comprehensive PDF generation library for Laravel with advanced features including multi-page support, custom page breaks, headers/footers, and full styling capabilities.

## Features

- 🚀 **Multi-page Support** - Handle large documents with automatic pagination
- 📄 **Custom Page Breaks** - Break pages anywhere you want, even within tables
- 📊 **Table Pagination** - Smart table breaking with repeated headers
- 🔢 **Page Numbering** - Automatic page numbering with custom formats
- 📋 **Headers & Footers** - Customizable headers and footers for each page
- 🎨 **Advanced Styling** - Full CSS support including Microsoft Word-like formatting
- 💧 **Watermarks** - Add watermarks to your PDFs
- 🔖 **Bookmarks** - Create PDF bookmarks for navigation
- 📝 **Metadata** - Set PDF metadata (title, author, subject, etc.)
- ⚡ **Performance** - Optimized for large documents and high performance

## 🚀 Installation

### Packagist Installation (Recommended)

```bash
# Install from Packagist
composer require sim-pdf/sim-pdf-libs

# Publish config (optional)
php artisan vendor:publish --provider="SimPdf\SimPdfLibs\SimPdfServiceProvider" --tag="config"
```

### One-Command Installer

```bash
# Download and run installer (from your Laravel project root)
curl -O https://raw.githubusercontent.com/5u00n/sim-pdf-libs/main/install-simpdf.php && php install-simpdf.php
```

### Git Installation

```bash
# Install from Git repository
composer config repositories.sim-pdf vcs https://github.com/5u00n/sim-pdf-libs
composer require sim-pdf/sim-pdf-libs:dev-main
```

## 🎯 Quick Start

### Basic PDF (3 lines!)

```php
use SimPdf\SimPdfLibs\Facades\SimPdf;

$html = '<h1>Hello World</h1><p>This is a PDF!</p>';
return SimPdf::loadHtml($html)->download('document.pdf');
```

### Test Installation

After installation, visit: `http://your-app.test/simpdf/test`

## 🎯 When to Use SimPDF

### ✅ **Perfect For:**

- **📊 Reports & Invoices** - Professional business documents
- **📋 Contracts & Legal Docs** - Multi-page documents with headers/footers
- **📚 Manuals & Guides** - Large documents with bookmarks and page numbers
- **📈 Data Reports** - Tables with pagination and custom breaks
- **🎨 Styled Documents** - Microsoft Word-like formatting
- **📄 Forms & Applications** - Complex layouts with styling
- **📑 Catalogs & Brochures** - Multi-page marketing materials
- **📊 Financial Statements** - Professional financial documents

### ❌ **Not Ideal For:**

- **🖼️ Image-heavy PDFs** - Use specialized image-to-PDF tools
- **📱 Interactive PDFs** - Use Adobe Acrobat or similar
- **🎬 Video/Audio PDFs** - Use multimedia PDF tools
- **📊 Complex Charts** - Use chart-specific libraries first

### 🚀 **Best Use Cases:**

#### 1. **Business Reports**

```php
// Perfect for monthly/quarterly reports
SimPdf::loadHtml($reportHtml)
    ->setPaper('A4', 'portrait')
    ->enablePageNumbers()
    ->setHeader('Monthly Report - ' . date('F Y'))
    ->setFooter('Confidential - Page {PAGE_NUM}')
    ->download('monthly-report.pdf');
```

#### 2. **Invoice Generation**

```php
// Perfect for invoices with line items
SimPdf::loadHtml($invoiceHtml)
    ->breakTable(['repeat_header' => true])
    ->setHeader('INVOICE #' . $invoiceNumber)
    ->setFooter('Payment due within 30 days')
    ->download('invoice.pdf');
```

#### 3. **User Manuals**

```php
// Perfect for documentation with bookmarks
SimPdf::loadHtml($manualHtml)
    ->addBookmark('Introduction', 1)
    ->addBookmark('Installation', 1)
    ->addBookmark('Configuration', 1)
    ->addBookmark('Troubleshooting', 1)
    ->enablePageNumbers()
    ->download('user-manual.pdf');
```

## 📚 Real-World Usage Examples

### 1. **Employee Report Card**

```php
// Perfect for HR reports with multiple pages
$html = view('reports.employee-card', [
    'employee' => $employee,
    'performance' => $performanceData,
    'goals' => $goals
])->render();

return SimPdf::loadHtml($html)
    ->setPaper('A4', 'portrait')
    ->enablePageNumbers(['position' => 'bottom-center'])
    ->setHeader('Employee Performance Report')
    ->setFooter('Confidential - HR Department')
    ->addWatermark('CONFIDENTIAL', ['opacity' => 0.1])
    ->download('employee-report-' . $employee->id . '.pdf');
```

### 2. **Product Catalog**

```php
// Perfect for e-commerce catalogs
$html = view('catalog.products', [
    'products' => $products,
    'categories' => $categories
])->render();

return SimPdf::loadHtml($html)
    ->setPaper('A4', 'portrait')
    ->breakTable(['repeat_header' => true, 'min_rows' => 3])
    ->setHeader('Product Catalog 2024')
    ->setFooter('Visit our website for more products')
    ->addBookmark('Electronics', 1)
    ->addBookmark('Clothing', 1)
    ->addBookmark('Home & Garden', 1)
    ->download('product-catalog.pdf');
```

### 3. **Financial Statement**

```php
// Perfect for financial documents
$html = view('financial.statement', [
    'revenue' => $revenueData,
    'expenses' => $expensesData,
    'balance' => $balanceSheet
])->render();

return SimPdf::loadHtml($html)
    ->setPaper('A4', 'landscape')
    ->breakTable(['repeat_header' => true])
    ->setHeader('Financial Statement - Q' . $quarter . ' ' . $year)
    ->setFooter('Prepared by: ' . auth()->user()->name)
    ->addWatermark('DRAFT', ['opacity' => 0.3, 'color' => '#ff0000'])
    ->setMetadata([
        'Title' => 'Financial Statement',
        'Author' => auth()->user()->name,
        'Subject' => 'Quarterly Financial Report'
    ])
    ->download('financial-statement-q' . $quarter . '.pdf');
```

### 4. **Contract Document**

```php
// Perfect for legal documents
$html = view('contracts.agreement', [
    'contract' => $contract,
    'parties' => $parties,
    'terms' => $terms
])->render();

return SimPdf::loadHtml($html)
    ->setPaper('A4', 'portrait')
    ->addPageBreak('page', ['before' => '.contract-section'])
    ->setHeader('Service Agreement - ' . $contract->number)
    ->setFooter('Page {PAGE_NUM} of {PAGE_COUNT} - Legal Document')
    ->addBookmark('Parties', 1)
    ->addBookmark('Terms & Conditions', 1)
    ->addBookmark('Payment Terms', 1)
    ->addBookmark('Signatures', 1)
    ->download('contract-' . $contract->number . '.pdf');
```

## 📚 Advanced Usage

### Multi-page PDF with Headers and Footers

```php
$html = '
<!DOCTYPE html>
<html>
<head><title>Multi-page Document</title></head>
<body>
    <h1>Page 1</h1>
    <p>Content for page 1...</p>

    <div class="page-break"></div>

    <h1>Page 2</h1>
    <p>Content for page 2...</p>
</body>
</html>';

SimPdf::loadHtml($html)
    ->setPaper('A4', 'portrait')
    ->enablePageNumbers([
        'position' => 'bottom-right',
        'format' => 'Page {PAGE_NUM} of {PAGE_COUNT}'
    ])
    ->setHeader('<h3>Company Header</h3>', [
        'height' => '60px',
        'background' => '#f8f9fa'
    ])
    ->setFooter('<p>© 2024 Company Name</p>', [
        'height' => '40px',
        'background' => '#f8f9fa'
    ])
    ->download('multi-page-document.pdf');
```

### Advanced Table with Custom Breaks

```php
$html = '
<table class="breakable-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Department</th>
        </tr>
    </thead>
    <tbody>
        <!-- Large table data -->
    </tbody>
</table>';

SimPdf::loadHtml($html)
    ->setPaper('A4', 'portrait')
    ->breakTable([
        'repeat_header' => true,
        'min_rows' => 5,
        'max_rows' => 20
    ])
    ->addStyle('
        .breakable-table {
            page-break-inside: auto;
        }
        .breakable-table thead {
            display: table-header-group;
        }
        .breakable-table tbody {
            page-break-inside: avoid;
        }
    ')
    ->download('table-document.pdf');
```

## Advanced Features

### Custom Page Breaks

```php
// Break before specific element
SimPdf::loadHtml($html)
    ->addPageBreak('page', ['before' => '<h2>New Section</h2>'])
    ->download('document.pdf');

// Break after specific element
SimPdf::loadHtml($html)
    ->addPageBreak('page', ['after' => '<div class="section-end"></div>'])
    ->download('document.pdf');

// Avoid breaking inside elements
SimPdf::loadHtml($html)
    ->addPageBreak('avoid', ['element' => '.no-break'])
    ->download('document.pdf');
```

### Watermarks and Bookmarks

```php
SimPdf::loadHtml($html)
    ->addWatermark('CONFIDENTIAL', [
        'opacity' => 0.3,
        'font-size' => '48px',
        'color' => '#ff0000',
        'rotation' => -45
    ])
    ->addBookmark('Introduction', 1)
    ->addBookmark('Details', 1)
    ->addBookmark('Summary', 1)
    ->download('document.pdf');
```

### Metadata and Styling

```php
SimPdf::loadHtml($html)
    ->setMetadata([
        'Title' => 'My Document',
        'Author' => 'John Doe',
        'Subject' => 'Important Document',
        'Keywords' => 'PDF, Laravel, Document'
    ])
    ->addStyle('
        body { font-family: Arial, sans-serif; }
        h1 { color: #2c3e50; }
        .highlight { background-color: #ffff00; }
    ')
    ->download('document.pdf');
```

## Configuration

The package comes with a comprehensive configuration file at `config/simpdf.php`. You can customize:

- Default paper size and orientation
- Font settings and caching
- Page break behavior
- Header and footer defaults
- Page numbering format
- Watermark settings
- Performance options
- Security settings

## Laravel Integration

### Controller Example

```php
<?php

namespace App\Http\Controllers;

use SimPdf\SimPdfLibs\Facades\SimPdf;

class PdfController extends Controller
{
    public function generateReport()
    {
        $html = view('pdf.report', [
            'data' => $this->getReportData()
        ])->render();

        return SimPdf::loadHtml($html)
            ->setPaper('A4', 'portrait')
            ->enablePageNumbers()
            ->setHeader('Report Header')
            ->setFooter('Report Footer')
            ->download('report.pdf');
    }
}
```

### Blade Template

```blade
<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <style>
        .page-break { page-break-before: always; }
        .no-break { page-break-inside: avoid; }
    </style>
</head>
<body>
    <h1>Report Title</h1>

    @foreach($data as $section)
        <div class="section">
            <h2>{{ $section['title'] }}</h2>
            <p>{{ $section['content'] }}</p>
        </div>

        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
```

## API Reference

### Main Methods

- `loadHtml(string $html)` - Load HTML content
- `setPaper(string $paper, string $orientation)` - Set paper size and orientation
- `setOptions(array $options)` - Set PDF generation options
- `addPageBreak(string $type, array $options)` - Add custom page breaks
- `setHeader(string $content, array $options)` - Set header content
- `setFooter(string $content, array $options)` - Set footer content
- `enablePageNumbers(array $options)` - Enable page numbering
- `addStyle(string $css)` - Add custom CSS
- `addWatermark(string $text, array $options)` - Add watermark
- `addBookmark(string $title, int $level)` - Add bookmark
- `setMetadata(array $metadata)` - Set PDF metadata
- `breakTable(array $options)` - Configure table breaking
- `breakRow(array $options)` - Configure row breaking

### Output Methods

- `output()` - Get PDF as string
- `save(string $path)` - Save PDF to file
- `download(string $filename)` - Download PDF
- `stream()` - Stream PDF to browser

## ⚡ Performance & Best Practices

### 🚀 **Performance Tips:**

#### 1. **Large Documents**

```php
// For documents with 100+ pages
SimPdf::loadHtml($html)
    ->setOptions([
        'enable_css_float' => false,  // Disable for better performance
        'enable_html5_parser' => true,
        'dpi' => 72,  // Lower DPI for faster rendering
        'isFontSubsettingEnabled' => true  // Reduce font file size
    ])
    ->download('large-document.pdf');
```

#### 2. **Memory Management**

```php
// For memory-intensive operations
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 300);

SimPdf::loadHtml($html)
    ->setOptions(['isPhpEnabled' => false])  // Disable PHP for security
    ->download('document.pdf');
```

#### 3. **Caching Styles**

```php
// Cache frequently used styles
$commonStyles = '
    .header { font-size: 14px; font-weight: bold; }
    .footer { font-size: 10px; color: #666; }
    .page-break { page-break-before: always; }
';

SimPdf::loadHtml($html)
    ->addStyle($commonStyles)
    ->download('document.pdf');
```

### 🎯 **Best Practices:**

#### 1. **Use Blade Templates**

```php
// ✅ Good: Use Blade templates
$html = view('pdf.report', compact('data'))->render();

// ❌ Avoid: Inline HTML in controllers
$html = '<html><body><h1>Report</h1>...</body></html>';
```

#### 2. **Optimize Images**

```php
// ✅ Good: Optimize images before PDF generation
$html = '<img src="' . asset('images/optimized-logo.png') . '" width="200">';

// ❌ Avoid: Large unoptimized images
$html = '<img src="' . asset('images/huge-logo.jpg') . '">';
```

#### 3. **Use CSS Classes for Page Breaks**

```php
// ✅ Good: Use CSS classes
$html = '<div class="page-break"></div>';

// ❌ Avoid: Inline styles
$html = '<div style="page-break-before: always;"></div>';
```

#### 4. **Handle Errors Gracefully**

```php
try {
    return SimPdf::loadHtml($html)->download('document.pdf');
} catch (Exception $e) {
    Log::error('PDF Generation Failed: ' . $e->getMessage());
    return redirect()->back()->with('error', 'Failed to generate PDF');
}
```

### 📊 **Performance Benchmarks:**

| Document Type   | Pages | Size    | Generation Time |
| --------------- | ----- | ------- | --------------- |
| Simple Report   | 1-5   | < 1MB   | < 2 seconds     |
| Business Report | 10-20 | 2-5MB   | 3-8 seconds     |
| Large Manual    | 50+   | 10-20MB | 15-30 seconds   |
| Data Export     | 100+  | 50MB+   | 30-60 seconds   |

## Requirements

- **PHP 8.1 or higher** (recommended PHP 8.2+)
- **Laravel 9.0 or higher** (supports Laravel 12.0)
- **DomPDF 3.0.1 or higher** (latest stable)
- **Intervention Image 3.11.4 or higher** (for image processing)

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🐛 Troubleshooting

### Common Issues & Solutions:

#### 1. **Memory Limit Exceeded**

```php
// Solution: Increase memory limit
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 300);
```

#### 2. **Font Not Found**

```php
// Solution: Use web-safe fonts or install custom fonts
SimPdf::loadHtml($html)
    ->addStyle('body { font-family: Arial, sans-serif; }')
    ->download('document.pdf');
```

#### 3. **Images Not Displaying**

```php
// Solution: Use absolute URLs for images
$html = '<img src="' . asset('images/logo.png') . '" alt="Logo">';
```

#### 4. **Page Breaks Not Working**

```php
// Solution: Use proper CSS classes
$html = '<div class="page-break"></div>';

// Add CSS
SimPdf::loadHtml($html)
    ->addStyle('.page-break { page-break-before: always; }')
    ->download('document.pdf');
```

#### 5. **Table Breaking Issues**

```php
// Solution: Configure table breaking
SimPdf::loadHtml($html)
    ->breakTable([
        'repeat_header' => true,
        'min_rows' => 5,
        'max_rows' => 20
    ])
    ->download('document.pdf');
```

### 🔧 **Debug Mode:**

```php
// Enable debug mode for troubleshooting
SimPdf::loadHtml($html)
    ->setOptions([
        'debugPng' => true,
        'debugKeepTemp' => true,
        'debugCss' => true
    ])
    ->download('document.pdf');
```

## 📞 Support

- **GitHub Issues:** [Report bugs or request features](https://github.com/5u00n/sim-pdf-libs/issues)
- **Documentation:** [Full documentation](https://github.com/5u00n/sim-pdf-libs)
- **Examples:** Check the `examples/` directory for more usage examples

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

### Development Setup:

```bash
# Clone the repository
git clone https://github.com/5u00n/sim-pdf-libs.git
cd sim-pdf-libs

# Install dependencies
composer install

# Run tests
php run-tests.php
```

## 📄 License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

**Made with ❤️ for the Laravel community**
