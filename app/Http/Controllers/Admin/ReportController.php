<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Admin\Order;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    

  public function __construct()
  {
    $this->middleware('auth:admin');
  }

    public function daily_report()
    {

    	 $dateS = new Carbon();
    	 $start=$dateS->format('Y-m-d')." 00:00:01";
    	 $to=$dateS->format('Y-m-d')." 23:59:59";
         

	      $orders = DB::table('orders')
	     ->join('payments','orders.payment_id','=','payments.id')
	     ->select('orders.*','payments.payment_name as payment_name')
	     ->where('orders.created_at',Carbon::today())
	     ->where('orders.status','delivered')
	     ->get();



    	    $total_pro_amount = DB::table('orders')
    	    ->where('status','delivered')
    	    ->whereBetween('orders.created_at', [$start,$to])
    	    ->get()->sum('sub_total');

    	    $total_orders = DB::table('orders')
    	    ->where('status','delivered')
    	   ->whereBetween('orders.created_at', [$start,$to])
            ->count();

    	    $total_quantity = DB::table('orders')
    	    ->where('status','delivered')
    	    ->whereBetween('orders.created_at', [$start,$to])
    	    ->get()->sum('quantity');

 
    	return view('admin.report.daily_report',compact('orders','total_pro_amount','total_orders','total_quantity'));
    }


    public function weekly_report()
    {

    	    $dateS =Carbon::today();
    	    $start=$dateS->format('Y-m-d')." 23:59:59";
    	    $to=$dateS->subDays(7)->format('Y-m-d')." 00:00:01";

    	  //  return $to;

    	     $orders = DB::table('orders')
		     ->join('payments','orders.payment_id','=','payments.id')
		     ->select('orders.*','payments.payment_name as payment_name')
		     ->whereBetween('orders.created_at', [$to,$start])
		     ->where('orders.status','delivered')
		     ->get();

    	    $total_pro_amount = DB::table('orders')
    	        ->where('status','delivered')
    	        ->whereBetween('created_at', [$to,$start])
    	        ->get()->sum('sub_total');

    	    $total_orders = DB::table('orders')
    	        ->where('status','delivered')
    	        ->whereBetween('created_at', [$to,$start])->count();

    	    $total_quantity = DB::table('orders')
    	        ->where('status','delivered')
    	        ->whereBetween('created_at', [$to,$start])
    	        ->get()->sum('quantity');

    	return view('admin.report.weekly_report',compact('orders','total_pro_amount','total_orders','total_quantity'));
    }

    public function monthly_report()
    {

    	    $dateS =Carbon::today();
    	    $start=$dateS->format('Y-m-d')." 23:59:59";
    	    $to=$dateS->subDays(30)->format('Y-m-d')." 00:00:01";

    	  //  return $to;

       	     $orders = DB::table('orders')
   		     ->join('payments','orders.payment_id','=','payments.id')
   		     ->select('orders.*','payments.payment_name as payment_name')
   		     ->whereBetween('orders.created_at', [$to,$start])
   		     ->where('orders.status','delivered')
   		     ->get();

    	    $total_pro_amount = DB::table('orders')
    	        ->where('status','delivered')
    	        ->whereBetween('created_at', [$to,$start])
    	        ->get()->sum('sub_total');

    	    $total_orders = DB::table('orders')
    	        ->where('status','delivered')
    	        ->whereBetween('created_at', [$to,$start])->count();

    	    $total_quantity = DB::table('orders')
    	        ->where('status','delivered')
    	        ->whereBetween('created_at', [$to,$start])
    	        ->get()->sum('quantity');

    	return view('admin.report.monthly_report',compact('orders','total_pro_amount','total_orders','total_quantity'));
    }


    public function custom_report()
    {
    	  $orders=null;
    	  return view('admin.report.custom_report',compact('orders'));
    }


    public function generate_report(Request $request)
    {

    	$this->validate($request,[
    	    'start_date'=>'required',
    	    'end_date'=>'required'
    	]);

    
    	$start=date('Y-m-d',strtotime($request->start_date));
    	$to=date('Y-m-d',strtotime($request->end_date));

    	     $orders = DB::table('orders')
		     ->join('payments','orders.payment_id','=','payments.id')
		     ->select('orders.*','payments.payment_name as payment_name')
		     ->whereIn('orders.created_at', [$to,$start])
		     ->where('orders.status','delivered')
		     ->get();


    	    $total_pro_amount = DB::table('orders')
    	        ->where('status','delivered')
    	        ->whereBetween('created_at', [$to,$start])
    	        ->get()->sum('sub_total');

    	    $total_orders = DB::table('orders')
    	        ->where('status','delivered')
    	        ->whereBetween('created_at', [$to,$start])->count();

    	    $total_quantity = DB::table('orders')
    	        ->where('status','delivered')
    	        ->whereBetween('created_at', [$to,$start])
    	        ->get()->sum('quantity');
    	
    	  return view('admin.report.custom_report',compact('orders','total_pro_amount','total_orders','total_quantity'));

    }
}
