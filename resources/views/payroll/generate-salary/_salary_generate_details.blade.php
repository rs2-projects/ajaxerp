<div class="row salary-set-show-data">
    <div class="col-md-3">
        <div class="form-group">
            <label>Salary Type : <strong>{{ $salary_type }}</strong></label>

        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Month : <strong>{{ $month_name }}</strong></label>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Year : <strong>{{ $year }}</strong></label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Period Type : <strong>{{ $period_type }}</strong></label>
        </div>
    </div>
    <div class="col-md-2">
        <div class="back-to-salary-generate-edit">
            <button type="button" class="btn btn-small-edit" onclick="backToEdit()" title="Edit Info">
                <i class="fa fa-pen"></i>
            </button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="input-block erp-step-input-block ">
            <label class="col-form-label">Salary Set <span class="text-danger">*</span></label>
            <select class="select salary-set-select"  name="salary_set[]" required multiple>
                @foreach($settingsSalarySets as $item)
                    <option value="{{ $item->id }}">{{ $item->name??'N/A' }}</option>
                @endforeach
            </select>
            <span class="salary_set_error ie-span"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="input-block erp-step-input-block ">
            <label class="col-form-label">Salary Bonuses</label>
            <select class="select salary-set-select" name="bonus_types[]" multiple>
                @foreach($bonusTypes as $bonusType)
                    <option value="{{ $bonusType->id }}">{{ $bonusType->title }}</option>
                @endforeach
            </select>
            <span class="bonus_types_error ie-span"></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-block erp-step-input-block ">
            <label class="col-form-label">Salary Deduction Type</label>
            <select class="select salary-set-select" name="deduction_type">
                <option value="">Select Deduction Type</option>
                @foreach($deductionTypes as $deductionType)
                    <option value="{{ $deductionType->id }}">{{ $deductionType->title }}</option>
                @endforeach
            </select>
            <span class="deduction_type_error ie-span"></span>
        </div>
    </div>
</div>
<div class="submit-section mt-2">
    <button class="btn btn-primary submit-btn" type="submit">Submit</button>
</div>
