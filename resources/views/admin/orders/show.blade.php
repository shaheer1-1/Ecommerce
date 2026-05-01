@extends('admin.layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
	<div class="main-container container-fluid">
		<div class="page-header d-flex flex-wrap align-items-center justify-content-between">
			<h1 class="page-title">Order #{{ $order->id }}</h1>
			<a class="btn btn-secondary" href="{{ route('orders.index') }}">All orders</a>
		</div>

		@if (session('success'))
			<div class="alert alert-success mb-3">{{ session('success') }}</div>
		@endif

		<div class="row">
			<div class="col-lg-8">
				<div class="card mb-3">
					<div class="card-header">Customer &amp; status</div>
					<div class="card-body">
						<p><strong>Name:</strong> {{ $order->name }}</p>
						<p><strong>Email:</strong> {{ $order->email }}</p>
						<p><strong>Phone:</strong> {{ $order->phone }}</p>
						<p><strong>Address:</strong><br>{!! nl2br(e($order->address->shipping_address . ', ' . $order->address->shipping_city . ', ' . $order->address->shipping_country)) !!}</p>
					</div>
				</div>
				<div class="card">
					<div class="card-header">Line items</div>
					<div class="card-body p-0">
						<div class="table-responsive">
							<table class="table table-bordered mb-0">
								<thead>
									<tr>
										<th>Product (snapshot)</th>
										<th>Unit</th>
										<th>Qty</th>
										<th>Subtotal</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($order->items as $row)
										<tr>
											<td>{{ $row->product_name }}</td>
											<td>${{ number_format($row->price, 2) }}</td>
											<td>{{ $row->quantity }}</td>
											<td>${{ number_format($row->subtotal, 2) }}</td>
										</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<th colspan="3" class="text-right">Order total</th>
										<th>${{ number_format($order->total_price, 2) }}</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card">
					<div class="card-header">Update status</div>
					<div class="card-body">
						<form method="POST" action="">
							@csrf
							@method('PUT')
							<div class="mb-3">
								<label class="form-label">Status</label>
								<select name="status" class="form-control" required>
									@foreach (config('orderStatus') as $s)
										<option value="{{ $s }}" @selected($order->status === $s)>
											{{ $s }}
										</option>
									@endforeach
								</select>
							</div>
							<button class="btn btn-primary" type="submit">Save status</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
