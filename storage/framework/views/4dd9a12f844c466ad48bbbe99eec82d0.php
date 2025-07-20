<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Suppliers Report</title>
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
        .suppliers-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .suppliers-table th, .suppliers-table td { border: 1.5px solid #b71c1c; padding: 8px; }
        .suppliers-table th { background: #f3e5e5; color: #b71c1c; font-weight: bold; }
        .suppliers-table td { color: #222; }
        .no-print { display: block; margin: 24px 0 0 0; text-align: right; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <?php if($company && $company->logo): ?>
                <img src="<?php echo e(asset('storage/' . $company->logo)); ?>" class="logo" alt="Company Logo">
            <?php endif; ?>
            <span class="company-name"><?php echo e($company->name ?? ''); ?></span>
        </div>
        <div class="company-details">
            <?php if($company && $company->address): ?> <div><i class="bi bi-geo-alt"></i> <?php echo e($company->address); ?></div> <?php endif; ?>
            <?php if($company && $company->cell_no): ?> <div><i class="bi bi-telephone"></i> <?php echo e($company->cell_no); ?></div> <?php endif; ?>
            <?php if($company && $company->email): ?> <div><i class="bi bi-envelope"></i> <?php echo e($company->email); ?></div> <?php endif; ?>
            <?php if($company && $company->website): ?> <div><i class="bi bi-globe"></i> <?php echo e($company->website); ?></div> <?php endif; ?>
        </div>
    </div>
    <div class="no-print">
        <button onclick="window.print()" style="padding:10px 32px; font-size:1.1rem; background:#b71c1c; color:#fff; border:none; border-radius:6px; cursor:pointer;"><i class="bi bi-printer"></i> Print</button>
    </div>
    <div class="section-title">All Suppliers Report</div>
    <?php if(!empty($from) || !empty($to)): ?>
        <div style="text-align:center; font-size: 1em; color: #555; margin-bottom: 12px;">
            <?php if($from && $to): ?>
                From <?php echo e(\Carbon\Carbon::parse($from)->format('d M, Y')); ?> to <?php echo e(\Carbon\Carbon::parse($to)->format('d M, Y')); ?>

            <?php elseif($from): ?>
                From <?php echo e(\Carbon\Carbon::parse($from)->format('d M, Y')); ?>

            <?php elseif($to): ?>
                Up to <?php echo e(\Carbon\Carbon::parse($to)->format('d M, Y')); ?>

            <?php endif; ?>
        </div>
    <?php endif; ?>
    <table class="suppliers-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Country</th>
                <th>Total Purchase</th>
                <th>Total Paid</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $supplierSummaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($s['name']); ?></td>
                    <td><?php echo e($s['country']); ?></td>
                    <td><?php echo e($s['currency_symbol']); ?> <?php echo e(number_format($s['total_purchase'], 2)); ?> <span class="text-muted">(<?php echo e($s['currency_code']); ?>)</span></td>
                    <td><?php echo e($s['currency_symbol']); ?> <?php echo e(number_format($s['total_paid'], 2)); ?> <span class="text-muted">(<?php echo e($s['currency_code']); ?>)</span></td>
                    <td><?php echo e($s['currency_symbol']); ?> <?php echo e(number_format($s['balance'], 2)); ?> <span class="text-muted">(<?php echo e($s['currency_code']); ?>)</span></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr style="font-weight:bold; background:#f3e5e5; color:#b71c1c;">
                <td colspan="2" style="text-align:right;">Total (PKR):</td>
                <td>Rs <?php echo e(number_format($totalPurchase, 2)); ?></td>
                <td>Rs <?php echo e(number_format($totalPaid, 2)); ?></td>
                <td>Rs <?php echo e(number_format($totalBalance, 2)); ?></td>
            </tr>
        </tbody>
    </table>
    <?php if($company && $company->logo): ?>
    <div style="position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); z-index:0; opacity:0.07; pointer-events:none; width:60vw; max-width:600px;">
        <img src="<?php echo e(asset('storage/' . $company->logo)); ?>" alt="Watermark Logo" style="width:100%; height:auto;">
    </div>
    <?php endif; ?>
</body>
</html> <?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/suppliers/print_all.blade.php ENDPATH**/ ?>