<?php

namespace App\Services\Inventory;

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

class DispatchInvoiceService
{
    private $paginate_limit;

    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    // index data
    public function indexData()
    {
        $data['months'] = config('commonData.month_names');
        //$data['statuses'] = Invoice::INVOICE_STATUSES;
        return $data;
    }

    //filtered data
    public function indexFilteredData($request)
    {
        $invoice_id = $request->invoice_id;
        $status_filter = $request->status_filter;
        $start_date_filtered = $request->start_date_filtered ?? null;
        $end_date_filtered = $request->end_date_filtered ?? null;
        $data['invoices'] = Invoice::where('deleted', Invoice::DELETED_NO)
            ->where('status', Invoice::STATUS_ACTIVE)
            ->whereIn('invoice_status', [
                Invoice::INVOICE_STATUS_PENDING,
                Invoice::INVOICE_STATUS_PROCESSING,
            ])
            ->where(function ($q) use ($invoice_id) {
                if ($invoice_id != '') {
                    $q->where('invoice_no', 'like', '%' . $invoice_id . '%');
                }


            })
            ->where(function ($q) use ($status_filter) {
                if ($status_filter != '') {
                    $q->where('invoice_status', 'like', '%' . $status_filter . '%');
                }


            })
            ->where(function ($q) use ($start_date_filtered, $end_date_filtered) {
                if ($start_date_filtered != null) {
                    $q->whereDate('invoice_date', '>=', $start_date_filtered);
                }
                if ($end_date_filtered != null) {
                    $q->whereDate('invoice_date', '<=', $end_date_filtered);
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);
        $data['view'] = view('inventory.sales-dispatch._index_filtered', $data)->render();
        return $data;
    }

    public function deliverData($id)
    {
        $data['invoice'] = Invoice::with('details')->where('deleted', Invoice::DELETED_NO)
            ->where('status', Invoice::STATUS_ACTIVE)
            ->where('id', $id)->first();
        return $data;
    }

    public function deliverStoreData($request, $id)
    {
        $invoice = Invoice::where('deleted', PreProduction::DELETED_NO)
            ->where('deleted', Invoice::DELETED_NO)
            ->where('id', $id)
            ->first();
        if (!$invoice) {
            throw new \Exception('Invoice not found');
        }

        DB::beginTransaction();
        try {
            $dispatch = new InvoiceDispatch();
            $dispatch->invoice_id = $invoice->id;
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
                    if ($request->invoice_details_id != '' && $request->finished_good_id != '' && $request->barcode_count[$key] > 0) {

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
                        $finished_goods_category = FinishedGoodsCategory::where('deleted', FinishedGoodsCategory::DELETED_NO)
                            ->where('status', FinishedGoodsCategory::STATUS_ACTIVE)
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
                        $invoice_details = InvoiceDetails::where('deleted', Invoice::DELETED_NO)
                            ->where('id', $id)
                            ->first();
                        $invoice_details->dispatched_qty += $request->barcode_count[$key];
                        if (($invoice_details->dispatched_qty != 0) && ($invoice_details->quantity > $invoice_details->dispatched_qty)) {
                            $invoice_details->dispatched = InvoiceDetails::DISPATCHED_PARTIALLY;
                        } elseif ($invoice_details->quantity <= $invoice_details->dispatched_qty) {
                            $invoice_details->dispatched = InvoiceDetails::DISPATCHED_YES;
                        }
                        $invoice_details->save();

                        $invoiceDispatchDetails[$key] = [
                            'invoice_dispatch_details_id' => $dispatch_detail->id,
                            'finished_good_id' => $request->finished_good_id[$key],
                            'invoice_detail_id' => $id
                        ];

                    }

                }
            }
            $hasPendingDispatch = InvoiceDetails::where('deleted', Invoice::DELETED_NO)
                ->where('status', Invoice::STATUS_ACTIVE)
                ->where('invoice_id', $invoice->id)
                ->where('dispatched', '!=', InvoiceDetails::DISPATCHED_YES)
                ->count();
            if ($hasPendingDispatch > 0) {
                $invoice->invoice_status = Invoice::INVOICE_STATUS_PROCESSING;
            } else {
                $invoice->invoice_status = Invoice::INVOICE_STATUS_DELIVERED;
            }
            $invoice->save();

            if (isset($request->pre_production_id) && is_array($request->pre_production_id)) {
                foreach ($request->pre_production_id as $key => $pre_production_ids) {
                    $invoiceDispatchDetail = $invoiceDispatchDetails[$key];
                    if (!is_array($pre_production_ids)) {
                        continue;
                    }
                    $countPreProductionIds = array_count_values($pre_production_ids);

                    foreach ($countPreProductionIds as $preProductionId => $qty) {
                        $dispatch_details_production = new InvoiceDispatchDetailsProduction();
                        $dispatch_details_production->invoice_dispatch_id = $dispatch->id;
                        $dispatch_details_production->invoice_dispatch_detail_id = $invoiceDispatchDetail['invoice_dispatch_details_id'];
                        $dispatch_details_production->invoice_detail_id = $invoiceDispatchDetail['invoice_detail_id'];
                        $dispatch_details_production->finished_good_id = $invoiceDispatchDetail['finished_good_id'];
                        $dispatch_details_production->pre_production_id = $preProductionId;
                        $preProduction = PreProduction::where('deleted', PreProduction::DELETED_NO)->where('id', $preProductionId)->first();
                        $preProduction->available_qty = $preProduction->available_qty - $qty;
                        $preProduction->sale_qty += $qty;
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

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }
}
