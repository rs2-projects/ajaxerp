@php use App\Models\Sales\Invoice; @endphp
@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row" id="VueApp">
        <div class="erp-employee-list-wrapper">
            <div class="new-production-wrapper bg-card attd-table">
                <form action="{{route('sales.invoice.deliver.store', $invoice->id)}}" id="deliverStoreForm"
                      method="post" @submit="checkValidation">
                    @csrf

                    <input type="hidden" name="invoice_id" id="invoice_id" value="{{$invoice->id}}">
                    <div class="product-general-info-box d-flex flex-wrap pd-box">
                        <div class="pgib-item flex-32 pd-item">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Customer Details</label>
                                <h4>Name: {{$invoice->customer->business_name??'N/A'}}</h4>
                                <h4>Email: {{$invoice->customer->email??'N/A'}}</h4>
                                <h4>Phone: {{$invoice->customer->phone??'N/A'}}</h4>
                                <h4>Address: {{$invoice->customer->address??'N/A'}}</h4>
                            </div>
                        </div>
                        <div class="pgib-item flex-32 pd-item">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Invoice Details</label>
                                <h4>Invoice no: {{$invoice->invoice_no}}</h4>
                                <h4>Invoice Date: {{getFormattedDate($invoice->invoice_date)}}</h4>
                                <h4>Payment Date: {{getFormattedDate($invoice->payment_date)}}</h4>
                            </div>
                        </div>
                        <div class="pgib-item flex-32 pd-item">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Status</label>
                                <h4>Payment Status: {{Invoice::PAYMENT_STATUSES[$invoice->payment_status]}}</h4>
                                <h4>Invoice Status: {{Invoice::INVOICE_STATUSES[$invoice->invoice_status]}}</h4>
                            </div>
                        </div>
                        <div class="pgib-item flex-100 pd-item">
                            <div class="input-block erp-step-input-block mb-0">
                                <label class="col-form-label">Notes</label>
                                <p>{{$invoice->notes ?? 'N/A'}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="pd-table-box">
                        <div class="my-attendance-report-wrapper">
                            <div class="big-table">
                                <div class="de-table-wrapper">
                                    <div class="table-responsive">
                                        <table class="table mb-0 erp-table">
                                            <thead class="erp-thead">
                                                <tr class="erp-tr">
                                                    <th class="erp-th text-center">Item</th>
                                                    <th class="erp-th text-center">Available Qty</th>
                                                    <th class="erp-th text-center">Deliverable Qty</th>
                                                    <th class="text-center erp-th">QR Code</th>
                                                </tr>
                                            </thead>
                                            <tbody class="erp-tbody">
                                                <tr class="erp-tbody-tr" v-for="(item, index) in regular_items" :key="item.id">
                                                    <input type="hidden" name="invoice_details_id[]" :value="item.id">
                                                    <input type="hidden" name="item_id[]" :value="item.item_id">
                                                    <input type="hidden" name="item_type[]" :value="item.item_type">
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">@{{ item.item_name }}</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">@{{ item.available_qty }}</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">@{{ item.dispatched_qty }} / @{{ item.quantity }}</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <div v-if="item.quantity === item.dispatched_qty">
                                                            <h4 class="text-center d-table-title approved-status">Delivered</h4>
                                                        </div>
                                                        <div class="pd-input-box" v-else>
                                                            <button type="button" class="btn btn-sm btn-primary" @click="openScanModal(item, index, false)"> Scan </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <h5 class="mt-4 mb-2"><strong>Set Items</strong></h5>
                                        <table class="table mb-0 erp-table">
                                            <thead class="erp-thead">
                                                <tr class="erp-tr">
                                                    <th class="erp-th text-center">Set Name</th>
                                                    <th class="erp-th text-center">Item</th>
                                                    <th class="erp-th text-center">Available Qty</th>
                                                    <th class="erp-th text-center">Deliverable Qty</th>
                                                    <th class="erp-th text-center">QR Code</th>
                                                </tr>
                                            </thead>
                                            <tbody class="erp-tbody">
                                                <template v-for="(set, index) in set_items" :key="set.id">
                                                    <tr v-for="(child, cIndex) in set.set_items" :key="child.id">
                                                        <td class="erp-tbody-td text-center" v-if="cIndex === 0" :rowspan="set.set_items.length">
                                                            <h4 class="d-table-title">@{{ set.item_name }}</h4>

                                                            <input type="hidden" name="invoice_details_id[]" :value="set.id">
                                                            <input type="hidden" name="item_id[]" :value="set.item_id">
                                                            <input type="hidden" name="item_type[]" :value="set.item_type">
                                                        </td>

                                                        <td class="erp-tbody-td text-center">@{{ child.name }}</td>
                                                        <td class="erp-tbody-td text-center">@{{ child.available_qty }}</td>

                                                        <td class="erp-tbody-td text-center" v-if="cIndex === 0" :rowspan="set.set_items.length">
                                                            <h4 class="text-center d-table-title">@{{ set.dispatched_qty }} / @{{ set.quantity }}</h4>
                                                        </td>

                                                        <td class="erp-tbody-td text-center" v-if="cIndex === 0" :rowspan="set.set_items.length">
                                                            <div v-if="set.quantity === set.dispatched_qty">
                                                                <h4 class="text-center d-table-title approved-status">Delivered</h4>
                                                            </div>
                                                            <div class="pd-input-box" v-else>
                                                                <button type="button" class="btn btn-sm btn-primary" @click="openScanModal(set, index, true)"> Scan </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="production-instrucion-output-selection-wrapper mt-3 p-2 text-center">
                        <button class=" erp-search-btn text-center" type="submit">Deliver</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End::row-1 -->
    </div>
@endsection

@section('modals')

@endsection

@section('css')
    <style>
        .table.erp-table .erp-tbody-td:last-child{
            border-right: 1px dashed #ddd !important;
        }
    </style>
@endsection

@section('css_plugins')

@endsection

@section('js_plugins')
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@endsection

@section('js')
    <script>
        var {createApp} = Vue;
        var vueApp = createApp({
            data() {
                return {
                    // invoice_details: [],
                    regular_items: [],
                    set_items: [],
                };
            },
            methods: {
                getInvoiceData() {
                    let id = document.getElementById('invoice_id').value;
                    let url = "{{ route('inventory.dispatch-invoice-items.get-deliver-data', ':id') }}";
                    url = url.replace(':id', id);

                    axios.get(url)
                        .then(response => {
                            const allItems = response.data.invoice_details;

                            this.regular_items = allItems.filter(item => item.item_type !== {{ \App\Models\Sales\InvoiceDetails::TYPE_SET_ITEM }});
                            this.set_items = allItems.filter(item => item.item_type === {{ \App\Models\Sales\InvoiceDetails::TYPE_SET_ITEM }});
                        })
                        .catch(error => {
                            console.error('Error fetching finished goods:', error);
                        });
                },

                checkValidation(e) {
                    e.preventDefault();
                    if (this.invoices.every(invoice => invoice.barcodeCounts === 0)) {
                        showErrorAlert('Opps!', 'Please add delivery items!');
                    }else {
                        this.deliverStoreForm();
                    }
                },
                deliverStoreForm(){
                    var self = $("#deliverStoreForm");
                    var formData = new FormData($(self)[0]);
                    var url = $(self).attr('action');

                    formPost(url, formData, function (res) {
                        if(res.status == 200){
                            showSuccessAlert('Success',res.message)
                            setTimeout(function () {
                                window.location.href = "{{route('sales.invoice.index')}}";
                            }, 1000);
                        }else{
                            showErrorAlert('Error',res.message)
                        }
                    }, 'show_input_error');
                }

            },
            mounted() {
                this.getInvoiceData();
            }
        }).mount('#VueApp');


    </script>

@endsection


