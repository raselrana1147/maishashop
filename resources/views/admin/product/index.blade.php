@extends("layouts.admin")
@section("title","Admin | Product List")
@section("breadcrumb","Product List")
@section('css')
 <style>
   .product-status{
           margin-left: 100px
      }
   .product-status span{
       position: absolute;
       padding-left: 10px;
      
   }
 </style>
@endsection
@section("content")
   <div class="row">
       <div class="col-12">
           <div class="card">
               <div class="card-body">
                     <a href="{{ route('admin.product_create') }}" class="btn btn-primary btn-icon float-right"><span class="btn-icon-label"><i class="fas fa-plus mr-2"></i></span>Add New</a>
                    <h4 class="mt-0 header-title">Product List</h4>
                   <table id="tables_item" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                       <thead>
                       <tr>
                           <th>Serial</th>
                           <th>Name</th>
                           <th>Previous Price</th>
                           <th>price</th>
                           <th>Image</th>
                           <th>Attributes</th>
                           <th>Action</th>
                       </tr>
                       </thead>
                      
                   </table>
   
               </div>
           </div>
       </div> <!-- end col -->
   </div> <!-- end row -->
    <p id="product_link">my name is rasel</p>
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Product Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <div class="product-status">
                 
                    <input type="hidden" class="store_product_id" name="store_product_id" value="" data-action="{{ route('admin.update_product_status') }}">
                 

                  <div>
                      <input type="checkbox" id="featured" switch="dark" class="change_product_status" status_type="featured"/>
                      <label for="featured" data-on-label="Yes" data-off-label="No"></label><span>Featured</span>
                  </div>

                  

                  <div>
                      <input type="checkbox" id="top_sale" switch="dark" class="change_product_status" status_type="top_sale"/>
                      <label for="top_sale" data-on-label="Yes" data-off-label="No"></label><span>Top Sale</span>
                  </div>

                  <div>
                      <input type="checkbox" id="trending" switch="dark" class="change_product_status" status_type="trending"/>
                      <label for="trending" data-on-label="Yes" data-off-label="No"></label><span>Treanding</span>
                  </div>
                  

                 </div>
            </div>
            
        </div>
    </div>
     </div>
@endsection
@section('js')
<script src="{{ asset('assets/backend/style/js/click_board.js') }}"></script>

 <script>
         var table = $("#tables_item").DataTable({
             processing: true,
             responsive: true,
             serverSide: true,
             ordering: false,
             pagingType: "full_numbers",
             ajax: '{{ route('admin.load_product') }}',
             columns: [
                 { data: 'id',name:'id' },
                 { data: 'name',name:'name'},
                 { data: 'previous_price',name:'previous_price'},
                 { data: 'current_price',name:'current_price'},
                 { data: 'thumbnail',name:'thumbnail'},
                 { data: 'attribute',name:'attribute'},
                 { data: 'action',name:'action' },
             ],

              language : {
                   processing: 'Processing'
               },
              
         });
    </script>
    <script>
        $(document).ready(function(){
              
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
                             $('#tables_item').DataTable().ajax.reload();
                             
                          }

                       }); 
                
                  } 
                });
              })

              // show product status

        $('body').on('click','.show_product_status',function(e){
          e.preventDefault();
          let product_id=$(this).attr('product_id');
           $.ajax({
              url: $(this).attr('data-action'),
              method: "POST",
              data:{product_id:product_id},
              success:function(response){
                let data=response.product;
                
                $(".store_product_id").val(data.id)

                  if (data.featured==0) 
                  {
                    $('#featured').prop('checked', true)
                  }else
                  {
                    $('#featured').prop('checked', false)
                  }
                  if (data.top_sale==0) 
                  {
                    $('#top_sale').prop('checked', true)
                  }else
                  {
                    $('#top_sale').prop('checked', false)
                  }
              
                  if (data.trending==0) 
                  {
                    $('#trending').prop('checked', true)
                  }else
                  {
                    $('#trending').prop('checked', false)
                  }
              },
           })

        });


        // change product status

        $('body').on('click','.change_product_status',function(){

              let type=$(this).attr('status_type');
              let product_id=$(".store_product_id").val();

              $.ajax({
                 url: $(".store_product_id").attr('data-action'),
                 method: "POST",
                 data:{product_id:product_id,type:type},
                 success:function(data){
                   
                    toastr.success(data.message);
                 },
              })
        })

              //====copy product url========
            $('body').on('click','.copy_link',function(e){
                    $(this).html('<span class="btn-icon-label"><i class="fas fa-copy"></i></span>Copying')
                    e.preventDefault();
                    var url = $(this).attr('data-action');
                    document.addEventListener('copy', function(e) {
                       e.clipboardData.setData('text/plain', url);
                       e.preventDefault();
                    }, true);
                    document.execCommand('copy');
                   setInterval(function(){
                           $(".copy_link").html('<span class="btn-icon-label"><i class="fas fa-copy"></i></span>Copy Link')
                    },500);
              })
        })

  
    </script>
@endsection()