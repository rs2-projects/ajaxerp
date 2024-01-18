    <option value="">Select Salary Set</option>
@foreach($settingsSalarySets as $item)
    <option value="{{ $item->id }}">{{ $item->name??'N/A' }}</option>
@endforeach
