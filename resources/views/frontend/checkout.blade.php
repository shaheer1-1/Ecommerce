@extends('frontend.layouts.app')

@section('title', 'Checkout')

@section('pageSpecificCSS')
<style>
    .StripeElement {
        background-color: #fff;
        padding: .75rem;
        border: 1px solid #ced4da;
        border-radius: .25rem;
    }
    .StripeElement--focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    .StripeElement--invalid { border-color: #dc3545; }
</style>
@endsection

@section('main-content')
<div class="section shopping-cart" style="padding: 40px 0;">
    <div class="container">

        <div class="row align-items-end mb-3">
            <div class="col-12 col-md-8">
                <h2 class="mb-1">Checkout</h2>
                <p class="text-muted mb-0">Complete your shipping details and choose a payment method.</p>
            </div>
        </div>

        <div class="row">

            {{-- LEFT: Form --}}
            <div class="col-lg-7">
                <form id="checkout-form" method="POST" action="{{ route('checkout.placeOrder') }}" novalidate>
                    @csrf

                    {{-- Shipping --}}
                    <div class="card mb-4">
                        <div class="card-header bg-white d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Shipping details</h5>
                            <small class="text-muted">Fields marked * are required</small>
                        </div>
                        <div class="card-body">

                            @if ($errors->any())
                                <div class="alert alert-danger"><strong>Please fix the errors below.</strong></div>
                            @endif

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Full name <span class="text-danger">*</span></label>
                                    <input id="name" name="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', auth()->user()->name) }}"
                                        required autocomplete="name">
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input id="email" name="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', auth()->user()->email) }}"
                                        required autocomplete="email">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="phone">Phone <span class="text-danger">*</span></label>
                                    <input id="phone" name="phone" type="tel"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone') }}"
                                        required autocomplete="tel" placeholder="e.g. +1 555 123 4567">
                                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="shipping_country">Country <span class="text-danger">*</span></label>
                                    <input id="shipping_country" name="shipping_country" type="text"
                                        class="form-control @error('shipping_country') is-invalid @enderror"
                                        value="{{ old('shipping_country') }}"
                                        required autocomplete="country-name" placeholder="Country">
                                    @error('shipping_country')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="shipping_address">Street address <span class="text-danger">*</span></label>
                                <input id="shipping_address" name="shipping_address" type="text"
                                    class="form-control @error('shipping_address') is-invalid @enderror"
                                    value="{{ old('shipping_address') }}"
                                    required autocomplete="shipping street-address" placeholder="House no, street, area">
                                @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="shipping_city">City <span class="text-danger">*</span></label>
                                    <input id="shipping_city" name="shipping_city" type="text"
                                        class="form-control @error('shipping_city') is-invalid @enderror"
                                        value="{{ old('shipping_city') }}"
                                        required autocomplete="shipping address-level2" placeholder="City">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="shipping_state">State/Province <span class="text-danger">*</span></label>
                                    <select id="shipping_state" name="shipping_state"
                                        class="form-control @error('shipping_state') is-invalid @enderror" required>
                                        <option value="">Select a state</option>
                                        @foreach (config('states') as $state)
                                            <option value="{{ $state }}" {{ old('shipping_state') == $state ? 'selected' : '' }}>
                                                {{ $state }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="shipping_zip">ZIP/Postal code <span class="text-danger">*</span></label>
                                    <input id="shipping_zip" name="shipping_zip" type="text"
                                        class="form-control @error('shipping_zip') is-invalid @enderror"
                                        value="{{ old('shipping_zip') }}"
                                        required autocomplete="shipping postal-code" placeholder="ZIP">
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Payment --}}
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Payment</h5>
                        </div>
                        <div class="card-body">

                            <div class="custom-control custom-radio mb-2">
                                <input type="radio" id="pm_card" name="payment_method" class="custom-control-input"
                                    value="card" {{ old('payment_method', 'card') === 'card' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="pm_card">
                                    Pay by card <span class="text-muted">(Stripe)</span>
                                </label>
                            </div>

                            <div id="stripe-card-wrap" class="border rounded p-3 mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div>
                                        <strong>Card details</strong>
                                        <div class="text-muted" style="font-size:.9rem;">Secure payment powered by Stripe</div>
                                    </div>
                                    <small class="text-muted"><i class="fa fa-lock"></i> SSL secure</small>
                                </div>
                                <div id="card-element"></div>
                                <small class="text-muted d-block mt-2">We do not store your card details.</small>
                                <div id="card-errors" class="text-danger mt-2" role="alert"></div>
                                <input type="hidden" name="stripe_payment_method_id" id="stripe_payment_method_id"
                                    value="{{ old('stripe_payment_method_id') }}">
                            </div>

                            <div class="custom-control custom-radio mb-0">
                                <input type="radio" id="pm_cod" name="payment_method" class="custom-control-input"
                                    value="cod" {{ old('payment_method') === 'cod' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="pm_cod">
                                    Cash on delivery <span class="text-muted">(pay when you receive)</span>
                                </label>
                            </div>

                            <hr>

                            <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-between">
                                <p class="text-muted mb-3 mb-sm-0" style="font-size:.92rem;">
                                    By placing your order, you agree to our terms and privacy policy.
                                </p>
                                <button id="place-order-btn" class="btn btn-primary btn-lg" type="submit">
                                    Place order
                                </button>
                            </div>

                        </div>
                    </div>

                </form>
            </div>

            {{-- RIGHT: Order Summary --}}
            <div class="col-lg-5">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Order summary</h5>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th style="min-width:180px;">Product</th>
                                        <th class="text-center" style="width:1%;">Qty</th>
                                        <th class="text-right" style="width:1%;">Line</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart->items as $row)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-2" style="width:44px;">
                                                        @if ($row->product?->image)
                                                            <img class="img-fluid rounded"
                                                                src="{{ route('document.unauth.download', ['type' => 'product-image', 'id' => $row->product->id, 'action' => 'view']) }}"
                                                                alt="{{ $row->product?->name ?? 'Product' }}">
                                                        @else
                                                            <img class="img-fluid rounded" src="https://via.placeholder.com/80" alt="Product">
                                                        @endif
                                                    </div>
                                                    <div class="text-truncate">
                                                        <div class="font-weight-bold text-truncate">{{ $row->product?->name ?? 'Product' }}</div>
                                                        <div class="text-muted" style="font-size:.9rem;">${{ number_format($row->price, 2) }} each</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">{{ (int) $row->quantity }}</td>
                                            <td class="align-middle text-right font-weight-bold">${{ number_format($row->quantity * $row->price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="font-weight-bold">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping</span>
                            <span class="text-muted">Calculated at next step</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="h5 mb-0">Total</span>
                            <span class="h5 mb-0">${{ number_format($total, 2) }}</span>
                        </div>

                        <div class="alert alert-light border mt-3 mb-0" style="font-size:.92rem;">
                            <strong>Tip:</strong> Use a valid phone number so the courier can reach you.
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('pageSpecificJS')
@if (!empty($stripePublicKey))
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe  = Stripe(@json($stripePublicKey));
    const card    = stripe.elements().create('card', { hidePostalCode: true });
    const form    = document.getElementById('checkout-form');
    const cardEl  = document.getElementById('card-errors');
    const pmInput = document.getElementById('stripe_payment_method_id');
    const btn     = document.getElementById('place-order-btn');
    const wrap    = document.getElementById('stripe-card-wrap');

    card.mount('#card-element');

    card.on('change', e => {
        cardEl.textContent = e.error ? e.error.message : '';
    });

    document.querySelectorAll('input[name="payment_method"]').forEach(r =>
        r.addEventListener('change', () => {
            wrap.style.display = r.value === 'card' && r.checked ? '' : 'none';
        })
    );
    wrap.style.display = document.querySelector('input[name="payment_method"]:checked')?.value === 'card' ? '' : 'none';
    form.addEventListener('submit', async e => {
        if (document.querySelector('input[name="payment_method"]:checked')?.value !== 'card') return;
        e.preventDefault();
        btn.disabled = true;
        const { error, paymentMethod } = await stripe.createPaymentMethod({ type: 'card', card });
        if (error) {
            cardEl.textContent = error.message || 'Card payment failed. Please verify your details.';
            btn.disabled = false;
            return;
        }

        pmInput.value = paymentMethod.id;
        form.submit();
    });
</script>
@endif
@endsection