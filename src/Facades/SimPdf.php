<?php

namespace SimPdf\SimPdfLibs\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \SimPdf\SimPdfLibs\Services\PdfGeneratorService loadHtml(string $html)
 * @method static \SimPdf\SimPdfLibs\Services\PdfGeneratorService setPaper(string $paper, string $orientation = 'portrait')
 * @method static \SimPdf\SimPdfLibs\Services\PdfGeneratorService setOptions(array $options)
 * @method static \SimPdf\SimPdfLibs\Services\PdfGeneratorService addPageBreak(string $type = 'page', array $options = [])
 * @method static \SimPdf\SimPdfLibs\Services\PdfGeneratorService setHeader(string $content, array $options = [])
 * @method static \SimPdf\SimPdfLibs\Services\PdfGeneratorService setFooter(string $content, array $options = [])
 * @method static \SimPdf\SimPdfLibs\Services\PdfGeneratorService enablePageNumbers(array $options = [])
 * @method static \SimPdf\SimPdfLibs\Services\PdfGeneratorService addStyle(string $css)
 * @method static \SimPdf\SimPdfLibs\Services\PdfGeneratorService addWatermark(string $text, array $options = [])
 * @method static \SimPdf\SimPdfLibs\Services\PdfGeneratorService addBookmark(string $title, int $level = 1)
 * @method static \SimPdf\SimPdfLibs\Services\PdfGeneratorService setMetadata(array $metadata)
 * @method static \SimPdf\SimPdfLibs\Services\PdfGeneratorService breakTable(array $options = [])
 * @method static \SimPdf\SimPdfLibs\Services\PdfGeneratorService breakRow(array $options = [])
 * @method static string output()
 * @method static \SimPdf\SimPdfLibs\Services\PdfGeneratorService save(string $path)
 * @method static \SimPdf\SimPdfLibs\Services\PdfGeneratorService download(string $filename = 'document.pdf')
 * @method static \SimPdf\SimPdfLibs\Services\PdfGeneratorService stream()
 *
 * @see \SimPdf\SimPdfLibs\Services\PdfGeneratorService
 */
class SimPdf extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'simpdf';
    }
}
