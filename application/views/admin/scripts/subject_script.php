<script>
    $("#edit_type").change(function(){
        var type = $('#edit_type').val();
        if (type == "Module") {
            $("#edit_div").css("display","block");
            $("#editcoursediv").css("display","none");
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_allparent_subjects',
                type: 'POST',
                data: {
                    subject_type_id: type,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                     $("#edit_div").html(response);
                    $(".loader").hide();
                }
            });
        }
        else{
            $("#edit_div").css("display","none");
            $("#editcoursediv").css("display","block");
        }
    });
    
    
    //add subject** show parent subject
    $('#type').change(function() {
        var type = $('#type').val();

        if (type == "Module") {
            $("#parent_div").css("display","block");
            $("#coursediv").css("display","none");
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_allparent_subjects',
                type: 'POST',
                data: {
                    subject_type_id: type,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#parent_div").html(response);
                    $(".loader").hide();
                }
            });
        }
        else{
            $("#parent_div").css("display","none");
            $("#coursediv").css("display","block");
        }
    });



    $("form#add_subject_form").validate({
        rules: {
            subject_name: {
                required: true
            },
            subject_type_id: {
                required: true

            },
             course_id: {
                  required: true

              }
        },
        messages: {
            subject_name: "Please Enter Subject Name",
            subject_type_id: "select Choose Subject Type",
            course_id: "Please select course"
        },

        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/subject_add',
                type: 'POST',
                data: $("#add_subject_form").serialize(),
                success: function(response) {
                    if (response != 2 && response != 0) {
                        $('#myModal').modal('toggle');
                        $( '#add_subject_form' ).each(function(){
                            this.reset();
                        });
                        $.toaster({ priority : 'success', title : 'Success', message : 'Subject added' });
//                        setTimeout(function(){ window.location.reload(); }, 3000);
//                        $("#subject_data").append(response);
                         $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Courses/load_subject_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {     
                                        $('#subject_data').DataTable().destroy();
                                        $("#subject_data").html(response);
                                        $("#subject_data").DataTable({
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
                                        $(".loader").hide();
                                    } 
                                }); 
                            
                    }
                    else if(response == 2)
                    {
                        $.toaster({priority:'warning',title:'Error',message:'Already Exist'});
                         
                    }
                    $(".loader").hide();
                }
            });

        }


    });
    $("form#edit_subject_form").validate({
        rules: {
            subject_name: {
                required: true
            },
            subject_type_id: {
                required: true

            },
            /*  parent_subject: {
                  required: true

              }*/
        },
        messages: {
            subject_name: "Please Enter Subject Name",
            subject_type_id: "Please Choose Subject Type"
            // parent_subject: "Please Choose Parent subject"
        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/subject_edit',
                type: 'POST',
                data: $("#edit_subject_form").serialize(),
                success: function(response) {
                    if (response == 1) {
                        $.toaster({ priority : 'success', title : 'Success', message : 'Successfully updated' });
                        $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Courses/load_subject_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {  
                                         $('#edit_subject').modal('toggle');  
                                        $('#subject_data').DataTable().destroy();
                                        $("#subject_data").html(response);
                                        $("#subject_data").DataTable({
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
                                        $(".loader").hide();
                                    } 
                                }); 
                    }
                    $(".loader").hide();
                }
            });

        }


    });

    function delete_subject(id,type) {
        $.confirm({
            title: 'Alert message',
            content: 'Do you want to remove this Information?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {

                        $.post('<?php echo base_url();?>backoffice/Courses/delete_subject/', {
                            id: id,
                            type: type,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            var obj=JSON.parse(data);
                          
                            if (obj.st == 1) 
                            {
                                $.toaster({priority:'success',title:'Success',message:'Subject successfully deleted!'});
                                 $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Courses/load_subject_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {     
                                        $('#subject_data').DataTable().destroy();
                                        $("#subject_data").html(response);
                                        $("#subject_data").DataTable({
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
                                        $(".loader").hide();
                                    } 
                                }); 
                            }
                            else if(obj.st == 2) 
                            {
                                $.toaster({priority:'warning',title:'Invalid',message:obj.msg});   
                            }
                            else if(obj.st == 0){
                                 $.toaster({priority:'error',title:'Invalid',message:obj.msg}); 
                            }
                        });

                        /*$.alert('Successfully <strong>Deleted..!</strong>');*/
                    }
                },
                cancel: function() {
                    //$.alert(' <strong>cancelled</strong>');
                },
            }
        });
    }

    function get_subjectdata(id) {
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Courses/get_subjectdetails_by_id/' + id,
            type: 'POST',
            data: {
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
            success: function(response) {
                
                var obj = JSON.parse(response);
               //alert(obj['parent_subjects']);
                $("#edit_subjectid").val(obj.subject_id);
                $("#edit_subjectname").val(obj.subject_name);
                $("#edit_type").val(obj.subject_type_id);
                if(obj.subject_type_id=='Subject') {
                    $("#editcoursediv").css("display","block");
                    $("#edit_course_id").val(obj.course_id);
                }
                
                if(obj.subject_type_id == 'Module'){
                        $("#edit_div").css("display","block");
                         $("#edit_div").html(obj['parent_subjects']);
                         $("#edit_parent_subject").val(obj.parent_subject);
                        $("#editcoursediv").css("display","none");
                    }
                else{
                     $("#edit_div").css("display","none");
                   
                }
               // $("#edit_syllabus_id").val(obj.syllabus_id);
               $(".loader").hide();
            }
        });
    }
    
    

</script>
