# SimPDF Library - Quick Reference

## 🚀 Installation

```bash
composer require sim-pdf/sim-pdf-libs
```

## 🎯 Basic Usage

```php
use SimPdf\SimPdfLibs\Facades\SimPdf;

// Basic PDF
return SimPdf::loadHtml($html)->download('document.pdf');

// With options
return SimPdf::loadHtml($html)
    ->setPaper('A4', 'portrait')
    ->enablePageNumbers()
    ->setHeader('Header')
    ->setFooter('Footer')
    ->download('document.pdf');
```

## 📄 Page Breaks

```php
// CSS class
$html = '<div class="page-break"></div>';

// Add CSS
SimPdf::loadHtml($html)
    ->addStyle('.page-break { page-break-before: always; }')
    ->download('document.pdf');
```

## 📊 Table Breaking

```php
SimPdf::loadHtml($html)
    ->breakTable([
        'repeat_header' => true,
        'min_rows' => 5,
        'max_rows' => 20
    ])
    ->download('document.pdf');
```

## 🔢 Page Numbers

```php
SimPdf::loadHtml($html)
    ->enablePageNumbers([
        'position' => 'bottom-right',
        'format' => 'Page {PAGE_NUM} of {PAGE_COUNT}'
    ])
    ->download('document.pdf');
```

## 📋 Headers & Footers

```php
SimPdf::loadHtml($html)
    ->setHeader('<h3>Company Header</h3>', [
        'height' => '60px',
        'background' => '#f8f9fa'
    ])
    ->setFooter('<p>© 2024 Company</p>', [
        'height' => '40px'
    ])
    ->download('document.pdf');
```

## 💧 Watermarks

```php
SimPdf::loadHtml($html)
    ->addWatermark('DRAFT', [
        'opacity' => 0.3,
        'font-size' => '48px',
        'color' => '#ff0000',
        'rotation' => -45
    ])
    ->download('document.pdf');
```

## 🔖 Bookmarks

```php
SimPdf::loadHtml($html)
    ->addBookmark('Introduction', 1)
    ->addBookmark('Details', 1)
    ->addBookmark('Summary', 1)
    ->download('document.pdf');
```

## 🎨 Styling

```php
SimPdf::loadHtml($html)
    ->addStyle('
        body { font-family: Arial, sans-serif; }
        h1 { color: #2c3e50; }
        .highlight { background-color: #ffff00; }
    ')
    ->download('document.pdf');
```

## 📝 Metadata

```php
SimPdf::loadHtml($html)
    ->setMetadata([
        'Title' => 'My Document',
        'Author' => 'John Doe',
        'Subject' => 'Important Document',
        'Keywords' => 'PDF, Laravel, Document'
    ])
    ->download('document.pdf');
```

## ⚡ Performance

```php
// Large documents
SimPdf::loadHtml($html)
    ->setOptions([
        'enable_css_float' => false,
        'dpi' => 72,
        'isFontSubsettingEnabled' => true
    ])
    ->download('document.pdf');
```

## 🐛 Common Issues

### Memory Limit

```php
ini_set('memory_limit', '512M');
```

### Images Not Showing

```php
$html = '<img src="' . asset('images/logo.png') . '">';
```

### Font Issues

```php
SimPdf::loadHtml($html)
    ->addStyle('body { font-family: Arial, sans-serif; }')
    ->download('document.pdf');
```

## 📚 Output Methods

```php
// Download
->download('filename.pdf')

// Save to file
->save('/path/to/file.pdf')

// Get as string
->output()

// Stream to browser
->stream()
```

## 🎯 When to Use

✅ **Perfect For:**

- Business reports & invoices
- Contracts & legal documents
- User manuals & guides
- Data reports with tables
- Styled documents
- Forms & applications

❌ **Not Ideal For:**

- Image-heavy PDFs
- Interactive PDFs
- Video/Audio PDFs
- Complex charts

## 📞 Support

- **GitHub:** https://github.com/5u00n/sim-pdf-libs
- **Issues:** https://github.com/5u00n/sim-pdf-libs/issues
