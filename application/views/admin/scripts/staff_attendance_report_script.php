<script>
    $("#start_date").on("dp.change", function(e) {
        $('#end_date').data("DateTimePicker").minDate(e.date);
    });
    $("#end_date").on("dp.change", function(e) {
        $('#start_date').data("DateTimePicker").maxDate(e.date);
    });

    $("form#search_form").validate({
        rules: {
            start_date: {
                required: true
            },
            end_date: {
                required: true

            }
        },
        messages: {
            start_date: "Please choose a start date",
            end_date: "Please choose a end date",
        },

        submitHandler: function(form) {

            $.ajax({
                url: '<?php echo base_url();?>backoffice/Report/load_staff_attendance',
                type: "post",
                data: $("#search_form").serialize(),
                beforeSend: function(data) {
                    $(".loader").show();
                },
                success: function(data) {
                    var sdate=$("#start_date").val();
                    var edate=$("#end_date").val();
                    $("#export_startdate").val(sdate);
                    $("#export_enddate").val(edate);
                    $(".white_card").css("display","block");
                    $("#staff_detail").html(data);
                    $("#export").css("display","block");
                    
                   /* $('#syllabus_data').DataTable().destroy();
                                        $("#syllabus_data").html(data);

                                        $("#syllabus_data").DataTable({
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
                                                }
                                                
                                            ]
                                        });
             */   },
                complete: function(data) {
                    $(".loader").hide();
                },
            });

        }


    });

</script>
