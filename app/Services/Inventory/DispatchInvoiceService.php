<?php

namespace App\Services\Inventory;

use App\Models\Inventory\InventoryFinishedGoods;
use App\Models\Inventory\ProductMaterialStock;
use App\Models\Procurements\ProductMaterialPurchaseDetails;
use App\Models\Production\PreProduction;
use App\Models\Products\FinishedGoods;
use App\Models\Products\FinishedGoodsCategory;
use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialSet;
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

    public function getDeliverData($id)
    {
        $invoice = Invoice::with(['details',
                'details.product_material',
                'details.finishedGood',
                'details.finishedBoard',
                'details.set_item.set_items.productMaterial',
            ])
            ->where('deleted', Invoice::DELETED_NO)
            ->where('status', Invoice::STATUS_ACTIVE)
            ->where('id', $id)->first();

        if (!$invoice) {
            throw new \Exception('Invoice not found');
        }
        
        $details = $invoice->details->map(function ($detail) {
            $setItems = [];

            if ($detail->item_type == InvoiceDetails::TYPE_SET_ITEM && $detail->set_item) {
                $setItems = $detail->set_item->set_items->map(function ($setItem) {
                    return [
                        'id' => $setItem->id,
                        'product_material_id' => $setItem->product_material_id,
                        'name' => $setItem->productMaterial->name ?? null,
                        'code' => $setItem->productMaterial->code ?? null,
                        'item_quantity' => $setItem->quantity,
                        'available_qty' => $setItem->productMaterial->available_qty ?? 0,
                    ];
                })->values();
            }

            return [
                'id'             => $detail->id,
                'item_id'        => $detail->item_id,
                'item_type'      => $detail->item_type,
                'item_name'      => $detail->itemName(),
                'item_code'      => $detail->itemCode(),
                'quantity'       => $detail->quantity,
                'available_qty'  => $detail->itemAvailableQty(),
                'dispatched'     => $detail->dispatched ?? 0,
                'dispatched_qty' => $detail->dispatched_qty ?? 0,
                'remaining_qty' => $detail->quantity - $detail->dispatched_qty,
                'set_items'      => $setItems,
            ];
        });

        $data['invoice_details'] = $details;
        return $data;
    }

    public function deliverStoreData($request, $id)
    {
        $invoice = Invoice::where('deleted', Invoice::DELETED_NO)
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
            $dispatch->updated_by = auth()->id();
            $dispatch->save();

            if (isset($request->invoice_details_id)) {
                foreach ($request->invoice_details_id as $key => $id) {
                    if (!empty($request->invoice_details_id[$key]) && !empty($request->item_id[$key])) {

                        $dispatch_detail = new InvoiceDispatchDetails();
                        $dispatch_detail->invoice_dispatch_id = $dispatch->id;
                        $dispatch_detail->invoice_id = $invoice->id;
                        $dispatch_detail->invoice_detail_id = $id;
                        $dispatch_detail->item_type = isset($request->item_type[$key]) ? (int) $request->item_type[$key] : 0;
                        $dispatch_detail->finished_good_id = $request->item_id[$key];
                        $dispatch_detail->quantity = $request->delivery_qty[$key];
                        $dispatch_detail->created_by = auth()->id();
                        $dispatch_detail->updated_by = auth()->id();
                        $dispatch_detail->save();

                        // Update invoice details
                        $invoice_details = InvoiceDetails::where('deleted', Invoice::DELETED_NO)
                            ->where('id', $id)
                            ->first();

                        $invoice_details->dispatched_qty += $request->delivery_qty[$key];

                        if ($invoice_details->dispatched_qty > 0 && $invoice_details->quantity > $invoice_details->dispatched_qty) {
                            $invoice_details->dispatched = InvoiceDetails::DISPATCHED_PARTIALLY;
                        } elseif ($invoice_details->quantity <= $invoice_details->dispatched_qty) {
                            $invoice_details->dispatched = InvoiceDetails::DISPATCHED_YES;
                        }

                        $invoice_details->save();

                        // Inventory update by item type
                        if ($invoice_details->item_type == InvoiceDetails::TYPE_FINISHED_GOODS) {
                            $item = FinishedGoods::where('id', $invoice_details->item_id)
                                ->where('type', FinishedGoods::TYPE_OTHERS)
                                ->where('deleted', FinishedGoods::DELETED_NO)
                                ->where('status', FinishedGoods::STATUS_ACTIVE)
                                ->first();

                            if (!$item) throw new \Exception('Finished Goods not found');
                            if ($request->delivery_qty[$key] > 0 &&  $item->available_qty < $request->delivery_qty[$key]) {
                                throw new \Exception('Insufficient Finished Goods stock');
                            }

                            $item->available_qty -= $request->delivery_qty[$key];
                            $item->total_sale_qty += $request->delivery_qty[$key];
                            $item->save();

                        } elseif ($invoice_details->item_type == InvoiceDetails::TYPE_FINISHED_BOARD) {
                            $item = FinishedGoods::where('id', $invoice_details->item_id)
                                ->where('type', FinishedGoods::TYPE_BOARD)
                                ->where('deleted', FinishedGoods::DELETED_NO)
                                ->where('status', FinishedGoods::STATUS_ACTIVE)
                                ->first();

                            if (!$item) throw new \Exception('Finished Board not found');
                            if ($request->delivery_qty[$key] > 0 && $item->available_qty < $request->delivery_qty[$key]) {
                                throw new \Exception('Insufficient Finished Board stock');
                            }

                            $item->available_qty -= $request->delivery_qty[$key];
                            $item->total_sale_qty += $request->delivery_qty[$key];
                            $item->save();

                        } elseif ($invoice_details->item_type == InvoiceDetails::TYPE_SET_ITEM) {
                            $setItem = ProductMaterialSet::where('id', $invoice_details->item_id)
                                ->where('deleted', ProductMaterialSet::DELETED_NO)
                                ->where('status', ProductMaterialSet::STATUS_ACTIVE)
                                ->first();

                            if ($setItem && $request->delivery_qty[$key] > 0) {
                                foreach ($setItem->set_items as $setItemChild) {
                                    $material = ProductMaterial::where('id', $setItemChild->product_material_id)
                                        ->where('deleted', ProductMaterial::DELETED_NO)
                                        ->where('status', ProductMaterial::STATUS_ACTIVE)
                                        ->first();

                                    if (!$material) throw new \Exception('Product Material not found for Set Item');

                                    $qty = $setItemChild->quantity * $request->delivery_qty[$key];

                                    if ($material->available_qty < $qty) {
                                        throw new \Exception('Insufficient stock for Set Item Material');
                                    }

                                    $material->available_qty -= $qty;
                                    $material->total_used_qty += $qty;
                                    $material->save();

                                    $this->createMaterialStockOut($invoice->id, $material, $qty);
                                    $this->deductFromPurchaseStock($material->id, $qty);
                                }
                            }

                        } elseif (in_array($invoice_details->item_type, [
                            InvoiceDetails::TYPE_RAW_MATERIAL,
                            InvoiceDetails::TYPE_RAW_BOARD,
                            InvoiceDetails::TYPE_PAPER
                        ])) {
                            $material = ProductMaterial::where('id', $invoice_details->item_id)
                                ->where('deleted', ProductMaterial::DELETED_NO)
                                ->where('status', ProductMaterial::STATUS_ACTIVE)
                                ->first();

                            if (!$material) throw new \Exception('Product Material not found');
                            if ($request->delivery_qty[$key] > 0 && $material->available_qty < $request->delivery_qty[$key]) {
                                throw new \Exception('Insufficient Product Material stock');
                            }

                            $material->available_qty -= $request->delivery_qty[$key];
                            $material->total_used_qty += $request->delivery_qty[$key];
                            $material->save();

                            $this->createMaterialStockOut($invoice->id, $material, $request->delivery_qty[$key]);
                            $this->deductFromPurchaseStock($material->id, $request->delivery_qty[$key]);
                        }
                    }
                }
            }

            // Update invoice status
            $hasPendingDispatch = InvoiceDetails::where('deleted', Invoice::DELETED_NO)
                ->where('status', Invoice::STATUS_ACTIVE)
                ->where('invoice_id', $invoice->id)
                ->where('dispatched', '!=', InvoiceDetails::DISPATCHED_YES)
                ->exists();

            $invoice->invoice_status = $hasPendingDispatch
                ? Invoice::INVOICE_STATUS_PROCESSING
                : Invoice::INVOICE_STATUS_DELIVERED;

            $invoice->save();

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

        DB::commit();
    }


    private function createMaterialStockOut($invoice_id, $material, $qty)
    {
        if (!$material || $qty <= 0) return;

        $productStock = new ProductMaterialStock();
        $productStock->date = Carbon::today()->toDateString();
        $productStock->product_material_category_id = $material->product_material_category_id;
        $productStock->product_material_id = $material->id;
        $productStock->product_material_type = $material->type;
        $productStock->type = ProductMaterialStock::TYPE_OUT;
        $productStock->reference_type = ProductMaterialStock::REFERENCE_TYPE_SALES;
        $productStock->reference_id = $invoice_id ?? null;
        $productStock->quantity = $qty;
        $productStock->save();
    }

    private function deductFromPurchaseStock($product_material_id, $qty)
    {
        $remaining = $qty;
        $purchaseDetails = ProductMaterialPurchaseDetails::where('product_material_id', $product_material_id)
            ->where('available_qty', '>', 0)
            ->orderBy('id', 'desc')
            ->get();

        foreach ($purchaseDetails as $detail) {
            if ($remaining <= 0) break;

            $deductQty = min($detail->available_qty, $remaining);
            $detail->available_qty -= $deductQty;
            $detail->used_qty += $deductQty;
            $detail->save();

            $remaining -= $deductQty;
        }
    }

}
