@extends("layouts.admin")
@section("title","Admin | Change Password")
@section("breadcrumb","Change Password")
@section("content")
      <div class="message_section" style="display: none">
        
      </div>
   <div class="row">

       <div class="col-lg-8 offset-2">
           <div class="card">
               <div class="card-body">
   					 
                   <form id="submit_form" class="custom-validation" data-action="{{ route('admin.change_password') }}"  method="POST">
                    @csrf

                       <div class="form-group">
                           <label>Old Password</label>
                           <input type="password" class="form-control" name="old_password" required placeholder="Enter old password"/>
                       </div>

                       <div class="form-group">
                           <label>New Password</label>
                           <input type="password" class="form-control" name="new_password" required placeholder="Enter new password"/>
                       </div>

                       <div class="form-group">
                           <label>Confirm Password</label>
                           <input type="password" class="form-control" name="password_confirmation" required placeholder="Enter confirm password"/>
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
                    success:function(response){
                        let data=JSON.parse(response);
                        if (data.status==200) {
                               toastr.success(data.message);
                              $("#submit_form")[0].reset();
                              $(".submit_button").text("Submit").prop('disabled', false)
                        }else{

                             toastr.warning(data.message);
                            $("#submit_form")[0].reset();
                            $(".submit_button").text("Submit").prop('disabled', false)
                        }
                        
                       
                    },

                   

                  });
            });

    })
</script>

@endsection