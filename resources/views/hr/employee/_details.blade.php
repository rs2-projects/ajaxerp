
    <div class="erp-employee-details-item bg-card flex-100">
        <div class="profile-view">
            <div class="profile-img-wrap">
                <div class="profile-img">
                    <a href="javascript:void(0)"><img src="{{ asset($employee->show_image) }}" alt="User Image"></a>
                </div>
            </div>
            <div class="profile-basic">
                <div class="row">
                    <div class="col-md-5">
                        <div class="profile-info-left">
                            <h3 class="user-name m-t-0 mb-0">{{ $employee->full_name??'N/A' }}</h3>
                            <h6 class="text-muted">{{ $employee->user_role->title??'N/A' }}</h6>
                            <small class="text-muted">{{ $employee->department->name??'N/A' }} / {{ $employee->designation->name?? 'N/A' }}</small>
                            <div class="staff-id">Employee ID : {{ $employee->employee_id??'N/A' }}</div>
                            <div class="small doj text-muted">Date of Join : {{ getFormattedDate($employee->joining_date,'d M, Y') }}</div>
                            <div class="staff-msg">
                                <a class="btn btn-custom" href="javascript:void(0);">Send Message</a>
                                @if(hasPermission('login-employye-account'))
                                    <a class="btn btn-custom emp-login-btn" href="{{ route('hr.employee.login', $employee->id) }}" style="background: linear-gradient(to right, #0054cf 0%, #8b89ff 100%)">Login</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <ul class="personal-info">
                            <li>
                                <div class="title">Phone:</div>
                                <div class="text"><a href="javascript:void(0)">{{ $employee->phone??'N/A' }}</a></div>
                            </li>
                            <li>
                                <div class="title">Email:</div>
                                <div class="text"><a href="">{{ $employee->email??'N/A' }}</a></div>
                            </li>
                            <li>
                                <div class="title">Birthday:</div>
                                <div class="text">{{ getFormattedDate($employee->date_of_birth,'d M, Y') }}</div>
                            </li>
                            <li>
                                <div class="title">Address:</div>
                                <div class="text"> {{ $employee->present_address??'N/A' }}</div>
                            </li>
                            <li>
                                <div class="title">Gender:</div>
                                <div class="text">{{ $employee->gender_text }}</div>
                            </li>
                            {{--<li>
                                <div class="title">Reports to:</div>
                                <div class="text">
                                    <div class="avatar-box">
                                        <div class="avatar avatar-xs">
                                            <img src="assets/img/profiles/man-1.png"
                                                 alt="User Image">
                                        </div>
                                    </div>
                                    <a href="profile.html">
                                        Jeffery Lalor
                                    </a>
                                </div>
                            </li>--}}
                        </ul>
                    </div>
                </div>
            </div>
            @if(hasPermission('manage-employees'))
                <div class="pro-edit">
                    <a data-bs-target="#profile_info_modal" data-bs-toggle="modal" class="edit-icon" href="javascript:void(0)"><i class="fa-solid fa-pencil"></i></a>
                </div>
            @endif
        </div>
    </div>

    <div class="erp-employee-details-item bg-card flex-100">
        <div class="erp-profile-tab-wrapper">
            <div class="erp-tab-item">
                <div class="nav nav-tabs erp-nav-tabs" id="nav-tab" role="tablist">

                    <button class="nav-link erp-nav-link active" id="erp-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-erp-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button>
                    {{-- <button class="nav-link erp-nav-link" id="erp-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-erp-bank" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Bank & Statutory <small>(Admin Only)</small>  </button> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="erp-employee-details-item  flex-100 p-0">

        <div class="tab-content erp-employee-tab pt-0" >
            <div class="tab-pane fade show active erp-employee-tab-pane"  id="nav-erp-profile" role="tabpanel" aria-labelledby="erp-profile-tab">
                <div class="erp-employee-details-tab-content-wrapper d-flex flex-wrap justify-content-center">
                    <div class="erp-em-details-tab-item flex-32 bg-card">
                        <div class="erp-profile-info-box">
                            <div class="erp-box-header mb-3">
                                <h4>Personal Information
                                @if(hasPermission('manage-employees'))
                                    <a href="javascript:void(0)" class="edit-icon" data-bs-toggle="modal"	data-bs-target="#personal_info_modal">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                @endif
                                </h4>
                            </div>

                            <ul class="personal-info erp-personal-info">
                                <li>
                                    <div class="title">NID No :</div>
                                    <div class="text">{{ $employee->nid_no?? 'N/A' }}</div>
                                </li>
                                <li>
                                    <div class="title">Passport No :</div>
                                    <div class="text">{{ $employee->passport_no }}</div>
                                </li>
                                <li>
                                    <div class="title">Passport Exp. Date :</div>
                                    <div class="text">{{ getFormattedDate($employee->passport_expiry_date,'d M, Y') }}</div>
                                </li>
                                <li>
                                    <div class="title">Date of Birth :</div>
                                    <div class="text">{{ getFormattedDate($employee->date_of_birth, 'd M, Y') }}</div>
                                </li>

                                {{--<li>
                                    <div class="title">Nationality :</div>
                                    <div class="text">Bangladesh</div>
                                </li>--}}
                                <li>
                                    <div class="title">Religion :</div>
                                    <div class="text">{{ $employee->religion??'N/A' }}</div>
                                </li>
                                <li>
                                    <div class="title">Marital status :</div>
                                    <div class="text">{{ $employee->marital_status_text }}</div>
                                </li>
                                <li>
                                    <div class="title">Marriage Date :</div>
                                    <div class="text">{{ getFormattedDate($employee->marriage_date,'d M, Y') }}</div>
                                </li>


                            </ul>

                        </div>
                    </div>
                    <div class="erp-em-details-tab-item flex-32 bg-card">
                        <div class="erp-profile-info-box">
                            <div class="erp-box-header mb-3">
                                <h4>Bank Information
                                @if(hasPermission('manage-employees'))
                                    <a href="#" class="edit-icon" data-bs-toggle="modal"	data-bs-target="#bank_info_modal">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                @endif
                                </h4>
                            </div>
                            @if(count($employee->userBankInfo) > 0)
                                @foreach($employee->userBankInfo as $key=> $bankInfo)
                                    <ul class="personal-info erp-personal-info">
                                        <li>
                                            <div class="title">Bank name :</div>
                                            <div class="text">{{ $bankInfo->bank_name??'N/A' }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Account Name :</div>
                                            <div class="text">{{ $bankInfo->account_name??'N/A' }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Bank Account No :</div>
                                            <div class="text">{{ $bankInfo->account_number??'N/A' }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Routing Number: :</div>
                                            <div class="text">{{ $bankInfo->routing_number??'N/A' }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Swift Code :</div>
                                            <div class="text">{{ $bankInfo->swift_code??'N/A' }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Note :</div>
                                            <div class="text">{{ $bankInfo->note??'N/A' }}</div>
                                        </li>
                                    </ul>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="erp-em-details-tab-item flex-32 bg-card">
                        <div class="erp-profile-info-box">
                            <div class="erp-box-header mb-3">
                                <h4>Eduction Information
                                    @if(hasPermission('manage-employees'))
                                        <a href="javascript:void(0)" class="edit-icon" data-bs-toggle="modal"	data-bs-target="#education_info_modal">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                    @endif
                                </h4>
                            </div>
                            <div class="experience-box erp-experience-box">
                                <ul class="experience-list">
                                    @if(count($employee->userEducationInfo))
                                        @foreach($employee->userEducationInfo as $key=>$education)
                                            <li>
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="javascript:void(0);" class="name">{{ $education->institute_name??'N/A' }}</a>
                                                        <div>{{ $education->degree??'' }} {{ $education->subject??'' }}</div>
                                                        <span class="time">{{ getFormattedDate($education->start_date,'d M, Y') }} - {{ ($education->end_date) ? getFormattedDate($education->end_date,'d M, Y') : 'Present' }}</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="erp-em-details-tab-item flex-32 bg-card">
                        <div class="erp-profile-info-box">
                            <div class="erp-box-header mb-3">
                                <h4>Emergency Contact
                                    @if(hasPermission('manage-employees'))
                                        <a href="javascript:void(0)" class="edit-icon" data-bs-toggle="modal"	data-bs-target="#emergency_contact_modal">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                    @endif
                                </h4>
                            </div>
                            <div class="experience-box erp-experience-box">
                                <ul class="experience-list">
                                    @if(count($employee->userEmergencyContacts) >0)
                                        @foreach($employee->userEmergencyContacts as $key=>$contact)
                                            <li>
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <div class="erp-emergency-relation">
                                                            <h4><span class="me-2">Name:</span>{{$contact->name}}</h4>
                                                            <p class="rel-email"><span class="me-2">Email:</span>{{ $contact->email }}</p>
                                                            <p class="rel-phone"><span class="me-2">Phone:</span>{{ $contact->phone }}</p>
                                                            <p class="rel-relation"><span class="me-2">Relationship:</span> {{ $contact->relation }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="erp-em-details-tab-item flex-32 bg-card">
                        <div class="erp-profile-info-box">
                            <div class="erp-box-header mb-3">
                                <h4>Experience Information
                                    @if(hasPermission('manage-employees'))
                                        <a href="#" class="edit-icon" data-bs-toggle="modal"	data-bs-target="#experience_info_modal">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                    @endif
                                </h4>
                            </div>
                            <div class="experience-box erp-experience-box">
                                <ul class="experience-list">
                                    @if(count($employee->userExperienceInfo) > 0)
                                        @foreach($employee->userExperienceInfo as $key=> $experience)
                                            <li>
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="javascript:void(0);" class="name">{{ $experience->company_name??'N/A' }}</a>
                                                        <div>{{ $experience->designation??'N/a' }}</div>
                                                        <span class="time">{{ getFormattedDate($experience->start_date, 'd M, Y') }} - {{ ($experience->end_date) ? getFormattedDate($experience->end_date, 'd M, Y') : 'Present' }}</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade  erp-employee-tab-pane" id="nav-erp-bank" role="tabpanel" aria-labelledby="erp-bank-tab">
                <div class="erp-employee-details-tab-content-wrapper d-flex flex-wrap ">
                    <div class="erp-em-details-tab-item flex-48 bg-card">
                        <div class="erp-profile-info-box">
                            <div class="erp-box-header mb-3">
                                @if(hasPermission('manage-employees'))
                                    <a href="#" class="edit-icon" data-bs-toggle="modal"	data-bs-target="#personal_info_modal">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                @endif
                                <div class="input-block erp-step-input-block mb-0 two ">
                                    <h4 class="col-form-label pt-0">Select Salary type <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></h4>
                                    <select class="select select-step" >
                                        <option>Basic Salary (12000)</option>
                                        <option>Basic Salary (15000)</option>
                                        <option>Basic Salary (18000)</option>
                                        <option>Basic Salary (20000)</option>
                                        <option>Basic Salary (25000)</option>
                                        <option>Basic Salary (30000)</option>
                                        <option>Basic Salary (35000)</option>


                                    </select>
                                </div>

                            </div>

                            <div class="big-table pt-1">
                                <div class="de-table-wrapper employe-bank">
                                    <div class="table-responsive">
                                        <table class="table mb-0 erp-table">

                                            <tbody class="erp-tbody">
                                            <tr class="erp-tbody-tr">
                                                <td class="erp-tbody-td">
                                                    <h4 class="d-table-title"><strong>Basic Salary</strong></h4>
                                                </td>
                                                <td class="erp-tbody-td">
                                                    <h4 class="text-center d-table-title">: </h4>
                                                </td>
                                                <td class="erp-tbody-td text-center">
                                                    <h4 class="text-center d-table-title">16000</h4>
                                                </td>
                                            </tr>
                                            <tr class="erp-tbody-tr">
                                                <td class="erp-tbody-td">
                                                    <h4 class="d-table-title"><strong>TA DA</strong> (Travel and Dearness Allowance)</h4>
                                                </td>
                                                <td class="erp-tbody-td">
                                                    <h4 class="text-center d-table-title">: </h4>
                                                </td>
                                                <td class="erp-tbody-td text-center">
                                                    <h4 class="text-center d-table-title">0 % - 0</h4>
                                                </td>
                                            </tr>
                                            <tr class="erp-tbody-tr">
                                                <td class="erp-tbody-td">
                                                    <h4 class="d-table-title"><strong>MA </strong> (Medical Allowance)</h4>
                                                </td>
                                                <td class="erp-tbody-td">
                                                    <h4 class="text-center d-table-title">: </h4>
                                                </td>
                                                <td class="erp-tbody-td text-center">
                                                    <h4 class="text-center d-table-title">0 % - 0</h4>
                                                </td>
                                            </tr>
                                            <tr class="erp-tbody-tr">
                                                <td class="erp-tbody-td">
                                                    <h4 class="d-table-title"><strong>HRA</strong> (House Rent Allowance)</h4>
                                                </td>
                                                <td class="erp-tbody-td">
                                                    <h4 class="text-center d-table-title">: </h4>
                                                </td>
                                                <td class="erp-tbody-td text-center">
                                                    <h4 class="text-center d-table-title">0 % - 0</h4>
                                                </td>
                                            </tr>
                                            <tr class="erp-tbody-tr">
                                                <td class="erp-tbody-td">
                                                    <h4 class="d-table-title"><strong>Provident Fund </strong> (Employee Share)</h4>
                                                </td>
                                                <td class="erp-tbody-td">
                                                    <h4 class="text-center d-table-title">: </h4>
                                                </td>
                                                <td class="erp-tbody-td text-center">
                                                    <h4 class="text-center d-table-title">0 % - 0</h4>
                                                </td>
                                            </tr>
                                            <tr class="erp-tbody-tr">
                                                <td class="erp-tbody-td">
                                                    <h4 class="d-table-title"><strong>Provident Fund </strong> (Company Share)</h4>
                                                </td>
                                                <td class="erp-tbody-td">
                                                    <h4 class="text-center d-table-title">: </h4>
                                                </td>
                                                <td class="erp-tbody-td text-center">
                                                    <h4 class="text-center d-table-title">0 % - 0</h4>
                                                </td>
                                            </tr>
                                            <tr class="erp-tbody-tr">
                                                <td class="erp-tbody-td">
                                                    <h4 class="d-table-title"><strong>TDS </strong>(Tax Deducted at Source)</h4>
                                                </td>
                                                <td class="erp-tbody-td">
                                                    <h4 class="text-center d-table-title">: </h4>
                                                </td>
                                                <td class="erp-tbody-td text-center">
                                                    <h4 class="text-center d-table-title">0 % - 0</h4>
                                                </td>
                                            </tr>
                                            <tr class="erp-tbody-tr">
                                                <td class="erp-tbody-td">
                                                    <h4 class="d-table-title"><strong>Total Gross Salary</strong></h4>
                                                </td>
                                                <td class="erp-tbody-td">
                                                    <h4 class="text-center d-table-title">: </h4>
                                                </td>
                                                <td class="erp-tbody-td text-center">
                                                    <h4 class="text-center d-table-title">28000</h4>
                                                </td>
                                            </tr>




                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="erp-em-details-tab-item flex-48 bg-card">
                        <div class="erp-profile-info-box">
                            <div class="erp-box-header mb-3">
                                @if(hasPermission('manage-employees'))
                                    <a href="#" class="edit-icon" data-bs-toggle="modal"	data-bs-target="#personal_info_modal">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                @endif
                                <div class="input-block erp-step-input-block mb-0 two ">
                                    <h4 class="col-form-label pt-0">Employee Overtime <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></h4>
                                    <select class="select select-step" >
                                        <option>Over Time (OT1)</option>
                                        <option>Over Time (OT2)</option>
                                        <option>Over Time (OT3)</option>
                                        <option>Over Time (OT4)</option>
                                        <option>Over Time (OT5)</option>



                                    </select>
                                </div>

                            </div>

                            <ul class="personal-info erp-personal-info">
                                <li>
                                    <div class="title">Start Date :</div>
                                    <div class="text">28 September, 2023</div>
                                </li>
                                <li>
                                    <div class="title">End Date :</div>
                                    <div class="text">28 October, 2023</div>
                                </li>
                                <li>
                                    <div class="title">Interval Time :</div>
                                    <div class="text">30 Min</div>
                                </li>
                                <li>
                                    <div class="title">Salary Type :</div>
                                    <div class="text">Basic Salary</div>
                                </li>

                                <li>
                                    <div class="title">Hourly Rate :</div>
                                    <div class="text">100% of Basic Salary</div>
                                </li>
                            </ul>


                        </div>
                    </div>
                    <div class="erp-em-details-tab-item flex-32 bg-card">
                        <div class="erp-profile-info-box">
                            <div class="erp-box-header mb-3">
                                @if(hasPermission('manage-employees'))
                                    <a href="#" class="edit-icon" data-bs-toggle="modal"	data-bs-target="#personal_info_modal">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                @endif
                                <div class="input-block erp-step-input-block mb-0 two ">
                                    <h4 class="col-form-label pt-0">Employee Overtime <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></h4>
                                    <select class="select select-step" >
                                        <option>Over Time (OT1)</option>
                                        <option>Over Time (OT2)</option>
                                        <option>Over Time (OT3)</option>
                                        <option>Over Time (OT4)</option>
                                        <option>Over Time (OT5)</option>



                                    </select>
                                </div>

                            </div>

                            <ul class="personal-info erp-personal-info">
                                <li>
                                    <div class="title">Start Date :</div>
                                    <div class="text">28 September, 2023</div>
                                </li>
                                <li>
                                    <div class="title">End Date :</div>
                                    <div class="text">28 October, 2023</div>
                                </li>
                                <li>
                                    <div class="title">Interval Time :</div>
                                    <div class="text">30 Min</div>
                                </li>
                                <li>
                                    <div class="title">Salary Type :</div>
                                    <div class="text">Basic Salary</div>
                                </li>

                                <li>
                                    <div class="title">Hourly Rate :</div>
                                    <div class="text">100% of Basic Salary</div>
                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="erp-em-details-tab-item flex-32 bg-card">
                        <div class="erp-profile-info-box">
                            <div class="erp-box-header mb-3">
                                @if(hasPermission('manage-employees'))
                                    <a href="javascript:void(0)" class="edit-icon" data-bs-toggle="modal"	data-bs-target="#personal_info_modal">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                @endif
                                <div class="input-block erp-step-input-block mb-0 two ">
                                    <h4 class="col-form-label pt-0">Employee Absent Penalty <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></h4>
                                    <select class="select select-step" >
                                        <option>Absent Penalty (AP1)</option>
                                        <option>Absent Penalty (AP2)</option>
                                        <option>Absent Penalty (AP3)</option>
                                        <option>Absent Penalty (AP4)</option>
                                        <option>Absent Penalty (AP5)</option>



                                    </select>
                                </div>

                            </div>

                            <ul class="personal-info erp-personal-info">
                                <li>
                                    <div class="title">No Deduct Days :</div>
                                    <div class="text">5 Days</div>
                                </li>
                                <li>
                                    <div class="title">Deduct Day (unit) :</div>
                                    <div class="text">7 Days</div>
                                </li>
                                <li>
                                    <div class="title">Deduct Type :</div>
                                    <div class="text">Gross Salary</div>
                                </li>
                                <li>
                                    <div class="title">Deduct Value (%) :</div>
                                    <div class="text">100% of Gross Salary</div>
                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="erp-em-details-tab-item flex-32 bg-card">
                        <div class="erp-profile-info-box">
                            <div class="erp-box-header mb-3">
                                @if(hasPermission('manage-employees'))
                                    <a href="#" class="edit-icon" data-bs-toggle="modal"	data-bs-target="#personal_info_modal">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                @endif
                                <div class="input-block erp-step-input-block mb-0 two ">
                                    <h4 class="col-form-label pt-0">Employee Late Penalty <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Point Four Epos Solutions"><i class="fa-duotone fa-exclamation"></i></span></h4>
                                    <select class="select select-step" >
                                        <option>Late Penalty (LP1)</option>
                                        <option>Late Penalty (LP2)</option>
                                        <option>Late Penalty (LP3)</option>
                                        <option>Late Penalty (LP4)</option>
                                        <option>Late Penalty (Lp5)</option>



                                    </select>
                                </div>

                            </div>

                            <ul class="personal-info erp-personal-info">
                                <li>
                                    <div class="title">Late Count Time  :</div>
                                    <div class="text">9:20 AM</div>
                                </li>
                                <li>
                                    <div class="title">No Deduct Days :</div>
                                    <div class="text">4 Days</div>
                                </li>
                                <li>
                                    <div class="title">Deduct Day (unit) :</div>
                                    <div class="text">& Days</div>
                                </li>
                                <li>
                                    <div class="title">Deduct Type :</div>
                                    <div class="text">Basic Salary</div>
                                </li>

                                <li>
                                    <div class="title">Deduct Value (%):</div>
                                    <div class="text">100% of Basic Salary</div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
