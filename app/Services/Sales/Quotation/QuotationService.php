<?php

namespace App\Services\Sales\Quotation;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaSubCategory;
use App\Models\Accounting\Transaction;
use App\Models\Accounting\TransactionReceipt;
use App\Models\Products\FinishedGoods;
use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialSet;
use App\Models\Sales\Customer;
use App\Models\Sales\Invoice;
use App\Models\Sales\InvoiceDesigns;
use App\Models\Sales\InvoiceDetails;
use App\Models\Sales\InvoicePayment;
use App\Models\Sales\Quotation;
use App\Models\Sales\QuotationDetails;
use App\Models\Sales\QuotationImages;
use App\Services\Common\FileUploadService;
use App\Services\Sales\InvoiceDesignService;
use App\Services\Sales\InvoicePaymentService;
use App\Traits\LatestCalculatedPurchaseCostTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class QuotationService
{   
    use LatestCalculatedPurchaseCostTrait;
    private InvoicePaymentService $invoicePaymentService;
    private InvoiceDesignService $invoiceDesignService;
    private $paginate_limit;

    public function __construct()
    {
        $this->invoiceDesignService = new InvoiceDesignService();
        $this->invoicePaymentService = new InvoicePaymentService();
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
        $quotation_no = $request->quotation_id;
        $status_filter = $request->status_filter;
        $start_date_filtered = $request->start_date_filtered ?? null;
        $end_date_filtered = $request->end_date_filtered ?? null;
        $data['quotations'] = Quotation::where('deleted', Invoice::DELETED_NO)
            ->where(function ($q) use ($quotation_no) {
                if ($quotation_no != '') {
                    $q->where('quotation_no', 'like', '%' . $quotation_no . '%');
                }
            }) 
            ->where(function ($q) use ($status_filter) {
                if ($status_filter != '') {
                    $q->where('quotation_status', 'like', '%' . $status_filter . '%');
                }
            })
            ->where(function ($q) use ($start_date_filtered, $end_date_filtered) {
                if ($start_date_filtered != null) {
                    $q->whereDate('quotation_date', '>=', $start_date_filtered);
                }
                if ($end_date_filtered != null) {
                    $q->whereDate('quotation_date', '<=', $end_date_filtered);
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('sales.quotation._index_filtered', $data)->render();
        return $data;
    }

    //Get Design
    public function getDesign($id)
    {
        $data['invoice'] = Invoice::where('deleted', Invoice::DELETED_NO)
            ->where('id', $id)
            ->first();
        $data['designs'] = InvoiceDesigns::where('invoice_id', $id)->get();
        $data['view'] = view('sales.invoice.__design_modal_data', $data)->render();
        return $data;
    }

    //create invoice
    public function createData()
    {
        $data['quotation_date'] = Carbon::now();
        return $data;
    }

    //Get all customers
    public function getAllCustomer($request)
    {
        if (isset($request->q) && ($request->q != '') && ($request->q != null)) {
            $search_keyword = $request->q;
        } else {
            $search_keyword = null;
        }

        $data['customers'] = Customer::where('status', Customer::STATUS_ACTIVE)
            ->where('deleted', Customer::DELETED_NO)
            ->when($search_keyword, function ($q) use ($search_keyword) {
                $q->where(function ($j) use ($search_keyword) {
                    $j->where('business_name', 'LIKE', '%' . $search_keyword . '%')
                        ->orWhere('phone', 'LIKE', '%' . $search_keyword . '%');
                });
            })
            ->get()
            ->map(function ($customer) {
                $customer->show_image_full_url = asset($customer->show_image);
                $customer->contact_full_name = $customer->full_name;
                return $customer;
            });

        return $data;

    }

    public function getAllFinishedGoods()
    {
        $datTypes = [
            ['model' => FinishedGoods::class, 'type' => 'finished_goods'],
            ['model' => FinishedGoods::class, 'type' => 'finished_boards'],
            ['model' => ProductMaterial::class, 'type' => 'raw_materials'],
            ['model' => ProductMaterial::class, 'type' => 'raw_boards'],
            ['model' => ProductMaterial::class, 'type' => 'papers'],
            ['model' => ProductMaterialSet::class, 'type' => 'set_items'],
        ];

        $data = [];
        foreach ($datTypes as $typeData) {
            $products = $typeData['model']::where('status', $typeData['model']::STATUS_ACTIVE)
                ->where('deleted', $typeData['model']::DELETED_NO);

            if ($typeData['type'] != 'set_items') {
                $type_value = [
                    'finished_goods' => FinishedGoods::TYPE_OTHERS,
                    'finished_boards' => FinishedGoods::TYPE_BOARD,
                    'raw_materials' => ProductMaterial::TYPE_OTHERS,
                    'raw_boards' => ProductMaterial::TYPE_BOARD,
                    'papers' => ProductMaterial::TYPE_PAPER,
                ];
                $type = $type_value[$typeData['type']] ?? null;
            
                if ($type !== null) {
                    $products->where('type', $type);
                }
            }

            $products = $products->get()
                ->map(function ($item) use ($typeData) {
                    $itemTax = null;

                    if ($typeData['model'] == ProductMaterial::class && $item->tax != null) {
                        $itemTax = $item->tax;
                    } else {
                        $itemTax = (object) [
                            'id' => null,
                            'name' => null,
                            'tax_rate' => 0,
                        ];
                    }

                    if($typeData['type'] == 'finished_boards'){
                        $srp = $this->getLatestCalculatedBoardCost($item->id);
                    }elseif($typeData['type'] == 'finished_goods'){
                        $srp = 0;
                    }else{
                        $srp = $item->rp_srp;
                    }

                    if ($typeData['model'] == ProductMaterialSet::class && $item->set_items != null) {
                        $material_items = $item?->set_items?->map(function($setItem) {
                            return [
                                'name' => $setItem?->productMaterial?->name,
                                'code' => $setItem?->productMaterial?->code,
                                'quantity' => $setItem->quantity,
                            ];
                        });
                    } else {
                        $material_items = null;
                    }
                    $productData = [
                        'id' => $item->id,
                        'name' => $item?->name,
                        'code' => $item?->code,
                        'length' => $item?->length,
                        'width' => $item?->width,
                        'thickness' => $item?->thickness,
                        'show_image' => asset($item->show_image)??null,
                        'tax' => $itemTax,
                        'srp' => $srp,
                        'item_type' => $typeData['type'],
                        'material_items' => $material_items,
                    ];

                    return $productData;
                });

            $data[$typeData['type']] = $products;
        }
        return $data;
    }

    public function getAllTaxes($request)
    {
        $coaSubCat = AccCoaSubCategory::where('is_sales_tax', AccCoaSubCategory::IS_SALES_TAX_YES)
            ->where('status', AccCoaSubCategory::STATUS_ACTIVE)
            ->where('deleted', AccCoaSubCategory::DELETED_NO)
            ->first();
        if (!empty($coaSubCat)) {
            $data['vat_taxes'] = AccCoaAccount::where('acc_coa_sub_category_id', $coaSubCat->id)
                ->where('status', AccCoaAccount::STATUS_ACTIVE)
                ->where('deleted', AccCoaAccount::DELETED_NO)
                ->get();
        } else {
            $data['vat_taxes'] = [];
        }


        return $data;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            // dd($request->all());
            $checkRefNumber = Quotation::where('ref_no', $request->ref_no)
                ->where('deleted', Quotation::DELETED_NO)
                ->first();
            if (!empty($checkRefNumber)) {
                throw new \Exception("Ref Number already exists");
            }

            $quotation = new Quotation();
            $quotation->customer_id = $request->customer_id;
            $quotation->ref_no = $request->ref_no;
            $quotation->quotation_date = $request->quotation_date;
            $quotation->project_name = $request->project_name;
            $quotation->description = $request->project_description;
            $quotation->discount_type = $request->discount_type;
            $quotation->discount_value = $request->discount_value;
            $quotation->notes = $request->notes;

            $quotation->unloading_cost = $request->unloading_cost;
            $quotation->first_down_payment_percent = $request->down_payment_percent;
            
            $quotation->created_at = Carbon::now();
            $quotation->created_by = auth()->id();
            $quotation->updated_at = Carbon::now();
            $quotation->updated_by = auth()->id();
            $quotation->save();
            $quotation->quotation_no = "QT - " . (1000 + $quotation->id);
            $quotation->save();

            //upload design file
            // $this->invoiceDesignService->uploadDesign($request, $invoice->id);

            $total_amount = 0;
            $vat_amount = 0;

            if (isset($request->product_id) && is_array($request->product_id)) {
                foreach ($request->product_id as $key => $product) {

                    $qty = $request->qty[$key];
                    $price = $request->price[$key];
                    $tax_id = $request->tax[$key];
                    $item_name = $request->item_name[$key];

                    $amount_without_tax = $qty * $price;
                    $amount_with_tax = $amount_without_tax;
                    $tax_rate = 0;
                    $tax_amount = 0;
                    if ($tax_id != null) {
                        $tax = AccCoaAccount::where('status', AccCoaAccount::STATUS_ACTIVE)
                            ->where('deleted', AccCoaAccount::DELETED_NO)
                            ->where('id', $tax_id)
                            ->first();
                        if (!empty($tax)) {
                            $tax_rate = $tax->tax_rate;
                            $amount_with_tax = $amount_without_tax + ($amount_without_tax * $tax_rate / 100);
                            $tax_amount = $amount_without_tax * $tax_rate / 100;
                        }else{
                            $tax_rate = 0;
                            $amount_with_tax = $amount_without_tax;
                            $tax_amount = 0;
                        }
                    }

                    $type = $request->item_type[$key];
                    if($type == 'raw_materials'){
                        $item_type = QuotationDetails::TYPE_RAW_MATERIAL;
                    }elseif($type == 'raw_boards'){
                        $item_type = QuotationDetails::TYPE_RAW_BOARD;
                    }elseif($type == 'papers'){
                        $item_type = QuotationDetails::TYPE_PAPER;
                    }elseif($type == 'finished_goods'){
                        $item_type = QuotationDetails::TYPE_FINISHED_GOODS;
                    }elseif($type == 'finished_boards'){
                        $item_type = QuotationDetails::TYPE_FINISHED_BOARD;
                    }elseif($type == 'set_items'){
                        $item_type = QuotationDetails::TYPE_SET_ITEM;
                    }elseif($type == 'custom_item') {
                        $item_type = QuotationDetails::TYPE_CUSTOM_ITEM;
                    }

                    $quotationDetails = new QuotationDetails();
                    $quotationDetails->quotation_id = $quotation->id;
                    $quotationDetails->item_id = $product;
                    $quotationDetails->item_type = $item_type;
                    $quotationDetails->item_name = $item_name;
                    $quotationDetails->description = $request->description[$key];
                    $quotationDetails->quantity = $qty;
                    $quotationDetails->unit_price = $price;
                    $quotationDetails->total = $qty * $price;
                    $quotationDetails->tax_id = $tax_id;
                    $quotationDetails->tax_rate = $tax_rate;
                    $quotationDetails->tax_amount = $tax_amount;
                    $quotationDetails->net_total = $amount_with_tax;
                    $quotationDetails->created_at = Carbon::now();
                    $quotationDetails->created_by = auth()->id();
                    $quotationDetails->updated_at = Carbon::now();
                    $quotationDetails->updated_by = auth()->id();
                    $quotationDetails->save();
                    $total_amount += $quotationDetails->total;
                    $vat_amount += $quotationDetails->tax_amount;
                }
            }

            $discount_amount = 0;
            if ($quotation->discount_type == Quotation::DISCOUNT_TYPE_PERCENTAGE) {
                $discount_amount = (($total_amount + $vat_amount) * $quotation->discount_value) / 100;
            } else {
                $discount_amount = $quotation->discount_value;
            }

            $quotation->subtotal_amount = $total_amount;
            $quotation->vat_amount = $vat_amount;
            $quotation->total_amount = $total_amount + $vat_amount;
            $quotation->discount_amount = $discount_amount;
            $quotation->payable_amount = $total_amount + $vat_amount - $discount_amount;
            $quotation->save();

            if ($request->hasFile('gallery')) {
                if (count($request->file('gallery')) > 0) {
                    foreach ($request->file('gallery') as $key => $file) {
                        if($request->hasFile('gallery.'.$key)) {
                            $fileUploadService = new FileUploadService();
                            $file_path = $fileUploadService->store($request->file('gallery.'.$key), 'quotation/gallery');
                            $file_path = $file_path['path'];

                            $quotationImage = new QuotationImages();
                            $quotationImage->quotation_id = $quotation->id;
                            $quotationImage->image = $file_path;
                            $quotationImage->image_name = $request->file('gallery.'.$key)->getClientOriginalName();
                            $quotationImage->status = QuotationImages::STATUS_ACTIVE;
                            $quotationImage->save();
                        }
                    }
                }
            }

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    //Edit Invoice
    public function editData($id)
    {
        $quotation = Quotation::where('id', $id)
            ->where('deleted', 0)
            ->first();

        if (empty($quotation)) {
            return null;
        }
        
        $data['quotation'] = $quotation;
        return $data;
    }

    //Get Edit Invoice
    public function getEditQuotationData($id)
    {
        $quotation = Quotation::where('id', $id)
            ->where('deleted', 0)
            ->first();
        //customer data
        $customer = Customer::where('id', $quotation->customer_id)
            ->where('status', 1)
            ->where('deleted', 0)
            ->first();
        $customer->show_image_full_url = asset($customer->show_image);
        $customer->contact_full_name = $customer->full_name;
       

        //invoice details
        $cartItems = QuotationDetails::where('quotation_id', $id)
            ->where('deleted', QuotationDetails::DELETED_NO)
            ->get()
            ->map(function ($item) {
                if ($item->tax == null) {
                    $itemTax = (object)[
                        'id' => null,
                        'name' => null,
                        'tax_rate' => 0,
                    ];
                } else {
                    $itemTax = $item->tax;
                }

                $type = $item->item_type;
                if($type == QuotationDetails::TYPE_RAW_MATERIAL){
                    $product = $item->product_material;
                    $item_type = 'raw_materials';
                }else if($type == QuotationDetails::TYPE_RAW_BOARD){
                    $product = $item->product_material;
                    $item_type = 'raw_boards';
                }else if($type == QuotationDetails::TYPE_PAPER){
                    $product = $item->product_material;
                    $item_type = 'papers';
                }else if($type == QuotationDetails::TYPE_FINISHED_GOODS){
                    $product = $item->finishedGood;
                    $item_type = 'finished_goods';
                }else if($type == QuotationDetails::TYPE_FINISHED_BOARD){
                    $product = $item->finishedGood;
                    $item_type = 'finished_boards';
                }else if($type == QuotationDetails::TYPE_SET_ITEM){
                    $product = $item->set_item;
                    $item_type = 'set_items';
                } else {
                    $product = null;
                    
                    $product = new \stdClass();
                    $product->id = 0;
                    $product->name = $item->item_name;
                    $product->code = '';
                    $product->item_type = 'custom_item';
                    $product->show_image = asset('assets/img/placeholder.jpg');
                    $product->length = 0;
                    $product->width = 0;
                    $product->thickness = 0;
                    $product->unit_type = '';
                    $product->tax = null;
                    $product->unit_price = 0;
                    $product->net_total = 0;
                    $product->description = $item->description;
                    $product->set_items = null;
                    $item_type = 'custom_item';
                }

                if ($type == QuotationDetails::TYPE_SET_ITEM && $item?->set_item?->set_items != null) {
                    $material_items = $item?->set_item?->set_items?->map(function($setItem) {
                        return [
                            'name' => $setItem?->productMaterial?->name,
                            'code' => $setItem?->productMaterial?->code,
                            'quantity' => $setItem->quantity,
                        ];
                    });
                } else {
                    $material_items = null;
                }
                
                return [
                    'id' => $product?->id,
                    'name' => $product?->name,
                    'code' => $product?->code,
                    'show_image' => asset($product?->show_image),
                    'length' => $product?->length,
                    'width' => $product?->width,
                    'thickness' => $product?->thickness,
                    'description' => $item->description,
                    'qty' => $item->quantity,
                    'price' => formatNumber($item->unit_price),
                    'unit_price' => formatNumber($item->unit_price),
                    'total_price' => formatNumber($item->net_total),
                    'tax' => $itemTax,
                    'item_type' => $item_type,
                    'srp' => formatNumber($item->unit_price),
                    'material_items' => $material_items,
                    'quotation_details_id' => $item->id
                ];
            });
        $data['quotation'] = $quotation;
        $data['customer'] = $customer;
        $data['cartItem'] = $cartItems;

        return $data;
    }

    //Update Quotation
    public function update($request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {

            $quotation = Quotation::where('id', $id)
                ->where('deleted', Quotation::DELETED_NO)
                ->first();

            if (empty($quotation)) {
                throw new \Exception("Quotation Not Found");
            }

            $checkRefNumber = Quotation::where('ref_no', $request->ref_no)
                ->where('id', '!=', $id)
                ->where('deleted', Quotation::DELETED_NO)
                ->first();
            if (!empty($checkRefNumber)) {
                throw new \Exception("Ref Number already exists");
            }
            
            $quotation->customer_id = $request->customer_id;
            $quotation->ref_no = $request->ref_no;
            $quotation->quotation_date = $request->quotation_date;
            $quotation->project_name = $request->project_name;
            $quotation->description = $request->project_description;
            $quotation->discount_type = $request->discount_type;
            $quotation->discount_value = $request->discount_value;
            $quotation->notes = $request->notes;

            $quotation->unloading_cost = $request->unloading_cost;
            $quotation->first_down_payment_percent = $request->down_payment_percent;

            $quotation->updated_at = Carbon::now();
            $quotation->updated_by = auth()->id();
            $quotation->save();

            if (isset($request->quotation_details_id) && is_array($request->quotation_details_id)) {
                $quotation_details_id = array_filter($request->quotation_details_id, function ($value) {
                    return !is_null($value);
                });
                $delete_not_exist_product = QuotationDetails::where('quotation_id', $quotation->id)
                    ->whereNotIn('id', $quotation_details_id)
                    ->where('deleted', QuotationDetails::DELETED_NO)
                    ->delete();
            }

            $subtotal_amount = 0;
            $total_vat_amount = 0;

            if (isset($request->product_id) && is_array($request->product_id)) {
                foreach ($request->product_id as $key => $product) {
                    $qty = $request->qty[$key];
                    $price = $request->price[$key];
                    $tax_id = $request->tax[$key];
                    $item_name = $request->item_name[$key];

                    $amount_without_tax = $qty * $price;
                    $amount_with_tax = 0;
                    $tax_rate = 0;
                    $tax_amount = 0;
                    if ($tax_id != null) {
                        $tax = AccCoaAccount::where('status', AccCoaAccount::STATUS_ACTIVE)
                            ->where('deleted', AccCoaAccount::DELETED_NO)
                            ->where('id', $tax_id)
                            ->first();
                        if (!empty($tax)) {
                            $tax_rate = $tax->tax_rate;
                            $amount_with_tax = $amount_without_tax + ($amount_without_tax * $tax_rate / 100);
                            $tax_amount = $amount_without_tax * $tax_rate / 100;
                        }else{
                            $tax_rate = 0;
                            $amount_with_tax = $amount_without_tax;
                            $tax_amount = 0;
                        }
                    }

                    $type = $request->item_type[$key];
                    if($type == 'raw_materials'){
                        $item_type = QuotationDetails::TYPE_RAW_MATERIAL;
                    }else if($type == 'raw_boards'){
                        $item_type = QuotationDetails::TYPE_RAW_BOARD;
                    }else if($type == 'papers'){
                        $item_type = QuotationDetails::TYPE_PAPER;
                    }else if($type == 'finished_goods'){
                        $item_type = QuotationDetails::TYPE_FINISHED_GOODS;
                    }else if($type == 'finished_boards'){
                        $item_type = QuotationDetails::TYPE_FINISHED_BOARD;
                    }else if($type == 'set_items'){
                        $item_type = QuotationDetails::TYPE_SET_ITEM;
                    }elseif($type == 'custom_item') {
                        $item_type = QuotationDetails::TYPE_CUSTOM_ITEM;
                    }

                    $quotationDetails = QuotationDetails::where('quotation_id', $quotation->id)
                        ->where('item_id', $product)
                        ->where('item_type', $item_type)
                        ->where('deleted', QuotationDetails::DELETED_NO)
                        ->first();

                    if (empty($quotationDetails)) {
                        $quotationDetails = new QuotationDetails();
                        $quotationDetails->quotation_id = $quotation->id;
                        $quotationDetails->item_id = $product;
                        $quotationDetails->created_at = Carbon::now();
                        $quotationDetails->created_by = auth()->id();
                    }

                    $quotationDetails->item_type = $item_type;
                    $quotationDetails->item_name = $item_name;
                    $quotationDetails->description = $request->description[$key];
                    $quotationDetails->quantity = $qty;
                    $quotationDetails->unit_price = $price;
                    $quotationDetails->total = $qty * $price;
                    $quotationDetails->tax_id = $tax_id;
                    $quotationDetails->tax_rate = $tax_rate;
                    $quotationDetails->tax_amount = $tax_amount;
                    $quotationDetails->net_total = $amount_with_tax;
                    $quotationDetails->updated_at = Carbon::now();
                    $quotationDetails->updated_by = auth()->id();
                    $quotationDetails->save();

                    $subtotal_amount += $quotationDetails->total;
                    $total_vat_amount += $quotationDetails->tax_amount;

                }
            }
            
            //gallery images delete
            if(isset($request->pre_gallery_id) && is_array($request->pre_gallery_id)) {
                $quotationImages = QuotationImages::where('quotation_id', $quotation->id)
                    ->whereNotIn('id', $request->pre_gallery_id)
                    ->get();
                foreach ($quotationImages as $quotationImage) {
                    unlink($quotationImage->image);
                    $quotationImage->delete();
                }
            } else {
                $quotationImages = QuotationImages::where('quotation_id', $quotation->id)
                    ->get();
                foreach ($quotationImages as $quotationImage) {
                    unlink($quotationImage->image);
                    $quotationImage->delete();
                }
            }
            

            //upload design file
            $image_path = null;
            if ($request->hasFile('gallery')) {
                if (count($request->file('gallery')) > 0) {
                    foreach ($request->file('gallery') as $key => $file) {
                        if($request->hasFile('gallery.'.$key)) {
                            $fileUploadService = new FileUploadService();
                            $file_path = $fileUploadService->store($request->file('gallery.'.$key), 'quotation/gallery');
                            $file_path = $file_path['path'];

                            if(isset($request->pre_gallery_id[$key]) && ($request->pre_gallery_id[$key] != '')) {
                                $quotationImage = QuotationDetails::where('id', $request->pre_gallery_id[$key])
                                    ->where('quotation_id', $quotation->id)
                                    ->first();
                            } else {
                                $quotationImage = new QuotationImages();
                            }
                            
                            $quotationImage->quotation_id = $quotation->id;
                            $quotationImage->image = $file_path;
                            $quotationImage->image_name = $request->file('gallery.'.$key)->getClientOriginalName();
                            $quotationImage->status = QuotationImages::STATUS_ACTIVE;
                            $quotationImage->save();
                        }
                    }
                }
            }

            $total_discount_amount = 0;
            if ($quotation->discount_type == Quotation::DISCOUNT_TYPE_PERCENTAGE) {
                $total_discount_amount = (($subtotal_amount + $total_vat_amount) * $quotation->discount_value) / 100;
            } else {
                $total_discount_amount = $quotation->discount_value;
            }

            $quotation->subtotal_amount = $subtotal_amount;
            $quotation->vat_amount = $total_vat_amount;
            $quotation->total_amount = $subtotal_amount + $total_vat_amount;
            $quotation->discount_amount = $total_discount_amount;
            $quotation->payable_amount = $subtotal_amount + $total_vat_amount - $total_discount_amount;
            $quotation->save();

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    //Delete Invoice
    public function delete($id)
    {
        $invoice = Invoice::where('deleted', Invoice::DELETED_NO)
            ->where('id', $id)
            ->first();
        if (!$invoice) {
            throw new \Exception('Invoice not found');
        }
        $invoice->deleted = Invoice::DELETED_YES;
        $invoice->deleted_at = Carbon::now();
        $invoice->deleted_by = auth()->id();
        $invoice->save();
    }

    // delete design
    public function deleteDesign($id)
    {
        $design = InvoiceDesigns::where('deleted', InvoiceDesigns::DELETED_NO)
            ->where('status', InvoiceDesigns::STATUS_ACTIVE)
            ->where('id', $id)
            ->first();
        if (!$design) {
            throw new \Exception('Invoice design not found');
        }
        $design->deleted = InvoiceDesigns::DELETED_YES;
        $design->deleted_at = Carbon::now();
        $design->deleted_by = auth()->id();
        $design->save();
    }

    public function convertToInvoice($id) {
        $data['invoice_date'] = Carbon::now();
        $data['payment_date'] = Carbon::now();
        $data['payment_methods'] = InvoicePayment::PAYMENT_METHODS;


        $data['accounts_sub_categories'] = AccCoaSubCategory::with('accounts')
            ->where('deleted', AccCoaSubCategory::DELETED_NO)
            ->where('status', AccCoaSubCategory::STATUS_ACTIVE)
            ->where('is_account_type', AccCoaSubCategory::IS_ACCOUNT_TYPE_YES)
            ->get();
        
        $data['quotation'] = Quotation::with('details')
            ->where('id', $id)
            ->where('deleted', Quotation::DELETED_NO)
            ->first();
        return $data;
    }

     //Get Edit Invoice
     public function getConvertToInvoiceData($id)
     {
         $quotation = Quotation::where('id', $id)
             ->where('deleted', 0)
             ->first();
         //customer data
         $customer = Customer::where('id', $quotation->customer_id)
             ->where('status', 1)
             ->where('deleted', 0)
             ->first();
         $customer->show_image_full_url = asset($customer->show_image);
         $customer->contact_full_name = $customer->full_name;
        
 
         //invoice details
         $cartItems = QuotationDetails::where('quotation_id', $id)
             ->where('deleted', QuotationDetails::DELETED_NO)
             ->where('item_type', '!=', QuotationDetails::TYPE_CUSTOM_ITEM)
             ->get()
             ->map(function ($item) {
                 if ($item->tax == null) {
                     $itemTax = (object)[
                         'id' => null,
                         'name' => null,
                         'tax_rate' => 0,
                     ];
                 } else {
                     $itemTax = $item->tax;
                 }
 
                 $type = $item->item_type;
                 if($type == QuotationDetails::TYPE_RAW_MATERIAL){
                     $product = $item->product_material;
                     $item_type = 'raw_materials';
                 }else if($type == QuotationDetails::TYPE_RAW_BOARD){
                     $product = $item->product_material;
                     $item_type = 'raw_boards';
                 }else if($type == QuotationDetails::TYPE_PAPER){
                     $product = $item->product_material;
                     $item_type = 'papers';
                 }else if($type == QuotationDetails::TYPE_FINISHED_GOODS){
                     $product = $item->finishedGood;
                     $item_type = 'finished_goods';
                 }else if($type == QuotationDetails::TYPE_FINISHED_BOARD){
                     $product = $item->finishedGood;
                     $item_type = 'finished_boards';
                 }else if($type == QuotationDetails::TYPE_SET_ITEM){
                     $product = $item->set_item;
                     $item_type = 'set_items';
                 } else {
                     $product = null;
                     
                     $product = new \stdClass();
                     $product->id = 0;
                     $product->name = $item->item_name;
                     $product->code = '';
                     $product->item_type = 'custom_item';
                     $product->show_image = asset('assets/img/placeholder.jpg');
                     $product->length = 0;
                     $product->width = 0;
                     $product->thickness = 0;
                     $product->unit_type = '';
                     $product->tax = null;
                     $product->unit_price = 0;
                     $product->net_total = 0;
                     $product->description = $item->description;
                     $product->set_items = null;
                     $item_type = 'custom_item';
                 }
 
                 if ($type == QuotationDetails::TYPE_SET_ITEM && $item?->set_item?->set_items != null) {
                     $material_items = $item?->set_item?->set_items?->map(function($setItem) {
                         return [
                             'name' => $setItem?->productMaterial?->name,
                             'code' => $setItem?->productMaterial?->code,
                             'quantity' => $setItem->quantity,
                         ];
                     });
                 } else {
                     $material_items = null;
                 }
                 
                 return [
                     'id' => $product?->id,
                     'name' => $product?->name,
                     'code' => $product?->code,
                     'show_image' => asset($product?->show_image),
                     'length' => $product?->length,
                     'width' => $product?->width,
                     'thickness' => $product?->thickness,
                     'description' => $item->description,
                     'qty' => $item->quantity,
                     'price' => formatNumber($item->unit_price),
                     'unit_price' => formatNumber($item->unit_price),
                     'total_price' => formatNumber($item->net_total),
                     'tax' => $itemTax,
                     'item_type' => $item_type,
                     'srp' => formatNumber($item->unit_price),
                     'material_items' => $material_items,
                     'quotation_details_id' => $item->id
                 ];
             });
         $data['quotation'] = $quotation;
         $data['customer'] = $customer;
         $data['cartItem'] = $cartItems;
 
         return $data;
     }
}
