<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Admin\Stock;
class CartController extends Controller
{
    


    public function add_to_cart(Request $request)
    {


	    	if (Auth::check()) 
	    	{
	    		$cart=Cart::where('product_id','=',$request->product_id)
	    		->where('color',$request->color)
	    		->where('size',$request->size)
	    		->where('user_id',Auth::user()->id)->first();
	    	}else{
	    	   	
			   $cart=Cart::where('product_id','=',$request->product_id)
			     ->where('color',$request->color)
	    	   ->where('size',$request->size)
			     ->where('ip_address',$request->ip())->first();
	          }
	          if (is_null($cart)) {
	          	$cart            =new Cart();
	          	$cart->product_id=$request->product_id;
	          	$cart->size      =$request->size;
	          	$cart->color     =$request->color;
	          	$cart->quantity  =$request->quantity;
	          	if (Auth::check()) 
	          	{
	          		$cart->user_id=Auth::user()->id;
	          	}else
	          	{
	          		$cart->ip_address=$request->ip();
	          	}
	          	$cart->save();
	          }else
	          {
	          	$cart->increment('quantity');
	          }

	           $total_item=total_item();
	           $cart_items=$this->cart_items();
	          
	            $notification=['status'=>'200', 'type'=>'success','message'=>'Successfully added to cart','total_item'=>$total_item,'carts'=>$cart_items];
        

         echo json_encode($notification);
    }

    public function cart()
    {
    	$carts=Cart::carts();
    	$total_price=Cart::total_price();
    	return view('front.cart',compact('carts','total_price'));
    }


  

    public function cart_delete(Request $request)
    {


      
    	$cart=Cart::findOrFail($request->cart_id);
	    $cart->delete();
	   
    	$notification=['status'=>'200', 'type'=>'success','message'=>'Succeddfully deleted','total_item'=>total_item(),'carts'=>$this->cart_items(),'sub_total'=>currency().number_format(sub_total(),2),'grand_total'=>currency().number_format(grand_total(),2)];

    	echo json_encode($notification);
    }



    public  function cart_update(Request $request)
    {
    	
    			$cart=Cart::findOrFail($request->cart_id);
    			$cart->quantity=$request->quantity;
    			$cart->save();

    			$each_cart_price=$cart->quantity*$cart->product->current_price;

    			$notification=['status'=>'200', 'type'=>'success','message'=>'Succeddfully updated','sub_total'=>currency().number_format(sub_total(),2),'grand_total'=>grand_total(),'each_cart_price'=>currency().number_format($each_cart_price,2), 'carts'=>$this->cart_items()];
    		
    	    echo json_encode($notification);

    }





    public function grand_total()
    {
    	$total_price=Cart::total_price();
    	$grand_total=$total_price+shipping_charge()+tax();
    	return $grand_total;
    }


    private function cart_items()
    {
    	   $cart_items=carts();
    	   $total_price=sub_total();
           $setProduct='';
           if (count(carts())>0) {
             
       	    foreach ($cart_items as $cart) 
       	    {
                  $setProduct.='<li>
                                <div class="media">
                                    <a href="'.route('product.detail',$cart->product_id).'"><img alt="" class="me-3"
                                            src="'.asset('assets/backend/image/product/small/'.$cart->product->thumbnail).'" style="width:165px;height:140px"></a>
                                    <div class="media-body">
                                        <a href="'.route('product.detail',$cart->product_id).'">
                                            <h4>'.$cart->product->name.'</h4>
                                        </a>
                                        <h4><span>'.$cart->quantity.'x'.currency().number_format($cart->product->current_price,2).'</span></h4>
                                    </div>
                                </div>
                                <div class="close-circle"><a href="javascript:void"><i class="fa fa-times delete_cart"
                                            aria-hidden="true" cart_id="'.$cart->id.'" data-action="'.route('cart.delete').'></i></a></div>
                            </li>';

             }
           }
            else{
               return "<h4>Empty Cart</h4>";
            }

           return $setProduct;    


    }

}

                     

// <li>
//      <div class="total">
//          <h5>subtotal : <span>'.currency().number_format(sub_total(),2).'</span></h5>
//      </div>
//  </li>
//  <li>
//      <div class="buttons"><a href="'.route('view.cart').'" class="view-cart">view cart</a> <a href="'.route('checkout').'" class="checkout">checkout</a>
//      </div>
//  </li>