@extends('frontend.layouts.app')

@section('title', 'Your cart')

@section('main-content')
    <div class="shopping-cart section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Shopping cart</h2>
                </div>
            </div>
            @if ($cart->items->isEmpty())
                <p class="text-muted">Your cart is empty.</p>
                <a href="{{ route('home') }}" class="btn btn-primary" style="color: white;">Continue shopping</a>
            @else
                <div id="cart-message" class="alert d-none"></div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Unit price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart->items as $row)
                                @php
                                    $sub = $row->quantity * $row->price;
                                @endphp
                                <tr>
                                    <td>
                                        @if ($row->product?->image)
                                            <img src="{{ route('document.unauth.download', ['type' => 'product-image', 'id' => $row->product->id, 'action' => 'view']) }}"
                                                width="60" alt="">
                                        @else
                                            <img src="https://via.placeholder.com/60" width="60" alt="">
                                        @endif
                                    </td>
                                    <td>{{ $row->product?->name ?? 'Product' }}</td>
                                    <td>${{ number_format($row->price, 2) }}</td>
                                    <td>
                                        <form class="d-flex align-items-center cart-qty-form" method="POST"
                                            action="{{ route('cart.update', $row) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" class="form-control cart-qty-input"
                                                style="width: 80px" value="{{ (int) $row->quantity }}" min="1"
                                                data-id="{{ $row->id }}">
                                        </form>
                                    </td>
                                    <td>${{ number_format($sub, 2) }}</td>
                                    <td class="text-center align-middle" style="width: 1%; white-space: nowrap;">
                                        <a href="{{ route('cart.remove', $row) }}" class="text-danger d-inline-block p-1"
                                            title="Remove from cart"
                                            aria-label="Remove {{ $row->product?->name ?? 'item' }} from cart">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-right">Total</th>
                                <th>${{ number_format($total, 2) }}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <a href="{{ route('home') }}" class="btn btn-primary" style="color: white;">Continue shopping</a>
                <a href="" class="btn btn-secondary" style="color: white; margin-left:8px;">Proceed to checkout</a>
            @endif
        </div>
    </div>
@section('pageSpecificJS')
    <script>
        document.querySelectorAll('.cart-qty-input').forEach(input => {
            input.addEventListener('change', function() {
                fetch(`/cart/update/${this.dataset.id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            quantity: this.value,
                            _method: 'PUT'
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        document.querySelectorAll('.cart-count').forEach(el => {
                            el.textContent = data.total_qty;
                        });

                        let msg = document.getElementById('cart-message');
                        msg.className = 'alert alert-success';
                        msg.innerText = data.message;
                        clearTimeout(msg._hideTimer);
                        msg._hideTimer = setTimeout(() => msg.classList.add('d-none'), 2000);

                    });
            });
        });
    </script>
@endsection
@endsection
