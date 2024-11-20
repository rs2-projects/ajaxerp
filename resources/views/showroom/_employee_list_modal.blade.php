<!-- edit Profile Info Modal -->
<div id="employee_list_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header erp-modal-header">
                <h5 class="modal-title">Select Employees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body erp-modal-body">
                <div class="erp-modal-body-content">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex flex-wrap mt-3 gap-1">
                                <div class="erp-em-reg-step-item flex-50">
                                    <div class="input-block erp-step-input-block ">
                                        <label class="col-form-label">Search By: </label>
                                        <input class="form-control" v-model="employee_filter_keyword" @input="fetchEmployees" type="text" placeholder="Name / Email">
                                    </div>
                                </div>
                            </div>
                            <div class="table-main-wrapper pt-4">
                                <div class="table-body-item-wrapper d-flex flex-wrap">
                                    <div class="table-body-item em-list">
                                       <h4></h4>
                                    </div>
                                    <div class="table-body-item em-list flex-40">
                                       <h4>Employee</h4>
                                    </div>
                                    <div class="table-body-item em-list flex-40">
                                       <h4>Email/Phone</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="table-main-wrapper pt-2" v-for="(employee, employeeIndex) in employees" :key="employee.id">
                                <div class="table-body-item-wrapper d-flex flex-wrap">
                                    <div class="table-body-item em-list">
                                        <input :id="'employee_label'+employeeIndex" type="checkbox" class="check"  :value="employee.id" v-on:change="clickedEmployee(employeeIndex)" v-if="employee.is_selected === true" checked>
                                        <input :id="'employee_label'+employeeIndex" type="checkbox" class="check"  :value="employee.id" v-on:change="clickedEmployee(employeeIndex)" v-else>
                                    </div>
                                    <div class="table-body-item em-list flex-40">
                                        <a href="javascript:void(0)" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                            <div class="em-pro-img-box">
                                                <img :src="employee.show_image" alt="">
                                            </div>
                                            <div class="em-pro-details-box">
                                                <h5>@{{ employee.full_name }}</h5>
                                                <p class="em-id">ID: <span> # @{{ employee.employee_id }}</span></p>
    
                                            </div>
                                        </a>
                                    </div>
                                    <div class="table-body-item em-list flex-40">
                                        <h4 class="text-center erp-t-email">@{{ employee.email }}</h4>
                                        <h4 class="text-center erp-t-email">@{{ employee.phone }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <form action="{{ route('showroom.showroom-employees.store', $showroomId) }}" id="storeEmployeeForm" method="PSOT">
                                @csrf
                                <div class="employee-select-top-box">
                                    Selected Employees
                                </div>
                                <div class="table-wrapper">
                                    <table class="table mb-0 erp-table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(selectedEmployee, selectedEmployeeIndex) in selected_employees" key="selectedEmployeeIndex">
                                                <td>
                                                    <input type="hidden" name="employee_id[]" :value="selectedEmployee.id">
                                                    <a href="javascript:void(0)" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                                        <div class="em-pro-img-box">
                                                            <img :src="selectedEmployee.show_image" alt="">
                                                        </div>
                                                        <div class="em-pro-details-box">
                                                            <h5>@{{ selectedEmployee.full_name }}</h5>
                                                            <p class="em-id">ID: <span> # @{{ selectedEmployee.employee_id }}</span></p>
                
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="text-danger" v-on:click="removeSelectedEmployee(selectedEmployeeIndex)"> <i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="submit-section mt-4">
                                    <button class="btn btn-primary submit-btn" type="submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Add designation Modal -->
