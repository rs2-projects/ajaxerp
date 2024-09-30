<div class="row">
    <div class="col-lg-12 m-b-20">
        <ul class="list-unstyled">
            <li><h5 class="mb-0"><strong> {{ $salaryDetails->employee->full_name??'N/A' }}</strong></h5></li>
            <li><span> {{ $salaryDetails->employee->designation->name??'N/A' }} </span></li>
            <li>Employee ID: {{ $salaryDetails->employee->employee_id??'N/A' }}</li>
            <li>Joining Date: {{ getFormattedDate($salaryDetails->employee->joining_date, 'd M, Y') }}</li>
        </ul>
    </div>
</div>
    <div class="row">
        <div class="col-sm-6">
            <div>
                <h4 class="m-b-10"><strong>Earnings</strong></h4>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td><strong>Net Basic Salary</strong> <span class="float-right"><span class="currency-text">{{ getCurrencySymbol() }}</span> {{ formatNumber($salaryDetails->net_basic_salary) }} </span></td>
                    </tr>
                    <tr>
                        <td><strong>Total Over Time</strong> <span class="float-right"><span class="currency-text">{{ getCurrencySymbol() }}</span> {{ formatNumber($salaryDetails->normal_day_overtime_amount + $salaryDetails->special_day_overtime_amount) }} </span></td>
                    </tr>
                    <tr>
                        <td><strong>Total Bonus</strong> <span class="float-right"><span class="currency-text">{{ getCurrencySymbol() }}</span> {{ formatNumber($salaryDetails->total_bonus_amount) }} </span></td>
                    </tr>
                    @php($total_earning = $salaryDetails->net_basic_salary + $salaryDetails->normal_day_overtime_amount + $salaryDetails->special_day_overtime_amount + $salaryDetails->total_bonus_amount)
                    @if(count($salaryDetails->salaryDetailsAdditions) > 0)
                        @foreach($salaryDetails->salaryDetailsAdditions as $addition)
                            <tr>
                                <td><strong>{{ $addition->settingsSalaryTypeDetails->title??'N/A' }}</strong> <span class="float-right"><span class="currency-text">{{ getCurrencySymbol() }}</span>{{ formatNumber($addition->amount) }}</span></td>
                            </tr>
                            @php($total_earning += $addition->amount)
                        @endforeach
                    @endif
                    @if($salaryDetails->custom_add_amount > 0)
                        <tr>
                            <td><strong>{{ $salaryDetails->custom_add_amount_text??'N/A' }}</strong> <span class="float-right"><span class="currency-text">{{ getCurrencySymbol() }}</span> {{ showAmount($salaryDetails->custom_add_amount) }} </span></td>
                            @php($total_earning += $salaryDetails->custom_add_amount)
                        </tr>
                    @endif
                    <tr>
                        <td>
                            <strong>Total Earnings</strong>
                            <span class="float-right"><span class="currency-text">{{ getCurrencySymbol() }}</span>
                                <strong id="total_earning_text">{{ formatNumber($total_earning) }}</strong>
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-6">
            <div>
                <h4 class="m-b-10"><strong>Deductions</strong></h4>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td><strong>Absent</strong> <span class="float-right"><span class="currency-text">{{ getCurrencySymbol() }}</span> {{ formatNumber($salaryDetails->absent_day_amount) }} </span></td>
                    </tr>
                    <tr>
                        <td><strong>Late</strong> <span class="float-right"><span class="currency-text">{{ getCurrencySymbol() }}</span> {{ formatNumber($salaryDetails->late_amount) }} </span></td>
                    </tr>
                    <tr>
                        <td><strong>Early Departure</strong> <span class="float-right"><span class="currency-text">{{ getCurrencySymbol() }}</span> {{ formatNumber($salaryDetails->early_departure_amount) }} </span></td>
                    </tr>
                    <tr>
                        <td><strong>Extra Leave</strong> <span class="float-right"><span class="currency-text">{{ getCurrencySymbol() }}</span> {{ formatNumber($salaryDetails->extra_leave_amount) }} </span></td>
                    </tr>
                    @if($salaryDetails->settings_deduction_type_id != null)
                        <tr>
                            <td><strong>{{$salaryDetails->settingsDeductionType->title??'N/A'}}</strong> <span class="float-right"><span class="currency-text">{{ getCurrencySymbol() }}</span> {{ formatNumber($salaryDetails->deduction_amount) }} </span></td>
                        </tr>
                    @endif

                    @php($total_deduction = $salaryDetails->absent_day_amount+$salaryDetails->late_amount+$salaryDetails->early_departure_amount+$salaryDetails->extra_leave_amount+$salaryDetails->deduction_amount)
                    @if(count($salaryDetails->salaryDetailsDeductions) > 0)
                        @foreach($salaryDetails->salaryDetailsDeductions as $deduction)
                            <tr>
                                <td><strong>{{ $deduction->settingsSalaryTypeDetails->title??'N/A' }}</strong> <span class="float-right"><span class="currency-text">{{ getCurrencySymbol() }}</span>{{ formatNumber($deduction->amount) }}</span></td>
                            </tr>
                            @php($total_deduction += $deduction->amount)
                        @endforeach
                    @endif
                    @if($salaryDetails->custom_deduct_amount > 0)
                        <tr>
                            <td>
                                <strong>{{ $salaryDetails->custom_deduct_amount_text??'N/A' }}</strong>
                                <span class="float-right">
                                <span class="currency-text">{{ getCurrencySymbol() }}</span>
                                {{ formatNumber($salaryDetails->custom_deduct_amount) }}
                            </span>
                            </td>
                            @php($total_deduction += $salaryDetails->custom_deduct_amount)
                        </tr>
                    @endif
                    <tr>
                        <td><strong>Total Deductions</strong>
                            <span class="float-right">
                                <span class="currency-text">{{ getCurrencySymbol() }}</span>
                                <strong id="total_deduction_text"> {{ formatNumber($total_deduction) }} </strong>
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <input type="hidden" id="total_earning" value="{{ showAmount($total_earning) }}">
                <input type="hidden" id="total_deduction" value="{{ formatNumber($total_deduction) }}">
            </div>
        </div>
        <div class="col-sm-12">
            <p><strong>Net Salary: </strong><span class="currency-text">{{ getCurrencySymbol() }}</span><strong id="total_net_salary_text">{{ formatNumber($total_earning - $total_deduction) }}</strong> </p>
        </div>
    </div>
