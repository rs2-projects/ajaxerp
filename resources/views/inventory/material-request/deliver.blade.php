@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row" id="VueApp">	
		<div class="erp-employee-list-wrapper">
			<div class="new-production-wrapper bg-card attd-table">
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
												<th class="text-center erp-th">QR Code</th>
												<th class="text-center erp-th">Item Received</th>
											</tr>
										</thead>
										<tbody class="erp-tbody">
											{{-- @foreach($materials as $material)
												<tr class="erp-tbody-tr">
													<td class="erp-tbody-td text-start">
														<h4 class="text-start d-table-title">{{$material->category->name}}</h4>
													</td>
													<td class="erp-tbody-td text-center">
														<h4 class="text-center d-table-title">{{$material->product->name}}</h4>
													</td>
													<td class="erp-tbody-td text-center">
														<h4 class="text-center d-table-title">{{$material->quantity}}</h4>
													</td>
													<td class="erp-tbody-td text-center">
														<div class="pd-input-box">
															<input
																class="form-control text-center bar-code-input"
																type="text"
																placeholder="Scan QR / Bar Code"
																@keydown.enter="handleBarcodeScan"
																/>
														</div>
													</td>
													<td class="erp-tbody-td text-center">
														<div class="pd-recived-product-wrapper">
															<div class="pre-counter">@{{ barcodeCount }}</div>
															<div class="pd-recived-product-scrol-box">
															  <div
																class="pd-recived-product-item d-flex align-items-center gap-2"
																v-for="(code, i) in scannedBarcodes"
																:key="i"
															  >
																<div class="pd-recived-product-c-item">
																  <p class="mb-0">@{{ code }}</p>
																</div>
																<div class="pd-recived-product-c-item">
																	<a href="#" @click.prevent="removeBarcode(i)"><i class="fa-solid fa-xmark"></i></a>
																</div>
															  </div>
															</div>
														</div>
													</td>
												</tr>
											@endforeach --}}
											<tr class="erp-tbody-tr" v-for="(material, index) in materials">
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
													<div class="pd-input-box">
														<input
															class="form-control text-center bar-code-input"
															type="text"
															placeholder="Scan QR / Bar Code"
															@keydown.enter="handleBarcodeScan($event, index, material.product.id)"
															/>
													</div>
												</td>
												<td class="erp-tbody-td text-center">
													<div class="pd-recived-product-wrapper">
														<div class="pre-counter">@{{ material.barcodeCounts }}</div>
														<div class="pd-recived-product-scrol-box">
														  <div
															class="pd-recived-product-item d-flex align-items-center gap-2"
															v-for="(code, i) in material.scannedBarcodes"
															:key="i"
														  >
															<div class="pd-recived-product-c-item">
															  <p class="mb-0">@{{ code }}</p>
															</div>
															<div class="pd-recived-product-c-item">
																<a href="#" @click.prevent="removeBarcode(index, i)"><i class="fa-solid fa-xmark"></i></a>
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
					<button class=" erp-search-btn text-center">Deliver</button>
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

					let url = `{{ route('inventory.material-request.check-barcode', ['id' => ':material_id', 'barcode' => ':barcodeValue']) }}`;
					url = url.replace(':material_id', material_id);
					url = url.replace(':barcodeValue', barcodeValue);
					console.log(url);

					axios.get(url)
					.then(response => {
						console.log(response.data);
						this.materials[index].scannedBarcodes.push(response.data);
						this.materials[index].barcodeCounts++;
						event.target.value = '';
					})
					.catch(error => {
						console.error('Error fetching materials:', error);
						event.target.value = '';
						showErrorAlert('Error', 'Invalid Barcode')
					});
                }
            },
            removeBarcode(materialIndex, barcodeIndex) {
                this.materials[materialIndex].scannedBarcodes.splice(barcodeIndex, 1);
				this.materials[materialIndex].barcodeCounts--;
            },
            getMaterials() {
                var currentUrl = window.location.href;
                var id = currentUrl.split('/')[4];
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
            }
        },
        mounted() {
            this.getMaterials();
        }
    }).mount('#VueApp');
</script>


@endsection


