<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="right-content">
                        <ul class="list-main">
                            @auth 
                                @if(ensureUserHasRole('admin'))
                                    <li><i class="ti-user"></i> <a href="{{ route('admin.dashboard') }}" rel="noopener">Dashboard</a></li>
                                @endif                                
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit">
                                            <i class="ti-power-off"></i> Logout
                                        </button>
                                    </form>
                                </li>

                            @else 
                                <li><i class="ti-power-off"></i><a href="{{route('login')}}">Login</a> /<a href="{{route('register')}}">Register</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-12">
                   
                    <div class="search-top">
                        <div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
                        <div class="search-top">
                            <form class="search-form">
                                <input type="text" placeholder="Search here..." name="search">
                                <button value="search" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="search-bar-top">
                        <div class="search-bar">
                            <select>
                                <option >All Category</option>
                                <option>Category 1</option>
                                <option>Category 2</option>
                                <option>Category 3</option>
                            </select>
                            <form method="POST" action="">
                                <input name="search" placeholder="Search Products Here....." type="search">
                                <button class="btnn" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    @php
                    $headerCart = ensureUserHasRole('user')
                        ? auth()->user()->cart()->with('items.product')->first()
                        : null;
                
                    $headerItems = $headerCart ? $headerCart->items : collect();
                
                    $headerQty = $headerItems->sum('quantity');
                
                    $headerTotal = $headerItems->sum(fn($row) => $row->quantity * $row->price);
                @endphp
                    <div class="right-bar">
                        @auth
                        <div class="sinlge-bar">
                            <a href="{{ route('profile') }}" class="single-icon" title="My profile"><i class="ti-user"></i></a>
                        </div>
                        @endauth
                        <div class="sinlge-bar shopping">
                            <a href="" class="single-icon"><i class="fa fa-heart-o"></i> <span <span class="total-count wishlist-count">0</span>
                                </span></a>
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>0 Items</span>
                                        <a href="">View Wishlist</a>
                                    </div>
                                    <ul class="shopping-list">
                                            <li>
                                                <a href="" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                                <a class="cart-img" href="#"><img src="" alt=""></a>
                                                <h4><a href="" target="_blank">Product Title</a></h4>
                                                <p class="quantity">1 x - <span class="amount">$0.00</span></p>
                                            </li>
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span class="total-amount">$0.00</span>
                                        </div>
                                        <a href="" class="btn animate">Cart</a>
                                    </div>
                                </div>
                            @endauth
                        </div>
                        <div class="sinlge-bar shopping">
                            <div class="sinlge-bar flex-shrink-0">
                                <a href="{{ ensureUserHasRole('user') ? route('cart.index') : route('login') }}"
                                    class="single-icon" title="Cart"><i class="ti-bag"></i> <span
                                        class="total-count cart-count">{{ $headerQty }}</span></a>
                            </div>
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{ $headerQty }} Items</span>
                                        <a href="{{ route('cart.index') }}">View Cart</a>
                                    </div>
                                    <ul class="shopping-list">
                                        @forelse ($headerItems as $item)
                                            @php
                                                $product = $item->product;
                                                $productName = $product ? $product->name : 'Product';
                                                $productImg = $product && $product->image
                                                    ? route('document.unauth.download', ['type' => 'product-image', 'id' => $product->id, 'action' => 'view'])
                                                    : 'https://via.placeholder.com/80x80';
                                            @endphp
                                            <li>
                                                <a href="{{ route('cart.remove', $item->id) }}" class="remove" title="Remove this item">
                                                    <i class="fa fa-remove"></i>
                                                </a>
                                                <a class="cart-img" href="{{ route('cart.index') }}">
                                                    <img src="{{ $productImg }}" alt="{{ $productName }}">
                                                </a>
                                                <h4>
                                                    <a href="{{ route('cart.index') }}">{{ $productName }}</a>
                                                </h4>
                                                <p class="quantity">
                                                    {{ $item->quantity }} x - <span class="amount">${{ number_format((float) $item->price, 2) }}</span>
                                                </p>
                                            </li>
                                        @empty
                                            <li>
                                                <div class="p-3 text-center">
                                                    Your cart is empty.
                                                </div>
                                            </li>
                                        @endforelse
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span class="total-amount">${{ number_format((float) $headerTotal, 2) }}</span>
                                        </div>
                                        <a href="{{ route('cart.index') }}" class="btn animate">Cart</a>
                                    </div>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">	
                                    <div class="nav-inner">	
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{Request::path()=='home' ? 'active' : ''}}"><a href="/">Home</a></li>
                                                <li class="@if(Request::path()=='product-grids'||Request::path()=='product-lists')  active  @endif"><a href="/">Products</a><span class="new">New</span></li>												
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>