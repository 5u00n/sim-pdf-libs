<?php

namespace SimPdf\SimPdfLibs\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use SimPdf\SimPdfLibs\Contracts\PdfGeneratorInterface;
use SimPdf\SimPdfLibs\Services\PageBreakService;
use SimPdf\SimPdfLibs\Services\HeaderFooterService;
use SimPdf\SimPdfLibs\Services\StylingService;

class PdfGeneratorService implements PdfGeneratorInterface
{
    protected Dompdf $dompdf;
    protected PageBreakService $pageBreakService;
    protected HeaderFooterService $headerFooterService;
    protected StylingService $stylingService;
    protected array $options = [];
    protected string $html = '';
    protected array $pageBreaks = [];
    protected array $headers = [];
    protected array $footers = [];
    protected array $styles = [];
    protected array $watermarks = [];
    protected array $bookmarks = [];
    protected array $metadata = [];

    public function __construct()
    {
        $this->dompdf = new Dompdf();
        $this->pageBreakService = $this->getService('simpdf.pagebreak');
        $this->headerFooterService = $this->getService('simpdf.headerfooter');
        $this->stylingService = $this->getService('simpdf.styling');
        
        $this->setDefaultOptions();
    }

    protected function getService(string $service)
    {
        if (function_exists('app')) {
            return app($service);
        }
        
        // Fallback for when Laravel is not available
        switch ($service) {
            case 'simpdf.pagebreak':
                return new PageBreakService();
            case 'simpdf.headerfooter':
                return new HeaderFooterService();
            case 'simpdf.styling':
                return new StylingService();
            default:
                return null;
        }
    }

    protected function getPath(string $path): string
    {
        if (function_exists('storage_path') && function_exists('app') && app()->bound('path.storage')) {
            return storage_path($path);
        }
        
        if (function_exists('base_path') && function_exists('app') && app()->bound('path')) {
            return base_path($path);
        }
        
        // Fallback for standalone usage
        return __DIR__ . '/../../' . $path;
    }

    protected function setDefaultOptions(): void
    {
        $this->options = [
            'defaultFont' => 'DejaVu Sans',
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'defaultPaperSize' => 'A4',
            'defaultPaperOrientation' => 'portrait',
            'dpi' => 96,
            'enableCssFloat' => true,
            'enableHtml5Parser' => true,
            'enableRemote' => true,
            'enablePhp' => true,
            'fontCache' => $this->getPath('fonts/'),
            'tempDir' => sys_get_temp_dir(),
            'chroot' => realpath($this->getPath('')),
            'logOutputFile' => $this->getPath('logs/dompdf.log'),
            'defaultMediaType' => 'print',
            'defaultPaperSize' => 'A4',
            'defaultPaperOrientation' => 'portrait',
            'defaultFont' => 'DejaVu Sans',
            'enableCssFloat' => true,
            'enableHtml5Parser' => true,
            'enableRemote' => true,
            'enablePhp' => true,
            'fontCache' => $this->getPath('fonts/'),
            'tempDir' => sys_get_temp_dir(),
            'chroot' => realpath($this->getPath('')),
            'logOutputFile' => $this->getPath('logs/dompdf.log'),
            'defaultMediaType' => 'print',
        ];
    }

    public function loadHtml(string $html): self
    {
        $this->html = $html;
        return $this;
    }

    public function setPaper(string $paper, string $orientation = 'portrait'): self
    {
        $this->options['defaultPaperSize'] = $paper;
        $this->options['defaultPaperOrientation'] = $orientation;
        return $this;
    }

    public function setOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    public function addPageBreak(string $type = 'page', array $options = []): self
    {
        $this->pageBreaks[] = $this->pageBreakService->createPageBreak($type, $options);
        return $this;
    }

    public function setHeader(string $content, array $options = []): self
    {
        $this->headers[] = $this->headerFooterService->createHeader($content, $options);
        return $this;
    }

    public function setFooter(string $content, array $options = []): self
    {
        $this->footers[] = $this->headerFooterService->createFooter($content, $options);
        return $this;
    }

    public function enablePageNumbers(array $options = []): self
    {
        $this->pageBreakService->enablePageNumbers($options);
        return $this;
    }

    public function addStyle(string $css): self
    {
        $this->styles[] = $this->stylingService->addStyle($css);
        return $this;
    }

    public function addWatermark(string $text, array $options = []): self
    {
        $this->watermarks[] = $this->stylingService->createWatermark($text, $options);
        return $this;
    }

    public function addBookmark(string $title, int $level = 1): self
    {
        $this->bookmarks[] = $this->stylingService->createBookmark($title, $level);
        return $this;
    }

    public function setMetadata(array $metadata): self
    {
        $this->metadata = array_merge($this->metadata, $metadata);
        return $this;
    }

    public function breakTable(array $options = []): self
    {
        $this->pageBreakService->addTableBreak($options);
        return $this;
    }

    public function breakRow(array $options = []): self
    {
        $this->pageBreakService->addRowBreak($options);
        return $this;
    }

    protected function buildFinalHtml(): string
    {
        $finalHtml = $this->html;
        
        // Add page breaks
        foreach ($this->pageBreaks as $pageBreak) {
            $finalHtml = $this->pageBreakService->insertPageBreak($finalHtml, $pageBreak);
        }
        
        // Add headers and footers
        $finalHtml = $this->headerFooterService->addHeadersAndFooters($finalHtml, $this->headers, $this->footers);
        
        // Add styles
        $finalHtml = $this->stylingService->addStyles($finalHtml, $this->styles);
        
        // Add watermarks
        foreach ($this->watermarks as $watermark) {
            $finalHtml = $this->stylingService->addWatermark($finalHtml, $watermark);
        }
        
        // Add bookmarks
        $finalHtml = $this->stylingService->addBookmarks($finalHtml, $this->bookmarks);
        
        return $finalHtml;
    }

    public function output(): string
    {
        $finalHtml = $this->buildFinalHtml();
        
        $this->dompdf->loadHtml($finalHtml);
        $this->dompdf->setPaper($this->options['defaultPaperSize'], $this->options['defaultPaperOrientation']);
        
        $options = new Options();
        foreach ($this->options as $key => $value) {
            $options->set($key, $value);
        }
        $this->dompdf->setOptions($options);
        
        $this->dompdf->render();
        
        return $this->dompdf->output();
    }

    public function save(string $path): self
    {
        $output = $this->output();
        file_put_contents($path, $output);
        return $this;
    }

    public function download(string $filename = 'document.pdf'): self
    {
        $output = $this->output();
        
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . strlen($output));
        
        echo $output;
        exit;
    }

    public function stream(): self
    {
        $output = $this->output();
        
        header('Content-Type: application/pdf');
        header('Content-Length: ' . strlen($output));
        
        echo $output;
        exit;
    }
}
