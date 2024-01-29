@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="table-main-wrapper pt-4" id="ajax-data-load">

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!--End::row-1 -->
@endsection

@section('modals')
    @include('payroll.generated-salary._edit_salary_details_modal')
    @include('payroll.generated-salary._show_salary_details_modal')
@endsection

@section('css')
    <style>
        .float-right {
            float: right;
        }
    </style>
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

        $(document).ready(function () {
            getData();

            $(document).on("submit", "#salaryDetailsUpdateForm", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    if(res.status == 200){
                        $("#edit_salary_details_modal").modal('hide');
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });
        });

        function getData(){
            getPaginatedListData("{{ route('payroll.generated-salary.details.filtered',$salary->id) }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function editItem(id){
            let url = "{{route('payroll.generated-salary.details.salary-details.edit', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_salary_details_modal_body").html(response.view);
                    $("#edit_salary_details_modal").modal('show');

                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        function showItem(id){
            let url = "{{route('payroll.generated-salary.details.salary-details.show', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#show_salary_details_modal_body").html(response.view);
                    $("#show_salary_details_modal").modal('show');

                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }


        function calculateTotalEarning() {
            let earning = $("#total_earning").val();
            earning =  earning.replaceAll(',','');
            let custom_add_amount = $("#custom_add_amount").val();
            custom_add_amount = custom_add_amount.replaceAll(',','');
            if (isNaN(earning)) {
                earning = 0;
            }
            if (isNaN(custom_add_amount)) {
                custom_add_amount = 0;
            }
            let total_earning = parseFloat(earning) + parseFloat(custom_add_amount);
            $("#total_earning_text").html(total_earning);
            calculateNetSalary();
        }
        function calculateTotalDeduction() {
            let deduction = $("#total_deduction").val();
            deduction = deduction.replaceAll(',','');
            let custom_deduct_amount = $("#custom_deduct_amount").val();
            custom_deduct_amount = custom_deduct_amount.replaceAll(',','');
            if (isNaN(deduction)) {
                deduction = 0;
            }
            if (isNaN(custom_deduct_amount)) {
                custom_deduct_amount = 0;
            }

            let total_deduction = parseFloat(deduction) + parseFloat(custom_deduct_amount);
            $("#total_deduction_text").html(total_deduction);
            calculateNetSalary();
        }
        function calculateNetSalary() {
            let earning = $("#total_earning_text").html();
            earning = earning.replaceAll(',','');
            earning= parseFloat(earning);
            let deduction = $("#total_deduction_text").html();
            deduction = deduction.replaceAll(',','');
            deduction = parseFloat(deduction);
            let net_salary = earning - deduction;
            $("#total_net_salary_text").html(net_salary);

        }

    </script>
@endsection


