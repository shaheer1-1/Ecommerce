@extends('admin.layouts.app')

@section('title', 'Edit product')

@section('content')
	<div class="main-container container-fluid">
		<div class="page-header">
			<h1 class="page-title">Edit product</h1>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<div class="card">
					<div class="card-body">
						<form method="POST" action="{{ route('admin.products.update', $product) }}"
							enctype="multipart/form-data">
							@csrf
							@method('PUT')
							<div class="mb-3">
								<label for="category_id" class="form-label">Category <span
										class="text-danger">*</span></label>
								<select name="category_id" id="category_id" class="form-control" required>
									@foreach ($categories as $cat)
										<option value="{{ $cat->id }}"
											@selected(old('category_id', $product->category_id) == $cat->id)>
											{{ $cat->name }}
										</option>
									@endforeach
								</select>
							</div>
							<div class="mb-3">
								<label for="name" class="form-label">Name <span class="text-danger">*</span></label>
								<input type="text" name="name" id="name" class="form-control"
									value="{{ old('name', $product->name) }}" required>
							</div>
							<div class="mb-3">
								<label for="description" class="form-label">Description</label>
								<textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
							</div>
							<div class="mb-3">
								<label for="price" class="form-label">Price <span
										class="text-danger">*</span></label>
								<input type="number" name="price" id="price" class="form-control" step="0.01"
									min="0" value="{{ old('price', $product->price) }}" required>
							</div>
							<div class="mb-3">
								<label for="stock" class="form-label">Stock <span
										class="text-danger">*</span></label>
								<input type="number" name="stock" id="stock" class="form-control" step="1"
									min="0" value="{{ old('stock', $product->stock) }}" required>
							</div>
							@if ($product->image)
								<div class="mb-3">
									<p class="form-label mb-1">Current image</p>
									<img src="{{ route('admin.document.download', ['type' => 'product-image', 'id' => $product->id, 'action' => 'view']) }}" alt="" width="120" class="rounded border">
								</div>
							@endif
							<div class="mb-3">
								<label for="image" class="form-label">New image (jpg, png, jpeg) </label>
								<input type="file" name="image" id="image" class="form-control" accept="image/*">
							</div>
							<button type="submit" class="btn btn-primary">Update</button>
							<a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
