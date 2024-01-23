@extends('layouts.settings-layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">
                <a href="javascript:void(0)" class="btn add-btn erp-add-employee" data-bs-toggle="modal" data-bs-target="#add_bonus_type_salary_modal"><i class="fa-solid fa-plus"></i> Add Bonus Salary</a>

            </div>
        </div>
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                            <div class="erp-box-header">
                                <h4>Bonus Salary Setting </h4>
                            </div>

                        </div>

                        <div class="big-table pt-4">
                            <div class="de-table-wrapper" id="ajax-data-load">

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
    @include('settings.bonus-type-salary._add_bonus_type_salary_modal')
    @include('settings.bonus-type-salary._edit_bonus_type_salary_modal')
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
            getData();

            $("#bonusTypeSalaryStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        $("#add_bonus_type_salary_modal").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            $(document).on("submit", "#bonusTypeSalaryFormEdit", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#edit_bonus_type_salary_modal").modal('hide');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

        });

        function getData(){
            getPaginatedListData("{{ route('settings.bonus-type-salary.filtered') }}", "#ajax-data-load");
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load");
        }

        function editItem(id){
            let url = "{{route('settings.bonus-type-salary.edit', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_bonus_type_salary_modal_body").html(response.view);
                    $("#edit_bonus_type_salary_modal").modal('show');
                    initializeSelect();
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function initializeSelect() {
            $('.select2').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });
        }

        function changeRateType(value){
            if (value == '0'){
                $(".hide-show-salary-type").slideDown();
                $("select[name='salary_type']").attr('required', true);
                $(".hide-show-value-symbol").show();
            }else {
                $(".hide-show-salary-type").slideUp();
                $("select[name='salary_type']").attr('required', false);
                $(".hide-show-value-symbol").hide();
            }
        }

    </script>
@endsection


