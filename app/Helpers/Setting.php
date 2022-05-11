<?php 


use App\Models\Admin\GeneralSetting;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Category;
use Illuminate\Support\Str;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


function site_name()
{
	$data=GeneralSetting::first();
	return $data->site_name;
}

function site_tite()
{
	$data=GeneralSetting::first();
	return $data->title;
}

function copyright()
{
	$data=GeneralSetting::first();
	return $data->copyright;
}

function shipping_charge()
{
	$data=GeneralSetting::first();
	return $data->shipping_charge;
}
function tax()
{
	$data=GeneralSetting::first();
	return $data->tax;
}


function logo()
{
	$data=GeneralSetting::first();
	return $data->logo;
}

function favicon()
{
	$data=GeneralSetting::first();
	return $data->favicon;
}


function currency()
{
	$data=GeneralSetting::first();
	return $data->currency;
}


function default_image()
{
	$data=GeneralSetting::first();
	return $data->default_image;
}


function company_address()
{
	$data=GeneralSetting::first();
	return $data->company_address;
}


function description()
{
	$data=GeneralSetting::first();
	return $data->description;
}


function company_phone()
{
	$data=GeneralSetting::first();
	return $data->company_phone;
}


function company_email()
{
	$data=GeneralSetting::first();
	return $data->company_email;
}


function brands()
{
	$brands=DB::table('brands')->orderBy('id','DESC')->get();
	return $brands;
}


function categories()
{
	$categories=Category::orderBy('id','DESC')->get();
	return $categories;
}

function carts()
{
    return Cart::carts();
}

function first_cart()
{
     return Cart::first_cart();
}

function total_item()
{
    return Cart::total_item();
}

function total_price()
{
    return Cart::total_price();
}

function sub_total()
{
	$data=GeneralSetting::first();
    $data->shipping_charge;
    $sub_price=Cart::total_price();
    if (Auth::check())
    {
       $cart=Cart::where('user_id',Auth::user()->id)->first();
    }else{
    	$ip=\Request::ip();
        $cart=Cart::where('ip_address',$ip)->first();    
    }
    if (!is_null($cart)) 
    {
    	if ($cart->coupon_id !=null) {
    		$coupon=Coupon::findOrFail($cart->coupon_id);
    		if ($coupon->type=="flat")
    		{
    			$total_remain=$sub_price-$coupon->discount;
    			return $total_remain;

    		}else{
    			$discount=($sub_price*$coupon->discount)/100;
    			$total_remain=$sub_price-$discount;
    			return $total_remain;
    		}
    	}else{
    		return $sub_price;
    	}
    }
	
}



function grand_total()
{
	$data=GeneralSetting::first();
    $data->shipping_charge;
    $total_price=Cart::total_price();
    if (Auth::check())
    {
       $cart=Cart::where('user_id',Auth::user()->id)->first();
    }else{
    	$ip=\Request::ip();
        $cart=Cart::where('ip_address',$ip)->first();    
    }
    if (!is_null($cart)) 
    {
    	if ($cart->coupon_id !=null) {
    		$coupon=Coupon::findOrFail($cart->coupon_id);
    		if ($coupon->type=="flat")
    		{
    			$total_remain=$total_price-$coupon->discount;
    			return $total_remain+$data->shipping_charge+$data->tax;

    		}else{
    			$discount=($total_price*$coupon->discount)/100;
    			$total_remain=$total_price-$discount;
    			return $total_remain+$data->shipping_charge+$data->tax;
    		}
    	}else{
    		return $total_price+$data->shipping_charge+$data->tax;
    	}
    }
	
}


