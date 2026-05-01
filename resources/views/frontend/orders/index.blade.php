@extends('frontend.layouts.app')

@section('title', 'My orders')

@section('main-content')
	<div class="section" style="padding: 40px 0;">
		<div class="container">
			<h2>My orders</h2>
			@if (session('success'))
				<div class="alert alert-success">{{ session('success') }}</div>
			@endif
			@if ($orders->isEmpty())
				<p class="text-muted">You have not placed any orders yet.</p>
				<a href="{{ route('home') }}" class="btn btn-default border">Shop</a>
			@else
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Date</th>
								<th>Total</th>
								<th>Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($orders as $row)
								<tr>
									<td>{{ $row->created_at->format('M d, Y H:i') }}</td>
									<td>${{ number_format($row->total_price, 2) }}</td>
									<td>{{ ucfirst($row->status) }}</td>
									<td><a href="{{ route('orders.show', $row) }}">View</a></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</div>
	</div>
@endsection
