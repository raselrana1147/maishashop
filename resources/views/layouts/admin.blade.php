<!DOCTYPE html>
<html lang="en">
     <head>
       @include('admin.files.css')
    </head>

    <body>
         <div id="wrapper">

            <!-- Top Bar Start -->
            @include('admin.files.header')
            <!-- Top Bar End -->

            <!-- ========== Left Sidebar Start ========== -->
             @include('admin.files.sidebar')
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <h4 class="page-title">@yield('breadcrumb')</h4>
                                    
                                </div>
                                
                            </div> <!-- end row -->
                        </div>
                        <!-- end page-title -->
                        @section('content')
                        @show
                        
                    </div>
                    <!-- container-fluid -->

                </div>
                <!-- content -->

                <footer class="footer">
                    © 2021 DPG <span class="d-none d-sm-inline-block"> - Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</span>.
                </footer>

            </div>
           

        </div>
    
         @include('admin.files.js')
    </body>


<!-- Mirrored from themesbrand.com/veltrix/layouts-2/vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 13 Jan 2020 07:07:20 GMT -->
</html>