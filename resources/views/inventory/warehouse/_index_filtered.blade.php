<div class="wlm-item-wrapper row">
    @if(count($warehouses) > 0)
        @foreach($warehouses as $key=>$item)
            <div class="wrl-item col-md-3  bg-card attd-table">
                <div class="wrl-item-img">
                    <img src="{{asset('assets/img/profiles/office-building.png')}}" alt="Warehouse Image">
                    <div class="wrl-action">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">

                                <a class="dropdown-item" href="{{ route('inventory.warehouse.show',$item->id) }}" ><i class="fa-solid fa-eye m-r-5"></i> View</a>
                                <a class="dropdown-item" href="{{ route('inventory.warehouse.edit',$item->id) }}" ><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="deleteAjax('{{ route('inventory.warehouse.delete',$item->id) }}', 'reloadAjaxGetData') "><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrl-item-content">
                    <h4 class="wrl-item-title">{{ $item->name }}</h4>
                    <p class="wrl-item-description">{{ getSubStr($item->description) }}</p>
                    <div class="wlm-sr-wrap">
                        <div class="wlm-scetion-wrap d-flex align-items-center">
                            <h4>Total Section :</h4>
                            <p>{{ count($item->sections) }}</p>
                        </div>
                        <div class="wlm-rack-wrap d-flex align-items-center">
                            <h4>Total Rack :</h4>
                            <p>{{ count($item->racks) }}</p>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    @endif
</div>
{{ $warehouses->links('vendor.pagination.common_ajax_pagination') }}
