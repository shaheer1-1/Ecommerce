@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
	<div class="main-container container-fluid">
        <div class="page-header d-flex flex-wrap align-items-center justify-content-between">

            <div>
                <h1 class="page-title">Categories</h1>
            </div>
        
            <div class="d-flex align-items-center gap-2 flex-wrap">
        
                @include('partials.search-bar', [
                    'colClass' => 'col-lg-8 col-12',
                    'fullWidthSearchClass' => 'col-lg-10 col-md-9 mb-md-0 mb-3 ml-auto',
                    'action' => route('admin.categories.index'),
                    'placeholder' => 'Search categories...',
                ])
        
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    Add category
                </a>
        
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
										<th>Image</th>
										<th>Name</th>
										<th style="width: 160px;">Actions</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($categories as $row)
										<tr>
											<td>
												@if ($row->image)
													<img src="{{ asset('storage/' . $row->image) }}" alt="" width="60" class="rounded">
												@else
													<span class="text-muted small">—</span>
												@endif
											</td>
											<td>{{ $row->name }}</td>
											<td>
												<a class="btn btn-sm btn-info"
													href="{{ route('admin.categories.edit', $row) }}">Edit</a>
												<button type="button" class="btn btn-sm btn-danger btn-swal-delete"
													data-form-id="delete-form-category-{{ $row->id }}">Delete</button>
												<form id="delete-form-category-{{ $row->id }}"
													class="d-none" method="POST"
													action="{{ route('admin.categories.destroy', $row) }}">
													@csrf
													@method('DELETE')
												</form>
											</td>
										</tr>
									@empty
										<tr>
											<td colspan="4" class="text-center p-4 text-muted">No categories yet. Add
												one to get started.</td>
										</tr>
									@endforelse
								</tbody>
							</table>
                            <div class="d-flex justify-content-center mt-3 mb-3">
                                {{ $categories->links('pagination::bootstrap-5') }}                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('pageSpecificJS')
	<script>
		document.querySelectorAll('.btn-swal-delete').forEach(function(btn) {
			btn.addEventListener('click', function() {
				var formId = this.getAttribute('data-form-id');
				Swal.fire({
					title: 'Are you sure ?',
					text: "",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#d33',
					cancelButtonColor: '#6c757d',
					confirmButtonText: 'Yes, delete'
				}).then(function(result) {
					if (result.isConfirmed) {
						document.getElementById(formId).submit();
					}
				});
			});
		});
	</script>
@endsection
