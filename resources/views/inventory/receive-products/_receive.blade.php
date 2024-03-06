@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row" id="VueApp">
		<div class="erp-employee-list-wrapper">
			<div class="new-production-wrapper bg-card attd-table">
				<form action="{{route('inventory.receive-product.receive.store', $dispatch->id)}}" id="productReceiveStoreForm" method="post">
					@csrf
					<div class="product-general-info-box d-flex flex-wrap pd-box">
						<div class="pgib-item flex-32 pd-item">
							<div class="input-block erp-step-input-block mb-0">
								<label class="col-form-label">Order Details</label>
								<h4>{{$dispatch->pre_production->order_details}}</h4>
							</div>
						</div>
						<div class="pgib-item flex-100 pd-item">
							<div class="input-block erp-step-input-block mb-0">
								<label class="col-form-label">Description</label>
								<p>{{$dispatch->pre_production->description ?? 'N/A'}}</p>
							</div>
						</div>
					</div>
					<div class="pd-table-box">
						<div class="my-attendance-report-wrapper">
							<div class="big-table">
								<div class="de-table-wrapper">
									<div class="table-responsive">
										<table class="table mb-0 erp-table">
											<tbody class="erp-tbody">
												<tr class="erp-tbody-tr">
                                                    <td>
                                                        <div class="pgib-item pd-item">
                                                            <div class="input-block erp-step-input-block mb-0">
                                                                <label class="col-form-label">Finished Product</label>
                                                                <h4>{{$dispatch->pre_production->finishedGoods->name}}</h4>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="pgib-item pd-item">
                                                            <div class="input-block erp-step-input-block mb-0">
                                                                <label class="col-form-label">Dispatch QTY </label>
                                                                <h4>{{$dispatch->dispatched_qty}}</h4>
                                                            </div>
                                                        </div>
                                                    </td>
												</tr>
                                                <tr class="erp-tbody-tr">
                                                    <td>
                                                        <div class="pgib-item pd-item">
                                                            <div class="input-block erp-step-input-block mb-0">
                                                                <label class="col-form-label">QR Code</label>
                                                                <input
																	name="pre_production_no"
                                                                    class="form-control text-left bar-code-input"
                                                                    type="text"
                                                                    placeholder="Scan QR / Bar Code"
                                                                    required
                                                                    />
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="pgib-item pd-item">
                                                            <div class="input-block erp-step-input-block mb-0">
                                                                <label class="col-form-label">Receive QTY</label>
                                                                <input
																	name="dispatched_qty"
                                                                    class="form-control text-left bar-code-input"
                                                                    type="number"
                                                                    min="0"
                                                                    max="{{$dispatch->dispatched_qty - $dispatch->received_qty}}"
                                                                    required
                                                                    />
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
						<button class=" erp-search-btn text-center" type="submit">Receive</button>
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

@endsection

@section('js')
<script>
	$(document).ready(function () {
	    $(document).on("keydown", ":input:not(textarea)", function(event) {
            return event.key != "Enter";
        });
	});

	$("#productReceiveStoreForm").submit(function(e) {
		e.preventDefault();
		var formData = new FormData($(this)[0]);
		var url = $(this).attr('action');
		formPost(url, formData, function (res){
			if(res.status == 200){
				showSuccessAlert('Success',res.message)
				setTimeout(function () {
					window.location.href = "{{route('inventory.receive-product.index')}}";
				}, 1000);
			}else{
				showErrorAlert('Error',res.message)
			}
		}, 'show_input_error');
	});
</script>


@endsection


