@extends('layouts.app')
@section('title','Ecommerce | Shop')
@section('content')
   <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>product Shop</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('front.index') }}">home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Product Shop</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->


    <!-- section start -->
    <section class="section-b-space ratio_asos">
        <div class="collection-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 collection-filter">
                       
                        <div class="theme-card">
                            <h5 class="title-border">new product</h5>
                            <div class="offer-slider slide-1">
                                <div>
                                  @foreach ($latests_one as $l_one)
                                    
                                    <div class="media">
                                        <a href="{{ route('product.detail',$l_one->id) }}"><img class="img-fluid blur-up lazyload"
                                                src="{{ asset('assets/backend/image/product/small/'.$l_one->thumbnail) }}" alt=""></a>
                                        <div class="media-body align-self-center">
                                            <a
                                                href="product-page(no-sidebar).html">
                                                <h6>{{$l_one->name}}</h6>
                                            </a>
                                            <h4>{{currency()}}{{number_format($l_one->current_price,2)}}</h4>
                                        </div>
                                    </div>
                                     @endforeach
                                </div>
                                <div>
                                  @foreach ($latests_two as $l_two)
                                    <div class="media">
                                        <a href="{{ route('product.detail',$l_two->id) }}"><img class="img-fluid blur-up lazyload"
                                                src="{{ asset('assets/backend/image/product/small/'.$l_two->thumbnail) }}" alt=""></a>
                                        <div class="media-body align-self-center">
                                            <a
                                                href="product-page(no-sidebar).html">
                                                <h6>{{$l_two->name}}</h6>
                                            </a>
                                            <h4>{{currency()}}{{number_format($l_two->current_price,2)}}</h4>
                                        </div>
                                    </div>
                                  @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collection-content col">
                        <div class="page-main-content">
                            <div class="row">
                                <div class="col-sm-12">
                                   
                                    <div class="collection-product-wrapper">
                                        <div class="product-top-filter">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="filter-main-btn"><span
                                                            class="filter-btn btn btn-theme"><i class="fa fa-filter"
                                                                aria-hidden="true"></i> Filter</span></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="product-filter-content">
                                                        <div class="search-count">
                                                            <h5>Showing Products 1-24 of 10 Result</h5>
                                                        </div>
                                                        <div class="collection-view">
                                                            <ul>
                                                                <li><i class="fa fa-th grid-layout-view"></i></li>
                                                                <li><i class="fa fa-list-ul list-layout-view"></i></li>
                                                            </ul>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-wrapper-grid">
                                            <div class="row margin-res">
                                              @foreach ($products as $product)
                                                
                                                <div class="col-xl-3 col-6 col-grid-box">
                                                    <div class="product-box">
                                                        <div class="img-wrapper">
                                                            <div class="front">
                                                                <a href="{{ route('product.detail',$product->id) }}"><img src="{{ asset('assets/backend/image/product/small/'.$product->thumbnail) }}"
                                                                        class="img-fluid blur-up lazyload bg-img"
                                                                        alt=""></a>
                                                            </div>
                                                            <div class="back">
                                                                <a href="{{ route('product.detail',$product->id) }}"><img src="{{ asset('assets/backend/image/product/small/'.$product->thumbnail) }}"
                                                                        class="img-fluid blur-up lazyload bg-img"
                                                                        alt=""></a>
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
                                                            <div>
                                                                
                                                                <a href="{{ route('product.detail',$product->id) }}">
                                                                    <h6>{{$product->name}}</h6>
                                                                </a>
                                                                <p>{{$product->detail}}</p>
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
                                                    </div>
                                                </div>
                                                @endforeach
                                                
                                            </div>
                                        </div>
                                        <div class="product-pagination">
                                            <div class="theme-paggination-block">
                                                <div class="row">
                                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                                        <nav aria-label="Page navigation">
                                                            <ul class="pagination">
                                                               {{$products->links()}}
                                                            </ul>
                                                        </nav>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                                        <div class="product-search-count-bottom">
                                                            <h5>Showing Products 1-24 of 10 Result</h5>
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
                </div>
            </div>
        </div>
    </section>
@endsection

