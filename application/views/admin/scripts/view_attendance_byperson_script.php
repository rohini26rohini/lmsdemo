<script>
    

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
                url: '<?php echo base_url();?>backoffice/Employee/search_self_attendance',
                type: "post",
                data: $("#search_form").serialize(),
                beforeSend: function(data) {
                    $(".loader").show();
                },
                success: function(data) {
                    $('#syllabus_data').DataTable().destroy();
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
                                                }
                                                
                                            ]
                                        });
              
                       },
                complete: function(data) {
                    $(".loader").hide();
                },
            });

        }


    });

</script>
