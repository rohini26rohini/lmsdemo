<script>

    function getapprovaldetails(student_id, course_id) {
         $(".loader").show();
        if(student_id && course_id) {
        $.ajax({
                url: '<?php echo base_url();?>backoffice/Approval/approval_detail_view',
                type: 'POST',
                data: {
                    student_id: student_id,course_id: course_id,
                    <?php echo $this->security->get_csrf_token_name();?>: 
                    '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  
                    $("#loaddata").html(response);
                    $(".loader").hide();
                }
            });
        } else {
            $.toaster({priority:'danger',title:'INVALID',message:"Invalid data."});
           $(".loader").hide(); 
        }
        
    }
    
   

</script>
