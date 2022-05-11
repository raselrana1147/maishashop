<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use App\Models\Admin\Gallery;
use App\Models\Admin\Product;
use Image;

class GalleryController extends Controller
{
    
     public function __construct()
     {
         $this->middleware('auth:admin');
     }

     public function index($id)
     {
     	$galleries=Gallery::where('product_id',$id)->get();
     	$product=Product::findOrFail($id);
     	return view('admin.gallery.index',compact('galleries','product'));
     }

     public function edit($id)
     {
        $gallery=Gallery::findOrFail($id);
        return view('admin.gallery.edit',compact("gallery"));
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

                 //Gallery create

                 $gallery = new Gallery();

                 $gallery->product_id = $request->product_id;
                
                 if($request->hasFile('image')){

                         $image=$request->image;
                   
                         $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                         $original_image_path = base_path().'/assets/backend/image/gallery/original/'.$image_name;
                         $large_image_path = base_path().'/assets/backend/image/gallery/large/'.$image_name;
                         $medium_image_path = base_path().'/assets/backend/image/gallery/medium/'.$image_name;
                         $small_image_path = base_path().'/assets/backend/image/gallery/small/'.$image_name;

                         //Resize Image
                         Image::make($image)->save($original_image_path);
                         Image::make($image)->resize(1920,1000)->save($large_image_path);
                         Image::make($image)->resize(850,950)->save($medium_image_path);
                         Image::make($image)->resize(465,465)->save($small_image_path);
                         $gallery->image = $image_name; 
                 }

                 $gallery->save();

                 DB::commit();

                 return \response()->json([
                     'message' => 'Successful added',
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

                 //brand 
                 $gallery=Gallery::findOrFail($request->id);
                
                 if($request->hasFile('image')){

                         // delete current image

                       if (File::exists(base_path('/assets/backend/image/gallery/small/'.$gallery->image))) 
                         {
                           File::delete(base_path('/assets/backend/image/gallery/small/'.$gallery->image));
                         }
                         if (File::exists(base_path('/assets/backend/image/gallery/medium/'.$gallery->image))) 
                         {
                           File::delete(base_path('/assets/backend/image/gallery/medium/'.$gallery->image));
                         }

                         if (File::exists(base_path('/assets/backend/image/gallery/large/'.$gallery->image)))
                          {
                            File::delete(base_path('/assets/backend/image/gallery/large/'.$gallery->image));
                          }

                          if (File::exists(base_path('/assets/backend/image/gallery/original/'.$gallery->image)))
                          {
                             File::delete(base_path('/assets/backend/image/gallery/original/'.$gallery->image));
                          }
                         // upload new image
                         $image=$request->image;
                         $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                         $original_image_path = base_path().'/assets/backend/image/gallery/original/'.$image_name;
                         $large_image_path = base_path().'/assets/backend/image/gallery/large/'.$image_name;
                         $medium_image_path = base_path().'/assets/backend/image/gallery/medium/'.$image_name;
                         $small_image_path = base_path().'/assets/backend/image/gallery/small/'.$image_name;

                         //Resize Image
                         Image::make($image)->save($original_image_path);
                         Image::make($image)->resize(1920,1000)->save($large_image_path);
                         Image::make($image)->resize(850,950)->save($medium_image_path);
                         Image::make($image)->resize(465,465)->save($small_image_path);
                         $gallery->image = $image_name;
                     
                 }

                 $gallery->save();

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

     $data=Gallery::findOrFail($request->item_id);

     if (File::exists(base_path('/assets/backend/image/gallery/small/'.$data->image))) 
       {
         File::delete(base_path('/assets/backend/image/gallery/small/'.$data->image));
       }
       if (File::exists(base_path('/assets/backend/image/gallery/medium/'.$data->image))) 
       {
         File::delete(base_path('/assets/backend/image/gallery/medium/'.$data->image));
       }

       if (File::exists(base_path('/assets/backend/image/gallery/large/'.$data->image)))
        {
          File::delete(base_path('/assets/backend/image/gallery/large/'.$data->image));
        }

        if (File::exists(base_path('/assets/backend/image/gallery/original/'.$data->image)))
        {
           File::delete(base_path('/assets/backend/image/gallery/original/'.$data->image));
        }
     $data->delete();
     $notification=['alert'=>'success','message'=>'Successfully Delete','status'=>200];

     return \response()->json([
         'message' => 'Successfully Deleted',
         'status_code' => 200
     ], Response::HTTP_OK);

    }
}
