@extends("layouts.admin")
@section("title","Admin | Size Update")
@section("breadcrumb","Size Update")
@section("content")
      <div class="message_section" style="display: none"></div>
   <div class="row">

       <div class="col-lg-8 offset-2">
           <div class="card">
               <div class="card-body">
   					 <a href="javascript:history.back();" class="btn btn-primary btn-icon float-right mb-2">
   					 	   <span class="btn-icon-label"><i class="fas fa-arrow-left mr-2"></i></span>Back</a>
                   <form id="submit_form" class="custom-validation" data-action="{{ route('admin.size_update') }}" method="POST">
                    @csrf
                       <input type="hidden" name="id" value="{{$size->id}}">
                       <div class="form-group">
                           <label>Size Name</label>
                           <input type="text" class="form-control" name="size_name" required value="{{$size->size_name}}" />
                       </div>

                       <div class="form-group">
                           <label>Size Code</label>
                           <input type="text" class="form-control" name="size_code" required value="{{$size->size_code}}" />
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
                        var error=response.responseJSON.error
                        var errors=response.responseJSON
                         if (response.responseJSON.errors['size_code']) 
                         {
                             $('.message_section').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">`+response.responseJSON.errors['size_code']+`<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                            </button>
                           </div>`).show();
                           $(".submit_button").text("Submit").prop('disabled', false)
                          }     
                        
                        $(".submit_button").text("Submit").prop('disabled', false) 
                    
                    }

                  });
            });
    })
</script>

@endsection