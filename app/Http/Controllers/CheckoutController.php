<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Payment;
use App\Models\Admin\Order;
use App\Models\Admin\OrderDetail;
use App\Models\Admin\PaymentDetail;
use App\Models\Admin\BillingDetail;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    

	public function __construct()
	{
	    $this->middleware('auth');
	}

    public function checkout()
    {
    	$carts=Cart::carts();
    	$total_price=Cart::total_price();
    	$payments=DB::table('payments')->orderBy('id','DESC')->get();
    	return view('front.checkout',compact("carts","total_price","payments"));
    }

    public function submit_checkout(Request $request)
    {

    	  //return dd($request->all());

    		$customer_name=$request->name;
    		$customer_phone=$request->phone;
    		$customer_email=$request->email;
    		$customer_address=$request->address;
    		$order_note=$request->order_note;
    		$payment_id        =$request->payment_id;

    		$transaction_number     =$request->transaction_number;
    		$order_number=rand(10000,99999);
    		$carts=carts();
    		$sub_total=sub_total();
    		$total_item=total_item();

    		//inser Order table
    		$order              =new Order();
    		$order->user_id     =Auth::user()->id;
    		$order->quantity    =$total_item;
    		$order->amount      =$sub_total;
            $order->payment_id  =$payment_id;
            $order->transaction_number=$transaction_number;
    		$order->tax         =tax();
    		$order->shipping_charge =shipping_charge();
    		$order->sub_total   =$sub_total;
    		$order->grand_total =tax()+shipping_charge()+$sub_total;
    		$order->order_number=$order_number;

    		if (!empty($request->order_note)) {
    			$order->order_note=$request->order_note;
    		}
    		 $order->save();
    		foreach ($carts as $cart) {
    			//insert into Order Details
    			$order_detail                  =new OrderDetail();
    			$order_detail->order_id        =$order->id;
    			$order_detail->product_id      =$cart->product_id;
    			$order_detail->user_id         =Auth::user()->id;
    			$order_detail->size    	       =$cart->size;
    		    $order_detail->color   	       =$cart->color;
    			$order_detail->product_quantity=$cart->quantity;
    			$order_detail->save();
    	
    		}
    	 // insert data into billing details table
    		$billing_detail=new BillingDetail();
    		$billing_detail->user_id=Auth::user()->id;
    		$billing_detail->order_id=$order->id;
    		$billing_detail->customer_name=$customer_name;
    		$billing_detail->customer_email=$customer_email;
    		$billing_detail->customer_phone=$customer_phone;
    		$billing_detail->customer_address=$customer_address;
   
    		$billing_detail->save();

    		foreach ($carts as $c) {
    			$c->delete();
    		}
    		
            $orders=OrderDetail::where('order_id',$order->id)->get();
            return view('front.checkout_success',compact('orders','order'));
    

    }


    public function success_checkout()
    {
    	return view('front.checkout_success');
    }
}
