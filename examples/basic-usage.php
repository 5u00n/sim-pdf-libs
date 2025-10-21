<?php

require_once __DIR__ . '/../vendor/autoload.php';

use SimPdf\SimPdfLibs\Facades\SimPdf;

// Basic PDF generation
$html = '
<!DOCTYPE html>
<html>
<head>
    <title>Basic PDF Example</title>
</head>
<body>
    <h1>Welcome to SimPDF</h1>
    <p>This is a basic example of PDF generation with SimPDF library.</p>
    
    <h2>Features</h2>
    <ul>
        <li>Multi-page support</li>
        <li>Custom page breaks</li>
        <li>Headers and footers</li>
        <li>Page numbering</li>
        <li>Advanced styling</li>
    </ul>
    
    <h2>Table Example</h2>
    <table border="1" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>John Doe</td>
                <td>john@example.com</td>
                <td>123-456-7890</td>
            </tr>
            <tr>
                <td>Jane Smith</td>
                <td>jane@example.com</td>
                <td>098-765-4321</td>
            </tr>
        </tbody>
    </table>
</body>
</html>';

// Generate PDF
SimPdf::loadHtml($html)
    ->setPaper('A4', 'portrait')
    ->enablePageNumbers([
        'position' => 'bottom-right',
        'format' => 'Page {PAGE_NUM} of {PAGE_COUNT}'
    ])
    ->setHeader('<h3>Company Header</h3>', [
        'height' => '60px',
        'background' => '#f8f9fa',
        'text-align' => 'center'
    ])
    ->setFooter('<p>© 2024 Company Name. All rights reserved.</p>', [
        'height' => '40px',
        'background' => '#f8f9fa',
        'text-align' => 'center'
    ])
    ->addStyle('
        body { font-family: Arial, sans-serif; }
        h1 { color: #2c3e50; }
        h2 { color: #34495e; }
        table { margin: 20px 0; }
        th { background-color: #3498db; color: white; }
    ')
    ->download('basic-example.pdf');
