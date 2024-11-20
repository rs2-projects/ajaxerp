@extends('layouts.layout')
@section('content')
<div id="VueApp">
    <!-- Start::row-1 -->
    <div class="row">
        @if(hasPermission('manage-customers'))
            <div class="erp-add-employee-wrapper mb-3">
                <div class="erp-add-employee">
                    <a href="javascript:void(0)" class="btn add-btn erp-add-employee" v-on:click="addEmployeeModal()"><i class="fa-solid fa-plus"></i> Add Employees</a>
                </div>
            </div>
        @endif
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <form id="filterForm" class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                            <div class="erp-filter-box d-flex align-items-center justify-content-start flex-100">
                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-start flex-100">
                                    <div class="erp-filter-item flex-7">
                                        <h6 class="me-2">Search By: </h6>
                                    </div>

                                    <div class="erp-filter-item flex-30">
                                        <div class="search-box table-search position-relative">
                                            <input class="form-control" type="text" id="keyword_filtered" placeholder="Name ">
                                            <button class="btn position-absolute search-btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>

                        <div class="table-main-wrapper pt-4" id="ajax-data-load">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End::row-1 -->

    @include('showroom._employee_list_modal')
</div>
@endsection

@section('modals')
    
@endsection

@section('css')
    <style>
        .delete-btn-box.bank-info-remove {
            top: 10px;
        }
        .edit-img-src{
            margin-left: 5px;
            border-radius: 5px;
        }
    </style>
@endsection

@section('css_plugins')

@endsection

@section('js_plugins')
    
@endsection

@section('js')
    <script>
        $("#filterForm").on('submit', function (e) {
            e.preventDefault();
            getData();
        });
        var filterData = {
            keyword_filtered: ''
        };
        $(document).ready(function() {
            getData();

            filterData.keyword_filtered = $("#keyword_filtered").val()
            $("#keyword_filtered").on('input', function () {
                filterData.keyword_filtered = $(this).val();
            });

            $("#storeEmployeeForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        $("#employee_list_modal").modal('hide');
                        $(self)[0].reset();
                        showSuccessAlert('Success',res.message)
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });
        });

        function getData(){
            getPaginatedListData("{{ route('showroom.showroom-employees.index.filtered', $showroomId) }}", "#ajax-data-load", filterData);
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load", filterData);
        }

        function editItem(id){
            let url = "{{route('showroom.edit', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_showroom_modal_body").html(response.view);
                    $("#editShowroomModal").modal('show');
                    initializeSelect();
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }

        

    </script>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var { createApp } = Vue;

        var vueApp = createApp({
            data() {
                return {
                    employees: [],
                    selected_employees: [],
                    employee_filter_keyword: '',
                }
            },
            computed: {
                
            },
            methods: {
                fetchEmployees() {
                    axios
                        .get("{{ route('showroom.showroom-employees.free-employees') }}?keyword=" + this.employee_filter_keyword)
                        .then(response => {
                            this.employees = response.data.employees.data.map(employee => {
                                employee.is_selected = false;
                                //find if employee is already selected
                                let selectedEmployee = this.selected_employees.find(semployee => semployee.id === employee.id);
                                if (selectedEmployee) {
                                    employee.is_selected = true;
                                }
                                return employee;
                            });
                        });
                },
                clickedEmployee(index) {
                    let employee = this.employees[index];
                    if (employee.is_selected) {
                        employee.is_selected = false;
                        let selectedEmployeeIndex = this.selected_employees.findIndex(semployee => semployee.id === employee.id);
                        console.log("selectedEmployeeIndex", selectedEmployeeIndex);
                        this.selected_employees.splice(selectedEmployeeIndex, 1);
                    } else {
                        employee.is_selected = true;
                        this.selected_employees.push(employee);
                    }
                },
                removeSelectedEmployee(index) {
                    let employee_id = this.selected_employees[index].id;
                    let employeeIndex = this.employees.findIndex(employee => employee.id === employee_id);
                    this.selected_employees.splice(index, 1);
                    this.employees[employeeIndex].is_selected = false;
                },
                addEmployeeModal() {
                    this.fetchEmployees();
                    this.selected_employees = [];
                    $("#employee_list_modal").modal('show');
                },
            },
            mounted () {
                this.fetchEmployees();
            }

        }).mount('#VueApp');
    </script>
@endsection


