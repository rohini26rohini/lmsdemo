<script>
    
    $("#get_batch_student").change(function(){
        $(".loader").show(); 
        var id = $(this).val();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Students/get_batch_student',
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>','id':id},
            success: function(response) {
                if(response==0) {
                    $.toaster({priority:'warning',title:'Warning',message:'No student available in batch'});
                    $(".loader").hide();
                } else {
                    $('#institute_data').DataTable().destroy();
                    $("#institute_data").html(response);
                    $("#institute_data").DataTable({
                        "searching": true,
                        "bPaginate": true,
                        "bInfo": true,
                        "pageLength": 10,
                        //      "order": [[4, 'asc']],
                        "aoColumnDefs": [
                            {
                                'bSortable': true,
                                'aTargets': [0]
                            },
                            {
                                'bSortable': true,
                                'aTargets': [1]
                            },
                            {
                                'bSortable': true,
                                'aTargets': [2]
                            },
                            {
                                'bSortable': true,
                                'aTargets': [3]
                            },
                            {
                                'bSortable': true,
                                'aTargets': [4]
                            },
                            {
                                'bSortable': false,
                                'aTargets': [5]
                            }
                        ]
                    });    
                    $(".loader").hide();    
                }
            }
        });    
    });

    $("#applicationno").keyup(function(){
        var applicationno = $('#applicationno').val();
        var email = $('#email').val();
        var mobileno = $('#mobileno').val();
        //search_reset(applicationno, email, mobileno);
    });
    $("#email").keyup(function(){
        var applicationno = $('#applicationno').val();
        var email = $('#email').val();
        var mobileno = $('#mobileno').val();
        //search_reset(applicationno, email, mobileno);
    }); 
    $("#mobileno").keyup(function(){
        var applicationno = $('#applicationno').val();
        var email = $('#email').val();
        var mobileno = $('#mobileno').val();
        //search_reset(applicationno, email, mobileno);
    }); 
    $("#searchbutton").click(function(){
        var applicationno = $('#applicationno').val();
        var email = $('#email').val();
        var mobileno = $('#mobileno').val();
        search_reset(applicationno, email, mobileno);
    });    
    function search_reset(applicationno = NULL, email = NULL, mobileno = NULL) {
        //$(".loader").show(); //alert(applicationno+'='+email+'='+mobileno);
        if(applicationno!='' || email!="" || mobileno!='') { 
        $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_student_bysearch',
                type: 'POST',
                data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>','id':applicationno,'email':email,'mobileno':mobileno},
                success: function(response) {
                    if(response==0) {
                            //$.toaster({priority:'warning',title:'Warning',message:'No student available in batch'});
                            $("#institute_data").html('');
                            $('#institute_data').DataTable().destroy();
                                    $("#institute_data").DataTable({
                                        "searching": true,
                                        "bPaginate": true,
                                        "bInfo": true,
                                        "pageLength": 10,
                                //      "order": [[4, 'asc']],
                                        "aoColumnDefs": [
                                            {
                                                'bSortable': true,
                                                'aTargets': [0]
                                            },
                                            {
                                                'bSortable': true,
                                                'aTargets': [1]
                                            },
                                            {
                                                'bSortable': true,
                                                'aTargets': [2]
                                            },
                                            {
                                                'bSortable': true,
                                                'aTargets': [3]
                                            },
                                            {
                                                'bSortable': true,
                                                'aTargets': [4]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [5]
                                            }
                                        ]
                                    });
                            $(".loader").hide();
                    } else {
                    $('#institute_data').DataTable().destroy();
                                    $("#institute_data").html(response);
                                    $("#institute_data").DataTable({
                                        "searching": true,
                                        "bPaginate": true,
                                        "bInfo": true,
                                        "pageLength": 10,
                                //      "order": [[4, 'asc']],
                                        "aoColumnDefs": [
                                            {
                                                'bSortable': true,
                                                'aTargets': [0]
                                            },
                                            {
                                                'bSortable': true,
                                                'aTargets': [1]
                                            },
                                            {
                                                'bSortable': true,
                                                'aTargets': [2]
                                            },
                                            {
                                                'bSortable': true,
                                                'aTargets': [3]
                                            },
                                            {
                                                'bSortable': true,
                                                'aTargets': [4]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [5]
                                            }
                                        ]
                                    });    
                                    $(".loader").hide();    

                }
                }
            });  
        } else {
            $("#institute_data").html('');
                            $('#institute_data').DataTable().destroy();
                                    $("#institute_data").DataTable({
                                        "searching": true,
                                        "bPaginate": true,
                                        "bInfo": true,
                                        "pageLength": 10,
                                //      "order": [[4, 'asc']],
                                        "aoColumnDefs": [
                                            {
                                                'bSortable': true,
                                                'aTargets': [0]
                                            },
                                            {
                                                'bSortable': true,
                                                'aTargets': [1]
                                            },
                                            {
                                                'bSortable': true,
                                                'aTargets': [2]
                                            },
                                            {
                                                'bSortable': true,
                                                'aTargets': [3]
                                            },
                                            {
                                                'bSortable': true,
                                                'aTargets': [4]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [5]
                                            }
                                        ]
                                    });
                            $(".loader").hide();
        }  
   } 


// function passwordreset(student_id, type) {
//     alert(student_id);
// }


 $("form#add_form").validate({
        rules: {
           status: {
                required: true
            },
            description: {
                required: true
            }
        },
        messages: {
            status: "Please Choose a status",
            description: "Please Enter the  Reason"
            },

        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/status_change_student',
                type: 'POST',
                data: $("#add_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                                 $('#myModal').modal('toggle');
                                 $( '#add_form' ).each(function(){
                                        this.reset();
                                });
                          $.toaster({priority:'success',title:'Success',message:obj.msg});
                           $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Students/load_student_ajax',
                                    type: 'POST',
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {  
                                        $('#studentlist_table').DataTable().destroy();
                                        $("#studentlist_table").html(response);
                                        $("#studentlist_table").DataTable({
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                },
                                                 {
                                                    'bSortable': false,
                                                    'aTargets': [7]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [8]
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                }); 

                      }
                    else if (obj.st == 0){
                         $.toaster({priority:'danger',title:'INVALID',message:obj.msg});
                    }
                    else if (obj.st == 2){
                         $.toaster({priority:'success',title:'Notice',message:obj.msg});
                    }
                    $(".loader").hide();
                }

            });
        }
    });
    function emailPassword(student_id, type, email, user_username) {
        $.confirm({
            title: "Alert message",
            content: "Do you want to reset password?",
            icon: "fa fa-question-circle",
            animation: "scale",
            closeAnimation: "scale",
            opacity: 0.5,
            buttons: {
                "confirm": {
                    text: "Proceed",
                    btnClass: "btn-blue",
                    action: function() {
                        $(".loader").show();
                        $.ajax({
                            url: '<?php echo base_url();?>backoffice/Students/email_passwordresetuser',
                            type: "POST",
                            data:{
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>',
                                id:student_id,type:type,email:email,user_username:user_username},
                            success: function(response) {
                                var obj=JSON.parse(response);
                                if (obj.st == 1){
                                    $.toaster({priority:'success',title:'Success',message:obj.msg});
                                }else if(obj.st == 2){
                                    $.toaster({priority:'danger',title:'INVALID',message:obj.msg});
                                }
                                $(".loader").hide();
                            }
                        });
                    }
                },
                cancel: function() {
                    // $("#resetpassword").modal("toggle");
                },
            }
        });
    }


</script>
