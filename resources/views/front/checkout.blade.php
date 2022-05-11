@extends('layouts.app')
@section('title','Cutsomer | Order Checkout')

@section('content')


                <!-- section start -->
                <section class="section-b-space">
                    <div class="container">
                        <div class="checkout-page">
                            <div class="checkout-form">
                                <form action="{{ route('submit.checkout') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 col-xs-12">
                                            <div class="checkout-title">
                                                <h3>Billing Details</h3>
                                            </div>
                                            <div class="row check-out">
                                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                    <div class="field-label">Name</div>
                                                    <input type="text" name="name" value="{{Auth::user()->name}}" required="">
                                                </div>
                                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                    <div class="field-label">Email</div>
                                                    <input type="email" name="email" value="{{Auth::user()->email}}" required="">
                                                </div>
                                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                    <div class="field-label">Phone</div>
                                                    <input type="text" name="phone" value="{{Auth::user()->phone}}" required="">
                                                </div>
                                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                    <div class="field-label">Address</div>
                                                    <input type="text" name="address" value="{{Auth::user()->address}}" required="">
                                                </div>
                                                
                                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                    <div class="field-label">Order Note (optional)</div>
                                                    <input type="text" name="order_note" value="" placeholder="Say...">
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-xs-12">
                                            <div class="checkout-details">
                                                <div class="order-box">
                                                    <div class="title-box">
                                                        <div>Product <span>Total</span></div>
                                                    </div>
                                                    <ul class="qty">
                                                        @foreach (carts() as $cart)
                                                          
                                                        <li>{{$cart->product->name}} × {{$cart->quantity}} <span>{{currency()}}{{number_format($cart->product->current_price*$cart->quantity)}}</span></li>
                                                       @endforeach
                                                    </ul>
                                                    <ul class="sub-total">
                                                        <li>Subtotal <span class="count">{{currency()}}{{number_format(sub_total(),2)}}</span></li>
                                                        <li>Shipping
                                                            <div class="shipping">
                                                                <div class="shopping-option">
                                                                    <label for="free-shipping">{{currency()}}{{number_format(shipping_charge(),2)}}</label>
                                                                </div>
                                                                
                                                            </div>
                                                        </li>

                                                        <li>Tax
                                                            <div class="shipping">
                                                                <div class="shopping-option">
                                                                    <label for="free-shipping">{{currency()}}{{number_format(tax(),2)}}</label>
                                                                </div>
                                                                
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <ul class="total">
                                                        <li>Grand Total <span class="count">{{currency()}}{{number_format(grand_total(),2)}}</span></li>
                                                    </ul>
                                                </div>
                                                <div class="payment-box">
                                                    <div class="upper-box">
                                                        <div class="payment-options">
                                                            <ul>
                                                               
                                                    @foreach ($payments as $payment)
                                                     <li>
                                                        <div class="form-check">
                                                               <input class="form-check-input select_payment" type="radio" name="payment_id" value="{{$payment->id}}"  {{($payment->account_number==NULL) ? 'checked' : ''}} account_number="{{$payment->account_number}}">
                                                               <label class="form-check-label ml-3" style="padding-left: 12px">
                                                                    {{$payment->payment_name}}
                                                               </label>
                                                             </div>
                                                        </li>
                                                     @endforeach

                                                     <div id="payment_area" style="display: none">
                                                         <div class="col-lg-12 mb-20">
                                                             <div class="checkout-form-list">
                                                                <label>
                                                                     Account Number
                                                                    <span id="account_number"></span>
                                                                </label> <br>
                                                                 <label>Transaction number <span class="required">*</span></label><br>
                                                                 <input type="text" class="form-control" name="transaction_number" id="transaction_number" />
                                                             </div>
                                                         </div>
                                                     </div>

                                                               
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <button class="btn-solid btn" type="submit">Place Order</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
@endsection
@section('js')

<script>
    $(document).ready(function(){
        $('body').on('click','.select_payment',function(){
            let payment_id=$(this).val();
            let account_number=$(this).attr('account_number');

            if (account_number=="") {
                $('#account_number').text();
                $('#payment_area').hide();
                $('#transaction_number').removeAttr('required');
            }else{
                $('#account_number').text(account_number);
                $('#payment_area').show();
                $('#transaction_number').attr('required', 'true');
            }
        });

      
    });
</script>
@endsection