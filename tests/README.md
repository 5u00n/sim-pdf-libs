# SimPDF Library - Tests

## 🧪 Test Files

This directory contains the essential test files for SimPDF library:

### **tests/basic-test.php**
- Tests basic PDF generation
- Tests page numbers
- Tests headers and footers
- Verifies core functionality

### **tests/advanced-test.php**
- Tests individual services (PageBreakService, HeaderFooterService, StylingService)
- Tests comprehensive PDF generation
- Tests advanced features like watermarks and bookmarks
- Verifies all components work together

### **tests/comprehensive-test.php**
- Tests the complete library functionality
- Tests all features in one comprehensive test
- Verifies production readiness
- Tests performance with large documents

## 🚀 Running Tests

### Run All Tests
```bash
php run-tests.php
```

### Run Individual Tests
```bash
# Basic functionality test
php tests/basic-test.php

# Advanced features test
php tests/advanced-test.php

# Comprehensive test
php tests/comprehensive-test.php
```

## ✅ What Tests Verify

- ✅ HTML to PDF conversion
- ✅ Multi-page document support
- ✅ Custom page breaks
- ✅ Table pagination
- ✅ Page numbering
- ✅ Headers and footers
- ✅ Advanced CSS styling
- ✅ Watermarks
- ✅ Bookmarks
- ✅ PDF metadata
- ✅ Laravel integration
- ✅ Performance with large documents

## 📊 Test Results

All tests should pass to ensure SimPDF library is working correctly. The tests verify:

1. **Core Functionality** - Basic PDF generation works
2. **Advanced Features** - All advanced features work correctly
3. **Integration** - Laravel integration works properly
4. **Performance** - Library handles large documents efficiently

## 🐛 Troubleshooting

If tests fail:
1. Check that all dependencies are installed
2. Verify PHP version is 8.0+
3. Ensure DomPDF is working
4. Check memory limits for large document tests

## 📚 Documentation

For more information, visit: https://github.com/5u00n/sim-pdf-libs
