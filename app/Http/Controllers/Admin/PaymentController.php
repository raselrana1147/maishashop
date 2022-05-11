<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Image;
use Illuminate\Database\QueryException;
use App\Models\Admin\SubCategory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
use App\Models\Admin\Brand;
use App\Models\Admin\Payment;

class PaymentController extends Controller
{
    
      public function __construct()
        {
            $this->middleware('auth:admin');
        }


        public function datatable()
        {
           $datas=Payment::orderBy('id','DESC')->get();
          
            return DataTables::of($datas)

             ->editColumn('image',function(Payment $data){

                      $url=$data->image ? asset("assets/backend/image/payment/small/".$data->image) 
                      :asset("assets/backend/image/".default_image());
                      return '<img src='.$url.' border="0" width="120" height="50" class="img-rounded" />';      
              })
            ->editColumn('action',function(Payment $data){
                     return '<a href="'.route('admin.payment_edit',$data->id).'" class="btn btn-success btn-sm">
                      <i class="fa fa-edit"></i>
                      </a>
                       <a href="javascript:;" class="btn btn-danger btn-sm delete_item" data-action="'.route('admin.payment_delete').'"  item_id="'.$data->id.'">
                       <i class="fa fa-trash"></i>
                      </a>';
            })
           ->rawColumns(['image','action'])
            ->make(true);
        }


        public function index()
        {
        	return view('admin.payment.index');
        }

        public function edit($id)
        {
           $payment=Payment::findOrFail($id);
           return view('admin.payment.edit',compact("payment"));
        }

       public function create()
       {
       	 return view('admin.payment.create');
       }

       public function store(Request $request)
       {

       	$this->validate($request,[
       	       'payment_name'=>'unique:payments',
       	 ]);

          if ($request->isMethod('post'))
            {
                DB::beginTransaction();

                try{

                    //Payment method create

                    $payment = new Payment();

                    $payment->payment_name = $request->payment_name;
                    $payment->account_number = $request->account_number;
                    $payment->ref_number = $request->ref_number;

                   
                    if($request->hasFile('image')){

                            $image=$request->image;
                      
                            $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                            $original_image_path = base_path().'/assets/backend/image/payment/original/'.$image_name;
                            $large_image_path = base_path().'/assets/backend/image/payment/large/'.$image_name;
                            $medium_image_path = base_path().'/assets/backend/image/payment/medium/'.$image_name;
                            $small_image_path = base_path().'/assets/backend/image/payment/small/'.$image_name;

                            //Resize Image
                            Image::make($image)->save($original_image_path);
                            Image::make($image)->resize(1920,980)->save($large_image_path);
                            Image::make($image)->resize(1000,850)->save($medium_image_path);
                            Image::make($image)->resize(465,465)->save($small_image_path);
                            $payment->image = $image_name;
                        
                    }

                    $payment->save();

                    DB::commit();

                    return \response()->json([
                        'message' => 'Successfully added',
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


       public function update(Request $request)
       {
        
         $payment=Payment::findOrFail($request->id);
         $this->validate($request,[
              'payment_name'=>'unique:payments,payment_name,'.$payment->id,
          ]);


          if ($request->isMethod('post'))
            {
                DB::beginTransaction();

                try{

                    //brand 
                   
                  $payment->payment_name = $request->payment_name;
                  $payment->account_number = $request->account_number;
                  $payment->ref_number = $request->ref_number;

                  
            
                    if($request->hasFile('image')){

                            // delete current image

                          if (File::exists(base_path('/assets/backend/image/payment/small/'.$payment->image))) 
                            {
                              File::delete(base_path('/assets/backend/image/payment/small/'.$payment->image));
                            }
                            if (File::exists(base_path('/assets/backend/image/payment/medium/'.$payment->image))) 
                            {
                              File::delete(base_path('/assets/backend/image/payment/medium/'.$payment->image));
                            }

                            if (File::exists(base_path('/assets/backend/image/payment/large/'.$payment->image)))
                             {
                               File::delete(base_path('/assets/backend/image/payment/large/'.$payment->image));
                             }

                             if (File::exists(base_path('/assets/backend/image/payment/original/'.$payment->image)))
                             {
                                File::delete(base_path('/assets/backend/image/payment/original/'.$payment->image));
                             }
                            // upload new image
                            $image=$request->image;
                            $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                            $original_image_path = base_path().'/assets/backend/image/payment/original/'.$image_name;
                            $large_image_path = base_path().'/assets/backend/image/payment/large/'.$image_name;
                            $medium_image_path = base_path().'/assets/backend/image/payment/medium/'.$image_name;
                            $small_image_path = base_path().'/assets/backend/image/payment/small/'.$image_name;

                            //Resize Image
                            Image::make($image)->save($original_image_path);
                            Image::make($image)->resize(1920,980)->save($large_image_path);
                            Image::make($image)->resize(1000,850)->save($medium_image_path);
                            Image::make($image)->resize(465,465)->save($small_image_path);
                            $payment->image = $image_name;
                        
                    }

                    $payment->save();

                    DB::commit();

                    return \response()->json([
                        'message' => 'Successful Updated',
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

        $data=Brand::findOrFail($request->item_id);

        if (File::exists(base_path('/assets/backend/image/brand/small/'.$data->image))) 
          {
            File::delete(base_path('/assets/backend/image/brand/small/'.$data->image));
          }
          if (File::exists(base_path('/assets/backend/image/brand/medium/'.$data->image))) 
          {
            File::delete(base_path('/assets/backend/image/brand/medium/'.$data->image));
          }

          if (File::exists(base_path('/assets/backend/image/brand/large/'.$data->image)))
           {
             File::delete(base_path('/assets/backend/image/brand/large/'.$data->image));
           }

           if (File::exists(base_path('/assets/backend/image/brand/original/'.$data->image)))
           {
              File::delete(base_path('/assets/backend/image/brand/original/'.$data->image));
           }
        $data->delete();
        $notification=['alert'=>'success','message'=>'Successfully Delete','status'=>200];

        return \response()->json([
            'message' => 'Sub Category Delete Successfully',
            'status_code' => 200
        ], Response::HTTP_OK);

       }
}
