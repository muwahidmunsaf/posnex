<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3">
                <span style="font-size:2.2rem; background: linear-gradient(135deg, #ffbaba 40%, #b2ebf2 100%); border-radius:10px; padding:8px; color:#fff; display:inline-flex; align-items:center;"><i class="bi bi-bar-chart-fill" style="color:#b71c1c;"></i></span>
                <div>
                    <h2 class="fw-bold mb-1" style="font-size:2.1rem;color:#b71c1c;"><?php echo e($companyName); ?> Dashboard</h2>
                    <div class="text-muted" style="font-size:1.1rem;">Welcome back, <strong><?php echo e(auth()->user()->name); ?></strong>! Here’s a quick overview of your company’s performance.</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-light border shadow-sm me-2" data-bs-toggle="modal" data-bs-target="#dateFilterModal" title="Filter by Date" style="font-size:1.3rem;"><i class="bi bi-funnel-fill"></i></button>
                <a href="<?php echo e(route('dashboard.print', request()->only(['from','to']))); ?>" target="_blank" class="btn btn-light border shadow-sm" title="Print Dashboard" style="font-size:1.3rem;"><i class="bi bi-printer"></i></a>
            </div>
        </div>
        <!-- Date Filter Modal -->
        <div class="modal fade" id="dateFilterModal" tabindex="-1" aria-labelledby="dateFilterModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <form method="GET" id="dashboard-date-filter-form">
                <div class="modal-header">
                  <h5 class="modal-title" id="dateFilterModalLabel"><i class="bi bi-funnel-fill text-primary"></i> Filter by Date Range</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex gap-3 align-items-end">
                  <div>
                    <label for="from" class="form-label mb-1"><i class="bi bi-calendar-date"></i> From</label>
                    <input type="date" name="from" id="from" class="form-control form-control-sm" value="<?php echo e(request('from')); ?>">
                  </div>
                  <div>
                    <label for="to" class="form-label mb-1"><i class="bi bi-calendar-date"></i> To</label>
                    <input type="date" name="to" id="to" class="form-control form-control-sm" value="<?php echo e(request('to')); ?>">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i> Filter</button>
                  <button type="button" class="btn btn-secondary ms-2" id="clear-date-filter">Clear Filter</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php if(request('from') || request('to')): ?>
            <div class="mb-3" style="font-size:1.1em; color:#555;">
                <strong>Date Range:</strong>
                <?php if(request('from') && request('to')): ?>
                    <?php echo e(\Carbon\Carbon::parse(request('from'))->format('d M, Y')); ?> to <?php echo e(\Carbon\Carbon::parse(request('to'))->format('d M, Y')); ?>

                <?php elseif(request('from')): ?>
                    From <?php echo e(\Carbon\Carbon::parse(request('from'))->format('d M, Y')); ?>

                <?php elseif(request('to')): ?>
                    Up to <?php echo e(\Carbon\Carbon::parse(request('to'))->format('d M, Y')); ?>

                <?php endif; ?>
            </div>
        <?php endif; ?>
        <style>
            .dashboard-row {
                display: flex;
                flex-wrap: wrap;
                gap: 18px;
                margin-bottom: 24px;
            }
            .dashboard-stat {
                flex: 1 1 180px;
                min-width: 180px;
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 1px 6px rgba(0,0,0,0.06);
                display: flex;
                align-items: center;
                padding: 12px 18px;
                border-left: 5px solid #b71c1c;
                transition: box-shadow 0.2s, transform 0.2s;
                height: 70px;
            }
            .dashboard-stat:hover {
                box-shadow: 0 4px 16px rgba(0,0,0,0.10);
                transform: translateY(-2px) scale(1.01);
            }
            .dashboard-stat .icon {
                font-size: 1.7rem;
                margin-right: 12px;
                color: #b71c1c;
            }
            .dashboard-stat .label {
                font-size: 0.98rem;
                color: #888;
                font-weight: 500;
            }
            .dashboard-stat .value {
                font-size: 1.25rem;
                font-weight: bold;
                color: #222;
            }
            @media (max-width: 900px) {
                .dashboard-row { flex-direction: column; gap: 12px; }
            }
            .dashboard-card {
                border-radius: 12px;
                box-shadow: 0 1px 8px rgba(0,0,0,0.06);
                transition: box-shadow 0.2s, transform 0.2s;
                background: #f9fafb;
                border: none;
                min-height: 110px;
                cursor: pointer;
                padding: 0;
            }
            .dashboard-card:hover {
                box-shadow: 0 4px 16px rgba(0,0,0,0.10);
                transform: translateY(-2px) scale(1.01);
            }
            .dashboard-card .icon {
                font-size: 1.7rem;
                margin-bottom: 6px;
            }
            .dashboard-card .label {
                font-size: 0.98rem;
                color: #888;
                font-weight: 500;
                margin-bottom: 2px;
            }
            .dashboard-card .value {
                font-size: 1.35rem;
                font-weight: bold;
                color: #222;
            }
        </style>

        <!-- Quick Stats Row Modernized -->
        <div class="dashboard-row mb-4" style="gap:14px; display:flex; flex-wrap:wrap; justify-content:space-between;">
            <a href="<?php echo e(route('suppliers.index')); ?>" class="dashboard-stat text-decoration-none flex-grow-1 flex-basis-0" style="min-width:120px;">
                <span class="icon"><i class="bi bi-people-fill"></i></span>
                <div>
                    <div class="label">Suppliers</div>
                    <div class="value"><?php echo e($suppliersCount ?? '0'); ?></div>
                </div>
            </a>
            <a href="<?php echo e(route('distributors.index')); ?>" class="dashboard-stat text-decoration-none flex-grow-1 flex-basis-0" style="min-width:120px;">
                <span class="icon"><i class="bi bi-truck"></i></span>
                <div>
                    <div class="label">Distributors</div>
                    <div class="value"><?php echo e($distributorsCount ?? '0'); ?></div>
                </div>
            </a>
            <a href="<?php echo e(route('shopkeepers.index')); ?>" class="dashboard-stat text-decoration-none flex-grow-1 flex-basis-0" style="min-width:120px;">
                <span class="icon"><i class="bi bi-person-lines-fill"></i></span>
                <div>
                    <div class="label">Shopkeepers</div>
                    <div class="value"><?php echo e($shopkeepersCount ?? '0'); ?></div>
                </div>
            </a>
            <a href="<?php echo e(route('customers.index')); ?>" class="dashboard-stat text-decoration-none flex-grow-1 flex-basis-0" style="min-width:120px;">
                <span class="icon"><i class="bi bi-person-badge"></i></span>
                <div>
                    <div class="label">Customers</div>
                    <div class="value"><?php echo e($customersCount ?? '0'); ?></div>
                </div>
            </a>
        </div>
        <!-- Main Financial Cards -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
            <div class="col">
                <a href="<?php echo e(route('sales.index')); ?>" class="card dashboard-card text-center border-0 text-decoration-none" style="background: linear-gradient(135deg, #e0f7fa 60%, #b2ebf2 100%);">
                    <div class="card-body">
                        <div class="icon text-success"><i class="bi bi-cash-stack"></i></div>
                        <div class="label">Total Sales</div>
                        <div class="value">Rs. <?php echo e(number_format($totalSales, 2)); ?></div>
                    </div>
                </a>
                        </div>
            <div class="col">
                <a href="<?php echo e(route('sales.index')); ?>" class="card dashboard-card text-center border-0 text-decoration-none" style="background: linear-gradient(135deg, #e3fcec 60%, #b2f2bb 100%);">
                    <div class="card-body">
                        <div class="icon text-primary"><i class="bi bi-currency-exchange"></i></div>
                        <div class="label">Payments Received</div>
                        <div class="value">Rs. <?php echo e(number_format($paymentsReceived, 2)); ?></div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="<?php echo e(route('sales.index')); ?>" class="card dashboard-card text-center border-0 text-decoration-none" style="background: linear-gradient(135deg, #fffbe7 60%, #ffe082 100%);">
                    <div class="card-body">
                        <div class="icon text-warning"><i class="bi bi-hourglass-split"></i></div>
                        <div class="label">Pending Balance</div>
                        <div class="value">Rs. <?php echo e(number_format($pendingBalance, 2)); ?></div>
                </div>
                </a>
            </div>
            <div class="col">
                <a href="<?php echo e(route('purchase.index')); ?>" class="card dashboard-card text-center border-0 text-decoration-none" style="background: linear-gradient(135deg, #ffeaea 60%, #ffbaba 100%);">
                    <div class="card-body">
                        <div class="icon text-danger"><i class="bi bi-bag-check"></i></div>
                        <div class="label">Total Purchases (PKR)</div>
                        <div class="value">Rs. <?php echo e(number_format($totalPurchases, 2)); ?></div>
                    </div>
                </a>
                        </div>
            <div class="col">
                <div class="card dashboard-card text-center border-0" style="background: linear-gradient(135deg, #f3e5f5 60%, #ce93d8 100%);">
                    <div class="card-body">
                        <div class="icon text-info"><i class="bi bi-box-seam"></i></div>
                        <div class="label">Inventory Items</div>
                        <div class="value"><?php echo e($inventoryCount); ?></div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card dashboard-card text-center border-0" style="background: linear-gradient(135deg, #ffdde1 0%, #ee9ca7 100%);">
                    <div class="card-body">
                        <div class="icon text-danger"><i class="bi bi-arrow-counterclockwise"></i></div>
                        <div class="label">Return Amount</div>
                        <div class="value">Rs. <?php echo e(number_format($totalReturns ?? 0, 2)); ?></div>
                    </div>
                </div>
            </div>
            <div class="col">
                <a href="<?php echo e(route('expenses.index')); ?>" class="card dashboard-card text-center border-0 text-decoration-none" style="background: linear-gradient(135deg, #ffeaea 60%, #ffbaba 100%);">
                    <div class="card-body">
                        <div class="icon text-danger"><i class="bi bi-wallet2"></i></div>
                        <div class="label">Total Expenses</div>
                        <div class="value">Rs. <?php echo e(number_format($totalExpenses, 2)); ?></div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="<?php echo e(route('reports.finance')); ?>" class="card dashboard-card text-center border-0 text-decoration-none" style="background: linear-gradient(135deg, #e3fcec 60%, #b2f2bb 100%);">
                    <div class="card-body">
                        <div class="icon text-success"><i class="bi bi-graph-up-arrow"></i></div>
                        <div class="label">Gross Profit</div>
                        <div class="value">Rs. <?php echo e(number_format($grossProfit, 2)); ?></div>
                    </div>
                </a>
                        </div>
            <div class="col">
                <a href="<?php echo e(route('reports.finance')); ?>" class="card dashboard-card text-center border-0 text-decoration-none" style="background: linear-gradient(135deg, #fffde7 60%, #fff9c4 100%);">
                    <div class="card-body">
                        <div class="icon text-success"><i class="bi bi-cash-coin"></i></div>
                        <div class="label">Net Profit</div>
                        <div class="value">Rs. <?php echo e(number_format($netProfit, 2)); ?></div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="<?php echo e(route('suppliers.index')); ?>" class="card dashboard-card text-center border-0 text-decoration-none" style="background: linear-gradient(135deg, #f3e5f5 60%, #ce93d8 100%);">
                    <div class="card-body">
                        <div class="icon text-secondary"><i class="bi bi-journal-minus"></i></div>
                        <div class="label">Accounts Payable (PKR)</div>
                        <div class="value">Rs. <?php echo e(number_format($accountsPayablePKR, 2)); ?></div>
                </div>
                </a>
            </div>
        </div>
        <div class="mt-5">
            <div class="card shadow-lg border-0" style="border-radius: 22px;">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <span class="me-2" style="font-size:2rem; background: linear-gradient(135deg, #ffbaba 40%, #b2ebf2 100%); border-radius:8px; padding:8px; color:#fff;"><i class="bi bi-bar-chart-fill" style="color:#b71c1c;"></i></span>
                        <h4 class="mb-0 fw-bold" style="color:#b71c1c;">Financial Overview</h4>
                    </div>
            <canvas id="financeChart" height="120"></canvas>
                    <div id="financeChartLegend" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
        <script>
            const ctx = document.getElementById('financeChart').getContext('2d');
            const chartColors = [
                'rgba(25, 135, 84, 0.85)',
                'rgba(0, 123, 255, 0.85)',
                'rgba(13, 110, 253, 0.85)',
                'rgba(255, 193, 7, 0.85)',
                'rgba(220, 53, 69, 0.85)'
            ];
            const borderColors = [
                'rgba(25, 135, 84, 1)',
                'rgba(0, 123, 255, 1)',
                'rgba(13, 110, 253, 1)',
                'rgba(255, 193, 7, 1)',
                'rgba(220, 53, 69, 1)'
            ];
            const chartLabels = ['Internal Sales', 'External Sales', 'Internal Purchases', 'External Purchases', 'Expenses'];
            const chartData = [
                <?php echo e($totalInternalSales); ?>,
                <?php echo e($totalExternalSales); ?>,
                <?php echo e($totalPurchasesPKR); ?>,
                <?php echo e($totalExternalPurchases); ?>,
                <?php echo e($totalExpenses); ?>

            ];
            const financeChart = new Chart(ctx, {
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
                    responsive: true,
                    layout: { padding: { top: 40 } }, // Add top padding for value labels
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#222',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#b71c1c',
                            borderWidth: 1,
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: Rs. ${context.parsed.y.toLocaleString()}`;
                                }
                            }
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'end', // End of each bar
                            offset: 8, // Add space so label is not hidden
                            color: '#222',
                            font: { weight: 'bold', size: 13 },
                            formatter: function(value) {
                                return 'Rs. ' + value.toLocaleString();
                            }
                        }
                    },
                    animation: {
                        duration: 1200,
                        easing: 'easeOutBounce'
                    },
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
            // Custom legend
            const legendLabels = chartLabels.map((label, i) => `<span style="display:inline-block;margin-right:18px;"><span style="display:inline-block;width:14px;height:14px;background:${chartColors[i]};border-radius:3px;margin-right:6px;"></span>${label}</span>`);
            document.getElementById('financeChartLegend').innerHTML = legendLabels.join('');
        </script>
        <script>
document.addEventListener('DOMContentLoaded', function() {
    var clearBtn = document.getElementById('clear-date-filter');
    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            document.getElementById('from').value = '';
            document.getElementById('to').value = '';
            window.location.href = window.location.pathname;
        });
    }
});
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/dashboard.blade.php ENDPATH**/ ?>