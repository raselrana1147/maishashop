@extends("layouts.admin")
@section("title","Admin | Product Update")
@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
  {{-- <link href="{{ asset('assets/style/css/summernote.css') }}" rel="stylesheet"> --}}
  <link href="{{ asset('assets/backend/style/css/select2.css') }}" rel="stylesheet" />
@endsection
@section("breadcrumb","Product Update")
@section("content")

      <div class="message_section" style="display: none">
        
      </div> 
      <a href="javascript:history.back();" class="btn btn-primary btn-icon float-right mb-2">
                 <span class="btn-icon-label"><i class="fas fa-arrow-left mr-2"></i></span>Back</a><br><br><br>
  <form id="submit_form" class="custom-validation" data-action="{{ route('admin.product_update') }}" enctype="multipart/form-data" method="POST">
   <div class="row">
      <input type="hidden" name="id"  value="{{$product->id}}">
       <div class="col-lg-6">
        
           <div class="card">
               <div class="card-body">
   
                     @csrf
                       <div class="form-group">
                           <label>Name</label>
                           <input type="text" class="form-control" name="name" required value="{{$product->name}}" />
                       </div>
   
                       <div class="form-group">
                           <label>Product Short Detail (optional)</label>
                           <div>
                               <input type="text" name="detail" class="form-control" required value="{{$product->detail}}"/>
                           </div>
                   
                       </div>
   
                       <div class="form-group">
                           <label>Category</label>
                           <div>
                              <select class="form-control" name="category_id" id="find_sub_category" data-action="{{ route('find_sub_category') }}" required="">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                   <option {{($category->id==$product->category_id) ? 'selected' : ''}} value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                              </select>
                           </div>
                       </div>

                       <div class="form-group">
                           <label>Sub Category</label>
                           <div>
                              <select class="form-control load_sub_cat" name="sub_category_id" id="find_child_category" data-action="{{ route('find_child_category') }}">
                                @if ($product->sub_category_id !=null)
                                 <option value="{{$product->sub_category_id}}">{{$product->sub_category->sub_cat_name}}</option>
                                @endif
                               
                              </select>
                           </div>
                       </div>

                         <div class="form-group">
                           <label>Child Category</label>
                           <div>
                              <select class="form-control load_child_cat" name="child_category_id">
                                @if ($product->child_category_id !=null)
                                 <option value="{{$product->child_category_id}}">{{$product->child_category->child_cat_name}}</option>
                                @endif
                              </select>
                           </div>
                       </div>

                        <div class="form-group">
                           <label>Brand</label>
                           <div>
                              <select class="form-control" name="brand_id" required="">
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                   <option {{($brand->id==$product->brand_id) ? 'selected' : ''}} value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                @endforeach
                               
                              </select>
                           </div>
                       </div>

                       <div class="form-group">
                           <label>Product type</label>
                            <select class="form-control" name="product_type_id" required="">
                                <option value="">Select product type</option>
                                @foreach ($producttypes as $p_type)
                                   <option {{($p_type->id==$product->product_type_id) ? 'selected' : ''}} value="{{$p_type->id}}">{{$p_type->type_name}}</option>
                                @endforeach
                               
                              </select>
                       </div>
                       
                       <div class="form-group">
                           <label>Previous Price <span class="pl-1">(Optional)</span></label>
                           <div>
                               <input type="number" class="form-control" name="previous_price" value="{{$product->previous_price}}" min="1" />
                           </div>
                       </div>

                        <div class="form-group">
                           <label>Current Price</label>
                           <div>
                               <input type="number" class="form-control" name="current_price" required value="{{$product->current_price}}" min="1" />
                           </div>
                       </div>

                       <div class="form-group">
                           <label>Discount <span class="pl-1">(Optional)</span></label>
                           <div>
                               <input type="number" class="form-control" name="discount" value="{{$product->discount}}"/>
                           </div>
                       </div>

                       

                       <div class="form-group">
                        @php
                            $sizes=json_decode($product->size);
                        @endphp
                           <label>Size</label><span class="pl-1">(Optional)</span><i data-toggle="tooltip" data-placement="top" 
                           data-original-title="Product Size." 
                           class="mdi mdi-information"></i>
                           <select class="form-control add_size" name="sizes[]" multiple="multiple" required>
                               @if (!is_null($sizes))
                               @foreach ($sizes as $size)
                                   <option selected="selected">{{$size}}</option>
                               @endforeach
                             @endif
                           </select>
                       </div>


                        <div class="form-group">
                          @php
                              $colors=json_decode($product->color);
                          @endphp
                           <label>Color</label><span class="pl-1">(Optional)</span><i data-toggle="tooltip" data-placement="top" 
                           data-original-title="Product Color. Color must be direct color name or hexacode color (black, #000000)" 
                           class="mdi mdi-information"></i>
                           <select class="form-control add_color" name="colors[]" multiple="multiple" required>
                             @if (!is_null($colors))
                             @foreach ($colors as $color)
                                 <option selected="selected">{{$color}}</option>
                             @endforeach
                              @endif
                           </select>
                       </div> 

                       

               </div>
           </div>
       </div> <!-- end col -->
   
       <div class="col-lg-6">
           <div class="card">
               <div class="card-body">

                 <div class="form-group">
                           <label>Thumbnail</label>
                           <div>
                               <input type="file" class="form-control dropify" name="thumbnail" data-default-file="{{($product->thumbnail !==null) ? asset('assets/backend/image/product/small/'.$product->thumbnail) : asset('assets/backend/image/default.png') }}"/>
                           </div>
                       </div>
  
                       <div class="form-group">
                           <label>Description</label>
                           <div>
                               <textarea class="form-control summernote" name="description" required="true">{{$product->description}}</textarea>
                           </div>
                       </div>

                        <div class="form-group">
                           <label>Specification</label>
                           <div>
                               <textarea class="form-control summernote" name="specification"  required="true">{{$product->specification}}</textarea>
                           </div>
                       </div>

                        <div class="form-group">
                           <label>Return Policy</label>
                           <div>
                               <textarea class="form-control summernote" name="return_policy" required="true">{{$product->return_policy}}</textarea>
                           </div>
                       </div>
                        <div class="form-group mb-0">
                           <div>
                               <button type="submit" class="submit_button btn btn-primary waves-effect waves-light mr-1">
                                  Save Changes
                               </button>
                             
                           </div>
                       </div>
               </div>
           </div>

       </div> <!-- end col -->
         
   </div> <!-- end row -->
    </form>
@endsection

@section('js')
<script src="{{ asset('assets/backend/style/js/summernote.js') }}"></script>
<script src="{{ asset('assets/backend/style/js/select2.js') }}"></script>

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
                        
                         if (data.status_code==201) 
                         {
                           $('.message_section').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">`+data.message+`<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                            </button>
                           </div>`).show();
                            $(".submit_button").text("Submit").prop('disabled', false)
                         }else{
                              $(".submit_button").text("Save Changes").prop('disabled', false)
                              $('.message_section').html('').hide();
                               toastr.success(data.message);
                          }
                       
                    },
                    error:function(response){
                        var errors=response.responseJSON   
                    }

                  });
            });

        $('body').on('change','#find_sub_category',function(){
                  let category_id=$(this).val();

                  $.ajax({
                  url: $(this).attr('data-action'),
                  method: "POST",
                  data:{category_id:category_id},

                  success:function(data){
                    
                    var setItem='';
                    data.subcategoryes.forEach(function(item,index){
                       // console.log(item.name)
                        setItem+='<option value="'+item.id+'">'+item.sub_cat_name+'</option>'
                    });
                     $('.load_sub_cat').html(setItem);
                    $('.load_child_cat').html("");
                  },

                  error:function(response){
                  }
                });
          });


          $('body').on('change','#find_child_category',function(){
                  let sub_category_id=$(this).val();

                  $.ajax({
                  url: $(this).attr('data-action'),
                  method: "POST",
                  data:{sub_category_id:sub_category_id},

                  success:function(data){
                    
                    var setItem='';
                    data.childcategories.forEach(function(item,index){
                    
                        setItem+='<option value="'+item.id+'">'+item.child_cat_name+'</option>'
                    });
                     $('.load_child_cat').html(setItem);
                  },

                  error:function(response){
                  }
                });
          });

             $('body').on('change','#find_child_category',function(){
                  let sub_cat_id=$(this).val();

                  $.ajax({
                  url: $(this).attr('data-action'),
                  method: "POST",
                  data:{category_id:category_id},

                  success:function(data){
                    
                    var setItem='';
                    data.subcategoryes.forEach(function(item,index){
                       // console.log(item.name)
                        setItem+='<option value="'+item.id+'">'+item.sub_cat_name+'</option>'
                    });
                     $('.load_sub_cat').html(setItem);
                  },

                  error:function(response){
                  }
                });
          });

         $('.summernote').summernote();

             //===select2=====
         $(".add_size").select2({
             tags: true,
             tokenSeparators: [',', ' ']
         })
         $(".add_color").select2({
             tags: true,
             tokenSeparators: [',', ' ']
         })

    })
</script>

@endsection