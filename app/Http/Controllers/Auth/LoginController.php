<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {

         $this->validate($request, [
           
            'email' => 'required',
            'password' => 'required',
            
        ]);
      
            if (Auth::guard('web')->attempt(['email'=>$request->email,'password'=>$request->password])) 
            {
               $carts=Cart::where('ip_address',$request->ip())->get();
               if (!is_null($carts)) 
               {
                  foreach ($carts as $cart) 
                  {
                    $cart->user_id=Auth::user()->id;
                    $cart->save();
                  }
               }
              $notification=array(
                  'message'=>'Successfully Login !!',
                  'alert-type'=>'success'
                  );
                return redirect()->intended(route('front.index'))->with($notification);
            }else{
                $notification=array(
                    'message'=>'Credentians not match !!',
                    'alert-type'=>'error'
                    );
              return redirect()->back()->with($notification);
            }
}

}
