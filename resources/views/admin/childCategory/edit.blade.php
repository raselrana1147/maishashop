@extends("layouts.admin")
@section("title","DPG Admin | Sub Category Update")
@section("breadcrumb","Sub Category Update")
@section("content")
      <div class="message_section" style="display: none"></div>
   <div class="row">

       <div class="col-lg-8 offset-2">
           <div class="card">
               <div class="card-body">
   					 <a href="javascript:history.back();" class="btn btn-primary btn-icon float-right mb-2">
   					 	   <span class="btn-icon-label"><i class="fas fa-arrow-left mr-2"></i></span>Back</a>
                   <form id="submit_form" class="custom-validation" data-action="{{ route('admin.childcategory_update') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                       <input type="hidden" name="id" value="{{$data->id}}">
                       <div class="form-group">
                           <label>Child Category Name</label>
                           <input type="text" class="form-control" name="child_cat_name" required value="{{$data->child_cat_name}}" />
                       </div>


                         <div class="form-group">
                           <label>Sub Category Name</label>
                           
                            <select class="form-control" name="sub_category_id">
                               <option value="">Select One</option>
                              @foreach ($subcategories as $subcategory)
                                  <option value="{{$subcategory->id}}" {{$data->sub_category_id==$subcategory->id ? 'selected' : ''}}>{{$subcategory->sub_cat_name}}</option>

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
                        $(".submit_button").text("Submit").prop('disabled', false)
                        $('.message_section').html('').hide();
                    },

                    error:function(response){
                        var errors=response.responseJSON
                         if (response.responseJSON.errors['category_name']) 
                         Swal.fire(error)
                       
                        $(".submit_button").text("Submit").prop('disabled', false)

            
                    }

                  });
            });
    })
</script>

@endsection