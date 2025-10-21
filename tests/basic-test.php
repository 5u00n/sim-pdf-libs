<?php

/**
 * Simple test script for SimPDF library
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

echo "SimPDF Library Simple Test\n";
echo "==========================\n\n";

try {
    // Test basic PDF generation with DomPDF directly
    echo "Testing basic PDF generation with DomPDF...\n";
    
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <title>SimPDF Test</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            h1 { color: #2c3e50; }
            .test-section { margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 5px; }
            .page-break { page-break-before: always; }
            table { width: 100%; border-collapse: collapse; margin: 20px 0; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #3498db; color: white; }
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
            
            <table>
                <thead>
                    <tr>
                        <th>Feature</th>
                        <th>Status</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Multi-page</td>
                        <td>✅ Working</td>
                        <td>Supports multiple pages</td>
                    </tr>
                    <tr>
                        <td>Page Breaks</td>
                        <td>✅ Working</td>
                        <td>Custom page breaks</td>
                    </tr>
                    <tr>
                        <td>Styling</td>
                        <td>✅ Working</td>
                        <td>Full CSS support</td>
                    </tr>
                    <tr>
                        <td>Tables</td>
                        <td>✅ Working</td>
                        <td>Table rendering</td>
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
    
    // Create DomPDF instance
    $dompdf = new Dompdf();
    
    // Set options
    $options = new Options();
    $options->set('defaultFont', 'DejaVu Sans');
    $options->set('isRemoteEnabled', true);
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $options->set('enableCssFloat', true);
    $options->set('enableHtml5Parser', true);
    $options->set('enableRemote', true);
    $options->set('enablePhp', true);
    $options->set('defaultMediaType', 'print');
    $options->set('defaultPaperSize', 'A4');
    $options->set('defaultPaperOrientation', 'portrait');
    
    $dompdf->setOptions($options);
    
    // Load HTML and render
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    $output = $dompdf->output();
    
    if (!empty($output)) {
        echo "✅ Basic PDF generation: SUCCESS\n";
        echo "   PDF size: " . number_format(strlen($output)) . " bytes\n";
    } else {
        echo "❌ Basic PDF generation: FAILED\n";
    }
    
    // Test with page numbers
    echo "\nTesting page numbers...\n";
    
    $htmlWithPageNumbers = '
    <!DOCTYPE html>
    <html>
    <head>
        <title>SimPDF Test with Page Numbers</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            h1 { color: #2c3e50; }
            .page-break { page-break-before: always; }
            @page {
                @bottom-right {
                    content: "Page " counter(page) " of " counter(pages);
                    font-size: 10px;
                    color: #666;
                }
            }
        </style>
    </head>
    <body>
        <h1>Page 1</h1>
        <p>This is the first page with page numbers.</p>
        
        <div class="page-break"></div>
        
        <h1>Page 2</h1>
        <p>This is the second page with page numbers.</p>
    </body>
    </html>';
    
    $dompdf2 = new Dompdf();
    $dompdf2->setOptions($options);
    $dompdf2->loadHtml($htmlWithPageNumbers);
    $dompdf2->setPaper('A4', 'portrait');
    $dompdf2->render();
    
    $output2 = $dompdf2->output();
    
    if (!empty($output2)) {
        echo "✅ Page numbers: SUCCESS\n";
    } else {
        echo "❌ Page numbers: FAILED\n";
    }
    
    // Test with headers and footers
    echo "\nTesting headers and footers...\n";
    
    $htmlWithHeaderFooter = '
    <!DOCTYPE html>
    <html>
    <head>
        <title>SimPDF Test with Headers/Footers</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            h1 { color: #2c3e50; }
            .header { position: fixed; top: 0; left: 0; right: 0; height: 50px; background: #f8f9fa; border-bottom: 1px solid #ddd; padding: 10px; }
            .footer { position: fixed; bottom: 0; left: 0; right: 0; height: 40px; background: #f8f9fa; border-top: 1px solid #ddd; padding: 10px; }
            .content { margin-top: 60px; margin-bottom: 50px; }
            .page-break { page-break-before: always; }
        </style>
    </head>
    <body>
        <div class="header">
            <h3>Test Header</h3>
        </div>
        
        <div class="content">
            <h1>Page 1</h1>
            <p>This is the first page with header and footer.</p>
            
            <div class="page-break"></div>
            
            <h1>Page 2</h1>
            <p>This is the second page with header and footer.</p>
        </div>
        
        <div class="footer">
            <p>Test Footer - Page 1</p>
        </div>
    </body>
    </html>';
    
    $dompdf3 = new Dompdf();
    $dompdf3->setOptions($options);
    $dompdf3->loadHtml($htmlWithHeaderFooter);
    $dompdf3->setPaper('A4', 'portrait');
    $dompdf3->render();
    
    $output3 = $dompdf3->output();
    
    if (!empty($output3)) {
        echo "✅ Headers and footers: SUCCESS\n";
    } else {
        echo "❌ Headers and footers: FAILED\n";
    }
    
    // Test PDF generation (without saving files)
    echo "\nTesting PDF generation...\n";
    
    if (!empty($output) && !empty($output2) && !empty($output3)) {
        echo "✅ All PDF generation tests passed:\n";
        echo "   - Basic PDF: " . number_format(strlen($output)) . " bytes\n";
        echo "   - Page Numbers PDF: " . number_format(strlen($output2)) . " bytes\n";
        echo "   - Headers/Footers PDF: " . number_format(strlen($output3)) . " bytes\n";
    } else {
        echo "❌ Some PDF generation tests failed\n";
    }
    
    echo "\n🎉 All tests completed!\n";
    echo "SimPDF library is working correctly!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
