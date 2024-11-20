@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row" id="VueApp">
		<div class="erp-employee-list-wrapper">
			<div class="new-production-wrapper bg-card attd-table">
				<form action="{{route('inventory.material-request.deliver.store', $pre_production->id)}}" id="deliverStoreForm" method="post" @submit="checkValidation">
					@csrf
					<div class="product-general-info-box d-flex flex-wrap pd-box">
						<div class="pgib-item flex-32 pd-item">
							<div class="input-block erp-step-input-block mb-0">
								<label class="col-form-label">Order Details</label>
								<h4>{{ !empty($pre_production->order_details) ? $pre_production->order_details : 'N/A'}}</h4>
							</div>
						</div>
						<div class="pgib-item flex-32 pd-item">
							<div class="input-block erp-step-input-block mb-0">
								<label class="col-form-label">Product(Finished Product)</label>
								<h4>{{$pre_production->finishedGoods->name}}</h4>
							</div>
						</div>
						<div class="pgib-item flex-32 pd-item">
							<div class="input-block erp-step-input-block mb-0">
								<label class="col-form-label">Estimated Output QTY </label>
								<h4>{{$pre_production->estimated_production_qty}}</h4>
							</div>
						</div>
						<div class="pgib-item flex-100 pd-item">
							<div class="input-block erp-step-input-block mb-0">
								<label class="col-form-label">Description</label>
								<p>{{$pre_production->description ?? 'N/A'}}</p>
							</div>
						</div>
					</div>
					<div class="text-end mt-4">
						<a href="{{ route('inventory.material-request.barcode-details',$pre_production->id) }}" class="btn btn-primary btn-sm" target="_blank">
							<span>
								<i class="fa fa-print"></i>
							</span>
							Print QR code
						</a>
					</div>
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
														<input type="hidden" name="type[]" :value="material.type">
														<input type="hidden" name="pre_production_material_id[]" :value="material.material.id">
														<input type="hidden" name="product_material_id[]" :value="material.material.product.id">
														<input type= "hidden" name="total_quantity[]" :value="material.material.quantity">
														<h4 class="text-start d-table-title">@{{material.material.category.name}}</h4>
													</td>
													<td class="erp-tbody-td text-center">
														<h4 class="text-center d-table-title">@{{material.material.product.name}}</h4>
													</td>
													<td class="erp-tbody-td text-center">
														<h4 class="text-center d-table-title">@{{material.material.quantity}}</h4>
													</td>
													<td class="erp-tbody-td text-center">
														<h4 class="text-center d-table-title">@{{material.material.delivered_qty}}</h4>
													</td>
													<td class="erp-tbody-td text-center">
														<div v-if="material.material.quantity === material.material.delivered_qty">
															<h4 class="text-center d-table-title declined-status">Delivered</h4>
														</div>
														<div class="pd-input-box" v-else>
															{{-- <input
																class="form-control text-center bar-code-input"
																type="text"
																placeholder="Scan QR / Bar Code"
																@keydown.enter.prevent="handleBarcodeScan($event, index, material.material.product.id)"
																/> --}}
															<button type="button" v-on:click="openDeliverModal(material.material.id)" class="btn btn-primary btn-sm">Deliver</button>
														</div>
													</td>
													<td class="erp-tbody-td text-center">
														<div class="pd-recived-product-wrapper">
															<input type="hidden" :name="'barcode_count['+index+']'" :value="material.barcodeCounts"/>
															<div class="pre-counter">@{{ sumOfDeliveryItem(material) }}</div>
															<div class="pd-recived-product-scrol-box">
																{{-- <div
																	class="pd-recived-product-item d-flex align-items-center gap-2"
																	v-for="(barCode, barCodeIndex) in material.scannedBarcodes"
																	:key="barCodeIndex"
																>
																	<div class="pd-recived-product-c-item" v-if="material.type == 'other'">
																		<input type="hidden" :name="'barcode['+index+'][]'" :value="barCode.barcode"/>
																		<input type="hidden" :name="'product_material_purchase_details_id['+index+'][]'" :value="barCode.id"/>
																		<p class="mb-0">@{{ barCode.barcode }}</p>
																	</div>

																	<div class="pd-recived-product-c-item" v-if="material.type == 'board'">
																		<input type="hidden" :name="'barcode['+index+'][]'" :value="barCode.pre_production_no"/>
																		<input type="hidden" :name="'product_material_purchase_details_id['+index+'][]'" :value="barCode.id"/>
																		<p class="mb-0">@{{ barCode.pre_production_no }}</p>
																	</div>
																	<div class="pd-recived-product-c-item">
																		<a href="#" @click.prevent="removeBarcode(index, barCodeIndex)"><i class="fa-solid fa-xmark"></i></a>
																	</div>
																</div> --}}
																<div
																	class="pd-recived-product-item d-flex align-items-center gap-2" v-if="material.type == 'other'"
																	v-for="(deliver_item, deliver_item_index) in material.deliver_items"
																	:key="deliver_item_index"
																	>
																	<input type="hidden" :name="'purchase_id['+index+'][]'" :value="deliver_item.product_material_purchase_id">
																	<input type="hidden" :name="'purchase_details_id['+index+'][]'" :value="deliver_item.id">
																	<input type="hidden" :name="'selected_qty['+index+'][]'" :value="deliver_item.selected_qty">
																	<input type="hidden" :name="'type['+index+']'" :value="material.type">
																	<p>
																		@{{ deliver_item.material_purchase.batch_number }}
																	</p>
																	<p>
																		@{{ deliver_item.selected_qty }}
																	</p>
																	<div class="pd-recived-product-c-item">
																		<a href="#" @click.prevent="removeBarcode(index, barCodeIndex)"><i class="fa-solid fa-xmark"></i></a>
																	</div>
																</div>
																<div
																	class="pd-recived-product-item d-flex align-items-center gap-2" v-if="material.type == 'board'"
																	v-for="(deliver_item, deliver_item_index) in material.deliver_items"
																	:key="deliver_item_index"
																	>
																	<input type="hidden" :name="'production_id['+index+'][]'" :value="deliver_item.id">
																	{{-- <input type="hidden" :name="'production_details_id['+index+'][]'" :value="deliver_item.id"> --}}
																	<input type="hidden" :name="'selected_qty['+index+'][]'" :value="deliver_item.selected_qty">
																	<input type="hidden" :name="'type['+index+']'" :value="material.type">
																	<p>
																		@{{ deliver_item.pre_production_batch_no }}
																	</p>
																	<p>
																		@{{ deliver_item.selected_qty }}
																	</p>
																	<div class="pd-recived-product-c-item">
																		<a href="#" @click.prevent="removeBarcode(index, barCodeIndex)"><i class="fa-solid fa-xmark"></i></a>
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
						<table class="table table-bordered table-striped table-hover" v-if="materials[selected_material_index].type == 'other'">
							<thead>
								<tr>
									<th>Purchase ID</th>
									<th>Batch</th>
									<th>Available Qty</th>
									<th>Qty</th>
								</tr>
							</thead>
							<tbody v-if="selected_material_index != null">
								<tr v-for="(purchaseDetails, index) in materials[selected_material_index].material.product.available_purchase_details">
									<td>@{{ purchaseDetails.material_purchase.purchase_id }}</td>
									<td>@{{ purchaseDetails.material_purchase.batch_number }}</td>
									<td class="text-center">@{{ purchaseDetails.available_qty }}</td>
									<td>
										<input type="text" class="form-control" placeholder="Enter Qty" v-model="purchaseDetails.selected_qty" :max="(remainingDeliverQty(selected_material_index) < purchaseDetails.available_qty) ? remainingDeliverQty(selected_material_index) : purchaseDetails.available_qty">
									</td>
								</tr>
							</tbody>
						</table>
						<table class="table table-bordered table-striped table-hover" v-else>
							<thead>
								<tr>
									<th>Production ID</th>
									<th>Batch</th>
									<th>Available Qty</th>
									<th>Qty</th>
								</tr>
							</thead>
							<tbody v-if="selected_material_index != null">
								<tr v-for="(production, index) in materials[selected_material_index].material.product.available_productions">
									<td>@{{ production.pre_production_no }}</td>
									<td>@{{ production.pre_production_batch_no }}</td>
									<td class="text-center">@{{ production.available_qty }}</td>
									<td>
										<input type="text" class="form-control" placeholder="Enter Qty" v-model="production.selected_qty" :max="(remainingDeliverQty(selected_material_index) < production.available_qty) ? remainingDeliverQty(selected_material_index) : production.available_qty">
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
						<div class="form-group">
							<label class="mb-2" for="scanning_qrcode">Scan QrCode</label>
							<input type="text" class="form-control" id="scanning_qrcode" v-model="scanning_qrcode" placeholder="Scan QrCode">
						</div>
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
            handleBarcodeScan(event, index, material_id) {
                if (event.key === 'Enter') {
                    const barcodeValue = event.target.value;
					let codeCount = 0;
					let type = this.materials[index].type;

					this.materials[index].scannedBarcodes.map((code, index) => {
					    if(code.barcode == barcodeValue){
							codeCount ++;
						}
					});

					let url = `{{ route('inventory.material-request.check-barcode', ['id' => ':material_id', 'barcode' => ':barcodeValue', 'count' => ':codeCount', 'type' => ':type']) }}`;
					url = url.replace(':material_id', material_id);
					url = url.replace(':barcodeValue', barcodeValue);
					url = url.replace(':codeCount', codeCount);
					url = url.replace(':type', type);

					let available_qtn = this.materials[index].material.quantity - this.materials[index].material.delivered_qty;
					let scaneed_qtn = this.materials[index].barcodeCounts;
					if(available_qtn > scaneed_qtn){
						axios.get(url)
						.then(response => {
							console.log(response.data);
							response = response.data;
							event.target.value = '';
							if(response.status == 200){
								this.materials[index].scannedBarcodes.push(response.data);
								this.materials[index].barcodeCounts++;
							}else if(response.status == 201){
								this.materials[index].scannedBarcodes.push(response.data);
								this.materials[index].barcodeCounts++;
								showErrorAlert('Warning', "You are choosing an item from newer batch! Please take item from oldest batch first.")
							}else{
								showErrorAlert('Error', "Invalid Barcode")
							}
						})
						.catch(error => {
							event.target.value = '';
							showErrorAlert('Error', error.response.data.message)
						});
					}else{
						showErrorAlert('Error', 'Items Exceeding Required Quantity');
						event.target.value = '';
					}
                }
            },
            removeBarcode(materialIndex, barcodeIndex) {
                this.materials[materialIndex].scannedBarcodes.splice(barcodeIndex, 1);
				this.materials[materialIndex].barcodeCounts--;
            },
            getMaterials() {
                let id = {{ $pre_production->id }};
                let url = "{{ route('inventory.material-request.get-all-materials', ':id') }}";
                url = url.replace(':id', id);

                axios.get(url)
                .then(response => {
					// console.log(response.data.board_materials);
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
			openDeliverModal(material_id){
				let material = this.materials.find(material => material.material.id === material_id);
				let materialIndex = this.materials.findIndex(material => material.material.id === material_id);
				if(material.material.quantity === material.material.delivered_qty){
					showErrorAlert('Error', 'All items are delivered');
				}else{
					this.selected_material_index = materialIndex;
					$('#scanModal').modal('show');
				}
			},

			selectDeliverItem() {
				let material = this.materials[this.selected_material_index];
				let total_selected_qty = 0;
				let deliver_items = [];
				if(material.type == 'other'){
					material.material.product.available_purchase_details.forEach(purchaseDetails => {
						if(purchaseDetails.selected_qty == undefined){
							purchaseDetails.selected_qty = 0;
						}
						total_selected_qty += parseInt(purchaseDetails.selected_qty);
						if(purchaseDetails.selected_qty > 0){
							deliver_items.push(purchaseDetails);
						}
					});
				} else {
					material.material.product.available_productions.forEach(production => {
						if(production.selected_qty == undefined){
							production.selected_qty = 0;
						}
						total_selected_qty += parseInt(production.selected_qty);
						if(production.selected_qty > 0){
							deliver_items.push(production);
						}
					});
				}
				
				// console.log('total_selected_qty',total_selected_qty);
				// console.log('remainingDeliverQty', this.remainingDeliverQty(this.selected_material_index));
				// return false;
				if(total_selected_qty > this.remainingDeliverQty(this.selected_material_index)){
					showErrorAlert('Error', 'Items Exceeding Required Quantity');
				}else{
					// material.material.delivered_qty += total_selected_qty;
					material.deliver_items = deliver_items;
					this.selected_material_index = null;
					$('#deliverModal').modal('hide');
				}
			},

			remainingDeliverQty(index){
				if(index != null) {
					let material = this.materials[index];
					return material.material.quantity - material.material.delivered_qty;
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
				let material = this.materials[this.selected_material_index].material;
				let barcodeValue = this.scanning_qrcode;
				if (material.product.code == barcodeValue) {
					$("#scanModal").modal('hide');
					$("#deliverModal").modal('show');
					this.scanning_qrcode = '';
				} else {
					showErrorAlert('Error', 'Invalid Item');
					this.scanning_qrcode = '';
				}
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

	function getBarcodePrintDetails() {
		let route = "{{ route('inventory.material-request.barcode-details',$pre_production->id) }}";

		ajaxGet(route, {}, function (response) {
			console.log(response);
			if (response.status == 200) {
				showSuccessAlert('Success', response.message);
			} else {
				showErrorAlert('Error', response.message);
			}
		});
	}
</script>


@endsection


