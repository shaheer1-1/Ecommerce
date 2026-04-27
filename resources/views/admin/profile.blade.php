@extends('admin.layouts.app')

@section('title', 'Dashboard')

@push('scripts')
	<script src="{{ asset('admin/assets/js/index1.js') }}"></script>
@endpush

@section('content')
    <div class="app-content main-content mt-0">
        <div class="side-app">
            <!-- CONTAINER -->
            <div class="main-container container-fluid">

                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <div>
                        <h1 class="page-title">Profile</h1>
                    </div>
                    <div class="ms-auto pageheader-btn">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </div>
                </div>
                <!-- PAGE-HEADER END -->

                <!-- ROW-1 OPEN -->
                <div class="row" id="user-profile">
                    <div class="col-lg-12">
                       
                        <div class="tab-content">
                            
                            <div class="tab-pane active show" id="profileMain">
                                <div class="card">
                                    <div class="card-body border-0">
                                        <form class="form-horizontal" action="{{ route('admin.profile.update') }}" method="POST">
                                            @csrf
                                            
                                        
                                            <div class="row mb-4">
                                                <p class="mb-4 text-17">Personal Info</p>
                                        
                                                <div class="col-md-12 col-lg-12 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="username" class="form-label">Name</label>
                                                        <input type="text" class="form-control" name="name" id="username" value="{{ Auth::user()->name }}">
                                                    </div>
                                                </div>
                                        
                                                <div class="col-md-12 col-lg-12 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="text" class="form-control" name="email" id="email" value="{{ Auth::user()->email }}">
                                                    </div>
                                                </div>
                                        
                                                <div class="col-md-12 col-lg-12 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="password" class="form-label">Password</label>
                                                        <input type="password" class="form-control" name="password" id="password" placeholder="New Password">
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <!-- SAVE BUTTON -->
                                            <div class="mt-3">
                                                <button type="submit" class="btn btn-primary">
                                                    Save Changes
                                                </button>
                                            </div>
                                        
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
