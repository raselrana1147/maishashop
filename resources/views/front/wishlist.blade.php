@extends('layouts.app')
@section('title','Ecommerce | Wishlist View')
@section('content')
      <div class="breadcrumb-section">
          <div class="container">
              <div class="row">
                  <div class="col-sm-6">
                      <div class="page-title">
                          <h2>wishlist</h2>
                      </div>
                  </div>
                  <div class="col-sm-6">
                      <nav aria-label="breadcrumb" class="theme-breadcrumb">
                          <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                              <li class="breadcrumb-item active">wishlist</li>
                          </ol>
                      </nav>
                  </div>
              </div>
          </div>
      </div>
      <!-- breadcrumb End -->


      <!--section start-->
      <section class="wishlist-section section-b-space">
        @if (count($wishlists)>0)
          <div class="container">
              <div class="row">
                  <div class="col-sm-12 table-responsive-xs">
                   
                       
                      <table class="table cart-table">
                          <thead>
                              <tr class="table-head">
                                  <th scope="col">image</th>
                                  <th scope="col">product name</th>
                                  <th scope="col">price</th>
                                  <th scope="col">action</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach ($wishlists as $wishlist)
                               
                              <tr class="wishlist_row{{$wishlist->id}}">
                                  <td>
                                      <a href="{{ route('product.detail',$wishlist->product_id) }}"><img src="{{ asset('assets/backend/image/product/small/'.$wishlist->product->thumbnail) }}" alt=""></a>
                                  </td>
                                  <td><a href="{{ route('product.detail',$wishlist->product_id) }}">{{$wishlist->product->name}}</a>
                                      <div class="mobile-cart-content row">
                                          
                                          <div class="col">
                                              <h2 class="td-color">{{currency()}}{{number_format($wishlist->product->current_price,2)}}</h2>
                                          </div>
                                          <div class="col">
                                              <h2 class="td-color">
                                                <a href="javascript:void" class="icon me-1"><i class="ti-close delete_wishlist" data-action="{{ route('wishlist.delete') }}" wishlist_id="{{$wishlist->id}}"></i>
                                                  </a>
                                                  
                                              </h2>
                                          </div>
                                      </div>
                                  </td>
                                  <td>
                                      <h2>{{currency()}}{{number_format($wishlist->product->current_price,2)}}</h2>
                                  </td>
                                  
                                  <td><a href="javascript:void" class="icon me-3"><i class="ti-close delete_wishlist" data-action="{{ route('wishlist.delete') }}" wishlist_id="{{$wishlist->id}}"></i> </a>

                              </tr>

                               @endforeach
                          </tbody>
                          
                       
                      </table>
                  </div>
              </div>
              <div class="row wishlist-buttons">
                  <div class="col-12"><a href="{{ route('checkout') }}" class="btn btn-solid">continue shopping</a> <a href="{{ route('front.index') }}" class="btn btn-solid">check out</a></div>
              </div>

          </div>
          @else
          <h2 class="text-center">Empty Wishlist</h2>
          @endif
      </section>         
@endsection
