<script>
    // $("#start_date").on("dp.change", function (e) {
    //     $('#end_date').data("DateTimePicker").minDate(e.date);
    // });
    // $("#end_date").on("dp.change", function (e) {
    //     $('#start_date').data("DateTimePicker").maxDate(e.date);  
    // });

    $("#filter_batch").change(function(){
        batch_id=$(this).val();
        if (batch_id != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Report/get_exam',
                type: 'POST',
                data: {
                    batch_id: batch_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    $(".loader").hide();
                    $("#filter_exam").html(response);
                }
            });
        }
    });

    $("#filter_exam").change(function(){
        exam_id=$(this).val();
        if (batch_id != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Report/get_atmt',
                type: 'POST',
                data: {
                    exam_id: exam_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    $(".loader").hide();
                    $("#filter_attempt").html(response);
                }
            });
        }
    });

    // $("#filter_exam").change(function(){
    //     exam_id=$(this).val();
    //     if (batch_id != "") {
    //         $(".loader").show();
    //         $.ajax({
    //             url: '<?php echo base_url();?>backoffice/Report/get_section',
    //             type: 'POST',
    //             data: {
    //                 exam_id: exam_id,
    //                 <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
    //             },
    //             success: function(response) {
    //                 $(".loader").hide();
    //                 $("#filter_section").html(response);
    //             }
    //         });
    //     }
    // });
    
    var search_validation = 0;
    $("form#search_form").validate({
        rules: {
            batch_id: {required: true},
            filter_exam: {required: true}
            // filter_attempt: {required: true}
        },
        messages: {
            batch_id: {required: "Please select a batch"},
            filter_exam: {required: "Please select a Exam"}
            // filter_attempt: {required: "Please select an Attempt"}
        },
        submitHandler: function(form) {
            $('#white_card_tbl').show();
            search_validation = 1;
        }
    });
    
    $("#search_form").submit(function(e){
        e.preventDefault();
        if(search_validation == 1){
        $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Report/search_section_mark',
                type: "post",
                data: $("#search_form").serialize(),
                success: function(data) {
                    var export_exam = $("#filter_exam").val();
                    if(export_exam !="") {
                       $("#export_exam").val(export_exam); 
                    } else {
                        $("#export_exam").val("");
                    }
                    $('#studentlist_tablONE').html(data);
                    $(".loader").hide();
                }
            });
        }  
    });


//pagination
$(document).ready(function() {
    $(".loader").hide();
    // $('#white_card_tbl').css('visibility','hidden');
    $('#studentlist_table1').DataTable();
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