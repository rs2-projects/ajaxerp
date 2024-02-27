<?php

namespace App\Services\Sales\Invoice;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaSubCategory;
use App\Models\Products\FinishedGoods;
use App\Models\Sales\Customer;
use App\Models\Sales\Invoice;
use App\Models\Sales\InvoiceDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    // index data
    public function indexData()
    {
        $data['months'] = config('commonData.month_names');
        $data['statuses'] = Invoice::INVOICE_STATUSES;
        return $data;
    }
    //filtered data
    public function indexFilteredData($request)
    {
        $status_filter = $request->status_filter;
        $month_filter = $request->month_filter;
        $data['invoices'] = Invoice::where('deleted', Invoice::DELETED_NO)
            ->where(function ($q) use ($status_filter,$month_filter){
                if ($status_filter !=''){
                    $q->where('invoice_status', 'like', '%'.$status_filter.'%');
                }
                if ($month_filter !=''){
                    $q->where('invoice_status', 'like', '%'.$month_filter.'%');
                }

            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        return $data;
    }
    //create invoice
    public function createData()
    {
       $data['invoice_date'] = Carbon::now();
        $data['payment_date'] = Carbon::now();
        return $data;
    }
    //Get all customers
    public function getAllCustomer($request)
    {
        if(isset($request->q) && ($request->q != '') && ($request->q != null)) {
            $search_keyword = $request->q;
        } else {
            $search_keyword = null;
        }

        $data['customers'] = Customer::where('status', Customer::STATUS_ACTIVE)
            ->where('deleted', Customer::DELETED_NO)
            ->when($search_keyword, function ($q) use($search_keyword){
                $q->where(function ($j) use ($search_keyword) {
                    $j->where('business_name', 'LIKE', '%'.$search_keyword.'%')
                        ->orWhere('phone', 'LIKE', '%'.$search_keyword.'%');
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

    public function getAllFinishedGoods($request)
    {
        if(isset($request->q) && ($request->q != '') && ($request->q != null)) {
            $search_keyword = $request->q;
        } else {
            $search_keyword = null;
        }
        $data['finished_goods'] = FinishedGoods::where('status', FinishedGoods::STATUS_ACTIVE)
            ->where('deleted', FinishedGoods::DELETED_NO)
            ->when($search_keyword, function ($q) use($search_keyword){
                return $q->where('name', 'LIKE', '%'.$search_keyword.'%');
            })
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'code' => $item->code,
                    'show_image' => asset($item->show_image),
                ];
            });
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
                ->where('deleted',AccCoaAccount::DELETED_NO)
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

            $checkBatchNumber = Invoice::where('invoice_no', $request->invoice_no)
                ->where('deleted', Invoice::DELETED_NO)
                ->first();
            if (!empty($checkBatchNumber)) {
                throw new \Exception("Invoice Number already exists");
            }

            $invoice = new Invoice();
            $invoice->customer_id = $request->customer_id;
            $invoice->invoice_no = $request->invoice_no;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->payment_date = $request->payment_date;
            $invoice->discount_type = $request->discount_type;
            $invoice->discount_value = $request->discount_value;
            $invoice->notes = $request->notes;
            $invoice->invoice_footer = $request->invoice_footer;
            $invoice->created_at = Carbon::now();
            $invoice->created_by = auth()->id();
            $invoice->updated_at = Carbon::now();
            $invoice->updated_by = auth()->id();
            $invoice->save();
            $invoice->order_no = "INVOICE - ".(1000 + $invoice->id);
            $invoice->save();


            $total_amount = 0;
            $vat_amount = 0;

            if(isset($request->product_id) && is_array($request->product_id)){
                foreach ($request->product_id as $key=>$product){
                    $finishedGoods = FinishedGoods::where('status', FinishedGoods::STATUS_ACTIVE)
                        ->where('deleted', FinishedGoods::DELETED_NO)
                        ->where('id', $product)
                        ->first();

                    if(empty($finishedGoods)){
                        continue;
                    }

                    $qty = $request->qty[$key];
                    $price = $request->price[$key];
                    $tax_id = $request->tax[$key];

                    $amount_without_tax = $qty * $price;
                    $amount_with_tax = 0;
                    $tax_rate = 0;
                    $tax_amount = 0;
                    if($tax_id != null){
                        $tax = AccCoaAccount::where('status', AccCoaAccount::STATUS_ACTIVE)
                            ->where('deleted', AccCoaAccount::DELETED_NO)
                            ->where('id', $tax_id)
                            ->first();
                        if(!empty($tax)){
                            $tax_rate = $tax->tax_rate;
                            $amount_with_tax = $amount_without_tax + ($amount_without_tax * $tax_rate / 100);
                            $tax_amount = $amount_without_tax * $tax_rate / 100;
                        }
                    }

                    $invoiceDetails = new InvoiceDetails();
                    $invoiceDetails->invoice_id = $invoice->id;
                    $invoiceDetails->finished_good_id = $product;
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

                    $total_amount += $invoiceDetails->total_price;
                    $vat_amount += $invoiceDetails->tax_amount;

                }
            }
            $discount_amount = 0;
            if($invoice->discount_type == Invoice::DISCOUNT_TYPE_PERCENTAGE){
                $discount_amount = ($total_amount * $invoice->discount_value) / 100;
            }else{
                $discount_amount = $invoice->discount_value;
            }

            $invoice->total_amount = $total_amount;
            $invoice->vat_amount = $vat_amount;
            $invoice->discount_amount = $discount_amount;
            $invoice->payable_amount = $total_amount + $vat_amount - $discount_amount;
            $invoice->due_amount = $total_amount + $vat_amount - $discount_amount;
            $invoice->save();


        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }


}
