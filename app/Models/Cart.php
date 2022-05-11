<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Product;
use App\Models\Admin\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory;
    protected $guarded=[];


      public function product()
      {
    	return $this->belongsTo(Product::class);
      }

    
      public function coupon()
      {
         return $this->belongsTo(Coupon::class);
      }

    public static function total_item(){
    	 

    	$cart_item=0;
    	if (Auth::check()) {

   	      	$cart_item=Cart::where('user_id',Auth::user()->id)->count();
   	        return $cart_item;
    	}else
    	{
    		$ip=\Request::ip();
   	      	$cart_item=Cart::where('ip_address',$ip)->count();
   	        return $cart_item;
    	}

   }


    public static function total_price(){
    	$total_price=0;
    	if (Auth::check()) 
    	{
   	  	 $carts=Cart::where('user_id',Auth::user()->id)->get();
   	  	 foreach($carts as $cart)
   	  	 {
   	  	 	$total_price+=$cart->product->current_price*$cart->quantity;
   	  	 }
      }else
      {
      	  $ip=\Request::ip();
	      $carts=Cart::where('ip_address',$ip)->get();	
	      foreach($carts as $cart)
	      {
	      	$total_price+=$cart->product->current_price*$cart->quantity;
	      }
      }

   	  return $total_price;
   }

    public static function carts()
    {
    	$carts=null;
	    if (Auth::check()) 
	    { 
	   	  $carts=Cart::where('user_id',Auth::user()->id)->get();
	    }
	    else
	    {
	      $ip=\Request::ip();
	      $carts=Cart::where('ip_address',$ip)->get();	     
	    }

      return $carts;
   }


}
