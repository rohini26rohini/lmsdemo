<script>

 $(document).ready(function(){
   
               $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Staff/load_attendance',
                    type: 'POST',
                    data: {
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                         $(".loader").hide();
                         $('#loadattendancesheet').html(response);
                    }
                });
	 $(".loader").hide();
     
 });

    $("#date").blur(function(){
        var date=$("#date").val();
        $(".loader").show();
        $.ajax({
                    url: '<?php echo base_url();?>backoffice/Staff/load_attendance_by_date',
                    type: 'POST',
                    data: {date:date,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                         $(".loader").hide();
                         $('#loadattendancesheet').html(response);
                    }
                });
        
    });


</script>