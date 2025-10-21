<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .content {
            margin-bottom: 30px;
        }

        .data-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .data-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .data-label {
            font-weight: bold;
            color: #495057;
        }

        .data-value {
            color: #6c757d;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        h2 {
            color: #34495e;
            margin-top: 30px;
            margin-bottom: 15px;
        }

        p {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</p>
    </div>

    <div class="content">
        <p>{{ $content }}</p>

        <div class="data-section">
            <h2>Document Information</h2>
            <div class="data-item">
                <span class="data-label">Name:</span>
                <span class="data-value">{{ $data['name'] }}</span>
            </div>
            <div class="data-item">
                <span class="data-label">Email:</span>
                <span class="data-value">{{ $data['email'] }}</span>
            </div>
            <div class="data-item">
                <span class="data-label">Generated:</span>
                <span class="data-value">{{ $data['date'] }}</span>
            </div>
        </div>

        <h2>Features</h2>
        <ul>
            <li>Multi-page support with custom page breaks</li>
            <li>Automatic page numbering</li>
            <li>Custom headers and footers</li>
            <li>Advanced CSS styling support</li>
            <li>Table pagination and row breaking</li>
            <li>Watermarks and bookmarks</li>
            <li>Metadata support</li>
        </ul>
    </div>
</body>

</html>
