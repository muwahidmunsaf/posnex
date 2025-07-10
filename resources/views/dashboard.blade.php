@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        {{-- Removed backup/restore buttons from dashboard --}}
        <div class="mb-5">
            <h2 class="fw-bold text-dark">📊 Daisho Gold Dashboard</h2>
            <p class="text-muted">Welcome back, <strong>{{ auth()->user()->name }}</strong>! Here’s a quick overview of your
                company’s performance.</p>
        </div>

        <div class="row g-4">
            {{-- Total Sales --}}
            <div class="col-md-3">
                <div class="card shadow-sm border-start border-success border-4 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-cash-stack fs-4 text-success me-2"></i>
                            <h6 class="text-muted mb-0">Total Sales</h6>
                        </div>
                        <h4 class="fw-bold text-success">Rs. {{ number_format($totalSales, 2) }}</h4>
                    </div>
                </div>
            </div>

            {{-- Total Purchases --}}
            <div class="col-md-3">
                <div class="card shadow-sm border-start border-danger border-4 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-bag-check fs-4 text-danger me-2"></i>
                            <h6 class="text-muted mb-0">Total Purchases</h6>
                        </div>
                        <h4 class="fw-bold text-danger">Rs. {{ number_format($totalPurchases, 2) }}</h4>
                    </div>
                </div>
            </div>

            {{-- Total Expenses --}}
            <div class="col-md-3">
                <div class="card shadow-sm border-start border-danger border-4 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-wallet2 fs-4 text-danger me-2"></i>
                            <h6 class="text-muted mb-0">Total Expenses</h6>
                        </div>
                        <h4 class="fw-bold text-danger">Rs. {{ number_format($totalExpenses, 2) }}</h4>
                    </div>
                </div>
            </div>

            {{-- Inventory Count --}}
            <div class="col-md-3">
                <div class="card shadow-sm border-start border-warning border-4 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-boxes fs-4 text-warning me-2"></i>
                            <h6 class="text-muted mb-0">Inventory Items</h6>
                        </div>
                        <h4 class="fw-bold text-warning">{{ $inventoryCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <h4 class="mb-3">Financial Overview</h4>
            <canvas id="financeChart" height="120"></canvas>
        </div>

    </div>
    @push('scripts')
        <script>
            const ctx = document.getElementById('financeChart').getContext('2d');

            const financeChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Internal Sales', 'External Sales', 'Internal Purchases', 'External Purchases',
                        'Expenses'],
                    datasets: [{
                        label: 'Amount (Rs.)',
                        data: [
                            {{ $totalInternalSales }},
                            {{ $totalExternalSales }},
                            {{ $totalInternalPurchases }},
                            {{ $totalExternalPurchases }},
                            {{ $totalExpenses }}
                        ],
                        backgroundColor: [
                            'rgba(25, 135, 84, 0.8)',
                            'rgba(0, 123, 255, 0.8)',
                            'rgba(13, 110, 253, 0.8)',
                            'rgba(255, 193, 7, 0.8)',
                            'rgba(220, 53, 69, 0.8)'
                        ],
                        borderColor: [
                            'rgba(25, 135, 84, 1)',
                            'rgba(0, 123, 255, 1)',
                            'rgba(13, 110, 253, 1)',
                            'rgba(255, 193, 7, 1)',
                            'rgba(220, 53, 69, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rs. ' + context.formattedValue;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rs. ' + value;
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
