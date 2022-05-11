<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    

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
        $this->middleware('guest:admin')->except('logout');
    }


    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        
             if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $notification=['alert'=>'success','message'=>'Successfully Added','status'=>200,'route'=>route("admin.dashboard")];
                return json_encode($notification);
            }else{
                $notification=['alert'=>'error','message'=>'Credentials not match','status'=>400,'route'=>'admin.login'];
                 return json_encode($notification);
            }    
    }


     public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        session()->flash('success_message','successfully loged out...');
        return redirect()->route('admin.login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
}
