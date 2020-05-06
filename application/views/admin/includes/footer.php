
        <div id="reschedule_modal_exam" class="modal fade form_box modalCustom" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="reschedule_modal_schedulename"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td width="50%">Exam name:</td>
                                    <td id="reschedule_modal_examname"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Exam date:</td>
                                    <td id="reschedule_modal_examdate"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Exam start time:</td>
                                    <td id="reschedule_modal_examstime"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Exam end time:</td>
                                    <td id="reschedule_modal_exametime"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Exam room:</td>
                                    <td id="reschedule_modal_examroom"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Exam type:</td>
                                    <td id="reschedule_modal_examresult"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Exam status:</td>
                                    <td id="reschedule_modal_examstatus"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Batch:</td>
                                    <td id="reschedule_modal_batch"></td>
                                </tr>
                            </tbody>
                        </table>
                        <span class="pdeactivatespan" style="display: none;">*Note: Deactivated exam should not find anywhere in the user profile</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="reschedule_modal_exam_button" class="btn btn-success">Reschedule exam</button>
                        <button type="button" id="delete_modal_exam_button" class="btn btn-danger">Cancel exam</button>
                        <button type="button" id="change_status_exam_button" class="btn btn-info"></button>
                   </div>
                </div>
            </div>
        </div>        
        
        <div id="reschedule_batch_modal" class="modal fade form_box modalCustom" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="reschedule_modal_batch_schedulename"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td width="50%">Center Name:</td>
                                    <td id="reschedule_modal_centername"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Batch Name:</td>
                                    <td id="reschedule_modal_batchname"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Class Topic:</td>
                                    <td id="reschedule_modal_classtopic"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Topic Content:</td>
                                    <td id="reschedule_modal_classcontent"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Faculty:</td>
                                    <td id="reschedule_modal_faculty"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Room:</td>
                                    <td id="reschedule_modal_room"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Date and time:</td>
                                    <td id="reschedule_modal_datetime"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="reschedule_modal_batch_button" class="btn btn-success">Reschedule</button>
                        <button type="button" id="delete_modal_batch_button" class="btn btn-danger">Delete schedule</button>
                    </div>
                </div>
            </div>
        </div> 

        <div id="assign_learning_module_modal" class="modal fade form_box modalCustom" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="learning_module_batch_schedulename"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td width="50%">Center Name:</td>
                                    <td id="learning_module_centername"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Batch Name:</td>
                                    <td id="learning_module_batchname"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Class Topic:</td>
                                    <td id="learning_module_classtopic"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Topic Content:</td>
                                    <td id="learning_module_classcontent"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Faculty:</td>
                                    <td id="learning_module_faculty"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Room:</td>
                                    <td id="learning_module_room"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Date and time:</td>
                                    <td id="learning_module_datetime"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Assinged learning module</td>
                                    <td id="learning_module_assigned"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="learning_module_assign_button" class="btn btn-success"></button>
                    </div>
                </div>
            </div>
        </div> 
        <div id="learning_module_list" class="modal fade form_box modalCustom" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Assign Learning Module</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-striped" id="learning_module_table">
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="learning_module_savebtn" class="btn btn-success">Save</button>
                        
                   </div>
                </div>
            </div>
        </div> 
        <div id="calendar_advanced_filter_modal" class="modal fade form_box modalCustom" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Advanced Filter</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form autocomplete="off" id="calendar_advanced_filter" method="post" enctype="multipart/form-data"  accept-charset="utf-8">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 form-group ">
                                    <label>Branch<span class="req redbold">*</span></label>
                                    <select name="branch" class="form-control" onchange="get_calendar_center()" id="calendar_branch">
                                        <option value="">Select Branch</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group ">
                                    <label>Center<span class="req redbold">*</span></label>
                                    <select name="center" class="form-control" onchange="get_calendar_course()" id="calendar_center">
                                        <option value="">Select Center</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group ">
                                    <label>Course<span class="req redbold">*</span></label>
                                    <select name="course" class="form-control" onchange="get_calendar_batch()" id="calendar_course">
                                        <option value="">Select Course</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group ">
                                    <label>Batch<span class="req redbold">*</span></label>
                                    <select name="batch" class="form-control" id="calendar_batch">
                                        <option value="">Select Batch</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Filter</button>
                            <button type="button" id="reset_calendar_filter" class="btn btn-info">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
        <?php 
            if(ENVIRONMENT=='production'){
                echo "<script>$.fn.dataTable.ext.errMode = 'none';</script>";
            }
        ?>
        <script>
        
            $(document).ready(function(){
                $("#calendar_advanced_filter").validate({
                    rules: {
                        branch: {required: true},
                        center: {required: true},
                        course: {required: true},
                        batch: {required: true}
                    },
                    messages: {
                        branch: {required: "Please select a branch"},
                        center: {required: "Please select a center"},
                        course: {required: "Please select a course"},
                        batch: {required: "Please select a batch"}
                    },
                    submitHandler: function(form) {
                        var url = base_url+"backoffice/calendar/get_calendar_events?batch_id="+$("#calendar_batch").val();
                        update_calendar(url);
                        $("#calendar_advanced_filter_modal").modal('hide');
                    }
                });
                $("#reset_calendar_filter").click(function(){
                    update_calendar();
                    $("#calendar_advanced_filter").trigger("reset");
                    $("#calendar_advanced_filter_modal").modal('hide');
                });
            });
            function reschedule(id){
                $(".loader").show();
                $.ajax({
                    url: base_url+"backoffice/calendar/reschedule_permission",
                    type: "GET",
                    data: {id:id},
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if(obj.data.schedule_type==1){
                            $("#reschedule_modal_examname").html(obj.data.examname);
                            $("#reschedule_modal_examdate").html(obj.data.schedule_date);
                            $("#reschedule_modal_examstime").html(obj.data.schedule_start_time);
                            $("#reschedule_modal_exametime").html(obj.data.schedule_end_time);
                            $("#reschedule_modal_examroom").html(obj.data.description);
                            $("#reschedule_modal_batch").html(obj.data.batch_name);
                            $("#reschedule_modal_schedulename").html(obj.data.schedule_description);
                            $("#reschedule_modal_examresult").html(obj.data.result_immeadiate);
                            $("#reschedule_modal_examstatus").html(obj.data.statusname);
                            $("#change_status_exam_button").html(obj.data.newstatusname);
                            $("#reschedule_modal_exam").modal('show');
                            if(obj.examst){ 
                                $("#change_status_exam_button").show();
                                $("#change_status_exam_button").val(obj.data.schedule_id);
                            }else{
                                $("#change_status_exam_button").hide();
                            }
                            if(obj.st){
                                $("#reschedule_modal_exam_button").show();
                                $("#delete_modal_exam_button").show();
                                $("#reschedule_modal_exam_button").val(obj.data.schedule_id);
                                $("#delete_modal_exam_button").val(obj.data.schedule_id);
                            }else{
                                $("#reschedule_modal_exam_button").hide();
                                $("#delete_modal_exam_button").hide();
                            }
                        }
                        if(obj.data.schedule_type==2){
                            $("#reschedule_modal_centername").html(obj.data.center_name);
                            $("#reschedule_modal_batchname").html(obj.data.batch_name);
                            $("#reschedule_modal_classtopic").html(obj.data.module_name);
                            $("#reschedule_modal_classcontent").html(obj.data.module_content);
                            $("#reschedule_modal_faculty").html(obj.data.faculty_name);
                            $("#reschedule_modal_room").html(obj.data.classroom_name);
                            $("#reschedule_modal_datetime").html(obj.data.reschedule_modal_datetime);
                            $("#reschedule_modal_batch_schedulename").html(obj.data.schedule_description);
                            $("#change_status_exam_button").hide();
                            $("#reschedule_batch_modal").modal('show');
                            if(obj.st && obj.data.class_taken==0){
                                $("#reschedule_modal_batch_button").show();
                                $("#delete_modal_batch_button").show();
                                $("#reschedule_modal_batch_button").val(obj.data.schedule_id);
                                $("#delete_modal_batch_button").val(obj.data.schedule_id);
                            }else{
                                $("#reschedule_modal_batch_button").hide();
                                $("#delete_modal_batch_button").hide();
                            }
                        }
                        if(obj.data.examstatus == 5){
                            $('.pdeactivatespan').show();
                        }else{
                            $('.pdeactivatespan').hide();
                        }
                        $(".loader").hide();
                    }
                });
            }
            
            function assign_learning_module(id){
                $(".loader").show();
                $.ajax({
                    url: base_url+"backoffice/calendar/assign_learning_module",
                    type: "GET",
                    data: {id:id},
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if(obj.data.schedule_type==2){
                            $("#learning_module_centername").html(obj.data.center_name);
                            $("#learning_module_batchname").html(obj.data.batch_name);
                            $("#learning_module_classtopic").html(obj.data.module_name);
                            $("#learning_module_classcontent").html(obj.data.module_content);
                            $("#learning_module_faculty").html(obj.data.faculty_name);
                            $("#learning_module_room").html(obj.data.classroom_name);
                            $("#learning_module_datetime").html(obj.data.reschedule_modal_datetime);
                            $("#learning_module_batch_schedulename").html(obj.data.schedule_description);
                            $("#assign_learning_module_modal").modal('show');
                            $("#reschedule_modal_batch_button").show();
                            $("#learning_module_assigned").html(obj.data.learning_module);
                            if(obj.data.assinged_module_flag == 0){
                                $("#learning_module_assign_button").html('Reassign learning module');
                            }else{
                                $("#learning_module_assign_button").html('Assign a learning module');
                            }
                            $("#learning_module_assign_button").val(obj.data.schedule_id);
                        }
                        $(".loader").hide();
                    }
                });
            }

            $(document).on('click','#reschedule_modal_exam_button',function() {
                var id = $(this).val();
                redirect("backoffice/exam-schedule?id="+id);
            });

            $(document).on('click','#reschedule_modal_batch_button',function() {
                var id = $(this).val();
                redirect("backoffice/manual-class-schedule?id="+id);
            });

            $(document).on('click','#delete_modal_exam_button',function() {
                var schedule_id = $(this).val();
                cancel_schedule(schedule_id);
            });

            $(document).on('click','#delete_modal_batch_button',function() {
                var schedule_id = $(this).val();
                cancel_schedule(schedule_id);
            });

            $(document).on('click','#change_status_exam_button',function() {
                var schedule_id = $(this).val();
                change_schedule_status(schedule_id);
            });

            function cancel_schedule(schedule_id){
                $.confirm({
                    title: 'Warning',
                    content: 'Are you sure you want to cancel this schedule?',
                    icon: 'fa fa-question-circle',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
                        'confirm': {
                            text: 'Yes',
                            btnClass: 'btn-red',
                            action: function() {
                                $.ajax({
                                    url: base_url+'backoffice/scheduler/delete_schedule',
                                    type: "post",
                                    data: {
                                        'schedule_id':schedule_id,
                                        'ci_csrf_token':csrfHash
                                    },
                                    success: function (data) {
                                        var obj = JSON.parse(data);
                                        if (obj.st == 1) {
                                            update_calendar();
                                            $('.modal').modal('hide');
                                            $.toaster({priority:'success',title:'Message',message:obj.message});
                                        }else{
                                            $.toaster({priority:'danger',title:obj.message,message:''});
                                        }
                                    },
                                    error: function () {
                                        $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                                    }
                                });
                            }
                        },
                        'cancel': {
                            text: 'No',
                            btnClass: 'btn-white',
                            action: function() {
                            }
                        }
                    }
                });
            }

            function change_schedule_status(schedule_id){
                $.confirm({
                    title: 'Warning',
                    content: 'Are you sure you want to change the status of this exam?',
                    icon: 'fa fa-question-circle',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
                        'confirm': {
                            text: 'Yes',
                            btnClass: 'btn-red',
                            action: function() {
                                $.ajax({
                                    url: base_url+'backoffice/scheduler/change_exam_status',
                                    type: "post",
                                    data: {
                                        'schedule_id':schedule_id,
                                        'ci_csrf_token':csrfHash
                                    },
                                    success: function (data) {
                                        var obj = JSON.parse(data);
                                        if (obj.st == 1) {
                                            update_calendar();
                                            $('.modal').modal('hide');
                                            $.toaster({priority:'success',title:'Message',message:obj.message});
                                        }else{
                                            alert_message(obj.message);
                                            // $.toaster({priority:'danger',title:obj.message,message:''});
                                        }
                                    },
                                    error: function () {
                                        $.toaster({priority:'warning',title:'Error',message:'Network error please try again later'});
                                    }
                                });
                            }
                        },
                        'cancel': {
                            text: 'No',
                            btnClass: 'btn-white',
                            action: function() {
                            }
                        }
                    }
                });
            }

            $(document).on('click','#learning_module_assign_button',function() {
                var schedule_id = $(this).val();
                assign_learning_module_schedule(schedule_id);
            });
            function assign_learning_module_schedule(id){
                $("#learning_module_table").empty();
                $(".loader").show();
                $.ajax({
                    url: base_url+"backoffice/Questionbank/get_learning_module",
                    type: "post",
                    data: {id:id,'ci_csrf_token':csrfHash},
                    success: function (data) {
                        $("#learning_module_table").html(data);
                        $("#assign_learning_module_modal").modal('hide');
                        $("#learning_module_list").modal('show');
                        $(".loader").hide();
                    }
                });
            }

            $(document).on('click','#learning_module_savebtn',function() {
                var selectedlearningmodule = $('input[name=module_id]:checked').val();
                // alert(selectedlearningmodule);
                if(selectedlearningmodule == undefined){
                    $.toaster({priority:'danger',title:'Error',message:'Please select any of the given learning module.!'});
                    return false;
                }
                var scheduleId = $('#scheduleId').val();
                assign_learning_module_save(selectedlearningmodule,scheduleId);
            });
            function assign_learning_module_save(selectedlearningmodule,scheduleId){
                // alert(scheduleId);
                $(".loader").show();
                $.ajax({
                    url: base_url+"backoffice/Questionbank/assign_learning_module_save",
                    type: "post",
                    data: {
                            selectedlearningmodule:selectedlearningmodule,
                            scheduleId:scheduleId,
                            'ci_csrf_token':csrfHash
                        },
                    success: function (data) {
                        var obj = JSON.parse(data);
                            if (obj.st == 1) {
                                assign_learning_module(scheduleId);
                                $('#learning_module_list').modal('hide');
                                $.toaster({priority:'success',title:'Message',message:obj.msg});
                            }else{
                                $.toaster({priority:'danger',title:obj.message,message:''});
                            }
                        $("#learning_module_table").html(data);
                        $("#assign_learning_module_modal").modal('hide');
                        $("#learning_module_list").modal('show');
                        $(".loader").hide();
                    }
                });
            }


            $(window).on("load", function () {
                $(".loader").hide();
            });




            
        </script>

    </body>
</html>
