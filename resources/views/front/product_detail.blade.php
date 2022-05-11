@extends('layouts.app')
@section('title','Product Detail')
@section('content')
    
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>product</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">product</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!-- section start -->
    <section>
        <div class="collection-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="product-slick">
                            <div><img src="{{ asset('assets/backend/image/product/large/'.$product->thumbnail) }}" alt=""
                                    class="img-fluid blur-up lazyload image_zoom_cls-0" style="widows: 850px; height: 950px"></div>

                        @foreach ($product->galleries as $gallery)
                            <div><img src="{{ asset('assets/backend/image/gallery/large/'.$gallery->image) }}" alt=""
                                    class="img-fluid blur-up lazyload image_zoom_cls-0" style="widows: 850px; height: 950px"></div>
                          @endforeach
                        </div>
                        <div class="row">
                            <div class="col-12 p-0">
                                <div class="slider-nav">
                                     <div><img src="{{ asset('assets/backend/image/product/large/'.$product->thumbnail) }}" alt=""
                                    class="img-fluid blur-up lazyload image_zoom_cls-0"></div>
                                     @foreach ($product->galleries as $gallery)
                                    <div><img src="{{ asset('assets/backend/image/gallery/large/'.$gallery->image) }}" alt=""
                                            class="img-fluid blur-up lazyload"></div>
                                     @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 rtl-text">
                        <div class="product-right">
                            <div class="product-count">
                                <ul>
                                    <li>
                                        <img src="{{ asset('assets/frontend/assets/images/fire.gif')}}" class="img-fluid" alt="image">
                                        <span class="p-counter">37</span>
                                        <span class="lang">orders in last 24 hours</span>
                                    </li>
                                    <li>
                                        <img src="{{ asset('assets/frontend/assets/images/person.gif')}}" class="img-fluid user_img" alt="image">
                                        <span class="p-counter">44</span>
                                        <span class="lang">active view this</span>
                                    </li>
                                </ul>
                            </div>
                            <h2>{{$product->name}}</h2>
                            <div class="rating-section">
                                <div class="rating"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                        class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                </div>
                                <h6>120 ratings</h6>
                            </div>
                            <div class="label-section">
                                <span class="badge badge-grey-color">{{$product->brand->brand_name}}</span>
                                <span class="label-text">{{$product->category->category_name}}</span>
                            </div>
                            <h3 class="price-detail">{{currency()}}{{number_format($product->current_price,2)}} 
                                @if (!is_null($product->previous_price))
                                <del>{{currency()}}{{number_format($product->previous_price,2)}}</del>
                                @endif
                                @if (!is_null($product->discount))
                                    <span>{{$product->discount}}% off</span>
                                @endif
                            </h3>
                            <form id="submit_cart_form" data-action="{{ route('add_to_cart') }}" method="POST">
                            @if (!is_null($product->color))
                             
                            <ul class="color-variant">
                                @php
                                    $colors=json_decode($product->color,true);
                                @endphp
                                @foreach ($colors as $key=> $color)
                                   <li class="getColor" color_code="{{$color}}" style="background: {{$color}}"></li>
                                @endforeach
                            </ul>
                            <input type="hidden" name="color" class="setColor" value="">
                           
                             @endif
                            <div id="selectSize" class="addeffect-section product-description border-product">
                                <div class="modal fade" id="sizemodal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Sheer
                                                    Straight Kurta</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body"><img src="{{ asset('assets/frontend/assets/images/size-chart.jpg')}}" alt=""
                                                    class="img-fluid blur-up lazyload"></div>
                                        </div>
                                    </div>
                                </div>
                                @if (!is_null($product->size))
                                <h6 class="error-message">please select size</h6>
                                <div class="size-box">
                                    <ul>
                                        @php
                                            $sizes=json_decode($product->size,true);  
                                        @endphp
                                        @foreach ($sizes as $key=> $size)
                                          <li><a class="getSize" size_name="{{$size}}" href="javascript:void(0)">{{$size}}</a></li>
                                        @endforeach
                                         <input type="hidden" name="size" class="setSize" value="">
                                    </ul>
                                </div>
                                @endif
                                <h6 class="product-title">quantity</h6>
                                 <input type="hidden" name="product_id" value="{{$product->id}}">
                                <div class="qty-box">
                                    <div class="input-group"><span class="input-group-prepend"><button type="button"
                                                class="btn quantity-left-minus" data-type="minus" data-field=""><i
                                                    class="ti-angle-left"></i></button> </span>
                                        <input type="text" name="quantity" class="form-control input-number" value="1">
                                        <span class="input-group-prepend"><button type="button"
                                                class="btn quantity-right-plus" data-type="plus" data-field=""><i
                                                    class="ti-angle-right"></i></button></span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-buttons">
                                <button type="submit" id="cartEffect"
                                    class="btn btn-solid hover-solid btn-animation"><i class="fa fa-shopping-cart me-1"
                                        aria-hidden="true"></i> add to cart</button> 

                                <a href="javascript:void" class="btn btn-solid add_to_wishlist" data-action="{{ route('add_to_wishlist')}}" product_id="{{$product->id}}"><i
                                class="fa fa-bookmark fz-16 me-2 " ></i>wishlist</a>
                            </div>
                            </form>
                         
                          
                            <div class="border-product">
                                <h6 class="product-title">share it</h6>
                                <div class="product-icon">
                                    <ul class="product-social">
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->


    <!-- product-tab starts -->
    <section class="tab-product m-0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab"
                                href="#top-home" role="tab" aria-selected="true"><i
                                    class="icofont icofont-ui-home"></i>Details</a>
                            <div class="material-border"></div>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab"
                                href="#top-profile" role="tab" aria-selected="false"><i
                                    class="icofont icofont-man-in-glasses"></i>Specification</a>
                            <div class="material-border"></div>
                        </li>
                    </ul>
                    <div class="tab-content nav-material" id="top-tabContent">
                        <div class="tab-pane fade show active" id="top-home" role="tabpanel"
                            aria-labelledby="top-home-tab">
                            <div class="product-tab-discription">
                                <div class="part">
                                    <p>{!!$product->description!!}</p>
                                </div>
                               
                            </div>
                        </div>
                        <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
                            <p>{!! $product->specification!!}</p>
                           
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product-tab ends -->


    <!-- product section start -->
    <section class="section-b-space ratio_asos">
        <div class="container">
            <div class="row">
                <div class="col-12 product-related">
                    <h2>related products</h2>
                </div>
            </div>
            <div class="row search-product">
                @foreach ($releted_products as $rp)
                  
                <div class="col-xl-2 col-md-4 col-6">
                    <div class="product-box">
                        <div class="img-wrapper">
                            <div class="front">
                                <a href="{{ route('product.detail',$rp->id) }}"><img src="{{ asset('assets/backend/image/product/large/'.$rp->thumbnail) }}"
                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                            </div>
                            <div class="back">
                                <a href="{{ route('product.detail',$rp->id) }}"><img src="{{ asset('assets/backend/image/product/large/'.$rp->thumbnail) }}"
                                        class="img-fluid blur-up lazyload bg-img" alt=""></a>
                            </div>
                            <div class="cart-info cart-wrap">
                                <button data-bs-toggle="modal" data-bs-target="#addtocart" title="Add to cart"><i
                                        class="ti-shopping-cart"></i></button> <a href="javascript:void(0)"
                                    title="Add to Wishlist"><i class="ti-heart" aria-hidden="true"></i></a> <a href="#"
                                    data-bs-toggle="modal" data-bs-target="#quick-view" title="Quick View"><i
                                        class="ti-search" aria-hidden="true"></i></a> <a href="compare.html"
                                    title="Compare"><i class="ti-reload" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div class="product-detail">
                            
                            <a href="{{ route('product.detail',$rp->id) }}">
                                <h6>{{$rp->name}}</h6>
                            </a>
                            <h4>{{currency()}}{{number_format($rp->current_price,2)}}</h4>
                            @php
                                 $colors=json_decode($rp->color,true);
                                
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
                </div>
             @endforeach
            </div>
        </div>
    </section>
@endsection

@section('js')
<script src="{{ asset('assets/frontend/assets/js/jquery.elevatezoom.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.product-gallery-item').on("click",function(){
         var image=$(this).attr('data-zoom-image')
          $("#product-zoom").attr("src",image)
          $("#product-zoom").attr("data-zoom-image",image)
        })

        $('body').on('click','.getColor',function(){
            let color_code=$(this).attr('color_code')
            $('.setColor').val(color_code)
        })

         $('body').on('click','.getSize',function(){
            let size=$(this).attr('size_name')
            $('.setSize').val(size)
        })   
    });
</script>
@endsection