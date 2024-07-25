@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row" id="VueApp">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">
                <a href="javascript(0)" data-bs-toggle="modal" data-bs-target="#employee_list_modal" class="btn add-btn erp-add-employee ms-2" ><i class="fa-solid fa-plus"></i>Choose Employees</a>
            </div>
        </div>

        <div class="erp-employee-list-wrapper">
            <form action="{{ route('hr.salary-set.set-employees.store',$salarySet->id) }}" method="post" id="employeeSetStoreForm">
                @csrf
                {{--<div class="submit-section mt-3" v-if="selectedEmployees.length > 0">
                    <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                </div>--}}
                <div class="erp-main-filter-wrapper d-flex justify-content-center ">
                    <div class="erp-add-em-step-wrapper bg-card flex-100">
                        <div class="erp-step-content-wrapper">
                            <div id="reg-employee">
                                <h3 class="d-none">Employee Set</h3>
                                <section class="erp-step-salary-wrapper">
                                    <div class="table-main-wrapper pt-4" >
                                        <div class="table-header-wrapper d-flex flex-wrap">
                                            <div class="table-header-item em-list">
                                                <h4>SL</h4>
                                            </div>
                                            <div class="table-header-item em-list text-start flex-23">
                                                <h4>Name</h4>
                                            </div>
                                            <div class="table-header-item em-list text-center flex-23">
                                                <h4>Email/Phone</h4>
                                            </div>
                                            <div class="table-header-item em-list text-center flex-23">
                                                <h4>Department/Designation</h4>
                                            </div>
                                            <div class="table-header-item em-list text-center flex-20">
                                                <h4>Basic Salary</h4>
                                            </div>
                                        </div>
                                        <div class="table-body-wrapper" v-for="(selectedEmployee, selectedEmployeeItemIndex) in selectedEmployees" :key="selectedEmployee.id">
                                            <div class="table-body-item-wrapper d-flex">

                                                <div class="table-body-item em-list">
                                                    <input type="hidden" name="employee_id[]" :value="selectedEmployee.id">
                                                    <h4>1</h4>
                                                </div>
                                                <div class="table-body-item em-list flex-23">
                                                    <a href="#" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                                        <div class="em-pro-img-box">
                                                            <img src="@{{ selectedEmployee.show_image }}" alt="">
                                                        </div>
                                                        <div class="em-pro-details-box">
                                                            <h5>@{{ selectedEmployee.full_name }}</h5>
                                                            <p class="em-id">ID: <span> # @{{ selectedEmployee.employee_id }}</span></p>

                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="table-body-item em-list flex-23">
                                                    <h4 class="text-center erp-t-email">@{{ selectedEmployee.email }}</h4>
                                                    <h4 class="text-center erp-t-email">@{{ selectedEmployee.phone }}</h4>
                                                </div>
                                                <div class="table-body-item em-list flex-23 d-block">
                                                    <h4 class="text-center erp-t-phone">@{{ selectedEmployee.department.name }}</h4>
                                                    <h4 class="text-center erp-t-phone">@{{ selectedEmployee.designation.name }}</h4>
                                                </div>
                                                <div class="table-body-item em-list flex-20">
                                                    <input type="text" class="form-control" name="basic_salary[]" required v-model="selectedEmployee.basic_salary">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <div class="submit-section mt-3" v-if="selectedEmployees.length > 0">
                                    <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @include('hr.salary-set._employee_list_modal')
    </div>


@endsection

@section('modals')

@endsection

@section('css')
    <style>

    </style>
@endsection

@section('css_plugins')
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('js_plugins')
    <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
    <!-- Datetimepicker JS -->
    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
@endsection

@section('js')
    @include('layouts.partials.__vue_scripts')

    <script>
        $(document).ready(function() {
            initializeDatepicker();
            initializeSelect();

            $(document).on("submit", "#employeeSetStoreForm", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    if(res.status == 200){
                        showSuccessAlert('Success',res.message)
                        window.location.href = "{{ route('hr.salary-set') }}";
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });
        });

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

        function initializeSelect() {
            $('#addEducationWrapMain .select2').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });
        }


        function employeeListModal(){
            $('#employee_list_modal').modal('show');
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



    <script>
        var { createApp } = Vue;

        var vueApp = createApp({
            data() {
                return {
                    keyword: '',
                    getEmployees:[],
                    basic_salary: 0,

                }
            },
            computed: {
                isAllChecked() {
                    let isFalse = this.getEmployees.find(o => o.is_selected !== true);
                    if(isFalse !== undefined) {
                        return false;
                    } else {
                        return true;
                    }
                    // return isFalse;
                },
                selectedEmployees() {
                    return $.grep(this.getEmployees, function (e) {
                        return e.is_selected === true;
                    });
                },

                filteredEmployees() {
                    return this.getEmployees.filter((employee) =>
                        employee.full_name.toUpperCase().includes(this.keyword.toUpperCase())
                    );
                },
            },
            methods: {

                fetchEmployees() {

                    let keyword = this.keyword;

                    axios
                        .get("{{ route('ajax.salary-set.get-employees') }}", {
                            params: {
                                keyword: keyword,
                                salary_set_id: "{{ $salarySet->id }}"
                            }
                        })
                        .then(response => {
                            this.getEmployees = response.data.getEmployees;
                        })
                        .catch(error => {
                            console.log(error);
                        });

                },

                clickedEmployee(index) {
                    let selected_employee = this.filteredEmployees[index];
                    console.log(selected_employee);
                    let selected_index = this.getEmployees.findIndex(o => o.id === selected_employee.id);
                    this.getEmployees[selected_index].is_selected = !this.getEmployees[selected_index].is_selected;
                },
                unCheckAllEmployee() {
                    for(let i=0; i<this.getEmployees.length; i++) {
                        this.getEmployees[i].is_selected = false;
                    }
                },

            },
            created() {

            },
            mounted () {

                this.fetchEmployees();

            }
        }).mount('#VueApp');
    </script>
@endsection


