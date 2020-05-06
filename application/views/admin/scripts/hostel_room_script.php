<script>
//load floor under building
 $("#building_id").change(function(){
        var building = $('#building_id').val();
        if(building !=""){
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Hostel/get_floors_by_buildingId',
                    type: 'POST',
                    data: {
                        building_id: building,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                    // alert(response);
                        $("#floor_id").html(response);

                    }
                });
                $(".loader").hide();
        }
    });
  //adding room
 $("form#add_room_form").validate({
        rules: {
            building_id: {
                required: true
            },
            floor_id: {
                required: true
            },
            roomtype_id: {
                required: true
            },
             room_number: {
                required: true
            },
            room_capacity: {
                required: true
            },
        },
        messages: {
            building_id: "Please Choose a Building",
            floor_id: "Please Choose a Floor",
            roomtype_id: "Please Choose a Room Type",
            room_number: "Please Enter Room Number",
            room_capacity: "Please Enter Room Capacity"
           
        },

        submitHandler: function(form) {
            // $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Hostel/hostel_rooms_add',
                type: 'POST',
                data: $("#add_room_form").serialize(),
                success: function(response) {
                
                    var obj=JSON.parse(response);
                      if (obj.st == 1) {
                                 $('#myModal').modal('toggle');
                                 $( '#add_room_form' ).each(function(){
                                        this.reset();
                                });
                          $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_roomList_ajax',
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
    
   // get room data
    function get_roomdata(id)
    {
        $(".loader").show();
             $.ajax({
                        url: '<?php echo base_url();?>backoffice/Hostel/get_hostel_roomdata_byId',
                        type: 'POST',
                        data: {
                            room_id : id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        },
                        success: function(response) {
                            $(".loader").hide();
                            var obj = JSON.parse(response);
                              //  alert(obj['data'].building_id);
							$("#edit_building_id").val(obj['data'].building_id);
                            $("#edit_roomtype").val(obj['data'].building_id);
                            $("#room_id").val(obj['data'].room_id);
                            $("#edit_floor_id").html(obj['floors']);
                            $("#edit_floor_id").val(obj['data'].floor_id);
                            $("#edit_roomtype_id").val(obj['data'].roomtype_id);
                            $("#roomtype").val(obj['data'].room_type);
                            $("#edit_roomno").val(obj['data'].room_number);
                            $("#edit_room_capcity").val(obj['data'].room_capacity);
                            $('#editModal').modal({
                                    show: true
                                    });
                            }
                    });
    }

    //edit room
 $("form#edit_room_form").validate({
        rules: {
            building_id: {
                required: true
            },
            floor_id: {
                required: true
            },
            roomtype_id: {
                required: true
            },
             room_number: {
                required: true
            },
            room_capacity: {
                required: true
            },
        },
        messages: {
            building_id: "Please Choose a Building",
            floor_id: "Please Choose a Floor",
            roomtype_id: "Please Choose a Room Type",
            room_number: "Please Enter Room Number",
            room_capacity: "Please Enter Room Capacity"

        },

        submitHandler: function(form) {
            // $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Hostel/hostel_rooms_edit',
                type: 'POST',
                data: $("#edit_room_form").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);
                      if (obj.st == 1) {
                                 $('#editModal').modal('toggle');
                                 $( '#edit_room_form' ).each(function(){
                                        this.reset();
                                });
                          $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_roomList_ajax',
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
    function delete_roomdata(id)
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
                                    url: '<?php echo base_url();?>backoffice/Hostel/delete_roomdata',
                                    type: 'POST',
                                    data: {
                                        room_id: id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.status == 1) {
                                            
                                             $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_roomList_ajax',
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
    
    
    
    //change status
    function edit_room_status(id,status)
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
                                    url: '<?php echo base_url();?>backoffice/Hostel/hostel_room_status',
                                    type: 'POST',
                                    data: {
                                        room_id: id,
                                        room_status:status,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.st == 1) {
                                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_roomList_ajax',
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
                                           $.toaster({priority:'warning',title:'Invalid Request',message:'This room is occupied!'}); 
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
</script>
