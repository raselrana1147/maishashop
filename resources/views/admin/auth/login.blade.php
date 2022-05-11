<!DOCTYPE html>
<html lang="en">

<head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Admin Login</title>
        <meta content="Responsive admin theme build on top of Bootstrap 4" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="{{ asset('assets/backend/assets/images/favicon.ico')}}">

        <link href="{{ asset('assets/backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/backend/assets/css/metismenu.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/backend/assets/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/backend/assets/css/style.css')}}" rel="stylesheet" type="text/css">
    </head>

    <body class="bg-primary">
        <div class="home-btn d-none d-sm-block">
            <a href="{{ route('admin.dashboard') }}" class="text-white"><i class="fas fa-home h2"></i></a>
        </div>

        <div class="account-pages my-5 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern shadow-none">
                            <div class="card-body">
                                <div class="text-center mt-4">
                                    <div class="mb-3">
                                        <a href="index.html" class="logo"><img src="{{ asset('assets/backend/assets/images/logo-dark.png') }}" height="20" alt="logo"></a>
                                    </div>
                                </div>
                                <div class="p-3"> 
                                    <h4 class="font-18 text-center">Maisha-E-Shop</h4>
                                    <p class="text-muted text-center mb-4">Sign in to continue to Maisha-E-Shop.</p>
                                    <div id="message_area" style="display: none"></div>
                                    <form  class="form-horizontal" data-action="{{ route('admin.login') }}" method="POST" id="kt_sign_in_form">
                						@csrf
                                        <div class="form-group">
                                            <label for="username">E-mail</label>
                                            <input type="text" class="form-control" name="email" placeholder="Enter E-mail">
                                        </div>
                
                                        <div class="form-group">
                                            <label for="userpassword">Password</label>
                                            <input type="password" class="form-control" name="password" placeholder="Enter password">
                                        </div>
                
                                        
                                        
                                        <div class="mt-3">
                                            <button class="btn btn-primary btn-block waves-effect waves-light submit_button" type="submit">Log In</button>
                                        </div>
            
                                        <div class="mt-4 text-center">
                                            <a href="pages-recoverpw.html"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                        </div>
                                    </form>
                
                                </div>
                    
                            </div>
                        </div>
                        <div class="mt-5 text-center text-white-50">
                            <p>Don't have an account ? <a href="pages-register.html" class="font-500 text-white"> Signup now </a> </p>
                            <p>© {{date('Y')}} DPG-E-Marketplace. Crafted with</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery  -->
        <script src="{{ asset('assets/backend/assets/js/jquery.min.js')}}"></script>
        <script src="{{ asset('assets/backend/assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ asset('assets/backend/assets/js/metismenu.min.js')}}"></script>
        <script src="{{ asset('assets/backend/assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{ asset('assets/backend/assets/js/waves.min.js')}}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/backend/assets/js/app.js')}}"></script>
        <script>
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });
      </script>


        <script>
            $(document).ready(function(){

                $('body').on('submit','#kt_sign_in_form',function(e){
              
                e.preventDefault();
                let formDta = new FormData(this);

                $('.submit_button').text("Processing").prop('disabled',true);
                 $('#message_area').html('<div class="alert alert-success">Processing...</div>').show();

                $.ajax({
                  url: $(this).attr('data-action'),
                  method: "POST",
                  data: formDta,
                  cache: false,
                  contentType: false,
                  processData: false,
                  success:function(response){

                    let data=JSON.parse(response);

                    if(data.status==200){
                        $('#message_area').html('<div class="alert alert-success">Successfull !!!</div>').show();
                        window.location = data.route
                    }else{
                        //toastr.error(data.message);   
                        $('#message_area')
                        .html('<div class="alert alert-danger">Credential Not Match</div>').show();
                         $('.submit_button').text("Sing In").prop('disabled',false);
                    }
                  },

                 
                });
          })
            })
        </script>
        
    </body>
</html>