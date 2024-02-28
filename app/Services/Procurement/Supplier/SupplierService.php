<?php

namespace App\Services\Procurement\Supplier;
use App\Services\Common\ImageUploadService;
use App\Models\Country;
use App\Models\State;
use App\Models\Products\AssetProduct;
use App\Models\Products\ProductMaterial;
use App\Models\Procurements\Supplier;
use App\Models\Procurements\SupplierAssetProduct;
use App\Models\Procurements\SupplierBank;
use App\Models\Procurements\SupplierContact;
use App\Models\Procurements\SupplierProductMaterial;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SupplierService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexData()
    {
        $data['countries'] = Country::orderBy('name', 'asc')->get();
        $data['asset_products'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where('status', AssetProduct::STATUS_ACTIVE)
            ->orderBy('name', 'asc')->get();
        $data['material_products'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
            ->where('status', ProductMaterial::STATUS_ACTIVE)
            ->orderBy('name', 'asc')->get();
        return $data;
    }

    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $data['suppliers'] = Supplier::where('deleted', Supplier::DELETED_NO)
            ->where('status', Supplier::STATUS_ACTIVE)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('business_name', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('business_name', 'asc')->paginate($this->paginate_limit);
        return $data;
    }

    public function getStatesByCountry($request)
    {
        $country_id = $request->country_id;
        $data['states'] = State::where('country_id', $country_id)
            ->orderBy('name', 'asc')
            ->get();

        return $data;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {

            $duplicate_check = Supplier::where('business_name', $request->business_name)
                ->where('email', $request->email)
                ->where('deleted', Supplier::DELETED_NO)
                ->first();
            if (!empty($duplicate_check)) {
                throw new \Exception("Supplier already exists");
            }

            $image_path = null;
            if ($request->hasFile('image')) {
                $imageUploadService = new ImageUploadService();
                $image_path = $imageUploadService->store($request->image, 'procurement/suppliers');
                $image_path = $image_path['path'];
            }

            $supplier = new Supplier();
            $supplier->business_name = $request->business_name;
            $supplier->image = $image_path??null;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->contact_first_name = $request->contact_first_name;
            $supplier->contact_last_name = $request->contact_last_name;
            $supplier->lead_time_status = $request->lead_time_status;
            $supplier->address = $request->address;
            $supplier->city = $request->city;
            $supplier->zip_code = $request->zip_code;
            $supplier->country_id = $request->country_id;
            $supplier->state_id = $request->state_id;
            $supplier->fax = $request->fax;
            $supplier->website = $request->website;
            $supplier->notes = $request->supplier_notes;
            $supplier->created_by = auth()->user()->id;
            $supplier->created_at = Carbon::now();
            $supplier->updated_by = auth()->user()->id;
            $supplier->updated_at = Carbon::now();
            $supplier->save();


            if (isset($request->bank_name) && is_array($request->bank_name) && count($request->bank_name) > 0) {
                foreach ($request->bank_name as $key=>$bank) {
                    if(
                        ($bank == null) || ($bank == '') ||
                        ($request->account_name[$key] == null) || ($request->account_name[$key] == '') ||
                        ($request->account_no[$key] == null) || ($request->account_no[$key] == '')){
                        continue;
                    }
                    $supplier_bank = new SupplierBank();
                    $supplier_bank->supplier_id = $supplier->id;
                    $supplier_bank->bank_name = $bank;
                    $supplier_bank->account_name = $request->account_name[$key];
                    $supplier_bank->account_no = $request->account_no[$key];
                    $supplier_bank->branch = $request->branch[$key];
                    $supplier_bank->routing_number = $request->routing_number[$key];
                    $supplier_bank->swift_code = $request->swift_code[$key];
                    $supplier_bank->notes = $request->notes[$key];
                    $supplier_bank->created_by = auth()->user()->id;
                    $supplier_bank->created_at = Carbon::now();
                    $supplier_bank->updated_by = auth()->user()->id;
                    $supplier_bank->updated_at = Carbon::now();
                    $supplier_bank->save();
                }
            }

            if (isset($request->material_products) && is_array($request->material_products) && (count($request->material_products) > 0)) {
                foreach ($request->material_products as $key=>$material_id) {
                    $supplier_material = new SupplierProductMaterial();
                    $supplier_material->supplier_id = $supplier->id;
                    $supplier_material->product_material_id = $material_id;
                    $supplier_material->save();
                }
            }

            if (isset($request->asset_products) && is_array($request->asset_products) && (count($request->asset_products) > 0)) {
                foreach ($request->asset_products as $key=>$asset_id) {
                    $supplier_asset = new SupplierAssetProduct();
                    $supplier_asset->supplier_id = $supplier->id;
                    $supplier_asset->asset_product_id = $asset_id;
                    $supplier_asset->save();
                }
            }

            if (isset($request->contact_name) && is_array($request->contact_name) && count($request->contact_name) > 0) {
                foreach ($request->contact_name as $key=>$name) {
                    if(($name == null) || ($name == '')){
                        continue;
                    }
                    $supplier_contact = new SupplierContact();
                    $supplier_contact->supplier_id = $supplier->id;
                    $supplier_contact->name = $name;
                    $supplier_contact->email = $request->contact_email[$key];
                    $supplier_contact->phone = $request->contact_phone[$key];
                    $supplier_contact->save();
                }
            }
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

        // return $supplier;
    }

    public function editData($id)
    {
        $data['countries'] = Country::orderBy('name', 'asc')->get();
        $data['item'] = Supplier::with('supplierBanks')
            ->where('id', $id)
            ->where('deleted', Supplier::DELETED_NO)
            ->first();

        $data['asset_products'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where('status', AssetProduct::STATUS_ACTIVE)
            ->orderBy('name', 'asc')->get();

        $data['material_products'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
            ->where('status', ProductMaterial::STATUS_ACTIVE)
            ->orderBy('name', 'asc')->get();

        if (!$data['item']) {
            throw new \Exception('Supplier not found');
        }
        return $data;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {

            $duplicate_check = Supplier::where('business_name', $request->business_name)
                ->where('email', $request->email)
                ->where('deleted', Supplier::DELETED_NO)
                ->where('id', '!=', $id)
                ->first();

            if (!empty($duplicate_check)) {
                throw new \Exception("Supplier already exists");
            }

            $image_path = null;
            if ($request->hasFile('image')) {
                $imageUploadService = new ImageUploadService();
                $image_path = $imageUploadService->store($request->image, 'procurement/suppliers');
                $image_path = $image_path['path'];
            }

            $supplier = Supplier::where('deleted', Supplier::DELETED_NO)
                ->where('id', $id)
                ->first();

            if(!$supplier){
                throw new \Exception("Supplier not found");
            }

            $supplier->business_name = $request->business_name;
            $supplier->image = $image_path?? $supplier->image;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->contact_first_name = $request->contact_first_name;
            $supplier->contact_last_name = $request->contact_last_name;
            $supplier->lead_time_status = $request->lead_time_status;
            $supplier->address = $request->address;
            $supplier->city = $request->city;
            $supplier->zip_code = $request->zip_code;
            $supplier->country_id = $request->country_id;
            $supplier->state_id = $request->state_id;
            $supplier->fax = $request->fax;
            $supplier->website = $request->website;
            $supplier->notes = $request->supplier_notes;
            $supplier->updated_by = auth()->user()->id;
            $supplier->updated_at = Carbon::now();
            $supplier->save();


            // check if not exist then delete first
            $bank_info_ids = $request->bank_info_id??[];
            $delete_bank = SupplierBank::where('supplier_id', $supplier->id)
                ->whereNotIn('id', $bank_info_ids)
                ->delete();

            if (isset($request->bank_name) && is_array($request->bank_name) && count($request->bank_name) > 0) {

                foreach ($request->bank_name as $key=>$value) {
                    if (isset($request->bank_info_id[$key]) &&  $request->bank_info_id[$key] != null){
                        if(
                            ($value == null) || ($value == '') ||
                            ($request->account_name[$key] == null) || ($request->account_name[$key] == '') ||
                            ($request->account_no[$key] == null) || ($request->account_no[$key] == '')){
                            SupplierBank::where('supplier_id', $supplier->id)
                                ->where('id', $request->bank_info_id[$key])
                                ->delete();
                            continue;
                        }
                        // update
                        $supplier_bank = SupplierBank::where('id', $request->bank_info_id[$key])
                            ->where('supplier_id', $supplier->id)
                            ->first();
                        if ($supplier_bank){
                            $supplier_bank->bank_name = $value;
                            $supplier_bank->account_name = $request->account_name[$key];
                            $supplier_bank->account_no = $request->account_no[$key];
                            $supplier_bank->branch = $request->branch[$key];
                            $supplier_bank->routing_number = $request->routing_number[$key];
                            $supplier_bank->swift_code = $request->swift_code[$key];
                            $supplier_bank->notes = $request->notes[$key];
                            $supplier_bank->updated_by = auth()->user()->id;
                            $supplier_bank->updated_at = Carbon::now();
                            $supplier_bank->save();
                        }
                    }else{
                        if(
                            ($value == null) || ($value == '') ||
                            ($request->account_name[$key] == null) || ($request->account_name[$key] == '') ||
                            ($request->account_no[$key] == null) || ($request->account_no[$key] == '')){
                            continue;
                        }
                        // create
                        $supplier_bank = new SupplierBank();
                        $supplier_bank->supplier_id = $supplier->id;
                        $supplier_bank->bank_name = $value;
                        $supplier_bank->account_name = $request->account_name[$key];
                        $supplier_bank->account_no = $request->account_no[$key];
                        $supplier_bank->branch = $request->branch[$key];
                        $supplier_bank->routing_number = $request->routing_number[$key];
                        $supplier_bank->swift_code = $request->swift_code[$key];
                        $supplier_bank->notes = $request->notes[$key];
                        $supplier_bank->created_by = auth()->user()->id;
                        $supplier_bank->created_at = Carbon::now();
                        $supplier_bank->updated_by = auth()->user()->id;
                        $supplier_bank->updated_at = Carbon::now();
                        $supplier_bank->save();
                    }
                }
            }

            $material_ids = $request->material_products??[];
            $delete_material = SupplierProductMaterial::where('supplier_id', $supplier->id)
                ->whereNotIn('id', $material_ids)
                ->delete();

            if (isset($request->material_products) && is_array($request->material_products) && (count($request->material_products) > 0)) {
                foreach ($request->material_products as $key=>$material_id) {
                    if (isset($request->material_products[$key]) &&  $request->material_products[$key] != null){
                        $supplier_material = SupplierProductMaterial::where('id', $request->material_products[$key])
                            ->where('supplier_id', $supplier->id)
                            ->first();
                        if ($supplier_material){
                            continue;
                        }else{
                            $supplier_material = new SupplierProductMaterial();
                            $supplier_material->supplier_id = $supplier->id;
                            $supplier_material->product_material_id = $material_id;
                            $supplier_material->save();
                        }
                    }
                }
            }


            $asset_ids = $request->asset_products??[];
            $delete_asset = SupplierAssetProduct::where('supplier_id', $supplier->id)
                ->whereNotIn('id', $asset_ids)
                ->delete();

            if (isset($request->asset_products) && is_array($request->asset_products) && (count($request->asset_products) > 0)) {
                foreach ($request->asset_products as $key=>$asset_id) {
                    if (isset($request->asset_products[$key]) &&  $request->asset_products[$key] != null){
                        $supplier_asset = SupplierAssetProduct::where('id', $request->asset_products[$key])
                            ->where('supplier_id', $supplier->id)
                            ->first();
                        if ($supplier_asset){
                            continue;
                        }else{
                            $supplier_asset = new SupplierAssetProduct();
                            $supplier_asset->supplier_id = $supplier->id;
                            $supplier_asset->asset_product_id = $asset_id;
                            $supplier_asset->save();
                        }
                    }
                }
            }

            if (isset($request->contact_name) && is_array($request->contact_name) && count($request->contact_name) > 0) {
                $supplier_contact_ids = $request->supplier_contact_id??[];
                $delete_contact = SupplierContact::where('supplier_id', $supplier->id)
                    ->whereNotIn('id', $supplier_contact_ids)
                    ->delete();

                foreach ($request->contact_name as $key=>$value) {
                    if (isset($request->supplier_contact_id[$key]) &&  $request->supplier_contact_id[$key] != null){
                        if(($value == null) || ($value == '')){
                           SupplierContact::where('id', $request->supplier_contact_id[$key])
                                ->where('supplier_id', $supplier->id)
                                ->delete();
                            continue;
                        }
                        $supplier_contact = SupplierContact::where('id', $request->supplier_contact_id[$key])
                            ->where('supplier_id', $supplier->id)
                            ->first();
                        if ($supplier_contact){
                            $supplier_contact->name = $value;
                            $supplier_contact->email = $request->contact_email[$key];
                            $supplier_contact->phone = $request->contact_phone[$key];
                            $supplier_contact->updated_by = auth()->user()->id;
                            $supplier_contact->updated_at = Carbon::now();
                            $supplier_contact->save();
                        }
                    }else{
                        if(($value == null) || ($value == '')){
                            continue;
                        }
                        $supplier_contact = new SupplierContact();
                        $supplier_contact->supplier_id = $supplier->id;
                        $supplier_contact->name = $value;
                        $supplier_contact->email = $request->contact_email[$key];
                        $supplier_contact->phone = $request->contact_phone[$key];
                        $supplier_contact->created_by = auth()->user()->id;
                        $supplier_contact->created_at = Carbon::now();
                        $supplier_contact->updated_by = auth()->user()->id;
                        $supplier_contact->updated_at = Carbon::now();
                        $supplier_contact->save();
                    }
                }
            }
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

    }

    public function delete($id)
    {
        $suplier = Supplier::where('id', $id)
            ->where('deleted', Supplier::DELETED_NO)
            ->first();
        if (!$suplier) {
            throw new \Exception('Supplier not found');
        }
        $suplier->deleted = Supplier::DELETED_YES;
        $suplier->deleted_by = auth()->user()->id;
        $suplier->deleted_at = now();
        $suplier->save();
    }
}
