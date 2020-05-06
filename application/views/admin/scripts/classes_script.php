<script>
    function courseColor(cls){
        formclear('add_class_form');
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Courses/courseColor/',
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                // $("#courseColor").html(response);
                var obj = JSON.parse(response);
                $( '.'+cls+'[ data-color="#E62"]' ).prop('title', obj.cE62);
                $( '.'+cls+'[ data-color="#9c27b0"]' ).prop('title', obj.c9c27b0);
                $( '.'+cls+'[ data-color="#00BCD4"]' ).prop('title', obj.c00BCD4);
                $( '.'+cls+'[ data-color="#b9a709"]' ).prop('title', obj.cb9a709);

                $( '.'+cls+'[ data-color="#0AF"]' ).prop('title', obj.c0AF);
                $( '.'+cls+'[ data-color="#05A"]' ).prop('title', obj.c05A);
                $( '.'+cls+'[ data-color="#E91E63"]' ).prop('title', obj.cE91E63);
                $( '.'+cls+'[ data-color="#FF9800"]' ).prop('title', obj.cFF9800);

                $( '.'+cls+'[ data-color="#191"]' ).prop('title', obj.c191);
                $( '.'+cls+'[ data-color="#FD0"]' ).prop('title', obj.cFD0);
                $( '.'+cls+'[ data-color="#607D8B"]' ).prop('title', obj.c607D8B);
                $( '.'+cls+'[ data-color="#CDDC39"]' ).prop('title', obj.cCDDC39);

                $( '.'+cls+'[ data-color="#305eb1"]' ).prop('title', obj.c305eb1);
                $( '.'+cls+'[ data-color="#913535"]' ).prop('title', obj.c913535);
                $( '.'+cls+'[ data-color="#fa68db"]' ).prop('title', obj.cfa68db);
                $( '.'+cls+'[ data-color="#005020"]' ).prop('title', obj.c005020);
                $(".loader").hide();
            }
        });
    }

    $(document).ready(function () {
        $(".color-pallete").click(function () {
            $(".color-pallete").removeClass('active');
            $(this).addClass('active');
            var color=$(this).attr("data-color");
            $("#color").val(color);
            $("#user_color").val($(this).data('color'));
        })
        $(".color-pallete-edit").click(function () {
            $(".color-pallete-edit").removeClass('active');
            $(this).addClass('active');
            var color=$(this).attr("data-color");
            $("#edit_color").val(color);
            $("#user_color_edit").val($(this).data('color'));
        })


    $("form#add_class_form").validate({
        rules: {
            class_name: {
                required: true
            },
            school_id: {
                required: true

            },
            syllabus_id: {
                required: true

            },
            batch_mode_id: {
                required: true

            },
            basic_qualification: {
                required: true
            },
            result_publish: {
                required: true
            },
            active_exam: {
                required: true
            }
        },
        messages: {
            class_name: "Please Enter Course Name",
            school_id: "Please Choose School",
            syllabus_id: "Please Choose syllabus",
            batch_mode_id: "Please Choose mode",
            basic_qualification: "Please Choose Basic Qualification",
            result_publish: "Please Choose result publish",
            active_exam: "Please Choose active exam "
        },

        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/classes_add',
                type: 'POST',
                data: $("#add_class_form").serialize(),
                success: function(response) {
                    var obj=JSON.parse(response);
                    
                    if (obj['st'] == 1) 
                    {
                              $('#add_class').modal('toggle');
                             $('#add_class_form').each(function(){this.reset(); });
                               //$("#institute_data").append(obj['html']);                  
                               $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Courses/load_course_ajax',
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                }
                                                
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                });                    
                            $.toaster({ priority : 'success', title : 'Success', message : 'Course Added Succesfully..!' });
                    }
                    else if(obj['st'] == 2)
                        {
                             $.toaster({ priority : 'warning', title : 'Invalid', message : 'This Course Already Exist..!' });
                        }
                    else{
                        $.toaster({ priority : 'danger', title : 'Error', message : 'Something went wrong,Please try again later..!' });
                    }
                    $(".loader").hide();
                }
            });
            

        }


    });
    $("form#edit_class_form").validate({
        rules: {
            class_name: {
                required: true
            },
            school_id: {
                required: true

            },
            syllabus_id: {
                required: true

            },
            batch_mode_id: {
                required: true

            },basic_qualification: {
                required: true

            },result_publish: {
                required: true
            },
            active_exam: {
                required: true
            }
        },
        messages: {
            class_name: "Please Enter Class Name",
            school_id: "Please Choose School",
            syllabus_id: "Please Choose Syllabus",
            batch_mode_id: "Please Choose mode",
            basic_qualification: "Please Choose Basic Qualification",
            result_publish: "Please Choose result publish",
            active_exam: "Please Choose active exam "
        },

        submitHandler: function(form) {
           
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/classes_edit',
                type: 'POST',
                data: $("#edit_class_form").serialize(),
                success: function(response) {
                    if (response == 1) {
                                 /*setInterval(function (){
                                    location.reload();
                                    }, 2500);*/
                       // alert("Succesfully Updated");
                         $('#edit_class').modal('toggle');
                        $.toaster({priority:'success',title:'Message',message:'Succesfully Updated'});
                        $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Courses/load_course_ajax',
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [6]
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
});
    function delete_classes(id) {
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
                   
                        $.post('<?php echo base_url();?>backoffice/Courses/delete_classes/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {

                            var obj = JSON.parse(data);
                            if (obj.status == 1) {
                                $.toaster({ priority : 'success', title : 'Success', message : obj.message });
                                  $("#row_"+id).remove();
                                 $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Courses/load_course_ajax',
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                }

                                            ]
                                        });
                                        $(".loader").hide();
                                    }
                                });
                            } else {
                               $.toaster({priority:'danger',title:'INVALID',message:obj.message}); 
                            }
                        });
                        
                        //$.alert('Successfully <strong>Deleted..!</strong>');
                    }
                },
                cancel: function() {
                    //$.alert(' <strong>cancelled</strong>');
                },
            }
        });
    }
function get_editdata(id){
     $(".loader").show();
     courseColor('color-pallete-edit')
    $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_class_by_id/'+id,
                type: 'POST',
                data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response) {
                    var obj = JSON.parse(response);
                    $("#qualification").val(obj.basic_qualification);
                    $("#edit_class_id").val(obj.class_id);
                    $("#edit_class_name").val(obj.class_name);
                    $("#edit_school_id").val(obj.school_id);
                    $("#edit_syllabus_id").val(obj.syllabus_id);
                    $("#edit_batch_mode_id").val(obj.batch_mode_id);
                    $("#edit_color").val(obj.color);
                    if(obj.result_publish==0){
                        $("#result_publish").prop("checked", true);
                    }else{
                        $("#result_publish1").prop("checked", true);
                    }
                    if(obj.active_exam==1){
                        $("#active_exam").prop("checked", true);
                    }else{
                        $("#active_exam1").prop("checked", true);
                    }
                    $("#active_exam").val(obj.active_exam);
                    var color=obj.color;
                    $( '.color-pallete-edit' ).removeClass( 'active' );
                    $( '.color-pallete-edit[ data-color="' + color + '"]' ).addClass( 'active' );
                  /*if($(".color-pallete-edit").attr("data-color")== color)
                      {
                         $(".color-pallete-edit").attr("active");
                      }*/

                     $('#edit_class').modal({
                        show: true
                        });
                     $(".loader").hide();
                }
            });
      
}
</script>
