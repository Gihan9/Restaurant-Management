@extends('layouts.app')

@section('content')
<h1>Edit Concession</h1>
<form action="{{ route('concessions.update', $concession->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Name</label>
        <input 
            type="text" 
            name="name" 
            class="form-control" 
            value="{{ $concession->name }}" 
            required>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea 
            name="description" 
            class="form-control">{{ $concession->description }}</textarea>
    </div>
    <div class="mb-3">
        <label>Price</label>
        <input 
            type="number" 
            name="price" 
            class="form-control" 
            value="{{ $concession->price }}" 
            step="0.01" 
            required>
    </div>
    <div class="mb-3">
        <label>Image</label>
        <input 
            type="file" 
            name="image" 
            class="form-control">
        <small>Leave empty to keep the current image.</small>
    </div>
    <button type="submit" class="btn btn-primary">Update Concession</button>
</form>
@endsection