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
								<h4>{{$pre_production->order_details}}</h4>
							</div>
						</div>
						<div class="pgib-item flex-32 pd-item">
							<div class="input-block erp-step-input-block mb-0">
								<label class="col-form-label">Product(Finished Product) Selection</label>
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
													<input type="hidden" name="pre_production_material_id[]" :value="material.id">
													<input type="hidden" name="product_material_id[]" :value="material.product.id">
													<input type= "hidden" name="total_quantity[]" :value="material.quantity">
													<td class="erp-tbody-td text-start">
														<h4 class="text-start d-table-title">@{{material.category.name}}</h4>
													</td>
													<td class="erp-tbody-td text-center">
														<h4 class="text-center d-table-title">@{{material.product.name}}</h4>
													</td>
													<td class="erp-tbody-td text-center">
														<h4 class="text-center d-table-title">@{{material.quantity}}</h4>
													</td>
													<td class="erp-tbody-td text-center">
														<h4 class="text-center d-table-title">@{{material.delivered_qty}}</h4>
													</td>
													<td class="erp-tbody-td text-center">
														<div v-if="material.quantity === material.delivered_qty">
															<h4 class="text-center d-table-title approved-status">Delivered</h4>
														</div>
														<div class="pd-input-box" v-else>
															<input
																class="form-control text-center bar-code-input"
																type="text"
																placeholder="Scan QR / Bar Code"
																@keydown.enter.prevent="handleBarcodeScan($event, index, material.product.id)"
																/>
														</div>
													</td>
													<td class="erp-tbody-td text-center">
														<div class="pd-recived-product-wrapper">
															<input type="hidden" :name="'barcode_count['+index+']'" :value="material.barcodeCounts"/>
															<div class="pre-counter">@{{ material.barcodeCounts }}</div>
															<div class="pd-recived-product-scrol-box">
															<div
																class="pd-recived-product-item d-flex align-items-center gap-2"
																v-for="(barCode, barCodeIndex) in material.scannedBarcodes"
																:key="barCodeIndex"
															>
																<div class="pd-recived-product-c-item">
																	<input type="hidden" :name="'barcode['+index+'][]'" :value="barCode.barcode"/>
																	<input type="hidden" :name="'product_material_purchase_details_id['+index+'][]'" :value="barCode.id"/>
																	<p class="mb-0">@{{ barCode.barcode }}</p>
																</div>
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
    var { createApp } = Vue;
    var vueApp = createApp({
        data() {
            return {
                materials: [],
            };
        },
        methods: {
            handleBarcodeScan(event, index, material_id) {
                if (event.key === 'Enter') {
                    const barcodeValue = event.target.value;
					let codeCount = 0;
					this.materials[index].scannedBarcodes.map((code, index) => {
					    if(code.barcode == barcodeValue){
							codeCount ++;
						}
					});

					let url = `{{ route('inventory.material-request.check-barcode', ['id' => ':material_id', 'barcode' => ':barcodeValue', 'count' => ':codeCount']) }}`;
					url = url.replace(':material_id', material_id);
					url = url.replace(':barcodeValue', barcodeValue);
					url = url.replace(':codeCount', codeCount);

					let available_qtn = this.materials[index].quantity - this.materials[index].delivered_qty;
					let scaneed_qtn = this.materials[index].barcodeCounts;

					if(available_qtn > scaneed_qtn){
						axios.get(url)
						.then(response => {
							console.log(response.data);
							event.target.value = '';
							if(response.data){
								this.materials[index].scannedBarcodes.push(response.data);
								this.materials[index].barcodeCounts++;
							}else{
								showErrorAlert('Error', "Invalid Barcode")
							}
						})
						.catch(error => {
							event.target.value = '';
							showErrorAlert('Error', error.response.data.message)
						});
					}else{
						showErrorAlert('Error', 'No item available for delivery')
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
                    this.materials = response.data.materials.map(material => {
                        return {
                            scannedBarcodes: [],
                            barcodeCounts: 0,
                            barcodes: [],
                            ...material
                        };
                    });
                })
                .catch(error => {
                    console.error('Error fetching materials:', error);
                });
            },

			checkValidation(e) {
				e.preventDefault();
				if (this.materials.every(material => material.barcodeCounts === 0)) {
					showErrorAlert('Opps!', 'Please add delivery items!');
				}else {
					deliverStoreForm();
				}
			},
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


