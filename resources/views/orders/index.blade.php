@extends('layouts.app')

@section('content')
<h1>Orders</h1>
<a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">Create Order</a>
<table id="orders-table" class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Concessions</th>
            <th>Send Time</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <!-- Data will be dynamically injected here -->
    </tbody>
</table>
@endsection