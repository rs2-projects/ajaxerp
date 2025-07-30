@php use App\Models\Sales\Invoice; @endphp
@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row" id="VueApp">
        <div class="erp-employee-list-wrapper">
            <div class="new-production-wrapper bg-card attd-table">
                <form action="{{route('inventory.dispatch-invoice-items.deliver.store', $invoice->id)}}" id="deliverStoreForm"
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
                                        <div v-if="regular_items.length > 0">
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
                                                    <td class="erp-tbody-td text-center" style="width: 40%;">
                                                        <h4 class="text-center d-table-title">@{{ item.item_name }}</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">@{{ item.available_qty }}</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">@{{ item.dispatched_qty }} / @{{ item.quantity }}</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <div v-if="item._delivered">
                                                            <input type="hidden" name="delivery_qty[]" value="0">
                                                            <h4 class="text-center d-table-title approved-status">Delivered</h4>
                                                        </div>
                                                        <div class="pd-input-box" v-else>
                                                            <input v-if="!item._showInput" type="hidden" name="delivery_qty[]" value="0">
                                                            <button v-if="!item._showInput" type="button" class="btn btn-sm btn-primary" @click="openScanModal(item)">Scan</button>
                                                            <input v-else class="form-control text-center" type="number" :value="item.remaining_qty" min="0" :max="item.remaining_qty" name="delivery_qty[]">
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div v-if="set_items.length > 0" class="mt-4">
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
                                                            <div v-if="set._delivered">
                                                                <input type="hidden" name="delivery_qty[]" value="0">
                                                                <h4 class="text-center d-table-title approved-status">Delivered</h4>
                                                            </div>
                                                            <div class="pd-input-box" v-else>
                                                                <input v-if="!set._showInput" type="hidden" name="delivery_qty[]" value="0">
                                                                <button v-if="!set._showInput" type="button" class="btn btn-sm btn-primary" @click="openScanModal(set)">Scan</button>
                                                                <input v-else class="form-control text-center" type="number" :value="set.remaining_qty" min="0" :max="set.remaining_qty" name="delivery_qty[]">
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
                    </div>
                    @if($invoice->invoice_status != \App\Models\Sales\Invoice::INVOICE_STATUS_DELIVERED)
                        <div class="production-instrucion-output-selection-wrapper mt-3 p-2 text-center">
                            <button class=" erp-search-btn text-center" type="submit">Deliver</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        @include('inventory.sales-dispatch.scan-modal')
    </div>
@endsection

@section('modals')
    {{-- @include('inventory.sales-dispatch.scan-modal') --}}
@endsection

@section('css')
    <style>
        .table.erp-table .erp-tbody-td:last-child {
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
const { createApp } = Vue;
const vueApp = createApp({
    data() {
        return {
            regular_items: [],
            set_items: [],
            // scannedCode: '',
            selected_item: null,
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

                    this.regular_items = allItems.filter(item => item.item_type !== {{ \App\Models\Sales\InvoiceDetails::TYPE_SET_ITEM }}).map(item => {
                        item._showInput = false;
                        item._delivered = item.quantity === item.dispatched_qty;
                        item.is_scanned = false;
                        return item;
                    });

                    this.set_items = allItems.filter(item => item.item_type === {{ \App\Models\Sales\InvoiceDetails::TYPE_SET_ITEM }}).map(item => {
                        item._showInput = false;
                        item._delivered = item.quantity === item.dispatched_qty;
                        item.is_scanned = false;
                        item.set_items.forEach(child => {
                            child.is_scanned = false;
                            child.scannedCode = '';
                        });
                        return item;
                    });
                })
                .catch(error => {
                    console.error('Error fetching finished goods:', error);
                });
        },

        openScanModal(item) {
            this.selected_item = item;
            this.scannedCode = '';

            const modal = new bootstrap.Modal(document.getElementById('scanModal'));
            modal.show();
        },

        closeScanModal() {
            this.selected_item = null;
            this.scannedCode = '';
            const modalEl = document.getElementById('scanModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
        },

        verifyScanCode(itemId, code, childId = null) {
            code = code.trim();
            if (!code) return;

            // Normal item
            if (this.selected_item.item_type !== 5) {
                if (this.selected_item.item_code === code) {
                    this.selected_item.is_scanned = true;
                    this.selected_item._showInput = true;
                    this.closeScanModal();
                } else {
                    showErrorAlert('Mismatch', 'QR code does not match.');
                }
            } else {
                // Set item
                const child = this.selected_item.set_items.find(c => c.id === childId);
                if (!child) return;

                if (child.code === code) {
                    child.is_scanned = true;
                } else {
                    showErrorAlert('Mismatch', 'QR code does not match for set item.');
                }

                const allScanned = this.selected_item.set_items.every(c => c.is_scanned);
                if (allScanned) {
                    this.selected_item.is_scanned = true;
                    this.selected_item._showInput = true;
                    this.closeScanModal();
                }
            }
        },

        checkValidation(e) {
            e.preventDefault();
            const regularScanned = this.regular_items.some(item => item.is_scanned);
            const setScanned = this.set_items.some(set =>
                set.set_items?.some(child => child.is_scanned)
            );

            if (!regularScanned && !setScanned) {
                showErrorAlert('Oops!', 'Please scan at least one item before submitting.');
                return;
            }
            
            this.deliverStoreForm();
        },

        deliverStoreForm() {
            const form = $("#deliverStoreForm");
            const formData = new FormData(form[0]);
            const url = form.attr('action');

            formPost(url, formData, function (res) {
                if (res.status === 200) {
                    showSuccessAlert('Success', res.message);
                    setTimeout(() => {
                        window.location.href = "{{ route('inventory.dispatch-invoice-items.index') }}";
                    }, 1000);
                } else {
                    showErrorAlert('Error', res.message);
                }
            }, 'show_input_error');
        },
    },
    mounted() {
        this.getInvoiceData();
    }
}).mount('#VueApp');
</script>

@endsection
