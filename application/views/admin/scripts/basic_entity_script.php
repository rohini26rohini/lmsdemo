<script>
    $(document).ready(function(){
        var add_validation = 0;
        $("form#add_category_form").validate({
            rules: {
                entity: {required: true},
                mode: {required: true}
            },
            messages: {
                entity: {required: "Please enter entity"}, 
                mode: {required: "Please select type"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                add_validation = 1;
                if (add_validation == 1) {
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Courses/check_basic_entity',
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            if(response==0) {
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Courses/basic_entity_add',
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
                                        url: '<?php echo base_url();?>backoffice/Courses/load_basicentity_ajax',
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
                entity: {required: true},
                mode: {required: true}
            },
            messages: {
                entity: {required: "Please enter entity"}, 
                mode: {required: "Please select type"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                edit_validation = 1;
                if (edit_validation == 1) {
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Courses/checkedit_basic_entity',
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            if(response==0) {
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Courses/basic_entity_edit',
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
                                        url: '<?php echo base_url();?>backoffice/Courses/load_basicentity_ajax',
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

        $(".addBtnPosition").click(function(){
            $("#leveldiv").css("display","block"); 
        });

        $("#mode").change(function(){
            var modeval = $(this).val();
            if (modeval == "Qualification") {
                $("#leveldiv").css("display","block"); 
            }
            else{
                $("#leveldiv").css("display","none");

            }
        });
    });


    var baseUrl = '<?php echo base_url(); ?>';
    function get_category_Data(id){
        
        var level = '';
        $(".loader").show();
        $('#leveldiv').hide();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Courses/get_basicentity_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                // alert(response);
                var obj = JSON.parse(response);
                $("#entity_id").val(obj.entity_id);
                $("#entity_edit").val(obj.entity_name);
                $("#mode_edit").html('<option value="'+obj.entity_type+'">'+obj.entity_type+'</option>');
                if(obj.entity_type=='Qualification') {
                    $('#leveldiv').show();
                }
                if(obj.entity_level=='Classx') {
                    var level = 'Class X or Below';
                }
                if(obj.entity_level=='Classxii') {
                    var level = 'Class XII or Equivalent';
                }
                if(obj.entity_level=='Degree') {
                    var level = 'Degree/Diploma';
                }
                if(obj.entity_level=='PG') {
                    var level = 'P.G. & Above';
                }
                $("#level_edit").html('<option value="'+obj.entity_level+'">'+level+'</option>');
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
    function edit_entityStaff_status(name, status, field) {
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
                        $.post('<?php echo base_url();?>backoffice/Courses/edit_entityStaff_status/', {
                            name: name, status: status, field: field,
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
</script>