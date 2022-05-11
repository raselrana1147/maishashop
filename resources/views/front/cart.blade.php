@extends('layouts.app')
@section('title','Ecommerce | Cart View')

@section('content')
          <!-- breadcrumb start -->
          <div class="breadcrumb-section">
              <div class="container">
                  <div class="row">
                      <div class="col-sm-6">
                          <div class="page-title">
                              <h2>cart</h2>
                          </div>
                      </div>
                      <div class="col-sm-6">
                          <nav aria-label="breadcrumb" class="theme-breadcrumb">
                              <ol class="breadcrumb">
                                  <li class="breadcrumb-item"><a href="{{ route('front.index') }}">Home</a></li>
                                  <li class="breadcrumb-item active">cart</li>
                              </ol>
                          </nav>
                      </div>
                  </div>
              </div>
          </div>
          <!-- breadcrumb End -->


          <!--section start-->
          <section class="cart-section section-b-space">
            @if (count(carts())>0)
              <div class="container empty_cart">
                  <div class="row">
                      
                      <div class="col-sm-12 table-responsive-xs">
                          <table class="table cart-table">
                              <thead>
                                  <tr class="table-head">
                                      <th scope="col">image</th>
                                      <th scope="col">product name</th>
                                      <th scope="col">price</th>
                                      <th scope="col">quantity</th>
                                      <th scope="col">action</th>
                                      <th scope="col">total</th>
                                  </tr>
                              </thead>
                              <tbody>


                                @foreach (carts() as $cart)
                                    
                                  <tr class="cart_row{{$cart->id}}">
                                      <td>
                                          <a href="{{ route('product.detail',$cart->product_id) }}"><img src="{{ asset('assets/backend/image/product/small/'.$cart->product->thumbnail) }}" alt=""></a>
                                      </td>
                                      <td><a href="{{ route('product.detail',$cart->product_id) }}">{{ $cart->product->name }}</a>
                                          <div class="mobile-cart-content row">
                                              <div class="col">
                                                  <div class="qty-box">
                                                      <div class="input-group">
                                                          <input type="number" name="quantity" class="form-control input-number"
                                                              value="{{ $cart->quantity }}" min="1">
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col">
                                                  <h2 class="td-color">{{currency()}}{{ number_format($cart->product->current_price,2) }}</h2>
                                              </div>
                                              <div class="col">
                                                  <h2 class="td-color"><a href="javascript:void" class="icon"><i class="ti-close delete_cart" cart_id="{{$cart->id}}" data-action="{{ route('cart.delete') }}"></i></a>
                                                  </h2>
                                              </div>
                                          </div>
                                      </td>
                                      <td>
                                          <h2>{{currency()}}{{ number_format($cart->product->current_price,2) }}</h2>
                                      </td>
                                      <td>
                                          <div class="qty-box">
                                              <div class="input-group">
                                                  <input type="number" name="quantity" class="form-control input-number cart-product-quantity" value="{{ $cart->quantity }}" min="1" cart_id="{{$cart->id}}" product_id="{{$cart->product_id}}" data-action="{{ route('cart.update') }}">
                                              </div>
                                          </div>
                                      </td>
                                      <td><a href="javascript:;" class="icon"><i class="ti-close delete_cart" cart_id="{{$cart->id}}" data-action="{{ route('cart.delete') }}"></i></a></td>
                                      <td>
                                          <h2 class="td-color each_cart_price{{$cart->id}}">{{currency()}}{{ number_format($cart->quantity*$cart->product->current_price,2) }}</h2>
                                      </td>
                                  </tr>
                                  @endforeach
                              </tbody>
                             
                          </table>
                          <div class="table-responsive-md">
                              <table class="table cart-table ">
                                  <tfoot>
                                      <tr>
                                          <td>total price :</td>
                                          <td>
                                              <h2 class="sub_total">{{currency()}}{{number_format(sub_total(),2)}}</h2>
                                          </td>
                                      </tr>
                                  </tfoot>
                              </table>
                          </div>
                      </div>
                  </div>
                  <div class="row cart-buttons">
                      <div class="col-6"><a href="{{ route('front.index') }}" class="btn btn-solid">continue shopping</a></div>
                      <div class="col-6"><a href="{{ route('checkout') }}" class="btn btn-solid">check out</a></div>
                  </div>
              </div>
              @else 
              <h2 class="text-center">Empty Cart</h2>
              @endif
          </section>      
@endsection
@section('js')
@endsection