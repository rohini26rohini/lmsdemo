<script>
    $("#start_date").on("dp.change", function (e) {
        $('#end_date').data("DateTimePicker").minDate(e.date);
    });
    $("#end_date").on("dp.change", function (e) {
        $('#start_date').data("DateTimePicker").maxDate(e.date);  
    });

    $("#filter_batch").change(function(){
        batch_id=$(this).val();
        if (batch_id != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Report/get_subject',
                type: 'POST',
                data: {
                    batch_id: batch_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    $(".loader").hide();
                    $("#filter_subject").html(response);
                }
            });
        }
    });
    
    var search_validation = 0;
    $("form#search_form").validate({
        rules: {
            faculty_id: {required: true}
        },
        messages: {
            faculty_id: {required: "Please select a faculty"}
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
                url: '<?php echo base_url();?>backoffice/Report/search_leave',
                type: "post",
                data: $("#search_form").serialize(),
                success: function(data) {
                    var faculty_id= $("#filter_faculty").val();
                    var batch_id= $("#filter_batch").val();
                    var status= $("#filter_status").val();
                    var start_date= $("#start_date").val();
                    var end_date= $("#end_date").val();
                    var filter_subject= $("#filter_subject").val();
                    if(batch_id !="") {
                       $("#export_batch_id").val(batch_id); 
                    } else {
                        $("#export_batch_id").val("");
                    } 
                    if(status !="") {
                       $("#export_status").val(status); 
                    } else {
                        $("#export_status").val("");
                    }
                    if(start_date !="") {
                       $("#export_start_date").val(start_date); 
                    } else {
                        $("#export_start_date").val("");
                    }
                    if(end_date !="") {
                       $("#export_end_date").val(end_date); 
                    } else {
                        $("#export_end_date").val("");
                    }
                    if(faculty_id !="") {
                       $("#export_faculty_id").val(faculty_id); 
                    } else {
                        $("#export_faculty_id").val("");
                    }
                    $("#studentlist_table1").html(data);
                    $(".loader").hide();
                }
            });
        }  
    });


//pagination
$(document).ready(function() {
    $(".loader").hide();
    // $('#white_card_tbl').css('visibility','hidden');
    // $('#studentlist_table1').DataTable();
});
function export_data(type){
    $('#type').val(type);
    form = $('#filter_form');
    form.submit();
}
</script>