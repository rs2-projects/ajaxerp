<?php

namespace App\Services\Procurement\ProductMaterial;

use App\Models\Procurements\ProductMaterialPurchase;
use App\Models\Procurements\ProductMaterialPurchaseCalculatedPrice;
use App\Models\Products\ProductMaterial;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PurchaseCalculatePriceService
{
    //calculate others price
    public function indexData($purchase_id)
    {
        try {
            $purchase = ProductMaterialPurchase::with(['purchaseDetails' => function ($q) {
                $q->where('product_type', ProductMaterial::TYPE_OTHERS);
            }])
                ->where('id', $purchase_id)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();

            if (!$purchase) {
                throw new \Exception('Purchase Order Not Found');
            }

            $data['purchase'] = $purchase;
            return $data;
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function storeData($request, $id){
        DB::beginTransaction();
        try {
            $CONST_VALUE = 67;
            $purchase = ProductMaterialPurchase::where('id', $id)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();
            if(!$purchase){
                throw new \Exception('Purchase Order Not Found');
            }

            if (isset($request->product_material_purchase_detail_id) && is_array($request->product_material_purchase_detail_id) && count($request->product_material_purchase_detail_id) > 0) {
                $product_material_purchase_detail_ids = $request->product_material_purchase_detail_id??[];
                $delete_item = ProductMaterialPurchaseCalculatedPrice::where('product_material_purchase_id', $purchase->id)
                    ->whereNotIn('id', $product_material_purchase_detail_ids)
                    ->where('product_type', ProductMaterialPurchaseCalculatedPrice::PRODUCT_TYPE_OTHERS)
                    ->delete();

                foreach ($request->product_material_purchase_detail_id as $key=>$details_id) {
                    if (isset($request->product_material_purchase_detail_id[$key]) &&  $request->product_material_purchase_detail_id[$key] != null){
                        // update
                        $calculate = ProductMaterialPurchaseCalculatedPrice::where('product_material_purchase_detail_id', $request->product_material_purchase_detail_id[$key])
                            ->where('product_material_purchase_id', $purchase->id)
                            ->first();
                        if ($calculate){
                            $calculate->product_type = ProductMaterialPurchaseCalculatedPrice::PRODUCT_TYPE_OTHERS;
                            $calculate->product_material_purchase_id = $id;
                            $calculate->product_material_purchase_detail_id = $details_id;
                            $calculate->product_material_id = $request->product_material_id[$key];
                            $calculate->qty = $request->qty[$key];
                            $calculate->price = $request->price[$key];
                            $calculate->exchange_rate = $request->exchange_rate[$key];
                            $calculate->price_usd = $request->price_usd[$key];
                            $calculate->cbm = $request->cbm[$key];
                            $calculate->total_pieces_per_container = $request->total_pieces_per_container[$key];
                            $calculate->freight_cost_usd = $request->freight_cost_usd[$key];
                            $calculate->exchange_rate_after_import = $request->exchange_rate_after_import[$key];
                            $calculate->total_taxes_import_duties = $request->total_taxes_import_duties[$key];
                            $calculate->total_transport_cost_to_wh = $request->total_transport_cost_to_wh[$key];
                            $calculate->total_unloading_cost = $request->total_unloading_cost[$key];
                            $calculate->handling_cost = $request->handling_cost[$key];
                            $calculate->vat_percent = $request->vat_percent;

                            $price_fob = $request->exchange_rate[$key] * $request->price_usd[$key];
                            $freight_cost = ((($request->freight_cost_usd[$key] / $CONST_VALUE) * $request->cbm[$key]) * $request->exchange_rate_after_import[$key]) / $request->total_pieces_per_container[$key];
                            $import_duties = (($request->total_taxes_import_duties[$key] / $CONST_VALUE) * $request->cbm[$key]) / $request->total_pieces_per_container[$key];
                            $transport_cost = (($request->total_transport_cost_to_wh[$key] / $CONST_VALUE) * $request->cbm[$key]) / $request->total_pieces_per_container[$key];
                            $unloading_cost = (($request->total_unloading_cost[$key] / $CONST_VALUE) * $request->cbm[$key]) / $request->total_pieces_per_container[$key];

                            // $freight_cost = ($request->freight_cost_usd[$key] / $request->total_pieces_per_container[$key]) * $request->exchange_rate_after_import[$key];
                            // $import_duties = $request->total_taxes_import_duties[$key] / $request->total_pieces_per_container[$key];
                            // $transport_cost = $request->total_transport_cost_to_wh[$key] / $request->total_pieces_per_container[$key];
                            // $unloading_cost = $request->total_unloading_cost[$key] / $request->total_pieces_per_container[$key];
                            $price_without_vat= ($price_fob + $freight_cost + $import_duties + $transport_cost + $unloading_cost) * $request->handling_cost[$key];
                            $vat_amount = ($price_without_vat * $request->vat_percent) / 100;
                            $final_price = $price_without_vat + $vat_amount;
                            $total_final_price = $final_price * $request->qty[$key];

                            $calculate->price_fob = $price_fob;
                            $calculate->freight_cost = $freight_cost;
                            $calculate->taxes_import_duties = $import_duties;
                            $calculate->transport_cost_to_wh = $transport_cost;
                            $calculate->unloading_cost = $unloading_cost;
                            $calculate->price_excluding_vat = $price_without_vat;
                            $calculate->vat = $vat_amount;
                            $calculate->final_price = $final_price;
                            $calculate->total_final_price = $total_final_price;
                            $calculate->updated_by = auth()->user()->id;
                            $calculate->updated_at = Carbon::now();
                            $calculate->save();
                        }else{
                            // create
                            $calculate = new ProductMaterialPurchaseCalculatedPrice();
                            $calculate->product_type = ProductMaterialPurchaseCalculatedPrice::PRODUCT_TYPE_OTHERS;
                            $calculate->product_material_purchase_id = $id;
                            $calculate->product_material_purchase_detail_id = $details_id;
                            $calculate->product_material_id = $request->product_material_id[$key];
                            $calculate->qty = $request->qty[$key];
                            $calculate->price = $request->price[$key];
                            $calculate->exchange_rate = $request->exchange_rate[$key];
                            $calculate->price_usd = $request->price_usd[$key];
                            $calculate->cbm = $request->cbm[$key];
                            $calculate->total_pieces_per_container = $request->total_pieces_per_container[$key];
                            $calculate->freight_cost_usd = $request->freight_cost_usd[$key];
                            $calculate->exchange_rate_after_import = $request->exchange_rate_after_import[$key];
                            $calculate->total_taxes_import_duties = $request->total_taxes_import_duties[$key];
                            $calculate->total_transport_cost_to_wh = $request->total_transport_cost_to_wh[$key];
                            $calculate->total_unloading_cost = $request->total_unloading_cost[$key];
                            $calculate->handling_cost = $request->handling_cost[$key];
                            $calculate->vat_percent = $request->vat_percent;

                            $price_fob = $request->exchange_rate[$key] * $request->price_usd[$key];
                            $freight_cost = ((($request->freight_cost_usd[$key] / $CONST_VALUE) * $request->cbm[$key]) * $request->exchange_rate_after_import[$key]) / $request->total_pieces_per_container[$key];
                            $import_duties = (($request->total_taxes_import_duties[$key] / $CONST_VALUE) * $request->cbm[$key]) / $request->total_pieces_per_container[$key];
                            $transport_cost = (($request->total_transport_cost_to_wh[$key] / $CONST_VALUE) * $request->cbm[$key]) / $request->total_pieces_per_container[$key];
                            $unloading_cost = (($request->total_unloading_cost[$key] / $CONST_VALUE) * $request->cbm[$key]) / $request->total_pieces_per_container[$key];
                            $price_without_vat= ($price_fob + $freight_cost + $import_duties + $transport_cost + $unloading_cost) * $request->handling_cost[$key];
                            $vat_amount = ($price_without_vat * $request->vat_percent) / 100;
                            $final_price = $price_without_vat + $vat_amount;
                            $total_final_price = $final_price * $request->qty[$key];

                            $calculate->price_fob = $price_fob;
                            $calculate->freight_cost = $freight_cost;
                            $calculate->taxes_import_duties = $import_duties;
                            $calculate->transport_cost_to_wh = $transport_cost;
                            $calculate->unloading_cost = $unloading_cost;
                            $calculate->price_excluding_vat = $price_without_vat;
                            $calculate->vat = $vat_amount;
                            $calculate->final_price = $final_price;
                            $calculate->total_final_price = $total_final_price;
                            $calculate->created_by = auth()->user()->id;
                            $calculate->created_at = Carbon::now();
                            $calculate->updated_by = auth()->user()->id;
                            $calculate->updated_at = Carbon::now();
                            $calculate->save();
                        }

                        // update purchase order table
                        $purchase->price_calculated = 1;
                        $purchase->price_calculated_at = Carbon::now();
                        $purchase->price_calculated_by = auth()->user()->id;
                        $purchase->save();
                    }
                }
            }
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    // calculate board price
    public function boardCalculateFormData($purchase_id)
    {
        try {
            $purchase = ProductMaterialPurchase::with(['purchaseDetails' => function ($q) {
                    $q->whereIn('product_type', [ProductMaterial::TYPE_BOARD,ProductMaterial::TYPE_PAPER]);
                }])
                ->where('id', $purchase_id)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();

            if (!$purchase) {
                throw new \Exception('Purchase Order Not Found');
            }
            $data['purchase'] = $purchase;
            return $data;
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function storeBoardCalculateForm($request, $id){
        DB::beginTransaction();
        try {
            $purchase = ProductMaterialPurchase::where('id', $id)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();
            if(!$purchase){
                throw new \Exception('Purchase Order Not Found');
            }

            if (isset($request->product_material_purchase_detail_id) && is_array($request->product_material_purchase_detail_id) && count($request->product_material_purchase_detail_id) > 0) {
                $product_material_purchase_detail_ids = $request->product_material_purchase_detail_id??[];
                $delete_item = ProductMaterialPurchaseCalculatedPrice::where('product_material_purchase_id', $purchase->id)
                        ->whereNotIn('id', $product_material_purchase_detail_ids)
                        ->where('product_type', ProductMaterialPurchaseCalculatedPrice::PRODUCT_TYPE_BOARD)
                        ->delete();

                foreach ($request->product_material_purchase_detail_id as $key=>$details_id) {
                    if (isset($request->product_material_purchase_detail_id[$key]) &&  $request->product_material_purchase_detail_id[$key] != null){
                        // update
                        $calculate = ProductMaterialPurchaseCalculatedPrice::where('product_material_purchase_detail_id', $request->product_material_purchase_detail_id[$key])
                            ->where('product_material_purchase_id', $purchase->id)
                            ->first();
                        if ($calculate){
                            $calculate->product_type = ProductMaterialPurchaseCalculatedPrice::PRODUCT_TYPE_BOARD;
                            $calculate->product_material_purchase_id = $id;
                            $calculate->product_material_purchase_detail_id = $details_id;
                            $calculate->product_material_id = $request->product_material_id[$key];
                            $calculate->qty = $request->qty[$key];
                            $calculate->price = $request->price[$key];
                            $calculate->exchange_rate = $request->exchange_rate[$key];
                            $calculate->price_usd = $request->price_usd[$key];
                            $calculate->cbm = $request->cbm[$key];
                            $calculate->total_pieces_per_container = $request->total_pieces_per_container[$key];
                            $calculate->freight_cost_usd = $request->freight_cost_usd[$key];
                            $calculate->exchange_rate_after_import = $request->exchange_rate_after_import[$key];
                            $calculate->total_taxes_import_duties = $request->total_taxes_import_duties[$key];
                            $calculate->total_transport_cost_to_wh = $request->total_transport_cost_to_wh[$key];
                            $calculate->total_unloading_cost = $request->total_unloading_cost[$key];
                            $calculate->handling_cost = $request->handling_cost[$key];
                            $calculate->vat_percent = $request->vat_percent;

                            $price_fob = $request->exchange_rate[$key] * $request->price_usd[$key];
                            $freight_cost = ($request->freight_cost_usd[$key] / $request->total_pieces_per_container[$key]) * $request->exchange_rate_after_import[$key];
                            $import_duties = $request->total_taxes_import_duties[$key] / $request->total_pieces_per_container[$key];
                            $transport_cost = $request->total_transport_cost_to_wh[$key] / $request->total_pieces_per_container[$key];
                            $unloading_cost = $request->total_unloading_cost[$key] / $request->total_pieces_per_container[$key];
                            $price_without_vat= ($price_fob + $freight_cost + $import_duties + $transport_cost + $unloading_cost) * $request->handling_cost[$key];
                            $vat_amount = ($price_without_vat * $request->vat_percent) / 100;
                            $final_price = $price_without_vat + $vat_amount;
                            $total_final_price = $final_price * $request->qty[$key];

                            $calculate->price_fob = $price_fob;
                            $calculate->freight_cost = $freight_cost;
                            $calculate->taxes_import_duties = $import_duties;
                            $calculate->transport_cost_to_wh = $transport_cost;
                            $calculate->unloading_cost = $unloading_cost;
                            $calculate->price_excluding_vat = $price_without_vat;
                            $calculate->vat = $vat_amount;
                            $calculate->final_price = $final_price;
                            $calculate->total_final_price = $total_final_price;
                            $calculate->updated_by = auth()->user()->id;
                            $calculate->updated_at = Carbon::now();
                            $calculate->save();
                        }else{
                            // create
                            $calculate = new ProductMaterialPurchaseCalculatedPrice();
                            $calculate->product_type = ProductMaterialPurchaseCalculatedPrice::PRODUCT_TYPE_BOARD;
                            $calculate->product_material_purchase_id = $id;
                            $calculate->product_material_purchase_detail_id = $details_id;
                            $calculate->product_material_id = $request->product_material_id[$key];
                            $calculate->qty = $request->qty[$key];
                            $calculate->price = $request->price[$key];
                            $calculate->exchange_rate = $request->exchange_rate[$key];
                            $calculate->price_usd = $request->price_usd[$key];
                            $calculate->cbm = $request->cbm[$key];
                            $calculate->total_pieces_per_container = $request->total_pieces_per_container[$key];
                            $calculate->freight_cost_usd = $request->freight_cost_usd[$key];
                            $calculate->exchange_rate_after_import = $request->exchange_rate_after_import[$key];
                            $calculate->total_taxes_import_duties = $request->total_taxes_import_duties[$key];
                            $calculate->total_transport_cost_to_wh = $request->total_transport_cost_to_wh[$key];
                            $calculate->total_unloading_cost = $request->total_unloading_cost[$key];
                            $calculate->handling_cost = $request->handling_cost[$key];
                            $calculate->vat_percent = $request->vat_percent;

                            $price_fob = $request->exchange_rate[$key] * $request->price_usd[$key];
                            $freight_cost = ($request->freight_cost_usd[$key] / $request->total_pieces_per_container[$key]) * $request->exchange_rate_after_import[$key];
                            $import_duties = $request->total_taxes_import_duties[$key] / $request->total_pieces_per_container[$key];
                            $transport_cost = $request->total_transport_cost_to_wh[$key] / $request->total_pieces_per_container[$key];
                            $unloading_cost = $request->total_unloading_cost[$key] / $request->total_pieces_per_container[$key];
                            $price_without_vat= ($price_fob + $freight_cost + $import_duties + $transport_cost + $unloading_cost) * $request->handling_cost[$key];
                            $vat_amount = ($price_without_vat * $request->vat_percent) / 100;
                            $final_price = $price_without_vat + $vat_amount;
                            $total_final_price = $final_price * $request->qty[$key];

                            $calculate->price_fob = $price_fob;
                            $calculate->freight_cost = $freight_cost;
                            $calculate->taxes_import_duties = $import_duties;
                            $calculate->transport_cost_to_wh = $transport_cost;
                            $calculate->unloading_cost = $unloading_cost;
                            $calculate->price_excluding_vat = $price_without_vat;
                            $calculate->vat = $vat_amount;
                            $calculate->final_price = $final_price;
                            $calculate->total_final_price = $total_final_price;
                            $calculate->created_by = auth()->user()->id;
                            $calculate->created_at = Carbon::now();
                            $calculate->updated_by = auth()->user()->id;
                            $calculate->updated_at = Carbon::now();
                            $calculate->save();
                        }

                        // update purchase order table
                        $purchase->board_price_calculated = 1;
                        $purchase->board_price_calculated_at = Carbon::now();
                        $purchase->board_price_calculated_by = auth()->user()->id;
                        $purchase->save();
                    }
                }
            }
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }
}
