<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Str;
use Image;

class AdminProfileController extends Controller
{
    
        public function __construct()
        {
            $this->middleware('auth:admin');
        }

        public function password_form()
        {
        	return view('admin.profile.password_change');
        }



        public function change_password(Request $request)
        {

        	   $user=Auth::user();
        	   if (Hash::check($request->old_password,$user->password)) {
        	      if (strlen($request->new_password) >=6) {
        	           if ($request->new_password===$request->password_confirmation) 
        	           {
        	                $user->update(['password'=>Hash::make($request->new_password)]);
        	                $notification=['alert'=>'error','message'=>'Password updated','status'=>200];
        	           }else
        	           {
        	               $notification=['alert'=>'error','message'=>'Confirm Password not match','status'=>405];
        	           }
        	        
        	      }else{
        	            $notification=['alert'=>'error','message'=>"Password should be 6 character",'status'=>405];
        	      }
        	   }else{
        	     $notification=['alert'=>'error','message'=>"Old Password Not match",'status'=>403];
        	   }
      
        	return json_encode($notification);
        }


        public function profile_form(Request $request)
        {

        	return view('admin.profile.profile_change');
        }


         public function change_profile(Request $request)
        {

             $user=Admin::findOrFail($request->id);

             $this->validate($request,[
                'phone'=>'unique:admins,phone,'.$user->id
             ]);

    	      
    	       $user->name=$request->name;
               $user->phone=$request->phone;
               $user->address=$request->address;

    	      
    	      if($request->hasFile('avatar')){

    	               if (File::exists(base_path('/assets/backend/image/profile/'.$user->avatar))) 
    	               {
    	                 File::delete(base_path('/assets/backend/image/profile/'.$user->avatar));
    	               }

    	              $image=$request->avatar;
    	              $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
    	              $image_path = base_path().'/assets/backend/image/profile/'.$image_name;
    	              //Resize Image
    	              Image::make($image)->resize(500,480)->save($image_path);
    	              $user->avatar = $image_name;  
    	      }

    	       $user->save();
    	       $notification=['alert'=>'success','message'=>'Updated successfully','status'=>200];
    	     
    	    return json_encode($notification);
        }
}
