<?php
    $saleType = $sale->sale_type ?? 'retail';
?>
<?php if($saleType === 'retail'): ?>
    
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt #<?php echo e($sale->id); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
            body { font-family: 'Arial', sans-serif; font-size: 12px; max-width: 80mm; margin: 0 auto; padding: 10px; }
            h4, h5 { text-align: center; }
            .table { width: 100%; margin-bottom: 10px; }
            .table th, .table td { padding: 4px; font-size: 12px; }
            .summary { margin-top: 10px; border-top: 1px dashed #000; padding-top: 5px; }
            .footer { text-align: center; font-size: 10px; border-top: 1px dashed #000; padding-top: 5px; margin-top: 10px; }
            @media print { .no-print { display: none !important; } body { width: 80mm; } }
    </style>
</head>
<body>
    <h4><?php echo e(auth()->user()->company->name ?? 'POS System'); ?></h4>
    <h5>Sale Receipt</h5>
    <p><strong>Sale ID</strong> # <?php echo e($sale->sale_code); ?><br>
        <strong>Date:</strong> <?php echo e($sale->created_at->format('d-m-Y h:i A')); ?><br>
        <strong>Created By:</strong> <?php echo e($sale->created_by); ?> <br>
        <strong>Customer:</strong> <?php echo e($sale->customer->name ?? $sale->customer_name ?? 'N/A'); ?><br>
        <?php if($sale->distributor): ?>
            <strong>Distributor:</strong> <?php echo e($sale->distributor->name); ?><br>
        <?php endif; ?>
        <?php if($sale->shopkeeper): ?>
            <strong>Shopkeeper:</strong> <?php echo e($sale->shopkeeper->name); ?><br>
        <?php endif; ?>
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
            <?php $__currentLoopData = $sale->inventorySales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($detail->item->item_name); ?></td>
                    <td><?php echo e($detail->quantity); ?></td>
                    <td><?php echo e(number_format($detail->amount, 2)); ?></td>
                    <td><?php echo e(number_format($detail->amount * $detail->quantity, 2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($externalProducts) && $externalProducts->count()): ?>
                <?php $__currentLoopData = $externalProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manual): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($manual['name']); ?></td>
                        <td><?php echo e($manual['quantity']); ?></td>
                        <td><?php echo e(number_format($manual['rate'], 2)); ?></td>
                        <td><?php echo e(number_format($manual['amount'], 2)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?php if($sale->returns && $sale->returns->count()): ?>
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
                    <?php $__currentLoopData = $sale->returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ret): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($ret->item->item_name ?? '-'); ?></td>
                            <td><?php echo e($ret->quantity); ?></td>
                            <td><?php echo e(number_format($ret->amount, 2)); ?></td>
                            <td><?php echo e($ret->reason); ?></td>
                            <td><?php echo e($ret->processed_by); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    <div class="summary">
        <p><strong>Subtotal:</strong> <?php echo e(number_format($sale->subtotal, 2)); ?></p>
        <p><strong>Tax (<?php echo e($sale->tax_percentage); ?>%):</strong> <?php echo e(number_format($sale->tax_amount, 2)); ?></p>
        <p><strong>Discount:</strong> <?php echo e(number_format($sale->discount, 2)); ?></p>
        <?php if($saleType !== 'retail'): ?>
            <p><strong>Previous Balance:</strong> <?php echo e((isset($previousOutstanding) && $previousOutstanding > 0) ? number_format($previousOutstanding, 2) : '0.00'); ?></p>
        <?php endif; ?>
        <h5><strong>Total:</strong> <?php echo e(number_format($sale->total_amount, 2)); ?></h5>
        <p><strong>Payment Method:</strong> <?php echo e(ucfirst($sale->payment_method)); ?></p>
        <?php if(isset($sale->amount_received)): ?>
            <p><strong>Amount Received:</strong> <?php echo e(number_format($sale->amount_received, 2)); ?></p>
        <?php endif; ?>
        <?php if(isset($sale->change_return)): ?>
            <p><strong>Change Returned:</strong> <?php echo e(number_format($sale->change_return, 2)); ?></p>
        <?php endif; ?>
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
        <a href="<?php echo e(route('sales.create')); ?>" class="btn btn-secondary btn-sm">Back</a>
    </div>
    </body>
    </html>
<?php else: ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sales Invoice - <?php echo e($company->name ?? (auth()->user()->company->name ?? 'POS System')); ?></title>
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
                <?php if(($company->logo ?? false) || (auth()->user()->company->logo ?? false)): ?>
                    <img src="<?php echo e(asset('storage/' . ($company->logo ?? auth()->user()->company->logo))); ?>" class="logo" alt="Company Logo">
                <?php endif; ?>
                <span class="company-name"><?php echo e($company->name ?? (auth()->user()->company->name ?? 'POS System')); ?></span>
            </div>
            <div class="company-details">
                <?php if(($company->address ?? false) || (auth()->user()->company->address ?? false)): ?> <div><i class="bi bi-geo-alt"></i> <?php echo e($company->address ?? auth()->user()->company->address); ?></div> <?php endif; ?>
                <?php if(($company->cell_no ?? false) || (auth()->user()->company->cell_no ?? false)): ?> <div><i class="bi bi-telephone"></i> <?php echo e($company->cell_no ?? auth()->user()->company->cell_no); ?></div> <?php endif; ?>
                <?php if(($company->email ?? false) || (auth()->user()->company->email ?? false)): ?> <div><i class="bi bi-envelope"></i> <?php echo e($company->email ?? auth()->user()->company->email); ?></div> <?php endif; ?>
                <?php if(($company->website ?? false) || (auth()->user()->company->website ?? false)): ?> <div><i class="bi bi-globe"></i> <?php echo e($company->website ?? auth()->user()->company->website); ?></div> <?php endif; ?>
            </div>
        </div>
        <div class="summary-row" style="margin: 24px 32px 0 32px; justify-content: space-between; white-space: nowrap; gap: 16px;">
            <span style="white-space: nowrap;"><span style="margin-right:2px; font-weight:bold; color:#b71c1c;">Invoice Date:</span><span class="value"><?php echo e(\Carbon\Carbon::parse($sale->sale_date ?? $sale->created_at)->format('d-M-Y')); ?></span></span>
            <span style="white-space: nowrap;"><span style="margin-right:2px; font-weight:bold; color:#b71c1c;">Issue Date:</span><span class="value"><?php echo e(\Carbon\Carbon::parse($sale->created_at)->format('d-M-Y')); ?></span></span>
            <span style="white-space: nowrap;"><span style="margin-right:2px; font-weight:bold; color:#b71c1c;">Invoice No:</span><span class="value"><?php echo e($sale->sale_code); ?></span></span>
        </div>
        <div style="text-align:center; margin-top:24px; margin-bottom:8px;">
            <span style="font-size:2rem; font-weight:bold; color:#b71c1c; letter-spacing:1px;">Sales Invoice</span>
        </div>
        <div class="to-block">
            <b>TO</b><br>
            <span class="label">Name:</span> <span class="value"><?php echo e($sale->customer->name ?? $sale->customer_name ?? '-'); ?></span><br>
            <span class="label">Phone:</span> <span class="value"><?php echo e($sale->customer->cel_no ?? '-'); ?></span><br>
            <span class="label">Address:</span> <span class="value"><?php echo e($sale->customer->address ?? '-'); ?></span><br>
            <?php if($sale->distributor && isset($sale->distributor->name)): ?>
            <span class="label">Distributor:</span> <span class="value"><?php echo e($sale->distributor->name); ?></span><br>
            <?php endif; ?>
            <?php if($sale->shopkeeper && isset($sale->shopkeeper->name)): ?>
            <span class="label">Shopkeeper:</span> <span class="value"><?php echo e($sale->shopkeeper->name); ?></span><br>
            <?php endif; ?>
        </div>
        <?php if(isset($externalProducts)): ?>
<pre style="color:red; font-size:12px;"><?php echo e(print_r($externalProducts, true)); ?></pre>
<?php endif; ?>
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
                    <?php $__currentLoopData = $sale->inventorySales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $total = $detail->amount * $detail->quantity; $grandTotal += $total; $totalQty += $detail->quantity; ?>
                        <tr>
                            <td><?php echo e($i+1); ?></td>
                            <td style="text-align:left;">
                                <b><?php echo e($detail->item->item_name ?? '-'); ?></b>
                            </td>
                            <td>Rs <?php echo e(number_format($detail->amount, 2)); ?> (PKR)</td>
                            <td><?php echo e($detail->quantity); ?></td>
                            <td>Rs <?php echo e(number_format($total, 2)); ?> (PKR)</td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if(isset($externalProducts) && $externalProducts->count()): ?>
                        <?php $__currentLoopData = $externalProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manual): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $total = $manual['rate'] * $manual['quantity']; $grandTotal += $total; $totalQty += $manual['quantity']; ?>
                            <tr>
                                <td><?php echo e($i+1); ?></td>
                                <td style="text-align:left;">
                                    <b><?php echo e($manual['name']); ?></b>
                                </td>
                                <td>Rs <?php echo e(number_format($manual['rate'], 2)); ?> (PKR)</td>
                                <td><?php echo e($manual['quantity']); ?></td>
                                <td>Rs <?php echo e(number_format($total, 2)); ?> (PKR)</td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    <tr class="total-row">
                        <td colspan="3" style="text-align:right;">Total</td>
                        <td><?php echo e($totalQty); ?></td>
                        <td>Rs <?php echo e(number_format($grandTotal, 2)); ?> (PKR)</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="totals-block" style="float: right; margin: 18px 32px 0 0;">
            <table>
                <tr>
                    <td class="label">Sub Total</td>
                    <td class="value">Rs <?php echo e(number_format($grandTotal, 2)); ?> (PKR)</td>
                </tr>
                <tr>
                    <td class="label">Tax (<?php echo e($sale->tax_percentage ?? 0); ?>%)</td>
                    <td class="value">Rs <?php echo e(number_format($sale->tax_amount ?? 0, 2)); ?> (PKR)</td>
                </tr>
                <tr>
                    <td class="label">Discount</td>
                    <td class="value">Rs <?php echo e(number_format($sale->discount ?? 0, 2)); ?> (PKR)</td>
                </tr>
                <tr>
                    <td class="label">Previous Outstanding</td>
                    <td class="value">Rs <?php echo e(number_format($sale->previous_outstanding ?? 0, 2)); ?> (PKR)</td>
                </tr>
                <tr>
                    <td class="label">Amount Received</td>
                    <td class="value">Rs <?php echo e(number_format($sale->amount_received ?? 0, 2)); ?> (PKR)</td>
                </tr>
                <tr class="grand">
                    <td class="grand">Grand Total</td>
                    <td class="grand">Rs <?php echo e(number_format($sale->total_amount ?? $grandTotal, 2)); ?> (PKR)</td>
                </tr>
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
</html>
<?php endif; ?>
<?php /**PATH C:\Users\HP\Desktop\posnex\resources\views/sales/print.blade.php ENDPATH**/ ?>