@extends("layouts.admin")
@section("title","Admin | Stock Update")
@section("breadcrumb","Stock Update")
@section("content")
      <div class="message_section" style="display: none"></div>
   <div class="row">

       <div class="col-lg-8 offset-2">
           <div class="card">
               <div class="card-body">
   					 <a href="javascript:history.back();" class="btn btn-primary btn-icon float-right mb-2">
   					 	   <span class="btn-icon-label"><i class="fas fa-arrow-left mr-2"></i></span>Back</a>
                  <form id="submit_form" class="custom-validation" data-action="{{ route('admin.stock_update') }}"  method="POST">
                   @csrf
                      <input type="hidden" name="id" value="{{$stock->id}}">

                      <div class="form-group">
                          <label>Quantity</label>
                          <input type="text" class="form-control" name="quantity" required value="{{$stock->quantity}}" />
                      </div>
                    <div class="form-group">
                        <label>Color</label>
                        <div>
                           <select class="form-control" name="color_id" required="">
                             <option value="">Select Color</option>
                             @foreach ($colors as $color)
                                <option value="{{$color->id}}" {{$stock->color_id==$color->id ? 'selected' : ''}}>{{$color->color_name}} <span>{{$color->color_code}}</span></option>
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
                                <option value="{{$size->id}}" {{$stock->size_id==$size->id ? 'selected' : ''}}>{{$size->size_name}} <span>{{$size->size_code}}</span></option>
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

                    error:function(response){}

                  });
            });
    })
</script>

@endsection