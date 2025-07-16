<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Print</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { font-family: Arial, sans-serif; background: #fff; margin: 0; padding: 0; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2.5px solid #b71c1c; padding: 24px 32px 12px 32px; }
        .header-left { display: flex; align-items: center; }
        .logo { height: 60px; margin-right: 18px; }
        .company-name { font-size: 2rem; font-weight: bold; color: #b71c1c; }
        .company-details { text-align: right; font-size: 1rem; color: #333; line-height: 1.7; }
        .company-details i { color: #b71c1c; margin-right: 4px; }
        .section-title { font-size: 1.3rem; color: #b71c1c; font-weight: bold; margin: 32px 0 16px 0; text-align:center; }
        .dashboard-row { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 18px; justify-content: center; }
        .dashboard-stat { flex: 1 1 120px; min-width: 120px; max-width: 170px; background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.05); display: flex; align-items: center; padding: 8px 10px; border-left: 4px solid #b71c1c; margin-bottom: 6px; font-size: 0.95em; }
        .dashboard-stat .icon { font-size: 1.2rem; margin-right: 8px; color: #b71c1c; }
        .dashboard-stat .label { font-size: 0.92rem; color: #888; font-weight: 500; }
        .dashboard-stat .value { font-size: 1.08rem; font-weight: bold; color: #222; }
        .card { border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.05); border: none; min-height: 60px; margin-bottom: 8px; }
        .card-body { padding: 10px 6px; }
        .card .icon { font-size: 1.2rem; margin-bottom: 2px; }
        .card .label { font-size: 0.92rem; color: #888; font-weight: 500; margin-bottom: 1px; }
        .card .value { font-size: 1.08rem; font-weight: bold; color: #222; }
        .no-print { display: block; margin: 18px 0 0 0; text-align: right; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body>
@php $company = auth()->user()->company; @endphp
<div class="header">
    <div class="header-left">
        @if($company && $company->logo)
            <img src="{{ asset('storage/' . $company->logo) }}" class="logo" alt="Company Logo">
        @else
            <img src="{{ asset('logo.png') }}" class="logo" alt="Logo">
        @endif
        <span class="company-name">{{ $company->name ?? '' }}</span>
    </div>
    <div class="company-details">
        @if($company && $company->address) <div><i class="bi bi-geo-alt"></i> {{ $company->address }}</div> @endif
        @if($company && $company->cell_no) <div><i class="bi bi-telephone"></i> {{ $company->cell_no }}</div> @endif
        @if($company && $company->email) <div><i class="bi bi-envelope"></i> {{ $company->email }}</div> @endif
        @if($company && $company->website) <div><i class="bi bi-globe"></i> {{ $company->website }}</div> @endif
        <div><b>Printed:</b> {{ now()->format('d M, Y H:i') }}</div>
        @if($from || $to)
            <div>
                <b>Date Range:</b>
                @if($from && $to)
                    {{ \Carbon\Carbon::parse($from)->format('d M, Y') }} to {{ \Carbon\Carbon::parse($to)->format('d M, Y') }}
                @elseif($from)
                    From {{ \Carbon\Carbon::parse($from)->format('d M, Y') }}
                @elseif($to)
                    Up to {{ \Carbon\Carbon::parse($to)->format('d M, Y') }}
                @endif
            </div>
        @endif
    </div>
</div>
<div class="no-print">
    <button onclick="window.print()" style="padding:8px 24px; font-size:1rem; background:#b71c1c; color:#fff; border:none; border-radius:6px; cursor:pointer;"><i class="bi bi-printer"></i> Print</button>
</div>
<div class="section-title">Dashboard Summary</div>
<div class="dashboard-row">
    <div class="dashboard-stat">
        <span class="icon"><i class="bi bi-people-fill"></i></span>
        <div>
            <div class="label">Suppliers</div>
            <div class="value">{{ $suppliersCount ?? '0' }}</div>
        </div>
    </div>
    <div class="dashboard-stat">
        <span class="icon"><i class="bi bi-person-badge"></i></span>
        <div>
            <div class="label">Customers</div>
            <div class="value">{{ $customersCount ?? '0' }}</div>
        </div>
    </div>
    <div class="dashboard-stat">
        <span class="icon"><i class="bi bi-person-lines-fill"></i></span>
        <div>
            <div class="label">Shopkeepers</div>
            <div class="value">{{ $shopkeepersCount ?? '0' }}</div>
        </div>
    </div>
    <div class="dashboard-stat">
        <span class="icon"><i class="bi bi-truck"></i></span>
        <div>
            <div class="label">Distributors</div>
            <div class="value">{{ $distributorsCount ?? '0' }}</div>
        </div>
    </div>
</div>
<!-- Financial Cards Grid: 4 per row -->
<div class="dashboard-cards-print" style="display: flex; flex-wrap: wrap; gap: 18px 0; margin-top: 24px;">
    <div class="dashboard-card-print">
        <div class="card dashboard-stat text-center border-0" style="background: linear-gradient(135deg, #e0f7fa 60%, #b2ebf2 100%);">
            <div class="card-body">
                <div class="icon text-success"><i class="bi bi-cash-stack"></i></div>
                <div class="label">Total Sales</div>
                <div class="value">Rs. {{ number_format($totalSales, 2) }}</div>
            </div>
        </div>
    </div>
    <div class="dashboard-card-print">
        <div class="card dashboard-stat text-center border-0" style="background: linear-gradient(135deg, #e3fcec 60%, #b2f2bb 100%);">
            <div class="card-body">
                <div class="icon text-primary"><i class="bi bi-currency-exchange"></i></div>
                <div class="label">Payments Received</div>
                <div class="value">Rs. {{ number_format($paymentsReceived, 2) }}</div>
            </div>
        </div>
    </div>
    <div class="dashboard-card-print">
        <div class="card dashboard-stat text-center border-0" style="background: linear-gradient(135deg, #fffbe7 60%, #ffe082 100%);">
            <div class="card-body">
                <div class="icon text-warning"><i class="bi bi-hourglass-split"></i></div>
                <div class="label">Pending Balance</div>
                <div class="value">Rs. {{ number_format($pendingBalance, 2) }}</div>
            </div>
        </div>
    </div>
    <div class="dashboard-card-print">
        <div class="card dashboard-stat text-center border-0" style="background: linear-gradient(135deg, #ffeaea 60%, #ffbaba 100%);">
            <div class="card-body">
                <div class="icon text-danger"><i class="bi bi-bag-check"></i></div>
                <div class="label">Total Purchases</div>
                <div class="value">Rs. {{ number_format($totalPurchases, 2) }}</div>
            </div>
        </div>
    </div>
    <div class="dashboard-card-print">
        <div class="card dashboard-stat text-center border-0" style="background: linear-gradient(135deg, #f3e5f5 60%, #ce93d8 100%);">
            <div class="card-body">
                <div class="icon text-info"><i class="bi bi-box-seam"></i></div>
                <div class="label">Inventory Items</div>
                <div class="value">{{ $inventoryCount }}</div>
            </div>
        </div>
    </div>
    <div class="dashboard-card-print">
        <div class="card dashboard-stat text-center border-0" style="background: linear-gradient(135deg, #ffdde1 0%, #ee9ca7 100%);">
            <div class="card-body">
                <div class="icon text-danger"><i class="bi bi-arrow-counterclockwise"></i></div>
                <div class="label">Return Amount</div>
                <div class="value">Rs. {{ number_format($totalReturns ?? 0, 2) }}</div>
            </div>
        </div>
    </div>
    <div class="dashboard-card-print">
        <div class="card dashboard-stat text-center border-0" style="background: linear-gradient(135deg, #ffeaea 60%, #ffbaba 100%);">
            <div class="card-body">
                <div class="icon text-danger"><i class="bi bi-wallet2"></i></div>
                <div class="label">Total Expenses</div>
                <div class="value">Rs. {{ number_format($totalExpenses, 2) }}</div>
            </div>
        </div>
    </div>
    <div class="dashboard-card-print">
        <div class="card dashboard-stat text-center border-0" style="background: linear-gradient(135deg, #e3fcec 60%, #b2f2bb 100%);">
            <div class="card-body">
                <div class="icon text-success"><i class="bi bi-graph-up-arrow"></i></div>
                <div class="label">Gross Profit</div>
                <div class="value">Rs. {{ number_format($grossProfit, 2) }}</div>
            </div>
        </div>
    </div>
    <div class="dashboard-card-print">
        <div class="card dashboard-stat text-center border-0" style="background: linear-gradient(135deg, #fffde7 60%, #fff9c4 100%);">
            <div class="card-body">
                <div class="icon text-success"><i class="bi bi-cash-coin"></i></div>
                <div class="label">Net Profit</div>
                <div class="value">Rs. {{ number_format($netProfit, 2) }}</div>
            </div>
        </div>
    </div>
    <div class="dashboard-card-print">
        <div class="card dashboard-stat text-center border-0" style="background: linear-gradient(135deg, #f3e5f5 60%, #ce93d8 100%);">
            <div class="card-body">
                <div class="icon text-secondary"><i class="bi bi-journal-minus"></i></div>
                <div class="label">Accounts Payable (PKR)</div>
                <div class="value">Rs. {{ number_format($accountsPayablePKR, 2) }}</div>
            </div>
        </div>
    </div>
</div>
<!-- Financial Overview Chart for Print -->
<div style="margin: 40px 0 0 0; text-align: center;">
    <div style="font-size: 1.2rem; color: #b71c1c; font-weight: bold; margin-bottom: 10px;">Financial Overview</div>
    <canvas id="financeChartPrint" width="700" height="220" style="max-width:100%;"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('financeChartPrint').getContext('2d');
    var chartColors = [
        'rgba(25, 135, 84, 0.85)',
        'rgba(0, 123, 255, 0.85)',
        'rgba(13, 110, 253, 0.85)',
        'rgba(255, 193, 7, 0.85)',
        'rgba(220, 53, 69, 0.85)'
    ];
    var borderColors = [
        'rgba(25, 135, 84, 1)',
        'rgba(0, 123, 255, 1)',
        'rgba(13, 110, 253, 1)',
        'rgba(255, 193, 7, 1)',
        'rgba(220, 53, 69, 1)'
    ];
    var chartLabels = ['Internal Sales', 'External Sales', 'Internal Purchases', 'External Purchases', 'Expenses'];
    var chartData = [
        {{ $totalInternalSales }},
        {{ $totalExternalSales }},
        {{ $totalInternalPurchases }},
        {{ $totalExternalPurchases }},
        {{ $totalExpenses }}
    ];
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Amount (Rs.)',
                data: chartData,
                backgroundColor: chartColors,
                borderColor: borderColors,
                borderWidth: 2,
                borderRadius: 14,
                maxBarThickness: 48,
            }]
        },
        options: {
            responsive: false,
            layout: { padding: { top: 40 } },
            plugins: {
                legend: { display: false },
                datalabels: {
                    anchor: 'end',
                    align: 'end',
                    offset: 8,
                    color: '#222',
                    font: { weight: 'bold', size: 13 },
                    formatter: function(value) {
                        return 'Rs. ' + value.toLocaleString();
                    }
                }
            },
            animation: false,
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#b71c1c', font: { weight: 'bold' } }
                },
                y: {
                    grid: { color: '#eee', borderDash: [4,4] },
                    ticks: { color: '#888', callback: value => 'Rs. ' + value.toLocaleString() }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
});
</script>
<style>
.dashboard-cards-print {
    margin-top: 10px;
    margin-bottom: 10px;
}
.dashboard-card-print {
    flex: 0 0 25%;
    max-width: 25%;
    padding: 4px 8px;
    box-sizing: border-box;
}
@media print, (max-width: 900px) {
    .dashboard-card-print {
        flex: 0 0 25%;
        max-width: 25%;
    }
}
@media (max-width: 600px) {
    .dashboard-card-print {
        flex: 0 0 50%;
        max-width: 50%;
    }
}
</style>
</body>
</html> 