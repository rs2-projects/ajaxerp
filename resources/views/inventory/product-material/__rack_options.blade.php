
@foreach($racks as $rack)
    <option value="{{ $rack->id }}">{{ $rack->section->name.' -> '.$rack->name }}</option>
@endforeach
