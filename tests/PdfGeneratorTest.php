<?php

namespace SimPdf\SimPdfLibs\Tests;

use PHPUnit\Framework\TestCase;
use SimPdf\SimPdfLibs\Services\PdfGeneratorService;
use SimPdf\SimPdfLibs\Exceptions\PdfGenerationException;

class PdfGeneratorTest extends TestCase
{
    protected PdfGeneratorService $pdfGenerator;

    protected function setUp(): void
    {
        $this->pdfGenerator = new PdfGeneratorService();
    }

    public function testCanLoadHtml()
    {
        $html = '<h1>Test</h1><p>This is a test.</p>';
        
        $result = $this->pdfGenerator->loadHtml($html);
        
        $this->assertInstanceOf(PdfGeneratorService::class, $result);
    }

    public function testCanSetPaper()
    {
        $result = $this->pdfGenerator->setPaper('A4', 'portrait');
        
        $this->assertInstanceOf(PdfGeneratorService::class, $result);
    }

    public function testCanAddPageBreak()
    {
        $result = $this->pdfGenerator->addPageBreak('page');
        
        $this->assertInstanceOf(PdfGeneratorService::class, $result);
    }

    public function testCanSetHeader()
    {
        $result = $this->pdfGenerator->setHeader('Test Header');
        
        $this->assertInstanceOf(PdfGeneratorService::class, $result);
    }

    public function testCanSetFooter()
    {
        $result = $this->pdfGenerator->setFooter('Test Footer');
        
        $this->assertInstanceOf(PdfGeneratorService::class, $result);
    }

    public function testCanEnablePageNumbers()
    {
        $result = $this->pdfGenerator->enablePageNumbers();
        
        $this->assertInstanceOf(PdfGeneratorService::class, $result);
    }

    public function testCanAddStyle()
    {
        $result = $this->pdfGenerator->addStyle('body { color: red; }');
        
        $this->assertInstanceOf(PdfGeneratorService::class, $result);
    }

    public function testCanAddWatermark()
    {
        $result = $this->pdfGenerator->addWatermark('DRAFT');
        
        $this->assertInstanceOf(PdfGeneratorService::class, $result);
    }

    public function testCanAddBookmark()
    {
        $result = $this->pdfGenerator->addBookmark('Test Bookmark');
        
        $this->assertInstanceOf(PdfGeneratorService::class, $result);
    }

    public function testCanSetMetadata()
    {
        $metadata = [
            'Title' => 'Test Document',
            'Author' => 'Test Author'
        ];
        
        $result = $this->pdfGenerator->setMetadata($metadata);
        
        $this->assertInstanceOf(PdfGeneratorService::class, $result);
    }

    public function testCanBreakTable()
    {
        $result = $this->pdfGenerator->breakTable();
        
        $this->assertInstanceOf(PdfGeneratorService::class, $result);
    }

    public function testCanBreakRow()
    {
        $result = $this->pdfGenerator->breakRow();
        
        $this->assertInstanceOf(PdfGeneratorService::class, $result);
    }

    public function testCanGeneratePdf()
    {
        $html = '<h1>Test Document</h1><p>This is a test document.</p>';
        
        $this->pdfGenerator->loadHtml($html);
        $output = $this->pdfGenerator->output();
        
        $this->assertIsString($output);
        $this->assertNotEmpty($output);
    }

    public function testCanSavePdf()
    {
        $html = '<h1>Test Document</h1><p>This is a test document.</p>';
        $tempFile = sys_get_temp_dir() . '/test.pdf';
        
        $this->pdfGenerator->loadHtml($html);
        $result = $this->pdfGenerator->save($tempFile);
        
        $this->assertInstanceOf(PdfGeneratorService::class, $result);
        $this->assertFileExists($tempFile);
        
        // Clean up
        unlink($tempFile);
    }

    public function testCanGenerateMultiPagePdf()
    {
        $html = '
        <h1>Page 1</h1>
        <p>Content for page 1.</p>
        <div class="page-break"></div>
        <h1>Page 2</h1>
        <p>Content for page 2.</p>
        ';
        
        $this->pdfGenerator->loadHtml($html);
        $output = $this->pdfGenerator->output();
        
        $this->assertIsString($output);
        $this->assertNotEmpty($output);
    }

    public function testCanGeneratePdfWithHeaderAndFooter()
    {
        $html = '<h1>Test Document</h1><p>This is a test document.</p>';
        
        $this->pdfGenerator->loadHtml($html)
            ->setHeader('Test Header')
            ->setFooter('Test Footer');
        
        $output = $this->pdfGenerator->output();
        
        $this->assertIsString($output);
        $this->assertNotEmpty($output);
    }

    public function testCanGeneratePdfWithPageNumbers()
    {
        $html = '<h1>Test Document</h1><p>This is a test document.</p>';
        
        $this->pdfGenerator->loadHtml($html)
            ->enablePageNumbers([
                'position' => 'bottom-right',
                'format' => 'Page {PAGE_NUM} of {PAGE_COUNT}'
            ]);
        
        $output = $this->pdfGenerator->output();
        
        $this->assertIsString($output);
        $this->assertNotEmpty($output);
    }

    public function testCanGeneratePdfWithWatermark()
    {
        $html = '<h1>Test Document</h1><p>This is a test document.</p>';
        
        $this->pdfGenerator->loadHtml($html)
            ->addWatermark('DRAFT', [
                'opacity' => 0.3,
                'font-size' => '48px'
            ]);
        
        $output = $this->pdfGenerator->output();
        
        $this->assertIsString($output);
        $this->assertNotEmpty($output);
    }

    public function testCanGeneratePdfWithBookmarks()
    {
        $html = '<h1>Test Document</h1><p>This is a test document.</p>';
        
        $this->pdfGenerator->loadHtml($html)
            ->addBookmark('Introduction', 1)
            ->addBookmark('Details', 1);
        
        $output = $this->pdfGenerator->output();
        
        $this->assertIsString($output);
        $this->assertNotEmpty($output);
    }

    public function testCanGeneratePdfWithMetadata()
    {
        $html = '<h1>Test Document</h1><p>This is a test document.</p>';
        
        $this->pdfGenerator->loadHtml($html)
            ->setMetadata([
                'Title' => 'Test Document',
                'Author' => 'Test Author',
                'Subject' => 'Test Subject'
            ]);
        
        $output = $this->pdfGenerator->output();
        
        $this->assertIsString($output);
        $this->assertNotEmpty($output);
    }
}
