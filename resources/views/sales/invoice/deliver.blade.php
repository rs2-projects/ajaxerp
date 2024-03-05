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
                                                <th class="erp-th text-center">Item Name</th>
                                                <th class="erp-th text-center">Qty</th>
                                                <th class="text-center erp-th">QR Code</th>
                                                <th class="text-center erp-th">Item Delivered</th>
                                            </tr>
                                            </thead>
                                            <tbody class="erp-tbody">
                                            <tr class="erp-tbody-tr" v-for="(invoice, index) in invoices">
                                                <input type="hidden" name="invoice_details_id[]" :value="invoice.id">
                                                <input type="hidden" name="finished_good_id[]" :value="invoice.finished_good_id">
                                                <input type= "hidden" name="total_quantity[]" :value="invoice.quantity">
                                                <td class="erp-tbody-td text-center">
                                                    <h4 class="text-center d-table-title">
                                                        @{{invoice.finished_good.name}}</h4>
                                                </td>
                                                <td class="erp-tbody-td text-center">
                                                    <h4 class="text-center d-table-title">@{{invoice.quantity}}</h4>
                                                </td>
                                                <td class="erp-tbody-td text-center">
                                                    <div class="pd-input-box">
                                                        <input
                                                            class="form-control text-center bar-code-input"
                                                            type="text"
                                                            placeholder="Scan QR / Bar Code"
                                                            @keydown.enter.prevent="handleBarcodeScan($event, index, invoice.finished_good.id)"
                                                        />
                                                    </div>
                                                </td>
                                                <td class="erp-tbody-td text-center">
                                                    <div class="pd-recived-product-wrapper">
                                                        <input type="hidden" :name="'barcode_count['+index+']'"
                                                               :value="invoice.barcodeCounts"/>
                                                        <div class="pre-counter">@{{ invoice.barcodeCounts }}</div>
                                                        <div class="pd-recived-product-scrol-box">
                                                            <div
                                                                class="pd-recived-product-item d-flex align-items-center gap-2"
                                                                v-for="(barCode, barCodeIndex) in invoice.scannedBarcodes"
                                                                :key="barCodeIndex"
                                                            >
                                                                <div class="pd-recived-product-c-item">
                                                                    <input type="hidden" :name="'barcode['+index+'][]'"
                                                                           :value="barCode.pre_production_no"/>
                                                                    <input type="hidden"
                                                                           :name="'pre_production_id['+index+'][]'"
                                                                           :value="barCode.id"/>
                                                                    <p class="mb-0">@{{ barCode.pre_production_no }}</p>
                                                                </div>
                                                                <div class="pd-recived-product-c-item">
                                                                    <a href="#"
                                                                       @click.prevent="removeBarcode(index, barCodeIndex)"><i
                                                                            class="fa-solid fa-xmark"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
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
                    invoices: [],
                };
            },
            methods: {
                handleBarcodeScan(event, index, finished_good_id) {
                    console.log(index, finished_good_id);
                    if (event.key === 'Enter') {
                        const barcodeValue = event.target.value;
                        let codeCount = 0;
                        this.invoices[index].scannedBarcodes.map((code, index) => {
                            if(code.pre_production_no == barcodeValue){
                                codeCount ++;
                            }
                        });

                        let url = `{{ route('sales.invoice.deliver.check-barcode', ['id' => ':finished_good_id', 'barcode' => ':barcodeValue', 'count' => ':codeCount']) }}`;
                        url = url.replace(':finished_good_id', finished_good_id);
                        url = url.replace(':barcodeValue', barcodeValue);
                        url = url.replace(':codeCount', codeCount);
                        let available_qtn = this.invoices[index].quantity - this.invoices[index].dispatched_qty;
                        let scaneed_qtn = this.invoices[index].barcodeCounts;

                        if(available_qtn > scaneed_qtn){
                            axios.get(url)
                                .then(response => {
                                    console.log(response.data);
                                    event.target.value = '';
                                    if(response.data){
                                        this.invoices[index].scannedBarcodes.push(response.data);
                                        this.invoices[index].barcodeCounts++;
                                    }else{
                                        showErrorAlert('Error', 'Invalid Barcode')
                                    }
                                })
                                .catch(error => {
                                    event.target.value = '';
                                    showErrorAlert('Error', 'Invalid Barcode')
                                });
                        }else{
                            showErrorAlert('Error', 'No item available for delivery')
                        }
                    }
                },
                removeBarcode(finished_good_index, barcodeIndex) {
                    this.invoices[finished_good_index].scannedBarcodes.splice(barcodeIndex, 1);
                    this.invoices[finished_good_index].barcodeCounts--;
                },
                getInvoices() {
                    var currentUrl = window.location.href;
                    var id = currentUrl.split('/')[4];
                    let url = "{{ route('sales.invoice.deliver.get-all-finished-goods', ':id') }}";
                    url = url.replace(':id', id);

                    axios.get(url)
                        .then(response => {
                            console.log(response.data);
                            this.invoices = response.data.invoices.map(invoice => {
                                return {
                                    scannedBarcodes: [],
                                    barcodeCounts: 0,
                                    barcodes: [],
                                    ...invoice
                                };
                            });
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
                this.getInvoices();
            }
        }).mount('#VueApp');


    </script>

@endsection


