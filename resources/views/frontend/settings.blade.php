@extends('frontend.layouts.app')

@section('title', 'Settings')

@section('main-content')
<section class="shop login section">
    <div class="container">

        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-12">

                <div class="mb-4 text-center">
                    <h2 class="mb-1">Account Settings</h2>
                    <p class="text-muted">Manage your application configuration and payment settings</p>
                </div>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="{{ route('settings.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <h5 class="mb-3">Stripe Configuration</h5>
                            <div class="form-group mb-3">
                                <label>Stripe Public Key</label>
                                <input type="text"
                                       name="stripe_public_key"
                                       class="form-control"
                                       value="{{ old('stripe_public_key', $stripePublicKey) }}"
                                       placeholder="pk_test_...">
                            </div>

                            <div class="form-group mb-3">
                                <label>Stripe Secret Key</label>
                                <input type="text" name="stripe_secret_key" class="form-control" value="{{ old('stripe_secret_key', $stripeSecretKey) }}"placeholder="sk_test_...">
                            </div>
                            <hr>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary px-4">
                                    Save Settings
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection