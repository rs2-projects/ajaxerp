<?php

namespace App\Services\Sales;

use App\Models\Sales\InvoicePayment;
use Carbon\Carbon;

class InvoicePaymentService
{
    // Your code here
    public function store($request,$invoice_id=null,$transaction_id=null,$account_id=null)
    {
        try {
            $invoice_payment = new InvoicePayment();
            $invoice_payment->invoice_id = $invoice_id;
            $invoice_payment->transaction_id = $transaction_id;
            $invoice_payment->account_id = $account_id;
            $invoice_payment->payment_method = $request->payment_method;
            $invoice_payment->amount = $request->amount;
            $invoice_payment->payment_date = $request->date;
            $invoice_payment->note = $request->note;
            $invoice_payment->created_at = Carbon::now();
            $invoice_payment->created_by = auth()->id();
            $invoice_payment->updated_at = Carbon::now();
            $invoice_payment->updated_by = auth()->id();
            $invoice_payment->save();
            return $invoice_payment;
        }catch(\Exception $e){
            return throw new \Exception($e->getMessage());
        }

    }
}
