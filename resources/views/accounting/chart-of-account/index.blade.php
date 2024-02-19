@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        @if(hasPermission('manage-chart-of-accounts'))
            <div class="erp-add-employee-wrapper mb-3">
                <div class="erp-add-employee">
                    <a href="javascript:void(0)" class="btn add-btn erp-add-employee ms-2" data-bs-toggle="modal" data-bs-target="#addAccountModal"><i class="fa-solid fa-plus"></i> Add a New Account</a>
                </div>
            </div>
        @endif
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table" id="ajax-data-load">

            </div>
        </div>


    </div>
    <!--End::row-1 -->
@endsection

@section('modals')
    @include('accounting.chart-of-account._add_account_modal')
    @include('accounting.chart-of-account._edit_account_modal')
@endsection

@section('css')

@endsection

@section('css_plugins')

@endsection

@section('js_plugins')

@endsection

@section('js')
    <script>
        var filterData = {
            keyword_filtered: ''
        };
        $(document).ready(function() {
            getData();
            initSelect2();

            $("#cofAccountStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        showSuccessAlert('Success',res.message);
                        $(self)[0].reset();
                        $('#addAccountModal').modal('hide');
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            })
            $(document).on("submit", "#cofAccountUpdateForm", function(e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        showSuccessAlert('Success',res.message);
                        $(self)[0].reset();
                        $('#editAccountModal').modal('hide');
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

        });

        function getData(){
            getPaginatedListData("{{ route('accounting.chart-of-accounts.filtered') }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function addNewAccount(sub_category_id) {
            $("#acc_coa_sub_category_id").val(sub_category_id).trigger('change');;
            $("#addAccountModal").modal('show');
        }

        function showEditAccountDetails() {
            $("#edit_details_btn").slideUp();
            $("#edit_details_section").slideDown();
        }

        function editAccountItem(id){
            let url = "{{route('accounting.chart-of-accounts.account-edit', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_account_modal_body").html(response.view);
                    $("#editAccountModal").modal('show');
                    initSelect2();
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function initSelect2(){
            $(".select-step").select2({
                closeOnSelect: true,
                containerCssClass: "select2-box-container",
                dropdownCssClass: "select2-box-dropdown",
                width: '100%'

            });
        }

    </script>
@endsection


