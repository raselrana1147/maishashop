 $(document).ready(function(){

	$('body').on('submit','#submit_cart_form',function(e){
		   e.preventDefault();
		   let formDta = new FormData(this);
		   $.ajax({
		     url: $(this).attr('data-action'),
		     method: "POST",
		     data: formDta,
		     cache: false,
		     contentType: false,
		     processData: false,
		     success:function(response){
		         let data=JSON.parse(response)
		         if (data.type=="success") 
		         {
		         	$('.message_part').html('<p class="font-weight-bold alert alert-success ">'+'✔ '+data.message+'</p>').show()
		         	$('.cart-count').html(data.total_item)
		         	$('.cart-item-added').html(data.carts);
		         	

		         	setTimeout(function(){
		         		$('.message_part').fadeOut('slow')
		         	},5000)
		         	
		         }else
		         {
		         	$('.message_part').html('<div class="alert alert-danger">'+data.message+'</div>').show()

		         	setTimeout(function(){
		         		$('.message_part').fadeOut('slow')
		         	},5000)
		         }
		     },

		     error:function(response){}

		   });
	});
	/// cart remove

	$('body').on('click','.delete_cart',function(e){
		e.preventDefault();
		let cart_id=$(this).attr('cart_id');
		
	       $.ajax({
	          url:$(this).attr('data-action'),
	          method:'post',
	          data:{cart_id:cart_id},
	          success:function(response){
	             let data=JSON.parse(response)
	             if (data.type=="success") 
	             {
	             	$('.message_part').html('<p class="font-weight-bold alert alert-success ">'+'✔ '+data.message+'</p>').show()
	             	$(".cart-count").html(data.total_item)
	             	$(".cart-item-added").html(data.carts);
	             	$(".sub_total").html(data.sub_total);
	             	$('.cart_row'+cart_id).hide()

	             	if (data.total_item==0) 
	             	{
	             	    $('.empty_cart').html('<h4 class="text-center">Empty Cart</h4>')
	             	}
	             	setTimeout(function(){$('.message_part').fadeOut('slow')},5000)
	             	
	             }
	          }
	       }); 
	})

		/// cart update

	$('body').on('change','.cart-product-quantity',function(e){
		e.preventDefault();

		let cart_id=$(this).attr('cart_id');
		let quantity=$(this).val();
		let product_id=$(this).attr('product_id');


	       $.ajax({
	          url:$(this).attr('data-action'),
	          method:'post',
	          data:{cart_id:cart_id,quantity:quantity,product_id:product_id},
	          success:function(response){
	             let data=JSON.parse(response)

	             if (data.type=="success") 
	             {
	             	
	             	$('.message_part').html('<p class="font-weight-bold alert alert-success ">'+'✔ '+data.message+'</p>').show()
	             	$(".cart-count").html(data.total_item)
	             	$(".cart-item-added").html(data.carts);
	             	$(".cart_subtotal").html(data.sub_total);
	             	$(".each_cart_price"+cart_id).html(data.each_cart_price);

	             	setTimeout(function(){$('.message_part').fadeOut('slow')},5000)	
	             	
	             }else
	             {
	             	toastr.error(data.message);
	             }
	          }
	       }); 
	})



})