<script>
//add froom type


    $("form#add_roomtype_form").validate({
        rules: {
           room_type: {
                required: true
            },
            facilities: {
                required: true
            }
        },
        messages: {
            room_type: "Please Enter Room Type",
            facilities: "Please Enter Facilites"
            },

        submitHandler: function(form) {
            // $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Hostel/hostel_roomtype_add',
                type: 'POST',
                data: $("#add_roomtype_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                                 $('#myModal').modal('toggle');
                                 $( '#add_roomtype_form' ).each(function(){
                                        this.reset();
                                });
                          $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_roomtypeList_ajax',
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [4]
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

//edit room type
     $("form#edit_roomtype_form").validate({
        rules: {
           room_type: {
                required: true
            },
            facilities: {
                required: true
            }
        },
        messages: {
            room_type: "Please Enter Room Type",
            facilities: "Please Enter Facilites"
            },

        submitHandler: function(form) {
            // $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Hostel/hostel_roomtype_edit',
                type: 'POST',
                data: $("#edit_roomtype_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                                 $('#editModal').modal('toggle');
                                 $( '#edit_roomtype_form' ).each(function(){
                                        this.reset();
                                });
                          $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_roomtypeList_ajax',
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [4]
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

//get room type details on edit form
    function get_roomtypedata(id)
    {
        $(".loader").show();
             $.ajax({
                        url: '<?php echo base_url();?>backoffice/Hostel/get_hostel_roomtypedata_byId',
                        type: 'POST',
                        data: {
                            roomtype_id : id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        },
                        success: function(response) {
                            $(".loader").hide();
                            var obj = JSON.parse(response);
                              //  alert(obj['data'].building_id);

                            $("#roomtype_id").val(obj['data'].roomtype_id);
                            $("#roomtype").val(obj['data'].room_type);
                            $("#facility").val(obj['data'].facilities);
                            $('#editModal').modal({
                                    show: true
                                    });
                            }
                    });
    }

    //change status
    function edit_roomtype_status(id,status)
    {
      $.confirm({
            title: 'Alert message',
            content: 'Are you sure you want to change status?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Ok',
                    btnClass: 'btn-blue',
                    action: function() {
                        if(id !=""){
                            $(".loader").show();
                                $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/hostel_roomtype_status',
                                    type: 'POST',
                                    data: {
                                        roomtype_id: id,
                                        roomtype_status:status,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.st == 1) {
                                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_roomtypeList_ajax',
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [4]
                                                }
                                                
                                                
                                            ]
                                        });
                                    }
                                   });
                                            $.toaster({priority:'success',title:'Success',message:'Status Changed Successfully!'});
                                            //$("#row_"+id).remove();
                                        }
                                        else if (obj.st == 2) {
                                             $.toaster({priority:'warning',title:'Invalid Request',message:'Please deactivate room details first!'});
                                        }else {
                                             $.toaster({priority:'warning',title:'Success',message:'Invalid Request!'});
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
    //delete roomtype
    function delete_roomtypedata(id)
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
                                    url: '<?php echo base_url();?>backoffice/Hostel/delete_roomtypedata',
                                    type: 'POST',
                                    data: {
                                        roomtype_id: id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.status == 1) {
                                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_roomtypeList_ajax',
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [4]
                                                }
                                                
                                                
                                            ]
                                        });
                                    }
                                   });
                                            $.toaster({priority:'success',title:'Success',message:obj.message});
                                            //$("#row_"+id).remove();
                                        }
                                        else if(obj.status == 2)
                                            {
                                                 $.toaster({priority:'warning',title:'Invalid Request',message:obj.message});
                                            }else {
                                           
                                             $.toaster({priority:'warning',title:'Success',message:obj.message});
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
