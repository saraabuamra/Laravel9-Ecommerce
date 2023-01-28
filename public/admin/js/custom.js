$(document).ready(function(){
    // call datatable class
    $('#sections').DataTable();
    $('#categories').DataTable();

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

      $(".confirmDelete").click(function () {
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
});