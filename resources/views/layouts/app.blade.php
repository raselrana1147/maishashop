<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="multikart">
    <meta name="keywords" content="multikart">
    <meta name="author" content="multikart">
    <link rel="icon" href="{{ asset('assets/frontend/assets/images/favicon/1.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/frontend/assets/images/favicon/1.png')}}" type="image/x-icon">
    <title>@yield('title')</title>

    <!--Google font-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Yellowtail&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/assets/css/vendors/fontawesome.css')}}">
                  
    <!--Slick slider css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/assets/css/vendors/slick.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/assets/css/vendors/slick-theme.css')}}">

    <!-- Animate icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/assets/css/vendors/animate.css')}}">

    <!-- Themify icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/assets/css/vendors/themify-icons.css')}}">

    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/assets/css/vendors/bootstrap.css')}}">
    <link href="{{ asset('assets/frontend/style/css/toast.css')}}" rel="stylesheet" type="text/css">
    <!-- Theme css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/assets/css/style.css')}}">


    @yield('css')



</head>

<body class="theme-color-1">


    <!-- loader start -->
   @include('front.files.loader')
    <!-- loader end -->


    <!-- header start -->
    @include('front.files.header')
    <!-- header end -->
    <div class=" text-center message_part"></div>
    @section('content')
    @show


    <!-- footer -->
    @include('front.files.footer')
    <!-- footer end -->


    <!-- cookie bar start -->
   {{--  @include('front.files.modal') --}}
    <!-- Add to cart modal popup end-->


    <!-- facebook chat section start -->
    <div id="fb-root"></div>
    <script>
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src =
                'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <!-- Your customer chat code -->
    <div class="fb-customerchat" attribution=setup_tool page_id="2123438804574660" theme_color="#0084ff"
        logged_in_greeting="Hi! Welcome to PixelStrap Themes  How can we help you?"
        logged_out_greeting="Hi! Welcome to PixelStrap Themes  How can we help you?">
    </div>
    <!-- facebook chat section end -->


    <!-- tap to top -->
    <div class="tap-top top-cls">
        <div>
            <i class="fa fa-angle-double-up"></i>
        </div>
    </div>
    <!-- tap to top end -->


    <!-- latest jquery-->
    <script src="{{ asset('assets/frontend/assets/js/jquery-3.3.1.min.js')}}"></script>

    <!-- fly cart ui jquery-->
    <script src="{{ asset('assets/frontend/assets/js/jquery-ui.min.js')}}"></script>

    <!-- exitintent jquery-->
    <script src="{{ asset('assets/frontend/assets/js/jquery.exitintent.js')}}"></script>
    <script src="{{ asset('assets/frontend/assets/js/exit.js')}}"></script>

    <!-- slick js-->
    <script src="{{ asset('assets/frontend/assets/js/slick.js')}}"></script>

    <!-- menu js-->
    <script src="{{ asset('assets/frontend/assets/js/menu.js')}}"></script>

    <!-- lazyload js-->
    <script src="{{ asset('assets/frontend/assets/js/lazysizes.min.js')}}"></script>

    <!-- Bootstrap js-->
    <script src="{{ asset('assets/frontend/assets/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Bootstrap Notification js-->
   {{--  <script src="{{ asset('assets/frontend/assets/js/bootstrap-notify.min.js')}}"></script> --}}

    <!-- Fly cart js-->
    <script src="{{ asset('assets/frontend/assets/js/fly-cart.js')}}"></script>

    <!-- Theme js-->
    <script src="{{ asset('assets/frontend/assets/js/theme-setting.js')}}"></script>
    <script src="{{ asset('assets/frontend/assets/js/script.js')}}"></script>
    <script src="{{ asset('assets/frontend/style/js/toast.js')}}"></script>
    <script src="{{ asset('assets/frontend/style/js/cart.js') }}"></script>
    <script src="{{ asset('assets/frontend/style/js/wishlist.js') }}"></script>
    <script>
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
     </script>

       <script>
           @if(Session::has('message'))
             var type="{{Session::get('alert-type','info')}}"
             switch(type){
                 case 'info':
                      toastr.info("{{ Session::get('message') }}");
                      break;
                 case 'success':
                     toastr.success("{{ Session::get('message') }}");
                     break;
                 case 'warning':
                     toastr.warning("{{ Session::get('message') }}");
                     break;
                 case 'error':
                     toastr.error("{{ Session::get('message') }}");
                    break;
             }
           @endif
     </script>
    @yield('js')

    <script>
        $(window).on('load', function () {
            setTimeout(function () {
                $('#exampleModal').modal('show');
            }, 2500);
        });

        function openSearch() {
            document.getElementById("search-overlay").style.display = "block";
        }

        function closeSearch() {
            document.getElementById("search-overlay").style.display = "none";
        }
    </script>

    

</body>

</html>