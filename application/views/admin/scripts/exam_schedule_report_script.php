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
            batch_id: {required: true}
        },
        messages: {
            batch_id: {required: "Please select a batch"}
        },
        submitHandler: function(form) {
            search_validation = 1;
        }
    });
    
    $("#search_form").submit(function(e){
        e.preventDefault();
        if(search_validation == 1){
        $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Report/search_exam',
                type: "post",
                data: $("#search_form").serialize(),
                success: function(data) {
                    var batch_id= $("#filter_batch1").val();
                    var status= $("#filter_status").val();
                    var start_date= $("#start_date").val();
                    var end_date= $("#end_date").val();
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
                            }
                        ]
                    });
                    $(".loader").hide();
                }
            });
        }  
    });


//pagination
$(document).ready(function() {
    $(".loader").hide();
    $('#studentlist_table1').DataTable();
    if($('.alertemp').length !=0){
        setTimeout(function(){
            $('.alertemp').remove();
        }, 5000);
    }
});
function export_data(type){
    // $(".loader").show();
    $('#type1').val(type);
    form = $('#filter_form');
    form.submit();
}
</script>