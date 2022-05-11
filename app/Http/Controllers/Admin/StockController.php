<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Models\Admin\Color;
use App\Models\Admin\Product;
use App\Models\Admin\Stock;
use App\Models\Admin\Size;

class StockController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index($id)
    {
    	$stocks=Stock::where('product_id',$id)->get();
    	$colors=Color::latest()->get();
    	$sizes=Size::latest()->get();
    	$product=Product::findOrFail($id);
    	return view('admin.stock.index',compact('stocks','product','sizes','colors'));
    }

    public function edit($id)
    {
            $stock=Stock::findOrFail($id);
         	$colors=Color::latest()->get();
         	$sizes=Size::latest()->get();
         	return view('admin.stock.edit',compact('stock','sizes','colors'));
    }

   public function create()
   {
   	 return view('admin.brand.create');
   }

   public function store(Request $request)
   {

      if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //Stock add

                $check_color=Stock::where([
                	'color_id'=>$request->color_id,
                	'size_id'=>$request->size_id,
                	'product_id'=>$request->product_id,
                ])->first();
                if (is_null($check_color)) 
                {
                	$stock = new Stock();

	               	$stock->product_id=$request->product_id;
	               	$stock->size_id=$request->size_id;
	               	$stock->color_id=$request->color_id;
	               	$stock->quantity=$request->quantity;

	                $stock->save();

	                DB::commit();

	                return \response()->json([
	                    'message' => 'Successfully added',
	                    'type'=>'success',
	                    'status_code' => 200
	                ], Response::HTTP_OK);
                }else
                {
                	return \response()->json([
                    'message' => 'This stock is already recorded',
                    'type'=>'error',
                    'status_code' => 200
                   ],Response::HTTP_OK);
                }

            }catch (QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return \response()->json([
                    'error' => $error,
                    'status_code' => 500
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

   }


   public function update(Request $request)
   {
    

      if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

	        	$stock =Stock::findOrFail($request->id);
	           	$stock->size_id=$request->size_id;
	           	$stock->color_id=$request->color_id;
	           	$stock->quantity=$request->quantity;
	            $stock->save();
                DB::commit();
                return \response()->json([
                    'message' => 'Successfully Updated',
                    'status_code' => 200
                ], Response::HTTP_OK);

            }catch (QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return \response()->json([
                    'error' => $error,
                    'status_code' => 500
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
   }

   
   public function delete(Request $request)
   {

    $data=Stock::findOrFail($request->item_id);
    $data->delete();
    $notification=['alert'=>'success','message'=>'Successfully Delete','status'=>200];

    return \response()->json([
        'message' => 'Successfully Deleted',
        'status_code' => 200
    ], Response::HTTP_OK);

   }
}
