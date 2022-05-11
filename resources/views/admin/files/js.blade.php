       <script src="{{ asset('assets/backend/assets/js/jquery.min.js')}}"></script>
        <script src="{{ asset('assets/backend/assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ asset('assets/backend/assets/js/metismenu.min.js')}}"></script>
        <script src="{{ asset('assets/backend/assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{ asset('assets/backend/assets/js/waves.min.js')}}"></script>

        <!-- datepicker -->
        <script src="{{ asset('assets/backend/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
        <!-- vector map  -->
        <script src="{{ asset('assets/backend/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
        <script src="{{ asset('assets/backend/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>

        <!-- apexcharts -->
        <script src="{{ asset('assets/backend/plugins/apexcharts/apexcharts.min.js')}}"></script>

        <!-- Peity JS -->
        <script src="{{ asset('assets/backend/plugins/peity-chart/jquery.peity.min.js')}}"></script>

        <script src="{{ asset('assets/backend/assets/pages/dashboard.js')}}"></script>
        <!-- Required datatable js -->
        <script src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
         <!-- Responsive examples -->
        <script src="{{ asset('assets/backend/plugins/datatables/dataTables.responsive.min.js')}}"></script>
        <script src="{{ asset('assets/backend/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>

         <script src="{{ asset('assets/backend/assets/pages/datatables.init.js')}}"></script> 
         <script src="{{ asset('assets/backend/assets/js/app.js')}}"></script>
         <script src="{{ asset('assets/backend/style/js/dropify.js')}}"></script>
         <script src="{{ asset('assets/backend/style/js/dropify.more.js')}}"></script>

        
          <script src="{{ asset('assets/backend/style/js/toastr.js')}}"></script>
          <script src="{{ asset('assets/backend/style/js/sweet-alert.js')}}"></script>
         {{--  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
        {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
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
