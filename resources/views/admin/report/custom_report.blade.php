@extends("layouts.admin")
@section('css')
<link href="{{ asset('assets/backend/style/css/jquery-ui.css') }}" rel = "stylesheet">
<style type="text/css">
  .ui-widget-header{
    border: #ddd solid red !important;
    background: #000 !important
  }
</style>

@endsection
@section("title","Admin | Custom Report")
@section("breadcrumb",'Custome Report')
@section("content")

  <div class="row">
      <div class="col-12">
          <div class="card">
              <div class="card-body">
                  
                  <form action="{{ route('admin.generate_report') }}" method="post">
                    @csrf
                      <div class="row">
                          <div class="col-6">
                              <div class="form-group">
                                  <label>Shart Date</label>
                                  <input type="text" class="form-control" name="start_date" id="start_date" required>
                                  
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>End Date</label>
                                  <input type="text" class="form-control" name="end_date" id="end_date" required>
                              </div>
                          </div>
                      </div>
                      <button class="btn btn-primary" type="submit">Generate Report</button>
                  </form>
              </div>
          </div>
          <!-- end card -->
      </div> 
  </div>

  @if ($orders !=null)
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
                   
                    <h4 class="mt-0 header-title"> Custom Report</h4>
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
       </div> 
   </div> 
     @endif
@endsection
@section('js')
<script src = "{{ asset('assets/backend/style/js/jquery-ui.js') }}"></script>
  <script>
    $(document).ready(function(){
          $('#datatable_table').DataTable();

            $( "#start_date" ).datepicker({
                  maxDate: new Date(), 
            });
            $( "#end_date" ).datepicker({
                  maxDate: new Date()    
            });
    });
  </script>
@endsection
