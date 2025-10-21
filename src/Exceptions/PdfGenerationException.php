<?php

namespace SimPdf\SimPdfLibs\Exceptions;

use Exception;

class PdfGenerationException extends Exception
{
    /**
     * Create a new PDF generation exception.
     */
    public static function invalidHtml(string $message = 'Invalid HTML provided'): self
    {
        return new static($message);
    }

    /**
     * Create a new PDF generation exception for invalid paper size.
     */
    public static function invalidPaperSize(string $paper): self
    {
        return new static("Invalid paper size: {$paper}");
    }

    /**
     * Create a new PDF generation exception for invalid orientation.
     */
    public static function invalidOrientation(string $orientation): self
    {
        return new static("Invalid orientation: {$orientation}");
    }

    /**
     * Create a new PDF generation exception for file save failure.
     */
    public static function saveFailed(string $path): self
    {
        return new static("Failed to save PDF to: {$path}");
    }

    /**
     * Create a new PDF generation exception for memory limit exceeded.
     */
    public static function memoryLimitExceeded(): self
    {
        return new static("Memory limit exceeded during PDF generation");
    }

    /**
     * Create a new PDF generation exception for timeout.
     */
    public static function timeoutExceeded(): self
    {
        return new static("Timeout exceeded during PDF generation");
    }
}
