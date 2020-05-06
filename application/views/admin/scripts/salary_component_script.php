<script>
    $(document).ready(function(){
        $("form#add_salary_component_form").validate({
            rules: {
                head: {required: true},
                type: {required: true}
            },
            messages: {
                head: {required:"Please enter salary component"},
                type: {required:"Please choose a type"}

            },
            submitHandler: function(form) {
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Leave/salary_component_add', 
                    type: 'POST',
                    data: $("#add_salary_component_form").serialize(),
                    success: function(response) {
                        var obj=JSON.parse(response);
                        if (obj.st == 1) {
                            $('#add_salary_component').modal('toggle');
                            $('#add_salary_component_form' ).each(function(){
                                this.reset();
                            });
                            $.toaster({ priority : 'success', title : 'Success', message : obj.msg});
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Leave/load_salary_component_ajax',
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
                                                'aTargets': [3]
                                            }
                                        ]
                                    });    
                                    $(".loader").hide();
                                } 
                            }); 
                        }else if(obj.st == 2){
                            $.toaster({ priority : 'danger', title : 'Error', message : obj.msg });
                        }
                        $(".loader").hide();
                    }
                });
            }
        });

        $("form#edit_salary_component_form").validate({
            rules: {
                head: {required: true},
                type: {required: true}
            },
            messages: {
                head: {required:"Please enter a leave head name"},
                type: {required:"Please choose a type"}

            },
            submitHandler: function(form) {
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Leave/salary_component_edit',
                    type: 'POST',
                    data: $("#edit_salary_component_form").serialize(),
                    success: function(response) {
                        var obj = JSON.parse(response);
                        if (obj.st == 1) {
                            $('#edit_salary_component').modal('toggle');
                            $.toaster({ priority : 'success', title : 'Success', message : obj.msg });
                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Leave/load_salary_component_ajax',
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
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                }); 
                        }else if(obj.st == 2){
                            $.toaster({ priority : 'danger', title : 'Error', message : obj.msg });
                        }
                        $(".loader").hide();
                    }
                });
            }
        });
    });

    function delete_salarycompnent(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Leave/salary_component_delete/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                                if (data == 1) {
                                    $.toaster({ priority : 'success', title : 'Success', message : 'Successfully deleted ' });
                                    //$.alert('Successfully <strong>Deleted..!</strong>');
                                    $("#row_"+id).remove();
                                    $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Leave/load_salary_component_ajax',
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
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                }); 
                                }
                            });
                    }
                },
                cancel: function() {
                },
            }
        });
    }

    function get_salarycomponent_data(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Leave/get_salary_component_by_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj = JSON.parse(response);
                $("#edit_component_id").val(obj.id);
                $("#status").val(obj.status);
                $("#edit_salary_head").val(obj.head);
                $("#edit_type").val(obj.type);
                $('#edit_salary_component').modal({
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
                                    url: '<?php echo base_url();?>backoffice/Leave/salary_component_status',
                                    type: 'POST',
                                    data: {
                                        id: id,
                                        status:status,
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {
                                        if (response == 1) {
                                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Leave/load_salary_component_ajax',
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
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [3]
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




</script>