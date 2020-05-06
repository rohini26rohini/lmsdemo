<script>
    $(document).ready(function(){
        $("form#add_leave_head_form").validate({
            rules: {
                head: {
                    required: true,
                     remote:{
                            url: '<?php echo base_url();?>backoffice/Leave/check_headName',
                            type: 'POST',
                            data: {
                                 head_name: function() {
                                  return $("#head").val();
                                  },
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                }
                            }
                }
            },
            messages: {
                head: {
                    required:"Please enter a leave head name",
                    remote:"This leave head already exist"
                }
            },
            submitHandler: function(form) {
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Leave/leave_head_add',
                    type: 'POST',
                    data: $("#add_leave_head_form").serialize(),
                    success: function(response) {
                        if (response != "2" && response != "0") {
                            $('#add_leave_head').modal('toggle');
                            $('#add_leave_head_form' ).each(function(){
                                this.reset();
                            });
                            $.toaster({ priority : 'success', title : 'Success', message : 'Leave Head Added Succesfully ' });
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Leave/load_leave_head_ajax',
                                type: 'POST',
                                    data: {
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {  
                                    $('#syllabus_data').DataTable().destroy();
                                    $("#syllabus_data").html(response);
                                    $("#syllabus_data").DataTable({
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
                                            }
                                        ]
                                    });    
                                    $(".loader").hide();
                                } 
                            }); 
                        }
                        else if(response == "2")
                        {
                            $.toaster({ priority : 'danger', title : 'Error', message : 'Leave Head Already Exist' });
                        
                        }
                        $(".loader").hide();
                    }
                });
            }
        });

        $("form#edit_leave_head_form").validate({
            rules: {
                head: {
                    required: true,
                     remote:{
                            url: '<?php echo base_url();?>backoffice/Leave/check_headName_edit',
                            type: 'POST',
                            data: {
                                 head: function() {
                                  return $("#edit_head").val();
                                  }, head_id: function() {
                                  return $("#edit_id").val();
                                  },
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                }
                            }
                }
            },
            messages: {
                head: {required:"Please enter a leave head name",
                       remote:"This leave head already exist"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Leave/leave_head_edit',
                    type: 'POST',
                    data: $("#edit_leave_head_form").serialize(),
                    success: function(response) {
                        if (response == 1) {
                            $('#edit_leave_head').modal('toggle');
                            $.toaster({ priority : 'success', title : 'Success', message : 'Leave Head Updated Successfully' });
                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Leave/load_leave_head_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {  
                                        $('#syllabus_data').DataTable().destroy();
                                        $("#syllabus_data").html(response);
                                        $("#syllabus_data").DataTable({
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
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                }); 
                        }
                        $(".loader").hide();
                    }
                });
            }
        });
    });

    function delete_leavehead(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Leave/leave_head_delete', 
                               {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                                if (data == 1) {
                                   // $.alert('Successfully <strong>Deleted..!</strong>');
                            $.toaster({ priority : 'success', title : 'Success', message : 'Successfully Deleted..!' });
                                    $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Leave/load_leave_head_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {  
                                        $('#syllabus_data').DataTable().destroy();
                                        $("#syllabus_data").html(response);
                                        $("#syllabus_data").DataTable({
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
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                }); 
                                }
                            else if(data ==2)
                                {
                                     $.toaster({ priority : 'warning', title : 'Invalid Request', message : 'Already some leaves are applied under this leave head' }); 
                                } else if(data ==3)
                                {
                                     $.toaster({ priority : 'warning', title : 'Invalid Request', message : 'This leave head is already added under some leave scheme' }); 
                                }
                            });
                    }
                },
                cancel: function() {
                },
            }
        });
    }

    function get_leavehead_data(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Leave/get_leave_head_by_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj = JSON.parse(response);
                $("#edit_type_id").val(obj.type_id);
                $("#edit_head").val(obj.head);
                $("#edit_id").val(obj.id);
                $("#status").val(obj.status);
                $("#edit_type_name").val(obj.type_name);
                $('#edit_leave_head').modal({
                    show: true
                });
                $(".loader").hide();
            }
        });
    }

    function edit_status(id,status){
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
                                    url: '<?php echo base_url();?>backoffice/Leave/leave_head_status',
                                    type: 'POST',
                                    data: {
                                        id: id,
                                        status:status,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                          if (response == 1) {
                                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Leave/load_leave_head_ajax',
                                    type: "post",
                                    data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                    success: function(data) {
                                        $('#syllabus_data').DataTable().destroy();
                                        $("#syllabus_data").html(data);
                                        $("#syllabus_data").DataTable({
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
                                                }
                                                
                                                
                                            ]
                                        });
                                    }
                                   });
                                            $.toaster({priority:'success',title:'Success',message:'Status Changed Successfully!'});
                                            //$("#row_"+id).remove();
                                        }
                                        // else if (obj.st == 2) {
                                        //    $.toaster({priority:'warning',title:'Invalid Request',message:'This room is occupied!'}); 
                                        // }else {
                                        //      $.toaster({priority:'warning',title:'Success',message:'Invalid Request!'});
                                        // }
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

//------------------------------------------Discount Packages--------------------------------------------//



</script>