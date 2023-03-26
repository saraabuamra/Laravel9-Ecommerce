$(document).ready(function(){
  //products Attributes Add/Remove Script
  var max_fields = 10; //Maximum allowed input fields 
  var wrapper    = $(".wrapper"); //Input fields wrapper
  var add_button = $(".add_fields"); //Add button class or ID
  var x = 1; //Initial input field is set to 1

//When user click on add input button
$(add_button).click(function(e){
      e.preventDefault();
  //Check maximum allowed input fields
      if(x < max_fields){ 
          x++; //input field increment
     //add input field
          $(wrapper).append('<div><div style="height:10px"></div><input type="text" name="size[]" placeholder="Size" value="" style="width:120px" />&nbsp;<input type="text" name="sku[]" placeholder="SKU" value="" style="width:120px" />&nbsp;<input type="text" name="price[]" placeholder="Price" value="" style="width:120px" />&nbsp;<input type="text" name="stock[]" placeholder="Stock" value="" style="width:120px" />&nbsp;<a href="javascript:void(0);" class="remove_field">Remove</a></div>');
      }
  });

  //when user click on remove button
  $(wrapper).on("click",".remove_field", function(e){ 
      e.preventDefault();
  $(this).parent('div').remove(); //remove inout field
  x--; //inout field decrement
  });


  // Show Filters on Selection of Category
  $("#category_id").on('change',function(){
   var category_id = $(this).val();
   $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
    type:'post',
    url:'category-filters',
    data:{category_id:category_id},
    success:function(resp){
      $(".loadFilters").html(resp.view);
    }
   })
  });
    // call datatable class
    $('#sections').DataTable();
    $('#categories').DataTable();
    $('#brands').DataTable();
    $('#products').DataTable();
    $('#banners').DataTable();
    $('#filters').DataTable();

  $(".nav-item").removeClass("active");
  $(".nav-link").removeClass("active");
//Check Admin Password is correct or not
$("#current_password").keyup(function(){
    var current_password = $("#current_password").val();
    // alert(current_password);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: '/admin/check-admin-password',
        data: {current_password:current_password},
        success: function(resp){
             if(resp=="false"){
               $("#check_password").html("<font color='red'>Current Password is Incorrect!</font>");
             }else if(resp=="true"){
                $("#check_password").html("<font color='green'>Current Password is Correct!</font>");
             }
        },error:function(){
            alert('Error');
        }
        
      });
})
     //update admin status
     $(document).on("click",".updateAdminStatus",function(){
      var status = $(this).children("i").attr("status");
      var admin_id = $(this).attr("admin_id");
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'post',
              url: '/admin/update-admin-status',
              data: {status:status,admin_id:admin_id},
              success: function(resp){
                  if(resp['status']==0){
                    $("#admin-"+admin_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock' status='Inactive'></i>")
                  }else if(resp['status']==1){
                    $("#admin-"+admin_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock-open-outline' status='Active'></i>")
                  }
              },error:function(){
                alert('Error');
              }
              
            });
      })

       //update filter status
     $(document).on("click",".updateFilterStatus",function(){
      var status = $(this).children("i").attr("status");
      var filter_id = $(this).attr("filter_id");
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'post',
              url: '/admin/update-filter-status',
              data: {status:status,filter_id:filter_id},
              success: function(resp){
                  if(resp['status']==0){
                    Swal.fire({
                      title: 'This filter is Not Available',
                  
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#filter-"+filter_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock' status='Inactive'></i>")
                  }else if(resp['status']==1){
                    Swal.fire({
                      title: 'This filter is Available',
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#filter-"+filter_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock-open-outline' status='Active'></i>")
                  }
              },error:function(){
                alert('Error');
              }
              
            });
      })


      
       //update filter value status
     $(document).on("click",".updateFilterValueStatus",function(){
      var status = $(this).children("i").attr("status");
      var filter_id = $(this).attr("filter_id");
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'post',
              url: '/admin/update-filter-value-status',
              data: {status:status,filter_id:filter_id},
              success: function(resp){
                  if(resp['status']==0){
                    Swal.fire({
                      title: 'This filter value is Not Available',
                  
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#filter-"+filter_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock' status='Inactive'></i>")
                  }else if(resp['status']==1){
                    Swal.fire({
                      title: 'This filter value is Available',
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#filter-"+filter_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock-open-outline' status='Active'></i>")
                  }
              },error:function(){
                alert('Error');
              }
              
            });
      })
       //update section status
     $(document).on("click",".updateSectionStatus",function(){
      var status = $(this).children("i").attr("status");
      var section_id = $(this).attr("section_id");
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'post',
              url: '/admin/update-section-status',
              data: {status:status,section_id:section_id},
              success: function(resp){
                  if(resp['status']==0){
                    Swal.fire({
                      title: 'This section is Not Available',
                  
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#section-"+section_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock' status='Inactive'></i>")
                  }else if(resp['status']==1){
                    Swal.fire({
                      title: 'This section is Available',
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#section-"+section_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock-open-outline' status='Active'></i>")
                  }
              },error:function(){
                alert('Error');
              }
              
            });
      })

         //update product status
     $(document).on("click",".updateProductStatus",function(){
      var status = $(this).children("i").attr("status");
      var product_id = $(this).attr("product_id");
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'post',
              url: '/admin/update-product-status',
              data: {status:status,product_id:product_id},
              success: function(resp){
                  if(resp['status']==0){
                    Swal.fire({
                      title: 'This product is Not Available',
                  
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#product-"+product_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock' status='Inactive'></i>")
                  }else if(resp['status']==1){
                    Swal.fire({
                      title: 'This product is Available',
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#product-"+product_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock-open-outline' status='Active'></i>")
                  }
              },error:function(){
                alert('Error');
              }
              
            });
      })

       //update attribute status
     $(document).on("click",".updateAttributeStatus",function(){
      var status = $(this).children("i").attr("status");
      var attribute_id = $(this).attr("attribute_id");
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'post',
              url: '/admin/update-attribute-status',
              data: {status:status,attribute_id:attribute_id},
              success: function(resp){
                  if(resp['status']==0){
                    Swal.fire({
                      title: 'This attribute is Not Available',
                  
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#attribute-"+attribute_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock' status='Inactive'></i>")
                  }else if(resp['status']==1){
                    Swal.fire({
                      title: 'This attribute is Available',
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#attribute-"+attribute_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock-open-outline' status='Active'></i>")
                  }
              },error:function(){
                alert('Error');
              }
              
            });
      })

       //update banner status
     $(document).on("click",".updateBannerStatus",function(){
      var status = $(this).children("i").attr("status");
      var banner_id = $(this).attr("banner_id");
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'post',
              url: '/admin/update-banner-status',
              data: {status:status,banner_id:banner_id},
              success: function(resp){
                  if(resp['status']==0){
                    Swal.fire({
                      title: 'This banner is Not Available',
                  
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#banner-"+banner_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock' status='Inactive'></i>")
                  }else if(resp['status']==1){
                    Swal.fire({
                      title: 'This banner is Available',
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#banner-"+banner_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock-open-outline' status='Active'></i>")
                  }
              },error:function(){
                alert('Error');
              }
              
            });
      })
      //update image status
     $(document).on("click",".updateImageStatus",function(){
      var status = $(this).children("i").attr("status");
      var image_id = $(this).attr("image_id");
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'post',
              url: '/admin/update-image-status',
              data: {status:status,image_id:image_id},
              success: function(resp){
                  if(resp['status']==0){
                    Swal.fire({
                      title: 'This image is Not Available',
                  
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#image-"+image_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock' status='Inactive'></i>")
                  }else if(resp['status']==1){
                    Swal.fire({
                      title: 'This image is Available',
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#image-"+image_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock-open-outline' status='Active'></i>")
                  }
              },error:function(){
                alert('Error');
              }
              
            });
      })
        //update brand status
     $(document).on("click",".updateBrandStatus",function(){
      var status = $(this).children("i").attr("status");
      var brand_id = $(this).attr("brand_id");
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'post',
              url: '/admin/update-brand-status',
              data: {status:status,brand_id:brand_id},
              success: function(resp){
                  if(resp['status']==0){
                    Swal.fire({
                      title: 'This brand is Not Available',
                  
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#brand-"+brand_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock' status='Inactive'></i>")
                  }else if(resp['status']==1){
                    Swal.fire({
                      title: 'This brand is Available',
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#brand-"+brand_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock-open-outline' status='Active'></i>")
                  }
              },error:function(){
                alert('Error');
              }
              
            });
      })

         //update category status
     $(document).on("click",".updateCategoryStatus",function(){
      var status = $(this).children("i").attr("status");
      var category_id = $(this).attr("category_id");
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'post',
              url: '/admin/update-category-status',
              data: {status:status,category_id:category_id},
              success: function(resp){
                  if(resp['status']==0){
                    Swal.fire({
                      title: 'This category is Not Available',
                  
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#category-"+category_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock' status='Inactive'></i>")
                  }else if(resp['status']==1){
                    Swal.fire({
                      title: 'This category is Available',
                      showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    }),
                    $("#category-"+category_id).html("<i style='font-size: 25px;color:#4B49AC;' class='mdi mdi-lock-open-outline' status='Active'></i>")
                  }
              },error:function(){
                alert('Error');
              }
              
            });
      })

        $(document).on("click",".confirmDelete",function(){
        var module = $(this).attr('module');
        var moduleid = $(this).attr("moduleid");
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire(
              'Deleted!',
              "Your "+ module+ " has been deleted",
              'success'
            )
            window.location="/admin/delete-"+module+"/"+moduleid;
          }
        })
    });

  // Append Categories level
	$("#section_id").change(function(){
		var section_id = $(this).val();
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			type:'get',
			url:'/admin/append-categories-level',
			data:{section_id:section_id},
			success:function(resp){
				$("#appendCategoriesLevel").html(resp);
			},error:function(){
				alert("Error");
			}
		})
	});

  

   


  
});