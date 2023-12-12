@extends('layouts.settings-layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">
                <a href="javascript:void(0)" class="btn add-btn erp-add-employee" data-bs-toggle="modal" data-bs-target="#add_office_time_modal"><i class="fa-solid fa-plus"></i> Add Office Time</a>

            </div>
        </div>

        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                            <div class="erp-box-header">
                                <h4>Office Time </h4>
                            </div>

                        </div>

                        <div class="big-table pt-4">
                            <div class="de-table-wrapper">
                                <div class="table-responsive">
                                    <table class="table mb-0 erp-table">
                                        <thead class="erp-thead">
                                            <tr class="erp-tr">
                                                <th class="erp-th">SL</th>
                                                <th class="erp-th">Title </th>
                                                <th class="erp-th text-center">Description </th>
                                                {{--<th class="erp-th text-center">Interval Time <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></th>
                                                <th class="erp-th text-center">Salary Type </th>
                                                <th class="erp-th text-center">Hourly Rate </th>--}}
                                                <th class="text-end erp-th">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="erp-tbody">

                                            @foreach($office_time_types as $key=> $item)
                                                <tr class="erp-tbody-tr">
                                                    <td class="erp-tbody-td">
                                                        <h4 class="d-table-title">{{$loop->iteration}}</h4>
                                                    </td>
                                                    <td class="erp-tbody-td">
                                                        <h4 class="text-start d-table-title">{{ucfirst($item->name)}}</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">{!! $item->description??'N/A' !!}</h4>
                                                    </td>
                                                    {{--<td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">30 min</h4>

                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">Basic Salary</h4>
                                                    </td>
                                                    <td class="erp-tbody-td text-center">
                                                        <h4 class="text-center d-table-title">100% of Basic Salary</h4>
                                                    </td>--}}
                                                    <td class="text-end erp-tbody-td">
                                                        <div class="erp-action-t">
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">

                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="editItem({{$item->id}})"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                                                    <a class="dropdown-item" href="{{ route('settings.office-time.delete',$item->id) }}" onclick="return confirm('Are you sure to delete?')"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>

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

                        <div class="erp-pagination-wrapper d-flex justify-content-between align-items-center">
                            <div class="erp-pagi-item">
                                <div class="showing-date-box">
                                    <p>Showing 1 to 7 of 7 entries
                                    </p>
                                </div>
                            </div>
                            <div class="erp-pagi-item">
                                <ul class="pagination">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">2 <span class="visually-hidden">(current)</span></a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--End::row-1 -->
@endsection

@section('modals')
    @include('settings.office-time._add_office_time_modal')
    @include('settings.office-time._edit_office_time_modal')
@endsection

@section('css')

@endsection

@section('css_plugins')
@endsection

@section('js_plugins')
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $(document).on("change", ".is_weekend_checkbox", function() {
            // $(".is_weekend_checkbox").on('change', function () {
                if ($(this).is(':checked')) {
                    let day = $(this).attr('data-day');
                    $("."+day+"_start_time").attr('required', false);
                    $("."+day+"_end_time").attr('required', false);
                    $("."+day+"_working_hour").attr('required', false);
                } else {
                    let day = $(this).attr('data-day');
                    $("."+day+"_start_time").attr('required', true);
                    $("."+day+"_end_time").attr('required', true);
                    $("."+day+"_working_hour").attr('required', true);
                }
            });

            $("#officeTimeStoreForm").on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, 'reload', 'show_input_error');
            });

            $(document).on("submit", "#officeTimeStoreFormEdit", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, 'reload', 'show_input_error');
            });

        });


        function editItem(id){
            let url = "{{route('settings.office-time.edit', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_office_time_modal_body").html(response.view);
                    $("#edit_office_time_modal").modal('show');
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }
    </script>
@endsection


