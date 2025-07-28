<?php

namespace App\Services\Procurement\ProductMaterial;

use App\Models\Inventory\InventoryProductMaterial;
use App\Models\Inventory\ProductMaterialStock;
use App\Models\Procurements\ProductMaterialPurchase;
use App\Models\Procurements\ProductMaterialPurchaseDetailDamageFile;
use App\Models\Procurements\ProductMaterialPurchaseDetails;
use App\Models\Products\ProductMaterial;
use App\Services\Common\ImageUploadService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PurchaseInvestigationService
{
    public function indexData($purchase_id)
    {
        try {

            $data['purchase'] = ProductMaterialPurchase::with('purchaseDetails')
                ->where('id', $purchase_id)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();

            if (!$data['purchase']) {
                throw new \Exception('Purchase Order Not Found');
            }

            return $data;

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateData($request, $id)
    {
//        dd($request->all());
        DB::beginTransaction();
        try {
            $purchase = ProductMaterialPurchase::where('id', $id)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();

            if (!$purchase) {
                throw new \Exception('Purchase Order Not Found');
            }
//            dd($request->all());

            /*$has_damage = 0;
            $has_missing = 0;*/

            if (is_array($request->purchase_detail_id) && count($request->purchase_detail_id) > 0) {
                foreach ($request->purchase_detail_id as $key => $value) {

                    $purchaseDetail = ProductMaterialPurchaseDetails::where('id', $value)
                        ->where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
                        ->first();

                    if (!$purchaseDetail) {
                        throw new \Exception('Purchase Detail Not Found');
                    }

                    if (!isset($request->is_perfect[$key]) && !isset($request->has_damage[$key]) && !isset($request->has_missing[$key])) {
                        throw new \Exception('Please select at least one option for '. $purchaseDetail->productMaterial->name);
                    }

                    $productMaterial = ProductMaterial::where('id', $purchaseDetail->product_material_id)
                        ->where('deleted', ProductMaterial::DELETED_NO)
                        ->first();

                    if (isset($request->is_perfect[$key]) && ($request->is_perfect[$key])) {
                        $requestDamageQty = 0;
                        $requestMissingQty = 0;
                    }else{
                        if (isset($request->has_damage[$key]) && ($request->has_damage[$key])) {
                            $requestDamageQty = $request->damage_qty[$key];
                            if($requestDamageQty <= 0){
                                throw new \Exception('Damage Quantity must be greater than 0 for '. $purchaseDetail->productMaterial->name);
                            }
                        }else{
                            $requestDamageQty = 0;
                        }

                        if (isset($request->has_missing[$key]) && ($request->has_missing[$key])) {
                            $requestMissingQty = $request->missing_qty[$key];
                            if($requestMissingQty <= 0){
                                throw new \Exception('Missing Quantity must be greater than 0 for '. $purchaseDetail->productMaterial->name);
                            }
                        }else{
                            $requestMissingQty = 0;
                        }
                    }

                    $totalDamageMissingQty = $requestDamageQty + $requestMissingQty;

                    if ($totalDamageMissingQty > $purchaseDetail->qty) {
                        throw new \Exception('Damage and Missing Quantity can not be greater than Purchased Quantity');
                    }


                    if ($purchaseDetail->is_perfect == $purchaseDetail::IS_PERFECT_NO &&
                        $purchaseDetail->has_damage == $purchaseDetail::HAS_DAMAGE_NO &&
                        $purchaseDetail->has_missing == $purchaseDetail::HAS_MISSING_NO)
                    {
                        $productAvailableQty = $productMaterial->available_qty + ($purchaseDetail->qty - $requestDamageQty - $requestMissingQty);

                        $purchaseDetailAvailableQty = $purchaseDetail->available_qty + ($purchaseDetail->qty - $requestDamageQty - $requestMissingQty);

                        // update product material stock
                        $inventoryProductMaterialQty = $purchaseDetail->qty - $requestDamageQty - $requestMissingQty;

                        $inventoryProductMaterial = new ProductMaterialStock();
                        $inventoryProductMaterial->date = Carbon::today()->toDateString();
                        $inventoryProductMaterial->product_material_category_id = $productMaterial->product_material_category_id;
                        $inventoryProductMaterial->product_material_id = $productMaterial->id;
                        $inventoryProductMaterial->product_material_type = $productMaterial->type;
                        $inventoryProductMaterial->type = ProductMaterialStock::TYPE_IN;
                        $inventoryProductMaterial->reference_type = ProductMaterialStock::REFERENCE_TYPE_PURCHASE;
                        $inventoryProductMaterial->reference_id = $purchaseDetail->id;
                        $inventoryProductMaterial->created_at = Carbon::now();
                        $inventoryProductMaterial->created_by = auth()->user()->id;
                        $inventoryProductMaterial->save();
                        
                        // inventory product material store
                        // $inventoryProductMaterialQty = $purchaseDetail->qty - $requestDamageQty - $requestMissingQty;
                        // $inventoryProductMaterial = new InventoryProductMaterial();
                        // $inventoryProductMaterial->product_material_category_id = $productMaterial->product_material_category_id;
                        // $inventoryProductMaterial->product_material_id = $productMaterial->id;
                        // $inventoryProductMaterial->type = $inventoryProductMaterial::TYPE_IN;
                        // $inventoryProductMaterial->reference_type = $inventoryProductMaterial::REFERENCE_TYPE_PRODUCT_MATERIAL_PURCHASE;
                        // $inventoryProductMaterial->reference_id = $purchaseDetail->id;
                        // $inventoryProductMaterial->created_by = auth()->user()->id;
                        // $inventoryProductMaterial->created_at = Carbon::now();


                    } else {

                        $productAvailableQty = $productMaterial->available_qty - ($purchaseDetail->qty - $purchaseDetail->damage_qty - $purchaseDetail->missing_qty)
                            + ($purchaseDetail->qty - $requestDamageQty - $requestMissingQty);

                        $purchaseDetailAvailableQty = $purchaseDetail->available_qty - ($purchaseDetail->qty - $purchaseDetail->damage_qty - $purchaseDetail->missing_qty)
                            + ($purchaseDetail->qty - $requestDamageQty - $requestMissingQty);

                        // inventory product material table update
                        $inventoryProductMaterial = ProductMaterialStock::where('product_material_id', $purchaseDetail->product_material_id)
                            ->where('reference_id', $purchaseDetail->id)
                            ->where('type', InventoryProductMaterial::TYPE_IN)
                            ->where('deleted', InventoryProductMaterial::DELETED_NO)
                            ->first();

                        $inventoryProductMaterialQty = $inventoryProductMaterial->quantity - ($purchaseDetail->qty - $purchaseDetail->damage_qty - $purchaseDetail->missing_qty)
                            + ($purchaseDetail->qty - $requestDamageQty - $requestMissingQty);


                        // $inventoryProductMaterial = InventoryProductMaterial::where('product_material_id', $purchaseDetail->product_material_id)
                        //     ->where('reference_id', $purchaseDetail->id)
                        //     ->where('type', InventoryProductMaterial::TYPE_IN)
                        //     ->where('deleted', InventoryProductMaterial::DELETED_NO)
                        //     ->first();

                        // $inventoryProductMaterialQty = $inventoryProductMaterial->quantity - ($purchaseDetail->qty - $purchaseDetail->damage_qty - $purchaseDetail->missing_qty)
                        //     + ($purchaseDetail->qty - $requestDamageQty - $requestMissingQty);
                    }

                    if (isset($request->is_perfect[$key]) && ($request->is_perfect[$key])) {
                        $purchaseDetail->is_perfect = 1;
                        //item perfect do the rest of function
                        $purchaseDetail->has_damage = $purchaseDetail::HAS_DAMAGE_NO;
                        $purchaseDetail->damage_qty = 0;
                        $purchaseDetail->damage_remarks = $request->damage_remarks[$key];

                        $purchaseDetail->has_missing = $purchaseDetail::HAS_MISSING_NO;
                        $purchaseDetail->missing_qty = 0;
                        $purchaseDetail->missing_remarks = $request->missing_remarks[$key];

                        /*$has_damage = 0;
                        $has_missing = 0;*/

                    } else {
                        $purchaseDetail->is_perfect = 0;
                        //check if has damage and do the rest of functions
                        if (isset($request->has_damage[$key]) && ($request->has_damage[$key])) {
                            $purchaseDetail->has_damage = $purchaseDetail::HAS_DAMAGE_YES;
                            $purchaseDetail->damage_qty = $request->damage_qty[$key];
                            $purchaseDetail->damage_remarks = $request->damage_remarks[$key];

                            /*$has_damage = 1;*/
                        } else {
                            $purchaseDetail->has_damage = $purchaseDetail::HAS_DAMAGE_NO;
                            $purchaseDetail->damage_qty = 0;
                            $purchaseDetail->damage_remarks = $request->damage_remarks[$key];

                            /*$has_damage = 0;*/
                        }
                        //check if has missing and do the rest of functions

                        if (isset($request->has_missing[$key]) && ($request->has_missing[$key])) {
                            $purchaseDetail->has_missing = $purchaseDetail::HAS_MISSING_YES;
                            $purchaseDetail->missing_qty = $request->missing_qty[$key];
                            $purchaseDetail->missing_remarks = $request->missing_remarks[$key];

                            $has_missing = 1;
                        } else {
                            $purchaseDetail->has_missing = $purchaseDetail::HAS_MISSING_NO;
                            $purchaseDetail->missing_qty = 0;
                            $purchaseDetail->missing_remarks = $request->missing_remarks[$key];

                            $has_missing = 0;
                        }

                    }
                    $purchaseDetail->available_qty = $purchaseDetailAvailableQty;
                    $purchaseDetail->updated_by = auth()->user()->id;
                    $purchaseDetail->updated_at = Carbon::now();

                    $purchaseDetail->save();

                    $productMaterial->total_purchased_qty = $productAvailableQty;
                    $productMaterial->available_qty = $productAvailableQty;
                    $productMaterial->updated_by = auth()->user()->id;
                    $productMaterial->updated_at = Carbon::now();
                    $productMaterial->save();


                    $inventoryProductMaterial->quantity = $inventoryProductMaterialQty;
                    $inventoryProductMaterial->updated_at = Carbon::now();
                    $inventoryProductMaterial->updated_by = auth()->user()->id;
                    $inventoryProductMaterial->save();



                    // delete previous files

                    $unlinkAndDelete = ProductMaterialPurchaseDetailDamageFile::where('product_material_purchase_detail_id', $value)
                        ->get();

                    if(count($unlinkAndDelete) > 0){
                        foreach($unlinkAndDelete as $unlink){

                            if($unlink->file_path !='' && file_exists(getExactFilePath($unlink->file_path))) {

                                unlink(getExactFilePath($unlink->file_path));
                            }

                            $unlink->delete();
                        }
                    }



                    if(isset($request->file_type_damage) && is_array($request->file_type_damage)) {
                        if(isset($request->file_type_damage[$key]) && is_array($request->file_type_damage[$key])) {
                            foreach($request->file_type_damage[$key] as $fileKey=>$damageFile){
                                if($request->hasFile('file_type_damage.'.$key.'.'.$fileKey)){
                                    $file = $request->file('file_type_damage.'.$key.'.'.$fileKey);
                                    $imageUploadService = new ImageUploadService();
                                    $image_path = $imageUploadService->store($file, 'material-purchase/investigation/');

                                    $damageFileStore = new ProductMaterialPurchaseDetailDamageFile();
                                    $damageFileStore->product_material_purchase_id = $purchase->id;
                                    $damageFileStore->product_material_purchase_detail_id = $purchaseDetail->id;
                                    $damageFileStore->file_type = ProductMaterialPurchaseDetailDamageFile::FILE_TYPE_DAMAGE;
                                    $damageFileStore->file_path = $image_path['path']??null;
                                    $damageFileStore->created_by = auth()->user()->id;
                                    $damageFileStore->created_at = Carbon::now();
                                    $damageFileStore->updated_by = auth()->user()->id;
                                    $damageFileStore->updated_at = Carbon::now();
                                    $damageFileStore->save();

                                }
                            }
                        }
                    }

                    if(isset($request->file_type_missing) && is_array($request->file_type_missing)) {
                        if(isset($request->file_type_missing[$key]) && is_array($request->file_type_missing[$key])) {
                            foreach($request->file_type_missing[$key] as $fileKey=>$missingFile){
                                if($request->hasFile('file_type_missing.'.$key.'.'.$fileKey)){
                                    $file = $request->file('file_type_missing.'.$key.'.'.$fileKey);
                                    $imageUploadService = new ImageUploadService();
                                    $image_path = $imageUploadService->store($file, 'material-purchase/investigation/');

                                    $missingFileStore = new ProductMaterialPurchaseDetailDamageFile();
                                    $missingFileStore->product_material_purchase_id = $purchase->id;
                                    $missingFileStore->product_material_purchase_detail_id = $purchaseDetail->id;
                                    $missingFileStore->file_type = ProductMaterialPurchaseDetailDamageFile::FILE_TYPE_MISSING;
                                    $missingFileStore->file_path = $image_path['path']??null;
                                    $missingFileStore->created_by = auth()->user()->id;
                                    $missingFileStore->created_at = Carbon::now();
                                    $missingFileStore->updated_by = auth()->user()->id;
                                    $missingFileStore->updated_at = Carbon::now();
                                    $missingFileStore->save();

                                }
                            }
                        }
                    }
                }
            }

            $purchase->purchase_status = $purchase::PURCHASE_STATUS_DELIVERED;
            $purchase->updated_by = auth()->user()->id;
            $purchase->updated_at = Carbon::now();
            $purchase->save();

            // check if any purchase details are has missing
            $checkPurchaseDetailHasMissing = ProductMaterialPurchaseDetails::where('product_material_purchase_id', $purchase->id)
                ->where('has_missing', ProductMaterialPurchaseDetails::HAS_MISSING_YES)
                ->where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
                ->get();
            if (count($checkPurchaseDetailHasMissing) > 0) {
                $purchase->has_missing = $purchase::HAS_MISSING_YES;
                $purchase->updated_by = auth()->user()->id;
                $purchase->updated_at = Carbon::now();
                $purchase->save();
            }else{
                $purchase->has_missing = $purchase::HAS_MISSING_NO;
                $purchase->updated_by = auth()->user()->id;
                $purchase->updated_at = Carbon::now();
                $purchase->save();
            }

            // check if any purchase details are has damage
            $checkPurchaseDetailHasDamage = ProductMaterialPurchaseDetails::where('product_material_purchase_id', $purchase->id)
                ->where('has_damage', ProductMaterialPurchaseDetails::HAS_DAMAGE_YES)
                ->where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
                ->get();
            if (count($checkPurchaseDetailHasDamage) > 0) {
                $purchase->has_damage = $purchase::HAS_DAMAGE_YES;
                $purchase->updated_by = auth()->user()->id;
                $purchase->updated_at = Carbon::now();
                $purchase->save();
            }else{
                $purchase->has_damage = $purchase::HAS_DAMAGE_NO;
                $purchase->updated_by = auth()->user()->id;
                $purchase->updated_at = Carbon::now();
                $purchase->save();
            }



        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

        return $purchase;
    }
}
