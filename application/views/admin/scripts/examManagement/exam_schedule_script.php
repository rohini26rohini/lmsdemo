
<script type="text/javascript">
    var exam_duration_in_min = 0;
    $(document).ready(function() {
        create_calendar(800);
        $("#duration-error").hide();
    <?php 
        if(isset($details)){
            $date = date('Y-m-d',strtotime($details->start_date_time)).'T'.date('H:i',strtotime($details->end_date_time));
            if(strtotime($details->start_date_time) >= strtotime("+1 day")){
                $start_date_time = strtotime($details->start_date_time);
            }else{
                $start_date_time = strtotime("+1 day",time());
            }
    ?>
        $('#calendar').fullCalendar('gotoDate', '<?php echo $date; ?>');
        $('#calendar').fullCalendar('changeView','agendaDay');
        $('#examdate').datetimepicker({
            date: new Date(<?php echo $start_date_time; ?>)
        });
        $("#center").val(<?php echo $details->institute_master_id; ?>).prop('selected','selected');
        update_room(<?php echo $details->schedule_room; ?>);
        update_batch(<?php echo $details->batch_id; ?>);
        $("#exammodel").val(<?php echo $details->exam_definition_id; ?>).prop('selected','selected');
        $("#examroom").val(<?php echo $details->schedule_room; ?>).prop('selected','selected');
        update_exam_paper();
        get_exam_duration();
    <?php } ?>
        

        $('#examdate').on('dp.change', function(e){
            var date = $('#examdate').val().split('-');
            $('#calendar').fullCalendar('gotoDate', date[2]+'-'+date[1]+'-'+date[0]);
            $('#calendar').fullCalendar('changeView','agendaDay');
            if($('#center').val()==''){
                $("#batch").html('<option value="">Select a center</option>');
            }else{
                update_batch();
            }
        });

        
        $('#center').on('change', function(e){
            if($('#examdate').val()==''){
                $("#batch").html('<option value="">Select a date</option>');
            }else{
                update_batch();
                update_room();
            }
        });

        $('#exammodel').on('change', function(e){
            if($('#exammodel').val()!=''){
                update_exam_paper();
                get_exam_duration();
            }else{
                $("#exam_duration").html('');
                $("#exampapers").html('');
            }
        });

        $("#schedule_exam_form").validate({
            rules: {
                examdate: "required",
                starttime: "required",
                examname: "required",
                batch: "required",
                exammodel: "required",
                'exampapers[]': "required",
                examroom: "required",
                result: "required"
            },
            messages: {
                examdate: "Please provide a date",
                starttime: "Please provide a start time",
                examname: "Please provide a name",
                batch: "Please select a batch",
                exammodel: "Please select an exam model",
                'exampapers[]': "Please select exam papers",
                examroom: "Please select a room",
                result: "Please select an exam type"
            },
            submitHandler: function (form) {
                var formData = $("#schedule_exam_form").serializeArray();
                formData.push({name: "force_exam_schedule", value: 0});
                schedule_exam_common(formData);
            }
        });
    });

    function force_exam_schedule(){
        var formData = $("#schedule_exam_form").serializeArray();
        formData.push({name: "force_exam_schedule", value: 1});
        schedule_exam_common(formData);
    }

    function schedule_exam_common(formData){
        $("#duration-error").hide();
        $(".loader").show();
        $('.btn_save').prop('disabled', true);
        $.ajax({
            url: "<?php echo base_url('backoffice/exam/schedule_exam'); ?>",
            type: "post",
            data: formData,
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.st == 1) {
                    update_calendar();
                    $('#schedule_exam_form').trigger('reset');
                    $('#exampapers').html('');
                    $.toaster({priority:'success',title:obj.message,message:' '});
                }else{
                    if(obj.st == 2){
                        $("#duration-error").html('For final exam the total exam duration must be equal to the selected Exam model duration');
                        $("#duration-error").show();
                        $.toaster({priority:'danger',title:'For final exam the total exam duration must be equal to the selected Exam model duration',message:' '});
                        }else{
                        if(obj.st == 3){
                            var html = '<h5>Batch - <small>'+$('#batch').find(":selected").text()+'</small></h5><div class="table-responsive table_language"><table class="table table-bordered table-striped table-sm"><thead><tr><th>Subject</th><th>Module</th><th>Class</th></tr></thead>';
                            html += "<tbody>";
                            $.each(obj.modules,function(i,v){
                                html += '<tr><td>'+v.subject_name+'</td><td>'+v.module_name+'</td><td><span class="error">Pending</span></td></tr>';
                            });
                            html += "</tbody></table></div>";
                            $("#errormodal_title").html(obj.message);
                            $("#errormodal_body").html(html);
                            $("#errormodal").modal('show');
                            $.toaster({priority:'danger',title:obj.message,message:' '});
                        }else{
                            $.toaster({priority:'danger',title:obj.message,message:' '});
                        }
                    }
                }
                $('.btn_save').prop('disabled', false);
                $(".loader").hide();
            },
            error: function (jqXHR, exception) {
                $(".loader").hide();
                $('.btn_save').prop('disabled', false);
                update_calendar();
                show_ajax_error_message(jqXHR, exception);
            }
        });
    }

    function update_batch(id=''){
        $(".loader").show();
        $.ajax({
            url: "<?php echo base_url('backoffice/exam/get_batch_in_date_center'); ?>",
            type: "post",
            data: {'examdate':$('#examdate').val(),'center':$('#center').val(),'ci_csrf_token':csrfHash},
            success: function (data) {
                var obj = JSON.parse(data);
                $('#batch').html(obj.html);
                if(id!=''){
                    $("#batch").val(id).prop('selected','selected');
                }
                $(".loader").hide();
            },
            error: function (jqXHR, exception) {
                $(".loader").hide();
                show_ajax_error_message(jqXHR, exception);
            }
        });
    }

    function update_exam_paper(){
        $(".loader").show();
        $.ajax({
            url: "<?php echo base_url('backoffice/exam/get_exam_paper_model'); ?>",
            type: "post",
            data: {'exammodel':$('#exammodel').val(),'ci_csrf_token':csrfHash},
            success: function (data) {
                var obj = JSON.parse(data);
                $('#exampapers').html(obj.html);
                $(".loader").hide();
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'error',title:'Error',message:'Technical error please try again later'});
            }
        });
    }

    function get_exam_duration(){
        $(".loader").show();
        $.ajax({
            url: "<?php echo base_url('backoffice/exam/get_exam_details'); ?>",
            type: "post",
            data: {'exammodel':$('#exammodel').val(),'ci_csrf_token':csrfHash},
            success: function (response) {
                var obj = JSON.parse(response);
                exam_duration_in_min = obj.data.duration_in_min;
                $("#exam_duration").html('Exam model duration - '+obj.data.duration_in_min+' Minutes');
                $(".loader").hide();
            },
            error: function (jqXHR, exception) {
                $(".loader").hide();
                show_ajax_error_message(jqXHR, exception);
            }
        });
    }

    function update_room(id=''){
        $(".loader").show();
        $.ajax({
            url: "<?php echo base_url('backoffice/exam/get_exam_rooms_center'); ?>",
            type: "post",
            data: {'center':$('#center').val(),'ci_csrf_token':csrfHash},
            success: function (data) {
                var obj = JSON.parse(data);
                $('#examroom').html(obj.html);
                if(id!=''){
                    $("#examroom").val(id).prop('selected','selected');
                }
                $(".loader").hide();
            },
            error: function (jqXHR, exception) {
                $(".loader").hide();
                show_ajax_error_message(jqXHR, exception);
            }
        });
    }

</script>
