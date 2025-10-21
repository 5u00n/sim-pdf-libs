<?php

namespace SimPdf\SimPdfLibs\Services;

class PageBreakService
{
    protected array $pageNumbers = [];
    protected array $tableBreaks = [];
    protected array $rowBreaks = [];

    public function createPageBreak(string $type = 'page', array $options = []): array
    {
        return [
            'type' => $type,
            'options' => $options,
            'timestamp' => time()
        ];
    }

    public function insertPageBreak(string $html, array $pageBreak): string
    {
        $breakHtml = $this->generatePageBreakHtml($pageBreak);
        
        // Insert page break before specific elements if specified
        if (isset($pageBreak['options']['before'])) {
            $html = str_replace(
                $pageBreak['options']['before'],
                $breakHtml . $pageBreak['options']['before'],
                $html
            );
        }
        
        // Insert page break after specific elements if specified
        if (isset($pageBreak['options']['after'])) {
            $html = str_replace(
                $pageBreak['options']['after'],
                $pageBreak['options']['after'] . $breakHtml,
                $html
            );
        }
        
        // Insert page break at specific position if specified
        if (isset($pageBreak['options']['position'])) {
            $position = $pageBreak['options']['position'];
            $html = substr_replace($html, $breakHtml, $position, 0);
        }
        
        return $html;
    }

    protected function generatePageBreakHtml(array $pageBreak): string
    {
        $type = $pageBreak['type'];
        $options = $pageBreak['options'];
        
        switch ($type) {
            case 'page':
                return '<div style="page-break-before: always;"></div>';
                
            case 'avoid':
                return '<div style="page-break-inside: avoid;"></div>';
                
            case 'table':
                return '<div style="page-break-before: always; break-inside: avoid;"></div>';
                
            case 'row':
                return '<div style="page-break-before: always;"></div>';
                
            case 'column':
                return '<div style="page-break-before: always; column-break-before: always;"></div>';
                
            default:
                return '<div style="page-break-before: always;"></div>';
        }
    }

    public function enablePageNumbers(array $options = []): void
    {
        $this->pageNumbers = array_merge([
            'enabled' => true,
            'position' => 'bottom-right',
            'format' => 'Page {PAGE_NUM} of {PAGE_COUNT}',
            'font-size' => '10px',
            'font-family' => 'Arial, sans-serif',
            'color' => '#666666',
            'margin' => '10px'
        ], $options);
    }

    public function addTableBreak(array $options = []): void
    {
        $this->tableBreaks[] = array_merge([
            'enabled' => true,
            'repeat_header' => true,
            'min_rows' => 3,
            'max_rows' => 50
        ], $options);
    }

    public function addRowBreak(array $options = []): void
    {
        $this->rowBreaks[] = array_merge([
            'enabled' => true,
            'avoid_orphans' => true,
            'min_rows' => 2
        ], $options);
    }

    public function generatePageNumberCss(): string
    {
        if (empty($this->pageNumbers) || !$this->pageNumbers['enabled']) {
            return '';
        }

        $position = $this->pageNumbers['position'];
        $fontSize = $this->pageNumbers['font-size'];
        $fontFamily = $this->pageNumbers['font-family'];
        $color = $this->pageNumbers['color'];
        $margin = $this->pageNumbers['margin'];

        return "
        @page {
            @bottom-right {
                content: '{$this->pageNumbers['format']}';
                font-size: {$fontSize};
                font-family: {$fontFamily};
                color: {$color};
                margin: {$margin};
            }
        }
        ";
    }

    public function generateTableBreakCss(): string
    {
        if (empty($this->tableBreaks)) {
            return '';
        }

        $css = '';
        foreach ($this->tableBreaks as $break) {
            if ($break['enabled']) {
                $css .= "
                table {
                    page-break-inside: auto;
                }
                thead {
                    display: table-header-group;
                }
                tbody {
                    page-break-inside: avoid;
                }
                tr {
                    page-break-inside: avoid;
                    page-break-after: auto;
                }
                ";
            }
        }

        return $css;
    }

    public function generateRowBreakCss(): string
    {
        if (empty($this->rowBreaks)) {
            return '';
        }

        $css = '';
        foreach ($this->rowBreaks as $break) {
            if ($break['enabled']) {
                $css .= "
                tr {
                    page-break-inside: avoid;
                }
                ";
            }
        }

        return $css;
    }
}
