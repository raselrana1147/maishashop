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
use App\Models\Admin\SubCategory;
use App\Models\Admin\ChildCategory;

class ChildCategoryController extends Controller
{
    
     public function __construct()
     {
         $this->middleware('auth:admin');
     }


     public function datatable()
     {
        $datas=ChildCategory::orderBy('id','DESC')->get();
       
         return DataTables::of($datas)
          ->editColumn('subcategory',function(ChildCategory $data){
                  return $data->subcategory->sub_cat_name;          
           })

         ->editColumn('action',function(ChildCategory $data){
                  return '<a href="'.route('admin.childcategory_edit',$data->id).'" class="btn btn-success btn-sm">
                   <i class="fa fa-edit"></i>
                   </a>
                    <a href="javascript:;" class="btn btn-danger btn-sm delete_item" data-action="'.route('admin.childcategory_delete').'"  item_id="'.$data->id.'">
                    <i class="fa fa-trash"></i>
                   </a>';
         })
        ->rawColumns(['subcategory','action'])
         ->make(true);
     }


     public function index()
     {
     	return view('admin.childCategory.index');
     }

     public function edit($id)
     {
        $data=ChildCategory::findOrFail($id);
        $subcategories=SubCategory::latest()->get();
        return view('admin.childCategory.edit',compact('subcategories','data'));
     }

    public function create()
    {
    	$subcategories=SubCategory::latest()->get();
    	 return view('admin.childCategory.create',compact('subcategories'));
    }

    public function store(Request $request)
    {


       if ($request->isMethod('post'))
         {
             DB::beginTransaction();

             try{

                 //create child category

                 $child_category = new ChildCategory();

                 $child_category->child_cat_name = $request->   child_cat_name;
                 $child_category->sub_category_id  = $request->sub_category_id ;
                 $child_category->save();

                 DB::commit();

                 return \response()->json([
                     'message' => 'Child category Added Successful',
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

                 //update Child category
                 $childcategory=ChildCategory::findOrFail($request->id);
                 $childcategory->child_cat_name = $request->child_cat_name;
                 $childcategory->sub_category_id = $request->sub_category_id;
         

                 $childcategory->save();

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


    public function delete(Request $request){

     $data=ChildCategory::findOrFail($request->item_id);

     $data->delete();
     $notification=['alert'=>'success','message'=>'Successfully Delete','status'=>200];

     return \response()->json([
         'message' => 'Successfully Deleted',
         'status_code' => 200
     ], Response::HTTP_OK);

    }


   public  function sub_wise_child_cat(Request $request)
   {

     $childcategories=ChildCategory::
     where('sub_category_id',$request->sub_category_id)
     ->get();

          return \response()->json([
              'childcategories' => $childcategories,
              'status_code' => 200
          ], Response::HTTP_OK);
   }
}
