<option value="">Select {{$type == 'other' ? 'Material' : 'Board'}}</option>
@foreach($materials as $material)
    <option value="{{ $material->id }}">{{ $material->name }}</option>
@endforeach
