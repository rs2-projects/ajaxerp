@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row" id="VueApp">
		<div class="erp-employee-list-wrapper">
			<div class="new-production-wrapper bg-card attd-table">
				<form action="{{route('inventory.material-request.product-requisition.deliver.store', $requisition->id)}}" id="deliverStoreForm" method="post" @submit="checkValidation">
					@csrf
					<div class="product-general-info-box d-flex flex-wrap pd-box">
						<div class="pgib-item flex-32 pd-item">
							<div class="input-block erp-step-input-block mb-0">
								<label class="col-form-label">Requisition No</label>
								<h4>#{{ $requisition->requisition_no }}</h4>
							</div>
						</div>
						<div class="pgib-item flex-32 pd-items">
							
						</div>
						<div class="pgib-item flex-32 pd-items">
							
						</div>
						<div class="pgib-item flex-100 pd-item">
							<div class="input-block erp-step-input-block mb-0">
								<label class="col-form-label">Description</label>
								<p>{{ $requisition->description ?? 'N/A' }}</p>
							</div>
						</div>
					</div>
					{{-- <div class="text-end mt-4">
						<a href="{{ route('inventory.material-request.product-requisition.barcode-print',$requisition->id) }}" class="btn btn-primary btn-sm" target="_blank">
							<span>
								<i class="fa fa-print"></i>
							</span>
							Print QR code
						</a>
					</div> --}}
					<div class="pd-table-box">
						<div class="my-attendance-report-wrapper">
							<div class="big-table">
								<div class="de-table-wrapper">
									<div class="table-responsive">
										<table class="table mb-0 erp-table">
											<thead class="erp-thead">
												<tr class="erp-tr">
													<th class="erp-th">Category </th>
													<th class="erp-th text-center">Item Name </th>
													<th class="erp-th text-center">Qty </th>
													<th class="erp-th text-center">Delivered Qty </th>
													<th class="text-center erp-th">QR Code</th>
													<th class="text-center erp-th">Item Delivered</th>
												</tr>
											</thead>
											<tbody class="erp-tbody">
												<tr class="erp-tbody-tr" v-for="(material, index) in materials">
													
													<td class="erp-tbody-td text-start">
														<input type="hidden" name="product_material_id[]" :value="material.product_id">
														<input type="hidden" name="requisition_details_id[]" :value="material.id">
														<input type= "hidden" name="total_quantity[]" :value="material.qty">
														<h4 class="text-start d-table-title">@{{material.product.category.name}}</h4>
													</td>
													<td class="erp-tbody-td text-center">
														<h4 class="text-center d-table-title">@{{material.product.name}}</h4>
													</td>
													<td class="erp-tbody-td text-center">
														<h4 class="text-center d-table-title">@{{material.qty}}</h4>
													</td>
													<td class="erp-tbody-td text-center">
														<h4 class="text-center d-table-title">@{{material.delivered_qty}}</h4>
													</td>
													<td class="erp-tbody-td text-center">
														<div v-if="material.qty === material.delivered_qty">
															<h4 class="text-center d-table-title declined-status">Delivered</h4>
														</div>
														<div class="pd-input-box" v-else>
															<button type="button" v-on:click="openDeliverModal(index)" class="btn btn-primary btn-sm">Deliver</button>
														</div>
													</td>
													<td class="erp-tbody-td text-center">
														<div class="pd-recived-product-wrapper">
															<div class="pre-counter">@{{ sumOfDeliveryItem(material) }}</div>
															<div class="pd-recived-product-scrol-box">
																
																<div
																	class="pd-recived-product-item d-flex align-items-center gap-2"
																	v-for="(deliver_item, deliver_item_index) in material.deliver_items"
																	:key="deliver_item_index"
																	>
																	<input type="hidden" :name="'purchase_id['+index+'][]'" :value="deliver_item.product_material_purchase_id">
																	<input type="hidden" :name="'purchase_details_id['+index+'][]'" :value="deliver_item.id">
																	<input type="hidden" :name="'selected_qty['+index+'][]'" :value="deliver_item.selected_qty">
																	<input type="hidden" :name="'type['+index+']'" :value="material.product_type">
																	<p>
																		@{{ deliver_item.material_purchase.batch_number }}
																	</p>
																	<p>
																		@{{ deliver_item.selected_qty }}
																	</p>
																	<div class="pd-recived-product-c-item">
																		<a href="#" @click.prevent="removeDeliverItem(index, deliver_item_index)"><i class="fa-solid fa-xmark"></i></a>
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


		<!-- Deliver Modal -->
		<div class="modal fade" id="deliverModal" tabindex="-1" aria-labelledby="deliverModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="deliverModalLabel">Deliver Item</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" v-if="selected_material_index != null">
						<h4 v-if="selected_material_index != null">Remaining Deliver Quantity: @{{ remainingDeliverQty(selected_material_index) }}</h4>
						<table class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Purchase ID</th>
									<th>Batch</th>
									<th>Available Qty</th>
									<th>Qty</th>
								</tr>
							</thead>
							<tbody v-if="selected_material_index != null">
								<tr v-for="(purchaseDetails, index) in materials[selected_material_index].product.available_purchase_details">
									<td>@{{ purchaseDetails.material_purchase.purchase_id }}</td>
									<td>@{{ purchaseDetails.material_purchase.batch_number }}</td>
									<td class="text-center">@{{ purchaseDetails.available_qty }}</td>
									<td>
										<input type="text" class="form-control" placeholder="Enter Qty" v-model="purchaseDetails.selected_qty" :max="(remainingDeliverQty(selected_material_index) < purchaseDetails.available_qty) ? remainingDeliverQty(selected_material_index) : purchaseDetails.available_qty">
									</td>
								</tr>
							</tbody>
						</table>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" v-on:click="selectDeliverItem()">Deliver</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Scan Modal -->
		<div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="scanModalLabel">Scan Item</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" v-if="selected_material_index != null">
						<form action="" @submit="scanQrCodeForm">
							<div class="form-group">
								<label class="mb-2" for="scanning_qrcode">Scan QrCode</label>
								<input type="text" class="form-control" id="scanning_qrcode" v-model="scanning_qrcode" placeholder="Scan QrCode">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" v-on:click="scanItem()">Check</button>
					</div>
				</div>
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
	$(document).ready(function () {
		$('#scanModal').modal().on('shown.bs.modal', function() {
			$('#scanning_qrcode').focus()
		});
	});
    var { createApp } = Vue;
    var vueApp = createApp({
        data() {
            return {
                materials: [],
				selected_material_index:null,
				delivered_items: [],
				scanning_qrcode: '',
            };
        },
        methods: {
            getMaterials() {
                let id = {{ $requisition->id }};
                let url = "{{ route('inventory.material-request.product-requisition.get-materials', ':id') }}";
                url = url.replace(':id', id);

                axios.get(url)
					.then(response => {
						this.materials = response.data.materials.map(material => {
							return {
								scannedBarcodes: [],
								barcodeCounts: 0,
								barcodes: [],
								deliver_items: [],
								...material
							};
						});
					})
					.catch(error => {
						console.error('Error fetching materials:', error);
					});
            },
			openDeliverModal(materialIndex){
				let material = this.materials[materialIndex];
				if(material.qty === material.delivered_qty){
					showErrorAlert('Error', 'All items are delivered');
				}else{
					this.selected_material_index = materialIndex;
					$('#deliverModal').modal('show');
					// $('#scanModal').modal('show');
				}
			},

			selectDeliverItem() {
				let material = this.materials[this.selected_material_index];
				let total_selected_qty = 0;
				let deliver_items = [];
			
				for (let i = 0; i < material.product.available_purchase_details.length; i++) {
					let purchaseDetails = material.product.available_purchase_details[i];
					if (purchaseDetails.selected_qty == undefined) {
						purchaseDetails.selected_qty = 0;
					}
					total_selected_qty += parseInt(purchaseDetails.selected_qty);
					if (purchaseDetails.selected_qty > purchaseDetails.available_qty) {
						showErrorAlert('Error', 'Items Exceeding Available Quantity');
						return;
					}
					if (purchaseDetails.selected_qty > 0) {
						deliver_items.push(purchaseDetails);
					}
				}

				/*
					material.product.available_purchase_details.forEach(purchaseDetails => {
						if(purchaseDetails.selected_qty == undefined){
							purchaseDetails.selected_qty = 0;
						}
						total_selected_qty += parseInt(purchaseDetails.selected_qty);
						if(purchaseDetails.selected_qty > purchaseDetails.available_qty){
							showErrorAlert('Error', 'Items Exceeding Available Quantity');
							return false;
						}
						if(purchaseDetails.selected_qty > 0){
							deliver_items.push(purchaseDetails);
						}
					});
				*/
				
			
				if(total_selected_qty > this.remainingDeliverQty(this.selected_material_index)){
					showErrorAlert('Error', 'Items Exceeding Required Quantity');
				}else{
					material.deliver_items = deliver_items;
					this.selected_material_index = null;
					$('#deliverModal').modal('hide');
				}
			},

			remainingDeliverQty(index){
				if(index != null) {
					let material = this.materials[index];
					return material.qty - material.delivered_qty;
				}
				return 0;
			},

			sumOfDeliveryItem(material) {
				let sum = 0;
				material.deliver_items.forEach(item => {
					sum += parseInt(item.selected_qty);
				});
				return sum;
			},

			checkValidation(e) {
				e.preventDefault();
				if (this.materials.every(material => material.deliver_items.length === 0)) {
					showErrorAlert('Opps!', 'Please add delivery items!');
				}else {
					deliverStoreForm();
				}
			},

			scanItem() {
				let material = this.materials[this.selected_material_index];
				let barcodeValue = this.scanning_qrcode;
				if (material.product.code == barcodeValue) {
					$("#scanModal").modal('hide');
					$("#deliverModal").modal('show');
					this.scanning_qrcode = '';
				} else {
					showErrorAlert('Error', 'Invalid Item');
					this.scanning_qrcode = '';
				}
			},

			removeDeliverItem(index, deliverIndex) {
				this.materials[index].deliver_items.splice(deliverIndex, 1);
			},
			scanQrCodeForm(e) {
				e.preventDefault();
				this.scanItem();
			}
        },
        mounted() {
            this.getMaterials();
        }
    }).mount('#VueApp');

	function deliverStoreForm(){
		var self = $("#deliverStoreForm");
		var formData = new FormData($(self)[0]);
		var url = $(self).attr('action');

		formPost(url, formData, function (res) {
			if(res.status == 200){
				showSuccessAlert('Success',res.message)
				setTimeout(function () {
					window.location.href = "{{route('inventory.material-request.index')}}";
				}, 1000);
			}else{
				showErrorAlert('Error',res.message)
			}
		}, 'show_input_error');
	}

	
</script>


@endsection


