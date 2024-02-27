@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
						
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
                                                        @foreach($materials as $material)
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
                                                                        <input class="form-control text-center bar-code-input" type="text" placeholder="Scan QR / Bar Code" required="">
                                                                    </div>
                                                                </td>
                                                                <td class="erp-tbody-td text-center">
                                                                    <div class="pd-recived-product-wrapper">
                                                                        <div class="pre-counter">
                                                                            <span class="bar_code_count">1</span>
                                                                        </div>
                                                                        <div class="pd-recived-product-scrol-box">
                                                                            <div class="pd-recived-product-item d-flex  align-items-center gap-2">
                                                                                <div class="pd-recived-product-c-item">
                                                                                    <p class="mb-0 bar_code_num">4235</p>
                                                                                </div>
                                                                                <div class="pd-recived-product-c-item">
                                                                                    <a href="#"><i class="fa-solid fa-xmark"></i></a>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
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
    
@endsection

@section('js')
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script>
        
    </script>
@endsection


