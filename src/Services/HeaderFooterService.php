<?php

namespace SimPdf\SimPdfLibs\Services;

class HeaderFooterService
{
    public function createHeader(string $content, array $options = []): array
    {
        return array_merge([
            'content' => $content,
            'position' => 'top',
            'height' => '50px',
            'background' => '#ffffff',
            'border' => '1px solid #cccccc',
            'padding' => '10px',
            'font-size' => '12px',
            'font-family' => 'Arial, sans-serif',
            'color' => '#333333',
            'text-align' => 'left',
            'z-index' => 1000,
            'repeat' => true
        ], $options);
    }

    public function createFooter(string $content, array $options = []): array
    {
        return array_merge([
            'content' => $content,
            'position' => 'bottom',
            'height' => '50px',
            'background' => '#ffffff',
            'border' => '1px solid #cccccc',
            'padding' => '10px',
            'font-size' => '12px',
            'font-family' => 'Arial, sans-serif',
            'color' => '#333333',
            'text-align' => 'left',
            'z-index' => 1000,
            'repeat' => true
        ], $options);
    }

    public function addHeadersAndFooters(string $html, array $headers, array $footers): string
    {
        $headerCss = $this->generateHeaderCss($headers);
        $footerCss = $this->generateFooterCss($footers);
        $headerHtml = $this->generateHeaderHtml($headers);
        $footerHtml = $this->generateFooterHtml($footers);

        // Wrap the content with headers and footers
        $wrappedHtml = "
        <div class='pdf-container'>
            <div class='pdf-header'>{$headerHtml}</div>
            <div class='pdf-content'>{$html}</div>
            <div class='pdf-footer'>{$footerHtml}</div>
        </div>
        ";

        // Add CSS
        $wrappedHtml = $this->addCssToHtml($wrappedHtml, $headerCss . $footerCss);

        return $wrappedHtml;
    }

    protected function generateHeaderCss(array $headers): string
    {
        if (empty($headers)) {
            return '';
        }

        $css = "
        .pdf-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            page-break-inside: avoid;
        }
        ";

        foreach ($headers as $index => $header) {
            $css .= "
            .pdf-header-{$index} {
                height: {$header['height']};
                background: {$header['background']};
                border: {$header['border']};
                padding: {$header['padding']};
                font-size: {$header['font-size']};
                font-family: {$header['font-family']};
                color: {$header['color']};
                text-align: {$header['text-align']};
                z-index: {$header['z-index']};
            }
            ";
        }

        return $css;
    }

    protected function generateFooterCss(array $footers): string
    {
        if (empty($footers)) {
            return '';
        }

        $css = "
        .pdf-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            page-break-inside: avoid;
        }
        ";

        foreach ($footers as $index => $footer) {
            $css .= "
            .pdf-footer-{$index} {
                height: {$footer['height']};
                background: {$footer['background']};
                border: {$footer['border']};
                padding: {$footer['padding']};
                font-size: {$footer['font-size']};
                font-family: {$footer['font-family']};
                color: {$footer['color']};
                text-align: {$footer['text-align']};
                z-index: {$footer['z-index']};
            }
            ";
        }

        return $css;
    }

    protected function generateHeaderHtml(array $headers): string
    {
        if (empty($headers)) {
            return '';
        }

        $html = '';
        foreach ($headers as $index => $header) {
            $html .= "<div class='pdf-header-{$index}'>{$header['content']}</div>";
        }

        return $html;
    }

    protected function generateFooterHtml(array $footers): string
    {
        if (empty($footers)) {
            return '';
        }

        $html = '';
        foreach ($footers as $index => $footer) {
            $html .= "<div class='pdf-footer-{$index}'>{$footer['content']}</div>";
        }

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

    public function generatePageMarginCss(array $headers, array $footers): string
    {
        $topMargin = '0px';
        $bottomMargin = '0px';

        // Calculate margins based on header/footer heights
        foreach ($headers as $header) {
            $height = str_replace('px', '', $header['height']);
            $topMargin = max($topMargin, $height + 10) . 'px';
        }

        foreach ($footers as $footer) {
            $height = str_replace('px', '', $footer['height']);
            $bottomMargin = max($bottomMargin, $height + 10) . 'px';
        }

        return "
        @page {
            margin-top: {$topMargin};
            margin-bottom: {$bottomMargin};
        }
        .pdf-content {
            margin-top: {$topMargin};
            margin-bottom: {$bottomMargin};
        }
        ";
    }
}
