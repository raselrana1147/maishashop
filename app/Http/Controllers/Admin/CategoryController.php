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
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function datatable()
    {
       $datas=Category::orderBy('id','DESC')->get();
      
        return DataTables::of($datas)

         ->editColumn('image',function(Category $data){

                  $url=$data->image ? asset("assets/backend/image/category/small/".$data->image) 
                  :asset("assets/backend/image/default.png");
                  return '<img src='.$url.' border="0" width="120" height="50" class="img-rounded" />';
                 
                      
          })

        ->editColumn('action',function(Category $data){
                 return '<a href="'.route('admin.category_edit',$data->id).'" class="btn btn-success btn-sm">
                  <i class="fa fa-edit"></i>
                  </a>
                   <a href="javascript:;" class="btn btn-danger btn-sm delete_item" data-action="'.route('admin.category_delete').'"  item_id="'.$data->id.'">
                   <i class="fa fa-trash"></i>
                  </a>';
        })
       ->rawColumns(['image','action'])
        ->make(true);
    }


    public function index()
    {
    	return view('admin.category.index');
    }

    public function edit($id)
    {
      $data=Category::findOrFail($id);
       return view('admin.category.edit',compact('data'));
    }

   public function create()
   {
   	 return view('admin.category.create');
   }

   public function store(Request $request)
   {

     $this->validate($request,[
            'category_name'=>'unique:categories',
      ]);

      if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //create category

                $category = new Category();

                $category->category_name = $request->category_name;
          

                if($request->hasFile('image')){

                        $image=$request->image;
                  
                        $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                        $original_image_path = base_path().'/assets/backend/image/category/original/'.$image_name;
                        $large_image_path = base_path().'/assets/backend/image/category/large/'.$image_name;
                        $medium_image_path = base_path().'/assets/backend/image/category/medium/'.$image_name;
                        $small_image_path = base_path().'/assets/backend/image/category/small/'.$image_name;

                        //Resize Image
                        Image::make($image)->save($original_image_path);
                        Image::make($image)->resize(1920,680)->save($large_image_path);
                        Image::make($image)->resize(1000,529)->save($medium_image_path);
                        Image::make($image)->resize(300,498)->save($small_image_path);
                        $category->image = $image_name;
                    
                }

                $category->save();

                DB::commit();

                return \response()->json([
                    'message' => 'Category Added Successful',
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
     $category=Category::findOrFail($request->id);
     $this->validate($request,[
          'category_name'=>'unique:categories,category_name,'.$category->id,
      ]);

      if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //update category

                $category->category_name = $request->category_name;
        
                if($request->hasFile('image')){

                        // delete current image

                      if (File::exists(base_path('/assets/backend/image/category/small/'.$category->image))) 
                        {
                          File::delete(base_path('/assets/backend/image/category/small/'.$category->image));
                        }
                        if (File::exists(base_path('/assets/backend/image/category/medium/'.$category->image))) 
                        {
                          File::delete(base_path('/assets/backend/image/category/medium/'.$category->image));
                        }

                        if (File::exists(base_path('/assets/backend/image/category/large/'.$category->image)))
                         {
                           File::delete(base_path('/assets/backend/image/category/large/'.$category->image));
                         }

                         if (File::exists(base_path('/assets/backend/image/category/original/'.$category->image)))
                         {
                            File::delete(base_path('/assets/backend/image/category/original/'.$category->image));
                         }
                        // upload new image
                        $image=$request->image;
                        $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                        $original_image_path = base_path().'/assets/backend/image/category/original/'.$image_name;
                        $large_image_path = base_path().'/assets/backend/image/category/large/'.$image_name;
                        $medium_image_path = base_path().'/assets/backend/image/category/medium/'.$image_name;
                        $small_image_path = base_path().'/assets/backend/image/category/small/'.$image_name;

                        //Resize Image
                        Image::make($image)->save($original_image_path);
                        Image::make($image)->resize(1920,680)->save($large_image_path);
                        Image::make($image)->resize(1000,529)->save($medium_image_path);
                        Image::make($image)->resize(300,498)->save($small_image_path);
                        $category->image = $image_name;
                    
                }

                $category->save();

                DB::commit();

                return \response()->json([
                    'message' => 'Category updated Successful',
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


   public function delete(Request $request){

    $data=Category::findOrFail($request->item_id);

    if (File::exists(base_path('/assets/backend/image/category/small/'.$data->image))) 
      {
        File::delete(base_path('/assets/backend/image/category/small/'.$data->image));
      }
      if (File::exists(base_path('/assets/backend/image/category/medium/'.$data->image))) 
      {
        File::delete(base_path('/assets/backend/image/category/medium/'.$data->image));
      }

      if (File::exists(base_path('/assets/backend/image/category/large/'.$data->image)))
       {
         File::delete(base_path('/assets/backend/image/category/large/'.$data->image));
       }

       if (File::exists(base_path('/assets/backend/image/category/original/'.$data->image)))
       {
          File::delete(base_path('/assets/backend/image/category/original/'.$data->image));
       }
    $data->delete();
    $notification=['alert'=>'success','message'=>'Successfully Delete','status'=>200];

    return \response()->json([
        'message' => 'Category Delete Successfully',
        'status_code' => 200
    ], Response::HTTP_OK);

   }
}
