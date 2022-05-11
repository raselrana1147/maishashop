<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin\Order;
use App\Models\Admin\OrderDetail;
use App\Models\Admin\Stock;

class OderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatable()
    {

    	$datas=Order::orderBy('id','DESC')->get();
    	
    	 return DataTables::of($datas)
    	 ->editColumn('sub_total',function(Order $data){
    	          return currency().' '.number_format($data->sub_total, 2);
    	 })
    	 ->editColumn('grand_total',function(Order $data){
    	          return currency().' '.number_format($data->grand_total, 2);
    	 })
    	 ->editColumn('order_at',function(Order $data){
    	          return date('Y-m-d H:m',strtotime($data->created_at));
    	 })
         ->editColumn('status',function(Order $data){
                    $pending = $data->status == 'pending' ? 'selected' : '';
                    $processing = $data->status == 'processing' ? 'selected' : '';
                    $confirmed = $data->status == 'confirmed' ? 'selected' : '';
                    $delivered = $data->status == 'delivered' ? 'selected' : '';
                    $declined = $data->status == 'declined' ? 'selected' : '';

                  return '<select class="form-control order_status" order_id="'.$data->id.'" data-action="'.route('admin.order_status_change').'">

                         <option value="pending" '.$pending.' >pending</option>
                         <option value="processing" '.$processing.' >processing</option>
                         <option value="confirmed" '.$confirmed.' >confirmed</option>
                         <option value="delivered" '.$delivered.' >delivered</option>
                         <option value="declined" '.$declined.' >declined</option>
                    </select>';
         })
    	 ->editColumn('action',function(Order $data){
    	          return '<a href="'.route('admin.order_detail',$data->id).'" class="btn btn-success btn-sm">
    	           Detail
    	           </a>
    	            <a href="'.route('admin.order_invoice',$data->id).'" class="btn btn-dark btn-sm">
    	            <i class="fa fa-dark"></i>
    	            Invoice
    	           </a>';
    	 })
    	->rawColumns(['status','action'])
    	 ->make(true);
    }

    public function index()
    {
    	return view('admin.order.index');
    }

    public function order_detail($id)
    {
    	$order=Order::findOrFail($id);
    	return view('admin.order.detail',compact('order'));
    }

     public function invoice($id)
    {
        $order=Order::findOrFail($id);
        return view('admin.order.invoice',compact('order'));
    }


    public function status_change(Request $request){

                $order=Order::findOrFail($request->order_id);
                $order->status=$request->status;
                $order->save();

               
             
              return \response()->json([
                  'message' => ' Successfully updated',
                  'status_code' => 200
              ], Response::HTTP_OK);
               
        }
}
