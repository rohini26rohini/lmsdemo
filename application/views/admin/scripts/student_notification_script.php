<script>
    $("#filter_centre").change(function(){
        var center = $('#filter_centre').val();

        if (center != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Notification/get_centercoursemapping',
                type: 'POST',
                data: {
                    center_id: center,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    // alert(response);
                    $("#filter_course").html(response);
                    $("#filter_batch").html("");
                    $(".loader").hide();
                }
            });
        }
    });
     $("#filter_course").change(function(){
         var course_id=$(this).val();
          var center = $('#filter_centre').val();
     if (course_id != "" && center !="") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Notification/get_batch_byCourse',
                type: 'POST',
                data: {
                    course_id: course_id,
                    center: center,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    $(".loader").hide();
                    $("#filter_batch").html(response);
                    var batch_id=$("#filter_batch").val(); 
                         search();
                }
            });
        }
});
    $("#filter_batch").change(function(){
        search();
        });
    function search(){
            $('.loader').show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Notification/get_student_list',
                type: "post",
                data: $("#search_form").serialize(),
                success: function(data) {
                    $("#syllabus_data").DataTable().destroy();
                    $("#syllabus_data").html(data); 
                    $("#syllabus_data").DataTable({
                        "searching": true,
                        "bPaginate": true,
                        "bInfo": true,
                        "pageLength": 10,
                //      "order": [[4, 'asc']],
                        "aoColumnDefs": [
                            {
                                'bSortable': false,
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
                            }
                        ]
                    }); 
                     $(".loader").hide();
                }
               
            });
    }
    
    function check_all()
    {
       
        if($("#main:checkbox:checked").length == 0){
            $('.all_student').prop('checked', false);
           
        }else{
            $('.all_student').prop('checked', true);
            
        }
    }
    
    $("form#msg_form").validate({
        rules: {
           message: {
                required: true
            }
        },
        messages: {
            message: "Please enter the message"
            },

        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Notification/send_message_student',
                type: 'POST',
                data: $("#msg_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                        $('#msg_form').each(function(){
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