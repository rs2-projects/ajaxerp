@extends('layouts.settings-layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="erp-employee-list-wrapper purchase-order-in-main">
                <div class="erp-main-filter-wrapper bg-card attd-table">
                    <form action="{{ route('settings.role-permission.store', $role_id) }}" id="userPermissionFormSubmit" method="POST">
                        @csrf
                        <div class="rs-erp-permission-wrapper d-flex flex-wrap">
                            <div class="rs-erp-permission-item">
                                <div class="rs-erp-permission-item-title-box">
                                    <h4>Administrator</h4>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Administration Settings</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-administration-settings" class="check" name="permissions[]" value="manage-administration-settings" 
                                                {{ in_array('manage-administration-settings', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-administration-settings" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Payroll Settings</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-payroll-settings" class="check" name="permissions[]" value="manage-payroll-settings" 
                                            {{ in_array('manage-payroll-settings', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-payroll-settings" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Tax Settings</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-tax-settings" class="check" name="permissions[]" value="manage-tax-settings"
                                            {{ in_array('manage-tax-settings', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-tax-settings" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Role Permission Settings</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-role-permission-settings" class="check" name="permissions[]" value="manage-role-permission-settings"
                                            {{ in_array('manage-role-permission-settings', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-role-permission-settings" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="rs-erp-permission-item">
                                <div class="rs-erp-permission-item-title-box">
                                    <h4>Payroll</h4>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Generate Salary</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="generate-salary" class="check" name="permissions[]" data-required-add="view-salary" value="generate-salary"
                                            {{ in_array('generate-salary', $permissions) ? 'checked' : ''}}>
                                            <label for="generate-salary" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Vew Salary</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-salary" class="check" name="permissions[]" data-required-remove="manage-salary,generate-salary" value="view-salary"
                                            {{ in_array('view-salary', $permissions) ? 'checked' : ''}}>
                                            <label for="view-salary" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Salary</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-salary" class="check" name="permissions[]" data-required-add="view-salary" value="manage-salary"
                                            {{ in_array('manage-salary', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-salary" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="rs-erp-permission-item">
                                <div class="rs-erp-permission-item-title-box">
                                    <h4>Accounting</h4>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Chart of Accounts</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-chart-of-accounts" data-required-remove="manage-chart-of-accounts" class="check" name="permissions[]" value="view-chart-of-accounts"
                                            {{ in_array('view-chart-of-accounts', $permissions) ? 'checked' : ''}}>
                                            <label for="view-chart-of-accounts" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Chart of Accounts</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-chart-of-accounts" data-required-add="view-chart-of-accounts" class="check" name="permissions[]" value="manage-chart-of-accounts"
                                            {{ in_array('manage-chart-of-accounts', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-chart-of-accounts" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rs-erp-permission-item">
                                <div class="rs-erp-permission-item-title-box">
                                    <h4>HR</h4>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Departments</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-departments" data-required-remove="manage-departments" class="check" name="permissions[]" value="view-departments"
                                            {{ in_array('view-departments', $permissions) ? 'checked' : ''}}>
                                            <label for="view-departments" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Departments</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-departments" data-required-add="view-departments" class="check" name="permissions[]" value="manage-departments"
                                            {{ in_array('manage-departments', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-departments" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Designations</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-designations" data-required-remove="manage-designations" class="check" name="permissions[]" value="view-designations"
                                            {{ in_array('view-designations', $permissions) ? 'checked' : ''}}>
                                            <label for="view-designations" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Designations</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-designations" data-required-add="view-designations" class="check" name="permissions[]" value="manage-designations"
                                            {{ in_array('manage-designations', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-designations" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Employees</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-employees" data-required-remove="manage-employees" class="check" name="permissions[]" value="view-employees"
                                            {{ in_array('view-employees', $permissions) ? 'checked' : ''}}>
                                            <label for="view-employees" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Employees</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-employees" data-required-add="view-employees" class="check" name="permissions[]" value="manage-employees"
                                            {{ in_array('manage-employees', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-employees" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Employee Termination</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-employee-termination" data-required-remove="manage-employee-termination" class="check" name="permissions[]" value="view-employee-termination"
                                            {{ in_array('view-employee-termination', $permissions) ? 'checked' : ''}}>
                                            <label for="view-employee-termination" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Employee Termination</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-employee-termination" data-required-add="view-employee-termination" class="check" name="permissions[]" value="manage-employee-termination"
                                            {{ in_array('manage-employee-termination', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-employee-termination" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Employee Resignation</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-employee-resignation" data-required-remove="manage-employee-resignation" class="check" name="permissions[]" value="view-employee-resignation"
                                            {{ in_array('view-employee-resignation', $permissions) ? 'checked' : ''}}>
                                            <label for="view-employee-resignation" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Employee Resignation</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-employee-resignation" data-required-add="view-employee-resignation" class="check" name="permissions[]" value="manage-employee-resignation"
                                            {{ in_array('manage-employee-resignation', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-employee-resignation" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Employee Leave</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-employee-leave" data-required-remove="manage-employee-leave" class="check" name="permissions[]" value="view-employee-leave"
                                            {{ in_array('view-employee-leave', $permissions) ? 'checked' : ''}}>
                                            <label for="view-employee-leave" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Employee Leave</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-employee-leave" data-required-add="view-employee-leave" class="check" name="permissions[]" value="manage-employee-leave"
                                            {{ in_array('manage-employee-leave', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-employee-leave" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Employee Attendance</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-employee-attendance" data-required-remove="manage-employee-attendance" class="check" name="permissions[]" value="view-employee-attendance"
                                            {{ in_array('view-employee-attendance', $permissions) ? 'checked' : ''}}>
                                            <label for="view-employee-attendance" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Employee Attendance</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-employee-attendance" data-required-add="view-employee-attendance" class="check" name="permissions[]" value="manage-employee-attendance"
                                            {{ in_array('manage-employee-attendance', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-employee-attendance" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Contractors</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-contractors" data-required-remove="manage-contractors" class="check" name="permissions[]" value="view-contractors"
                                            {{ in_array('view-contractors', $permissions) ? 'checked' : ''}}>
                                            <label for="view-contractors" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Contractors</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-contractors" data-required-add="view-contractors" class="check" name="permissions[]" value="manage-contractors"
                                            {{ in_array('manage-contractors', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-contractors" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Salary Set</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-salary-set" data-required-remove="manage-salary-set" class="check" name="permissions[]" value="view-salary-set"
                                            {{ in_array('view-salary-set', $permissions) ? 'checked' : ''}}>
                                            <label for="view-salary-set" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Salary Set</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-salary-set" data-required-add="view-salary-set" class="check" name="permissions[]" value="manage-salary-set"
                                            {{ in_array('manage-salary-set', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-salary-set" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="rs-erp-permission-item">
                                <div class="rs-erp-permission-item-title-box">
                                    <h4>Inventory</h4>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Product Material Category</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-product-material-category" data-required-remove="manage-product-material-category" class="check" name="permissions[]" value="view-product-material-category"
                                            {{ in_array('view-product-material-category', $permissions) ? 'checked' : ''}}>
                                            <label for="view-product-material-category" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Product Material Category</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-product-material-category" data-required-add="view-product-material-category" class="check" name="permissions[]" value="manage-product-material-category"
                                            {{ in_array('manage-product-material-category', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-product-material-category" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Product Material</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-product-material" data-required-remove="manage-product-material" class="check" name="permissions[]" value="view-product-material"
                                            {{ in_array('view-product-material', $permissions) ? 'checked' : ''}}>
                                            <label for="view-product-material" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Product Material</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-product-material" data-required-add="view-product-material" class="check" name="permissions[]" value="manage-product-material"
                                            {{ in_array('manage-product-material', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-product-material" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Asset Product Category</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-asset-product-category" data-required-remove="manage-asset-product-category" class="check" name="permissions[]" value="view-asset-product-category"
                                            {{ in_array('view-asset-product-category', $permissions) ? 'checked' : ''}}>
                                            <label for="view-asset-product-category" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Asset Product Category</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-asset-product-category" data-required-add="view-asset-product-category" class="check" name="permissions[]" value="manage-asset-product-category"
                                            {{ in_array('manage-asset-product-category', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-asset-product-category" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Asset Product</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-asset-product" data-required-remove="manage-asset-product" class="check" name="permissions[]" value="view-asset-product"
                                            {{ in_array('view-asset-product', $permissions) ? 'checked' : ''}}>
                                            <label for="view-asset-product" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Asset Product</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-asset-product" data-required-add="view-asset-product" class="check" name="permissions[]" value="manage-asset-product"
                                            {{ in_array('manage-asset-product', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-asset-product" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Warehouse</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-warehouse" data-required-remove="manage-warehouse" class="check" name="permissions[]" value="view-warehouse"
                                            {{ in_array('view-warehouse', $permissions) ? 'checked' : ''}}>
                                            <label for="view-warehouse" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Warehouse</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-warehouse" data-required-add="view-warehouse" class="check" name="permissions[]" value="manage-warehouse"
                                            {{ in_array('manage-warehouse', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-warehouse" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="rs-erp-permission-item">
                                <div class="rs-erp-permission-item-title-box">
                                    <h4>Procurement</h4>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Suppliers</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-suppliers" data-required-remove="manage-suppliers" class="check" name="permissions[]" value="view-suppliers"
                                            {{ in_array('view-suppliers', $permissions) ? 'checked' : ''}}>
                                            <label for="view-suppliers" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Suppliers</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-suppliers" data-required-add="view-suppliers" class="check" name="permissions[]" value="manage-suppliers"
                                            {{ in_array('manage-suppliers', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-suppliers" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Product Material Purchase Orders</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-product-material-purchase-orders" data-required-remove="manage-product-material-purchase-orders,product-material-purchase-order-payment" class="check" name="permissions[]" value="view-product-material-purchase-orders"
                                            {{ in_array('view-product-material-purchase-orders', $permissions) ? 'checked' : ''}}>
                                            <label for="view-product-material-purchase-orders" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Product Material Purchase Orders</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-product-material-purchase-orders" data-required-add="view-product-material-purchase-orders" class="check" name="permissions[]" value="manage-product-material-purchase-orders"
                                            {{ in_array('manage-product-material-purchase-orders', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-product-material-purchase-orders" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Product Material Purchase Order Payment</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="product-material-purchase-order-payment" data-required-add="view-product-material-purchase-orders" class="check" name="permissions[]" value="product-material-purchase-order-payment"
                                            {{ in_array('product-material-purchase-order-payment', $permissions) ? 'checked' : ''}}>
                                            <label for="product-material-purchase-order-payment" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Asset Product Purchase Request</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-asset-product-purchase-request" data-required-remove="create-asset-product-purchase-request,manage-asset-product-purchase-request" class="check" name="permissions[]" value="view-asset-product-purchase-request"
                                            {{ in_array('view-asset-product-purchase-request', $permissions) ? 'checked' : ''}}>
                                            <label for="view-asset-product-purchase-request" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Create Asset Product Purchase Request</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="create-asset-product-purchase-request" data-required-add="view-asset-product-purchase-request" class="check" name="permissions[]" value="create-asset-product-purchase-request"
                                            {{ in_array('create-asset-product-purchase-request', $permissions) ? 'checked' : ''}}>
                                            <label for="create-asset-product-purchase-request" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Asset Product Purchase Request</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-asset-product-purchase-request" data-required-add="view-asset-product-purchase-request" class="check" name="permissions[]" value="manage-asset-product-purchase-request"
                                            {{ in_array('manage-asset-product-purchase-request', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-asset-product-purchase-request" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Asset Product Purchase Orders</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-asset-product-purchase-orders" data-required-remove="manage-asset-product-purchase-orders,asset-product-purchase-order-payment" class="check" name="permissions[]" value="view-asset-product-purchase-orders"
                                            {{ in_array('view-asset-product-purchase-orders', $permissions) ? 'checked' : ''}}>
                                            <label for="view-asset-product-purchase-orders" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Asset Product Purchase Orders</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-asset-product-purchase-orders" data-required-add="view-asset-product-purchase-orders" class="check" name="permissions[]" value="manage-asset-product-purchase-orders"
                                            {{ in_array('manage-asset-product-purchase-orders', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-asset-product-purchase-orders" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Asset Product Purchase Order Payment</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="asset-product-purchase-order-payment" data-required-add="view-asset-product-purchase-orders" class="check" name="permissions[]" value="asset-product-purchase-order-payment"
                                            {{ in_array('asset-product-purchase-order-payment', $permissions) ? 'checked' : ''}}>
                                            <label for="asset-product-purchase-order-payment" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="erp-filter-box d-flex align-items-center justify-content-center flex-100 pt-4">
                                <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-center flex-100">
                                    <div class="erp-filter-item">
                                        <div class="erp-search-btn-wrap">
                                            <button class="erp-search-btn" type="submit">Save Permission</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
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
        $(document).ready(function() {
            $("#userPermissionFormSubmit").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if(res.status == 200){
                        showSuccessAlert('Success',res.message)
                        setTimeout(function() {
                            window.location.href = '{{ route("settings.role-management.index") }}';
                        }, 1000);
                        getData();
                    }else{
                        showErrorAlert('Error',res.message)
                    }
                }, 'show_input_error');
            });

            $(".check").on('change', function() {
                if($(this).is(":checked")) {
                    let requiredAdd = $(this).attr('data-required-add');
                    if(requiredAdd !== undefined) {
                        let requiredAddArr = requiredAdd.split(',');
                        requiredAddArr.forEach(function(item) {
                            $("#"+item).prop('checked', true);
                        });
                    }
                } else {
                    let requiredRemove = $(this).attr('data-required-remove');
                    if(requiredRemove !== undefined) {
                        let requiredRemoveArr = requiredRemove.split(',');
                        requiredRemoveArr.forEach(function(item) {
                            $("#"+item).prop('checked', false);
                        });
                    }
                }
            });
        });
    </script>
@endsection


