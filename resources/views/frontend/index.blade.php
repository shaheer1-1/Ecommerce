@extends('frontend.layouts.app')
@section('title','Ecommerce Website')
@section('specifcPageCSS')
<style>
    .single-product {
    height: 100%;
    display: flex;
    flex-direction: column;
}
.product-img {
    width: 100%;
    height: 280px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.product-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.product-content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
</style>
@section('main-content')

    <div class="product-area section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Trending Item</h2>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-12">
                <div class="product-info">
                    <div class="nav-main">
                        <ul class="nav nav-tabs filter-tope-group" id="myTab" role="tablist">
                            <li class="d-inline-block">
                                <button class="btn how-active1" type="button" style="background: black"
                                    data-filter="*">All Products</button>
                            </li>
                            @foreach ($categories as $cat)
                                <li class="d-inline-block">
                                    <button class="btn" type="button" style="background: none; color: black;"
                                        data-filter=".cat-{{ $cat->id }}">
                                        {{ $cat->name }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="tab-content isotope-grid" id="myTabContent">
                        @forelse ($products as $product)
                            <div
                                class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item cat-{{ $product->category_id }}">
                                <div class="single-product">
                                    <div class="product-img">
                                        <a href="javascript:void(0)">
                                            @php
                                                $pimg = $product->image
                                                    ? route('document.unauth.download', ['type' => 'product-image', 'id' => $product->id, 'action' => 'view'])
                                                    : 'https://via.placeholder.com/300x350';
                                            @endphp
                                            <img class="default-img" src="{{ $pimg }}" alt="{{ $product->name }}">
                                            <img class="hover-img" src="{{ $pimg }}" alt="{{ $product->name }}">
                                            <span class="new">New</span>
                                        </a>
                                        <div class="button-head">
                                            <div class="product-action">
                                                <a title="Add to Wishlist" href="javascript:void(0);"><i
                                                        class="ti-heart"></i><span>Add to Wishlist</span></a>
                                            </div>
                                            <div class="product-action-2">
                                                @auth
                                                    <a title="Add to cart"
                                                        href="{{ route('cart.add', $product->id) }}">Add to cart</a>
                                                @else
                                                    <a title="Add to cart" href="{{ route('login') }}">Add to
                                                        cart</a>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a href="javascript:void(0);">{{ $product->name }}</a></h3>
                                        <div class="product-price">
                                            <span>${{ number_format($product->price, 2) }}</span>
                                        </div>
                                        @if ($product->category)
                                            <p class="small text-muted mt-1 mb-0">
                                                {{ $product->category->name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 p-4 text-center text-muted">
                                <p>No products yet. Add categories and products from the admin panel.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <section class="midium-banner">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </section>

@endsection

@section('pageSpecificCSS')
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons' async='async'></script>
    
@endsection

@section('pageSpecificJS')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    var $topeContainer = $('.isotope-grid');
    var $filter = $('.filter-tope-group');

    $filter.each(function () {
        $filter.on('click', 'button', function () {
            var filterValue = $(this).attr('data-filter');
            $topeContainer.isotope({ filter: filterValue });
        });
    });

    $(window).on('load', function () {
        var $grid = $topeContainer.each(function () {
            $(this).isotope({
                itemSelector: '.isotope-item',
                layoutMode: 'fitRows',
                percentPosition: true,
                animationEngine: 'best-available',
                masonry: { columnWidth: '.isotope-item' }
            });
        });
    });

    var isotopeButton = $('.filter-tope-group button');
    $(isotopeButton).each(function () {
        $(this).on('click', function () {
            for (var i = 0; i < isotopeButton.length; i++) {
                $(isotopeButton[i]).removeClass('how-active1');
            }
            $(this).addClass('how-active1');
        });
    });
</script>
@endsection