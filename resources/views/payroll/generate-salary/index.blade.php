@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">

        <div class="erp-employee-list-wrapper">
            <form action="{{ route('payroll.generate-salary.create') }}" method="post" id="generateSalaryStoreForm">
                @csrf
                <div class="erp-main-filter-wrapper d-flex justify-content-center ">
                    <div class="erp-add-em-step-wrapper bg-card flex-100">
                        <div class="erp-step-content-wrapper">
                            <div id="reg-employee">
                                <form action="">
                                    <section class="erp-em-general-info">
                                        <div class="erp-em-reg-step-wrapper">
                                            <div class="salary-generate-settings">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="input-block erp-step-input-block ">
                                                            <label class="col-form-label">Salary Type <span class="text-danger">*</span></label>
                                                            <select class="select select-step" name="salary_type" id="salary_type" onchange="getSalarySetBySalaryType()" required>
                                                                <option value="">Select Salary Type</option>
                                                                @foreach(\App\Models\SettingsSalarySet::SALARY_GENERATE_TYPES as $salary_generate_type_key => $salary_generate_type)
                                                                    <option value="{{ $salary_generate_type_key }}">{{ $salary_generate_type }}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="salary_type_error ie-span"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="input-block erp-step-input-block ">
                                                            <label class="col-form-label">Month <span class="text-danger">*</span></label>
                                                            <select class="select select-step" name="month" id="month" required>
                                                                @foreach($months as $key=>$month)
                                                                    <option value="{{ $key }}"
                                                                        {{ $key == request()->month ? 'selected' : '' }}>
                                                                        {{ ucfirst($month) }}
                                                                    </option>

                                                                @endforeach
                                                            </select>
                                                            <span class="salary_type_error ie-span"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="input-block erp-step-input-block ">
                                                            <label class="col-form-label">Year <span class="text-danger">*</span></label>
                                                            <select class="select select-step" name="year" id="year" required>
                                                                @for($i=(date('Y'));$i>=(date('Y') - 1);$i--)
                                                                    <option value="{{$i}}" {{ (request()->year == $i)?'selected':'' }}>{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                            <span class="salary_type_error ie-span"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 period-type-slide-up-down" style="display: none">
                                                        <div class="input-block erp-step-input-block ">
                                                            <label class="col-form-label">Period Type <span class="text-danger">*</span></label>
                                                            <select class="select select-step" name="period_type" id="period_type" required>
                                                                <option value="">Select Period Type</option>
                                                                <option value="{{ \App\Models\Salary::SALARY_PERIOD_FIRST_HALF }}">First Half</option>
                                                                <option value="{{ \App\Models\Salary::SALARY_PERIOD_SECOND_HALF }}">Second Half</option>
                                                            </select>
                                                            <span class="salary_type_error ie-span"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 text-center mt-3 submit-section">
                                                        <button type="button" onclick="getSalaryGenerateDetails()" class="btn btn-primary submit-btn">
                                                            Next
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="salary-set-wrapper mt-3" style="display: none">

                                            </div>

                                        </div>
                                    </section>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>


    </div>
    <!--End::row-1 -->
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
            getSalarySetBySalaryType();
        });

        function getSalarySetBySalaryType(){
            var salary_type = $("#salary_type").val();
            if(salary_type == 1){
                $(".period-type-slide-up-down").slideDown();
                $("#period_type").attr('required', 'required');
            }else{
                $(".period-type-slide-up-down").slideUp();
                $("#period_type").removeAttr('required');
            }
        }

        function getSalaryGenerateDetails() {

            let salary_type = $("#salary_type").val();
            let month = $("#month").val();
            let year = $("#year").val();
            let period_type = $("#period_type").val();

            if(!salary_type){
                toastr.error('Please select Salary Type');
                return false;
            }
            if(!month){
                toastr.error('Please select Month');
                return false;
            }
            if(!year){
                toastr.error('Please select Year');
                return false;
            }
            if(salary_type == 1 && !period_type){
                toastr.error('Please select Period Type');
                return false;
            }


            let url = "{{ route('payroll.generate-salary.get-salary-generate-details') }}";
            let req_data = {
                salary_type:salary_type,
                month:month,
                year:year,
                period_type:period_type,
            };
            ajaxGet(url, req_data, function (response) {
                if (response.status == 200) {
                    $(".salary-set-wrapper").html(response.data).slideDown();
                    $(".salary-generate-settings").slideUp();
                    initSalarySetSelect2();
                } else {
                    toastr.error(response.message);
                    $(".salary-set-wrapper").slideUp();
                    $(".salary-generate-settings").slideDown();
                }
            });
        }

        function backToEdit() {
            $(".salary-set-wrapper").slideUp();
            $(".salary-generate-settings").slideDown();
        }
        function initSalarySetSelect2() {
            $(".salary-set-select").select2({
                placeholder: "Select Salary Set",
                allowClear: true,
                width: '100%',
            });
        }
    </script>
@endsection


