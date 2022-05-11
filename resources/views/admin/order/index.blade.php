@extends("layouts.admin")
@section("title","Admin | Order List")
@section("breadcrumb","Order")
@section("content")
   <div class="row">
       <div class="col-12">
           <div class="card">
               <div class="card-body">
                    <h4 class="mt-0 header-title">Order List</h4>
                   <table id="tables_item" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                       <thead>
                       <tr>
                           <th>Serial</th>
                           <th>Sub Total</th>
                           <th>Grand Total</th>
                           <th>Order Number</th>
                           <th>Quantity</th>
                           <th>Ordered At</th>
                           <th>Status</th>
                           <th>Action</th>
                       </tr>
                       </thead>
                      
                   </table>
   
               </div>
           </div>
       </div> <!-- end col -->
   </div> <!-- end row -->
@endsection
@section('js')

 <script>
         var table = $("#tables_item").DataTable({
             processing: true,
             responsive: true,
             serverSide: true,
             ordering: false,
             pagingType: "full_numbers",
             ajax: '{{ route('admin.load_order') }}',
             columns: [
                 { data: 'id',name:'id' },
                 { data: 'sub_total',name:'sub_total'},
                 { data: 'grand_total',name:'grand_total'},
                 { data: 'order_number',name:'order_number'},
                 { data: 'quantity',name:'quantity'},
                 { data: 'order_at',name:'order_at'},
                 { data: 'status',name:'status'},
                 { data: 'action',name:'action' },
             ],

              language : {
                   processing: 'Processing'
               },
              
         });
    </script>
    <script>
        $(document).ready(function(){
              
            $('body').on('change','.order_status',function(){

                 let order_id=$(this).attr('order_id');
                  let status=$(this).val();
                     $.ajax({
                        url:$(this).attr('data-action'),
                        method:'post',
                        data:{order_id:order_id,status:status},
                        success:function(data){
                           toastr.success(data.message);
                    }
                }); 
            })      
        })
    </script>
@endsection()