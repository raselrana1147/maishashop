@extends("layouts.admin")
@section("title","Admin | Order Invoice")
@section("breadcrumb","Order Invoice")
@section('css')
  <style>
    .my_table tr th ,.my_table tr td {
        border: none;
    }
  </style>
@endsection
@section("content")

<div class="page-title-box">
    <div class="row align-items-center">
       
        <div class="col-12">
            <div class="float-right d-none d-md-block">
                <div class="dropdown">
                    <a href="javascript:history.back();" class="btn btn-primary btn-icon float-right mb-2">
                         <span class="btn-icon-label"><i class="fas fa-arrow-left mr-2"></i></span>Back</a>
                </div>
            </div>
        </div>
    </div> <!-- end row -->
</div>
<!-- end page-title -->

<div class="row">
    <div class="col-12">
      <div c>
         <div class="card invoice_area">
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <div class="invoice-title">
                            <h4 class="mt-0 float-right font-16"><strong>Order # {{$order->order_number}}</strong></h4>
                            <div class="mb-4">
                                <img src="{{ asset('assets/backend/assets/images/logo-dark.png') }}" alt="logo" height="16"/>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <address>
                                    <strong>Company Detail:</strong><br>
                                   <span>Name: </span><span>TuTuni</span><br>
                                    114 Kazi Nazrul Avenue<br>
                                    Bangla Motor. Dhaka<br>
                                    1200
                                </address>
                            </div>
                            <div class="col-6 text-right">
                                <address>
                                    <strong>Shipped To:</strong><br>
                                    <span>Name</span> <span>{{$order->billing->customer_name}}</span><br>
                                    <span>Email</span> <span>{{$order->billing->customer_email}}</span><br>
                                    <span>Phone</span> <span>{{$order->billing->customer_phone}}</span><br>
                                   <span>Address</span> <span>{{$order->billing->customer_address}}</span><br>
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 m-t-30">
                                <address>
                                    <strong>Payment Method:</strong><br>
                                      {{$order->payment->payment_name}}<br>
                                    @if ($order->transaction_number !=null)
                                     Transaction number: {{$order->transaction_number}}
                                    @endif
                                </address>
                            </div>
                            <div class="col-6 m-t-30 text-right">
                                <address>
                                    <strong>Order Date:</strong><br>
                                    {{date("F d, Y", strtotime($order->created_at))}}<br><br>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div>
                            <div class="p-2">
                                <h3 class="font-16"><strong>Order summary</strong></h3>
                            </div>
                            <div class="">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <td><strong>Product Name</strong></td>
                                            <td class="text-center"><strong>Image</strong></td>
                                            <td class="text-center"><strong>Price</strong>
                                            </td>
                                            <td class="text-right"><strong>Quantity</strong></td>
                                             <td class="text-right"><strong>Size</strong></td>
                                            <td class="text-right"><strong>Color</strong></td>
                                            <td class="text-right"><strong>Total</strong></td>

                                        </tr>
                                        </thead>
                                        <tbody>
                                       @foreach ($order->order_detail as $order_detail)
                                        <tr>
                                            <td>{{$order_detail->product->name}}</td>
                                            <td class="text-center"><img src="{{ asset('assets/backend/image/product/small/'.$order_detail->product->thumbnail) }}" style="width: 80px;height: 50px"></td>
                                            <td class="text-center">{{currency()}} {{$order_detail->product->current_price}}</td>
                                            <td class="text-right">{{$order_detail->product_quantity}}</td>
                                            <td class="text-right">{{$order_detail->size !=null ? $order_detail->size : 'N\A'}}</td>
                                            <td class="text-right">{{$order_detail->color}} <span style="background: {{$order_detail->color}}; color:{{$order_detail->color !=null ? $order_detail->color : 'N\A' }}">color</span></td>
                                            <td class="text-right">{{currency()}} {{$order_detail->product->current_price*$order_detail->product_quantity}}</td>

                                        </tr>

                                        @endforeach
                                       
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="thick-line"></td>
                                            <td class="thick-line text-center">
                                                <strong>Subtotal</strong></td>
                                            <td class="thick-line text-right">{{currency()}} {{$order->sub_total}}</td>
                                        </tr>
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center">
                                                <strong>Shipping</strong></td>
                                            <td class="no-line text-right">{{currency()}} {{shipping_charge()}}</td>
                                        </tr>
                                         <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                           <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center">
                                                <strong>Tax</strong></td>
                                            <td class="no-line text-right">{{currency()}} {{tax()}}</td>
                                        </tr>

                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center">
                                                <strong>Grand Total</strong></td>
                                            <td class="no-line text-right">{{currency()}} {{$order->sub_total}}</td>
                                        </tr>
                                        
                                        </tbody>
                                    </table>
                                </div>

                                
                            </div>
                        </div>

                    </div>
                </div> <!-- end row -->

            </div>
        </div>
      </div>

      <div class="d-print-none">
          <div class="float-right">
              <a href="javascript:;" class="btn btn-success waves-effect waves-light make_invoice"><i class="fa fa-print"></i></a>
          </div>
      </div>
       
    </div> <!-- end col -->
</div>
<!-- end row -->

@endsection
@section('js')
  <script src="{{ asset('assets/backend/style/js/print.js') }}"></script>
 <script type="text/javascript"> 
     $(document).ready(function(){
          ////===========making printer ================
       $(".make_invoice").click(function(){
         
               var mode = 'iframe';
               var close = mode == "popup";
               var options = { mode : mode, popClose : close};
               $(".invoice_area").printArea( options );
           
       });
     });
 </script>
@endsection()