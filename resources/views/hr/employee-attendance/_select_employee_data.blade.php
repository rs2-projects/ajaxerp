@foreach($employees as $employee)
    <option value="{{ $employee['id'] }}" {{ ($employee['has_attendance'] == true) ? 'disabled' : '' }}>{{ $employee['name'] }}</option>
@endforeach

