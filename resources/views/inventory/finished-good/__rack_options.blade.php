
@foreach($racks as $rack)
    <option value="{{ $rack->id }}">{{ $rack->name }}</option>
@endforeach
