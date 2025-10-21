# SimPDF Library - Quick Start

## 🚀 Super Easy Installation

### Method 1: One-Command Installer (Recommended)

```bash
# Download and run installer
curl -O https://raw.githubusercontent.com/5u00n/sim-pdf-libs/main/install-simpdf.php && php install-simpdf.php
```

### Method 2: Composer (If published to Packagist)

```bash
composer require sim-pdf/sim-pdf-libs
```

### Method 3: Git Repository

```bash
composer config repositories.sim-pdf vcs https://github.com/5u00n/sim-pdf-libs
composer require sim-pdf/sim-pdf-libs:dev-main
```

## 🎯 Usage (3 Lines of Code!)

```php
use SimPdf\SimPdfLibs\Facades\SimPdf;

$html = '<h1>Hello World</h1><p>This is a PDF!</p>';
return SimPdf::loadHtml($html)->download('document.pdf');
```

## 🎨 Advanced Usage

```php
return SimPdf::loadHtml($html)
    ->setPaper('A4', 'portrait')
    ->enablePageNumbers()
    ->setHeader('<h3>My Header</h3>')
    ->setFooter('<p>Page {PAGE_NUM}</p>')
    ->addWatermark('DRAFT')
    ->download('document.pdf');
```

## 🧪 Test Installation

After installation, visit: `http://your-app.test/simpdf/test`

## 📚 Features

- ✅ Multi-page documents
- ✅ Custom page breaks
- ✅ Table pagination
- ✅ Page numbering
- ✅ Headers & footers
- ✅ Advanced CSS styling
- ✅ Watermarks
- ✅ Bookmarks
- ✅ PDF metadata

## 🆘 Help

- **GitHub:** https://github.com/5u00n/sim-pdf-libs
- **Issues:** https://github.com/5u00n/sim-pdf-libs/issues

That's it! No complex setup needed! 🎉
