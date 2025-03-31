@extends('layouts.app')

@section('content')
<h1>Kitchen Orders</h1>
<table id="kitchen-orders-table" class="table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Concessions</th>
            <th>Total Cost</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <!-- Data will be dynamically injected here -->
    </tbody>
</table>
@endsection