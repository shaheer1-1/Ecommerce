@extends('admin.layouts.app')

@section('title', 'Add category')

@section('content')
	<div class="main-container container-fluid">
		<div class="page-header">
			<h1 class="page-title">Add category</h1>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<div class="card">
					<div class="card-body">
						<form method="POST" action="{{ route('admin.categories.store') }}"
							enctype="multipart/form-data">
							@csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
								<input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
									required>
                                </div>
                                <div class="col-md-6">
                                    <label for="image" class="form-label">Image (jpg, png, jpeg)</label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                </div>
                            </div>
							<button type="submit" class="btn btn-primary">Save</button>
							<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
