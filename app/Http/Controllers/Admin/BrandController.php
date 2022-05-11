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

class BrandController extends Controller
{
        public function __construct()
        {
            $this->middleware('auth:admin');
        }


        public function datatable()
        {
           $datas=Brand::orderBy('id','DESC')->get();
          
            return DataTables::of($datas)

             ->editColumn('image',function(Brand $data){

                      $url=$data->image ? asset("assets/backend/image/brand/small/".$data->image) 
                      :asset("assets/backend/image/default.png");
                      return '<img src='.$url.' border="0" width="120" height="50" class="img-rounded" />';      
              })
            ->editColumn('action',function(Brand $data){
                     return '<a href="'.route('admin.brand_edit',$data->id).'" class="btn btn-success btn-sm">
                      <i class="fa fa-edit"></i>
                      </a>
                       <a href="javascript:;" class="btn btn-danger btn-sm delete_item" data-action="'.route('admin.brand_delete').'"  item_id="'.$data->id.'">
                       <i class="fa fa-trash"></i>
                      </a>';
            })
           ->rawColumns(['image','action'])
            ->make(true);
        }


        public function index()
        {
        	return view('admin.brand.index');
        }

        public function edit($id)
        {
           $brand=Brand::findOrFail($id);
           return view('admin.brand.edit',compact("brand"));
        }

       public function create()
       {
       	 return view('admin.brand.create');
       }

       public function store(Request $request)
       {

       	$this->validate($request,[
       	       'brand_name'=>'unique:brands',
       	 ]);

          if ($request->isMethod('post'))
            {
                DB::beginTransaction();

                try{

                    //Brand create

                    $brand = new Brand();

                    $brand->brand_name = $request->brand_name;
                   
                    if($request->hasFile('image')){

                            $image=$request->image;
                      
                            $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                            $original_image_path = base_path().'/assets/backend/image/brand/original/'.$image_name;
                            $large_image_path = base_path().'/assets/backend/image/brand/large/'.$image_name;
                            $medium_image_path = base_path().'/assets/backend/image/brand/medium/'.$image_name;
                            $small_image_path = base_path().'/assets/backend/image/brand/small/'.$image_name;

                            //Resize Image
                            Image::make($image)->save($original_image_path);
                            Image::make($image)->resize(1920,680)->save($large_image_path);
                            Image::make($image)->resize(1000,529)->save($medium_image_path);
                            Image::make($image)->resize(140,150)->save($small_image_path);
                            $brand->image = $image_name;
                        
                    }

                    $brand->save();

                    DB::commit();

                    return \response()->json([
                        'message' => 'SubCategory Added Successful',
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
        
         $brand=Brand::findOrFail($request->id);
         $this->validate($request,[
              'brand_name'=>'unique:brands,brand_name,'.$brand->id,
          ]);


          if ($request->isMethod('post'))
            {
                DB::beginTransaction();

                try{

                    //brand 
                    $brand=Brand::findOrFail($request->id);
                    $brand->brand_name = $request->brand_name;
                  
            
                    if($request->hasFile('image')){

                            // delete current image

                          if (File::exists(base_path('/assets/backend/image/brand/small/'.$brand->image))) 
                            {
                              File::delete(base_path('/assets/backend/image/brand/small/'.$brand->image));
                            }
                            if (File::exists(base_path('/assets/backend/image/brand/medium/'.$brand->image))) 
                            {
                              File::delete(base_path('/assets/backend/image/brand/medium/'.$brand->image));
                            }

                            if (File::exists(base_path('/assets/backend/image/brand/large/'.$brand->image)))
                             {
                               File::delete(base_path('/assets/backend/image/brand/large/'.$brand->image));
                             }

                             if (File::exists(base_path('/assets/backend/image/brand/original/'.$brand->image)))
                             {
                                File::delete(base_path('/assets/backend/image/brand/original/'.$brand->image));
                             }
                            // upload new image
                            $image=$request->image;
                            $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                            $original_image_path = base_path().'/assets/backend/image/brand/original/'.$image_name;
                            $large_image_path = base_path().'/assets/backend/image/brand/large/'.$image_name;
                            $medium_image_path = base_path().'/assets/backend/image/brand/medium/'.$image_name;
                            $small_image_path = base_path().'/assets/backend/image/brand/small/'.$image_name;

                            //Resize Image
                            Image::make($image)->save($original_image_path);
                            Image::make($image)->resize(1920,680)->save($large_image_path);
                            Image::make($image)->resize(1000,529)->save($medium_image_path);
                             Image::make($image)->resize(140,150)->save($small_image_path);
                            $brand->image = $image_name;
                        
                    }

                    $brand->save();

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
