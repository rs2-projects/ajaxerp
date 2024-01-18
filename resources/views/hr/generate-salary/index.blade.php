@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">

        <div class="erp-employee-list-wrapper">
            <form action="{{ route('hr.generate-salary.create') }}" method="post" id="generateSalaryStoreForm">
                @csrf
                <div class="erp-main-filter-wrapper d-flex justify-content-center ">
                    <div class="erp-add-em-step-wrapper bg-card flex-100">
                        <div class="erp-step-content-wrapper">
                            <div id="reg-employee">
                                <section class="erp-em-general-info">
                                    <div class="erp-em-reg-step-wrapper d-flex flex-wrap">
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Salary Type <span class="text-danger">*</span></label>
                                                <select class="select select-step" onchange="getSalarySetBySalaryType()" name="salary_type" id="salary_type" required>
                                                    <option value="">Select Salary Type</option>
                                                    <option value="1">Half Month</option>
                                                    <option value="2">Full Month</option>
                                                </select>
                                                <span class="salary_type_error ie-span"></span>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Salary Set <span class="text-danger">*</span></label>
                                                <select class="select select-step" name="salary_set" id="salary_set" required>
                                                    <option value="">Select Salary Set</option>
                                                </select>
                                                <span class="salary_type_error ie-span"></span>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Year <span class="text-danger">*</span></label>
                                                <select class="select select-step" name="year" id="year" required>
                                                    @for($i=(date('Y') - 2);$i<=(date('Y'));$i++)
                                                        <option value="{{$i}}" {{ (request()->year == $i)?'selected':'' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                <span class="salary_type_error ie-span"></span>
                                            </div>
                                        </div>
                                        <div class="erp-em-reg-step-item flex-48">
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
                                        <div class="erp-em-reg-step-item flex-48 period-type-slide-up-down" style="display: none">
                                            <div class="input-block erp-step-input-block ">
                                                <label class="col-form-label">Period Type <span class="text-danger">*</span></label>
                                                <select class="select select-step" name="period_type" id="period_type" required>
                                                    <option value="">Select Period Type</option>
                                                    <option value="1">First Half</option>
                                                    <option value="2">Second Half</option>
                                                </select>
                                                <span class="salary_type_error ie-span"></span>
                                            </div>
                                        </div>
                                        <div class="submit-section mt-2">
                                            <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </section>
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
            }else{
                $(".period-type-slide-up-down").slideUp();
            }
            let url = "{{ route('hr.generate-salary.get-salary-set-by-salary-type') }}";
            ajaxGet(url, {salary_type:salary_type}, function (response) {
                if (response.status == 200) {
                    $("#salary_set").html(response.data);
                } else {
                    toastr.error(response.message);
                }
            });
        }
    </script>
@endsection


