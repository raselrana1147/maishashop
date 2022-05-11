<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin\Color;


class ColorController extends Controller
{
    

	 public function __construct()
	 {
	     $this->middleware('auth:admin');
	 }


	 public function datatable()
	 {
	    $datas=Color::orderBy('id','DESC')->get();
	    
	     return DataTables::of($datas)

	      ->editColumn('color',function(Color $data){
	              return '<span style="background:'.$data->color_code.';color:'.$data->color_code.'">Color</span><span style="padding-left:12px">'.$data->color_code.'</span>';         
	       })
	     ->editColumn('action',function(Color $data){
	              return '<a href="'.route('admin.color_edit',$data->id).'" class="btn btn-success btn-sm">
	               <i class="fa fa-edit"></i>
	               </a>
	                <a href="javascript:;" class="btn btn-danger btn-sm delete_item" data-action="'.route('admin.color_delete').'"  item_id="'.$data->id.'">
	                <i class="fa fa-trash"></i>
	               </a>';
	     })
	    ->rawColumns(['color','action'])
	     ->make(true);
	 }


	 public function index()
	 {
	 	return view('admin.color.index');
	 }

	 public function edit($id)
	 {
	    $color=Color::findOrFail($id);
	    return view('admin.color.edit',compact("color"));
	 }

	public function create()
	{
		 return view('admin.color.create');
	}

	public function store(Request $request)
	{

	   if ($request->isMethod('post'))
	     {
	         DB::beginTransaction();

	         try{

	             //Color create

	             $color = new Color();

	             $color->color_name = $request->color_name;
	             $color->color_code = $request->color_code;
	           
	             $color->save();
	             DB::commit();

	             return \response()->json([
	                 'message' => ' Successfully Added',
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

	             //Color update 
	         	 $color=Color::findOrFail($request->id);
	             $color->color_name = $request->color_name;
	             $color->color_code = $request->color_code;
	           
	             $color->save();
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

	 $data=Color::findOrFail($request->item_id);

	
	 $data->delete();
	 $notification=['alert'=>'success','message'=>'Successfully Delete','status'=>200];

	 return \response()->json([
	     'message' => 'Sub Category Delete Successfully',
	     'status_code' => 200
	 ], Response::HTTP_OK);

	}

}
