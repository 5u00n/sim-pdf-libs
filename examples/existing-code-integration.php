<?php

/**
 * Example: How to integrate SimPDF with your existing Laravel code
 */

// Example 1: Replace existing PDF generation in your controller
class YourExistingController extends Controller
{
    // BEFORE: Using other PDF libraries
    public function generatePdfOld(Request $request)
    {
        // Your existing code might look like this:
        $data = $this->getYourData();
        $pdf = PDF::loadView('your-existing-view', $data);
        return $pdf->download('document.pdf');
    }
    
    // AFTER: Using SimPDF
    public function generatePdfNew(Request $request)
    {
        // Same data, but with SimPDF features
        $data = $this->getYourData();
        $html = view('your-existing-view', $data)->render();
        
        return SimPdf::loadHtml($html)
            ->setPaper('A4', 'portrait')
            ->enablePageNumbers([
                'position' => 'bottom-right',
                'format' => 'Page {PAGE_NUM} of {PAGE_COUNT}'
            ])
            ->setHeader('<h3>Your Company Header</h3>', [
                'height' => '60px',
                'background' => '#f8f9fa'
            ])
            ->setFooter('<p>© 2024 Your Company</p>', [
                'height' => '40px',
                'background' => '#f8f9fa'
            ])
            ->download('document.pdf');
    }
}

// Example 2: Multi-page document from your existing data
class ReportController extends Controller
{
    public function generateReport(Request $request)
    {
        // Your existing data fetching
        $users = User::all();
        $orders = Order::with('user')->get();
        $products = Product::all();
        
        // Build HTML with page breaks
        $html = $this->buildReportHtml($users, $orders, $products);
        
        return SimPdf::loadHtml($html)
            ->setPaper('A4', 'portrait')
            ->enablePageNumbers()
            ->setHeader('<h3>Monthly Report - ' . date('F Y') . '</h3>')
            ->setFooter('<p>Generated on ' . date('Y-m-d H:i:s') . '</p>')
            ->addWatermark('CONFIDENTIAL', [
                'opacity' => 0.1,
                'font-size' => '48px'
            ])
            ->download('monthly-report.pdf');
    }
    
    private function buildReportHtml($users, $orders, $products)
    {
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Monthly Report</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .page-break { page-break-before: always; }
                .section { margin: 20px 0; }
                table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background: #3498db; color: white; }
            </style>
        </head>
        <body>
            <h1>Monthly Report</h1>
            <p>Generated on: ' . date('Y-m-d H:i:s') . '</p>
            
            <div class="section">
                <h2>Users Summary</h2>
                <p>Total users: ' . $users->count() . '</p>
            </div>
            
            <div class="page-break"></div>
            
            <div class="section">
                <h2>Orders Summary</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        foreach ($orders as $order) {
            $html .= "
                        <tr>
                            <td>{$order->id}</td>
                            <td>{$order->user->name}</td>
                            <td>\${$order->total}</td>
                            <td>{$order->created_at->format('Y-m-d')}</td>
                        </tr>";
        }
        
        $html .= '
                    </tbody>
                </table>
            </div>
            
            <div class="page-break"></div>
            
            <div class="section">
                <h2>Products Summary</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        foreach ($products as $product) {
            $html .= "
                        <tr>
                            <td>{$product->id}</td>
                            <td>{$product->name}</td>
                            <td>\${$product->price}</td>
                            <td>{$product->stock}</td>
                        </tr>";
        }
        
        $html .= '
                    </tbody>
                </table>
            </div>
        </body>
        </html>';
        
        return $html;
    }
}

// Example 3: Invoice generation with your existing data
class InvoiceController extends Controller
{
    public function generateInvoice($invoiceId)
    {
        $invoice = Invoice::with(['items', 'customer'])->find($invoiceId);
        
        if (!$invoice) {
            return redirect()->back()->with('error', 'Invoice not found');
        }
        
        $html = view('invoices.pdf', compact('invoice'))->render();
        
        return SimPdf::loadHtml($html)
            ->setPaper('A4', 'portrait')
            ->enablePageNumbers()
            ->setHeader('<h3>Invoice #' . $invoice->number . '</h3>', [
                'height' => '50px',
                'background' => '#f8f9fa',
                'border' => '1px solid #ddd'
            ])
            ->setFooter('<p>Thank you for your business! | Page {PAGE_NUM}</p>', [
                'height' => '40px',
                'background' => '#f8f9fa',
                'border' => '1px solid #ddd'
            ])
            ->addWatermark('PAID', [
                'opacity' => 0.1,
                'font-size' => '72px',
                'color' => '#28a745'
            ])
            ->download('invoice-' . $invoice->number . '.pdf');
    }
}

// Example 4: Large table with pagination
class DataExportController extends Controller
{
    public function exportToPdf(Request $request)
    {
        $data = $this->getLargeDataset($request);
        
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Data Export</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                table { width: 100%; border-collapse: collapse; margin: 20px 0; page-break-inside: auto; }
                thead { display: table-header-group; }
                tbody { page-break-inside: avoid; }
                tr { page-break-inside: avoid; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background: #3498db; color: white; }
            </style>
        </head>
        <body>
            <h1>Data Export Report</h1>
            <p>Generated on: ' . date('Y-m-d H:i:s') . '</p>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($data as $item) {
            $html .= "
                    <tr>
                        <td>{$item->id}</td>
                        <td>{$item->name}</td>
                        <td>{$item->email}</td>
                        <td>{$item->status}</td>
                        <td>{$item->created_at->format('Y-m-d H:i:s')}</td>
                    </tr>";
        }
        
        $html .= '
                </tbody>
            </table>
        </body>
        </html>';
        
        return SimPdf::loadHtml($html)
            ->setPaper('A4', 'portrait')
            ->enablePageNumbers()
            ->breakTable([
                'repeat_header' => true,
                'min_rows' => 5,
                'max_rows' => 25
            ])
            ->setHeader('<h3>Data Export Report</h3>')
            ->setFooter('<p>Total Records: ' . count($data) . ' | Page {PAGE_NUM}</p>')
            ->download('data-export.pdf');
    }
    
    private function getLargeDataset($request)
    {
        // Your existing data fetching logic
        return User::when($request->status, function($query, $status) {
            return $query->where('status', $status);
        })->get();
    }
}

// Example 5: Update your existing Blade template
/*
<!-- Your existing Blade template (e.g., resources/views/reports/pdf.blade.php) -->
<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <style>
        /* Your existing styles */
        body { font-family: Arial, sans-serif; }
        
        /* Add SimPDF styles */
        .page-break { page-break-before: always; }
        .no-break { page-break-inside: avoid; }
        .break-before { page-break-before: always; }
        .break-after { page-break-after: always; }
    </style>
</head>
<body>
    <h1>{{ $report->title }}</h1>
    
    @foreach($report->sections as $section)
        <div class="section">
            <h2>{{ $section->title }}</h2>
            <p>{{ $section->content }}</p>
        </div>
        
        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
*/

// Example 6: Add routes to your existing routes/web.php
/*
Route::get('/pdf/report', [ReportController::class, 'generateReport']);
Route::get('/pdf/invoice/{id}', [InvoiceController::class, 'generateInvoice']);
Route::get('/pdf/export', [DataExportController::class, 'exportToPdf']);
*/
