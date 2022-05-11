<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use App\Models\Admin\Slider;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
use Image;

class SliderController extends Controller
{
   

	public function __construct()
	{
	    $this->middleware('auth:admin');
	    
	}

   public function datatable()
     {
        $datas=Slider::orderBy('id','DESC')->get();
       
         return DataTables::of($datas)

          ->editColumn('image',function(Slider $data){

                   $url=$data->image ? asset("assets/backend/image/slider/small/".$data->image) 
                   :asset("assets/backend/image/".default_image());
                   return '<img src='.$url.' border="0" width="120" height="50" class="img-rounded" />';         
           })


         ->editColumn('action',function(Slider $data){
                  return '<a href="'.route('admin.slider_edit',$data->id).'" class="btn btn-success btn-sm">
                   <i class="fa fa-edit"></i>
                   </a>
                    <a href="javascript:;" class="btn btn-danger btn-sm delete_item" data-action="'.route('admin.slider_delete').'"  item_id="'.$data->id.'">
                    <i class="fa fa-trash"></i>
                   </a>';
         })
        ->rawColumns(['image','action'])
         ->make(true);
     }


     public function index()
     {
     	return view('admin.slider.index');
     }
     
     public function edit($id)
     {
       $data=Slider::findOrFail($id);
        return view('admin.slider.edit',compact('data'));
     }

    public function create()
    {
      
    	 return view('admin.slider.create');
    }

    public function store(Request $request)
    {

     

       if ($request->isMethod('post'))
         {
             DB::beginTransaction();

             try{

                 //create Slider

                 $slider = new Slider();

                 $slider->title_1 = $request->title_1;
                 $slider->title_2 = $request->title_2;
                 $slider->button_title = $request->button_title;
                 $slider->url = $request->url;
                 $slider->tag = $request->tag;
              
                 if($request->hasFile('image')){

                         $image=$request->image;
                   
                         $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                         $original_image_path = base_path().'/assets/backend/image/slider/original/'.$image_name;
                         $large_image_path = base_path().'/assets/backend/image/slider/large/'.$image_name;
                         $medium_image_path = base_path().'/assets/backend/image/slider/medium/'.$image_name;
                         $small_image_path = base_path().'/assets/backend/image/slider/small/'.$image_name;

                         //Resize Image
                         Image::make($image)->save($original_image_path);
                         Image::make($image)->resize(1920,680)->save($large_image_path);
                         Image::make($image)->resize(848,380)->save($medium_image_path);
                         Image::make($image)->resize(465,465)->save($small_image_path);
                         $slider->image = $image_name;
                     
                 }

                 $slider->save();

                 DB::commit();

                 return \response()->json([
                     'message' => "Slider added successfully",
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

                 //update Slider
                 $slider=Slider::findOrFail($request->id);
                 $slider->title_1 = $request->title_1;
                 $slider->title_2 = $request->title_2;
                 $slider->button_title = $request->button_title;
                 $slider->url = $request->url;
                 $slider->tag = $request->tag;
         
                 if($request->hasFile('image')){

                         // delete current image

                       if (File::exists(base_path('/assets/backend/image/slider/small/'.$slider->image))) 
                         {
                           File::delete(base_path('/assets/backend/image/slider/small/'.$slider->image));
                         }
                         if (File::exists(base_path('/assets/backend/image/slider/medium/'.$slider->image))) 
                         {
                           File::delete(base_path('/assets/backend/image/slider/medium/'.$slider->image));
                         }

                         if (File::exists(base_path('/assets/backend/image/slider/large/'.$slider->image)))
                          {
                            File::delete(base_path('/assets/backend/image/slider/large/'.$slider->image));
                          }

                          if (File::exists(base_path('/assets/backend/image/slider/original/'.$slider->image)))
                          {
                             File::delete(base_path('/assets/backend/image/slider/original/'.$slider->image));
                          }
                         // upload new image
                         $image=$request->image;
                         $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                         $original_image_path = base_path().'/assets/backend/image/slider/original/'.$image_name;
                         $large_image_path = base_path().'/assets/backend/image/slider/large/'.$image_name;
                         $medium_image_path = base_path().'/assets/backend/image/slider/medium/'.$image_name;
                         $small_image_path = base_path().'/assets/backend/image/slider/small/'.$image_name;

                         //Resize Image
                         Image::make($image)->save($original_image_path);
                         Image::make($image)->resize(1920,680)->save($large_image_path);
                         Image::make($image)->resize(1000,529)->save($medium_image_path);
                         Image::make($image)->resize(465,465)->save($small_image_path);
                         $slider->image = $image_name;
                     
                 }

                 $slider->save();

                 DB::commit();

                 return \response()->json([
                     'message' => 'Successfully updated',
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

     $data=Slider::findOrFail($request->item_id);

     if (File::exists(base_path('/assets/backend/image/slider/small/'.$data->image))) 
       {
         File::delete(base_path('/assets/backend/image/slider/small/'.$data->image));
       }
       if (File::exists(base_path('/assets/backend/image/slider/medium/'.$data->image))) 
       {
         File::delete(base_path('/assets/backend/image/slider/medium/'.$data->image));
       }

       if (File::exists(base_path('/assets/backend/image/slider/large/'.$data->image)))
        {
          File::delete(base_path('/assets/backend/image/slider/large/'.$data->image));
        }

        if (File::exists(base_path('/assets/backend/image/slider/original/'.$data->image)))
        {
           File::delete(base_path('/assets/backend/image/slider/original/'.$data->image));
        }
     $data->delete();
     $notification=['alert'=>'success','message'=>'Successfully Delete','status'=>200];

     return \response()->json([
         'message' => 'Successfully deleted',
         'status_code' => 200
     ], Response::HTTP_OK);

    }
}
