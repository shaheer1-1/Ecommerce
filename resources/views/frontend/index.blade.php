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
                            <!-- Tab Nav -->
                            <ul class="nav nav-tabs filter-tope-group" id="myTab" role="tablist">
                                <button class="btn" style="background:black" data-filter="*">All Products</button>
                            </ul>
                        </div>

                        <div class="tab-content isotope-grid" id="myTabContent">

                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item 1">
                                <div class="single-product">
                                    <div class="product-img">
                                        <a href="/product/classic-white-shirt">
                                            <img src="https://via.placeholder.com/300x350" alt="No Image">
                                            <span class="new">New</span>
                                        </a>
                                        <div class="button-head">
                                            <div class="product-action">
                                                <a data-toggle="modal" data-target="#product1" title="Quick View" href="#"><i class="ti-eye"></i><span>Quick Shop</span></a>
                                                <a title="Wishlist" href="/add-to-wishlist/classic-white-shirt"><i class="ti-heart"></i><span>Add to Wishlist</span></a>
                                            </div>
                                            <div class="product-action-2">
                                                <a title="Add to cart" href="/add-to-cart/classic-white-shirt">Add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a href="/product/classic-white-shirt">Classic White Shirt</a></h3>
                                        <div class="product-price">
                                            <span>$35.99</span>
                                            <del style="padding-left:4%;">$49.99</del>
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
    <section class="midium-banner">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </section>
  
    <div class="modal fade" id="product1" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                </div>
                <div class="modal-body">
                    <div class="row no-gutters">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="product-gallery">
                                <div class="quickview-slider-active">
                                    <div class="single-slider"><img src="https://via.placeholder.com/400x450" alt="Classic White Shirt"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="quickview-content">
                                <h2>Classic White Shirt</h2>
                                <div class="quickview-ratting-review">
                                    <div class="quickview-ratting-wrap">
                                        <div class="quickview-ratting">
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="#"> (12 customer review)</a>
                                    </div>
                                    <div class="quickview-stock">
                                        <span><i class="fa fa-check-circle-o"></i> 25 in stock</span>
                                    </div>
                                </div>
                                <h3><small><del class="text-muted">$49.99</del></small> $35.99</h3>
                                <div class="quickview-peragraph">
                                    <p>A timeless classic white shirt crafted from premium cotton. Perfect for both casual and formal occasions.</p>
                                </div>
                                <div class="size">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <h5 class="title">Size</h5>
                                            <select>
                                                <option>S</option>
                                                <option>M</option>
                                                <option>L</option>
                                                <option>XL</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <form action="/single-add-to-cart" method="POST" class="mt-4">
                                    @csrf
                                    <div class="quantity">
                                        <div class="input-group">
                                            <div class="button minus">
                                                <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                    <i class="ti-minus"></i>
                                                </button>
                                            </div>
                                            <input type="hidden" name="slug" value="classic-white-shirt">
                                            <input type="text" name="quant[1]" class="input-number" data-min="1" data-max="1000" value="1">
                                            <div class="button plus">
                                                <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                    <i class="ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-to-cart">
                                        <button type="submit" class="btn">Add to cart</button>
                                        <a href="/add-to-wishlist/classic-white-shirt" class="btn min"><i class="ti-heart"></i></a>
                                    </div>
                                </form>
                                <div class="default-social">
                                    <div class="sharethis-inline-share-buttons"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Product 2 -->
    <div class="modal fade" id="product2" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                </div>
                <div class="modal-body">
                    <div class="row no-gutters">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="product-gallery">
                                <div class="quickview-slider-active">
                                    <div class="single-slider"><img src="https://via.placeholder.com/400x450" alt="Floral Summer Dress"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="quickview-content">
                                <h2>Floral Summer Dress</h2>
                                <div class="quickview-ratting-review">
                                    <div class="quickview-ratting-wrap">
                                        <div class="quickview-ratting">
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                        </div>
                                        <a href="#"> (28 customer review)</a>
                                    </div>
                                    <div class="quickview-stock">
                                        <span><i class="fa fa-check-circle-o"></i> 15 in stock</span>
                                    </div>
                                </div>
                                <h3><small><del class="text-muted">$69.99</del></small> $47.99</h3>
                                <div class="quickview-peragraph">
                                    <p>A vibrant floral summer dress with a relaxed fit. Light, breathable fabric ideal for warm days.</p>
                                </div>
                                <div class="size">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <h5 class="title">Size</h5>
                                            <select>
                                                <option>XS</option>
                                                <option>S</option>
                                                <option>M</option>
                                                <option>L</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <form action="/single-add-to-cart" method="POST" class="mt-4">
                                    @csrf
                                    <div class="quantity">
                                        <div class="input-group">
                                            <div class="button minus">
                                                <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                    <i class="ti-minus"></i>
                                                </button>
                                            </div>
                                            <input type="hidden" name="slug" value="floral-summer-dress">
                                            <input type="text" name="quant[1]" class="input-number" data-min="1" data-max="1000" value="1">
                                            <div class="button plus">
                                                <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                    <i class="ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-to-cart">
                                        <button type="submit" class="btn">Add to cart</button>
                                        <a href="/add-to-wishlist/floral-summer-dress" class="btn min"><i class="ti-heart"></i></a>
                                    </div>
                                </form>
                                <div class="default-social">
                                    <div class="sharethis-inline-share-buttons"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modals -->

@endsection

@push('styles')
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons' async='async'></script>
    
@endpush

@push('scripts')
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
@endpush