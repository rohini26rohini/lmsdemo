<script>
    
    
function get_course(){
   var school_id=$("#filter_school").val();
   var centre_id=$("#filter_centre").val();
     if (school_id != "" && centre_id != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_course_bySchool',
                type: 'POST',
                data: {
                    school: school_id,
                    centre_id: centre_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    $(".loader").hide();
                    $("#filter_course").html(response);
                   var  course_id=$("#filter_course").val();
                   if (course_id != "") 
                   {
                        $(".loader").show();
                        $.ajax({
                            url: '<?php echo base_url();?>backoffice/Students/get_batch_byCourse',
                            type: 'POST',
                            data: {
                                course_id: course_id,
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            },
                            success: function(response) {
                                $(".loader").hide();
                                $("#filter_batch").html(response);
                                var batch_id=$("#filter_batch").val();
                                if(batch_id !=""){
                                    search();
                                }
                            }
                        });
                    } 
                    else{
                        $("#filter_batch").html('<option value="">Select</option>');
                    }
                }
            });
        }
    else{
        $("#filter_course").html('<option value="">Select</option>');
    }
}
    $("#filter_course").change(function(){
      course_id=$(this).val();
     if (course_id != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_batch_byCourse',
                type: 'POST',
                data: {
                    course_id: course_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    $(".loader").hide();
                    $("#filter_batch").html(response);
                    var batch_id=$("#filter_batch").val();
                    if(batch_id !="")
                       {
                         search();
                       }
                }
            });
        }
});
    
    $("#filter_batch").change(function(){
      batch_id=$(this).val();
     if (batch_id != "") {
            $(".loader").show();
            search();
        }
});    

 //searching
   function search(){
            $('#loadreportview').show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/search_student_progresslist',
                type: "post",
                data: $("#search_form").serialize(),
                success: function(data) {
                                        $('#studentlist_table').DataTable().destroy();
                                        //$('#batch_examlist_table').DataTable().destroy();
                                        var obj = JSON.parse(data);
                                        $("#studentlist_table").html(obj.students);
                                        $("#batch_examlist_table").html(obj.exams);
                                        $("#studentlist_table").DataTable({
                                            "searching": true,
                                            "bPaginate": true,
                                            "bInfo": true,
                                            "pageLength": 10,
                                    //        "order": [[4, 'asc']],
                                            "aoColumnDefs": [
                                                {
                                                    'bSortable': true,
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
                                                },
                                                {
                                                    'bSortable': true,
                                                    'aTargets': [4]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                },
                                                
                                            ]
                                        });
                     $(".loader").hide();
                }
               
            });
    }

    


$(document).ready(function () {
		
     $("#chartBlockBtn").click(function () {
        $("#chartBlock").toggleClass("show");
        $(".close_btn").fadeIn("200");
    });
	$(".close_btn").click(function () {
        $(this).hide();
        $("#chartBlock").removeClass(("show"));
    });
    
});

    

$(document).on('click', '.batchaverage', function () { 
    var exam_id = $(this).attr("id");
    var attempt = $(this).attr("alt");
    $(".loader").show();
     if (exam_id != '' && attempt!='') {
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/get_batch_exam_details',
                type: 'POST',
                data: {
                    exam_id: exam_id,
                    attempt: attempt,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    $(".loader").hide();
                    $("#loadalldatas").html(response);
                   
                }
            });
        }
});
 
/*
*   function'll get progress report
*   @params student id
*   @author GBS-R
*/


$(document).on('click', '.studentindivigualprogress', function () {    
             $(".loader").show();
            var student_id = $(this).attr("id");
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/progress_report',
                type: 'POST',
                data: {
                    student_id:student_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#loadalldatas").html(response);
                    $(".loader").hide();
                }
            });
    });    
    
</script>
