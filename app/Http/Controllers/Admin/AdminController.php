<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Order;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;
use App\Models\Admin\Brand;

class AdminController extends Controller
{
    

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
    	$orders        =DB::table('orders')->orderBy('id','DESC')->get();
    	$products      =DB::table('products')->count();
    	$categories    =DB::table('categories')->count();
    	$sub_categories=DB::table('sub_categories')->count();
    	$brands        =DB::table('brands')->count();

    	$orders_pie= DB::table('orders')
    	->select('*', DB::raw('count(*) as total'))
    	->groupBy('status')
    	->get();



    	 $months = Order::select('*',
    	             DB::raw('sum(grand_total) as sums'),
    	             DB::raw('count(*) as total'),
    	             DB::raw("DATE_FORMAT(created_at,'%M') as months"),
    	             DB::raw("DATE_FORMAT(created_at,'%m') as monthKey"),
    	            DB::raw("DATE_FORMAT(created_at,'%Y') as Year")
    	         )
    	         ->groupBy('Year','months','monthKey')
    	         ->orderBy('created_at', 'ASC')
    	         ->whereYear('created_at', date('Y'))
    	         ->get();
    	 $month_salling = [0,0,0,0,0,0,0,0,0,0,0,0];

    	 foreach($months as $order){
    	     $month_salling[$order->monthKey-1] = $order->sums;
    	 }

    	$new_orders=DB::table('orders')->orderBy('id','DESC')->take(5)->get();
        $new_products=DB::table('products')->orderBy('id','DESC')->take(5)->get();
        $new_products=DB::table('products')->orderBy('id','DESC')->take(5)->get();
        $new_brands=DB::table('brands')->orderBy('id','DESC')->take(5)->get();
        $new_categories=DB::table('categories')->orderBy('id','DESC')->take(5)->get();
        $flash_deals=Product::where(['flash_deal'=>0])->orderBy('id','DESC')->get();
    	


    	return view("admin.index",compact('orders','products','categories','sub_categories','brands','orders_pie','month_salling','new_orders','new_products','new_brands','new_categories','flash_deals'));
    }
}