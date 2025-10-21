# SimPDF Library - Installation Guide

## 🚀 Quick Installation

### Packagist Installation (Recommended)

```bash
composer require sim-pdf/sim-pdf-libs
```

### Git Installation

```bash
composer config repositories.sim-pdf vcs https://github.com/5u00n/sim-pdf-libs
composer require sim-pdf/sim-pdf-libs:dev-main
```

## ⚙️ Laravel Configuration

### Laravel 11+ (Auto-discovery)

The package will be automatically discovered and registered.

### Laravel 9-10 (Manual)

Add to `config/app.php`:

```php
'providers' => [
    // ...
    SimPdf\SimPdfLibs\SimPdfServiceProvider::class,
],

'aliases' => [
    // ...
    'SimPdf' => SimPdf\SimPdfLibs\Facades\SimPdf::class,
],
```

## 🎯 Quick Usage

```php
use SimPdf\SimPdfLibs\Facades\SimPdf;

$html = '<h1>Hello World</h1><p>This is a PDF!</p>';
return SimPdf::loadHtml($html)->download('document.pdf');
```

## 📚 Features

- Multi-page documents with custom page breaks
- Headers and footers
- Page numbering
- Table pagination
- Watermarks and bookmarks
- Advanced CSS styling
- PDF metadata

## 🧪 Testing

```bash
php run-tests.php
```

## 📖 Documentation

See [README.md](README.md) for complete documentation and examples.

## 🆘 Support

- **GitHub Issues:** https://github.com/5u00n/sim-pdf-libs/issues
- **Documentation:** https://github.com/5u00n/sim-pdf-libs
