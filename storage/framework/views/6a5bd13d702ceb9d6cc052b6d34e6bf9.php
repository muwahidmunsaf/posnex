<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Invoice - <?php echo e($company->name); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #fff; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2.5px solid #b71c1c; padding: 24px 32px 12px 32px; }
        .header-left { display: flex; align-items: center; }
        .logo { height: 60px; margin-right: 18px; }
        .company-name { font-size: 2rem; font-weight: bold; color: #b71c1c; }
        .company-details { text-align: right; font-size: 1rem; color: #333; line-height: 1.7; }
        .company-details i { color: #b71c1c; margin-right: 4px; }
        .summary-row { display: flex; justify-content: flex-start; align-items: center; gap: 32px; margin: 24px 0 0 32px; }
        .summary-row span { font-weight: bold; font-size: 1.08rem; color: #b71c1c; margin-right: 12px; }
        .summary-row .value { color: #222; font-weight: normal; margin-right: 24px; }
        .amount-due { text-align: right; font-size: 1.5rem; font-weight: bold; color: #888; margin: 0 32px 0 0; }
        .amount-due strong { color: #b71c1c; }
        .to-block { margin: 18px 0 0 32px; font-size: 1.05rem; }
        .to-block b { color: #b71c1c; }
        .to-block .label { font-weight: bold; }
        .to-block .value { color: #222; }
        .table-container { margin: 24px 32px 0 32px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 0; }
        th, td { border: 1.5px solid #b71c1c; padding: 8px 12px; font-size: 1rem; }
        th { background: #b71c1c; color: #fff; font-weight: bold; text-align: center; }
        td { text-align: center; }
        tr.total-row td { font-weight: bold; background: #f3e5e5; }
        .totals-block { width: 350px; float: right; margin: 18px 32px 0 0; font-size: 1.05rem; }
        .totals-block table { width: 100%; border: none; }
        .totals-block td { border: none; padding: 4px 0; text-align: right; }
        .totals-block .label { color: #333; }
        .totals-block .value { color: #222; }
        .totals-block .grand { font-weight: bold; color: #b71c1c; font-size: 1.13rem; }
        .terms { clear: both; margin: 48px 32px 0 32px; font-size: 0.98rem; color: #b71c1c; }
        .stamp {
            display: block;
            margin: 32px auto 0 auto;
            width: 120px; height: 120px;
            border: 4px solid #b71c1c;
            border-radius: 50%;
            color: #b71c1c;
            font-weight: bold;
            font-size: 1.1rem;
            text-align: center;
            line-height: 120px;
            letter-spacing: 2px;
            opacity: 0.8;
            background: #fff;
            box-shadow: 0 0 8px #b71c1c33;
        }
        .thankyou { text-align: center; font-size: 1.1rem; color: #b71c1c; margin-top: 32px; font-weight: bold; letter-spacing: 1px; }
        @media print {
            .no-print { display: none !important; }
            body { background: #fff !important; }
            .header { border-bottom: 2.5px solid #b71c1c !important; }
            .totals-block { float: none; margin: 18px auto 0 auto; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <?php if($company->logo): ?>
                <img src="<?php echo e(asset('storage/' . $company->logo)); ?>" class="logo" alt="Company Logo">
            <?php endif; ?>
            <span class="company-name"><?php echo e($company->name); ?></span>
        </div>
        <div class="company-details">
            <?php if($company->address): ?> <div><i class="bi bi-geo-alt"></i> <?php echo e($company->address); ?></div> <?php endif; ?>
            <?php if($company->cell_no): ?> <div><i class="bi bi-telephone"></i> <?php echo e($company->cell_no); ?></div> <?php endif; ?>
            <?php if($company->email): ?> <div><i class="bi bi-envelope"></i> <?php echo e($company->email); ?></div> <?php endif; ?>
            <?php if($company->website): ?> <div><i class="bi bi-globe"></i> <?php echo e($company->website); ?></div> <?php endif; ?>
        </div>
    </div>
    <div class="summary-row" style="margin: 24px 32px 0 32px; justify-content: space-between; white-space: nowrap; gap: 16px;">
        <span style="white-space: nowrap;"><span style="margin-right:2px; font-weight:bold; color:#b71c1c;">Invoice Date:</span><span class="value"><?php echo e(\Carbon\Carbon::parse($purchase->purchase_date)->format('d-M-Y')); ?></span></span>
        <span style="white-space: nowrap;"><span style="margin-right:2px; font-weight:bold; color:#b71c1c;">Issue Date:</span><span class="value"><?php echo e(\Carbon\Carbon::parse($purchase->created_at)->format('d-M-Y')); ?></span></span>
        <span style="white-space: nowrap;"><span style="margin-right:2px; font-weight:bold; color:#b71c1c;">Invoice No:</span><span class="value">D<?php echo e(str_pad($purchase->id, 3, '0', STR_PAD_LEFT)); ?>-<?php echo e(str_pad($purchase->id, 5, '0', STR_PAD_LEFT)); ?></span></span>
    </div>
    <!-- Add Purchase Invoice Title -->
    <div style="text-align:center; margin-top:24px; margin-bottom:8px;">
        <span style="font-size:2rem; font-weight:bold; color:#b71c1c; letter-spacing:1px;">Purchase Invoice</span>
    </div>
    <div class="to-block">
        <b>TO</b><br>
        <span class="label">Name:</span> <span class="value"><?php echo e($purchase->supplier->supplier_name ?? '-'); ?></span><br>
        <span class="label">Phone:</span> <span class="value"><?php echo e($purchase->supplier->cell_no ?? '-'); ?></span><br>
        <span class="label">Address:</span> <span class="value"><?php echo e($purchase->supplier->address ?? '-'); ?></span><br>
        <span class="label">Country:</span> <span class="value"><?php echo e($purchase->supplier->country ?? '-'); ?></span><br>
        <?php if($purchase->distributor && isset($purchase->distributor->name)): ?>
        <span class="label">Distributor:</span> <span class="value"><?php echo e($purchase->distributor->name); ?></span><br>
        <?php endif; ?>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Item Descriptions</th>
                    <th>Rate</th>
                    <th>Qty</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php $grandTotal = 0; $totalQty = 0; ?>
                <?php $__currentLoopData = $purchase->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $total = $item->purchase_amount; $grandTotal += $total; $totalQty += $item->quantity; ?>
                    <tr>
                        <td><?php echo e($i+1); ?></td>
                        <td style="text-align:left;">
                            <b><?php echo e($item->inventory->item_name ?? '-'); ?></b>
                            <?php $details = trim($item->inventory->details ?? ''); ?>
                            <?php if($details && strtolower($details) !== 'n/a'): ?>
                                <div style="font-weight:normal; font-size:1.05em; margin-top:2px;">
                                    <?php echo e($details); ?>

                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo e($purchase->supplier->currency['symbol']); ?> <?php echo e(number_format($item->purchase_amount / max($item->quantity,1), 2)); ?> (<?php echo e($purchase->supplier->currency['code']); ?>)
                        </td>
                        <td><?php echo e($item->quantity); ?></td>
                        <td>
                            <?php echo e($purchase->supplier->currency['symbol']); ?> <?php echo e(number_format($total, 2)); ?> (<?php echo e($purchase->supplier->currency['code']); ?>)
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr class="total-row">
                    <td colspan="3" style="text-align:right;">Total</td>
                    <td><?php echo e($totalQty); ?></td>
                    <td>
                        <?php echo e($purchase->supplier->currency['symbol']); ?> <?php echo e(number_format($grandTotal, 2)); ?> (<?php echo e($purchase->supplier->currency['code']); ?>)
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="totals-block" style="float: right; margin: 18px 32px 0 0;">
        <table>
            <tr>
                <td class="label">Sub Total</td>
                <td class="value">
                    <?php echo e($purchase->supplier->currency['symbol']); ?> <?php echo e(number_format($grandTotal, 2)); ?> (<?php echo e($purchase->supplier->currency['code']); ?>)
                </td>
            </tr>
            <?php if($purchase->supplier->currency['code'] !== 'PKR'): ?>
            <tr>
                <td class="label">Sub Total (PKR)</td>
                <td class="value">
                    Rs <?php echo e(number_format($purchase->pkr_amount, 2)); ?> (PKR)
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <td class="label">Previous Payable</td>
                <td class="value">
                    <?php echo e($purchase->supplier->currency['symbol']); ?> <?php echo e(number_format($previousPayable, 2)); ?> (<?php echo e($purchase->supplier->currency['code']); ?>)
                </td>
            </tr>
            <tr>
                <td class="grand">Grand Total</td>
                <td class="grand">
                    <?php echo e($purchase->supplier->currency['symbol']); ?> <?php echo e(number_format($grandTotalWithPrevious, 2)); ?> (<?php echo e($purchase->supplier->currency['code']); ?>)
                </td>
            </tr>
            <?php if($purchase->supplier->currency['code'] !== 'PKR'): ?>
            <tr>
                <td class="grand">Grand Total (PKR)</td>
                <td class="grand">
                    Rs <?php echo e(number_format($grandTotalWithPrevious * $purchase->exchange_rate_to_pkr, 2)); ?> (PKR)
                </td>
            </tr>
            <tr>
                <td class="label">Conversion Rate</td>
                <td class="value">
                    1 <?php echo e($purchase->supplier->currency['code']); ?> = <?php echo e(number_format($purchase->exchange_rate_to_pkr, 4)); ?> PKR
                </td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
    <div style="clear:both;"></div>
    <div class="terms">
        <b>Terms & Conditions:</b> This is a computer-generated invoice and does not require a signature.
    </div>
    <div class="thankyou">Thank you for your business!</div>
    <div class="no-print" style="text-align:center; margin-bottom:32px;">
        <button onclick="window.print()" style="padding:10px 32px; font-size:1.1rem; background:#b71c1c; color:#fff; border:none; border-radius:6px; cursor:pointer;">Print</button>
    </div>
</body>
</html> <?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/purchases/print.blade.php ENDPATH**/ ?>