<form action="{{ route('settings.geo-location.update',$item->id) }}" id="geoLocationFormEdit" method="post">
    @csrf
    <div class="erp-modal-body-content ">
        <div class="input-block erp-step-input-block mb-2">
            <label class="col-form-label">Title<span class="text-danger">*</span></label>
            <input type="text" class="form-control" value="{{ $item->title }}" required name="title">
            <span class="title_error ie-span"></span>
        </div>
        <div class="input-block erp-step-input-block mb-2">
            <label class="col-form-label">Description</label>
            <textarea class="form-control" name="description" rows="2"> {!! $item->description !!} </textarea>
        </div>
        <div class="input-block erp-step-input-block mb-2">
            <label class="col-form-label">Search Location</label>
            <input type="text" class="form-control" id="autocomplete">
            <span class="location_data_error ie-span"></span>
        </div>

        <input type="hidden" id="map_json_data_create"  name="location_data">
        <div id="map" style="width: 100%; height: 300px; margin: 0 auto;"></div>
        <div class="text-center mt-2">
            <button class="btn btn-danger" id="delete-button" type="button" onclick="deleteSelectedShape('#map_json_data_create')">Change Shape</button>
        </div>
        <div class="input-block erp-step-input-block mb-2 text-center">
            <div class="checkbox">
                <label class="col-form-label">
                    <input type="checkbox" name="is_default" value="1" {{ (\App\Models\SettingsGeoLocation::IS_DEFAULT_YES) ? 'checked' : '' }}> Make it Default
                </label>
            </div>
        </div>
        <div class="submit-section mt-2">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
        </div>
    </div>
</form>
