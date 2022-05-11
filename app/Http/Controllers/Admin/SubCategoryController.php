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
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;


class SubCategoryController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function datatable()
    {
       $datas=SubCategory::orderBy('id','DESC')->get();
      
        return DataTables::of($datas)

         ->editColumn('image',function(SubCategory $data){

                  $url=$data->image ? asset("assets/backend/image/subcategory/small/".$data->image) 
                  :asset("assets/backend/image/default.png");
                  return '<img src='.$url.' border="0" width="120" height="50" class="img-rounded" />';
                 
                      
          })

         ->editColumn('category',function(SubCategory $data){
                 return $data->category->category_name;          
          })

        ->editColumn('action',function(SubCategory $data){
                 return '<a href="'.route('admin.subcategory_edit',$data->id).'" class="btn btn-success btn-sm">
                  <i class="fa fa-edit"></i>
                  </a>
                   <a href="javascript:;" class="btn btn-danger btn-sm delete_item" data-action="'.route('admin.subcategory_delete').'"  item_id="'.$data->id.'">
                   <i class="fa fa-trash"></i>
                  </a>';
        })
       ->rawColumns(['image','category','action'])
        ->make(true);
    }


    public function index()
    {
    	return view('admin.subCategory.index');
    }

    public function edit($id)
    {
      $data=SubCategory::findOrFail($id);
      $categories=Category::latest()->get();
       return view('admin.subcategory.edit',compact('categories','data'));
    }

   public function create()
   {
   	$categories=Category::latest()->get();
   	 return view('admin.subCategory.create',compact('categories'));
   }

   public function store(Request $request)
   {


      if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //create sub category

                $subcategory = new SubCategory();

                $subcategory->sub_cat_name = $request->sub_cat_name;
                $subcategory->category_id = $request->category_id;
          

                if($request->hasFile('image')){

                        $image=$request->image;
                  
                        $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                        $original_image_path = base_path().'/assets/backend/image/subcategory/original/'.$image_name;
                        $large_image_path = base_path().'/assets/backend/image/subcategory/large/'.$image_name;
                        $medium_image_path = base_path().'/assets/backend/image/subcategory/medium/'.$image_name;
                        $small_image_path = base_path().'/assets/backend/image/subcategory/small/'.$image_name;

                        //Resize Image
                        Image::make($image)->save($original_image_path);
                        Image::make($image)->resize(1920,680)->save($large_image_path);
                        Image::make($image)->resize(1000,529)->save($medium_image_path);
                        Image::make($image)->resize(465,465)->save($small_image_path);
                        $subcategory->image = $image_name;
                    
                }

                $subcategory->save();

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
    
     

      if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //update sub category
                 $subcategory=SubCategory::findOrFail($request->id);
                $subcategory->sub_cat_name = $request->sub_cat_name;
                $subcategory->category_id = $request->category_id;
        
                if($request->hasFile('image')){

                        // delete current image

                      if (File::exists(base_path('/assets/backend/image/subcategory/small/'.$subcategory->image))) 
                        {
                          File::delete(base_path('/assets/backend/image/subcategory/small/'.$subcategory->image));
                        }
                        if (File::exists(base_path('/assets/backend/image/subcategory/medium/'.$subcategory->image))) 
                        {
                          File::delete(base_path('/assets/backend/image/subcategory/medium/'.$subcategory->image));
                        }

                        if (File::exists(base_path('/assets/backend/image/subcategory/large/'.$subcategory->image)))
                         {
                           File::delete(base_path('/assets/backend/image/subcategory/large/'.$subcategory->image));
                         }

                         if (File::exists(base_path('/assets/backend/image/subcategory/original/'.$subcategory->image)))
                         {
                            File::delete(base_path('/assets/backend/image/subcategory/original/'.$subcategory->image));
                         }
                        // upload new image
                        $image=$request->image;
                        $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                        $original_image_path = base_path().'/assets/backend/image/subcategory/original/'.$image_name;
                        $large_image_path = base_path().'/assets/backend/image/subcategory/large/'.$image_name;
                        $medium_image_path = base_path().'/assets/backend/image/subcategory/medium/'.$image_name;
                        $small_image_path = base_path().'/assets/backend/image/subcategory/small/'.$image_name;

                        //Resize Image
                        Image::make($image)->save($original_image_path);
                        Image::make($image)->resize(1920,680)->save($large_image_path);
                        Image::make($image)->resize(1000,529)->save($medium_image_path);
                        Image::make($image)->resize(465,465)->save($small_image_path);
                        $subcategory->image = $image_name;
                    
                }

                $subcategory->save();

                DB::commit();

                return \response()->json([
                    'message' => 'Sub Category updated Successful',
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

public function get_sub_cat(Request $request)
{
   $subcategories=SubCategory::where('category_id',$request->category_id)->get();
   $notification=['alert'=>'success','subcategories'=>$subcategories,'status'=>200];
    return response()->json($notification);
}

   public function delete(Request $request){

    $data=SubCategory::findOrFail($request->item_id);

    if (File::exists(base_path('/assets/backend/image/subcategory/small/'.$data->image))) 
      {
        File::delete(base_path('/assets/backend/image/subcategory/small/'.$data->image));
      }
      if (File::exists(base_path('/assets/backend/image/subcategory/medium/'.$data->image))) 
      {
        File::delete(base_path('/assets/backend/image/subcategory/medium/'.$data->image));
      }

      if (File::exists(base_path('/assets/backend/image/subcategory/large/'.$data->image)))
       {
         File::delete(base_path('/assets/backend/image/subcategory/large/'.$data->image));
       }

       if (File::exists(base_path('/assets/backend/image/subcategory/original/'.$data->image)))
       {
          File::delete(base_path('/assets/backend/image/subcategory/original/'.$data->image));
       }
    $data->delete();
    $notification=['alert'=>'success','message'=>'Successfully Delete','status'=>200];

    return \response()->json([
        'message' => 'Sub Category Delete Successfully',
        'status_code' => 200
    ], Response::HTTP_OK);

   }


   public  function cat_wise_sub_cat(Request $request)
   {

     $subcategoryes=SubCategory::where('category_id',$request->category_id)->get();

          return \response()->json([
              'subcategoryes' => $subcategoryes,
              'status_code' => 200
          ], Response::HTTP_OK);
   }
}
