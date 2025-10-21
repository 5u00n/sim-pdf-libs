<?php

namespace SimPdf\SimPdfLibs\Helpers;

class PdfHelper
{
    /**
     * Validate paper size.
     */
    public static function isValidPaperSize(string $paper): bool
    {
        $validSizes = [
            'A0', 'A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'A10',
            'B0', 'B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8', 'B9', 'B10',
            'C0', 'C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7', 'C8', 'C9', 'C10',
            '4A0', '2A0', 'RA0', 'RA1', 'RA2', 'RA3', 'RA4',
            'SRA0', 'SRA1', 'SRA2', 'SRA3', 'SRA4',
            'Letter', 'Legal', 'Tabloid', 'Ledger', 'Executive', 'Folio',
            'Quarto', 'Statement', '10x14'
        ];

        return in_array($paper, $validSizes);
    }

    /**
     * Validate orientation.
     */
    public static function isValidOrientation(string $orientation): bool
    {
        return in_array(strtolower($orientation), ['portrait', 'landscape']);
    }

    /**
     * Generate unique filename.
     */
    public static function generateFilename(string $prefix = 'document', string $extension = 'pdf'): string
    {
        return $prefix . '_' . date('Y-m-d_H-i-s') . '_' . uniqid() . '.' . $extension;
    }

    /**
     * Sanitize filename.
     */
    public static function sanitizeFilename(string $filename): string
    {
        // Remove or replace invalid characters
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
        
        // Ensure it has .pdf extension
        if (!str_ends_with($filename, '.pdf')) {
            $filename .= '.pdf';
        }

        return $filename;
    }

    /**
     * Convert bytes to human readable format.
     */
    public static function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Check if HTML contains page breaks.
     */
    public static function hasPageBreaks(string $html): bool
    {
        $pageBreakPatterns = [
            '/<div[^>]*class[^>]*page-break[^>]*>/i',
            '/<div[^>]*style[^>]*page-break-before[^>]*>/i',
            '/<div[^>]*style[^>]*page-break-after[^>]*>/i',
            '/<div[^>]*style[^>]*break-before[^>]*>/i',
            '/<div[^>]*style[^>]*break-after[^>]*>/i',
        ];

        foreach ($pageBreakPatterns as $pattern) {
            if (preg_match($pattern, $html)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extract page break positions from HTML.
     */
    public static function extractPageBreaks(string $html): array
    {
        $pageBreaks = [];
        $pattern = '/<div[^>]*class[^>]*page-break[^>]*>/i';
        
        preg_match_all($pattern, $html, $matches, PREG_OFFSET_CAPTURE);
        
        foreach ($matches[0] as $match) {
            $pageBreaks[] = [
                'position' => $match[1],
                'html' => $match[0]
            ];
        }

        return $pageBreaks;
    }

    /**
     * Clean HTML for PDF generation.
     */
    public static function cleanHtml(string $html): string
    {
        // Remove unnecessary whitespace
        $html = preg_replace('/\s+/', ' ', $html);
        
        // Remove comments
        $html = preg_replace('/<!--.*?-->/s', '', $html);
        
        // Ensure proper DOCTYPE
        if (!str_starts_with(trim($html), '<!DOCTYPE')) {
            $html = '<!DOCTYPE html>' . $html;
        }

        return $html;
    }

    /**
     * Validate CSS for PDF compatibility.
     */
    public static function validateCss(string $css): array
    {
        $warnings = [];
        $errors = [];

        // Check for unsupported CSS properties
        $unsupportedProperties = [
            'position: fixed' => 'Fixed positioning may not work as expected in PDFs',
            'position: sticky' => 'Sticky positioning is not supported in PDFs',
            'display: flex' => 'Flexbox may not render correctly in PDFs',
            'display: grid' => 'CSS Grid is not supported in PDFs',
            'transform:' => 'CSS transforms may not work in PDFs',
            'animation:' => 'CSS animations are not supported in PDFs',
            'transition:' => 'CSS transitions are not supported in PDFs',
        ];

        foreach ($unsupportedProperties as $property => $message) {
            if (stripos($css, $property) !== false) {
                $warnings[] = $message;
            }
        }

        return [
            'warnings' => $warnings,
            'errors' => $errors
        ];
    }

    /**
     * Get memory usage information.
     */
    public static function getMemoryUsage(): array
    {
        return [
            'current' => self::formatBytes(memory_get_usage(true)),
            'peak' => self::formatBytes(memory_get_peak_usage(true)),
            'limit' => ini_get('memory_limit')
        ];
    }

    /**
     * Check if system has enough memory for PDF generation.
     */
    public static function hasEnoughMemory(int $requiredBytes = 134217728): bool
    {
        $memoryLimit = ini_get('memory_limit');
        $memoryLimitBytes = self::convertToBytes($memoryLimit);
        $currentUsage = memory_get_usage(true);
        $availableMemory = $memoryLimitBytes - $currentUsage;

        return $availableMemory >= $requiredBytes;
    }

    /**
     * Convert memory limit string to bytes.
     */
    protected static function convertToBytes(string $memoryLimit): int
    {
        $memoryLimit = trim($memoryLimit);
        $last = strtolower($memoryLimit[strlen($memoryLimit) - 1]);
        $memoryLimit = (int) $memoryLimit;

        switch ($last) {
            case 'g':
                $memoryLimit *= 1024;
            case 'm':
                $memoryLimit *= 1024;
            case 'k':
                $memoryLimit *= 1024;
        }

        return $memoryLimit;
    }
}
