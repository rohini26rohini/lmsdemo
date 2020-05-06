<script>
    $("#edit_type").change(function(){
        var type = $('#edit_type').val();
        if (type != "1" && type != "") {
            $("#edit_div").css("display","block");
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_allparent_institutes',
                type: 'POST',
                data: {
                    institute_type_id: type,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#edit_div").html(response);
                    $(".loader").hide();
                }
            });
            
        }
        else{
            $("#edit_div").css("display","none");
        }
    });
    
    
    //add institite** show parent institute
    $('#type').change(function() {
        var type = $('#type').val();
        if (type != "1" && type != "") {
            $("#parent_div").css("display","block");
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/get_allparent_institutes',
                type: 'POST',
                data: {
                    institute_type_id: type,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                  //  alert(response);
                    $("#parent_div").html(response);
                    $(".loader").hide();
                }
            });
            
        }
        else{
            $("#parent_div").css("display","none");
        }
    });

//add institute
    var validation=0; 
    $("form#add_institute_form").validate({
        rules: {
            institute_name: {
                required: true
            },
            institute_type_id: {
                required: true

            },
              parent_institute: {
                  required: true

              }
        },
        messages: {
            institute_name: "Please Enter Institute Name",
            institute_type_id: "Please Choose Institute Type",
             parent_institute: "Please Choose Parent institute"
        },

        submitHandler: function(form) {
            
            var type=$("#type").val();
            var parent_institute = $('#parent_institute').val();
           if(type != "1" && parent_institute =="")
               {
                  validation=1; 
                   $("#msg").html("please Choose the parent institute");
               }
            else{
               validation=0; 
                $("#msg").html("");
            }
            if(validation == 0){
                 $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/institute_add',
                type: 'POST',
                data: $("#add_institute_form").serialize(),
                success: function(response) {
                    if (response != 2 && response != 0) {
                    $.toaster({priority:'success',title:'Success',message:'Institute Added Succesfully '});
                    $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Courses/load_institute_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {
                                        $('#myModal').modal('toggle');    
                                        $('#institute_table').DataTable().destroy();
                                        $("#institute_table").html(response);

                                        $("#institute_table").DataTable({
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
                                        $(".loader").hide();
                                    } 
                                });
                    }
                    else if(response == 2)
                    {
                        $.toaster({priority:'danger',title:'INVALID',message:'Data Already Exist'});
                    }
                    $(".loader").hide();
                }
                
            });
        }
             

        }


    });
    $("form#edit_institute_form").validate({
        rules: {
            institute_name: {
                required: true
            },
            institute_type_id: {
                required: true

            },
              parent_institute: {
                  required: true

              }
        },
        messages: {
            institute_name: "Please Enter Institute Name",
            institute_type_id: "Please Choose Institute Type",
            parent_institute: "Please Choose Parent institute"
        },
        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Courses/institute_edit',
                type: 'POST',
                data: $("#edit_institute_form").serialize(),
                success: function(response) {
                    if (response ==1) {
                         $.toaster({priority:'success',title:'Success',message:'Succesfully Updated'});
                        $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Courses/load_institute_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {
                                        $('#edit_institute').modal('toggle');    
                                        $('#institute_table').DataTable().destroy();
                                        $("#institute_table").html(response);

                                        $("#institute_table").DataTable({
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
                                        $(".loader").hide();
                                    } 
                                });
                        }
                    else{
                          $.toaster({priority:'danger',title:'INVALID',message:'Already Exist'});
                    }
                    $(".loader").hide();
                }
                
            });
             

        }


    });

    function delete_institute(id) {
        $.confirm({
            title: 'Alert message',
            content: 'Do you want to remove this Information?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.post('<?php echo base_url();?>backoffice/Courses/delete_institute/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            var obj = JSON.parse(data);
                            if (obj.status == 1) {
                                $.toaster({ priority : 'success', title : 'Success', message : obj.message });
                                  $("#row_"+id).remove();
                                $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Courses/load_institute_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {
                                           
                                        $('#institute_table').DataTable().destroy();
                                        $("#institute_table").html(response);

                                        $("#institute_table").DataTable({
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
                                        $(".loader").hide();
                                    } 
                                });
                              
                            } else {
                               $.toaster({priority:'danger',title:'INVALID',message:obj.message}); 
                            }
                        });

                        /*$.alert('Successfully <strong>Deleted..!</strong>');*/
                    }
                },
                cancel: function() {
                    //$.alert(' <strong>cancelled</strong>');
                },
            }
        });
    }

    function get_institutedata(id) {
         $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Courses/get_institutedetails_by_id/' + id,
            type: 'POST',
            data: {
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
            },
            success: function(response) {
                
                var obj = JSON.parse(response);
               //alert(obj['parent_institutes']);
                $("#edit_instituteid").val(obj.institute_master_id);
                $("#edit_institutename").val(obj.institute_name);
                $("#edit_type").val(obj.institute_type_id);
                $('#edit_institute').modal({
                        show: true
                        });
                
                if(obj.institute_type_id == 1)
                    {
                        $("#edit_div").css("display","none");
                    }
                else{
                     $("#edit_div").css("display","block");
                     $("#edit_div").html(obj['parent_institutes']);
                     $("#edit_parent_institute").val(obj.parent_institute);
                   
                }
                $(".loader").hide();

            }
        });
        
    }
    
$(document).ready(function() {
    $('#institute_table').DataTable( {
        "pageLength" : 10,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "language": {
        //"infoEmpty": "No records available.",
    },
       // "order": [], //Initial no order.
         //"bSort": false,
        "searchable" :true,
         "order": [
          [0, "asc" ]
        ],
 
        // Load data for the table's content from an Ajax source
            "ajax": {
            "url": "<?php echo base_url();?>backoffice/Courses/institute_details_ajax",
            "type": "POST",
            data: {
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                  },
           },
         //Set column definition initialisation properties.
        aoColumnDefs: [
            { "aTargets": [ 4 ], "bSortable": false },
        ]
    } );
} );

</script>
