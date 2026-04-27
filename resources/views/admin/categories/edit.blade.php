@extends('admin.layouts.app')

@section('title', 'Edit category')

@section('content')
	<div class="main-container container-fluid">
		<div class="page-header">
			<h1 class="page-title">Edit category</h1>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<div class="card">
					<div class="card-body">
						<form method="POST" action="{{ route('admin.categories.update', $category) }}"
							enctype="multipart/form-data">
							@csrf
							@method('PUT')
							<div class="mb-3">
								<label for="name" class="form-label">Name <span class="text-danger">*</span></label>
								<input type="text" name="name" id="name" class="form-control"
									value="{{ old('name', $category->name) }}" required>
							</div>
							@if ($category->image)
								<div class="mb-3">
									<p class="form-label mb-1">Current image</p>
									<img src="{{ asset('storage/' . $category->image) }}" alt="" width="120" class="rounded border">
								</div>
							@endif
							<div class="mb-3">
								<label for="image" class="form-label">New image (jpg, png, jpeg) — leave empty to
									keep</label>
								<input type="file" name="image" id="image" class="form-control" accept="image/*">
							</div>
							<button type="submit" class="btn btn-primary">Update</button>
							<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
