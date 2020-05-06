<script>
    $(document).ready(function(){
        var add_validation = 0;
        $("form#add_category_form").validate({
            rules: {
                category: {required: true,
                    maxlength: 28,
                    remote: {
                                url: '<?php echo base_url();?>backoffice/Content/categoryCheck',
                                type: 'POST',
                                data: {
                                    topic_title: function() {
                                      return $("#category").val();
                                      },
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    }
                            }
                },
                school: {required: true}
            },
            messages: {
                category: {required: "Please enter a category",
                            remote:"This category already exist"}, 
                school: {required: "Please select a school"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                add_validation = 1;
                if (add_validation == 1) {
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Content/category_add',
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
                                        url: '<?php echo base_url();?>backoffice/Content/load_category_ajax',
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
                                $.toaster({priority:'warning',title:'Warning',message:obj.msg});
                            }else{
                                $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                            }
                        },
                        error: function () {
                            $(".loader").hide();
                            $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                        }
                    });
                }
            }
        });
        var edit_validation = 0;
        $("form#edit_category_form").validate({
            rules: {
                category: {required: true,
                    maxlength: 28,
                    remote: {
                                url: '<?php echo base_url();?>backoffice/Content/categoryCheck_edit',
                                type: 'POST',
                                data: {
                                    topic_title: function() {return $("#category_edit").val();},
                                    id: function() { return $("#id").val();},
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    }
                            }},
                school: {required: true}
            },
            messages: {
                category: {required: "Please enter a category",
                            remote:"This category already exist"}, 
                school: {required: "Please select a school"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                edit_validation = 1;
                if (edit_validation == 1) {
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Content/category_edit',
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            edit_validation = 0;
                            $('#edit_category').modal('toggle');
                            $('#edit_category_form' ).each(function(){
                                form.reset();
                            });
                            $(".loader").hide();
                            var obj = JSON.parse(response);
                            var id = obj.id;
                            if(obj.st == 1){
                                $.toaster({priority:'success',title:'Success',message:obj.msg});
                                $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Content/load_category_ajaxExtra/'+id,
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {  
                                        var obj = JSON.parse(response);
                                        $('#category_'+id).html(obj.category);  
                                        $('#school_'+id).html(obj.school);   
                                        $('#status_'+id).html(obj.status); 
                                        $('#action_'+id).html(obj.action); 
                                        
                                        $(".loader").hide();
                                    } 
                                });    
                            }else if(obj.st == 2){
                                $.toaster({priority:'warning',title:'Warning',message:obj.msg});
                            }else{
                                $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                            }
                        },
                        error: function () {
                            $(".loader").hide();
                            $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                        }
                    });
                }
            }
        });
    });

    function delete_catogory_Data(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Content/category_delete/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            var obj = JSON.parse(data);
                                if(obj.st == 1){
                                    $.toaster({priority:'success',title:'Success',message:obj.msg});  
                                    $(".loader").hide(); 
                                    $('#row_'+id).empty(); 
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
var baseUrl = '<?php echo base_url(); ?>';
    function get_category_Data(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Content/get_category_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                // alert(response);
                var obj = JSON.parse(response);
                $("#school_edit").val(obj.school_id);
                $("#category_edit").val(obj.category);
                $('#edit_category').modal({
                    show: true
                });
                $("#id").val(obj.id);
                $(".loader").hide();
            }
        });
    }

    function edit_catogory_status(id, status) {
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
                        $.post('<?php echo base_url();?>backoffice/Content/edit_category_status/', {
                            id: id,status: status,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            var obj = JSON.parse(data);
                            if(obj.st == 1){
                                $.toaster({priority:'success',title:'Success',message:obj.msg});
                                $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Content/load_category_ajaxExtra/'+id,
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {  
                                        var obj = JSON.parse(response);
                                        $('#category_'+id).html(obj.category);  
                                        $('#school_'+id).html(obj.school);   
                                        $('#status_'+id).html(obj.status); 
                                        $('#action_'+id).html(obj.action); 
                                        
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