<script>

//add floor
    $("form#add_floor_form").validate({
        rules: {
           building_id: {
                required: true
            },
            floor: {
                required: true
            }
        },
        messages: {
            building_id: "Please Choose a Building",
            floor: "Please Choose a Floor"
            },

        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Hostel/hostel_floor_add',
                type: 'POST',
                data: $("#add_floor_form").serialize(),
                success: function(response) {
                
                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                                 $('#myModal').modal('toggle');
                                 $( '#add_floor_form' ).each(function(){
                                        this.reset();
                                });
                          $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_floorList_ajax',
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
                    $(".loader").hide();
                }
                
            });
             

        }


    });

//delete

     function delete_floordata(id)
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
                                    url: '<?php echo base_url();?>backoffice/Hostel/delete_floordata',
                                    type: 'POST',
                                    data: {
                                        floor_id: id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.status == 1) {
                                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_floorList_ajax',
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
                                        else if(obj.status == 2)
                                        {
                                             $.toaster({priority:'warning',title:'Invalid Request',message:obj.message});
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
//status change
    function edit_floor_status(id,status)
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
                                    url: '<?php echo base_url();?>backoffice/Hostel/hostel_floor_status',
                                    type: 'POST',
                                    data: {
                                        floor_id: id,
                                        floor_status:status,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                    if (obj.st == 1) {
                                        
                                    $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_floorList_ajax',
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
                                        } 
                                        else if(obj.st == 2)
                                                {
                                                $.toaster({priority:'warning',title:'Invalid Request',message:'Please deactivate the rooms first!'});
                                                }
                                                else {

                                            $.toaster({priority:'warning',title:'Invalid',message:'Invalid Request!'});
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

    ///get floor data in edit form
    function get_floordata(id)
    {
         $(".loader").show();
             $.ajax({
                        url: '<?php echo base_url();?>backoffice/Hostel/get_hostel_floordata_byId',
                        type: 'POST',
                        data: {
                            floor_id : id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        },
                        success: function(response) {
                            $(".loader").hide();
                            var obj = JSON.parse(response);
                              //  alert(obj['data'].building_id);

                            $("#building").val(obj['data'].building_id);
                            $("#edit_floor_id").val(obj['data'].floor_id);
                            $("#floor").val(obj['data'].floor);
                            $('#editModal').modal({
                                    show: true
                                    });
                            }
                    });

    }

//edit floor data

    $("form#edit_floor_form").validate({
        rules: {
           building_id: {
                required: true
            },
            floor: {
                required: true
            }
        },
        messages: {
            building_id: "Please Choose a Building",
            floor: "Please Choose a Floor"
            },

        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Hostel/hostel_floor_edit',
                type: 'POST',
                data: $("#edit_floor_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);

                      if (obj.st == 1) {
                                 $('#editModal').modal('toggle');
                                 $( '#edit_floor_form' ).each(function(){
                                        this.reset();
                                });
                          
                          $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_floorList_ajax',
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
                    $(".loader").hide();
                }

            });


        }


    });


</script>
