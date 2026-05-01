@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')
	<div class="main-container container-fluid">
		<div class="page-header d-flex flex-wrap align-items-center justify-content-between">
			<h1 class="page-title">Orders</h1>
			<div class="d-flex align-items-center gap-2 flex-wrap">
        
                @include('partials.search-bar', [
                    'colClass' => 'col-lg-12 col-12',
                    'fullWidthSearchClass' => 'col-lg-10 col-md-9 mb-md-0 mb-3 ml-auto',
                    'action' => route('orders.index'),
                    'placeholder' => 'Search orders...',
                ])
        
            </div>
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body p-0">
						<div class="table-responsive">
							<table class="table table-bordered text-nowrap mb-0">
								<thead>
									<tr>
										<th>Customer</th>
										<th>Email</th>
										<th>Total</th>
										<th>Status</th>
										<th>Date</th>
										<th style="width: 100px;"></th>
									</tr>
								</thead>
								<tbody>
									@forelse ($orders as $row)
										<tr>
											<td>{{ $row->name }}</td>
											<td>{{ $row->email }}</td>
											<td>${{ number_format($row->total_price, 2) }}</td>
											<td>
												<span class="badge border" style="color: black !important;">{{ ucfirst($row->status) }}</span>
											</td>
											<td>{{ $row->created_at->format('Y-m-d H:i') }}</td> 
											<td>
												<a class="btn btn-sm btn-info"
													href="{{ route('orders.show', $row) }}">View</a>
											</td>
										</tr>
									@empty
										<tr>
											<td colspan="7" class="text-center p-4 text-muted">No orders yet.
											</td>
										</tr>
									@endforelse
								</tbody>
							</table> 
							<div class="d-flex justify-content-center mt-3 mb-3">
                                {{ $orders->links('pagination::bootstrap-5') }}         
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
