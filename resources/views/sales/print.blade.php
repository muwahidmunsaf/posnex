<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Receipt #{{ $sale->id }}</title>
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

    <h5>Sale Receipt</h5>
    <p><strong>Sale ID</strong> # {{ $sale->sale_code }}<br>
        <strong>Date:</strong> {{ $sale->created_at->format('d-m-Y h:i A') }}<br>
        <strong>Created By:</strong> {{ $sale->created_by }} <br>
        <strong>Customer:</strong> {{ $sale->customer->name ?? $sale->customer_name ?? 'N/A' }}
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
            @foreach ($sale->inventorySales as $detail)
                <tr>
                    <td>{{ $detail->item->item_name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ number_format($detail->amount, 2) }}</td>
                    <td>{{ number_format($detail->amount * $detail->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($sale->returns && $sale->returns->count())
        <div class="mt-3">
            <h6>Returned Items</h6>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Amount</th>
                        <th>Reason</th>
                        <th>Processed By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->returns as $ret)
                        <tr>
                            <td>{{ $ret->item->item_name ?? '-' }}</td>
                            <td>{{ $ret->quantity }}</td>
                            <td>{{ number_format($ret->amount, 2) }}</td>
                            <td>{{ $ret->reason }}</td>
                            <td>{{ $ret->processed_by }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="summary">
        <p><strong>Subtotal:</strong> {{ number_format($sale->subtotal, 2) }}</p>
        <p><strong>Tax ({{ $sale->tax_percentage }}%):</strong> {{ number_format($sale->tax_amount, 2) }}</p>
        <p><strong>Discount:</strong> {{ number_format($sale->discount, 2) }}</p>
        <h5><strong>Total:</strong> {{ number_format($sale->total_amount, 2) }}</h5>
        <p><strong>Payment Method:</strong> {{ ucfirst($sale->payment_method) }}</p>
        @if(isset($sale->amount_received))
            <p><strong>Amount Received:</strong> {{ number_format($sale->amount_received, 2) }}</p>
        @endif
        @if(isset($sale->change_return))
            <p><strong>Change Returned:</strong> {{ number_format($sale->change_return, 2) }}</p>
        @endif
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
        <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>

</body>

</html>
