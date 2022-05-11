@extends("layouts.admin")
@section("title","Admin | Weekly Report")
@section("breadcrumb",'Weekly Report')
@section("content")
s
 <div class="row">
 <div class="col-lg-4">
  <div class="card text-white bg-dark">
      <div class="card-header">
          <h5 class="font-16 my-0"><i class="mdi mdi-alert-circle-outline mr-3"></i>Total Sale</h5>
      </div>
      <div class="card-body">
         <h5 class="card-title font-16 mt-0">{{currency().number_format($total_pro_amount,2)}}</h5>
      </div>
  </div>
</div>
  <div class="col-lg-4">
   <div class="card text-white bg-success">
       <div class="card-header">
           <h5 class="font-16 my-0"><i class="mdi mdi-alert-circle-outline mr-3"></i>Total Orders</h5>
       </div>
       <div class="card-body">
          <h5 class="card-title font-16 mt-0">{{$total_orders}}</h5>
       </div>
   </div>
 </div>
  <div class="col-lg-4">
   <div class="card text-white bg-danger">
       <div class="card-header">
           <h5 class="font-16 my-0"><i class="mdi mdi-alert-circle-outline mr-3"></i>Total Items</h5>
       </div>
       <div class="card-body">
          <h5 class="card-title font-16 mt-0">{{$total_quantity}}</h5>
       </div>
   </div>
 </div>
 </div>


   <div class="row">
       <div class="col-12">
           <div class="card">
               <div class="card-body">
                   
                    <h4 class="mt-0 header-title">Weekly Report</h4>
                   <table id="datatable_table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                       <thead>
                       <tr>
                         <th>Serial</th>
                          <th>Order Number</th>
                          <th>Sub Total</th>
                          <th>Tax</th>
                          <th>Shiping Cost</th>
                          <th>Grand Total</th>
                          <th>Quantity</th>
                          <th>Payment</th>
                          <th>Order At</th>
                          <th>Status</th>
                           
                       </tr>
                       </thead>
                       <tbody>
                        @foreach ($orders as $order)
                        
                         <tr>
                           <td>{{$loop->index+1}}</td>
                           <td>#{{$order->order_number}}</td>
                           <td>{{currency().number_format($order->sub_total,2)}}</td>
                           <td>{{currency().number_format($order->tax,2)}}</td>
                           <td>{{currency().number_format($order->shipping_charge,2)}}</td>
                           <td>{{currency().number_format($order->grand_total,2)}}</td>
                           <td>{{$order->quantity}}</td>
                           <td>{{$order->payment_name}}</td>
                           <td>{{date('d-m-Y', strtotime($order->created_at))}}</td>
                           <td>{{$order->status}}</td>

                         </tr>

                      @endforeach
                      
                       </tbody>
                       
                   </table>
   
               </div>
           </div>
       </div> <!-- end col -->
   </div> <!-- end row -->
@endsection
@section('js')
  <script>
    $(document).ready(function(){
          $('#datatable_table').DataTable();
    });
  </script>
@endsection
