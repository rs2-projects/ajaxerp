<option value="">Select Leave Type</option>
@foreach($settings_leave_types as $settings_leave_type)
    <option value="{{ $settings_leave_type->id }}">{{ $settings_leave_type->title }} - Annual {{ $settings_leave_type->annual_leave_days }} Days</option>
@endforeach
