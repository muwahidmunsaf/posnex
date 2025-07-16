<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SupplierPayment;

class FixSupplierPaymentsPKR extends Command
{
    protected $signature = 'fix:supplier-payments-pkr';
    protected $description = 'Fix old supplier payments: update pkr_amount for non-PKR suppliers where it was not converted.';

    public function handle()
    {
        $count = 0;
        // Fix non-PKR payments with wrong, null, or zero pkr_amount
        SupplierPayment::whereHas('supplier', function($q) {
                $q->where('currency_code', '!=', 'PKR');
            })
            ->where(function($q) {
                $q->whereNull('pkr_amount')
                  ->orWhere('pkr_amount', 0)
                  ->orWhereNull('exchange_rate_to_pkr')
                  ->orWhereRaw('ABS(pkr_amount - (amount * exchange_rate_to_pkr)) > 0.01');
            })
            ->chunkById(100, function($payments) use (&$count) {
                foreach ($payments as $payment) {
                    $old = $payment->pkr_amount;
                    if ($payment->exchange_rate_to_pkr && $payment->exchange_rate_to_pkr > 0) {
                        $payment->pkr_amount = $payment->amount * $payment->exchange_rate_to_pkr;
                    } else {
                        $payment->pkr_amount = $payment->amount;
                    }
                    $payment->save();
                    $this->info("Updated non-PKR payment ID {$payment->id}: {$old} -> {$payment->pkr_amount}");
                    $count++;
                }
            });
        // Fix PKR payments with null or zero pkr_amount
        SupplierPayment::whereHas('supplier', function($q) {
                $q->where('currency_code', 'PKR');
            })
            ->where(function($q) {
                $q->whereNull('pkr_amount')->orWhere('pkr_amount', 0);
            })
            ->chunkById(100, function($payments) use (&$count) {
                foreach ($payments as $payment) {
                    $old = $payment->pkr_amount;
                    $payment->pkr_amount = $payment->amount;
                    $payment->save();
                    $this->info("Updated PKR payment ID {$payment->id}: {$old} -> {$payment->pkr_amount}");
                    $count++;
                }
            });
        $this->info("Total updated: $count");
        return 0;
    }
} 