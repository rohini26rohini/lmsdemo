<script>

//adding maintenance type
 $("form#add_form").validate({
        rules: {
            type: {
                required: true
            },
            allowed_amount: {
                required: true
            }
        },
        messages: {
            type: "Please enter the maintenance service type",
            allowed_amount: "Please enter the Amount"
        },

        submitHandler: function(form) {
            // $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Asset/add_maintenance_type',
                type: 'POST',
                data: $("#add_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);
                      if (obj.st == 1) {
                                 $('#myModal').modal('toggle');
                                 $( '#add_form').each(function(){
                                        this.reset();
                                });
                          $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Asset/maintenanace_type_byAjax',
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
                    $(".loader").hide();
                }

            });


        }


    });

//get data by id
    function get_typedata(id)
    {

      $(".loader").show();
             $.ajax({

                        url: '<?php echo base_url();?>backoffice/Asset/get_maintenancetype_byId',
                        type: 'POST',
                        data: {
                            id : id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        },
                        success: function(response) {
                            $(".loader").hide();
                            var obj = JSON.parse(response);
                            $("#edit_id").val(obj['data'].id);
                            $("#edit_title").val(obj['data'].type);
                            $("#edit_amount").val(obj['data'].allowed_amount);

                            $('#editModal').modal({
                                    show: true
                                    });
                            }
                    });
    }

    //adding maintenance type
 $("form#edit_form").validate({
        rules: {
            type: {
                required: true
            },
            allowed_amount: {
                required: true
            }
        },
        messages: {
            type: "Please the maintenance service type",
            allowed_amount: "Please enter the Amount"
        },

        submitHandler: function(form) {
            // $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Asset/edit_maintenance_type',
                type: 'POST',
                data: $("#edit_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);
                      if (obj.st == 1) {
                                 $('#editModal').modal('toggle');
                                 $( '#edit_form').each(function(){
                                        this.reset();
                                });
                        $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Asset/maintenanace_type_byAjax',
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
                    $(".loader").hide();
                }

            });


        }


    });
    //delete room
    function delete_typedata(id)
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
                                    url: '<?php echo base_url();?>backoffice/Asset/delete_maintenanace_type',
                                    type: 'POST',
                                    data: {
                                        id: id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.status == 1) {

                                             $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Asset/maintenanace_type_byAjax',
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
                                    }
                                   });
                                            $.toaster({priority:'success',title:'Success',message:obj.message});
                                        }
                                         else {

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
