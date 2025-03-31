@extends('layouts.app')

@section('content')
<h1>Create Order</h1>
<form method="POST" action="{{ route('orders.store') }}">
    @csrf
    <div class="mb-3">
        <label>Select Concessions</label>
        <div id="concessions">
            @foreach ($concessions as $concession)
                <div class="form-check">
                    <input 
                        type="checkbox" 
                        name="selected_concessions[{{ $concession->id }}][id]" 
                        value="{{ $concession->id }}" 
                        class="form-check-input">
                    <label class="form-check-label">{{ $concession->name }} - ${{ $concession->price }}</label>
                    <input 
                        type="number" 
                        name="selected_concessions[{{ $concession->id }}][quantity]" 
                        class="form-control mt-2" 
                        placeholder="Quantity" 
                        min="1">
                </div>
            @endforeach
        </div>
    </div>

    <div class="mb-3">
        <label>Send to Kitchen Time</label>
        <input type="datetime-local" name="send_to_kitchen_time" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Create Order</button>
</form>
@endsection