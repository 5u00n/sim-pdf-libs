<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default PDF Settings
    |--------------------------------------------------------------------------
    |
    | These are the default settings for PDF generation. You can override
    | these settings when creating PDFs.
    |
    */
    'default' => [
        'paper' => 'A4',
        'orientation' => 'portrait',
        'dpi' => 96,
        'defaultFont' => 'DejaVu Sans',
        'isRemoteEnabled' => true,
        'isHtml5ParserEnabled' => true,
        'isPhpEnabled' => true,
        'enableCssFloat' => true,
        'enableHtml5Parser' => true,
        'enableRemote' => true,
        'enablePhp' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Font Settings
    |--------------------------------------------------------------------------
    |
    | Configure font paths and caching for better performance.
    |
    */
    'fonts' => [
        'fontCache' => storage_path('fonts/'),
        'fontDir' => public_path('fonts/'),
        'defaultFont' => 'DejaVu Sans',
        'availableFonts' => [
            'DejaVu Sans',
            'DejaVu Serif',
            'DejaVu Sans Mono',
            'Arial',
            'Times New Roman',
            'Courier New',
            'Helvetica',
            'Verdana',
            'Georgia',
            'Palatino',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Page Break Settings
    |--------------------------------------------------------------------------
    |
    | Configure how page breaks are handled in your PDFs.
    |
    */
    'pageBreaks' => [
        'enabled' => true,
        'avoidOrphans' => true,
        'avoidWidows' => true,
        'minRowsBeforeBreak' => 3,
        'maxRowsPerPage' => 50,
        'repeatTableHeaders' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Header and Footer Settings
    |--------------------------------------------------------------------------
    |
    | Configure default header and footer settings.
    |
    */
    'headers' => [
        'enabled' => false,
        'height' => '50px',
        'background' => '#ffffff',
        'border' => '1px solid #cccccc',
        'padding' => '10px',
        'fontSize' => '12px',
        'fontFamily' => 'Arial, sans-serif',
        'color' => '#333333',
        'textAlign' => 'left',
    ],

    'footers' => [
        'enabled' => false,
        'height' => '50px',
        'background' => '#ffffff',
        'border' => '1px solid #cccccc',
        'padding' => '10px',
        'fontSize' => '12px',
        'fontFamily' => 'Arial, sans-serif',
        'color' => '#333333',
        'textAlign' => 'left',
    ],

    /*
    |--------------------------------------------------------------------------
    | Page Numbering Settings
    |--------------------------------------------------------------------------
    |
    | Configure page numbering for your PDFs.
    |
    */
    'pageNumbers' => [
        'enabled' => false,
        'position' => 'bottom-right',
        'format' => 'Page {PAGE_NUM} of {PAGE_COUNT}',
        'fontSize' => '10px',
        'fontFamily' => 'Arial, sans-serif',
        'color' => '#666666',
        'margin' => '10px',
    ],

    /*
    |--------------------------------------------------------------------------
    | Watermark Settings
    |--------------------------------------------------------------------------
    |
    | Configure watermark settings for your PDFs.
    |
    */
    'watermarks' => [
        'enabled' => false,
        'text' => 'DRAFT',
        'position' => 'center',
        'opacity' => 0.3,
        'fontSize' => '48px',
        'fontFamily' => 'Arial, sans-serif',
        'color' => '#cccccc',
        'rotation' => -45,
    ],

    /*
    |--------------------------------------------------------------------------
    | Styling Settings
    |--------------------------------------------------------------------------
    |
    | Configure default styling for your PDFs.
    |
    */
    'styling' => [
        'defaultCss' => true,
        'customCss' => '',
        'enableAdvancedFeatures' => true,
        'enableTableStyling' => true,
        'enableTextFormatting' => true,
        'enableColorSupport' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance Settings
    |--------------------------------------------------------------------------
    |
    | Configure performance-related settings for PDF generation.
    |
    */
    'performance' => [
        'memoryLimit' => '256M',
        'maxExecutionTime' => 300,
        'enableCaching' => true,
        'cacheDirectory' => storage_path('app/pdf-cache/'),
        'tempDirectory' => sys_get_temp_dir(),
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    |
    | Configure security settings for PDF generation.
    |
    */
    'security' => [
        'chroot' => realpath(base_path()),
        'enableRemote' => true,
        'allowedProtocols' => ['http', 'https'],
        'allowedHosts' => [],
        'logOutputFile' => storage_path('logs/dompdf.log'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Output Settings
    |--------------------------------------------------------------------------
    |
    | Configure how PDFs are output and saved.
    |
    */
    'output' => [
        'defaultFilename' => 'document.pdf',
        'savePath' => storage_path('app/pdfs/'),
        'enableDownload' => true,
        'enableStream' => true,
        'enableSave' => true,
    ],
];
