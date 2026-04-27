<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="right-content">
                        <ul class="list-main">
                        
                            @auth 
                                @if(Auth::user()->type === 'admin')
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
                    <div class="right-bar">
                        @auth
                        <div class="sinlge-bar">
                            <a href="{{ route('profile') }}" class="single-icon" title="My profile"><i class="ti-user"></i></a>
                        </div>
                        @endauth
                        <div class="sinlge-bar shopping">
                            <a href="" class="single-icon"><i class="fa fa-heart-o"></i> <span class="total-count">0</span></a>
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
                            <a href="" class="single-icon"><i class="ti-bag"></i> <span class="total-count">0</span></a>
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>0 Items</span>
                                        <a href="">View Cart</a>
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
                                        <a href="" class="btn animate">Checkout</a>
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
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">	
                                    <div class="nav-inner">	
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{Request::path()=='home' ? 'active' : ''}}"><a href="">Home</a></li>
                                                <li class="@if(Request::path()=='product-grids'||Request::path()=='product-lists')  active  @endif"><a href="">Products</a><span class="new">New</span></li>												
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