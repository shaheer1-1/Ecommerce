@extends('frontend.layouts.app')

@section('title', 'Order #' . $order->id)

@section('main-content')
	<div class="section" style="padding: 40px 0;">
		<div class="container">
			<h2 class="mt-3">Order #{{ $order->id }}</h2>
			<p class="text-muted">Placed on {{ $order->created_at->format('M d, Y H:i') }}</p>
			<p><strong>Status:</strong> <span
					class="badge border">{{ ucfirst($order->status) }}</span>
			</p>

			<h4>Shipping / contact</h4>
			<p>
				{{ $order->name }}<br>
				{{ $order->email }}<br>
				{{ $order->phone }}<br>
                    {!! nl2br(e($order->address->shipping_address . ', ' . $order->address->shipping_city . ', ' . $order->address->shipping_country)) !!}			</p>

			<h4>Items</h4>
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Product</th>
							<th>Unit price</th>
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
@endsection
