<script>

$("#installmentnosdiv").hide();

$("#group").change(function(){
        var group = $('#group').val();
    if(group !=""){
        $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_allsub_byparent',
                type: 'POST',
                data: {
                    parent_institute: group,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                   // alert(response);
                    $("#branch").html(response);
                    $(".loader").hide();
                }
            });
    }
    });

    


    $("#branch").change(function(){
        var branch = $('#branch').val();

        if (branch != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_allsub_byparent',
                type: 'POST',
                data: {
                    parent_institute: branch,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#center").html(response);
                    $(".loader").hide();
                }
            });
        }
        else{
            $("#edit_div").css("display","none");
        }
    });

     $("#center").change(function(){
        var center = $('#center').val();

        if (center != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_centercoursemapping',
                type: 'POST',
                data: {
                    center_id: center,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    // alert(response);
                    $("#courses").html(response);
                    $(".loader").hide();
                }
            });
        }
        else{
            $("#edit_div").css("display","none");
        }
    });



$("#group1").change(function(){
        var group = $('#group1').val();
    if(group !=""){
        $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_allsub_byparent',
                type: 'POST',
                data: {
                    parent_institute: group,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                   // alert(response);
                    $("#branch1").html(response);
                    $(".loader").hide();
                }
            });
    }
    });


    $("#branch1").change(function(){
        var branch = $('#branch1').val();

        if (branch != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_allsub_byparent',
                type: 'POST',
                data: {
                    parent_institute: branch,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#center1").html(response);
                    $(".loader").hide();
                }
            });
        }
        else{
            $("#edit_div").css("display","none");
        }
    });

    $(".cancel").click(function() {
        validator.resetForm();
    });

     $("#center1").change(function(){
        var center = $('#center1').val();

        if (center != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_centercoursemapping',
                type: 'POST',
                data: {
                    center_id: center,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    // alert(response);
                    $("#courses1").html(response);
                    $(".loader").hide();
                }
            });
        }
        else{
            $("#edit_div").css("display","none");
        }
    });



       


    $("form#add_classrooms_form").validate({
        rules: {
            group_master_id: {
                required: true
            },
            branch_master_id: {
                required: true

            },
              institute_master_id: {
                  required: true

              },
            classroom_name: {
                  required: true

              },
            type: {
                  required: true

              },
             total_occupancy: {
                  required: true

              }
        },
        messages: {
            group_master_id: "Please Choose a Group",
            branch_master_id: "Please Choose a Branch",
            institute_master_id: "Please Choose a Centre",
            classroom_name: "Please enter a class name",
            type: "Please Choose Class Room Type",
            total_occupancy: "Please Enter total number of occupancy"
        },

        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Home/add_classrooms',
                type: 'POST',
                data: $("#add_classrooms_form").serialize(),
                success: function(response) {
                    //alert(response);
                    if (response == 1) {
                         $('#add_classrooms').modal('toggle');
                        $("#other").css("display","block");
                         $('#add_classrooms_form').each(function(){
                            this.reset();
                         });
                        $.toaster({ priority : 'success', title : 'Success', message : 'Classroom Added Successfully' });
                        $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Home/load_classromm_ajax',
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

                        //  $(".reset").rules("remove");
                        //  $("#add_classrooms_form").data('validator').resetForm();


                        //location.reload();
                    }
                    else if(response == 2)
                    {
                        $.toaster({priority:'danger',title:'Error',message:'Data Already Exist'});
                         
                    }
                    $(".loader").hide();
                }
            });

        }
       
    });

    $("form#edit_classrooms_form").validate({
        rules: {
            group_master_id: {
                required: true
            },
            branch_master_id: {
                required: true

            },
              institute_master_id: {
                  required: true

              },
            classroom_name: {
                  required: true

              },
            type:{
                 required: true
            },
            total_occupancy:{
                 required: true
            }
        },
        messages: {
            group_master_id: "Please Choose a Group",
            branch_master_id: "Please Choose a Branch",
            institute_master_id: "Please Choose a Centre",
            classroom_name: "Please enter a class name",
             type: "Please Choose Class Room Type",
             total_occupancy: "Please enter the total number of occupancy"

        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Home/classrooms_edit',
                type: 'POST',
                data: $("#edit_classrooms_form").serialize(),
                success: function(response) {
                    if (response == 1) {
                         $('#edit_classrooms').modal('hide');
                        $.toaster({ priority : 'success', title : 'Success', message : 'Successfully updated' });

                        clear_form();
                        $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Home/load_classromm_ajax',
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
                    $(".loader").hide();
                }
            });
        }
    });
    // alert(edit_types());
    function get_classroomsdata(id)
    {                    

        $(".loader").show();
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Home/get_classrooms',
                type: 'POST',
                data: {room_id:id,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response) {
                    
                    var obj=JSON.parse(response);
                    // var type ="";
                    // if(obj.type == '1'){
                    //     type = "Class Room";
                    //     $("#edit_other").css("display","block");

                    // }else if(obj.type == '2'){
                    //     type = "Lab";
                    //     $("#edit_other").css("display","block");
                    // }else{
                    //     type = "Virtual Classroom";
                    //     $("#edit_other").css("display","none");
                    // }
                    $("#mapping_id").val(obj.room_id);
                    $("#group1").val(obj.group_master_id);
                    $("#branch1").html(obj['branch']);
                    $("#branch1").val(obj.branch_master_id);
                    $("#center1").html(obj['center']);
                    $("#center1").val(obj.institute_master_id);
                    $("#course").val(obj.course_master_id);
                    $("#classroom_name").val(obj.classroom_name);
                    $("#edit_total_occupancy").val(obj.total_occupancy);
                    // alert(type);
                    // $("#edit_type").val(type);
                    $("#edit_type").val(obj.type);
                    getothers(obj.type,obj.total_occupancy);
                    $('#edit_classrooms').modal({
                        show: true
                    });
                    $(".loader").hide();
                }
         });
        
    }
       // $("#type").change(function(){
        //     var type = $('#type').val();
        //     if (type == "3") {
        //         $("#other").css("display","none");
        //         $(".loader").show();
        //         $.ajax({
        //             url: '<?php echo base_url();?>backoffice/Home/get_type',
        //             type: 'POST',
        //             data: {
        //                 type: type,
        //                 <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
        //             },
        //             success: function(response) {
        //             //  alert(response);
        //                 $("#other").html(response);
        //                 $(".loader").hide();
        //             }
        //         });
        //     }
        //     else{
        //         $("#other").css("display","block");
        //     }
        // });

  function edit_types(id){
        var type = $('#edit_type').val();
        if (type== "3") {
            $("#edit_other").css("display","none");
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Home/get_edit_type',
                type: 'POST',
                data: {
                    type: type,room_id:id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                //  alert(response);
                    $("#edit_other").html(response);
                    $(".loader").hide();
                }
            });
        }
        else{
            // alert($('#edit_enquiry_type').val());
            $("#edit_other").css("display","block");
        }
    }


function getothers(type,total_occupancy){
    if (type == "3") {

                $("#edit_other").css("display","none");
                $("#edit_total_occupancy").val();
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Home/get_edit_type',
                    type: 'POST',
                    data: {
                        type: type,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                        $("#edit_other").html(response);
                        $("#edit_total_occupancy").val(total_occupancy);
                        $(".loader").hide();
                    }
                });
            }
}

      function roomtype(){
        // alert($('#edit_enquiry_type').val());
        var type = $('#type').val();
        if (type == "3") {
            $("#other").css("display","none");
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Home/get_type',
                type: 'POST',
                data: {
                    type: type,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                //  alert(response);
                    $("#other").html(response);
                    $(".loader").hide();
                }
            });
        }
        else{
            // alert($('#edit_enquiry_type').val());
            $("#other").css("display","block");
        }
    }



     


    function get_details(id){
         $(".loader").show();
         $.ajax({
            url: '<?php echo base_url();?>backoffice/Home/get_class_rooms_by_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj = JSON.parse(response);
                var type = "";
                if(obj.type == '1'){
                    type = "Class Room ";
                }else if(obj.type == '2'){
                    type = "Lab";
                }else{
                    type = "Virtual Classroom";
                }
                    $("#group_view").html(obj.group_master_id);
                    $("#branch_view").html(obj.branch_master_id);
                    $("#centre_view").html(obj.institute_name);
                    $("#class_name_view").html(obj.classroom_name);
                    $("#total_occupancy_view").html(obj.total_occupancy);
                    $("#room_type_view").html(type);
                $('#view_classrooms').modal({
                    show: true
                });
                $(".loader").hide();
            }
        });
        
    }

    function clear_id()
    {

        $("#mapping_id").val("");
    }

 $(window).on('load', function() {
        var group = $('#group').val();
    if(group !=""){
        $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_allsub_byparent',
                type: 'POST',
                data: {
                    parent_institute: group,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                   // alert(response);
                    $("#branch").html(response);
                    $(".loader").hide();

                }
            });
    }
});

  


function delete_fromtable(id){

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
                        $.post('<?php echo base_url();?>backoffice/Home/delete_classrooms/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                                if (data == 1) {
                                   
                                   $.toaster({ priority : 'success', title : 'Success', message : 'Successfully Deleted..!' });
                                   $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Home/load_classromm_ajax',
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
                            });
                    }
                },
                cancel: function() {
                    //$.alert(' <strong>cancelled</strong>');
                },
            }
        });

}

function clear_form() {
        $("form.add-edit").find("input,textarea,select").each(function(index, element) {
            if ($(element)) {
                var tag = $(element)[0].tagName;
                switch (tag) {
                    case "INPUT":
                        $(element).not(':checkbox').not('.exclude-status').val("");
                        if ($(element).not('.exclude-status').is(":checkbox")) $(element).prop('checked', false);
                        break;
                    case "TEXTAREA":
                        $(element).not('.exclude-status').val("");

                        break;
                    case "SELECT":
                        if ($(element).hasClass("exclude-status")) $(element).val("");
                        var choose_an_item = 0;
                        $(element).find('option').each(function() {
                            if ($(element).val() == "") {
                                choose_an_item = 1;
                            }
                        });
                        if (choose_an_item == 1) {
                            $(element).val("");
                        } else {
                            $(element).val("1");
                        }
                        if ($(element).hasClass("exclude-this")) $(element).val("1");
                        if ($(element).hasClass("exclude-banner")) $(element).val("_blank");
                        break;
                    default:
                        return false;
                }
            }
        });
    }



</script>
