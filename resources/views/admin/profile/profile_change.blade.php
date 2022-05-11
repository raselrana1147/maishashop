@extends("layouts.admin")
@section("title","Admin | Change Profile")
@section("breadcrumb","Change Profile")
@section('css')
  <style>
    .profile_image{
           width: 170px !important;
           height: 170px !important;
           background: #f30f55 !important;
           border-radius: 50%;
       }
     .upload_button{
             border-radius: 7px;
             margin-top: 6px;
     }
    .display-none{
           display: none
     }
  </style>
@endsection
@section("content")
      <div class="message_section" style="display: none">
        
      </div>
   <div class="row">

       <div class="col-lg-8 offset-2">
           <div class="card">
               <div class="card-body">
   					 
                   <form id="submit_form" class="custom-validation" data-action="{{ route('admin.change_profile') }}"  method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row pb-4">
                     <div class="offset-4">
                        <div class="text-center">
                           <img id="profile_image_path" src="{{Auth::user()->avatar !=null ? asset('assets/backend/image/profile/'.Auth::user()->avatar) : asset('assets/backend/image/'.default_image())}}"  class="profile_image" alt="customer image"><br>
                           <button type="button" class="btn btn-dark btn-sm upload_button" role="button"><i class="fa fa-upload"></i>Upload</button>
                        </div>
                        <input type="file" id="image_path" name="avatar" class="get_image" style="display: none">
                        <input type="hidden" name="id" value="{{Auth::user()->id}}">
                     </div>
                    </div>

                       <div class="form-group">
                           <label>Name</label>
                           <input type="text" class="form-control" name="name" required value="{{AUth::user()->name}}" />
                       </div>

                       <div class="form-group">
                           <label>phone</label>
                           <input type="text" class="form-control" name="phone" value="{{AUth::user()->phone}}" />
                           <span class="text-danger error_phone"></span>
                       </div>

                       <div class="form-group">
                           <label>Address</label>
                           <textarea name="address" class="form-control">{{Auth::user()->address}}</textarea>
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
                              $(".submit_button").text("Submit").prop('disabled', false)
                        }
                       
                    },

                    error:function(response)
                    {
                      if (response.status === 422) {
                         
                              if (response.responseJSON.errors.hasOwnProperty('phone')) {
                                  $('.error_phone').html(response.responseJSON.errors.phone)      
                              }else{
                                  $('.error_phone').html('') 
                              }
                              $(".submit_button").text("Submit").prop('disabled', false)
                      }
                    }



                  });
            });


        $('body').on('click','.upload_button',function(){
              $('.get_image').trigger('click')
          })

        $('.get_image').on('change',function(){
            const profile_image_path = document.querySelector('#profile_image_path');
            const image_path = document.querySelector('#image_path').files[0];
            const reader = new FileReader();
            reader.addEventListener("load", function () {
              profile_image_path.src = reader.result;
            }, false);

            if (image_path) {
              reader.readAsDataURL(image_path);
            }
        });

    })
</script>

@endsection