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

## Installation

1. Install the package via Composer:

```bash
composer require sim-pdf/sim-pdf-libs
```

2. Publish the configuration file:

```bash
php artisan vendor:publish --provider="SimPdf\SimPdfLibs\SimPdfServiceProvider" --tag="config"
```

3. Publish the views (optional):

```bash
php artisan vendor:publish --provider="SimPdf\SimPdfLibs\SimPdfServiceProvider" --tag="views"
```

## Basic Usage

### Simple PDF Generation

```php
use SimPdf\SimPdfLibs\Facades\SimPdf;

$html = '<h1>Hello World</h1><p>This is a simple PDF.</p>';

SimPdf::loadHtml($html)
    ->setPaper('A4', 'portrait')
    ->download('document.pdf');
```

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

## Requirements

- PHP 8.0 or higher
- Laravel 9.0 or higher
- DomPDF 2.0 or higher

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support, please open an issue on GitHub or contact us at support@simpdf.com.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.
