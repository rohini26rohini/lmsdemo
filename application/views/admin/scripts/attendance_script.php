<script>
    $(document).ready(function(){
        load_schedule();
    });
    

function loadattendancesheet(batch_id, schedule_id, type) {
    var dateval = $('#date').val(); 
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Attendance/attendancesheet_load_view',
        type: 'POST',
        data: {
            batch_id: batch_id,
            schedule_id: schedule_id,
            dateval: dateval,
            type: type,
            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
        },
        success: function(response) {
             $('#loadattendancesheet').html(response);
             $(".loader").hide();

        }
    });
}    
    
    
   
     $(".loadschedulesbatch").change(function(){
        var batch_id=$(this).val();
        var dateval = $('#date').val(); 
        $(".loader").show();
        $('#loadattendancesheet').html('');
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Attendance/showing_schedules_view',
                type: 'POST',
                data: {batch_id:batch_id,
                       dateval:dateval,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    $("#schedulesloader").html(response);
                    $(".loader").hide();
                }
            });
          
    });
    
    
    $("#date").blur(function(){
        var batch_id=$('#batch').val(); 
        var dateval = $(this).val();
        $(".loader").show();
        $('#loadattendancesheet').html('');
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Attendance/showing_schedules_view',
                type: 'POST',
                data: {batch_id:batch_id,
                       dateval:dateval,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    $("#schedulesloader").html(response);
                    $(".loader").hide();
                }
            });
          
    });
    function load_schedule()
    {
        var batch_id=$('#batch').val(); 
        var dateval = $('#date').val();
        $(".loader").show();
        $('#loadattendancesheet').html('');
         $.ajax({
                url: '<?php echo base_url();?>backoffice/Attendance/showing_schedules_view',
                type: 'POST',
                data: {batch_id:batch_id,
                       dateval:dateval,
                      <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function(response)
                {
                    $("#schedulesloader").html(response);
                    $(".loader").hide();
                }
            }); 
    }
    
</script>
