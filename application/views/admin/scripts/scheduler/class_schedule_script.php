<script type="text/javascript">
    $(".datefield").hide();
    $(document).ready(function(){

        create_calendar();

        $("#branch").change(function(){
            var html = '<option value="">Select a Center</option>';
            if($("#branch").val()!=''){
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
                        $(".datefield").hide();
                        $(".loader").hide();
                    },
                    error: function () {
                        $(".loader").hide();
                        $.toaster({priority:'danger',title:'Error',message:'Internal server error please try again later'});
                    }
                });
            }else{
                $("#center").html(html);
                $(".datefield").hide();
            }
        });
        
        $("#center").change(function(){
            var html = '<option value="">Select a course</option>';
            if($("#center").val()!=''){
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
                        $(".datefield").hide();
                        $(".loader").hide();
                    },
                    error: function () {
                        $(".loader").hide();
                        $.toaster({priority:'danger',title:'Error',message:'Internal server error please try again later'});
                    }
                });
            }else{
                $("#course").html(html);
                $(".datefield").hide();
            }
        });
        
        $("#course").change(function(){
            var html = '<option value="">Select a batch</option>';
            if($("#center").val()!=''){
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
                        }
                        $("#batch").html(html);
                        $(".datefield").hide();
                        $(".loader").hide();
                    },
                    error: function () {
                        $(".loader").hide();
                        $.toaster({priority:'danger',title:'Error',message:'Internal server error please try again later'});
                    }
                });
            }else{
                $("#batch").html(html);
                $(".datefield").hide();
            }
        });
        
        $("#batch").change(function(){
            if($("#batch").val()!=''){
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
                        $("#start_date").val(obj.datefrom);
                        $("#end_date").val(obj.dateto);
                        $(".datefield").show();
                        $(".loader").hide();
                    },
                    error: function () {
                        $(".loader").hide();
                        $.toaster({priority:'danger',title:'Error',message:'There is an error while submit'});
                    }
                });
            }else{
                $(".datefield").hide();
            }
        });

        $("#schedule_exam_form").validate({
            rules: {
                branch: "required",
                center: "required",
                course: "required",
                batch: "required"
            },
            messages: {
                branch: "Please select a branch",
                center: "Please select a center",
                course: "Please select a course",
                batch: "Please select a batch to schedule"
            },
            submitHandler: function (form) {
                $(".loader").show();
                $('.btn_save').prop('disabled', true);
                $.ajax({
                    url: "<?php echo base_url('backoffice/scheduler/schedule_batch'); ?>",
                    type: "post",
                    data: $(form).serialize(),
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if (obj.st == 1) {
                            var html = '<div class="table-responsive table_language" style="width:747px;height:450px;">'+
                                            '<table class="table table-bordered table-sm">'+
                                            '<tr>'+
                                                '<th>Date</th>'+
                                                '<th>Time</th>'+
                                                '<th>Module</th>'+
                                                '<th>Faculty</th>'+
                                                '<th>Room</th>'+
                                                '<th>Status</th>'+
                                            '</tr>';
                                          
                            $.each(obj.data.body, function(i,value) {
                                $.each(value, function(index,v) {
                                    if(v.conflict==1){
                                        html = html+'<tr style="background-color:#e0b0b0;">';
                                    }else{
                                        html = html+'<tr>';
                                    }
                                    if(i != ''){
                                        html = html+'<td>'+i+'</td>';
                                        i='';
                                    }else{
                                        html = html+'<td>&nbsp;</td>';
                                    }

                                    html = html+'<td>'+v.start_time+' <br>to</br> '+v.end_time+'</td>'+
                                                '<td>'+v.module+'</td>'+
                                                '<td>'+v.faculty+'</td>'+
                                                '<td>'+v.room+'</td>'+
                                                '<td>'+v.message+'</td>'+
                                            '</tr>';
                                });
                            });
                            html = html+'</table></div>';
                            $("#finishmodal_body").html(html);
                            $("#finishmodal_title").html(obj.data.title);
                            $("#finishmodal_footer").html(obj.data.footer);
                            $('#finishmodal').modal('show');
                            // $.toaster({priority:'success',title:'Message',message:obj.message});
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
                        $('#calendar').fullCalendar('changeView', 'agendaWeek');
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
    
</script>
     
