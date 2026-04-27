@extends('frontend.layouts.app')

@section('title', 'My profile')

@section('main-content')
    <section class="shop login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <div class="login-form">
                        <h2>My profile</h2>
                        <p>Update your account and addresses below.</p>

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul class="mb-0 pl-3">
                                    @foreach ($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="form" method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')

                            <h3 class="h4 mt-3">Account</h3>
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="current_password">Current password</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    name="current_password" id="current_password" placeholder="Current password" autocomplete="current-password">
                                @error('current_password')
                                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">New password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" id="password" placeholder="New password (min. 8 characters)" autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm new password</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" id="password_confirmation"
                                    placeholder="Confirm new password" autocomplete="new-password">
                                @error('password_confirmation')
                                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <hr class="my-4">
                            <h3 class="h4">Billing address</h3>
                            <div class="form-group">
                                <label for="billing_address">Street / address</label>
                                <input type="text" class="form-control" name="billing_address" id="billing_address"
                                    value="{{ old('billing_address', $addr?->billing_address ?? '') }}">

                            </div>
                            <div class="form-group">
                                <label for="billing_city">City</label>
                                <input type="text" class="form-control" name="billing_city" id="billing_city"
                                    value="{{ old('billing_city', $addr?->billing_city ?? '') }}">
                               
                            </div>
                            <div class="form-group">
                                <label for="billing_state"></label>
                                <select class="form-control popup-input" id="billing_state" name="billing_state">
                                    <option value="">State</option>
                                    @foreach (config('states') as $abbr => $fullName)
                                        <option value="{{ $abbr }}" {{ old('billing_state', $addr?->billing_state ?? '') == $abbr ? 'selected' : '' }}>{{ $fullName }}</option>
                                    @endforeach
                                </select>
                               
                            </div>
                            <div class="form-group">
                                <label for="billing_country">Country</label>
                                <input type="text" class="form-control" name="billing_country" id="billing_country"
                                    value="{{ old('billing_country', $addr?->billing_country ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="billing_zip">ZIP / postal code</label>
                                <input type="text" class="form-control" name="billing_zip" id="billing_zip"
                                    value="{{ old('billing_zip', $addr?->billing_zip ?? '') }}">
                            </div>

                            <hr class="my-4">
                            <h3 class="h4">Shipping address</h3>
                            <div class="form-group">
                                <label for="shipping_address">Street / address</label>
                                <input type="text" class="form-control" name="shipping_address" id="shipping_address"
                                    value="{{ old('shipping_address', $addr?->shipping_address ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="shipping_city">City</label>
                                <input type="text" class="form-control" name="shipping_city" id="shipping_city"
                                    value="{{ old('shipping_city', $addr?->shipping_city ?? '') }}">

                            </div>
                            <div class="form-group">
                                <label for="shipping_state"></label>
                                <select class="form-control popup-input" id="shipping_state" name="shipping_state">
                                    <option value="">State</option>
                                    @foreach (config('states') as $abbr => $fullName)
                                        <option value="{{ $abbr }}" {{ old('shipping_state', $addr?->shipping_state ?? '') == $abbr ? 'selected' : '' }}>{{ $fullName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="shipping_country">Country</label>
                                <input type="text" class="form-control" name="shipping_country" id="shipping_country"
                                    value="{{ old('shipping_country', $addr?->shipping_country ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="shipping_zip">ZIP / postal code</label>
                                <input type="text" class="form-control" name="shipping_zip" id="shipping_zip"
                                    value="{{ old('shipping_zip', $addr?->shipping_zip ?? '') }}">
                            </div>
                            <div class="form-group login-btn pt-2">
                                <button class="btn btn-primary" type="submit">Save changes</button>
                                <a href="{{ route('home') }}" class="btn border">Back to shop</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
