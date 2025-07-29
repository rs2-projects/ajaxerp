<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Stock Report</title>

    <style>
        @font-face {
            font-family: 'solaimanLipi';
            src: url('{{ public_path("SolaimanLipi.ttf") }}') format('truetype');
        }
        body {
            font-family: 'solaimanLipi', sans-serif;
            font-size: 14px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .report-title {
            font-size: 20px;
            font-weight: 600;
            text-align: center;
            color: #37B34A;
            padding-top: 20px;
        }
        .report-date-range {
            font-size: 16px;
            text-align: center;
            font-weight: 600;
            margin-top: 10px;
        }
        .report-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .report-table th,
        .report-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .report-table thead {
            background-color: #bdffc7;
        }
        .text-left {
            text-align: left;
        }
    </style>
</head>
<body>
    <h1 class="report-title">Product Material Stock Report</h1>
    <p class="report-date-range">Date: {{ $date }}</p>

    <table class="report-table">
        <thead>
            <tr>
                <th>SL</th>
                <th class="text-left">Product</th>
                <th>Code</th>
                <th>Qty</th>
                <th>Wholesale Price</th>
                <th>Retail Price</th>
            </tr>
        </thead>
        <tbody>
            @forelse($product_materials as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $item->name }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->available_qty }}</td>
                    <td>{{ getCurrencySymbol() }} {{ showAmount($item->wholesale_price) }}</td>
                    <td>{{ getCurrencySymbol() }} {{ showAmount($item->retail_price) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No data found!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
