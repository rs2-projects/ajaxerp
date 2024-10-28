<?php

namespace App\Services\Sales\Invoice;

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
use App\Services\Common\FileUploadService;
use App\Services\Sales\InvoiceDesignService;
use App\Services\Sales\InvoicePaymentService;
use App\Traits\LatestCalculatedPurchaseCostTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InvoiceService
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
        $invoice_id = $request->invoice_id;
        $status_filter = $request->status_filter;
        $start_date_filtered = $request->start_date_filtered ?? null;
        $end_date_filtered = $request->end_date_filtered ?? null;
        $data['invoices'] = Invoice::where('deleted', Invoice::DELETED_NO)
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
        $data['view'] = view('sales.invoice._index_filtered', $data)->render();
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
        $data['invoice_date'] = Carbon::now();
        $data['payment_date'] = Carbon::now();
        $data['payment_methods'] = InvoicePayment::PAYMENT_METHODS;


        $data['accounts_sub_categories'] = AccCoaSubCategory::with('accounts')
            ->where('deleted', AccCoaSubCategory::DELETED_NO)
            ->where('status', AccCoaSubCategory::STATUS_ACTIVE)
            ->where('is_account_type', AccCoaSubCategory::IS_ACCOUNT_TYPE_YES)
            ->get();
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
            $checkBatchNumber = Invoice::where('order_no', $request->order_no)
                ->where('deleted', Invoice::DELETED_NO)
                ->first();
            if (!empty($checkBatchNumber)) {
                throw new \Exception("Order Number already exists");
            }

            $invoice = new Invoice();
            $invoice->customer_id = $request->customer_id;
            $invoice->order_no = $request->order_no;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->payment_date = $request->payment_date;
            $invoice->discount_type = $request->discount_type;
            $invoice->discount_value = $request->discount_value;
            $invoice->unloading_cost = $request->unloading_cost;
            $invoice->notes = $request->notes;
            $invoice->invoice_footer = $request->invoice_footer;
            $invoice->created_at = Carbon::now();
            $invoice->created_by = auth()->id();
            $invoice->updated_at = Carbon::now();
            $invoice->updated_by = auth()->id();
            $invoice->save();
            $invoice->invoice_no = "INVOICE - " . (1000 + $invoice->id);
            $invoice->save();

            //upload design file
            $this->invoiceDesignService->uploadDesign($request, $invoice->id);

            $total_amount = 0;
            $vat_amount = 0;

            if (isset($request->product_id) && is_array($request->product_id)) {
                foreach ($request->product_id as $key => $product) {

                    $qty = $request->qty[$key];
                    $price = $request->price[$key];
                    $tax_id = $request->tax[$key];

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
                        $item_type = InvoiceDetails::TYPE_RAW_MATERIAL;
                    }else if($type == 'raw_boards'){
                        $item_type = InvoiceDetails::TYPE_RAW_BOARD;
                    }else if($type == 'papers'){
                        $item_type = InvoiceDetails::TYPE_PAPER;
                    }else if($type == 'finished_goods'){
                        $item_type = InvoiceDetails::TYPE_FINISHED_GOODS;
                    }else if($type == 'finished_boards'){
                        $item_type = InvoiceDetails::TYPE_FINISHED_BOARD;
                    }else if($type == 'set_items'){
                        $item_type = InvoiceDetails::TYPE_SET_ITEM;
                    }

                    $invoiceDetails = new InvoiceDetails();
                    $invoiceDetails->invoice_id = $invoice->id;
                    $invoiceDetails->item_id = $product;
                    $invoiceDetails->item_type = $item_type;
                    $invoiceDetails->description = $request->description[$key];
                    $invoiceDetails->quantity = $qty;
                    $invoiceDetails->unit_price = $price;
                    $invoiceDetails->total = $qty * $price;
                    $invoiceDetails->tax_id = $tax_id;
                    $invoiceDetails->tax_rate = $tax_rate;
                    $invoiceDetails->tax_amount = $tax_amount;
                    $invoiceDetails->net_total = $amount_with_tax;
                    $invoiceDetails->created_at = Carbon::now();
                    $invoiceDetails->created_by = auth()->id();
                    $invoiceDetails->updated_at = Carbon::now();
                    $invoiceDetails->updated_by = auth()->id();
                    $invoiceDetails->save();
                    $total_amount += $invoiceDetails->total;
                    $vat_amount += $invoiceDetails->tax_amount;
                }
            }
            $discount_amount = 0;
            if ($invoice->discount_type == Invoice::DISCOUNT_TYPE_PERCENTAGE) {
                $discount_amount = (($total_amount + $vat_amount) * $invoice->discount_value) / 100;
            } else {
                $discount_amount = $invoice->discount_value;
            }

            $total_amount_with_vat = $total_amount + $vat_amount;
            $payable_amount = $total_amount_with_vat - $discount_amount + $request->unloading_cost;
            $invoice->subtotal_amount = $total_amount;
            $invoice->vat_amount = $vat_amount;
            $invoice->total_amount = $total_amount_with_vat;
            $invoice->discount_amount = $discount_amount;
            $invoice->payable_amount = $payable_amount;
            $invoice->due_amount = $payable_amount;
            $invoice->save();


            //store invoice unpaid transaction
            $invoiceCreateSaleAccount = AccCoaAccount::where('slug', 'sales')
                ->where('deleted', AccCoaAccount::DELETED_NO)
                ->first();
            $receivable_category = AccCoaAccount::where('slug', 'accounts-receivable')
                ->where('deleted', AccCoaAccount::DELETED_NO)
                ->first();
            $createUnpaidTransaction = new Transaction();
            $createUnpaidTransaction->paid_type = Transaction::PAID_TYPE_UNPAID;
            $createUnpaidTransaction->transaction_type = Transaction::TRANSACTION_TYPE_DEPOSIT;
            $createUnpaidTransaction->transaction_date = $invoice->invoice_date;
            $createUnpaidTransaction->account_id = $invoiceCreateSaleAccount->id;
            $createUnpaidTransaction->category_id = $receivable_category->id;
            $createUnpaidTransaction->reference_type = Transaction::REFERENCE_TYPE_INVOICE_CREATE;
            $createUnpaidTransaction->reference_id = $invoice->id;
            $createUnpaidTransaction->reference_description = "Invoice Create ".$invoice->invoice_no;
            $createUnpaidTransaction->net_amount = $invoice->subtotal_amount;
            $createUnpaidTransaction->total_vat_amount = $invoice->vat_amount;
            $createUnpaidTransaction->total_amount = $invoice->payable_amount;
            $createUnpaidTransaction->description = "Invoice Create ".$invoice->invoice_no;
            $createUnpaidTransaction->note = "Invoice Create ".$invoice->invoice_no;
            $createUnpaidTransaction->created_at = Carbon::now();
            $createUnpaidTransaction->created_by = auth()->user()->id;
            $createUnpaidTransaction->updated_at = Carbon::now();
            $createUnpaidTransaction->updated_by = auth()->user()->id;
            $createUnpaidTransaction->save();

            if ($request->switch) {
                //Payment
                $account = AccCoaAccount::where('id', $request->account_id)
                    ->where('deleted', AccCoaAccount::DELETED_NO)
                    ->first();
                if (!$account) {
                    throw new \Exception("Account not found");
                }

                // payment amount validation
                if ($request->amount <= 0) {
                    throw new \Exception("Invalid amount");
                }

                if ($request->amount > $invoice->due_amount) {
                    throw new \Exception("Payment amount can't be greater than due amount");
                }


                // Create Transaction
                $transaction = new Transaction();
                $transaction->paid_type = Transaction::PAID_TYPE_PAID;
                $transaction->transaction_type = Transaction::TRANSACTION_TYPE_DEPOSIT;
                $transaction->transaction_date = $request->date;
                $transaction->account_id = $account->id;
                $transaction->category_id = $receivable_category->id;
                $transaction->reference_type = Transaction::REFERENCE_TYPE_INVOICE_PAYMENT;
                $transaction->reference_id = null;
                $transaction->reference_description = $invoice->description ?? null;
                $transaction->net_amount = $request->amount;
                $transaction->total_vat_amount = 0;
                $transaction->total_amount = $request->amount;
                $transaction->description = "Invoice Payment " . $invoice->invoice_no;
                $transaction->note = $request->note;
                $transaction->created_at = Carbon::now();
                $transaction->created_by = auth()->id();
                $transaction->updated_at = Carbon::now();
                $transaction->updated_by = auth()->id();
                $transaction->save();

                $invoice->paid_amount = $request->amount;
                $invoice->due_amount = $invoice->payable_amount - $invoice->paid_amount;
                if ($invoice->payable_amount == $invoice->paid_amount) {
                    $invoice->payment_status = Invoice::PAYMENT_STATUS_PAID;
                } elseif ($invoice->payable_amount > $invoice->paid_amount) {
                    $invoice->payment_status = Invoice::PAYMENT_STATUS_PARTIAL_PAID;
                }

                if ($invoice->invoice_status == $invoice::INVOICE_STATUS_PENDING) {
                    $invoice->invoice_status = $invoice::INVOICE_STATUS_PROCESSING;
                }

                $invoice->updated_at = Carbon::now();
                $invoice->updated_by = auth()->id();
                $invoice->save();


                // create invoice payment
                $invoice_payment = $this->invoicePaymentService->store($request, $invoice->id, $transaction->id, $account->id);
                $transaction->reference_id = $invoice_payment->id;
                $transaction->save();
            }
            // receipt upload

            if ($request->hasFile('receipt')) {
                if (count($request->file('receipt')) > 0) {
                    foreach ($request->file('receipt') as $key => $file) {
                        $fileUploadService = new FileUploadService();
                        $file_path = $fileUploadService->store($request->receipt[$key], 'transaction/invoice-payment-receipt');
                        $file_path = $file_path['path'];

                        $transaction_receipt = new TransactionReceipt();
                        $transaction_receipt->transaction_id = $transaction->id;
                        $transaction_receipt->receipt = $file_path;
                        $transaction_receipt->status = TransactionReceipt::STATUS_ACTIVE;
                        $transaction_receipt->save();
                    }
                }
            }

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    //make payment
    public function makePaymentData($id)
    {
        try {
            $data['invoice'] = Invoice::where('id', $id)
                ->where('deleted', Invoice::DELETED_NO)
                ->first();

            if (!$data['invoice']) {
                throw new \Exception("Invoice not found");
            }

            if ($data['invoice']->payment_status == Invoice::PAYMENT_STATUS_PAID) {
                throw new \Exception("Payment already made");
            }

            $data['payment_methods'] = InvoicePayment::PAYMENT_METHODS;


            $data['accounts_sub_categories'] = AccCoaSubCategory::with('accounts')
                ->where('deleted', AccCoaSubCategory::DELETED_NO)
                ->where('status', AccCoaSubCategory::STATUS_ACTIVE)
                ->where('is_account_type', AccCoaSubCategory::IS_ACCOUNT_TYPE_YES)
                ->get();

            return $data;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }

    // make payment submit
    public function makePaymentSubmit($request, $id)
    {
        DB::beginTransaction();
        try {
            $invoice = Invoice::where('id', $id)
                ->where('deleted', Invoice::DELETED_NO)
                ->first();
            if (!$invoice) {
                throw new \Exception("Invoice not found");
            }

            if ($invoice->payment_status == Invoice::PAYMENT_STATUS_PAID) {
                throw new \Exception("Payment already made");
            }

            $account = AccCoaAccount::where('id', $request->account_id)
                ->where('deleted', AccCoaAccount::DELETED_NO)
                ->first();
            if (!$account) {
                throw new \Exception("Account not found");
            }

            // payment amount validation
            if ($request->amount <= 0) {
                throw new \Exception("Invalid amount");
            }

            if ($request->amount > $invoice->due_amount) {
                throw new \Exception("Payment amount can't be greater than due amount");
            }


            $receivable_category = AccCoaAccount::where('slug', 'accounts-receivable')
                ->where('deleted', AccCoaAccount::DELETED_NO)
                ->first();
            // Create Transaction
            $transaction = new Transaction();
            $transaction->paid_type = Transaction::PAID_TYPE_PAID;
            $transaction->transaction_type = Transaction::TRANSACTION_TYPE_DEPOSIT;
            $transaction->transaction_date = $request->date;
            $transaction->account_id = $account->id;
            $transaction->category_id = $receivable_category->id;
            $transaction->reference_type = Transaction::REFERENCE_TYPE_INVOICE_PAYMENT;
            $transaction->reference_id = null;
            $transaction->reference_description = null;
            $transaction->net_amount = $request->amount;
            $transaction->total_vat_amount = 0;
            $transaction->total_amount = $request->amount;
            $transaction->description = "Invoice Payment " . $invoice->invoice_no;
            $transaction->note = $request->note;
            $transaction->created_at = Carbon::now();
            $transaction->created_by = auth()->id();
            $transaction->updated_at = Carbon::now();
            $transaction->updated_by = auth()->id();
            $transaction->save();

            $invoice->paid_amount = $invoice->paid_amount + $request->amount;
            $invoice->due_amount = $invoice->payable_amount - $invoice->paid_amount;
            if ($invoice->payable_amount == $invoice->paid_amount) {
                $invoice->payment_status = Invoice::PAYMENT_STATUS_PAID;
            } elseif ($invoice->payable_amount > $invoice->paid_amount) {
                $invoice->payment_status = Invoice::PAYMENT_STATUS_PARTIAL_PAID;
            }

            if ($invoice->invoice_status == $invoice::INVOICE_STATUS_PENDING) {
                $invoice->invoice_status = $invoice::INVOICE_STATUS_PROCESSING;
            }

            $invoice->updated_at = Carbon::now();
            $invoice->updated_by = auth()->id();
            $invoice->save();

            // create invoice payment
            $invoice_payment = $this->invoicePaymentService->store($request, $invoice->id, $transaction->id, $account->id);
            $transaction->reference_id = $invoice_payment->id;
            $transaction->save();

            // receipt upload

            if ($request->hasFile('receipt')) {
                if (count($request->file('receipt')) > 0) {
                    foreach ($request->file('receipt') as $key => $file) {
                        $fileUploadService = new FileUploadService();
                        $file_path = $fileUploadService->store($request->receipt[$key], 'transaction/invoice-payment-receipt');
                        $file_path = $file_path['path'];

                        $transaction_receipt = new TransactionReceipt();
                        $transaction_receipt->transaction_id = $transaction->id;
                        $transaction_receipt->receipt = $file_path;
                        $transaction_receipt->status = TransactionReceipt::STATUS_ACTIVE;
                        $transaction_receipt->save();
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
        $invoice = Invoice::where('id', $id)
            ->where('deleted', 0)
            ->first();

        if (empty($invoice)) {
            return null;
        }
        
        $data['invoice'] = $invoice;
        return $data;
    }

    //Get Edit Invoice
    public function getEditInvoiceData($id)
    {
        $invoice = Invoice::where('id', $id)
            ->where('deleted', 0)
            ->first();
        //customer data
        $customer = Customer::where('id', $invoice->customer_id)
            ->where('status', 1)
            ->where('deleted', 0)
            ->first();
        $customer->show_image_full_url = asset($customer->show_image);
        $customer->contact_full_name = $customer->full_name;
        //invoice design
        $invoiceDesign = InvoiceDesigns::where('deleted', InvoiceDesigns::DELETED_NO)
            ->where('status', InvoiceDesigns::STATUS_ACTIVE)
            ->where('invoice_id', $id)
            ->get();
        //invoice details
        $cartItems = InvoiceDetails::where('invoice_id', $id)
            ->where('deleted', InvoiceDetails::DELETED_NO)
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
                if($type == InvoiceDetails::TYPE_RAW_MATERIAL){
                    $product = $item->product_material;
                    $item_type = 'raw_materials';
                }else if($type == InvoiceDetails::TYPE_RAW_BOARD){
                    $product = $item->product_material;
                    $item_type = 'raw_boards';
                }else if($type == InvoiceDetails::TYPE_PAPER){
                    $product = $item->product_material;
                    $item_type = 'papers';
                }else if($type == InvoiceDetails::TYPE_FINISHED_GOODS){
                    $product = $item->finishedGood;
                    $item_type = 'finished_goods';
                }else if($type == InvoiceDetails::TYPE_FINISHED_BOARD){
                    $product = $item->finishedGood;
                    $item_type = 'finished_boards';
                }else if($type == InvoiceDetails::TYPE_SET_ITEM){
                    $product = $item->set_item;
                    $item_type = 'set_items';
                }

                if ($type == InvoiceDetails::TYPE_SET_ITEM && $item?->set_item?->set_items != null) {
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
                    'invoice_details_id' => $item->id
                ];
            });
        $data['invoice'] = $invoice;
        $data['customer'] = $customer;
        $data['designs'] = $invoiceDesign;
        $data['cartItem'] = $cartItems;

        return $data;
    }

    //Update Invoice
    public function update($request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {

            $invoice = Invoice::where('id', $id)
                ->where('deleted', Invoice::DELETED_NO)
                ->first();

            if (empty($invoice)) {
                throw new \Exception("Invoice Not Found");
            }

            $checkOrderNumber = Invoice::where('order_no', $request->order_no)
                ->where('id', '!=', $id)
                ->where('deleted', Invoice::DELETED_NO)
                ->first();
                
            if (!empty($checkOrderNumber)) {
                throw new \Exception("Order Number already exists");
            }
            
            $invoice->customer_id = $request->customer_id;
            $invoice->order_no = $request->order_no;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->payment_date = $request->payment_date;
            $invoice->discount_type = $request->discount_type;
            $invoice->discount_value = $request->discount_value;
            $invoice->unloading_cost = $request->unloading_cost;
            $invoice->notes = $request->notes;
            $invoice->invoice_footer = $request->invoice_footer;
            $invoice->updated_at = Carbon::now();
            $invoice->updated_by = auth()->id();
            $invoice->save();

            if (isset($request->product_id) && is_array($request->product_id)) {
                // $invoice_details_ids = $request->invoice_details_id ?? [];
                $invoice_details_ids = array_filter($request->invoice_details_id, function ($value) {
                    return !is_null($value);
                });
                $delete_not_exist_product = InvoiceDetails::where('invoice_id', $invoice->id)
                    ->whereNotIn('id', $invoice_details_ids)
                    ->where('deleted', InvoiceDetails::DELETED_NO)
                    ->delete();
            }

            $subtotal_amount = 0;
            $total_vat_amount = 0;

            if (isset($request->product_id) && is_array($request->product_id)) {
                foreach ($request->product_id as $key => $product) {
                    $qty = $request->qty[$key];
                    $price = $request->price[$key];
                    $tax_id = $request->tax[$key];

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
                        $item_type = InvoiceDetails::TYPE_RAW_MATERIAL;
                    }else if($type == 'raw_boards'){
                        $item_type = InvoiceDetails::TYPE_RAW_BOARD;
                    }else if($type == 'papers'){
                        $item_type = InvoiceDetails::TYPE_PAPER;
                    }else if($type == 'finished_goods'){
                        $item_type = InvoiceDetails::TYPE_FINISHED_GOODS;
                    }else if($type == 'finished_boards'){
                        $item_type = InvoiceDetails::TYPE_FINISHED_BOARD;
                    }else if($type == 'set_items'){
                        $item_type = InvoiceDetails::TYPE_SET_ITEM;
                    }

                    $invoiceDetails = InvoiceDetails::where('invoice_id', $invoice->id)
                        ->where('item_id', $product)
                        ->where('item_type', $item_type)
                        ->where('deleted', InvoiceDetails::DELETED_NO)
                        ->first();

                    if (empty($invoiceDetails)) {
                        $invoiceDetails = new InvoiceDetails();
                        $invoiceDetails->invoice_id = $invoice->id;
                        $invoiceDetails->item_id = $product;
                        $invoiceDetails->created_at = Carbon::now();
                        $invoiceDetails->created_by = auth()->id();
                    }

                    $invoiceDetails->item_type = $item_type;
                    $invoiceDetails->description = $request->description[$key];
                    $invoiceDetails->quantity = $qty;
                    $invoiceDetails->unit_price = $price;
                    $invoiceDetails->total = $qty * $price;
                    $invoiceDetails->tax_id = $tax_id;
                    $invoiceDetails->tax_rate = $tax_rate;
                    $invoiceDetails->tax_amount = $tax_amount;
                    $invoiceDetails->net_total = $amount_with_tax;
                    $invoiceDetails->updated_at = Carbon::now();
                    $invoiceDetails->updated_by = auth()->id();
                    $invoiceDetails->save();

                    $subtotal_amount += $invoiceDetails->total;
                    $total_vat_amount += $invoiceDetails->tax_amount;

                }
            }
            
            //invocie design delete
            $design_ids = $request->design_id ?? [];
            $deletedDesigns = InvoiceDesigns::where('deleted', InvoiceDesigns::DELETED_NO)
                ->where('status', InvoiceDesigns::STATUS_ACTIVE)
                ->where('invoice_id', $invoice->id)
                ->whereNotIn('id', $design_ids)
                ->get();
            foreach ($deletedDesigns as $deletedDesign) {
                unlink($deletedDesign->design);
                $deletedDesign->delete();
            }

            //upload design file
            $image_path = null;
            if ($request->hasFile('design') && $request->design != null) {
                $fileUploadService = new FileUploadService();
                foreach ($request->file('design') as $design) {
                    $design_name = $design->getClientOriginalName();
                    $file_path = $fileUploadService->store($design, 'inventory/invoice', $design_name);
                    $file_name = $file_path['name'];
                    $file_path = $file_path['path'];
                    $design = new InvoiceDesigns();
                    $design->invoice_id = $invoice->id;
                    $design->design_name = $file_name;
                    $design->design = $file_path ?? null;
                    $design->created_by = auth()->id();
                    $design->created_at = Carbon::now();
                    $design->updated_by = auth()->id();
                    $design->updated_at = Carbon::now();
                    $design->save();
                }
            }

            $total_discount_amount = 0;
            if ($invoice->discount_type == Invoice::DISCOUNT_TYPE_PERCENTAGE) {
                $total_discount_amount = (($subtotal_amount + $total_vat_amount) * $request->discount_value) / 100;
            } else {
                $total_discount_amount = $request->discount_value;
            }

            $total_amount_with_vat = $subtotal_amount + $total_vat_amount;
            $payable_amount = $total_amount_with_vat - $total_discount_amount + $request->unloading_cost;

            $due_amount = $payable_amount - $invoice->paid_amount;
            
            $invoice->subtotal_amount = $subtotal_amount;
            $invoice->vat_amount = $total_vat_amount;
            $invoice->total_amount = $total_amount_with_vat;
            $invoice->discount_amount = $total_discount_amount;
            $invoice->payable_amount = $payable_amount;
            $invoice->due_amount = $due_amount;
            if ($invoice->due_amount <= 0) {
                $invoice->payment_status = Invoice::PAYMENT_STATUS_PAID;
            }
            $invoice->save();

            // update transaction
            $transaction = Transaction::where('deleted', Transaction::DELETED_NO)
                ->where('reference_id', $invoice->id)
                ->where('paid_type', Transaction::PAID_TYPE_UNPAID)
                ->where('transaction_type', Transaction::TRANSACTION_TYPE_DEPOSIT)
                ->where('reference_type', Transaction::REFERENCE_TYPE_INVOICE_CREATE)
                ->orderBy('id', 'desc')
                ->first();
            if ($transaction) {
                $transaction->net_amount = $invoice->payable_amount;
                $transaction->total_vat_amount = 0;
                $transaction->total_amount = $invoice->payable_amount;
                $transaction->updated_at = Carbon::now();
                $transaction->updated_by = auth()->id();
                $transaction->save();
                $invoice->save();
            }

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


}
