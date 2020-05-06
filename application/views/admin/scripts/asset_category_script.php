<script>
    $(document).ready(function(){
        $("form#add_category_form").validate({
            rules: {
                category: {
                    required: true,
                     remote:{
                            url: '<?php echo base_url();?>backoffice/Asset/check_categoryName',
                            type: 'POST',
                            data: {
                                 category: function() {
                                  return $("#category").val();
                                  },
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                }
                            }
                }
            },
            messages: {
                category: {
                    required:"Please enter a category name",
                    remote:"This category already exist"
                }
            },
            submitHandler: function(form) {
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Asset/asset_category_add',
                    type: 'POST',
                    data: $("#add_category_form").serialize(),
                    success: function(response) {
                        var obj=JSON.parse(response);
                        if (obj.st==1) {
                            $('#add_category').modal('toggle');
                            $('#add_category_form' ).each(function(){
                                this.reset();
                            });
                            $.toaster({ priority : 'success', title : 'Success', message : obj.msg });
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Asset/load_category_ajax',
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
                                            ,
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
                        else
                        {
                            $.toaster({ priority : 'danger', title : 'Error', message : obj.msg });
                            
                        
                        }
                        $(".loader").hide();
                    }
                });
            }
        });

        $("form#edit_category_form").validate({
            rules: {
                name: {
                    required: true,
                     remote:{
                            url: '<?php echo base_url();?>backoffice/Asset/check_category_edit',
                            type: 'POST',
                            data: {
                                 category: function() {
                                  return $("#edit_category_name").val();
                                  },
                                id: function() {
                                  return $("#edit_id").val();
                                  },
                                
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                }
                            }
                }
            },
            messages: {
                name: {required:"Please enter a category name",             
                       remote:"This category already exist"
                          }
            },
            submitHandler: function(form) {
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Asset/edit_category',
                    type: 'POST',
                    data: $("#edit_category_form").serialize(),
                    success: function(response) {
                        var obj=JSON.parse(response);
                        if (obj.st==1) {
                            $('#edit_category').modal('toggle');
                            $('#edit_category_form' ).each(function(){
                                this.reset();
                            });
                            $.toaster({ priority : 'success', title : 'Success', message : obj.msg });
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Asset/load_category_ajax',
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
                                            ,
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
                        else
                        {
                            $.toaster({ priority : 'danger', title : 'Error', message : obj.msg });
                        
                        }
                        $(".loader").hide();
                    }
                });
            }
        });
    });

    function delete_category(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Asset/delete_category', 
                               {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                        var obj=JSON.parse(data);
                        if (obj.st==1) {
                          
                            $.toaster({ priority : 'success', title : 'Success', message : obj.msg });
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Asset/load_category_ajax',
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
                                            ,
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
                            else if(obj.st==2)
                        {
                            $.toaster({ priority : 'warning', title : 'Error', message : obj.msg });
                        
                        }
                        else
                        {
                            $.toaster({ priority : 'danger', title : 'Error', message : obj.msg });
                        
                        }
                                    
                                
                            });
                    }
                },
                cancel: function() {
                },
            }
        });
    }

    function get_category_data(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Asset/get_category_data',
            type: 'POST',
            data:{id:id,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj = JSON.parse(response);
             
                $("#edit_id").val(obj.id);
                $("#edit_category_name").val(obj.name);
               
                $('#edit_category').modal({
                    show: true
                });
                $(".loader").hide();
            }
        });
    }

    /*function edit_status(id,status){
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
    }*/





</script>