@extends("layouts.admin")
@section("title","DPG Admin | Child Category Create")
@section("breadcrumb","Child Category Create")
@section("content")
      <div class="message_section" style="display: none">
        
      </div>
   <div class="row">

       <div class="col-lg-8 offset-2">
           <div class="card">
               <div class="card-body">
   					 <a href="javascript:history.back();" class="btn btn-primary btn-icon float-right mb-2">
   					 	   <span class="btn-icon-label"><i class="fas fa-arrow-left mr-2"></i></span>Back</a>
                   <form id="submit_form" class="custom-validation" data-action="{{ route('admin.childcategory_store') }}" method="POST">
                    @csrf

                       <div class="form-group">
                           <label>Child Category Name</label>
                           <input type="text" class="form-control" name="child_cat_name" required placeholder="Enter Name"/>
                       </div>

                        <div class="form-group">
                           <label>Sub Category Name</label>
                           
                            <select class="form-control" name="sub_category_id" required="">
                              @foreach ($subcategories as $sub_cat)
                                  <option value="{{$sub_cat->id}}">{{$sub_cat->sub_cat_name}}</option>
                              @endforeach
                            </select>               
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
                         toastr.success(data.message);
                        $("#submit_form")[0].reset();
                        $(".submit_button").text("Submit").prop('disabled', false)
                        $('.message_section').html('').hide();
                    },

                    error:function(response){
                        var error=response.responseJSON.error
                        Swal.fire(error)
                       
                        $(".submit_button").text("Submit").prop('disabled', false)
                          
                    }

                  });
            });

        $('body').on('change','#select_category',function(){
                  let category_id=$(this).val();

                  $.ajax({
                  url: $(this).attr('data-action'),
                  method: "POST",
                  data:{category_id:category_id},
                  
                  success:function(data){
                    var setItem='';
                    data.subcategories.forEach(function(item,index){
                        console.log(item.sub_cat_name)
                        setItem+='<option value="'+item.id+'">'+item.sub_cat_name+'</option>'
                    });

                     $('#loadAllsubcat').html(setItem);
                   
                  },

                  error:function(response){
                          Swal.fire(error)
                          
                          $(".submit_button").text("Submit").prop('disabled', false)
                  }

                });
          });


    })
</script>

@endsection