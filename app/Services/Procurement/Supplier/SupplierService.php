<?php

namespace App\Services\Procurement\Supplier;
use App\Services\Common\ImageUploadService;
use App\Models\Country;
use App\Models\State;
use App\Models\Products\AssetProduct;
use App\Models\Products\ProductMaterial;
use App\Models\Procurements\Supplier;
use App\Models\Procurements\SupplierBank;
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
        $data['products'] = Supplier::where('deleted', Supplier::DELETED_NO)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);
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
            if (!empty($check_code)) {
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
            $supplier->notes = $request->notes;
            $supplier->created_by = auth()->user()->id;
            $supplier->created_at = Carbon::now();
            $supplier->updated_by = auth()->user()->id;
            $supplier->updated_at = Carbon::now();
            $supplier->save();

          
            if (count($request->bank_name) > 0) {
                foreach ($request->bank_name as $key=>$bank) {
                    $supplier_bank = new SupplierBank();
                    $supplier_bank->supplier_id = $supplier->id;
                    $supplier_bank->bank_name = $bank;
                    $supplier_bank->account_name = $request->account_name[$key];
                    $supplier_bank->account_no = $request->account_no[$key];
                    $supplier_bank->branch = $request->branch[$key];
                    $supplier_bank->routing_number = $request->routing_number[$key];
                    $supplier_bank->swift_code = $request->swift_code[$key];
                    $supplier_bank->save();
                }
            }
            // else{
            //     throw new \Exception("Bank info not available");
            // }

            if (count($request->material_products) > 0) {
                foreach ($request->material_products as $key=>$material) {
                    $supplier_material = new SupplierProductMaterial();
                    $supplier_material->supplier_id = $supplier->id;
                    $supplier_material->bank_name = $material;
                    $supplier_material->save();
                }
            }
  
            

            // if (count($request->racks) > 0) {
            //     foreach ($request->racks as $key2=>$rack) {
            //         $checkRack = WarehouseSectionRack::where('id', $rack)
            //             ->where('deleted', WarehouseSectionRack::DELETED_NO)
            //             ->where('status', WarehouseSectionRack::STATUS_ACTIVE)
            //             ->first();
            //         if (!empty($checkRack)) {
            //             $supplier_rack = new ProductMaterialRack();
            //             $supplier_rack->warehouse_id = $request->warehouse_id;
            //             $supplier_rack->supplier_id = $supplier->id;
            //             $supplier_rack->warehouse_section_id = $checkRack->warehouse_section_id;
            //             $supplier_rack->warehouse_rack_id = $rack;
            //             $supplier_rack->save();
            //         }
            //     }
            // }else{
            //     throw new \Exception("Please select at least one rack");
            // }



        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

        // return $supplier;
    }

    public function editData($id)
    {
        $data['item'] = AssetProduct::where('id', $id)
            ->where('deleted', AssetProduct::DELETED_NO)
            ->first();
        $data['categories'] = AssetProductCategory::where('deleted', AssetProductCategory::DELETED_NO)
            ->where('status', AssetProductCategory::STATUS_ACTIVE)
            ->orderBy('name', 'asc')->get();

        if (!$data['item']) {
            throw new \Exception('Asset Product not found');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $product = AssetProduct::where('id', $id)
            ->where('deleted', AssetProduct::DELETED_NO)
            ->first();
        if (!$product) {
            throw new \Exception('Asset Product not found');
        }
        $product->asset_product_category_id = $request->asset_product_category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->updated_by = auth()->user()->id;
        $product->updated_at = now();
        $product->save();
    }

    public function delete($id)
    {
        $product = AssetProduct::where('id', $id)
            ->where('deleted', AssetProduct::DELETED_NO)
            ->first();
        if (!$product) {
            throw new \Exception('Asset Product not found');
        }
        $product->deleted = AssetProduct::DELETED_YES;
        $product->deleted_by = auth()->user()->id;
        $product->deleted_at = now();
        $product->save();
    }
}
