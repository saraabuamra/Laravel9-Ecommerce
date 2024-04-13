$(document).ready(function(){
$("#getPrice").change(function(){
    var size = $(this).val();
    var product_id = $(this).attr("product_id");
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
        type:'post',
        url:'/get-product-price',
        data:{size:size,product_id:product_id},
        success:function(resp){
          if(resp['discount']>0){
             $(".getAttributePrice").html("<div class='price'><h4>$"+resp['final_price']+"</h4></div><div class='original-price'><span>Original Price: </span><span>$"+resp['product_price']+"</span></div>");
          }else{
            $(".getAttributePrice").html("<div class='price'><h4>$"+resp['final_price']+"</h4></div>");
          }
        },error:function(){
           alert("Error");
        }
   });
  });
 });

//Update Cart Items Qty
$(document).on("click",".updateCartItem",function(){
  if($(this).hasClass('plus-a')){
    // Get Qty
    var quantity = $(this).data('qty');
    // increase the qty by 1
    new_qty = parseInt(quantity) + 1;
    /*alert(new_qty);*/
  }
  if($(this).hasClass('minus-a')){
    // Get Qty
    var quantity = $(this).data('qty');
    // Check Qty is atleast 1
    if(quantity<=1){
      alert("Item quantity must be 1 or greater!");
      return false;
    }
    // increase the qty by 1
    new_qty = parseInt(quantity) - 1;
    //  alert(new_qty);
  }
  var cartid = $(this).data('cartid');
  $.ajax({
    headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
    data:{cartid:cartid,qty:new_qty},
    url:'/cart/update',
    type:'post',
    success:function(resp){
      $(".totalCartItems").html(resp.totalCartItems);
      if(resp.status==false){
        alert(resp.message);
      }
      $("#appendCartItems").html(resp.view);
    },error:function(){
      alert("Error");
    }
  });
});

//delete Cart Item
$(document).on("click",".deleteCartItem",function(){
  var cartid = $(this).data('cartid');
  var result = confirm("Are you sure to delete this Cart Item?");
  if(result){
    $.ajax({
      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
      data:{cartid:cartid},
      url:'/cart/delete',
      type:'post',
      success:function(resp){
        $("#appendCartItems").html(resp.view);
      },error:function(){
        alert("Error");
      }
    });
  }

});




function get_filter(class_name){
 var filter = [];
 $('.'+class_name+':checked').each(function(){
 filter.push($(this).val());
 });
 return filter;
}