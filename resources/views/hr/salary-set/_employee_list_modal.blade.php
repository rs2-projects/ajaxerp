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
                    <div class="d-flex flex-wrap mt-3 gap-1">
                        <div class="erp-em-reg-step-item flex-32">
                            <div class="input-block erp-step-input-block ">
                                <label class="col-form-label">Name <span class="text-red">*</span></label>
                                <input class="form-control" v-model="keyword" @input="fetchEmployees" type="text" placeholder="Name">
                            </div>
                        </div>
                        <div class="erp-em-reg-step-item flex-32">
                            <div class="input-block erp-step-input-block ">
                                <label class="col-form-label">Department <span class="text-danger">*</span></label>
                                <select class="select select-step" id="department_id" onchange="getDesignation(this)">
                                    <option>Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="erp-em-reg-step-item flex-32">
                            <div class="input-block erp-step-input-block ">
                                <label class="col-form-label">Designation <span class="text-danger">*</span></label>
                                <select class="select select-step" id="designation_id" >
                                    <option >Select Designation</option>
                                    @foreach($designations as $designation)
                                        <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-main-wrapper pt-4">
                        <div class="table-body-item-wrapper d-flex flex-wrap">
                            <div class="table-body-item em-list">
                               <h4></h4>
                            </div>
                            <div class="table-body-item em-list flex-30">
                               <h4>Employee</h4>
                            </div>
                            <div class="table-body-item em-list flex-30">
                               <h4>Email/Phone</h4>
                            </div>
                            <div class="table-body-item em-list flex-30">
                                <h4>Basic Salary</h4>
                            </div>
                        </div>
                    </div>
                    <div class="table-main-wrapper pt-2" v-for="(employee, employeeIndex) in getEmployees" :key="employee.id">
                        {{--@foreach($employees as $employee)--}}
                            <div class="table-body-item-wrapper d-flex flex-wrap">
                                <div class="table-body-item em-list">
                                    <input :id="'employee_label'+employeeIndex" type="checkbox" class="check"  :value="employee.id" v-on:change="clickedEmployee(employeeIndex)" v-if="employee.is_selected === true" checked>
                                    <input :id="'employee_label'+employeeIndex" type="checkbox" class="check"  :value="employee.id" v-on:change="clickedEmployee(employeeIndex)" v-else>
                                </div>
                                <div class="table-body-item em-list flex-30">
                                    <a href="javascript:void(0)" class="em-profile-wrap d-flex align-items-center flex-wrap w-100">
                                        <div class="em-pro-img-box">
                                            <img src="@{{employee.show_image}}" alt="">
                                        </div>
                                        <div class="em-pro-details-box">
                                            <h5>@{{ employee.full_name }}</h5>
                                            <p class="em-id">ID: <span> # @{{ employee.employee_id }}</span></p>

                                        </div>
                                    </a>
                                </div>
                                <div class="table-body-item em-list flex-30">
                                    <h4 class="text-center erp-t-email">@{{ employee.email }}</h4>
                                    <h4 class="text-center erp-t-email">@{{ employee.phone }}</h4>
                                </div>
                                <div class="table-body-item em-list flex-30">
                                    <input class="form-control " type="text" placeholder="Basic Salary" v-model="employee.basic_salary" required="">
                                </div>
                            </div>
                        {{--@endforeach--}}
                    </div>
                    <div class="submit-section mt-4">
                        <button class="btn btn-primary submit-btn" data-bs-dismiss="modal" type="button">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Add designation Modal -->
