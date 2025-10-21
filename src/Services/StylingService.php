<?php

namespace SimPdf\SimPdfLibs\Services;

class StylingService
{
    protected array $styles = [];
    protected array $watermarks = [];
    protected array $bookmarks = [];

    public function addStyle(string $css): string
    {
        $this->styles[] = $css;
        return $css;
    }

    public function createWatermark(string $text, array $options = []): array
    {
        return array_merge([
            'text' => $text,
            'position' => 'center',
            'opacity' => 0.3,
            'font-size' => '48px',
            'font-family' => 'Arial, sans-serif',
            'color' => '#cccccc',
            'rotation' => -45,
            'z-index' => -1
        ], $options);
    }

    public function createBookmark(string $title, int $level = 1): array
    {
        return [
            'title' => $title,
            'level' => $level,
            'timestamp' => time()
        ];
    }

    public function addStyles(string $html, array $styles): string
    {
        if (empty($styles)) {
            return $html;
        }

        $combinedCss = implode("\n", $styles);
        return $this->addCssToHtml($html, $combinedCss);
    }

    public function addWatermark(string $html, array $watermark): string
    {
        $watermarkCss = $this->generateWatermarkCss($watermark);
        $watermarkHtml = $this->generateWatermarkHtml($watermark);

        // Add watermark to the HTML
        $html = str_replace('</body>', "{$watermarkHtml}</body>", $html);
        $html = $this->addCssToHtml($html, $watermarkCss);

        return $html;
    }

    public function addBookmarks(string $html, array $bookmarks): string
    {
        if (empty($bookmarks)) {
            return $html;
        }

        $bookmarkCss = $this->generateBookmarkCss();
        $bookmarkHtml = $this->generateBookmarkHtml($bookmarks);

        // Add bookmarks to the HTML
        $html = str_replace('</body>', "{$bookmarkHtml}</body>", $html);
        $html = $this->addCssToHtml($html, $bookmarkCss);

        return $html;
    }

    protected function generateWatermarkCss(array $watermark): string
    {
        $position = $watermark['position'];
        $opacity = $watermark['opacity'];
        $fontSize = $watermark['font-size'];
        $fontFamily = $watermark['font-family'];
        $color = $watermark['color'];
        $rotation = $watermark['rotation'];
        $zIndex = $watermark['z-index'];

        return "
        .watermark {
            position: fixed;
            {$position}: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate({$rotation}deg);
            opacity: {$opacity};
            font-size: {$fontSize};
            font-family: {$fontFamily};
            color: {$color};
            z-index: {$zIndex};
            pointer-events: none;
            user-select: none;
        }
        ";
    }

    protected function generateWatermarkHtml(array $watermark): string
    {
        return "<div class='watermark'>{$watermark['text']}</div>";
    }

    protected function generateBookmarkCss(): string
    {
        return "
        .bookmark {
            display: none;
        }
        .bookmark-level-1 {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0 5px 0;
        }
        .bookmark-level-2 {
            font-size: 14px;
            font-weight: bold;
            margin: 8px 0 4px 20px;
        }
        .bookmark-level-3 {
            font-size: 12px;
            font-weight: normal;
            margin: 6px 0 3px 40px;
        }
        ";
    }

    protected function generateBookmarkHtml(array $bookmarks): string
    {
        $html = '<div class="bookmarks">';
        
        foreach ($bookmarks as $bookmark) {
            $level = $bookmark['level'];
            $title = $bookmark['title'];
            $html .= "<div class='bookmark bookmark-level-{$level}'>{$title}</div>";
        }
        
        $html .= '</div>';
        return $html;
    }

    protected function addCssToHtml(string $html, string $css): string
    {
        $styleTag = "<style>{$css}</style>";
        
        // Insert CSS in head if it exists, otherwise create head
        if (strpos($html, '<head>') !== false) {
            $html = str_replace('<head>', "<head>{$styleTag}", $html);
        } else {
            $html = "<head>{$styleTag}</head>{$html}";
        }

        return $html;
    }

    public function generateAdvancedStylingCss(): string
    {
        return "
        /* Advanced PDF Styling */
        @page {
            margin: 2cm;
            size: A4;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        
        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        /* Page break controls */
        .page-break {
            page-break-before: always;
        }
        
        .no-page-break {
            page-break-inside: avoid;
        }
        
        .break-before {
            page-break-before: always;
        }
        
        .break-after {
            page-break-after: always;
        }
        
        /* Headers and footers */
        .header, .footer {
            position: fixed;
            width: 100%;
            background: white;
            border: 1px solid #ccc;
        }
        
        .header {
            top: 0;
        }
        
        .footer {
            bottom: 0;
        }
        
        /* Text formatting */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .text-justify { text-align: justify; }
        
        .font-bold { font-weight: bold; }
        .font-italic { font-style: italic; }
        .font-underline { text-decoration: underline; }
        
        /* Colors */
        .text-primary { color: #007bff; }
        .text-success { color: #28a745; }
        .text-danger { color: #dc3545; }
        .text-warning { color: #ffc107; }
        .text-info { color: #17a2b8; }
        
        /* Spacing */
        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-3 { margin-top: 1rem; }
        .mt-4 { margin-top: 1.5rem; }
        .mt-5 { margin-top: 3rem; }
        
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 1rem; }
        .mb-4 { margin-bottom: 1.5rem; }
        .mb-5 { margin-bottom: 3rem; }
        
        .p-1 { padding: 0.25rem; }
        .p-2 { padding: 0.5rem; }
        .p-3 { padding: 1rem; }
        .p-4 { padding: 1.5rem; }
        .p-5 { padding: 3rem; }
        ";
    }
}
