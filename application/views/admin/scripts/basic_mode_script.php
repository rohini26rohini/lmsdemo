<script>
    $(document).ready(function(){
        var add_validation = 0;
        $("form#add_category_form").validate({
            rules: {
                entity: {required: true}
            },
            messages: {
                entity: {required: "Please enter course mode"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                add_validation = 1;
                if (add_validation == 1) {
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Courses/check_coursemode',
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            if(response==0) {
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Courses/coursemode_add',
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            add_validation = 0;
                            $('#add_category').modal('toggle');
                            $('#add_category_form' ).each(function(){
                                form.reset();
                                });
                            $(".loader").hide();
                            var obj = JSON.parse(response);
                            if(obj.st == 1){
                                $.toaster({priority:'success',title:'Success',message:obj.msg});
                                $.ajax({
                                        url: '<?php echo base_url();?>backoffice/Courses/load_coursemode_ajax',
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
                            }else{
                                $(".loader").hide();
                                $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                            }
                        },
                        error: function () {
                            $(".loader").hide();
                            $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                        }
                    });
                            } else {
                                $(".loader").hide();
                                $.toaster({priority:'warning',title:'Warning',message:'Entity is already exist'});  
                            }
                        }
                    });
            }
                }
        });

        var edit_validation = 0;
        $("form#edit_category_form").validate({
            rules: {
                entity: {required: true}
            },
            messages: {
                entity: {required: "Please enter course mode"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                edit_validation = 1;
                if (edit_validation == 1) {
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Courses/checkedit_coursemode',
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            if(response==0) {
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Courses/coursemode_edit',
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            edit_validation = 0;
                            $('#edit_category').modal('toggle');
                            $('#add_category_form' ).each(function(){
                                form.reset();
                                });
                            $(".loader").hide();
                            var obj = JSON.parse(response);
                            if(obj.st == 1){
                                $.toaster({priority:'success',title:'Success',message:obj.msg});
                                $.ajax({
                                        url: '<?php echo base_url();?>backoffice/Courses/load_coursemode_ajax',
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
                            }else{
                                $(".loader").hide();
                                $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                            }
                        },
                        error: function () {
                            $(".loader").hide();
                            $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                        }
                    });
                            } else {
                                $(".loader").hide();
                                $.toaster({priority:'warning',title:'Warning',message:'Entity is already exist'});  
                            }
                        }
                    });
            }
                }
        });    


    });


    var baseUrl = '<?php echo base_url(); ?>';
    function get_category_Data(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Courses/get_coursemode_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                // alert(response);
                var obj = JSON.parse(response);
                $("#mode_id").val(obj.mode_id);
                $("#entity_edit").val(obj.mode);
                //$("#mode_edit").html('<option value="'+obj.entity_type+'">'+obj.entity_type+'</option>');
                $('#edit_category').modal({
                    show: true
                });
                $(".loader").hide();
            }
        });
    }

    function edit_entity_status(id, status) {
        $.confirm({
            title: 'Alert message',
            content: 'Do you want to change status?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.post('<?php echo base_url();?>backoffice/Courses/edit_entity_status/', {
                            id: id,status: status,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            var obj = JSON.parse(data);
                            if(obj.st == 1){
                                $.toaster({priority:'success',title:'Success',message:obj.msg});
                                $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Courses/load_basicentity_ajax/',
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
                            }else if(obj.st == 2){
                                $.toaster({priority:'warning',title:'Oops!',message:obj.msg});
                            }else{
                                $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                            }  
                        });
                    }
                },
                cancel: function() {
                },
            }
        });
    }


    $(document).ready(function(){
        var add_validation = 0;
        $("form#add_city_form").validate({
            rules: {
                state:{required: true},
                entity: {required: true}
            },
            messages: {
                state:{required: "Please select state"},
                entity: {required: "Please enter city"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                add_validation = 1;
                if (add_validation == 1) {
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Courses/check_existing',
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            if(response==0) {
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Courses/city_add',
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            add_validation = 0;
                            $('#add_category').modal('toggle');
                            $('#add_city_form' ).each(function(){
                                form.reset();
                                });
                            $(".loader").hide();
                            var obj = JSON.parse(response);
                            if(obj.st == 1){
                                $.toaster({priority:'success',title:'Success',message:obj.msg});
                                $.ajax({
                                        url: '<?php echo base_url();?>backoffice/Courses/load_city_ajax',
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
                            }else{
                                $(".loader").hide();
                                $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                            }
                        },
                        error: function () {
                            $(".loader").hide();
                            $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                        }
                    });
                            } else {
                                $(".loader").hide();
                                $.toaster({priority:'warning',title:'Warning',message:'City is already exist'});  
                            }
                        }
                    });
            }
                }
        });

        var edit_validation = 0;
        $("form#edit_city_form").validate({
            rules: {
                state:{required: true},
                entity: {required: true}
            },
            messages: {
                state:{required: "Please select state"},
                entity: {required: "Please enter city"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                edit_validation = 1;
                if (edit_validation == 1) {
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Courses/checkedit_city',
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            if(response==0) {
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Courses/city_edit',
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            edit_validation = 0;
                            $('#edit_category').modal('toggle');
                            $('#add_city_form' ).each(function(){
                                form.reset();
                                });
                            $(".loader").hide();
                            var obj = JSON.parse(response);
                            if(obj.st == 1){
                                $.toaster({priority:'success',title:'Success',message:obj.msg});
                                $.ajax({
                                        url: '<?php echo base_url();?>backoffice/Courses/load_city_ajax',
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
                            }else{
                                $(".loader").hide();
                                $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                            }
                        },
                        error: function () {
                            $(".loader").hide();
                            $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                        }
                    });
                            } else {
                                $(".loader").hide();
                                $.toaster({priority:'warning',title:'Warning',message:'City is already exist'});  
                            }
                        }
                    });
            }
                }
        });    


    });  

        function get_city_Data(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Courses/get_city_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                // alert(response);
                var obj = JSON.parse(response);
                $("#mode_id").val(obj.id);
                $("#entity_edit").val(obj.name);
                $("#edit_state").val(obj.state_id);
                //$("#mode_edit").html('<option value="'+obj.entity_type+'">'+obj.entity_type+'</option>');
                $('#edit_category').modal({
                    show: true
                });
                $(".loader").hide();
            }
        });
    }  
</script>