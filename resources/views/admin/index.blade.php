@extends("layouts.admin")
@section("title","Admin | Dashboard")
@section("breadcrumb","Dashboard")
@section("content")
    <div class="row">
        <div class="col-lg-4">
            <div class="card mini-stat bg-info">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="dripicons-broadcast bg-soft-primary text-primary float-right h4"></i>
                    </div>
                    <h6 class="text-uppercase mb-3 mt-0">Orders</h6>
                    <h5 class="mb-3">{{number_format(count($orders),2)}}</h5>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mini-stat bg-success">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="dripicons-box bg-soft-primary text-primary float-right h4"></i>
                    </div>
                    <h6 class="text-uppercase mb-3 mt-0">Sales</h6>
                    <h5 class="mb-3">{{currency().number_format($orders->sum('sub_total')),2}}</h5>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="dripicons-tags bg-soft-primary text-primary float-right h4"></i>
                    </div>
                    <h6 class="text-uppercase mb-3 mt-0">Products</h6>
                    <h5 class="mb-3">{{number_format($products,2)}}</h5>
                   
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card mini-stat bg-warning">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="dripicons-broadcast bg-soft-primary text-primary float-right h4"></i>
                    </div>
                    <h6 class="text-uppercase mb-3 mt-0">Category</h6>
                    <h5 class="mb-3">{{number_format($categories,2)}}</h5>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mini-stat bg-danger">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="dripicons-box bg-soft-primary text-primary float-right h4"></i>
                    </div>
                    <h6 class="text-uppercase mb-3 mt-0">Sub Category</h6>
                    <h5 class="mb-3">{{number_format($sub_categories,2)}}</h5>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mini-stat bg-dark">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="dripicons-tags bg-soft-primary text-primary float-right h4"></i>
                    </div>
                    <h6 class="text-uppercase mb-3 mt-0">Brands</h6>
                    <h5 class="mb-3">{{number_format($brands,2)}}</h5>
                   
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title mb-4">Overall Order Status</h4>
                   <canvas id="AdminPieChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title mb-4">Monthly Selling Report</h4>
                    
                    <canvas id="AdminBarChart" style="width:100%;max-width:600px"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title mb-4">Latest Product</h4>
                   <table id="tables_item" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                       <thead>
                       <tr>
                           <th>Serial</th>
                           <th>Name</th>
                           <th>Image</th>
                           <th>Price</th>
                       </tr>
                       </thead>

                       <tbody>
                           @foreach ($new_products as $new_product)
                             
                           <tr>
                               <td>{{$loop->index+1}}</td>
                               <td><a href="{{ route('product.detail',$new_product->id)}}" target="_blank">{{$new_product->name}}</a></td>
                               <td><img src="{{ asset('assets/backend/image/product/small/'.$new_product->thumbnail) }}" style="width: 50px;height: 25px"></td>
                               <td>{{currency().number_format($new_product->current_price,2)}}</td>
                           </tr>
                            @endforeach
                       </tbody>
                      
                   </table>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title mb-4">Flash Deal Product</h4>
                    <table id="tables_item" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                       <thead>
                       <tr>
                           <th>Serial</th>
                           <th>Name</th>
                           <th>Image</th>
                           <th>Discount</th>
                           <th>Price</th>
                       </tr>
                       </thead>

                       <tbody>
                           @foreach ($flash_deals as $product)
                             
                           <tr>
                               <td>{{$loop->index+1}}</td>
                               <td><a href="{{ route('product.detail',$new_product->id)}}" target="_blank">{{$product->name}}</a></td>
                               <td><img src="{{ asset('assets/backend/image/product/small/'.$product->thumbnail) }}" style="width: 50px;height: 25px"></td>
                               <td>{{$product->discount}}%</td>
                               <td>
                                {{currency().number_format($product->current_price-($product->current_price*$product->discount)/100,2)}}
                                <del>{{currency().number_format($product->current_price,2)}}</del>
                              </td>
                           </tr>
                            @endforeach
                       </tbody>
                      
                   </table>
                </div>
            </div>
        </div>
    </div>


     <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title mb-4">Latest Categories</h4>
                   <table id="tables_item" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                       <thead>
                       <tr>
                           <th>Serial</th>
                           <th>Category Name</th>
                           <th>Image</th>
                       </tr>
                       </thead>

                       <tbody>
                           @foreach ($new_categories as $new_category)
                          <tr>
                              <td>{{$loop->index+1}}</td>
                              <td>{{$new_category->category_name}}</td>
                                <td><img src="{{  $new_category->image !=null ? asset('assets/backend/image/category/small/'.$new_category->image) : asset('assets/backend/image/'.default_image()) }}" style="width: 50px;height: 25px"></td>
                          </tr>
                            @endforeach
                       </tbody>
                      
                   </table>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title mb-4">Latest Brands</h4>
                    <table id="tables_item" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Brand Name</th>
                            <th>Image</th>
                           
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($new_brands as $new_brand)
                              
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$new_brand->brand_name}}</td>
                                  <td><img src="{{  $new_brand->image !=null ? asset('assets/backend/image/brand/small/'.$new_brand->image) : asset('assets/backend/image/'.default_image()) }}" style="width: 50px;height: 25px"></td>
                            </tr>
                             @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/backend/style/js/chart.js') }}"></script>
    <script>
      
        var xValues = [@foreach ($orders_pie as $key=> $val)"{{ $val->status}}", @endforeach];
        var yValues = [@foreach ($orders_pie as $val)"{{ $val->total}}",@endforeach];
        var barColors = ["#b91d47","#00aba9","#2b5797","#e8c3b9", "#1e7145"];

        new Chart("AdminPieChart", {
          type: "pie",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            title: {
              display: true,
              text: "Order Status Symbol"
            }
          }
        });


    var xValues = ["Jan", "Fab", "March", "March", "May","June","July","Aug","Sept","Oct","Nov","Dec"];
    var yValues = [@for ($i = 0; $i <12 ; $i++){{$month_salling[$i]}}{{ $i!=11 ? ",": ""}}@endfor];
     var barColors = ["#FF9933", "#669900","#000033","#669900","#CC0099","#D35400","#AD1457","#1F618D","#A93226","#7B1FA2","#FF5733","#512E5F"];


    new Chart("AdminBarChart", {
      type: "bar",
      data: {
        labels: xValues,
        datasets: [{
          backgroundColor: barColors,
          data: yValues
        }]
      },
      options: {
        legend: {display: false},
            title: {
              display: true,
              text: "Selling Report Symbol"
            }
    }
    });
     
    </script>
@endsection