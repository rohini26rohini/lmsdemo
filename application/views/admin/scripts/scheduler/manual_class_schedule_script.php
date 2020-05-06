<script type="text/javascript">
    $(document).ready(function(){
        create_calendar(850,'');

        $("#branch").change(function(){
            var html = '<option value="">Select a Center</option>';
            if($("#branch").val() != ''){
                update_center();
            }else{
                var html = '<option value="">Select a branch</option>';
                $("#center").html(html);
                $("#course").html(html);
                $("#batch").html(html);
                $("#subject").html(html);
                $("#module").html(html);
            }
            update_faculty();
        });
        
        $("#center").change(function(){
            var html = '<option value="">Select a course</option>';
            if($("#center").val()!=''){
                update_course();
                update_room();
            }else{
                $("#course").html(html);
                $("#batch").html(html);
                $("#subject").html(html);
                $("#module").html(html);
            }
            update_faculty();
        });
        
        $("#course").change(function(){
            var html = '<option value="">Select a batch</option>';
            if($("#center").val()!='' && $("#course").val()!=''){
                update_batch_subject();
            }else{
                $("#batch").html(html);
                $("#subject").html(html);
                $("#module").html(html);
            }
            update_faculty();
        });
        
        $("#batch").change(function(){
            if($("#batch").val()!=''){
                update_date_picker();
            }
            update_faculty();
        });

        $("#subject").change(function(){
            var html = '<option value="">Select a subject</option>';
            if($("#subject").val() != '' && $("#course").val() != ''){
                update_modules();
            }else{
                $("#module").html(html);
            }
            update_faculty();
        });

        $("#module").change(function(){
            update_faculty();
        });

        $("#date").on("dp.change", function(e) {
            if($("#date").val() != ''){
                var date = $("#date").val().split('-');
                $('#calendar').fullCalendar('gotoDate', date[2]+'-'+date[1]+'-'+date[0]);
            }
            update_faculty();
        });

        $("#starttime").on("dp.change", function(e) {
            update_faculty();
        });

        $("#endtime").on("dp.change", function(e) {
            update_faculty();
        });

        $("#manual_schedule_class_form").validate({
            rules: {
                branch: "required",
                center: "required",
                course: "required",
                batch: "required",
                subject: "required",
                module: "required",
                date: "required",
                starttime: "required",
                endtime: "required",
                faculty: "required",
                room: "required"
            },
            messages: {
                branch: "Please select a branch",
                center: "Please select a center",
                course: "Please select a course",
                batch: "Please select a batch to schedule",
                subject: "Please select a subject",
                module: "Please select a class topic",
                date: "Please select a day",
                starttime: "Please provide class start time",
                endtime: "Please provide class start time",
                faculty: "Please select a faculty",
                room: "Please select a room"
            },
            submitHandler: function (form) {
                $(".loader").show();
                $('.btn_save').prop('disabled', true);
                $.ajax({
                    url: "<?php echo base_url('backoffice/scheduler/manually_schedule_batch'); ?>",
                    type: "post",
                    data: $(form).serialize(),
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if (obj.st == 1) {
                            update_calendar();
                            $('#calendar').fullCalendar('gotoDate', obj.date);
                            $.toaster({priority:'success',title:'Message',message:obj.message});
                        }else{
                            $.toaster({priority:'danger',title:obj.message,message:''});
                        }
                        $('.btn_save').prop('disabled', false);
                        $(".loader").hide();
                    },
                    error: function () {
                        $(".loader").hide();
                        $('.btn_save').prop('disabled', false);
                        $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                    }
                });
            }
        });

        $(".reset").click(function(){
            $("#manual_schedule_class_form").trigger("reset");
        });
    });

    function finish_scheduling(){
        if($("#batch").val()!=''){
            $(".loader").show();
            jQuery.ajax({
                url: "<?php echo base_url('backoffice/scheduler/finish_scheduling'); ?>",
                type: "post",
                data: {
                    'batch':$("#batch").val(),
                    'ci_csrf_token':csrfHash
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    if(obj.st == 1){
                        update_calendar();
                        $('#calendar').fullCalendar('gotoDate', obj.date);
                        $('#finishmodal').modal('hide');
                    }else{
                        $.toaster({priority:'danger',title:'Error',message:obj.message});
                    }
                    $(".loader").hide();
                },
                error: function () {
                    $(".loader").hide();
                    $.toaster({priority:'danger',title:'Error',message:'There is an error while submit'});
                }
            });
        }
    }
    
    function update_center(center_id=''){
        var defer = $.Deferred();
        var html = '<option value="">Select a Center</option>';
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/scheduler/get_center'); ?>",
            type: "post",
            data: {
                'branch_id':$("#branch").val(),
                'ci_csrf_token':csrfHash
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if(obj.centers!=""){
                    $.each(obj.centers, function( index, value ) {
                        html = html+'<option value="'+value.id+'">'+value.center_name+'</option>';
                    });
                }
                $("#center").html(html);
                if(center_id != ''){
                    $("#center").val(center_id).prop('selected','selected');
                }
                $(".loader").hide();
                return defer;
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'danger',title:'Error',message:'Internal server error please try again later'});
            }
        });
    }

    function update_course(course_id=''){
        var defer = $.Deferred();
        var html = '<option value="">Select a course</option>';
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/scheduler/get_course'); ?>",
            type: "post",
            data: {
                'center_id':$("#center").val(),
                'ci_csrf_token':csrfHash
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if(obj.courses!=""){
                    $.each(obj.courses, function( index, value ) {
                        html = html+'<option value="'+value.id+'">'+value.course_name+'</option>';
                    });
                }
                $("#course").html(html);
                if(course_id!=''){
                    $("#course").val(course_id).prop('selected','selected');
                }
                $(".loader").hide();
                return defer;
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'danger',title:'Error',message:'Internal server error please try again later'});
            }
        });
    }

    function update_batch_subject(batch_id='',subject_id=''){
        var defer = $.Deferred();
        var html = '<option value="">Select a batch</option>';
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/scheduler/get_batch'); ?>",
            type: "post",
            data: {
                'center_id':$("#center").val(),
                'course_id':$("#course").val(),
                'ci_csrf_token':csrfHash
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if(obj.batch!=""){
                    $.each(obj.batch, function( index, value ) {
                        html = html+'<option value="'+value.id+'">'+value.batch_name+'</option>';
                    });
                    update_subjects(subject_id);
                }
                $("#batch").html(html);
                if(batch_id != ''){
                    $("#batch").val(batch_id).prop('selected','selected');
                }
                $(".loader").hide();
                return defer;
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'danger',title:'Error',message:'Internal server error please try again later'});
            }
        });
    }

    function update_date_picker(date=''){
        var defer = $.Deferred();
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/scheduler/get_batch_schedule_available_dates'); ?>",
            type: "post",
            data: {
                'batch':$("#batch").val(),
                'ci_csrf_token':csrfHash
            },
            success: function (data) {
                var obj = JSON.parse(data);
                $('.calendarclass').datetimepicker('destroy');
                $('.calendarclass').datetimepicker({
                    format:'DD-MM-YYYY',
                    minDate: obj.batch_datefrom,
                    maxDate: obj.batch_dateto,
                    useCurrent:false
                });
                if(date!=''){
                    $("#date").val(date);
                }
                $(".loader").hide();
                return defer;
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'danger',title:'Error',message:'Internal server error pleae try again later'});
            }
        });
    }

    function update_subjects(subject_id=''){
        var defer = $.Deferred();
        var html = '<option value="">Select a subject</option>';
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/scheduler/get_course_subjects'); ?>",
            type: "post",
            data: {
                'course_id':$("#course").val(),
                'ci_csrf_token':csrfHash
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if(obj.subjects != ""){
                    $.each(obj.subjects, function( index, value ) {
                        html = html+'<option value="'+value.id+'">'+value.subject_name+'</option>';
                    });
                }
                $("#subject").html(html);
                if(subject_id!=''){
                    $("#subject").val(subject_id).prop('selected','selected');
                }
                $(".loader").hide();
                return defer;
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'danger',title:'Error',message:'Internal server error please try again later'});
            }
        });
    }

    function update_modules(module_id=''){
        var defer = $.Deferred();
        var html = '<option value="">Select a module</option>';
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/scheduler/get_course_subject_modules'); ?>",
            type: "post",
            data: {
                'course_id':$("#course").val(),
                'subject_id':$("#subject").val(),
                'ci_csrf_token':csrfHash
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if(obj.modules != ""){
                    $.each(obj.modules, function( index, value ) {
                        html = html+'<option value="'+value.id+'">'+value.subject_name+'</option>';
                    });
                }
                $("#module").html(html);
                if(module_id!=''){
                    $("#module").val(module_id).prop('selected','selected');
                }
                $(".loader").hide();
                return defer;
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'danger',title:'Error',message:'Internal server error please try again later'});
            }
        });
    }
    
    function update_room(room_id=''){
        var defer = $.Deferred();
        $(".loader").show();
        $.ajax({
            url: "<?php echo base_url('backoffice/scheduler/get_exam_rooms_center'); ?>",
            type: "post",
            data: {'center':$('#center').val(),'ci_csrf_token':csrfHash},
            success: function (data) {
                var obj = JSON.parse(data);
                $('#room').html(obj.html);
                if(room_id!=''){
                    $("#room").val(room_id).prop('selected','selected');
                }
                $(".loader").hide();
                return defer;
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'error',title:'Error',message:'Technical error please try again later'});
            }
        });
    }
    
    function update_faculty(faculty_id=''){
        var html = '<option value="">Select a faculty</option>';
        if($("#subject").val() != '' && $("#module").val() != '' && $("#batch").val() != '' && $("#date").val() != '' && $("#starttime").val() != '' && $("#endtime").val() != ''){
            var defer = $.Deferred();
            $(".loader").show();
            $.ajax({
                url: "<?php echo base_url('backoffice/scheduler/get_faculty_module'); ?>",
                type: "post",
                data: { 'batch':$('#batch').val(),
                        'subject':$('#subject').val(),
                        'date':$('#date').val(),
                        'module':$('#module').val(),
                        'starttime':$('#starttime').val(),
                        'endtime':$('#endtime').val(),
                        'ci_csrf_token':csrfHash
                    },
                success: function (data) {
                    var obj = JSON.parse(data);
                    $('#faculty').html(obj.html);
                    if(faculty_id!=''){
                        $("#faculty").val(faculty_id).prop('selected','selected');
                    }
                    $(".loader").hide();
                    return defer;
                },
                error: function () {
                    $(".loader").hide();
                    $.toaster({priority:'error',title:'Error',message:'Technical error please try again later'});
                }
            });
        }else{
            $("#faculty").html(html);
        }
    }
    
<?php if(isset($reschedule_data)){ ?>
    $(document).ready(function(){
            var schedule_id = <?php echo $reschedule_data['schedule_id']; ?>;
            var course_id = <?php echo $reschedule_data['course_id']; ?>;
            var branch_id = <?php echo $reschedule_data['branch_id']; ?>;
            var center_id = <?php echo $reschedule_data['center_id']; ?>;
            var subject_id = <?php echo $reschedule_data['subject_id']; ?>;
            var batch_id = <?php echo $reschedule_data['batch_id']; ?>;
            var date = '<?php echo $reschedule_data['date']; ?>';
            var calendar_date = '<?php echo $reschedule_data['calendar_date']; ?>';
            var start_time = '<?php echo $reschedule_data['start_time']; ?>';
            var end_time = '<?php echo $reschedule_data['end_time']; ?>';
            var room = <?php echo $reschedule_data['room']; ?>;
            var faculty_id = <?php echo $reschedule_data['staff_id']; ?>;
            var module_id = <?php echo $reschedule_data['module_id']; ?>;
            $("#schedule_id").val(schedule_id);
            $("#starttime").val(start_time);
            $("#endtime").val(end_time);
            $("#branch").val(branch_id).prop('selected','selected');
            $('#calendar').fullCalendar('gotoDate', calendar_date);

            $(".loader").hide();
            $(".loader").prop('class','temp_loader');
            $(".temp_loader").show();
            setTimeout(function(){$(".loader").show();update_center(center_id);}, 1000);
            setTimeout(function(){ update_course(course_id);},2000);
            setTimeout(function(){ update_batch_subject(batch_id,subject_id);}, 3000);
            setTimeout(function(){ update_date_picker(date);}, 4000);
            setTimeout(function(){ update_modules(module_id);}, 5000);
            setTimeout(function(){ update_room(room);}, 6000);
            setTimeout(function(){ 
                update_faculty(faculty_id);
                $(".temp_loader").hide();
                $(".temp_loader").prop('class','loader');
            }, 7000);
      });
<?php } ?>

</script>
     
    