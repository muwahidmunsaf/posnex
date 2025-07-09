<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Receipt #{{ $sale->saleE_id }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            max-width: 80mm;
            margin: 0 auto;
            padding: 10px;
        }

        h4,
        h5 {
            text-align: center;
        }

        .table {
            width: 100%;
            margin-bottom: 10px;
        }

        .table th,
        .table td {
            padding: 4px;
            font-size: 12px;
        }

        .summary {
            margin-top: 10px;
            border-top: 1px dashed #000;
            padding-top: 5px;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            border-top: 1px dashed #000;
            padding-top: 5px;
            margin-top: 10px;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                width: 80mm;
            }
        }
    </style>
</head>

<body>

    <h4>{{ auth()->user()->company->name ?? 'POS System' }}</h4>
    <h5>Manual Sale Receipt</h5>
    <p>
        <strong>Sale ID:</strong> {{ $sale->saleE_id }}<br>
        <strong>Date:</strong> {{ $sale->created_at->format('d-m-Y h:i A') }}<br>
        <strong>Created By:</strong> {{ $sale->created_by }}<br>
        <strong>Customer:</strong> {{ $sale->customer->name ?? 'N/A' }}
    </p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Rate</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $sale->purchase->item_name ?? 'N/A' }}</td>
                <td>1</td>
                <td>{{ number_format($sale->sale_amount, 2) }}</td>
                <td>{{ number_format($sale->sale_amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="summary">
        <p><strong>Subtotal:</strong> {{ number_format($sale->sale_amount, 2) }} <br>
            <strong>Payment Method:</strong> {{ ucfirst($sale->payment_method) }} <br>
            <strong>Tax:</strong> {{ number_format($sale->tax_amount, 2) }}
        </p>
        <h5><strong>Total:</strong> {{ number_format($sale->total_amount, 2) }}</h5>

    </div>

    <div class="footer">
        <p>Thank you for your purchase!</p>
        <p>Developed by <strong>DevZyte</strong><br>
            <small>www.devzyte.com | info@devzyte.com</small><br>
            <small>(+92) 346-7911195</small>
        </p>
    </div>

    <div class="text-center no-print mt-3">
        <button class="btn btn-primary btn-sm" onclick="window.print()">Print Receipt</button>
        <a href="{{ route('external-sales.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>

</body>

</html>
