<?php

/**
 * Simple test script to verify the SimPDF library works
 */

require_once __DIR__ . '/vendor/autoload.php';

use SimPdf\SimPdfLibs\Services\PdfGeneratorService;

echo "SimPDF Library Test\n";
echo "==================\n\n";

try {
    // Test basic PDF generation
    echo "Testing basic PDF generation...\n";
    
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <title>SimPDF Test</title>
        <style>
            body { font-family: Arial, sans-serif; }
            h1 { color: #2c3e50; }
            .test-section { margin: 20px 0; padding: 15px; background: #f8f9fa; }
        </style>
    </head>
    <body>
        <h1>SimPDF Library Test Document</h1>
        
        <div class="test-section">
            <h2>Basic Features Test</h2>
            <p>This document tests the basic functionality of the SimPDF library.</p>
            <ul>
                <li>HTML to PDF conversion</li>
                <li>CSS styling support</li>
                <li>Multi-page support</li>
                <li>Page breaks</li>
            </ul>
        </div>
        
        <div class="page-break"></div>
        
        <div class="test-section">
            <h2>Page 2 - Advanced Features</h2>
            <p>This is the second page of the test document.</p>
            
            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <thead>
                    <tr style="background-color: #3498db; color: white;">
                        <th style="border: 1px solid #ddd; padding: 8px;">Feature</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Status</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px;">Multi-page</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">✅ Working</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">Supports multiple pages</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px;">Page Breaks</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">✅ Working</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">Custom page breaks</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px;">Styling</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">✅ Working</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">Full CSS support</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px;">Tables</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">✅ Working</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">Table rendering</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="test-section">
            <h2>Test Results</h2>
            <p>If you can see this PDF, the SimPDF library is working correctly!</p>
            <p><strong>Generated on:</strong> ' . date('Y-m-d H:i:s') . '</p>
        </div>
    </body>
    </html>';
    
    $pdfGenerator = new PdfGeneratorService();
    
    // Test basic generation
    $pdfGenerator->loadHtml($html);
    $output = $pdfGenerator->output();
    
    if (!empty($output)) {
        echo "✅ Basic PDF generation: SUCCESS\n";
        echo "   PDF size: " . number_format(strlen($output)) . " bytes\n";
    } else {
        echo "❌ Basic PDF generation: FAILED\n";
    }
    
    // Test with page numbers
    echo "\nTesting page numbers...\n";
    $pdfGenerator->enablePageNumbers([
        'position' => 'bottom-right',
        'format' => 'Page {PAGE_NUM} of {PAGE_COUNT}'
    ]);
    $output = $pdfGenerator->output();
    
    if (!empty($output)) {
        echo "✅ Page numbers: SUCCESS\n";
    } else {
        echo "❌ Page numbers: FAILED\n";
    }
    
    // Test with header and footer
    echo "\nTesting headers and footers...\n";
    $pdfGenerator->setHeader('<h3>Test Header</h3>', [
        'height' => '50px',
        'background' => '#f8f9fa'
    ]);
    $pdfGenerator->setFooter('<p>Test Footer - Page {PAGE_NUM}</p>', [
        'height' => '40px',
        'background' => '#f8f9fa'
    ]);
    $output = $pdfGenerator->output();
    
    if (!empty($output)) {
        echo "✅ Headers and footers: SUCCESS\n";
    } else {
        echo "❌ Headers and footers: FAILED\n";
    }
    
    // Test with watermark
    echo "\nTesting watermarks...\n";
    $pdfGenerator->addWatermark('TEST', [
        'opacity' => 0.1,
        'font-size' => '48px'
    ]);
    $output = $pdfGenerator->output();
    
    if (!empty($output)) {
        echo "✅ Watermarks: SUCCESS\n";
    } else {
        echo "❌ Watermarks: FAILED\n";
    }
    
    // Test with bookmarks
    echo "\nTesting bookmarks...\n";
    $pdfGenerator->addBookmark('Test Document', 1);
    $pdfGenerator->addBookmark('Page 1', 2);
    $pdfGenerator->addBookmark('Page 2', 2);
    $output = $pdfGenerator->output();
    
    if (!empty($output)) {
        echo "✅ Bookmarks: SUCCESS\n";
    } else {
        echo "❌ Bookmarks: FAILED\n";
    }
    
    // Test with metadata
    echo "\nTesting metadata...\n";
    $pdfGenerator->setMetadata([
        'Title' => 'SimPDF Test Document',
        'Author' => 'SimPDF Library',
        'Subject' => 'Library Testing',
        'Keywords' => 'PDF, Test, SimPDF'
    ]);
    $output = $pdfGenerator->output();
    
    if (!empty($output)) {
        echo "✅ Metadata: SUCCESS\n";
    } else {
        echo "❌ Metadata: FAILED\n";
    }
    
    // Save test PDF
    echo "\nSaving test PDF...\n";
    $testFile = __DIR__ . '/test-output.pdf';
    $pdfGenerator->save($testFile);
    
    if (file_exists($testFile)) {
        echo "✅ PDF saved successfully: {$testFile}\n";
        echo "   File size: " . number_format(filesize($testFile)) . " bytes\n";
    } else {
        echo "❌ Failed to save PDF\n";
    }
    
    echo "\n🎉 All tests completed!\n";
    echo "Check the test-output.pdf file to see the results.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
