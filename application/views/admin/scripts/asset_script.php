<script>
    $(document).ready(function(){
        $("form#add_assets_form").validate({
            rules: {
                category: {
                    required: true   
                },
                 total_no: {
                    required: true   
                },
                 status: {
                    required: true   
                }
            },
            messages: {
                category: {
                    required:"Please choose a category type"
                    
                },
                total_no: {
                    required:"Please enter the total number of items"
                    
                },
                status: {
                    required:"Please choose a status"
                }
            },
            submitHandler: function(form) {
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Asset/assets_add',
                    type: 'POST',
                    data: $("#add_assets_form").serialize(),
                    success: function(response) {
                        var obj=JSON.parse(response);
                        if (obj.st==1) {
                            $('#add_assets').modal('toggle');
                            $('#add_assets_form' ).each(function(){
                                this.reset();
                            });
                            $.toaster({ priority : 'success', title : 'Success', message : obj.msg });
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Asset/load_asset_ajax',
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
                                            ,
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
                                            }
                                        ]
                                    });    
                                    $(".loader").hide();
                                } 
                            }); 
                        }
                        else if(obj.st ==2)
                        {
                            $.toaster({ priority : 'warning', title : 'Warning', message : obj.msg });
                        
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

        $("form#edit_assets_form").validate({
            rules: {
                category: {
                    required: true   
                },
                 total_no: {
                    required: true   
                },
                 status: {
                    required: true   
                }
            },
            messages: {
                type: {
                    required:"Please choose a category type"
                    
                },
                total_no: {
                    required:"Please enter the total number of items"
                    
                },
                status: {
                    required:"Please choose a status"
                }
            },
            submitHandler: function(form) {
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Asset/edit_assets',
                    type: 'POST',
                    data: $("#edit_assets_form").serialize(),
                    success: function(response) {
                        var obj=JSON.parse(response);
                        if (obj.st==1) {
                            $('#edit_assets').modal('toggle');
                            $('#edit_assets_form' ).each(function(){
                                this.reset();
                            });
                            $.toaster({ priority : 'success', title : 'Success', message : obj.msg });
                             $.ajax({
                                url: '<?php echo base_url();?>backoffice/Asset/load_asset_ajax',
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
                                            ,
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

    function delete_assets(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Asset/delete_assets', 
                               {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                        var obj=JSON.parse(data);
                            //alert(response);
                        if (obj.st==1) {
                          
                            $.toaster({ priority : 'success', title : 'Success', message : obj.msg });
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Asset/load_asset_ajax',
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
                                            ,
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
                                    
                                
                            });
                    }
                },
                cancel: function() {
                },
            }
        });
    }

    function get_asset_data(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Asset/get_asset_data',
            type: 'POST',
            data:{id:id,
                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj = JSON.parse(response);
             
                $("#edit_id").val(obj.id);
                $("#category").val(obj.category);
                $("#total_no").val(obj.total_number);
                $("#status").val(obj.item_status);
                $("#price").val(obj.price_per_unit);
               
                $('#edit_assets').modal({
                    show: true
                });
                $(".loader").hide();
            }
        });
    }

    





</script>