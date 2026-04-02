@extends('layouts.settings-layout')

@section('content')
    <div class="row">
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper d-flex justify-content-center">
                <div class="erp-add-em-step-wrapper bg-card flex-100">
                    <div class="erp-step-content-wrapper">
                        <form action="{{ route('settings.company.update') }}" id="companySettingsForm" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-4">
                                        <div class="erp-filter-item flex-100">
                                            <h4 class="offcanvas-title-erp">Company Information</h4>
                                        </div>

                                        <div class="erp-filter-item flex-48">
                                            <div class="input-block mb-0 erp-step-input-block">
                                                <label class="col-form-label">Company Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="company_name" value="{{ $company->company_name ?? '' }}" placeholder="Company Name" required>
                                                <span class="company_name_error ie-span"></span>
                                            </div>
                                        </div>

                                        <div class="erp-filter-item flex-48">
                                            <div class="input-block mb-0 erp-step-input-block">
                                                <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" name="email" value="{{ $company->email ?? '' }}" placeholder="Email Address" required>
                                                <span class="email_error ie-span"></span>
                                            </div>
                                        </div>

                                        <div class="erp-filter-item flex-48">
                                            <div class="input-block mb-0 erp-step-input-block">
                                                <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="phone" value="{{ $company->phone ?? '' }}" placeholder="Phone Number" required>
                                                <span class="phone_error ie-span"></span>
                                            </div>
                                        </div>

                                        <div class="erp-filter-item flex-48">
                                            <div class="input-block mb-0 erp-step-input-block">
                                                <label class="col-form-label">Address <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="address" rows="2" placeholder="Company Address" required>{{ $company->address ?? '' }}</textarea>
                                                <span class="address_error ie-span"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="erp-filter-item-wrapper filter-row d-flex flex-wrap align-items-center justify-content-between mb-3 flex-100">
                                        <div class="erp-filter-item flex-100 mt-4">
                                            <div class="erp-search-btn-wrap text-center">
                                                <button class="erp-search-btn text-center" type="submit">Save</button>
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
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $("#companySettingsForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();

                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    if (res.status === 200) {
                        showSuccessAlert('Success', res.message);
                    } else {
                        showErrorAlert('Error', res.message);
                    }
                }, 'show_input_error');
            });
        });
    </script>
@endsection

