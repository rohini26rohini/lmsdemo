
<script>
    $("form#add_homework_form").validate({
        rules: {
           batch_id: {
                required: true
            },
            title: {
                required: true
            },
            description: {
                required: true
            },
            date_of_submission: {
                required: true
            }
        },
        messages: {
            batch_id: "Please Choose a batch",
            title: "Please Enter the  title",
            description: "Please Enter the  title",
            date_of_submission: "Please Choose a date"
            },

        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Homework/add_homework',
                type: 'POST',
                data: $("#add_homework_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                                 $('#myModal').modal('toggle');
                                 $( '#add_homework_form' ).each(function(){
                                        this.reset();
                                });
                                   $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Homework/load_homeworkList_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(data);

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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                }
                                                
                                            ]
                                        });
                                    }
                                   });
                          
                        $.toaster({priority:'success',title:'Success',message:obj.message});

                      }
                    else if (obj.st == 0){
                         $.toaster({priority:'danger',title:'INVALID',message:obj.message});
                    }
                    else if (obj.st == 2){
                         $.toaster({priority:'warning',title:'INVALID',message:obj.message});
                    }
                    $(".loader").hide();
                }

            });


        }


    });
    
    function delete_homework_data(id)
    {
            $.confirm({
            title: 'Alert message',
            content: 'Do you want to remove this information?',
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
                                    url: '<?php echo base_url();?>backoffice/Homework/delete_homework',
                                    type: 'POST',
                                    data: {
                                        id: id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.status == 1) {
                                          $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Homework/load_homeworkList_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(data);

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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                }
                                                
                                            ]
                                        });
                                    }
                                   });
                                             $.toaster({priority:'success',title:'Success',message:obj.message});
                                           
                                           
                                        } else {
                                            $.toaster({priority:'warning',title:'Invalid',message:obj.message});
                                        }
                                        $(".loader").hide();
                                    }
                                });
                        }


                    }
                },
                cancel: function() {
                    //$.alert(' <strong>cancelled</strong>');
                },
            }
        });
    }
    
    function get_homework_data(id)
    {
        $(".loader").show();
             $.ajax({
                        url: '<?php echo base_url();?>backoffice/Homework/get_homeworkdata_byId',
                        type: 'POST',
                        data: {
                            id : id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        },
                        success: function(response) {
                            $(".loader").hide();
                           // alert(response);
                            var obj = JSON.parse(response);
                            $("#edit_batch").val(obj['data'].batch_id);
                            $("#id").val(obj['data'].id);
                            $("#edit_id").val(obj['data'].id);
                            $("#edit_description").val(obj['data'].description);
                            $("#edit_title").val(obj['data'].title);
                            $("#edit_date").val(obj['data'].date_of_submission);
                            $('#editModal').modal({
                                    show: true
                                    });
                            }
                    });

    }
    
     $("form#edit_homework_form").validate({
        rules: {
           batch_id: {
                required: true
            },
            title: {
                required: true
            },
            description: {
                required: true
            },
            date_of_submission: {
                required: true
            }
        },
        messages: {
            batch_id: "Please Choose a batch",
            title: "Please Enter the  title",
            description: "Please Enter the  title",
            date_of_submission: "Please Choose a date"
            },

        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Homework/update_homework',
                type: 'POST',
                data: $("#edit_homework_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                                 $('#editModal').modal('toggle');
                                 $( '#edit_homework_form' ).each(function(){
                                        this.reset();
                                });
                                    $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Homework/load_homeworkList_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(data);

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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                }
                                                
                                            ]
                                        });
                                    }
                                   });
                          
                        $.toaster({priority:'success',title:'Success',message:obj.message});

                      }
                    else if (obj.st == 0){
                         $.toaster({priority:'danger',title:'INVALID',message:obj.message});
                    }
                    else if (obj.st == 2){
                         $.toaster({priority:'warning',title:'INVALID',message:obj.message});
                    }
                    $(".loader").hide();
                }

            });


        }


    });
    
    function view(id,batch_id)
    {
        $(".loader").show();
             $.ajax({
                        url: '<?php echo base_url();?>backoffice/Homework/view_batch_student_homework',
                        type: 'POST',
                        data: {
                            id : id,
                            batch_id : batch_id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        },
                        success: function(response) {
                            $(".loader").hide();
                            $("#loadalldatas").html(response);
                            
                            }
                    });
    }
    
    $("#filter_batch").change(function(){
        var batch = $('#filter_batch').val();

        if (batch != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Homework/get_homework_by_batch',
                type: 'POST',
                data: {
                    batch_id: batch,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {    
                    $(".loader").hide();
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                }
                                                
                                            ]
                                        });                                                                                 
                }
            });
        }
    });
     $(document).ready(function () {
                         $(".chartBlockBtn").click(function () {
                            $("#chartBlock").toggleClass("show");
                            $(".close_btn").fadeIn("200");
                        });
                        $(".close_btn").click(function () {
                            $(this).hide();
                            $("#chartBlock").removeClass(("show"));
                        });
                    });
    
    
    function view_homework_bystudentid(student_id,homework_id)
    {
        $("#all_data").css('display','none');
        $("#previous").css('display','block');
        $("#save").css('display','none');
        $("#status").css('display','none');
        $(".loader").show();
             $.ajax({
                        url: '<?php echo base_url();?>backoffice/Homework/view_homework_bystudentid_new',
                        type: 'POST',
                        data: {
                            student_id : student_id,
                            homework_id : homework_id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        },
                        success: function(response) {
                            $(".loader").hide();
                            $("#student_data").html(response);
                            
                            }
                    });
    }
    $("#previous").click(function(){
       // alert("jk");
        $("#student_data").css('display','none');
        $("#save").css('display','block');
        $("#status").css('display','block');
        $("#all_data").css('display','block');
        $("#previous").css('display','none');
    });
     function check_all()
    {
       
        if($("#main:checkbox:checked").length == 0){
            $('.all_student').prop('checked', false);
           
        }else{
            $('.all_student').prop('checked', true);
            
        }
    }
    
    $("form#verify_homework").validate({
        rules: {
           status: {
                required: true
            }
        },
        messages: {
            status: "Please choose a status"
            },

        submitHandler: function(form) {
            
             //$(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Homework/verify_homework',
                type: 'POST',
                data: $("#verify_homework").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                        $('#verify_homework').each(function(){
                                        this.reset();
                                });
                        
                          
                        $.toaster({priority:'success',title:'Success',message:obj.msg});

                      }
                    else if (obj.st == 2){
                         $.toaster({priority:'warning',title:'INVALID',message:obj.msg});
                    }
                     else{
                         $.toaster({priority:'danger',title:'INVALID',message:'Something went wrong,Please try again later..!'});
                    }
                    $(".loader").hide();
                }

            });


        }


    });
</script>