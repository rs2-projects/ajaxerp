@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        @if(hasPermission('add-expenses'))
            <div class="erp-add-employee-wrapper mb-3">
                <div class="erp-add-employee">
{{--                    <a href="#" class="btn add-btn erp-add-employee ms-2" data-bs-toggle="modal" data-bs-target="#cofa_transfer"><i class="fa-solid fa-plus"></i> Transfer Balance </a>--}}
                    <a href="javascript:void(0)" class="btn add-btn erp-add-employee ms-2" onclick="openExpenseModal()"><i class="fa-solid fa-plus"></i> Add Expense </a>
                </div>
            </div>
        @endif
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                            <div class="erp-box-header">
                                <h4>Transactions</h4>
                            </div>
                            <div class="erp-filter-box d-flex align-items-center justify-content-end flex-70">

                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-end flex-100">
                                    <div class="erp-filter-item">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>

                                    <div class="erp-filter-item flex-32">
                                        <div class=" form-focus select-focus custom-form-focus">
                                            <select class="select floating select2-box" id="account-select">
                                                <option value="all" selected>All Accounts ( {{ getCurrencySymbol() }} {{ showAmount($accounts->sum('available_balance')) }} )</option>
                                                @if(!empty($accounts))
                                                    @foreach($accounts as $account)
                                                        <option value="{{ $account->id }}">{{ $account->name }} ( {{ getCurrencySymbol() }} {{ showAmount($account->available_balance) }} ) </option>
                                                    @endforeach
                                                @endif
                                            </select>

                                        </div>
                                    </div>
                                    <div class="erp-filter-item">
                                        <div class="erp-search-btn-wrap">
                                            <button class=" erp-search-btn" type="button" onclick="getData()">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="my-attendance-report-wrapper" id="ajax-data-load">
                        </div>

                    </div>
                </div>

            </div>
        </div>


    </div>
    <!--End::row-1 -->
@endsection

@section('modals')
@include('accounting.transaction.__modals')
@endsection

@section('css')

@endsection

@section('css_plugins')
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('js_plugins')
    <!-- Datetimepicker JS -->
    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
@endsection

@section('js')
    <script>
        var filterData = {
            account_id: ''
        };
        $(document).ready(function() {
            getData();
            initSelect2();
            initializeDatepicker();

            $('#account-select').on('change', function () {
                filterData.account_id = $(this).val();
            });

            $("#expenseStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        showSuccessAlert('Success',res.message);
                        $(self)[0].reset();
                        $('#cofa_expense').modal('hide');
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            $(document).on('submit', "#expenseUpdateForm", function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        showSuccessAlert('Success',res.message);
                        $(self)[0].reset();
                        $('#cofa_expense_edit').modal('hide');
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            })
        });

        function getData(){
            getPaginatedListData("{{ route('accounting.transaction.index.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function initSelect2(){
            $(".select-step").select2({
                closeOnSelect: true,
                containerCssClass: "select2-box-container",
                dropdownCssClass: "select2-box-dropdown",
                width: '100%'
            });
        }
        function reInitSelect2() {
            $(".select-step").select2({
                closeOnSelect: true,
                containerCssClass: "select2-box-container",
                dropdownCssClass: "select2-box-dropdown",
                width: '100%',
                dropdownParent: $("#cofa_expense")
            });
        }

        function openExpenseModal() {
            $('#cofa_expense').modal('show');
            reInitSelect2();
        }

        function initializeDatepicker() {
            $('.datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD',
                icons: {
                    up: "fa fa-angle-up",
                    down: "fa-solid fa-angle-down",
                    next: 'fa-solid fa-angle-right',
                    previous: 'fa-solid fa-angle-left'
                }
            });
        }

        function editExpense(id) {
            let url = "{{route('accounting.transaction.expense.edit', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#cofa_expense_edit .modal-body").html(response.view);
                    $("#cofa_expense_edit").modal('show');
                    initSelect2();
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function deleteExpense(id) {
            let url = "{{route('accounting.transaction.expense.delete', ':id')}}";
            url = url.replace(':id', id);
            deleteAjax(
                url,
                'reloadAjaxGetData'
            );
        }

        function reviewTransaction(checkbox, id) {
            let url = "{{route('accounting.transaction.review', ':id')}}";
            url = url.replace(':id', id);

            let review = 0;
            if($(checkbox).is(":checked")) {
                review = 1;
            }
            let data = {
                review: review
            }
            ajaxGet(url, data, function (response) {
                if (response.status == 200) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                    $(checkbox).attr('checked', false);
                }
            }, function (err) {
                if (xhr.status == 422) {
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        $("." + key + "_error").text(value).show();
                        toastr.error(value);
                    });
                } else {
                    toastr.error(xhr.message);
                }
                $(checkbox).removeAttr('checked');
            });
        }
    </script>
@endsection


