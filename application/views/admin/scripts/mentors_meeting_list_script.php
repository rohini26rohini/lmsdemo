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
                    $("#filter_course").html(response);
                    $("#filter_batch").html("");
                    $("#get_center_id").val($("#filter_centre").val());
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
                url: '<?php echo base_url();?>backoffice/Students/get_batches_byCourse',
                type: 'POST',
                data: {
                    course_id: course_id,
                    center: center,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    $("#filter_batch").html(response);
                    var batch_id=$("#filter_batch").val(); 
                    $("#get_course_id").val($("#filter_course").val());
                    $(".loader").hide();

                }
            });
        }
    });
  



    $("#edit_filter_centre").change(function(){
        var center = $('#edit_filter_centre').val();
        if (center != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/edit_get_centercoursemapping',
                type: 'POST',
                data: {
                    centre_id: center,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    $("#edit_filter_course").html(response);
                    $("#edit_filter_batch").html("");
                    $("#edit_get_center_id").val($("#edit_filter_centre").val());
                    edit_search();
                    $(".loader").hide();
                }
            });
        }
    });
    $("#edit_filter_course").change(function(){
        var course_id=$(this).val();
        var center = $('#edit_filter_centre').val();
        if (course_id != "" && center !="") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/edit_get_batches_byCourse',
                type: 'POST',
                data: {
                    course_id: course_id,
                    center: center,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    $("#edit_filter_batch").html(response);
                    var batch_id=$("#edit_filter_batch").val(); 
                    $("#edit_get_course_id").val($("#edit_filter_course").val());
                    edit_search();
                    $(".loader").hide();

                }
            });
        }
    });
    $("#edit_filter_batch").change(function(){
        var batch_id=$(this).val();
        var course_id = $('#edit_filter_course').val();
        var center = $('#edit_filter_centre').val();
        if (batch_id != "" && course_id != "" && center !="") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/edit_get_mentors_byBatch',
                type: 'POST',
                data: {
                    batch_id: batch_id,
                    course_id: course_id,
                    center: center,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    $("#edit_staff_id").html(response);
                    var batch_id=$("#edit_staff_id").val(); 
                    edit_search();
                    get_staff_id();
                    $(".loader").hide();

                }
            });
        }
    });
    $("#edit_filter_batch").change(function(){
        var batch_id=$(this).val();
        var course_id = $('#edit_filter_course').val();
        var center = $('#edit_filter_centre').val();
        if (batch_id != "" && course_id != "" && center !="") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/edit_get_rooms_byBatch',
                type: 'POST',
                data: {
                    batch_id: batch_id,
                    course_id: course_id,
                    center: center,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    $("#edit_room_ids").html(response);
                    var batch_id=$("#edit_room_ids").val(); 
                    edit_search();
                    get_staff_id();
                    get_room_id();
                    $(".loader").hide();

                }
            });
        }
    });
    $("form#mentors_meeting_form").validate({
        rules: {
            staff_id: { required: true }
        },
        messages: {
            staff_id: "Please Choose Mentor"
        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/mentors_meeting_add',
                type: 'POST',
                data: $("#mentors_meeting_form").serialize(),
                success: function(response) {
                    if (response != "2" && response != "0") {
                        $('#mentors_meeting_form' ).each(function(){
                            this.reset();
                        });
                        $.toaster({ priority : 'success', title : 'Success', message : 'Meeting Scheduled Succesfully' });
                    }else if(response == "2"){
                        $.toaster({ priority : 'danger', title : 'Error', message : 'Meeting Schedule Already Exist' });
                    }
                    $(".loader").hide();
                }
            });
        }
    });

    $("form#edit_mentors_meeting_form").validate({
        rules: {
            date: { required: true },
            time: { required: true },
            room_id: { required: true }
        },
        messages: {
            date: "Please Select Date",
            time: "Please Select Time",
            room_id: "Please Choose Classroom"

        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/mentors_meeting_edit',
                type: 'POST',
                data: $("#edit_mentors_meeting_form").serialize(),
                success: function(response) {
                    if (response != "2" && response != "0") {
                        $('#edit_meeting').modal('toggle');

                        $('#edit_mentors_meeting_form' ).each(function(){
                            this.reset();
                        });
                        $.toaster({ priority : 'success', title : 'Success', message : 'Meeting Scheduled Succesfully' });
                    }else if(response == "2"){
                        $.toaster({ priority : 'danger', title : 'Error', message : 'Meeting Schedule Already Exist' });
                    }
                    $(".loader").hide();
                }
            });
        }
    });

    $("form#add_feedback_form").validate({
        rules: {
            student_id: { required: true }
        },
        messages: {
            student_id: "Please Choose Atleast One Student"
        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Employee/feedback_add',
                type: 'POST',
                data: $("#add_feedback_form").serialize(),
                success: function(response) {
                    if (response != "2" && response != "0") {
                        $('#add_feedback').modal('toggle');

                        $('#add_feedback_form' ).each(function(){
                            this.reset();
                        });
                        $.toaster({ priority : 'success', title : 'Success', message : 'Feedback Added Succesfully' });
                        $.ajax({
                                url: '<?php echo base_url();?>backoffice/Employee/load_feedback_ajax',
                                type: 'POST',
                                    data: {
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {  
                                    $('#syllabus_data').DataTable().destroy();
                                    $("#syllabus_data").html(response);
                                    $("#syllabus_data").DataTable({
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
                                            }
                                        ]
                                    });    
                                    $(".loader").hide();
                                } 
                            });
                    }else{
                        $.toaster({ priority : 'danger', title : 'Invalid Request', message : 'Something went wrong,Please try again later..!' });
                    }
                    $(".loader").hide();
                }
            });
        }
    });
    function edit_search(){
        // $('#edit_loadreportview').show();
        $(".loader").show();

        $.ajax({
            url: '<?php echo base_url();?>backoffice/Students/edit_get_student_list_byMentor',
            type: "post",
            data: $("#edit_search_form").serialize(),
            success: function(data) {
                $("#institute_data").DataTable().destroy();
                $("#institute_data").html(data); 
                $("#institute_data").DataTable({
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

    function edit_check_all()
    {
        if($("#edit_main:checkbox:checked").length == 0){
            $('.all_student').prop('checked', false);
        }else{
            $('.all_student').prop('checked', true);
        }
    }


    function get_center_id(){
        $("#get_batch_id").val($("#filter_batch").val());
    }
    function get_course_id(){
        $("#get_staff_id").val($("#staff_id").val());
    }
    function get_batch_id(){
        $("#get_batch_id").val($("#filter_batch").val());
    }
    function get_staff_id(){
        $("#get_staff_id").val($("#staff_id").val());
    }
    function get_room_id(){
        $("#get_room_id").val($("#room_id").val());
    }

    function edit_get_center_id(){
        $("#edit_get_batch_id").val($("#edit_filter_batch").val());
    }
    function edit_get_course_id(){
        $("#edit_get_staff_id").val($("#edit_staff_id").val());
    }

    function edit_get_batch_id(){
        $("#edit_get_batch_id").val($("#edit_filter_batch").val());
    }
    function edit_get_staff_id(){
        $("#edit_get_staff_id").val($("#edit_staff_id").val());
    }
    function edit_get_room_id(){
        $("#edit_get_room_id").val($("#edit_room_id").val());
    }



function get_meetingdata(id){
    $("#edit_meeting_id").val(id);
    $(".loader").show();    
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Students/get_meetings_by_id/'+id,
        type: 'POST',
        data:{edit_meeting_id:id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(response) {
            var obj = JSON.parse(response);
            $("#edit_meeting_id").val(obj.meetings.meeting_id);
            $("#edit_date").val(obj.meetings.date);
            $("#edit_time").val(obj.meetings.time);
            $("#edit_room_id").val(obj.meetings.room_id);
            $("#edit_filter_centre").val(obj.meetings.centre_id);
            // $("#edit_filter_course").val(obj.meetings.course_id);
            // $("#edit_filter_batch").val(obj.meetings.batch_id);
            get_course(obj.meetings.course_id);
            get_batch(obj.meetings.batch_id);
            get_mentors(obj.meetings.staff_id);
            get_rooms();
            $(".loader").hide();
        }
    });
}

function get_course(val1){
    $("#edit_filter_course").html('');
    var center = $('#edit_filter_centre').val();
    if (center != "") {
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Students/edit_get_centercoursemapping',
            type: 'POST',
            data: {
                centre_id: center,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
            success: function(response) {
                $("#edit_filter_course").html(response);
                $("#edit_filter_batch").html("");
                $("#edit_get_center_id").val($("#edit_filter_centre").val());
                $("#edit_filter_course").val(val1);
                get_batch();
                get_mentors();
                // get_rooms();

                edit_search();
                $(".loader").hide();
            }
        });
    }
}

function get_batch(val2){
    
    var center = $('#edit_filter_centre').val();
    var course_id=$('#edit_filter_course').val();
    var center = $('#edit_filter_centre').val();
    if (course_id != "" && center !="") {
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Students/edit_get_batches_byCourse',
            type: 'POST',
            data: {
                course_id: course_id,
                center: center,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
            success: function(response) {
                $("#edit_filter_batch").html(response);
                var batch_id=$("#edit_filter_batch").val(); 
                // alert(batch_id);
                $("#edit_get_course_id").val($("#edit_filter_course").val());
                get_mentors();
                get_rooms();
                // get_rooms(val2);
                $(".loader").hide();

            }
        });
    }
}

function get_mentors(val3){
    var center = $('#edit_filter_centre').val();
    var course_id=$('#edit_filter_course').val();
    var batch_id = $('#edit_filter_batch').val();
    if (batch_id != "" && course_id != "" && center !="") {
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Students/edit_get_mentors_byBatch',
            type: 'POST',
            data: {
                batch_id: batch_id,
                course_id: course_id,
                center: center,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
            success: function(response) {
                // alert("1");
                $("#edit_staff_id").html(response);
                var batch_id=$("#edit_staff_id").val(); 
                $("#edit_get_batch_id").val($("#edit_filter_batch").val());
                edit_search();
                // edit_get_staff_id();
                $(".loader").hide();

            }
        });
    }
}

    function get_rooms(){
        var center      = $('#edit_filter_centre').val();
        var course_id   = $('#edit_filter_course').val();
        var batch_id    = $('#edit_filter_batch').val();
        var room_idss   = $('#edit_room_id').val();
        // alert(room_id);
        if (batch_id != "" && course_id != "" && center !="") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/edit_get_rooms_byBatch',
                type: 'POST',
                data: {
                    batch_id: batch_id,
                    course_id: course_id,
                    center: center,
                    room_id: room_idss,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    $("#edit_room_ids").html(response);
                    var batch_id=$("#edit_room_ids").val(); 
                    // $("#edit_get_course_id").val($("#edit_filter_course").val());
                    $("#edit_get_staff_id").val($("#edit_staff_id").val());
                    $("#edit_room_ids").val(room_idss);
                    edit_search();
                    $(".loader").hide();
                }
            });
        }
    }


    // // FOR EDIT 
    // function get_rooms(){
    // //   $("#edit_course").change(function () {
    //         $("#edit_filter_centre").html(''); 
    //         $("#edit_filter_course").html('');
    //         $("#edit_filter_batch").html('');
    //         $(".loader").show();
    //         var center      = $('#edit_filter_centre').val();
    //     var course_id   = $('#edit_filter_course').val();
    //     var batch_id    = $('#edit_filter_batch').val();
    //         if (batch_id != "" ) {

    //        $(".loader").show();
	// 		 $.ajax({

    //             url: '<?php echo base_url();?>backoffice/Students/edit_get_rooms_byBatch',
    //             type: 'POST',
    //             data: { batch_id: batch_id,
    //                 course_id: course_id,
    //                 center: center,selected:0,
    //             <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
    //             success: function(response)
    //             {
    //                 $(".loader").hide();
    //                 if(response!='') {
    //                 $("#edit_room_id").html(response);
    //                 } else {
    //                     //$('#accordionExample').html('No batches added for this course.')
    //                 }
    //             }
    //         });
    // }
    // // });
    //     }


</script>