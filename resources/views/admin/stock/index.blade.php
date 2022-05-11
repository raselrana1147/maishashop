@extends("layouts.admin")
@section("title","Admin | Product Gallery")
@section("breadcrumb","Product Gallery")
@section("content")
<div class="row">
  <div class="col-6 offset-3">
    <div class="card">
        <div class="card-body">
       <a href="javascript:history.back();" class="btn btn-primary btn-icon float-right mb-2">
           <span class="btn-icon-label"><i class="fas fa-arrow-left mr-2"></i></span>Back</a>
            <form id="submit_form" class="custom-validation" data-action="{{ route('admin.stock_store') }}"  method="POST">
             @csrf
                <input type="hidden" name="product_id" value="{{$product->id}}">

                <div class="form-group">
                    <label>Quantity</label>
                    <input type="text" class="form-control" name="quantity" required placeholder="Enter quantity"/>
                </div>
              <div class="form-group">
                  <label>Color</label>
                  <div>
                     <select class="form-control" name="color_id" required="">
                       <option value="">Select Color</option>
                       @foreach ($colors as $color)
                          <option value="{{$color->id}}">{{$color->color_name}} <span>{{$color->color_code}}</span></option>
                       @endforeach
                     </select>
                  </div>
              </div>

                  <div class="form-group">
                  <label>Color</label>
                  <div>
                     <select class="form-control" name="size_id" required="">
                       <option value="">Select Color</option>
                       @foreach ($sizes as $size)
                          <option value="{{$size->id}}">{{$size->size_name}} <span>{{$size->size_code}}</span></option>
                       @endforeach
                     </select>
                  </div>
              </div>
                <div class="form-group mb-0">
                    <div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 submit_button">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
    
        </div>
    </div>
  </div>
</div>
   <div class="row">
       <div class="col-12">
                
           <div class="card">
               <div class="card-body">
                    <h4 class="mt-0 header-title">Product Gallery Image List</h4>
                   <table id="tables_item" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                       <thead>
                       <tr>
                           <th>Serial</th>
                           <th>Product Name</th>
                           <th>Color Name</th>
                           <th>Color Code</th>
                           <th>Size Name</th>
                           <th>Size Code</th>
                           <th>Quantity</th>
                           <th>Action</th>

                       </tr>
                       </thead>
                       <tbody>
                        @foreach ($stocks as $stock)
                         <tr class="hide_row{{$stock->id}}">
                           <td>{{$loop->index+1}}</td>
                           <td>{{$stock->product->name}}</td>
                           <td>{{$stock->color->color_name}}</td>
                           <td>{{$stock->color->color_code}} <span style="background-color: {{$stock->color->color_code}};color: {{$stock->color->color_code}}">color code</span></td>
                           <td>{{$stock->size->size_name}}</td>
                           <td>{{$stock->size->size_code}}</td>
                           <td>{{$stock->quantity}}</td>
                         
                           <td>
                             <a href="{{ route('admin.stock_edit',$stock->id) }}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                               <a href="javascript:;" class="btn btn-danger btn-sm delete_item" data-action="{{ route('admin.stock_delete') }}"  item_id="{{$stock->id}}">
                               <i class="fa fa-trash"></i>
                              </a>
                           </td>
                          
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

              $('body').on('submit','#submit_form',function(e){
                        e.preventDefault();
                        let formDta = new FormData(this);
                     $(".submit_button").html("Processing...").prop('disabled', true)
                  
                        $.ajax({
                          url: $(this).attr('data-action'),
                          method: "POST",
                          data: formDta,
                          cache: false,
                          contentType: false,
                          processData: false,
                          success:function(data){
                              if (data.type=="success") 
                              {
                                 toastr.success(data.message);
                                 $("#submit_form")[0].reset();
                                 $(".submit_button").text("Submit").prop('disabled', false)
                                 $('.message_section').html('').hide();
                                 location.reload();
                              }else
                              {
                                 toastr.error(data.message);
                                 $(".submit_button").text("Submit").prop('disabled', false)
                              }
    
                          },

                          error:function(response){}

                        });
                  });

              
              $('body').on('click','.delete_item',function(){

                let item_id=$(this).attr('item_id');
                swal({
                  title: "Do you want to delete?",
                  icon: "info",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                       $.ajax({
                          url:$(this).attr('data-action'),
                          method:'post',
                          data:{item_id:item_id},
                          success:function(data){
                             toastr.success(data.message);
                              $('.hide_row'+item_id).hide();
                             
                          }

                       }); 
                
                  } 
                });
              })

            
        })
    </script>
@endsection()