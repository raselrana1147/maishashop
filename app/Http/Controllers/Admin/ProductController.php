<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Admin\Brand;
use App\Models\Admin\ProductType;
use App\Models\Admin\SubCategory;
use App\Models\Admin\ChildCategory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
use App\Models\Admin\Product;
use Illuminate\Support\Facades\Auth;
use Validator;
use Image;


class ProductController extends Controller
{
    
    public function __construct()
        {
            $this->middleware('auth:admin');
        }


        public function datatable()
        {
           $datas=Product::orderBy('id','DESC')->get();
          
            return DataTables::of($datas)

             ->editColumn('thumbnail',function(Product $data){

                      $url=$data->thumbnail ? asset("assets/backend/image/product/small/".$data->thumbnail) 
                      :asset("assets/backend/image/default.png");
                      return '<img src='.$url.' border="0" width="120" height="50" class="img-rounded" />';      
              })

             ->editColumn('attribute',function(Product $data){
                     return '<div class="btn-group btn-group-medium" role="group" aria-label="Basic example">
                                  <a href="'.route('admin.gallery_list',$data->id).'" class="btn btn-dark btn-icon">
                                      <span class="btn-icon-label"><i class="fas fa-file-image mr-2"></i></span> Gallery
                                  </a>
                                
                                  <a href="javascript:void(0)" data-target="#myModal" data-toggle="modal" class="btn btn-dark btn-icon show_product_status" data-action="'.route('admin.show_product_status').'" product_id="'.$data->id.'">
                                      <span class="btn-icon-label"><i class="mdi mdi-check-all mr-2"></i></span> Status
                                  </a>
                                  <a href="'.route('product.detail',$data->id).'" class="btn btn-dark btn-icon">
                                      <span class="btn-icon-label"><i class="fas fa-street-view mr-2"></i></span> View
                                  </a>
                                  
                           </div>';

                            // <button id="copybutton" data-clipboard-target="#copydescription" class="btn btn-info">Copy content</button>
            })
            ->editColumn('action',function(Product $data){
                     return '<a href="'.route('admin.product_edit',$data->id).'" class="btn btn-success btn-sm">
                      <i class="fa fa-edit"></i>
                      </a>
                       <a href="javascript:;" class="btn btn-danger btn-sm delete_item" data-action="'.route('admin.product_delete').'"  item_id="'.$data->id.'">
                       <i class="fa fa-trash"></i>
                      ';
            })
           ->rawColumns(['thumbnail','attribute','action'])
            ->make(true);
        }


        public function index()
        {
        	return view('admin.product.index');
        }

        public function edit($id)
        {
           $categories=Category::latest()->get();
           $brands=Brand::latest()->get();
           $producttypes=ProductType::latest()->get();
           $product=Product::findOrFail($id);
           return view('admin.product.edit',compact("product","categories","brands","producttypes"));
        }

       public function create()
       {
       	 $categories=Category::latest()->get();
       	 $brands=Brand::latest()->get();
       	 $producttypes=ProductType::latest()->get();
       	 return view('admin.product.create',compact('categories','brands','producttypes'));
        }

       public function store(Request $request)
       {



          if ($request->isMethod('post'))
            {
                DB::beginTransaction();

                try{

                    //Product create

                    $product = new Product();

                    $product->name              = $request->name;
                    $product->detail            = $request->detail;
                    $product->category_id       = $request->category_id;
                    $product->sub_category_id   = $request->sub_category_id;
                    $product->child_category_id = $request->child_category_id;
                    $product->product_type_id   = $request->product_type_id;
                    $product->brand_id          = $request->brand_id;
                    $product->previous_price    = $request->privious_price;
                    $product->current_price     = $request->current_price;
                    $product->discount          = $request->discount;
                    $product->description       = $request->description;
                    $product->specification     = $request->specification;
                    $product->return_policy     = $request->return_policy;
                    $product->author_id         = Auth::user()->id;

                    if (count($request->sizes)>0) 
                    {
                      $product->size = json_encode($request->sizes);
                    }


                    if (count($request->colors)>0) 
                    {
                      $product->color = json_encode($request->colors);
                    }

                   
                    if($request->hasFile('thumbnail')){

                            $image=$request->thumbnail;
                      
                            $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                            $original_image_path = base_path().'/assets/backend/image/product/original/'.$image_name;
                            $large_image_path = base_path().'/assets/backend/image/product/large/'.$image_name;
                            $medium_image_path = base_path().'/assets/backend/image/product/medium/'.$image_name;
                            $small_image_path = base_path().'/assets/backend/image/product/small/'.$image_name;

                            //Resize Image
                            Image::make($image)->save($original_image_path);
                            Image::make($image)->resize(1920,1000)->save($large_image_path);
                            Image::make($image)->resize(850,950)->save($medium_image_path);
                            Image::make($image)->resize(465,465)->save($small_image_path);
                            $product->thumbnail = $image_name;
                        
                    }

	                    $product->save();

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
        
          if ($request->isMethod('post'))
            {
                DB::beginTransaction();

                try{
                   //Product create

                    
                   $product =Product::findOrFail($request->id);
                   $product->name              = $request->name;
                   $product->detail             = $request->detail;

                   $product->category_id= $request->category_id;
                   $product->sub_category_id   = $request->sub_category_id;
                   $product->child_category_id = $request->child_category_id;
                   

                   $product->product_type_id   = $request->product_type_id;
                   $product->brand_id          = $request->brand_id;
                   $product->previous_price    = $request->previous_price;
                   $product->current_price     = $request->current_price;
                   $product->discount          = $request->discount;
                   $product->description       = $request->description;
                   $product->specification     = $request->specification;
                   $product->return_policy     = $request->return_policy;
                   $product->author_id         = Auth::user()->id;

                   if (count($request->sizes)>0) 
                   {
                     $product->size = json_encode($request->sizes);
                   }


                   if (count($request->colors)>0) 
                   {
                     $product->color = json_encode($request->colors);
                   }

                  
                   if($request->hasFile('thumbnail')){

                           $image=$request->thumbnail;

                           if (File::exists(base_path('/assets/backend/image/product/small/'.$product->thumbnail))) 
                             {
                               File::delete(base_path('/assets/backend/image/product/small/'.$product->thumbnail));
                             }
                             if (File::exists(base_path('/assets/backend/image/product/medium/'.$product->thumbnail))) 
                             {
                               File::delete(base_path('/assets/backend/image/product/medium/'.$product->thumbnail));
                             }

                             if (File::exists(base_path('/assets/backend/image/product/large/'.$product->thumbnail)))
                              {
                                File::delete(base_path('/assets/backend/image/product/large/'.$product->thumbnail));
                              }

                              if (File::exists(base_path('/assets/backend/image/product/original/'.$product->thumbnail)))
                              {
                                 File::delete(base_path('/assets/backend/image/product/original/'.$product->thumbnail));
                              }
                     
                           $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                           $original_image_path = base_path().'/assets/backend/image/product/original/'.$image_name;
                           $large_image_path = base_path().'/assets/backend/image/product/large/'.$image_name;
                           $medium_image_path = base_path().'/assets/backend/image/product/medium/'.$image_name;
                           $small_image_path = base_path().'/assets/backend/image/product/small/'.$image_name;

                           //Resize Image
                           Image::make($image)->save($original_image_path);
                           Image::make($image)->resize(1920,680)->save($large_image_path);
                           Image::make($image)->resize(850,950)->save($medium_image_path);
                           Image::make($image)->resize(465,465)->save($small_image_path);
                           $product->thumbnail = $image_name;
                       
                   }

                    $product->save();

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

        $data=Product::findOrFail($request->item_id);

        if (File::exists(base_path('/assets/backend/image/product/small/'.$data->thumbnail))) 
          {
            File::delete(base_path('/assets/backend/image/product/small/'.$data->thumbnail));
          }
          if (File::exists(base_path('/assets/backend/image/product/medium/'.$data->thumbnail))) 
          {
            File::delete(base_path('/assets/backend/image/product/medium/'.$data->thumbnail));
          }

          if (File::exists(base_path('/assets/backend/image/product/large/'.$data->thumbnail)))
           {
             File::delete(base_path('/assets/backend/image/product/large/'.$data->thumbnail));
           }

           if (File::exists(base_path('/assets/backend/image/product/original/'.$data->thumbnail)))
           {
              File::delete(base_path('/assets/backend/image/product/original/'.$data->thumbnail));
           }
        $data->delete();
        $notification=['alert'=>'success','message'=>'Successfully Delete','status'=>200];

        return \response()->json([
            'message' => 'Sub Category Delete Successfully',
            'status_code' => 200
        ], Response::HTTP_OK);

       }


        public function show_product_status(Request $request)
    {

      $product=Product::findOrFail($request->product_id);

      return \response()->json([
              'product' => $product,
              'status_code' => 200
          ], Response::HTTP_OK);

    }


    public function update_product_status(Request $request)
    {
      $product=Product::findOrFail($request->product_id);

      if ($request->type=="featured") 
      {
          if ($product->featured==0) 
          {
            $product->featured=1;
          }else
          {
             $product->featured=0;
          }
      }elseif ($request->type=="top_sale") 
      {
        if ($product->top_sale==0) 
        {
          $product->top_sale=1;
        }else
        {
           $product->top_sale=0;
         }
      }elseif ($request->type=="trending") 
      {
        if ($product->trending==0) 
        {
          $product->trending=1;
        }else
        {
           $product->trending=0;
         }
      }

      $product->save();

      return \response()->json([
              'message' => "Successfully updated",
              'status_code' => 200
          ], Response::HTTP_OK);

    }
}
