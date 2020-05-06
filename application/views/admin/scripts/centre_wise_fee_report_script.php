<script>
    $("#start_date").on("dp.change", function (e) {
        $('#end_date').data("DateTimePicker").minDate(e.date);
    });
    $("#end_date").on("dp.change", function (e) {
        $('#start_date').data("DateTimePicker").maxDate(e.date);  
    });

    $(".batchwisetab").on("click", function (e) {
        $("#courseorbatch").val('1');
        $('.batchwise').show();
        $('.exportbtn').hide();
        $('#cource_wise_data').html("<div><span>Click search for the Results </span></div>");
    });

    $(".courcewisetab").on("click", function (e) {
        $("#courseorbatch").val('0');
        $('.batchwise').hide()
        $('.exportbtn').hide();
        $('#batch_wise_data').html("<div><span>Click search for the Results </span></div>");
    });

    $("#filter_centre").change(function(){
        centreId=$(this).val();
        if (centreId != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Report/get_cource',
                type: 'POST',
                data: {
                    centreId: centreId,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    $(".loader").hide();
                    $("#filter_course").html(response);
                }
            });
        }
    });

    $("#filter_course").change(function(){
        courseId=$(this).val();
        if (centreId != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Report/get_batch',
                type: 'POST',
                data: {
                    courseId: courseId,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    $(".loader").hide();
                    $("#filter_batch").html(response);
                }
            });
        }
    });
    
    var search_validation = 0;
    $("form#search_form").validate({
        rules: {
            centre_id: {required: true}
        },
        messages: {
            centre_id: {required: "Please select a center"}
        },
        submitHandler: function(form) {
            $('#white_card_tbl').show();
            search_validation = 1;
        }
    });
    
    $("#search_form").submit(function(e){
        e.preventDefault();
        var courseorbatch1 = $("#courseorbatch").val();
        var filter_course= $("#filter_course").val();
        if(search_validation == 1){
            if(courseorbatch1 != 0 && filter_course == ''){
                $.toaster({ priority : 'danger', title : 'Invalid', message : 'Please select a course' });
                return false;
            }
        $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Report/search_centre',
                type: "post",
                data: $("#search_form").serialize(),
                success: function(data) {
                    search_validation = 0;
                    var filter_centre= $("#filter_centre").val();
                    var filter_course= $("#filter_course").val();
                    var filter_batch= $("#filter_batch").val();
                    var courseorbatch= $("#courseorbatch").val();
                    if(filter_centre !="") {
                       $("#export_centre").val(filter_centre); 
                    } else {
                        $("#export_centre").val("");
                    } 
                    if(filter_course !="") {
                       $("#export_course").val(filter_course); 
                    } else {
                        $("#export_course").val("");
                    }
                    if(courseorbatch == 1){
                        if(filter_batch !="") {
                            $("#export_batch").val(filter_batch); 
                        } else {
                            $("#export_batch").val("");
                        }
                    }
                    if(courseorbatch !="") {
                       $("#export_courseorbatch").val(courseorbatch); 
                    } else {
                        $("#export_courseorbatch").val("");
                    }
                    if(courseorbatch == 0){
                        $("#cource_wise_data").html(data);
                    }else{
                        $("#batch_wise_data").html(data);
                    }
                    $('.exportbtn').show();
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