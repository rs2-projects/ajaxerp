<?php

namespace App\Services\Sales;

use App\Models\Inventory\InventoryFinishedGoods;
use App\Models\Production\PreProduction;
use App\Models\Products\FinishedGoodsCategory;
use App\Models\Sales\Invoice;
use App\Models\Sales\InvoiceDetails;
use App\Models\Sales\InvoiceDispatch;
use App\Models\Sales\InvoiceDispatchDetails;
use App\Models\Sales\InvoiceDispatchDetailsProduction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $data['invoices'] = InvoiceDetails::where('deleted', InvoiceDetails::DELETED_NO)
            ->where('invoice_id', $id)
            ->with('finishedGood')
            ->get();
        return $data;
    }

    public function checkBarCode($finished_good_id, $barcode, $count)
    {   $data = PreProduction::where('deleted', PreProduction::DELETED_NO)
        ->where('finished_goods_id', $finished_good_id)
        ->where('pre_production_no', $barcode)
        ->where('available_qty', '>', $count)
        ->where('status', PreProduction::STATUS_ACTIVE)
        ->first();
        return $data;
    }

    public function deliverStoreData($request, $id)
    {
        $invoice = Invoice::where('deleted', PreProduction::DELETED_NO)
            ->where('deleted', Invoice::DELETED_NO)
            ->where('id', $id)
            ->first();
        if(!$invoice){
            throw new \Exception('Invoice not found');
        }

        DB::beginTransaction();
        try {
            $dispatch = new InvoiceDispatch();
            $dispatch->invoice_id = $id;
            $dispatch->dispatched_by = auth()->id();
            $dispatch->dispatched_at = Carbon::now();
            $dispatch->note = $request->note;
            $dispatch->created_by = auth()->id();
            $dispatch->created_at = Carbon::now();
            $dispatch->updated_by = auth()->id();
            $dispatch->updated_at = Carbon::now();
            $dispatch->save();

            $invoiceDispatchDetails = [];
            if (isset($request->invoice_details_id)) {
                foreach ($request->invoice_details_id as $key => $id) {
                    if($request->invoice_details_id != '' && $request->finished_good_id !='' && $request->barcode_count[$key] > 0){

                        $dispatch_detail = new InvoiceDispatchDetails();
                        $dispatch_detail->invoice_dispatch_id = $dispatch->id;
                        $dispatch_detail->invoice_detail_id = $id;
                        $dispatch_detail->finished_good_id = $request->finished_good_id[$key];
                        $dispatch_detail->quantity = $request->barcode_count[$key];
                        $dispatch_detail->created_by = auth()->id();
                        $dispatch_detail->created_at = Carbon::now();
                        $dispatch_detail->updated_by = auth()->id();
                        $dispatch_detail->updated_at = Carbon::now();
                        $dispatch_detail->save();
                        //update inventory
                        $finished_goods_category  =  FinishedGoodsCategory::where('deleted',FinishedGoodsCategory::DELETED_NO)
                            ->where('status',FinishedGoodsCategory::STATUS_ACTIVE)
                            ->first();
                        $inventory_finished_good = new InventoryFinishedGoods();
                        $inventory_finished_good->finished_goods_category_id = $finished_goods_category->id;
                        $inventory_finished_good->finished_goods_id = $request->finished_good_id[$key];
                        $inventory_finished_good->type = InventoryFinishedGoods::TYPE_OUT;
                        $inventory_finished_good->reference_type = InventoryFinishedGoods::REFERENCE_TYPE_FROM_SALE;
                        $inventory_finished_good->reference_id = $dispatch_detail->id;
                        $inventory_finished_good->quantity = $request->barcode_count[$key];
                        $inventory_finished_good->save();
                        //update invoice details
                        $invoice_details = InvoiceDetails::where('deleted',Invoice::DELETED_NO)
                            ->where('id', $id)
                            ->first();
                        $invoice_details->dispatched_qty = $request->barcode_count[$key];
                        if ($invoice_details->dispatched_qty!=0 && $invoice_details->quantity>$invoice_details->dispatched_qty){
                            $invoice_details->dispatched = InvoiceDetails::DISPATCHED_PARTIALLY;
                        }elseif ($invoice_details->quantity==$invoice_details->dispatched_qty){
                            $invoice_details->dispatched = InvoiceDetails::DISPATCHED_YES;
                        }
                        $invoice_details->dispatched_qty= $request->barcode_count[$key];
                        $invoice_details->save();

                        $invoiceDispatchDetails[$key] = [
                            'invoice_dispatch_details_id' => $dispatch_detail->id,
                            'finished_good_id' => $request->finished_good_id[$key],
                            'invoice_detail_id' => $id
                        ];

                    }

                }

            }
                if (isset($request->pre_production_id) && is_array($request->pre_production_id)) {
                    foreach ($request->pre_production_id as $key => $pre_production_ids) {
                        $invoiceDispatchDetail = $invoiceDispatchDetails[$key];
                        if(!is_array($pre_production_ids)) {
                            continue;
                        }
                        $countPreProductionIds = array_count_values($pre_production_ids);

                        foreach ($countPreProductionIds as $preProductionId => $qty ) {
                            $dispatch_details_production = new InvoiceDispatchDetailsProduction();
                            $dispatch_details_production->invoice_dispatch_id = $dispatch->id;
                            $dispatch_details_production->invoice_dispatch_detail_id = $invoiceDispatchDetail['invoice_dispatch_details_id'];
                            $dispatch_details_production->invoice_detail_id = $invoiceDispatchDetail['invoice_detail_id'];
                            $dispatch_details_production->finished_good_id =  $invoiceDispatchDetail['finished_good_id'];
                            $dispatch_details_production->pre_production_id = $preProductionId;
                            $preProduction = PreProduction::where('deleted',PreProduction::DELETED_NO)->where('id', $preProductionId)->first();
                            $preProduction->available_qty = $preProduction->available_qty - $qty;
                            $preProduction->save();
                            $dispatch_details_production->quantity = $qty;
                            $dispatch_details_production->created_by = auth()->id();
                            $dispatch_details_production->created_at = Carbon::now();
                            $dispatch_details_production->updated_by = auth()->id();
                            $dispatch_details_production->updated_at = Carbon::now();
                            $dispatch_details_production->save();
                        }
                    }
                }

        }catch(\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }
}
