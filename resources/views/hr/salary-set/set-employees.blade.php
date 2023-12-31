@extends('layouts.layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row" id="VueApp">

        <div class="erp-employee-list-wrapper">
            <form action="{{ route('hr.salary-set.store') }}" method="post" id="salarySetStoreForm">
                @csrf
                <div class="erp-main-filter-wrapper d-flex justify-content-center ">
                    <div class="erp-add-em-step-wrapper bg-card flex-100">
                        <div class="erp-step-content-wrapper">
                            <div id="reg-employee">
                                <h3 class="d-none">Employee Set</h3>
                                <section class="erp-step-salary-wrapper">
                                    <div class="table-main-wrapper pt-4" >
                                        <a href="javascript:void(0)" onclick="employeeListModal()" class="employee-set-btn"><i class="fa-solid fa-plus"></i></a>
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
                                            <div class="table-header-item em-list text-center flex-23">
                                                <h4>Basic Salary</h4>
                                            </div>
                                        </div>
                                        <div class="table-body-wrapper" v-for="(selectedEmployee, selectedEmployeeItemIndex) in getEmployees" :key="selectedEmployee.id">
                                            <div class="table-body-item-wrapper d-flex flex-wrap">
                                                <input type="hidden" name="employee_id[]" :value="selectedEmployee.id">
                                                <div class="table-body-item em-list">
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
                                                <div class="table-body-item em-list flex-23">
                                                    <h4 class="text-center erp-t-phone">Department</h4>
                                                    <h4 class="text-center erp-t-phone">Designation</h4>
                                                </div>
                                                <div class="table-body-item em-list flex-23">
                                                    <h4 class="text-center erp-t-department">105000</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
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
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        $(document).ready(function() {
            initializeDatepicker();
            initializeSelect()
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

    </script>



    <script>
        var { createApp } = Vue;

        var vueApp = createApp({
            data() {
                return {
                    keyword: '',
                    getEmployees:[],

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
                    let self = this;
                    return this.getEmployees.filter(o => o.full_name.toUpperCase().includes(self.keyword.toUpperCase()));
                },
            },
            methods: {

                fetchEmployees() {

                    let keyword = this.keyword;

                    axios
                        .get("{{ route('ajax.get-employees') }}", {
                            params: {
                                keyword: keyword,
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


