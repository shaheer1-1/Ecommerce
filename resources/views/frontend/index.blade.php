@extends('frontend.layouts.app')
@section('title','Ecommerce Website')
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
                                                    ? asset('storage/' . $product->image)
                                                    : 'https://via.placeholder.com/300x350';
                                            @endphp
                                            <img class="default-img" src="{{ $pimg }}" alt="{{ $product->name }}">
                                            <img class="hover-img" src="{{ $pimg }}" alt="{{ $product->name }}">
                                            <span class="new">New</span>
                                        </a>
                                        <div class="button-head">
                                            <div class="product-action">
                                                <a data-toggle="modal" data-target="#productModal{{ $product->id }}"
                                                    href="javascript:void(0);" title="Quick View"><i
                                                        class="ti-eye"></i><span>Quick Shop</span></a>
                                                <a title="Add to Wishlist" href="javascript:void(0);"><i
                                                        class="ti-heart"></i><span>Add to Wishlist</span></a>
                                            </div>
                                            <div class="product-action-2">
                                                @auth
                                                    <a title="Add to cart"
                                                        href="">Add to cart</a>
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
  
    @foreach ($products as $product)
    <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100">{{ $product->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="ti-close" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row no-gutters">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="product-gallery">
                                <div class="quickview-slider-active">
                                    <div class="single-slider">
                                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x450' }}"
                                            alt="{{ $product->name }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="quickview-content">
                                <h2>{{ $product->name }}</h2>
                                <div class="quickview-ratting-review">
                                    <div class="quickview-ratting-wrap">
                                        <div class="quickview-ratting">
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <h3>${{ number_format($product->price, 2) }}</h3>
                                <div class="quickview-peragraph">
                                    <p>
                                        @if ($product->description)
                                            {!! nl2br(e($product->description)) !!}
                                        @else
                                            No description for this product yet.
                                        @endif
                                    </p>
                                </div>
                                @if ($product->category)
                                    <p class="text-muted small">Category: {{ $product->category->name }}</p>
                                @endif
                                <div class="add-to-cart pt-2">
                                    @auth
                                        <a href="" class="btn">Add to cart</a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn">Login to add to cart</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

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