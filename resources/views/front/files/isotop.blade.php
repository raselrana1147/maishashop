
    <div class="title1 section-t-space">
        <h4>exclusive products</h4>
        <h2 class="title-inner1">everyday casual</h2>
    </div>
    <section class="section-b-space pt-0 ratio_asos">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="theme-tab">
                        <ul class="tabs tab-title">
                            <li class="current"><a href="tab-4">Featured</a></li>
                            <li class=""><a href="tab-5">Top Sale</a></li>
                            <li class=""><a href="tab-6">Trending</a></li>
                        </ul>
                        <div class="tab-content-cls">
                            <div id="tab-4" class="tab-content active default">
                                <div class="no-slider row">
                                    @foreach ($features as $featured)
                                       
                                    <div class="product-box">
                                        <div class="img-wrapper">
                                            <div class="front">
                                                <a href="{{ route('product.detail',$featured->id) }}"><img
                                                        src="{{ asset('assets/backend/image/product/small/'.$featured->thumbnail)}}"
                                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                                            </div>
                                            <div class="back">
                                                <a href="{{ route('product.detail',$featured->id) }}"><img
                                                        src="{{ asset('assets/backend/image/product/small/'.$featured->thumbnail)}}"
                                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                                            </div>
                                            <div class="cart-info cart-wrap">
                                                <a href="{{ route('product.detail',$featured->id) }}" title="Add to cart">
                                                    <i class="ti-shopping-cart"></i>
                                                </a>
                                                <a href="javascript:void(0)" title="Add to Wishlist" >
                                                    <i class="ti-heart add_to_wishlist" aria-hidden="true" data-action="{{ route('add_to_wishlist')}}" product_id="{{$featured->id}}"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-detail">
                                            
                                            <a href="{{ route('product.detail',$featured->id) }}">
                                                <h6>{{$featured->name}}</h6>
                                            </a>
                                            <h4>{{currency()}}{{number_format($featured->current_price,2)}}</h4>
                                            @php
                                                 $colors=json_decode($featured->color,true);
                                            @endphp
                                            <ul class="color-variant">
                                                 
                                                @if (!is_null($colors))
                                                     @foreach ($colors as $color)
                                                         <li style="background: {{$color}}"></li>
                                                     @endforeach
                                                 @endif 
                                            </ul>
                                        </div>
                                    </div>
                                     @endforeach

                                  
                                </div>
                            </div>


                            <div id="tab-5" class="tab-content">
                                <div class="no-slider row">

                                    @foreach ($top_sales as $top)
                                       
                                    <div class="product-box">
                                        <div class="img-wrapper">
                                            <div class="lable-block"><span class="lable3">new</span> <span
                                                    class="lable4">on sale</span></div>
                                            <div class="front">
                                                <a href="{{ route('product.detail',$top->id) }}"><img
                                                        src="{{ asset('assets/backend/image/product/small/'.$top->thumbnail)}}"
                                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                                            </div>
                                            <div class="back">
                                                <a href="{{ route('product.detail',$top->id) }}"><img
                                                        src="{{ asset('assets/backend/image/product/small/'.$top->thumbnail)}}"
                                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                                            </div>
                                            <div class="cart-info cart-wrap">
                                                <a href="{{ route('product.detail',$top->id) }}" title="Add to cart">
                                                    <i class="ti-shopping-cart"></i>
                                                </a>
                                                <a href="javascript:void(0)" title="Add to Wishlist" >
                                                    <i class="ti-heart add_to_wishlist" aria-hidden="true" data-action="{{ route('add_to_wishlist')}}" product_id="{{$top->id}}"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-detail">
                                            
                                            <a href="{{ route('product.detail',$top->id) }}">
                                                <h6>{{$top->name}}</h6>
                                            </a>
                                            <h4>{{currency()}}{{number_format($top->current_price,2)}}</h4>
                                            @php
                                                 $colors=json_decode($top->color,true);
                                            @endphp
                                            <ul class="color-variant">
                                                 
                                                @if (!is_null($colors))
                                                     @foreach ($colors as $color)
                                                         <li style="background: {{$color}}"></li>
                                                     @endforeach
                                                 @endif 
                                            </ul>
                                        </div>
                                    </div>
                                   @endforeach
                                   
                                </div>
                            </div>
                            <div id="tab-6" class="tab-content">
                                <div class="no-slider row">
                                @foreach ($trendings as $trending)
                                    
                                    <div class="product-box">
                                        <div class="img-wrapper">
                                            <div class="lable-block"><span class="lable3">new</span> <span
                                                    class="lable4">on sale</span></div>
                                            <div class="front">
                                                <a href="{{ route('product.detail',$trending->id) }}"><img
                                                        src="{{ asset('assets/backend/image/product/small/'.$trending->thumbnail)}}"
                                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                                            </div>
                                            <div class="back">
                                                <a href="{{ route('product.detail',$trending->id) }}"><img
                                                        src="{{ asset('assets/backend/image/product/small/'.$trending->thumbnail)}}"
                                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                                            </div>
                                            <div class="cart-info cart-wrap">
                                                <a href="{{ route('product.detail',$trending->id) }}" title="Add to cart">
                                                    <i class="ti-shopping-cart"></i>
                                                </a>
                                                <a href="javascript:void(0)" title="Add to Wishlist" >
                                                    <i class="ti-heart add_to_wishlist" aria-hidden="true" data-action="{{ route('add_to_wishlist')}}" product_id="{{$trending->id}}"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-detail">
                                            
                                            <a href="{{ route('product.detail',$trending->id) }}">
                                                <h6>{{$trending->name}}</h6>
                                            </a>
                                            <h4>{{currency()}}{{number_format($trending->current_price,2)}}</h4>
                                            @php
                                                 $colors=json_decode($trending->color,true);
                                            @endphp
                                            <ul class="color-variant">
                                                 
                                                @if (!is_null($colors))
                                                     @foreach ($colors as $color)
                                                         <li style="background: {{$color}}"></li>
                                                     @endforeach
                                                 @endif 
                                            </ul>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>