<option value="">Select Designation</option>
@foreach($designations as $designation)
    <option value="{{ $designation->id }}">{{ $designation->name }}</option>
@endforeach
