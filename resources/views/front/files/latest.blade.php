 <div class="title1 section-t-space">
        <h4>special offer</h4>
        <h2 class="title-inner1">Latest Drops</h2>
    </div>
  
   
    <section class="section-b-space pt-0 ratio_asos">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="product-4 product-m no-arrow">
                        @foreach ($latests as $product)
                            {{-- expr --}}
                        
                        <div class="product-box">
                            <div class="img-wrapper">
                                <div class="front">
                                    <a href="{{ route('product.detail',$product->id) }}"><img src="{{ asset('assets/backend/image/product/small/'.$product->thumbnail)}}"
                                            class="img-fluid blur-up lazyload bg-img" alt=""></a>
                                </div>
                                <div class="back">
                                    <a href="{{ route('product.detail',$product->id) }}"><img src="{{ asset('assets/backend/image/product/small/'.$product->thumbnail)}}"
                                            class="img-fluid blur-up lazyload bg-img" alt=""></a>
                                </div>
                                <div class="cart-info cart-wrap">
                                    <a href="{{ route('product.detail',$product->id) }}" title="Add to cart">
                                        <i class="ti-shopping-cart"></i>
                                    </a>
                                    <a href="javascript:void(0)" title="Add to Wishlist" >
                                        <i class="ti-heart add_to_wishlist" aria-hidden="true" data-action="{{ route('add_to_wishlist')}}" product_id="{{$product->id}}"></i>
                                    </a>

                                </div>
                            </div>
                            <div class="product-detail">
                                
                                <a href="{{ route('product.detail',$product->id) }}">
                                    <h6>{{$product->name}}</h6>
                                </a>
                                <h4>{{currency()}}{{number_format($product->current_price,2)}}</h4>
                                @php
                                     $colors=json_decode($product->color,true);
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
    </section>