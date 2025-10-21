<?php

namespace SimPdf\SimPdfLibs;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use SimPdf\SimPdfLibs\Services\PdfGeneratorService;
use SimPdf\SimPdfLibs\Services\PageBreakService;
use SimPdf\SimPdfLibs\Services\HeaderFooterService;
use SimPdf\SimPdfLibs\Services\StylingService;

class SimPdfServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('simpdf', function ($app) {
            return new PdfGeneratorService();
        });

        $this->app->singleton('simpdf.pagebreak', function ($app) {
            return new PageBreakService();
        });

        $this->app->singleton('simpdf.headerfooter', function ($app) {
            return new HeaderFooterService();
        });

        $this->app->singleton('simpdf.styling', function ($app) {
            return new StylingService();
        });

        if (method_exists($this, 'mergeConfigFrom')) {
            $this->mergeConfigFrom(__DIR__ . '/../config/simpdf.php', 'simpdf');
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (method_exists($this, 'publishes')) {
            $this->publishes([
                __DIR__ . '/../config/simpdf.php' => function_exists('config_path') ? config_path('simpdf.php') : 'config/simpdf.php',
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => function_exists('resource_path') ? resource_path('views/vendor/simpdf') : 'resources/views/vendor/simpdf',
            ], 'views');
        }
    }
}
