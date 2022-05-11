@extends('layouts.app')
@section('title','Order Placement')
@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/style/css/invoice.css') }}">
@endsection

@section('content')
    	   <div class="bg-gray-13 bg-md-transparent">
               <div class="container">
                   <!-- breadcrumb -->
                   <div class="my-md-3">
                       <nav aria-label="breadcrumb">
                           <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                               <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('front.index') }}">@lang('menu.home')</a></li>
                               <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Order placement</li>
                           </ol>
                       </nav>
                   </div>
                   <!-- End breadcrumb -->
               </div>
           </div>
           <!-- End breadcrumb -->

           <div class="container">
               <div class="mb-5">
                   
                   <div id="shopCartHeadingOne" class="alert alert-primary mb-0" role="alert">
                      Your Order has been place successfully
                       <a href="{{ route('front.index') }}" class="btn-upper btn btn-primary">Continue Shopping</a>
                  </div>
              </div>
                    

                  <div class="invoice-wrapper">
                       <div class="pl-lg-3 invoice-area">
                               <div class="brand-section bg-warning">
                                   <div class="row">
                                       <div class="col-6">
                                           <img src="{{ asset('assets/backend/image/11.png') }}" style="width: 150px">
                                       </div>
                                       <div class="col-6">
                                           <div class="company-details">
                                               <p class="text-white">{{company_address()}}</p>
                                               <p class="text-white">{{company_email()}}</p>
                                               <p class="text-white">{{company_phone()}}</p>
                                           </div>
                                       </div>
                                   </div>
                               </div>

                               <div class="body-section">
                                   <div class="row">
                                       <div class="col-6">
                                       
                                           <h2 class="heading">Order Number.: {{$order->order_number}}</h2>
                                           <p class="sub-heading">Order Date: {{date('d-m-Y',strtotime($order->created_at))}}</p>
                                           
                                       </div>
                                       <div class="col-6">
                                           <p class="sub-heading">Full Name: {{$order->billing->customer_name}} </p>
                                           <p class="sub-heading">Phone: {{$order->billing->phone}} </p>
                                           <p class="sub-heading">Phone Number:  {{$order->billing->customer_phone}}</p>

                                       </div>
                                   </div>
                               </div>

                               <div class="body-section">
                                   <h3 class="heading">Ordered Items</h3>
                                   <br>
                                   <table class="table-bordered">
                                       <thead>
                                       	
                                       		
                                           <tr>
                                               <th>Image</th>
                                               <th>Product</th>
                                               <th class="w-20">Price</th>
                                               <th class="w-20">Quantity</th>
                                               <th class="w-20">Total</th>
                                           </tr>
                                           	
                                       </thead>
                                       <tbody>
                                       @foreach ($orders as $item)
                                           <tr>
                                               <td><img src="{{ asset('assets/backend/image/product/small/'.$item->product->thumbnail)}}" style="width: 70px;height: 60px"></td>
                                               <td><span>{{$item->product->name}}</span><br></td>
                                                <td>{{currency().number_format($item->product->current_price,2)}}</td>
                                                <td>{{$item->product_quantity}}</td>
                                               <td>{{currency().number_format($item->product_quantity*$item->product->current_price,2)}}</td>
                                           </tr>
                                         @endforeach
                                           
                                           <tr>
                                               <td colspan="4" class="text-right">Sub Total</td>
                                               <td>{{currency().number_format($order->sub_total,2)}}</td>
                                           </tr>
                                           <tr>
                                               <td colspan="4" class="text-right">Tax Total</td>
                                               <td>{{currency().number_format($order->tax,2)}}</td>
                                           </tr>
                                           <tr>
                                               <td colspan="4" class="text-right">Shipping</td>
                                               <td>{{currency().number_format($order->shipping_charge,2)}}</td>
                                           </tr>
                                           <tr>
                                               <td colspan="4" class="text-right">Grand Total</td>
                                               <td>{{currency().number_format($order->grand_total,2)}}</td>
                                           </tr>
                                       </tbody>
                                   </table>
                                   <br>  
                                   <h3 class="heading">Payment Status: {{$order->payment->payment_name}}</h3>
                               </div>

                               <div class="body-section">
                                   <p style="padding: 15px 0px">{{copyright()}}
                                       <a href="#" class="float-right p-4">Lotus Online Shopping</a>
                                   </p>
                               </div>      
                        
                    </div>
                </div>
            </div>
@endsection
@section('js')
@endsection