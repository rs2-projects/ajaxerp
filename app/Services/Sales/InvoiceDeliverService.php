<?php

namespace App\Services\Sales;


use App\Models\Procurements\ProductMaterialPurchaseDetails;
use App\Models\Production\PreProduction;
use App\Models\Sales\Invoice;
use App\Models\Sales\InvoiceDetails;

class InvoiceDeliverService
{
    // Your code here
    public function deliverData($id)
    {

        $data['invoice'] = Invoice::with('details')->where('deleted',Invoice::DELETED_NO)
            ->where('id', $id)->first();
        //dd($data);
        return $data;
    }

    public function getFinishedGoodsData($id)
    {
        $data['finished_goods'] = InvoiceDetails::where('deleted', InvoiceDetails::DELETED_NO)
            ->where('invoice_id', $id)
            ->with('finishedGood')
            ->get();
        return $data;
    }

    public function checkBarCode($finished_good_id, $barcode, $count)
    {   $data = PreProduction::where('deleted', PreProduction::DELETED_NO)
        ->where('finished_good_id', $finished_good_id)
        ->where('barcode', $barcode)
        ->where('available_qty', '>', $count)
        ->where('status', PreProduction::STATUS_ACTIVE)
        ->first();
        return $data;

    }
}
