@extends('layouts.app')

@section('content')
<h1>Concessions</h1>
<a href="{{ route('concessions.create') }}" class="btn btn-primary mb-3">Add Concession</a>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($concessions as $concession)
        <tr>
            <td>{{ $concession->name }}</td>
            <td>{{ $concession->description }}</td>
            <td>{{ $concession->price }}</td>
            <td><img src="{{ asset('storage/' . $concession->image) }}" alt="{{ $concession->name }}" width="50"></td>
            <td>
                <a href="{{ route('concessions.edit', $concession->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('concessions.destroy', $concession->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection