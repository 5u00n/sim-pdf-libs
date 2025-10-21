<?php

require_once __DIR__ . '/../vendor/autoload.php';

use SimPdf\SimPdfLibs\Facades\SimPdf;

// Advanced PDF generation with multi-page support
$html = '
<!DOCTYPE html>
<html>
<head>
    <title>Advanced PDF Example</title>
</head>
<body>
    <h1>Advanced PDF Generation</h1>
    <p>This example demonstrates advanced features of SimPDF library.</p>
    
    <!-- Page break example -->
    <div class="page-break"></div>
    
    <h2>Page 2 - Table with Custom Breaks</h2>
    <p>This table will break across pages with proper headers.</p>
    
    <table class="breakable-table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #3498db; color: white;">
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Salary</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>';

// Generate large table data
for ($i = 1; $i <= 100; $i++) {
    $html .= "
            <tr>
                <td>{$i}</td>
                <td>Employee {$i}</td>
                <td>employee{$i}@company.com</td>
                <td>Department " . ($i % 5 + 1) . "</td>
                <td>$" . number_format(rand(30000, 100000)) . "</td>
                <td>" . (rand(0, 1) ? 'Active' : 'Inactive') . "</td>
            </tr>";
}

$html .= '
        </tbody>
    </table>
    
    <!-- Another page break -->
    <div class="page-break"></div>
    
    <h2>Page 3 - Styled Content</h2>
    <div class="styled-content">
        <h3>Company Information</h3>
        <p>This is a styled section with custom formatting.</p>
        
        <div class="highlight-box">
            <h4>Important Notice</h4>
            <p>This is an important notice that should stand out.</p>
        </div>
        
        <h3>Contact Information</h3>
        <ul>
            <li>Email: info@company.com</li>
            <li>Phone: (555) 123-4567</li>
            <li>Address: 123 Business St, City, State 12345</li>
        </ul>
    </div>
</body>
</html>';

// Generate advanced PDF
SimPdf::loadHtml($html)
    ->setPaper('A4', 'portrait')
    ->enablePageNumbers([
        'position' => 'bottom-center',
        'format' => 'Page {PAGE_NUM} of {PAGE_COUNT}',
        'font-size' => '12px',
        'color' => '#666666'
    ])
    ->setHeader('
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h3>Company Report</h3>
            <span>Generated on: ' . date('Y-m-d H:i:s') . '</span>
        </div>
    ', [
        'height' => '70px',
        'background' => '#2c3e50',
        'color' => 'white',
        'padding' => '15px',
        'text-align' => 'left'
    ])
    ->setFooter('
        <div style="text-align: center; font-size: 10px;">
            <p>Confidential Document - For Internal Use Only</p>
        </div>
    ', [
        'height' => '50px',
        'background' => '#34495e',
        'color' => 'white',
        'padding' => '10px'
    ])
    ->addStyle('
        body { 
            font-family: "DejaVu Sans", Arial, sans-serif; 
            line-height: 1.6;
            color: #333;
        }
        
        h1 { 
            color: #2c3e50; 
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        
        h2 { 
            color: #34495e; 
            margin-top: 30px;
        }
        
        h3 { 
            color: #2980b9; 
            margin-top: 20px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .breakable-table {
            page-break-inside: auto;
        }
        
        .breakable-table thead {
            display: table-header-group;
        }
        
        .breakable-table tbody {
            page-break-inside: avoid;
        }
        
        .breakable-table tr {
            page-break-inside: avoid;
        }
        
        .breakable-table th,
        .breakable-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        .breakable-table th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
        }
        
        .styled-content {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        
        .highlight-box {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        
        .highlight-box h4 {
            color: #856404;
            margin-top: 0;
        }
        
        ul {
            padding-left: 20px;
        }
        
        li {
            margin-bottom: 5px;
        }
    ')
    ->addWatermark('CONFIDENTIAL', [
        'opacity' => 0.1,
        'font-size' => '72px',
        'color' => '#ff0000',
        'rotation' => -45
    ])
    ->addBookmark('Introduction', 1)
    ->addBookmark('Employee Data', 1)
    ->addBookmark('Company Information', 1)
    ->setMetadata([
        'Title' => 'Advanced PDF Report',
        'Author' => 'SimPDF Library',
        'Subject' => 'Advanced PDF Generation Example',
        'Keywords' => 'PDF, Laravel, Multi-page, Advanced',
        'Creator' => 'SimPDF Library v1.0'
    ])
    ->download('advanced-example.pdf');
