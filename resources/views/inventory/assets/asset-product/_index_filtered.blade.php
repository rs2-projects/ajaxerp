<div class="table-header-wrapper d-flex flex-wrap">
    <div class="table-header-item dep-list">
        <h4>SL</h4>
    </div>
    <div class="table-header-item dep-list text-start">
        <h4>Product Name</h4>
    </div>
    <div class="table-header-item dep-list text-center">
        <h4>Description</h4>
    </div>
    <div class="table-header-item dep-list text-end pe-2">
        <h4>Action</h4>
    </div>
</div>
<div class="table-body-wrapper">
    @if(count($products) > 0)
        @foreach($products as $key=>$product)
            <div class="table-body-item-wrapper d-flex flex-wrap">
                <div class="table-body-item dep-list">
                    <h4>{{ $products->firstItem() + $loop->iteration - 1 }}</h4>
                </div>
                <div class="table-body-item dep-list ">
                    <h4 class="text-start erp-t-email">{{ $product->name??'N/A' }}</h4>
                </div>

                <div class="table-body-item dep-list ">
                    <h4 class="text-center erp-t-email">{{ $product->description??'N/A' }}</h4>
                </div>


                <div class="table-body-item dep-list pe-2 justify-content-end">
                    <div class="erp-action-t">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$product->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('inventory.asset-product.delete',$product->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    @endif
</div>
{{ $products->links('vendor.pagination.common_ajax_pagination') }}
