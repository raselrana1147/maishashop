<header>
        <div class="mobile-fix-option"></div>
        <div class="top-header">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="header-contact">
                            <ul>
                                <li>Welcome to Our store Multikart</li>
                                <li><i class="fa fa-phone" aria-hidden="true"></i>Call Us: 123 - 456 - 7890</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 text-end">
                        <ul class="header-dropdown">
                            <li class="mobile-wishlist"><a href="{{ route('view.cart') }}"> <i class="ti-shopping-cart"></i></a>
                            </li>
                            <li class="mobile-wishlist"><a href="{{ route('wishlist') }}"><i class="fa fa-heart" aria-hidden="true"></i></a>
                            </li>
                            <li class="onhover-dropdown mobile-account"> <i class="fa fa-user" aria-hidden="true"></i>
                                My Account
                                <ul class="onhover-show-div">
                                    @guest
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                    <li><a href="{{ route('register') }}">register</a></li>
                                    @else
                                    <li><a href="">My Account</a></li>
                                    <li class="login">
                                       <a href="javascript:;" onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">Logout</a>
                                       <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                           @csrf
                                       </form>
                                    </li>
                                    @endguest
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="main-menu">
                        <div class="menu-left">
                            <div class="navbar">
                                <a href="javascript:void(0)" onclick="openNav()">
                                    <div class="bar-style"><i class="fa fa-bars sidebar-bar" aria-hidden="true"></i>
                                    </div>
                                </a>
                                <div id="mySidenav" class="sidenav">
                                    <a href="javascript:void(0)" class="sidebar-overlay" onclick="closeNav()"></a>
                                    <nav>
                                        <div onclick="closeNav()">
                                            <div class="sidebar-back text-start"><i class="fa fa-angle-left pe-2"
                                                    aria-hidden="true"></i> Back</div>
                                        </div>
                                        <ul id="sub-menu" class="sm pixelstrap sm-vertical">
                                                @foreach (categories() as $category)
                                                    
                                            <li> <a href="{{ route('product.category_product',$category->id) }}">{{$category->category_name}}</a>
                                                @if (count($category->sub_categories)>0)
                                                <ul class="mega-menu clothing-menu">
                                                   
                                                    <li>   
                                                        <div class="row m-0">
                                                        @foreach ($category->sub_categories as $sub)
                                                       
                                                            <div class="col-xl-4">
                                                                <div class="link-section">
                                                                    <h5>{{$sub->sub_cat_name}}</h5>
                                                                    @if (count($sub->child_category)>0)
                                                                    <ul>
                                                                        @foreach ($sub->child_category as $child)
                                                                          <li><a href="#">{{$child->child_cat_name}}</a></li>
                                                                         @endforeach
                                                                    </ul>
                                                                     @endif
                                                                </div>
                                                            </div>
                                                             @endforeach
                                                            <div class="col-xl-4">
                                                                <a href="#" class="mega-menu-banner"><img
                                                                        src="{{ asset('assets/backend/image/category/small/'.$category->image)}}"
                                                                        alt="" class="img-fluid blur-up lazyload"></a>
                                                            </div>
                                                        </div> 
                                                    </li>
                                                
                                                </ul>
                                                @endif
                                            </li>

                                             @endforeach
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="brand-logo">
                                <a href="{{ route('front.index') }}"><img src="{{ asset('assets/frontend/assets/images/icon/logo.png')}}"
                                        class="img-fluid blur-up lazyload" alt=""></a>
                            </div>
                        </div>
                        <div class="menu-right pull-right">
                            <div>
                                <nav id="main-nav">
                                    <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                                    <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                                        <li>
                                            <div class="mobile-back text-end">Back<i class="fa fa-angle-right ps-2"
                                                    aria-hidden="true"></i></div>
                                        </li>
                                        <li><a href="{{ route('front.index') }}">Home</a></li>
                                        <li><a href="{{ route('product.shop') }}">Shop</a></li>
                                        <li><a href="{{ route('front.index') }}">About</a></li>
                                        <li><a href="{{ route('front.index') }}">Contact</a></li>
                                        <li><a href="{{ route('front.index') }}">Term Condition</a></li>
                                        <li><a href="{{ route('front.index') }}">Privacy</a></li>
                                        
                                        
                                    </ul>
                                </nav>
                            </div>
                            <div>
                                <div class="icon-nav">
                                    <ul>
                                        <li class="onhover-div mobile-search">
                                            <div><img src="{{ asset('assets/frontend/assets/images/icon/search.png')}}" onclick="openSearch()"
                                                    class="img-fluid blur-up lazyload" alt=""> <i class="ti-search"
                                                    onclick="openSearch()"></i></div>
                                            <div id="search-overlay" class="search-overlay">
                                                <div> <span class="closebtn" onclick="closeSearch()"
                                                        title="Close Overlay">×</span>
                                                    <div class="overlay-content">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-xl-12">
                                                                    <form action="{{ route('product.search') }}" method="POST">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control"
                                                                                name="keyword"
                                                                                placeholder="Search a Product">
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary"><i
                                                                                class="fa fa-search"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                       
                                        <li class="onhover-div mobile-cart">
                                            <div><img src="{{ asset('assets/frontend/assets/images/icon/cart.png')}}"
                                                    class="img-fluid blur-up lazyload" alt=""> <i
                                                    class="ti-shopping-cart"></i></div>

                                            <span class="cart_qty_cls cart-count">{{total_item()}}</span>
                                            
                                            <ul class="show-div shopping-cart cart-item-added ">
                                                @if (count(carts())>0)
                                                @foreach (carts() as $cart)
                                                   
                                                <li class="cart_row{{$cart->id}}">
                                                    <div class="media">
                                                        <a href="{{ route('product.detail',$cart->product_id) }}"><img alt="" class="me-3"
                                                                src="{{ asset('assets/backend/image/product/small/'.$cart->product->thumbnail)}}"></a>
                                                        <div class="media-body">
                                                            <a href="{{ route('product.detail',$cart->product_id) }}">
                                                                <h4>{{$cart->product->name}}</h4>
                                                            </a>
                                                            <h4><span>{{$cart->quantity}} x {{currency()}}{{number_format($cart->product->current_price,2)}}</span></h4>
                                                        </div>
                                                    </div>
                                                    <div class="close-circle "><a href="javascript:void"><i class="fa fa-times delete_cart" cart_id="{{$cart->id}}" data-action="{{ route('cart.delete') }}" aria-hidden="true"></i></a></div>
                                                </li>

                                                @endforeach
                                             
                                               
                                                <li>
                                                    <div class="total">
                                                        <h5>subtotal : <span>{{currency()}}{{number_format(sub_total(),2)}}</span></h5>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="buttons"><a href="{{ route('view.cart') }}" class="view-cart">view cart</a> <a href="{{ route('checkout') }}" class="checkout">checkout</a></div>
                                                </li>
                                                
                                                @else
                                                <h4>Empty Cart</h4>
                                                @endif
                                            </ul>
                                            
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>