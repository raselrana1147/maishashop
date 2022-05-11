@extends("layouts.admin")
@section("title","Admin | Color Update")
@section("breadcrumb","Color Update")
@section("content")
      <div class="message_section" style="display: none"></div>
   <div class="row">

       <div class="col-lg-8 offset-2">
           <div class="card">
               <div class="card-body">
   					 <a href="javascript:history.back();" class="btn btn-primary btn-icon float-right mb-2">
   					 	   <span class="btn-icon-label"><i class="fas fa-arrow-left mr-2"></i></span>Back</a>
                   <form id="submit_form" class="custom-validation" data-action="{{ route('admin.color_update') }}" method="POST">
                    @csrf
                       <input type="hidden" name="id" value="{{$color->id}}">
                       <div class="form-group">
                           <label>Color Name</label>
                           <input type="text" class="form-control" name="color_name" required value="{{$color->color_name}}" />
                       </div>

                       <div class="form-group">
                           <label>Color Code</label>
                           <input type="text" class="form-control" name="color_code" required value="{{$color->color_code}}" />
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
                        
            
                    }

                  });
            });
    })
</script>

@endsection