@extends('layouts.app')

@section('content')
<h1>Add Concession</h1>
<form method="POST" action="{{ route('concessions.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" id="name" required>
    </div>
    <div class="mb-3">
        <label for="description">Description</label>
        <textarea name="description" class="form-control" id="description"></textarea>
    </div>
    <div class="mb-3">
        <label for="price">Price</label>
        <input type="number" name="price" class="form-control" id="price" step="0.01" required>
    </div>
    <div class="mb-3">
        <label for="image">Image</label>
        <input type="file" name="image" class="form-control" id="image" required>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection