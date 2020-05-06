<script>
   
    
      $("#group_name").change(function(){
        var group = $('#group_name').val();
        if(group !=""){
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Hostel/get_allsub_byparent',
                    type: 'POST',
                    data: {
                        parent_institute: group,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                    // alert(response);
                        $("#branch_name").html(response);

                    }
                });
                $(".loader").hide();
        }
    });

    $("#branch_name").change(function(){
        var branch = $('#branch_name').val();

        if (branch != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_allsub_byparent',
                type: 'POST',
                data: {
                    parent_institute: branch,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#center_name").html(response);
                    $(".loader").hide();
                }
            });
        }
        else{
            $("#edit_div").css("display","none");
        }
    });
    //adding building
 $("form#add_building_form").validate({
        rules: {
            group_id: {
                required: true
            },
            branch_id: {
                required: true
            },
            centre_id: {
                required: true
            },
             building_name: {
                required: true
            },
        },
        messages: {
            group_id: "Please Choose a Group",
            branch_id: "Please Choose a Branch",
            centre_id: "Please Choose a Centre",
            building_name: "Please Enter Building Name"
           
        },

        submitHandler: function(form) {
            // $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Hostel/hostel_building_add',
                type: 'POST',
                data: $("#add_building_form").serialize(),
                success: function(response) {
                
                    var obj=JSON.parse(response);
                      if (obj.st == 1) {
                                 $('#myModal').modal('toggle');
                                 $( '#add_building_form' ).each(function(){
                                        this.reset();
                                });
                           $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_buildingList_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#hostel_building_table').DataTable().destroy();
                                        $("#hostel_building_table").html(data);

                                        $("#hostel_building_table").DataTable({
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
  /***********EDIT building**************/  
     $("#group_id").change(function(){
        var group = $('#group_id').val();
        if(group !=""){
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Hostel/get_allsub_byparent',
                    type: 'POST',
                    data: {
                        parent_institute: group,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    },
                    success: function(response) {
                    // alert(response);
                        $("#branch_id").html(response);

                    }
                });
                $(".loader").hide();
        }
    });

    $("#branch_id").change(function(){
        var branch = $('#branch_id').val();

        if (branch != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_allsub_byparent',
                type: 'POST',
                data: {
                    parent_institute: branch,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#centre_id").html(response);
                    $(".loader").hide();
                }
            });
        }
        
    });
    //get building data in edit form
    function get_buildingdata(id) {
                $(".loader").show();
             $.ajax({
                        url: '<?php echo base_url();?>backoffice/Hostel/get_hostel_buildingdata_byId',
                        type: 'POST',
                        data: {
                            building_id : id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        },
                        success: function(response) {
                            $(".loader").hide();
                            var obj = JSON.parse(response);

                            $("#building_id").val(obj.building_id);
                            $("#group_id").val(obj.group_id);
                            $("#branch_id").html(obj.branches);
                            $("#branch_id").val(obj.branch_id);
                            $("#centre_id").html(obj.centres);
                            $("#centre_id").val(obj.centre_id);
                            $("#building_name").val(obj.building_name);
                            $('#editModal').modal({
                                    show: true
                                    });
                            }
                    });
        
    }
    
    
    $("form#edit_building_form").validate({
        rules: {
            group_id: {
                required: true
            },
            branch_id: {
                required: true
            },
            centre_id: {
                required: true
            },
             building_name: {
                required: true
            },
        },
        messages: {
            group_id: "Please Choose a Group",
            branch_id: "Please Choose a Branch",
            centre_id: "Please Choose a Centre",
            building_name: "Please Enter Building Name"
           
        },

        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Hostel/hostel_building_edit',
                type: 'POST',
                data: $("#edit_building_form").serialize(),
                success: function(response) {
                
                    var obj=JSON.parse(response);
                      if (obj.st == 1) {
                                 $('#editModal').modal('toggle');
                                 $( '#edit_building_form' ).each(function(){
                                        this.reset();
                                });
                           $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_buildingList_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#hostel_building_table').DataTable().destroy();
                                        $("#hostel_building_table").html(data);

                                        $("#hostel_building_table").DataTable({
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
    
    
    //load data in datatable
     $(document).ready(function() {
    $('#hostel_building_table').DataTable( { 
        "pageLength" : 10,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
       // "order": [], //Initial no order.
         //"bSort": false,
        "searchable" :true,
         "order": [
          [1, "desc" ]
        ],
 
        // Load data for the table's content from an Ajax source
            "ajax": {
            "url": "<?php echo base_url();?>backoffice/Hostel/hostelBuilding_details_ajax",
            "type": "POST",
            data: {
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                  },
           },
         //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
    } );
});
    function delete_buildingdata(id){

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
                                    url: '<?php echo base_url();?>backoffice/Hostel/delete_buildingdata',
                                    type: 'POST',
                                    data: {
                                        id: id,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.status == 1) {
                                           
                                           // $("#row_"+id).remove();
                                             $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_buildingList_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#hostel_building_table').DataTable().destroy();
                                        $("#hostel_building_table").html(data);

                                        $("#hostel_building_table").DataTable({
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
        function edit_building_status(id,status)
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
                                    url: '<?php echo base_url();?>backoffice/Hostel/hostel_building_status',
                                    type: 'POST',
                                    data: {
                                        building_id: id,
                                        building_status:status,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                    var obj = JSON.parse(response);
                                        if (obj.st == 1) {
                                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Hostel/load_buildingList_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#hostel_building_table').DataTable().destroy();
                                        $("#hostel_building_table").html(data);

                                        $("#hostel_building_table").DataTable({
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
                                           
                                            $.toaster({priority:'success',title:'Success',message:'Status Changed Successfully!'});
                                            //$("#row_"+id).remove();
                                        }
                                        else if(obj.st == 2)
                                        {
                                          $.toaster({priority:'warning',title:'Invalid Request',message:'Please Deactivate the floor details first!'});  
                                        }
                                        else {
                                           
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
