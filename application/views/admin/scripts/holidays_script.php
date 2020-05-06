<script>

  $("form#add_holiday_form").validate({
        rules: {
           date: {
                required: true
            },
            description: {
                required: true
            }
        },
        messages: {
            date: "Please Choose a Date",
            description: "Please Enter the  Reason"
            },

        submitHandler: function(form) {
            // $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Holidays/add_holiday',
                type: 'POST',
                data: $("#add_holiday_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                                 $('#myModal').modal('toggle');
                                 $( '#add_holiday_form' ).each(function(){
                                        this.reset();
                                });
                                    $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Holidays/load_holidayList_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(data);

                                        $("#institute_data").DataTable({
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
                                                }
                                                
                                            ]
                                        });
                                    }
                                   });
                          
                        $.toaster({priority:'success',title:'Success',message:obj.message});

                      }
                    else if (obj.st == 0){
                         $.toaster({priority:'danger',title:'INVALID',message:obj.message});
                    }
                    else if (obj.st == 2){
                         $.toaster({priority:'warning',title:'INVALID',message:obj.message});
                    }
                   // $(".loader").hide();
                }

            });


        }


    });

     ///get holidays data in edit form
    function get_holidaydata(id)
    {
         $(".loader").show();
             $.ajax({
                        url: '<?php echo base_url();?>backoffice/Holidays/get_holidaydata_byId',
                        type: 'POST',
                        data: {
                            id : id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        },
                        success: function(response) {
                            $(".loader").hide();
                            var obj = JSON.parse(response);
                              //  alert(obj['data'].building_id);

                            $("#date").val(obj['data'].date);
                            $("#id").val(obj['data'].id);
                            $("#description").val(obj['data'].description);
                            $('#editModal').modal({
                                    show: true
                                    });
                            }
                    });

    }

    //edit holiday
    $("form#edit_holiday_form").validate({
        rules: {
           date: {
                required: true
            },
            description: {
                required: true
            }
        },
        messages: {
            date: "Please Choose a Date",
            description: "Please Enter the  Reason"
            },

        submitHandler: function(form) {
            // $(".loader").show();
            $.ajax({
                 url: '<?php echo base_url();?>backoffice/Holidays/edit_holiday',
                type: 'POST',
                data: $("#edit_holiday_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                                 $('#editModal').modal('toggle');
                                 $( '#edit_holiday_form' ).each(function(){
                                        this.reset();
                                });
                          $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Holidays/load_holidayList_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(data);

                                        $("#institute_data").DataTable({
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
                                                }
                                                
                                            ]
                                        });
                                    }
                                   });
                        $.toaster({priority:'success',title:'Success',message:obj.message});

                      }
                    else if (obj.st == 0){
                         $.toaster({priority:'danger',title:'INVALID',message:obj.message});
                    }
                    else if (obj.st == 2){
                         $.toaster({priority:'warning',title:'INVALID',message:obj.message});
                    }
                   // $(".loader").hide();
                }

            });


        }


    });

//delete  holidays
    function delete_holidaydata(id)
    {
         $.confirm({
            title: 'Alert message',
            content: 'Do you want to remove this information?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {
                        if(id !=""){
                            $(".loader").show();
                                $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Holidays/delete_holidaydata',
                                    type: 'POST',
                                    data: {
                                        id: id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.status == 1) {
                                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Holidays/load_holidayList_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#institute_data').DataTable().destroy();
                                        $("#institute_data").html(data);

                                        $("#institute_data").DataTable({
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
                                                }
                                                
                                            ]
                                        });
                                    }
                                   });
                                             $.toaster({priority:'success',title:'Success',message:obj.message});
                                           
                                           
                                        } else {
                                            $.toaster({priority:'warning',title:'Invalid',message:obj.message});
                                        }
                                        $(".loader").hide();
                                    }
                                });
                        }

                    }
                },
                cancel: function() {
                    //$.alert(' <strong>cancelled</strong>');
                },
            }
        });
    }

</script>
