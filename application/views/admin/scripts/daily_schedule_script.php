<script>
   

function change_status(id,status)
    {
       $(".loader").show();
            $.ajax({
                url: "<?php echo base_url('backoffice/Employee/schedule_status_change'); ?>",
                type: "POST",
                data: {
                       id:id,
                       status:status,
                       dateselected:$('#search_data').val(),
                       <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                        success: function (data)
                        {
                            var obj=JSON.parse(data);
                             if (obj.st == 1)
                            {  
                                var selected = $('#search_data').val();
                                $.ajax({
                                url: "<?php echo base_url('backoffice/Employee/search_schedule'); ?>",
                                type: "POST",
                                data: {
                                        date:selected,
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                                        success: function (data)
                                        {
                                            $(".loader").hide();
                                            $('#schedule_datatable').DataTable().destroy();
                                            $("#schedule_datatable").html(data);
                                            $("#schedule_datatable").DataTable({
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
                                                }
                                                ,{
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                }
                                                ,{
                                                    'bSortable': false,
                                                    'aTargets': [7]
                                                },{
                                                    'bSortable': false,
                                                    'aTargets': [8]
                                                }
                                            ]
                                        }); 
                        }
            });                                 $.toaster({priority:'success',title:'Success',message:obj.msg});
                            //   $.ajax({
                            //     url: '<?php echo base_url();?>backoffice/Employee/load_ajax_daily_schedule',
                            //     type: 'POST',
                            //     data: {
                            //         <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            //     },
                            //     success: function(response) { 
                                      
                            //             $('#schedule_datatable').DataTable().destroy();
                            //             $("#schedule_datatable").html(response);

                            //             $("#schedule_datatable").DataTable({
                            //                 "searching": false,
                            //                 "bPaginate": true,
                            //                 "bInfo": true,
                            //                 "pageLength": 10,
                            //         //        "order": [[4, 'asc']],
                            //                 "aoColumnDefs": [
                            //                     {
                            //                         'bSortable': false,
                            //                         'aTargets': [0]
                            //                     },
                            //                     {
                            //                         'bSortable': false,
                            //                         'aTargets': [1]
                            //                     },
                            //                     {
                            //                         'bSortable': false,
                            //                         'aTargets': [2]
                            //                     },
                            //                     {
                            //                         'bSortable': false,
                            //                         'aTargets': [3]
                            //                     },
                            //                     {
                            //                         'bSortable': false,
                            //                         'aTargets': [4]
                            //                     }
                            //                     ,{
                            //                         'bSortable': false,
                            //                         'aTargets': [5]
                            //                     },
                            //                     {
                            //                         'bSortable': false,
                            //                         'aTargets': [6]
                            //                     }
                            //                     ,{
                            //                         'bSortable': false,
                            //                         'aTargets': [7]
                            //                     },{
                            //                         'bSortable': false,
                            //                         'aTargets': [8]
                            //                     }
                            //                 ]
                            //             }); 
                            //     }
                            // });
                            }
                            else{
                                 $.toaster({priority:'warning',title:'Warning',message:obj.msg});
                            }
                            
                            $(".loader").hide();
                        }
            });  
    }

    $('#search_data').on('dp.change', function(e){ 
        var selected = $(this).val();
        $(".loader").show();
        $.ajax({
                url: "<?php echo base_url('backoffice/Employee/search_schedule'); ?>",
                type: "POST",
                data: {
                        date:selected,
                       <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                        success: function (data)
                        {
                            $(".loader").hide();
                            $('#schedule_datatable').DataTable().destroy();
                            $("#schedule_datatable").html(data);
                            $("#schedule_datatable").DataTable({
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
                                                }
                                                ,{
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [6]
                                                }
                                                ,{
                                                    'bSortable': false,
                                                    'aTargets': [7]
                                                },{
                                                    'bSortable': false,
                                                    'aTargets': [8]
                                                }
                                            ]
                                        }); 
                        }
            });
                        
    });


</script>