<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Stock;
use Illuminate\Http\Response;
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;
use App\Models\Admin\ChildCategory;
use App\Models\Admin\Brand;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    
    public function index()
    {
    	$features=Product::where('featured',"=","0")->latest()->take(8)->get();
    	$top_sales=Product::where('top_sale',"=","0")->latest()->take(8)->get();
    	$trendings=Product::where('trending',"=","0")->latest()->take(8)->get();

        $latests=Product::orderBy('id','desc')->take(8)->get();
        $sliders=DB::table('sliders')->orderBy('id','desc')->get();
        return view('index',compact('latests','sliders','features','top_sales','trendings'));
    }

    public function product_detail($id)
    {
    	$product=Product::findOrFail($id);
        $releted_products=Product::where("category_id",$product->category_id)->inRandomOrder()->limit(6)->get(); 
    	return view('front.product_detail',compact("product","releted_products"));

    }

    public function find_color(Request $request)
    {
       
         $colors=Stock::with('color')->where(['product_id'=>$request->product_id,'size_id'=>$request->size_id])->get();

         return response()->json([
            'colors' =>$colors,
            'status_code' => 200
          ], Response::HTTP_OK);
    }

    public function available_quantity(Request $request)
    {
         $quantity=Stock::with('color')->where(
                [
                 'product_id'=>$request->product_id,
                 'size_id'=>$request->size_id,
                 'color_id'=>$request->color_id,
                 ]
            )->first();

         return response()->json([
            'quantity' =>$quantity,
            'status_code' => 200
          ], Response::HTTP_OK);
    }


    public function product_shop()
    {

         $products=DB::table('products')->latest()->paginate(2);

         $latests_one=DB::table('products')->orderBy('id','desc')->take(3)->get();
         $latests_two=DB::table('products')->skip(3)->take(3)->get();

         return view('front.shop',compact('products','latests_one','latests_two'));
    }


    public function category_product($id)
    {
         $products=Product::where('category_id','=',$id)->latest()->paginate(12);
         $category=Category::findOrFail($id);
         $latests_one=Product::orderBy('id','desc')->take(3)->get();
         $latests_two=Product::orderBy('id','desc')->skip(3)->take(3)->get();
         return view('front.category_product',compact("products","category",'latests_one','latests_two'));
    }

     public function subcategory_product($id)
    {
         $products=Product::where('sub_category_id','=',$id)->latest()->paginate(12);
         $subcategory=SubCategory::findOrFail($id);
         return view('front.subcategory_product',compact("products","subcategory"));
    }

    public function childcategory_product($id)
    {
         $products=Product::where('child_category_id','=',$id)->latest()->paginate(12);
         $childcategory=ChildCategory::findOrFail($id);
         return view('front.childcategory_product',compact("products","childcategory"));
    }

    public function brand_wise_product($id)
    {
         $products=Product::where('brand_id','=',$id)->latest()->paginate(12);
         $brand=Brand::findOrFail($id);
         $latests_one=Product::orderBy('id','desc')->take(3)->get();
         $latests_two=Product::orderBy('id','desc')->skip(3)->take(3)->get();
         return view('front.brand_product',compact("products","brand",'latests_one','latests_two'));
    }

    public function search(Request $request)
    {
        $latests_one=Product::orderBy('id','desc')->take(3)->get();
        $latests_two=Product::orderBy('id','desc')->skip(3)->take(3)->get();
        $products=Product::where('name',"LIKE","%$request->keyword%")
        ->orWhere('current_price',"LIKE","%$request->keyword%%")
        ->paginate(12);
        $keyword=$request->keyword;
         return view('front.search',compact('products','latests_one','latests_two','keyword'));
    }
}
