@extends('layouts.app')
@section('content')
          	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
          		<div class="container">
          			<h1 class="page-title">{{$subcategory->category->category_name}} > {{$subcategory->sub_cat_name}}</span></h1>
          		</div><!-- End .container -->
          	</div><!-- End .page-header -->
              <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                  <div class="container">
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
                           <li class="breadcrumb-item"><a href="{{ route('product.subcategory_product',$subcategory->id) }}">Sub Category Product</a></li>
                  </div><!-- End .container -->
              </nav><!-- End .breadcrumb-nav -->
              <div class="page-content">
                  <div class="container">
                      <div class="products">
                          <div class="row">
                          	@if (count($products))
                          		@foreach ($products as $product)
                              <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                                  <div class="product">
                                      <figure class="product-media">
                                         
                                          <a href="{{ route('product.detail',$product->id) }}">
                                              <img src="{{ asset('assets/backend/image/product/small/'.$product->thumbnail) }}" alt="Product image" class="product-image">
                                          </a>

                                          <div class="product-action-vertical">
                                             <a href="javascript:;" class="btn-product-icon btn-wishlist btn-expandable add_to_wishlist" data-action="{{ route('add_to_wishlist')}}" product_id="{{$product->id}}"><span>add to wishlist</span></a>
                                          </div>

                                      </figure>

                                      <div class="product-body">
                                          <div class="product-cat">
                                              <a href="#">{{$product->category_category_name}}</a>
                                          </div>
                                          <h3 class="product-title"><a href="product.html">{{$product->name}}</a></h3>
                                          <div class="product-price">
                                             {{currency()}} {{$product->current_price}}
                                          </div><!-- End .product-price -->
                                      </div><!-- End .product-body -->
                                  </div><!-- End .product -->
                              </div>
                             @endforeach
                             @else
                             <h4>No Product Found</h4>
                          	@endif
                          </div><!-- End .row -->

                           <div class="d-flex justify-content-center">
                              {{$products->links()}}
                          </div>
                      </div><!-- End .products -->

                      <div class="sidebar-filter-overlay"></div><!-- End .sidebar-filter-overlay -->
                     
                  </div><!-- End .container -->
              </div><!-- End .page-content -->
@endsection
@section('js')

@endsection