<script>

function edit_status(id,status)
    {
      /* alert(id); 
       alert(status); */
          $(".loader").show();
        jQuery.ajax({
               url:"<?php echo base_url(); ?>backoffice/Usermanagement/change_user_status",
                method:"POST",
                data:{
                    id:id,
                    status:status,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success:function(data)
                {
                    var obj=JSON.parse(data);
                    
                     $(".loader").hide();
                    if(obj.st == "1")
                        {
                             $.toaster({ priority : 'success', title : 'Success', message : obj.msg });
                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Usermanagement/load_users_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {
                                         
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(response);

                                        $("#institute_data").DataTable({
                                            "searching": true,
                                            "bPaginate": true,
                                            "bInfo": true,
                                            "pageLength": 10,
                                    //        "order": [[4, 'asc']],
                                            "aoColumnDefs": [
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [0]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [1]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [2]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [3]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [4]
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                });
                        }
                    else{
                         $.toaster({ priority : 'error', title : 'Invalid', message : obj.msg });
                    }
                    
                   
                }
        });
    }


    function resetpassword_status(id = NULL){
        $('#newpassword_show').html('');
        $.confirm({
          title: 'Alert message',
          content: 'Do you want to reset password?',
          icon: 'fa fa-question-circle',
          animation: 'scale',
          closeAnimation: 'scale',
          opacity: 0.5,
          buttons: {
              'confirm': {
                  text: 'Proceed',
                  btnClass: 'btn-blue',
                  action: function() {
                      if(id !=""){
                          $(".loader").show();
                          $.ajax({
                                  url: '<?php echo base_url();?>backoffice/Usermanagement/reset_password',
                                  type:'POST',
                                  data: {id:id,status:1,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                                  success: function(response) {
                                      $(".loader").hide();
                                    var obj = JSON.parse(response);
                                    if(obj.st==1) {
                                        $('#newpassword_show').html(obj.data);
                                    } else {
                                        $('#resetpassword').modal('toggle');
                                      $.toaster({ priority : 'warning', title : 'Notice', message : obj.message });   
                                    }
                                  }
                          });
                      }
                  }
              },
              cancel: function() {
                $('#resetpassword').modal('toggle');
              },
          }
      });
    }

    function resendpassword_status(id = null, email){
        $.confirm({
            title: 'Alert message',
            content: 'Do you want to reset password?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {
                        if(id !=""){
                            $(".loader").show();
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Usermanagement/resend_password',
                                type:'POST',
                                data: {id:id,status:1,email:email,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                                success: function(response) {
                                    $(".loader").hide();
                                    var obj = JSON.parse(response);
                                    if(obj.st == 1) {
                                        $.toaster({ priority : 'success', title : 'Success', message : obj.message });   
                                    } else {
                                        $.toaster({ priority : 'warning', title : 'Notice', message : obj.message });   
                                  }
                                }
                            });
                        }
                    }
                },
                cancel: function() { },
            }
      });
    }

</script>
