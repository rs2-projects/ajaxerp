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
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Transactions</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-transactions" data-required-remove="manage-transactions,add-expenses,verify-transactions" class="check" name="permissions[]" value="view-transactions"
                                            {{ in_array('view-transactions', $permissions) ? 'checked' : ''}}>
                                            <label for="view-transactions" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Transactions</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-transactions" data-required-add="view-transactions" class="check" name="permissions[]" value="manage-transactions"
                                            {{ in_array('manage-transactions', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-transactions" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Add Expenses</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="add-expenses" data-required-add="view-transactions" class="check" name="permissions[]" value="add-expenses"
                                            {{ in_array('add-expenses', $permissions) ? 'checked' : ''}}>
                                            <label for="add-expenses" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Verify Transactions</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="verify-transactions" data-required-add="view-transactions" class="check" name="permissions[]" value="verify-transactions"
                                            {{ in_array('verify-transactions', $permissions) ? 'checked' : ''}}>
                                            <label for="verify-transactions" class="checktoggle">checkbox</label>
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
                                            <input type="checkbox" id="view-employees" data-required-remove="manage-employees,login-employye-account" class="check" name="permissions[]" value="view-employees"
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
                                        <h4>Login Employee Account</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="login-employye-account" data-required-add="view-employees" class="check" name="permissions[]" value="login-employye-account"
                                            {{ in_array('login-employye-account', $permissions) ? 'checked' : ''}}>
                                            <label for="login-employye-account" class="checktoggle">checkbox</label>
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

                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Finished Goods Category</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-finished-goods-category" data-required-remove="manage-finished-goods-category" class="check" name="permissions[]" value="view-finished-goods-category"
                                            {{ in_array('view-finished-goods-category', $permissions) ? 'checked' : ''}}>
                                            <label for="view-finished-goods-category" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Finished Goods Category</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-finished-goods-category" data-required-add="view-finished-goods-category" class="check" name="permissions[]" value="manage-finished-goods-category"
                                            {{ in_array('manage-finished-goods-category', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-finished-goods-category" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Finished Goods</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-finished-goods" data-required-remove="manage-finished-goods" class="check" name="permissions[]" value="view-finished-goods"
                                            {{ in_array('view-finished-goods', $permissions) ? 'checked' : ''}}>
                                            <label for="view-finished-goods" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Finished Goods</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-finished-goods" data-required-add="view-finished-goods" class="check" name="permissions[]" value="manage-finished-goods"
                                            {{ in_array('manage-finished-goods', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-finished-goods" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Received Products</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-received-products" data-required-remove="receive-products" class="check" name="permissions[]" value="view-received-products"
                                            {{ in_array('view-received-products', $permissions) ? 'checked' : ''}}>
                                            <label for="view-received-products" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Receive Products</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="receive-products" data-required-add="view-received-products" class="check" name="permissions[]" value="receive-products"
                                            {{ in_array('receive-products', $permissions) ? 'checked' : ''}}>
                                            <label for="receive-products" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Material Requests</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-material-requests" data-required-remove="deliver-requested-materials" class="check" name="permissions[]" value="view-material-requests"
                                                {{ in_array('view-material-requests', $permissions) ? 'checked' : ''}}>
                                            <label for="view-material-requests" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Deliver Requested Materials</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="deliver-requested-materials" data-required-add="view-material-requests" class="check" name="permissions[]" value="deliver-requested-materials"
                                                {{ in_array('deliver-requested-materials', $permissions) ? 'checked' : ''}}>
                                            <label for="deliver-requested-materials" class="checktoggle">checkbox</label>
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
                                            <input type="checkbox" id="view-product-material-purchase-orders" data-required-remove="manage-product-material-purchase-orders,product-material-purchase-order-payment,product-material-purchase-print-barcode" class="check" name="permissions[]" value="view-product-material-purchase-orders"
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
                                        <h4>Product Material Purchase Print Barcode</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="product-material-purchase-print-barcode" data-required-add="view-product-material-purchase-orders" class="check" name="permissions[]" value="product-material-purchase-print-barcode"
                                            {{ in_array('product-material-purchase-print-barcode', $permissions) ? 'checked' : ''}}>
                                            <label for="product-material-purchase-print-barcode" class="checktoggle">checkbox</label>
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

                            {{-- sales & order --}}
                            <div class="rs-erp-permission-item">
                                <div class="rs-erp-permission-item-title-box">
                                    <h4>Sales & Order</h4>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Customers</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-customers" data-required-remove="manage-customers" class="check" name="permissions[]" value="view-customers"
                                            {{ in_array('view-customers', $permissions) ? 'checked' : ''}}>
                                            <label for="view-customers" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Customers</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-customers" data-required-add="view-customers" class="check" name="permissions[]" value="manage-customers"
                                            {{ in_array('manage-customers', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-customers" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Invoices</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-invoices" data-required-remove="manage-invoices,make-payment,deliver-items" class="check" name="permissions[]" value="view-invoices"
                                            {{ in_array('view-invoices', $permissions) ? 'checked' : ''}}>
                                            <label for="view-invoices" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Invoices</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-invoices" data-required-add="view-invoices" class="check" name="permissions[]" value="manage-invoices"
                                            {{ in_array('manage-invoices', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-invoices" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Make Payment</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="make-payment" data-required-add="view-invoices" class="check" name="permissions[]" value="make-payment"
                                            {{ in_array('make-payment', $permissions) ? 'checked' : ''}}>
                                            <label for="make-payment" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Deliver Items</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="deliver-items" data-required-add="view-invoices" class="check" name="permissions[]" value="deliver-items"
                                            {{ in_array('deliver-items', $permissions) ? 'checked' : ''}}>
                                            <label for="deliver-items" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- pre production & production --}}
                            <div class="rs-erp-permission-item">
                                <div class="rs-erp-permission-item-title-box">
                                    <h4>Production & Pre Production</h4>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Machines</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-machines" data-required-remove="manage-machines" class="check" name="permissions[]" value="view-machines"
                                            {{ in_array('view-machines', $permissions) ? 'checked' : ''}}>
                                            <label for="view-machines" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Machines</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-machines" data-required-add="view-machines" class="check" name="permissions[]" value="manage-machines"
                                            {{ in_array('manage-machines', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-machines" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Pre Productions</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-pre-productions" data-required-remove="manage-pre-productions,verify-pre-productions" class="check" name="permissions[]" value="view-pre-productions"
                                            {{ in_array('view-pre-productions', $permissions) ? 'checked' : ''}}>
                                            <label for="view-pre-productions" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Pre Productions</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-pre-productions" data-required-add="view-pre-productions" class="check" name="permissions[]" value="manage-pre-productions"
                                            {{ in_array('manage-pre-productions', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-pre-productions" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Verify Pre Productions</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="verify-pre-productions" data-required-add="view-pre-productions" class="check" name="permissions[]" value="verify-pre-productions"
                                            {{ in_array('verify-pre-productions', $permissions) ? 'checked' : ''}}>
                                            <label for="verify-pre-productions" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Production</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-production" data-required-remove="manage-processes,receive-production-materials,dispatch-production-materials,production-print-barcode" class="check" name="permissions[]" value="view-production"
                                            {{ in_array('view-production', $permissions) ? 'checked' : ''}}>
                                            <label for="view-production" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Production Processes</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-processes" data-required-add="view-production" class="check" name="permissions[]" value="manage-processes"
                                            {{ in_array('manage-processes', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-processes" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Receive Production Materials</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="receive-production-materials" data-required-add="view-production" class="check" name="permissions[]" value="receive-production-materials"
                                            {{ in_array('receive-production-materials', $permissions) ? 'checked' : ''}}>
                                            <label for="receive-production-materials" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Dispatch Production Materials</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="dispatch-production-materials" data-required-add="view-production" class="check" name="permissions[]" value="dispatch-production-materials"
                                            {{ in_array('dispatch-production-materials', $permissions) ? 'checked' : ''}}>
                                            <label for="dispatch-production-materials" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Production Print Barcode</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="production-print-barcode" data-required-add="view-production" class="check" name="permissions[]" value="production-print-barcode"
                                            {{ in_array('production-print-barcode', $permissions) ? 'checked' : ''}}>
                                            <label for="production-print-barcode" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- board pre production & production --}}
                            <div class="rs-erp-permission-item">
                                <div class="rs-erp-permission-item-title-box">
                                    <h4>Board Production & Pre Production</h4>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Pre Productions</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-board-pre-productions" data-required-remove="manage-board-pre-productions,verify-board-pre-productions" class="check" name="permissions[]" value="view-board-pre-productions"
                                            {{ in_array('view-board-pre-productions', $permissions) ? 'checked' : ''}}>
                                            <label for="view-board-pre-productions" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Manage Pre Productions</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="manage-board-pre-productions" data-required-add="view-board-pre-productions" class="check" name="permissions[]" value="manage-board-pre-productions"
                                            {{ in_array('manage-board-pre-productions', $permissions) ? 'checked' : ''}}>
                                            <label for="manage-board-pre-productions" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Verify Pre Productions</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="verify-board-pre-productions" data-required-add="view-board-pre-productions" class="check" name="permissions[]" value="verify-board-pre-productions"
                                            {{ in_array('verify-board-pre-productions', $permissions) ? 'checked' : ''}}>
                                            <label for="verify-board-pre-productions" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>View Production</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="view-board-production" data-required-remove="receive-board-production-materials,dispatch-board-production-materials,production-board-print-barcode" class="check" name="permissions[]" value="view-board-production"
                                            {{ in_array('view-board-production', $permissions) ? 'checked' : ''}}>
                                            <label for="view-board-production" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Receive Production Materials</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="receive-board-production-materials" data-required-add="view-board-production" class="check" name="permissions[]" value="receive-board-production-materials"
                                            {{ in_array('receive-board-production-materials', $permissions) ? 'checked' : ''}}>
                                            <label for="receive-board-production-materials" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Dispatch Production Materials</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="dispatch-board-production-materials" data-required-add="view-board-production" class="check" name="permissions[]" value="dispatch-board-production-materials"
                                            {{ in_array('dispatch-board-production-materials', $permissions) ? 'checked' : ''}}>
                                            <label for="dispatch-board-production-materials" class="checktoggle">checkbox</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="rs-erp-permission-c-item-wrapper d-flex justify-content-between">
                                    <div class="rs-erp-permission-c-item">
                                        <h4>Production Print Barcode</h4>
                                    </div>
                                    <div class="rs-erp-permission-c-item ">
                                        <div class="status-toggle rs-erp-toggle float-none d-flex justify-content-center">
                                            <input type="checkbox" id="production-board-print-barcode" data-required-add="view-board-production" class="check" name="permissions[]" value="production-board-print-barcode"
                                            {{ in_array('production-board-print-barcode', $permissions) ? 'checked' : ''}}>
                                            <label for="production-board-print-barcode" class="checktoggle">checkbox</label>
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


