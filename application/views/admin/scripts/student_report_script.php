<script>
    $("#start_date").on("dp.change", function (e) {
            $('#end_date').data("DateTimePicker").minDate(e.date);
        });
        $("#end_date").on("dp.change", function (e) {
            $('#start_date').data("DateTimePicker").maxDate(e.date);
             
            
        });
    
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
                    /*var batch_id=$("#filter_batch").val();
                    if(batch_id !="")
                       {
                         search();
                       }*/
                }
            });
        }
});
    
    
    
    $("#search_form").submit(function(e){
           e.preventDefault();
       // $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Report/search_student',
                type: "post",
                data: $("#search_form").serialize(),
                success: function(data) {
                   var school_id= $("#filter_school").val();
                   var centre_id= $("#filter_centre").val();
                   var course_id= $("#filter_course").val();
                   var batch_id= $("#filter_batch").val();
                   var status= $("#filter_status").val();
                   var start_date= $("#start_date").val();
                   var end_date= $("#end_date").val();
                    if(school_id !="")
                        {
                           $("#export_school").val(school_id); 
                        }
                    else{
                        $("#export_school").val("");
                    }
                    if(centre_id !="")
                        {
                           $("#export_centre_id").val(centre_id); 
                        }
                    else{
                        $("#export_centre_id").val("");
                    }
                    if(course_id !="")
                        {
                           $("#export_course_id").val(course_id); 
                        }
                    else{
                        $("#export_course_id").val("");
                    }
                    if(batch_id !="")
                        {
                           $("#export_batch_id").val(batch_id); 
                        }
                    else{
                        $("#export_batch_id").val("");
                    }
                    if(status !="")
                        {
                           $("#export_status").val(status); 
                        }
                    else{
                        $("#export_status").val("");
                    }
                    if(start_date !="")
                        {
                           $("#export_start_date").val(start_date); 
                        }
                    else{
                        $("#export_start_date").val("");
                    }
                    if(end_date !="")
                        {
                           $("#export_end_date").val(end_date); 
                        }
                    else{
                        $("#export_end_date").val("");
                    }
                                        $('#studentlist_table1').DataTable().destroy();
                                        $("#studentlist_table1").html(data);

                                        $("#studentlist_table1").DataTable({
                                            "searching": false,
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [7]
                                                }
                                            ]
                                        });
                     $(".loader").hide();
                }
               
            });
    });


//pagination
$(document).ready(function() {
    $('#studentlist_table1').DataTable( {
        "pageLength" : 10,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "language": {
        "infoEmpty": "No records available.",
    },
       // "order": [], //Initial no order.
        "searchable" :true,
        //  "order": [
        //   [1, "desc" ]
        // ],
        searching: false,
       
        // Load data for the table's content from an Ajax source
            "ajax": {
            "url": "<?php echo base_url();?>backoffice/Report/student_report_pagination",
            "type": "POST",
            data: {
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                  },
           },
         //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
    });
    if($('.alertemp').length !=0){
        setTimeout(function(){
            $('.alertemp').remove();
        }, 5000);
    }
});
function export_data(type){
    $('#type').val(type);
    form = $('#filter_form');
    form.submit();
}
</script>