<!DOCTYPE html>
<html>

<head>
    <title>Employee Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .report-header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .employee-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            page-break-inside: auto;
        }

        .employee-table thead {
            display: table-header-group;
        }

        .employee-table tbody {
            page-break-inside: avoid;
        }

        .employee-table tr {
            page-break-inside: avoid;
        }

        .employee-table th,
        .employee-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .employee-table th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
        }

        .employee-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .employee-table tr:hover {
            background-color: #e8f4f8;
        }

        .status-active {
            color: #28a745;
            font-weight: bold;
        }

        .status-inactive {
            color: #dc3545;
            font-weight: bold;
        }

        .summary {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
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
    </style>
</head>

<body>
    <div class="report-header">
        <h1>Employee Report</h1>
        <p>Total Employees: {{ $total }} | Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</p>
    </div>

    <div class="summary">
        <h2>Report Summary</h2>
        <p>This report contains employee information for {{ $total }} employees. The data is paginated with {{ $perPage }} employees per page for better readability.</p>
    </div>

    <table class="employee-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Salary</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee['id'] }}</td>
                    <td>{{ $employee['name'] }}</td>
                    <td>{{ $employee['email'] }}</td>
                    <td>{{ $employee['department'] }}</td>
                    <td>${{ number_format($employee['salary']) }}</td>
                    <td class="status-{{ strtolower($employee['status']) }}">{{ $employee['status'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

    <h2>Report Statistics</h2>
    <div class="summary">
        <p><strong>Total Employees:</strong> {{ $total }}</p>
        <p><strong>Active Employees:</strong> {{ collect($employees)->where('status', 'Active')->count() }}</p>
        <p><strong>Inactive Employees:</strong> {{ collect($employees)->where('status', 'Inactive')->count() }}</p>
        <p><strong>Average Salary:</strong> ${{ number_format(collect($employees)->avg('salary')) }}</p>
        <p><strong>Highest Salary:</strong> ${{ number_format(collect($employees)->max('salary')) }}</p>
        <p><strong>Lowest Salary:</strong> ${{ number_format(collect($employees)->min('salary')) }}</p>
    </div>
</body>

</html>
