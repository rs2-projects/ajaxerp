@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">

        <div class="erp-employee-details-wrapper">
            <div class="erp-employee-details-item-wrapper d-flex flex-wrap" id="ajax-data-load">
            </div>
        </div>


    </div>
    <!--End::row-1 -->
    <div id="bankInfoWrap" style="display: none;">
        <div class="erp-em-edu-step-wrapper d-flex flex-wrap">
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Bank Name: </label>
                    <input class="form-control "  name="bank_name[]" type="text" placeholder="">
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Account Name: </label>
                    <input class="form-control "  name="account_name[]" type="text" placeholder="">
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Account Number: </label>
                    <input class="form-control "  name="account_number[]" type="text" placeholder="">
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Branch: </label>
                    <input class="form-control "  name="branch_name[]" type="text" >
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Routing Number: </label>
                    <input class="form-control "  name="routing_number[]" type="text" >
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Swift Code: </label>
                    <input class="form-control " name="swift_code[]" type="text" >
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Note: </label>
                    <input class="form-control " name="note[]" type="text" >
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">E-Wallet (Gcash/Maya): </label>
                    <input class="form-control " value="" name="e_wallet[]" type="text" >
                </div>
            </div>
        </div>
    </div>

    {{--add education--}}
    <div id="addEducationWrap" style="display: none;">
        <div class="erp-em-edu-step-wrapper d-flex flex-wrap">

            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Degree: </label>
                    <select class="select2 select-step" name="degree[]">
                        <option value="">Select Degree</option>
                        <option value="ssc">SSC</option>
                        <option value="hsc">HSC </option>
                        <option value="diploma">Diploma </option>
                        <option value="honusrs">Honours </option>
                        <option value="associate_degree">Associate Degree </option>
                        <option value="bachelor_of_science">Bachelor of Science </option>
                        <option value="master_of_science">Master of Science </option>
                        <option value="others">Other's </option>

                    </select>
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Institute Number: </label>
                    <input class="form-control " name="institute_name[]" type="text" placeholder="">
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Subject: </label>
                    <input class="form-control " name="subject[]" type="text" >
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Grade: </label>
                    <input class="form-control " name="grade[]" type="text" >
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Start : </label>
                    <div class="cal-icon"><input class="form-control datetimepicker" name="start_date[]" type="text" ></div>
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Ending: </label>
                    <div class="cal-icon"><input class="form-control datetimepicker" name="end_date[]" type="text" ></div>
                </div>
            </div>
        </div>
    </div>
    <div id="addExperienceWrap" style="display: none;">
        <div class="erp-em-edu-step-wrapper d-flex flex-wrap">
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Company name: </label>
                    <input class="form-control "  name="company_name[]" type="text" placeholder="">
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Designation: </label>
                    <input class="form-control " name="designation[]" type="text" >
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Start : </label>
                    <div class="cal-icon"><input class="form-control datetimepicker" name="start_date[]" type="text" ></div>
                </div>
            </div>
            <div class="erp-em-reg-step-item flex-48">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Ending: </label>
                    <div class="cal-icon"><input class="form-control datetimepicker"  name="end_date[]" type="text" ></div>
                </div>
            </div>
        </div>
    </div>

    <div id="emergencyContactWrap" style="display: none;">
        <div class="erp-emergency-child-contact-wrap flex-wrap flex-48">
            <div class="erp-emergency-contact-item flex-100">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Name </label>
                    <input class="form-control " name="contact_name[]" required type="text" >
                </div>
            </div>
            <div class="erp-emergency-contact-item flex-100">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Email </label>
                    <input class="form-control " name="contact_email[]" type="text" >
                </div>
            </div>
            <div class="erp-emergency-contact-item flex-100">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Phone </label>
                    <input class="form-control " name="contact_phone[]" type="text" >
                </div>
            </div>
            <div class="erp-emergency-contact-item flex-100">
                <div class="input-block erp-step-input-block ">
                    <label class="col-form-label">Relationship </label>
                    <input class="form-control " name="contact_relation[]" required type="text" >
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modals')
    @include('hr.employee._profile_info_modal')
    @include('hr.employee._personal_info_modal')
    @include('hr.employee._bank_info_modal')
    @include('hr.employee._education_info_modal')
    @include('hr.employee._emergency_contact_modal')
    @include('hr.employee._experience_info_modal')
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
    $(document).ready(function() {
        initializeDatepicker();
        getData();
        initEducationSelect2();

        $(document).on("submit", "#profileInfoUpdateForm", function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $(".ie-span").text("").hide();
            var url = $(this).attr('action');

            formPost(url, formData, function (res){
                if(res.status == 200){
                    $("#profile_info_modal").modal('hide');
                    showSuccessAlert('Success',res.message)
                    getData();
                }else{
                    showErrorAlert('Error',res.message)
                }
            }, 'show_input_error');
        });
        $(document).on("submit", "#personalInfoUpdateForm", function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $(".ie-span").text("").hide();
            var url = $(this).attr('action');

            formPost(url, formData, function (res){
                if(res.status == 200){
                    $("#personal_info_modal").modal('hide');
                    showSuccessAlert('Success',res.message)
                    getData();
                }else{
                    showErrorAlert('Error',res.message)
                }
            }, 'show_input_error');
        });
        $(document).on("submit", "#bankInfoUpdateForm", function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $(".ie-span").text("").hide();
            var url = $(this).attr('action');

            formPost(url, formData, function (res){
                if(res.status == 200){
                    $("#bank_info_modal").modal('hide');
                    showSuccessAlert('Success',res.message)
                    getData();
                }else{
                    showErrorAlert('Error',res.message)
                }
            }, 'show_input_error');
        });
        $(document).on("submit", "#educationInfoUpdateForm", function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $(".ie-span").text("").hide();
            var url = $(this).attr('action');

            formPost(url, formData, function (res){
                if(res.status == 200){
                    $("#education_info_modal").modal('hide');
                    showSuccessAlert('Success',res.message)
                    getData();
                }else{
                    showErrorAlert('Error',res.message)
                }
            }, 'show_input_error');
        });
        $(document).on("submit", "#experienceInfoUpdateForm", function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $(".ie-span").text("").hide();
            var url = $(this).attr('action');

            formPost(url, formData, function (res){
                if(res.status == 200){
                    $("#experience_info_modal").modal('hide');
                    showSuccessAlert('Success',res.message)
                    getData();
                }else{
                    showErrorAlert('Error',res.message)
                }
            }, 'show_input_error');
        });
        $(document).on("submit", "#emergencyContactUpdateForm", function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $(".ie-span").text("").hide();
            var url = $(this).attr('action');

            formPost(url, formData, function (res){
                if(res.status == 200){
                    $("#emergency_contact_modal").modal('hide');
                    showSuccessAlert('Success',res.message)
                    getData();
                }else{
                    showErrorAlert('Error',res.message)
                }
            }, 'show_input_error');
        });
    });

    function getData(){
        getPaginatedListData("{{ route('hr.employee.detail.filtered',$employee->id) }}", "#ajax-data-load");
    }

    function getPaginatedData(button) {
        getPaginatedListData($(button).attr('data-href'), "#ajax-data-load");
    }

    function addEmergencyContact(){
        var item = $('#emergencyContactWrap').html();

        $('#emergencyContactWrapMain').append(item);
    }
    function addEducation(){
        var item = $('#addEducationWrap').html();
        $('#addEducationWrapMain').append(item);
        initEducationSelect2();
    }
    function initEducationSelect2() {
        $("#addEducationWrapMain .select2").select2({
            minimumResultsForSearch: -1,
            width: '100%'
        });
    }
    function addBankInfo(){
        var item = $('#bankInfoWrap').html();

        $('#bankInfoWrapMain').append(item);
    }
    function addExperienceInfo(){
        var item = $('#addExperienceWrap').html();

        $('#addExperienceWrapMain').append(item);
        initializeDatepicker();
    }

    function initializeDatepicker() {
        $('.datetimepicker').datetimepicker({
            //format: 'DD/MM/YYYY',
            format: 'YYYY-MM-DD',
            icons: {
                up: "fa fa-angle-up",
                down: "fa-solid fa-angle-down",
                next: 'fa-solid fa-angle-right',
                previous: 'fa-solid fa-angle-left'
            }
        });
    }
    function getDesignation(select) {
        var department_id = $(select).val();
        let url = "{{ route('ajax.get-designation-by-department') }}";
        ajaxGet(url, {department_id:department_id}, function (response) {
            if (response.status == 200) {
                $("#designation_id").html(response.view);
            } else {
                toastr.error(response.message);
            }
        });
    }
</script>
@endsection


