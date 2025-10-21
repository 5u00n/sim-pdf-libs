<?php

namespace SimPdf\SimPdfLibs\Contracts;

interface PdfGeneratorInterface
{
    public function loadHtml(string $html): self;
    public function setPaper(string $paper, string $orientation = 'portrait'): self;
    public function setOptions(array $options): self;
    public function addPageBreak(string $type = 'page', array $options = []): self;
    public function setHeader(string $content, array $options = []): self;
    public function setFooter(string $content, array $options = []): self;
    public function enablePageNumbers(array $options = []): self;
    public function addStyle(string $css): self;
    public function addWatermark(string $text, array $options = []): self;
    public function addBookmark(string $title, int $level = 1): self;
    public function setMetadata(array $metadata): self;
    public function breakTable(array $options = []): self;
    public function breakRow(array $options = []): self;
    public function output(): string;
    public function save(string $path): self;
    public function download(string $filename = 'document.pdf'): self;
    public function stream(): self;
}
