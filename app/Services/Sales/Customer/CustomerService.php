<?php

namespace App\Services\Sales\Customer;

use App\Models\Country;
use App\Models\Products\FinishedGoods;
use App\Models\Sales\Customer;
use App\Models\Sales\CustomerBank;
use App\Models\Sales\CustomerContact;
use App\Models\State;
use App\Services\Common\ImageUploadService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    // index data
    public function indexData()
    {
        $data['countries'] = Country::orderBy('name', 'asc')->get();
        return $data;
    }
    // index filtered data
    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $data['customers'] = Customer::where('deleted', Customer::DELETED_NO)
            ->where('status', Customer::STATUS_ACTIVE)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('business_name', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('business_name', 'asc')->paginate($this->paginate_limit);
        return $data;

    }
    //get state by country
    public function getStatesByCountry($request)
    {
        $country_id = $request->country_id;
        $data['states'] = State::where('country_id', $country_id)
            ->orderBy('name', 'asc')
            ->get();

        return $data;
    }
    //store customer data
    public function store($request)
    {


        DB::beginTransaction();
        try {

            $duplicate_check = Customer::where('business_name', $request->business_name)
                ->where('email', $request->email)
                ->where('deleted', Customer::DELETED_NO)
                ->first();
            if (!empty($duplicate_check)) {
                throw new \Exception("Customer already exists");
            }

            $image_path = null;
            if ($request->hasFile('image')) {
                $imageUploadService = new ImageUploadService();
                $image_path = $imageUploadService->store($request->image, 'sales/customers');
                $image_path = $image_path['path'];
            }
            //store data into customers table
            $customer = new Customer();
            $customer->business_name = $request->business_name;
            $customer->image = $image_path??null;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->contact_first_name = $request->contact_first_name;
            $customer->contact_last_name = $request->contact_last_name;
            $customer->lead_time_status = $request->lead_time_status;
            $customer->address = $request->address;
            $customer->city = $request->city;
            $customer->zip_code = $request->zip_code;
            $customer->country_id = $request->country_id;
            $customer->state_id = $request->state_id;
            $customer->fax = $request->fax;
            $customer->website = $request->website;
            $customer->notes = $request->customer_notes;
            $customer->created_by = auth()->id();
            $customer->created_at = Carbon::now();
            $customer->updated_by = auth()->id();
            $customer->updated_at = Carbon::now();
            $customer->save();

            //store data into customer_bank table
            if (isset($request->bank_name) && is_array($request->bank_name) && count($request->bank_name) > 0) {
                foreach ($request->bank_name as $key=>$bank) {
                    if(($bank == null) || ($bank == '') ||
                        ($request->account_name[$key] == null) || ($request->account_name[$key] == '') ||
                        ($request->account_no[$key] == null) || ($request->account_no[$key] == '')){
                        continue;
                    }
                    $customer_bank = new CustomerBank();
                    $customer_bank->customer_id = $customer->id;
                    $customer_bank->bank_name = $bank;
                    $customer_bank->account_name = $request->account_name[$key];
                    $customer_bank->account_no = $request->account_no[$key];
                    $customer_bank->branch = $request->branch[$key];
                    $customer_bank->routing_number = $request->routing_number[$key];
                    $customer_bank->swift_code = $request->swift_code[$key];
                    $customer_bank->notes = $request->notes[$key];
                    $customer_bank->created_by = auth()->id();
                    $customer_bank->created_at = Carbon::now();
                    $customer_bank->updated_by = auth()->id();
                    $customer_bank->updated_at = Carbon::now();
                    $customer_bank->save();
                }
            }
            //store data into customer_contact table
            if (isset($request->contact_name) && is_array($request->contact_name) && count($request->contact_name) > 0) {
                foreach ($request->contact_name as $key=>$name) {
                    if(
                        ($name == null) || ($name == '')){
                        continue;
                    }
                    $customer_contact = new CustomerContact();
                    $customer_contact->customer_id = $customer->id;
                    $customer_contact->name = $name;
                    $customer_contact->email = $request->contact_email[$key];
                    $customer_contact->phone = $request->contact_phone[$key];
                    $customer_contact->save();
                }
            }
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }
    //retrieve customer data for edit
    public function editData($id)
    {
        $data['countries'] = Country::orderBy('name','asc')->get();
        $data['item'] = Customer::with('customerBanks')
            ->where('id',$id)
            ->where('deleted',Customer::DELETED_NO)
            ->where('status',Customer::STATUS_ACTIVE)
            ->first();
        if (!$data['item']){
            throw new \Exception('Customer not found');
        }
        return $data;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {

            $duplicate_check = Customer::where('business_name', $request->business_name)
                ->where('email', $request->email)
                ->where('deleted', Customer::DELETED_NO)
                ->where('id', '!=', $id)
                ->first();

            if (!empty($duplicate_check)) {
                throw new \Exception("Customer already exists");
            }

            $image_path = null;
            if ($request->hasFile('image')) {
                $imageUploadService = new ImageUploadService();
                $image_path = $imageUploadService->store($request->image, 'sales/customers');
                $image_path = $image_path['path'];
            }

            $customer = Customer::where('deleted', Customer::DELETED_NO)
                ->where('id', $id)
                ->first();

            if(!$customer){
                throw new \Exception("Customer not found");
            }
            //UPDATE DATA INTO CUSTOMER TABLE
            $customer->business_name = $request->business_name;
            $customer->image = $image_path?? $customer->image;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->contact_first_name = $request->contact_first_name;
            $customer->contact_last_name = $request->contact_last_name;
            $customer->lead_time_status = $request->lead_time_status;
            $customer->address = $request->address;
            $customer->city = $request->city;
            $customer->zip_code = $request->zip_code;
            $customer->country_id = $request->country_id;
            $customer->state_id = $request->state_id;
            $customer->fax = $request->fax;
            $customer->website = $request->website;
            $customer->notes = $request->customer_notes;
            $customer->updated_by = auth()->id();
            $customer->updated_at = Carbon::now();
            $customer->save();


            if (isset($request->bank_name) && is_array($request->bank_name) && count($request->bank_name) > 0) {
                // check if not exist then delete first
                $bank_info_ids = $request->bank_info_id??[];
                $delete_bank = CustomerBank::where('customer_id', $customer->id)
                    ->whereNotIn('id', $bank_info_ids)
                    ->delete();

                foreach ($request->bank_name as $key=>$value) {
                    if (isset($request->bank_info_id[$key]) &&  $request->bank_info_id[$key] != null){
                        // update
                        $customer_bank = CustomerBank::where('id', $request->bank_info_id[$key])
                            ->where('customer_id', $customer->id)
                            ->first();
                        if ($customer_bank){
                            //UPDATE INTO CUSTOMER_BANK TABLE
                            $customer_bank->bank_name = $value;
                            $customer_bank->account_name = $request->account_name[$key];
                            $customer_bank->account_no = $request->account_no[$key];
                            $customer_bank->branch = $request->branch[$key];
                            $customer_bank->routing_number = $request->routing_number[$key];
                            $customer_bank->swift_code = $request->swift_code[$key];
                            $customer_bank->notes = $request->notes[$key];
                            $customer_bank->updated_by = auth()->id();
                            $customer_bank->updated_at = Carbon::now();
                            $customer_bank->save();
                        }
                    }else{
                        // create
                        $customer_bank = new CustomerBank();
                        $customer_bank->customer_id = $customer->id;
                        $customer_bank->bank_name = $value;
                        $customer_bank->account_name = $request->account_name[$key];
                        $customer_bank->account_no = $request->account_no[$key];
                        $customer_bank->branch = $request->branch[$key];
                        $customer_bank->routing_number = $request->routing_number[$key];
                        $customer_bank->swift_code = $request->swift_code[$key];
                        $customer_bank->notes = $request->notes[$key];
                        $customer_bank->created_by = auth()->id();
                        $customer_bank->created_at = Carbon::now();
                        $customer_bank->updated_by = auth()->id();
                        $customer_bank->updated_at = Carbon::now();
                        $customer_bank->save();
                    }
                }
            }

            if (isset($request->contact_name) && is_array($request->contact_name) && count($request->contact_name) > 0) {
                $customer_contact_ids = $request->customer_contact_id??[];
                $delete_contact = CustomerContact::where('customer_id', $customer->id)
                    ->whereNotIn('id', $customer_contact_ids)
                    ->delete();

                foreach ($request->contact_name as $key=>$value) {
                    if (isset($request->customer_contact_id[$key]) &&  $request->customer_contact_id[$key] != null){
                        $customer_contact = CustomerContact::where('id', $request->customer_contact_id[$key])
                            ->where('customer_id', $customer->id)
                            ->first();
                        if ($customer_contact){
                            $customer_contact->name = $value;
                            $customer_contact->email = $request->contact_email[$key];
                            $customer_contact->phone = $request->contact_phone[$key];
                            $customer_contact->updated_by = auth()->id();
                            $customer_contact->updated_at = Carbon::now();
                            $customer_contact->save();
                        }
                    }else{
                        //UPDATE INTO CUSTOMER CONTACT TABLE
                        $customer_contact = new CustomerContact();
                        $customer_contact->customer_id = $customer->id;
                        $customer_contact->name = $value;
                        $customer_contact->email = $request->contact_email[$key];
                        $customer_contact->phone = $request->contact_phone[$key];
                        $customer_contact->created_by = auth()->id();
                        $customer_contact->created_at = Carbon::now();
                        $customer_contact->updated_by = auth()->id();
                        $customer_contact->updated_at = Carbon::now();
                        $customer_contact->save();
                    }
                }
            }
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

    }
    //DELETE CUSTOMER DATA
    public function delete($id)
    {
        $customer = Customer::where('id', $id)
            ->where('deleted', Customer::DELETED_NO)
            ->where('status',Customer::STATUS_ACTIVE)
            ->first();
        if (!$customer) {
            throw new \Exception('Customer not found');
        }
        $customer->deleted = Customer::DELETED_YES;
        $customer->deleted_by = auth()->id();
        $customer->deleted_at = now();
        $customer->save();
    }
}
