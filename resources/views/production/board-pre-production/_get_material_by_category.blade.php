<option value="">Select Material</option>
@foreach($materials as $material)
    <option value="{{ $material->id }}">{{ $material->name }}</option>
@endforeach
