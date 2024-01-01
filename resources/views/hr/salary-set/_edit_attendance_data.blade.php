<form action="{{ route('hr.salary-set.attendance-set.update', $item->id) }}" id="attendanceSetUpdateForm" method="post">
    @csrf
    <div class="erp-modal-body-content">
        <section class="erp-em-general-info">
            <div class="erp-em-reg-step-wrapper d-flex flex-wrap flex-100">
                <div class="erp-em-reg-step-item flex-40">
                    <div class="input-block erp-step-input-block ">
                        <div class="checkbox">
                            <label class="col-form-label"><input type="checkbox" {{ ($item->attendance_type_fingerprint_device == 1) ? 'checked' : '' }} value="1" name="attendance_type_fingerprint_device" class="me-1"> Finger Print Device  </label>
                        </div>
                    </div>
                </div>
                <div class="erp-em-reg-step-item flex-40">
                    <div class="input-block erp-step-input-block ">
                        <label class="col-form-label">
                            <input type="radio" name="attendance_type_location" {{ ($item->attendance_type_location == 1) ? 'checked' : '' }} onclick="locationType(this)" value="1">
                            In Geo
                        </label>

                        <label class="col-form-label">
                            <input type="radio" name="attendance_type_location" {{ ($item->attendance_type_location == 2) ? 'checked' : '' }} onclick="locationType(this)" value="2">
                            Any Location
                        </label>
                    </div>
                </div>

                <div class="erp-em-reg-step-item flex-100 location-hide-show" style="{{ ($item->attendance_type_location != 1) ? 'display: none' : '' }} ">
                    <div class="input-block erp-step-input-block ">
                        <label class="col-form-label">Location: <span class="text-danger">*</span></label>
                        <select class="select select-step" multiple name="settings_geo_location_id[]" id="settings_geo_location_id">
                            @foreach($settingsGeoLocations as $settingsGeoLocation)
                                <option value="{{ $settingsGeoLocation->id }}" {{ in_array($settingsGeoLocation->id, $selected_geo_location_ids) ? 'selected' : '' }}>{{ $settingsGeoLocation->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </section>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Submit</button>
        </div>
    </div>
</form>
