<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    
    
    public function add_wishlist(Request $request)
    {
    	if (Auth::check()) {
    		$check=Wishlist::where(['user_id'=>Auth::user()->id,'product_id'=>$request->product_id])->first();
    		if (is_null($check)) {
    			$wishlist=new Wishlist();
    			$wishlist->user_id=Auth::user()->id;
    			$wishlist->product_id=$request->product_id;
    			$wishlist->save();
    			$notification=['status'=>'200', 'type'=>'success','message'=>"Successfully added to wishlist","total_wishlist"=>Wishlist::total_wishlist()];
    		}else{
    			$notification=['status'=>'200', 'type'=>'success','message'=>"Already added to wishlist"];
    		}
    	}else{
    		 $notification=['status'=>'401', 'type'=>'error','route'=>route('login')];
    	}
    	echo json_encode($notification);
    }

    public function wishlist()
    {
        if (Auth::check()) {
            $wishlists=Wishlist::where('user_id',Auth::user()->id)->get();
            return view('front.wishlist',compact('wishlists'));
        }else{
            return redirect(route('login'));
        }

    }


     public function delete(Request $request)
    {
      
        $wishlist=Wishlist::findOrFail($request->wishlist_id);
        $wishlist->delete();
        $notification=['status'=>'200', 'type'=>'success','message'=>'Succeddfully deleted','total_wishlist'=>Wishlist::total_wishlist()];

        echo json_encode($notification);
    }
}
