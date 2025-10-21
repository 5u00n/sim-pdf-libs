# SimPDF Library - Super Easy Installation

## 🚀 One-Command Installation

Just download and run one file - that's it!

```bash
# Download the installer
curl -O https://raw.githubusercontent.com/5u00n/sim-pdf-libs/main/install-simpdf.php

# Run it (from your Laravel project root)
php install-simpdf.php
```

**That's it!** The installer will:

- ✅ Install SimPDF library
- ✅ Configure Laravel automatically
- ✅ Create example files
- ✅ Test the installation
- ✅ Show you how to use it

## 🎯 After Installation

### Test it works:

Visit: `http://your-app.test/simpdf/test`

### Use in your code:

```php
use SimPdf\SimPdfLibs\Facades\SimPdf;

// Generate PDF
return SimPdf::loadHtml($html)->download('document.pdf');
```

### Advanced features:

```php
return SimPdf::loadHtml($html)
    ->enablePageNumbers()
    ->setHeader('My Header')
    ->setFooter('My Footer')
    ->addWatermark('DRAFT')
    ->download('document.pdf');
```

## 📚 What You Get

- 🚀 **Multi-page Support** - Handle large documents
- 📄 **Custom Page Breaks** - Break pages anywhere
- 📊 **Table Pagination** - Smart table breaking
- 🔢 **Page Numbering** - Automatic page numbers
- 📋 **Headers & Footers** - Custom headers/footers
- 🎨 **Advanced Styling** - Full CSS support
- 💧 **Watermarks** - Add watermarks
- 🔖 **Bookmarks** - PDF navigation
- 📝 **Metadata** - PDF metadata

## 🆘 Need Help?

- **Documentation:** https://github.com/5u00n/sim-pdf-libs
- **Issues:** https://github.com/5u00n/sim-pdf-libs/issues
- **Examples:** Check `app/Http/Controllers/SimPdfController.php`

## 🎉 That's It!

No complex configuration, no multiple steps - just one command and you're ready to generate amazing PDFs!
