<script>
    $("#filter_centre").change(function(){
        var center = $('#filter_centre').val();
        if (center != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_centercoursemapping',
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
                url: '<?php echo base_url();?>backoffice/Students/get_batchesss_byCourse',
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
    function search(){
     
            $('#loadreportview').show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_student_list',
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
    $("form#mentor_form").validate({
        rules: {
            staff_id: {
                required: true
            }
        },
        messages: {
            staff_id: "Please Choose Mentor"
            },

        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/mentor_add',
                type: 'POST',
                data: $("#mentor_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                        $( '#mentor_form' ).each(function(){
                                        this.reset();
                                });
                        
                          
                        $.toaster({priority:'success',title:'Success',message:obj.msg});

                      }
                    else if (obj.st == 2){
                         $.toaster({priority:'warning',title:'INVALID',message:obj.msg});
                    } else if (obj.st == 3){
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