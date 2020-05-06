<script>
    $("#school").change(function(){
        var school_id = $('#school').val();
        if (school_id != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Content/get_categoryby_school',
                type: 'POST',
                data: {
                    school_id: school_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    // alert(response);
                    $("#category").html(response);
                    $(".loader").hide();
                }
            });
        }
    });
    $("#edit_school").change(function(){
        var school_id = $('#edit_school').val();
        if (school_id != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Content/get_categoryby_school',
                type: 'POST',
                data: {
                    school_id: school_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    // alert(response);
                    $("#category_edit").html(response);
                    $(".loader").hide();
                }
            });
        }
    });
    $("#type").change(function(){
        var type = $('#type').val();
        if (type == "general_studies") {
            $(".loader").show();
            $("#topic_div").html('<label><?php echo $this->lang->line('topic_title');?> <span class="req redbold">*</span></label><input type="text" name="topic_title" id="topic_title" class="form-control" placeholder="<?php echo $this->lang->line('topic_title');?>" />');
            $(".loader").hide();
        }else{
            $("#topic_div").empty();
        }
    });
    $("#type_edit").change(function(){
        var type = $('#type_edit').val();
        if (type == "general_studies") {
            $(".loader").show();
            $("#topic_div_edit").html('<label><?php echo $this->lang->line('topic_title');?> <span class="req redbold">*</span></label><input type="text" name="topic_title" id="topic_title" class="form-control" placeholder="<?php echo $this->lang->line('topic_title');?>" />');
            $(".loader").hide();
        }else{
            $("#topic_div_edit").empty();
        }
    });
    function getCategory(school_id,category_id){
        if (school_id != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Content/get_categoryby_school_edit',
                type: 'POST',
                data: {
                    school_id: school_id,category_id: category_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    // alert(response);
                    $("#category_edit").html(response);
                    $(".loader").hide();
                }
            });
        }
    }
    $(document).ready(function(){
        var add_validation = 0;
        $("form#gs_form").validate({
            rules: {
                school: {required: true},
                category: {required: true},
                type: {required: true},
                topic_title: {required: true,
                remote: {
                            url: '<?php echo base_url();?>backoffice/Content/topicCheck',
                            type: 'POST',
                            data: {
                                    topic_title: function() {
                                    return $("#topic_title").val();
                                  },
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                }
                        }},
                topic_document: {required: true}
            },
            messages: {
                school: {required: "Please select a school"},
                category: {required: "Please select a category"},
                type: {required: "Please select a type"},
                topic_title: {required: "Please enter a topic title",
                    remote:"This topic already exist"}, 
                topic_document: {required: "Please select a topic document"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                var file=$("#topic_document").get(0).files[0].name;
                if(file){
                    var file_size = $("#topic_document").get(0).files[0].size/1024;
                    if(file_size < <?php echo UPLOAD_IMAGE_SIZE; ?>){
                        var ext = file.split('.').pop().toLowerCase();
                        if(ext!='docx' && ext!='doc' && ext!='xlsx' && ext!='ppt'){
                            $("#document_error").html('<br>Invalid file format, accept only ppt,docx,doc & xlsx files');
                            add_validation = 0;
                            $(".loader").hide();
                            return;
                        }
                        add_validation = 1;
                    }else{
                        $("#document_error").html('<br>Image file size is too large. Maximum allotted size <?php $size=UPLOAD_IMAGE_SIZE;echo $size/(1024).' MB'; ?>');
                        add_validation = 0;
                        $(".loader").hide();
                        return;
                    }
                }
            }
        });
        $("form#gs_form").submit(function(e) {
            e.preventDefault();
            // alert(add_validation);
            if (add_validation == 1) {
            $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/previous_question_and_syllabus_add',
                    type: 'POST',
                    data: new FormData(this),
                    success: function(response) {
                        add_validation = 0;
                        var obj = JSON.parse(response);
                        if(obj.st == 1){
                            // alert(response);
                            $('#add_gs').modal('toggle');
                            $(".loader").hide();
                            $.toaster({priority:'success',title:'Success',message:obj.msg});
                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Content/load_previous_question_and_syllabus_ajax',
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
                            $.toaster({priority:'warning',title:'Warning',message:obj.msg});
                            $(".loader").hide();
                        }else{
                            $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });
        var edit_validation = 0;
        $("form#edit_gs_form").validate({
            rules: {
                school: {required: true},
                category: {required: true},
                type: {required: true},
                topic_title: {required: true}
            },
            messages: {
                school: {required: "Please select a school"},
                category: {required: "Please select a category"},
                type: {required: "Please select a type"},
                topic_title: {required: "Please enter a topic title"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                edit_validation = 1;
                if($("#edit_topic_document").val() != ''){
                    var file=$("#edit_topic_document").get(0).files[0].name;
                    if(file){
                        var file_size = $("#edit_topic_document").get(0).files[0].size/1024;
                        if(file_size < <?php echo UPLOAD_IMAGE_SIZE; ?>){
                            var ext = file.split('.').pop().toLowerCase();
                            if(ext!='docx' && ext!='doc' && ext!='xlsx' && ext!='ppt'){
                                $("#edit_document_error").html('<br>Invalid file format, accept only pdf,ppt,docx,doc & xlsx file');
                                edit_validation = 0;
                                $(".loader").hide();
                                return;
                            }
                            edit_validation = 1;
                        }else{
                            $("#edit_document_error").html('<br>Image file size is too large. Maximum allotted size <?php $size=UPLOAD_IMAGE_SIZE;echo $size/(1024).' MB'; ?>');
                            edit_validation = 0;
                            $(".loader").hide();
                            return;
                        }
                    }
                }
            }
        });
        $("form#edit_gs_form").submit(function(e) {
            //prevent Default functionality
            e.preventDefault();
            // alert(edit_validation);
            if (edit_validation == 1) {
            $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/previous_question_and_syllabus_edit',
                    type: 'POST',
                    data: new FormData(this),
                    success: function(response) {
                        edit_validation = 0;
                        // alert(response);
                        $(".loader").hide();
                        var obj = JSON.parse(response);
                        var id = obj.id;
                        // alert(obj.st);
                        if(obj.st == 1){
                            $('#edit_gs').modal('toggle');
                            $.toaster({priority:'success',title:'Success',message:obj.msg});
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Content/load_previous_question_and_syllabus_ajaxExtra/'+id,
                                type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) {  
                                    var obj1 = JSON.parse(response); 
                                    $('#school_'+id).html(obj1.school); 
                                    $('#category_'+id).html(obj1.category); 
                                    $('#type_'+id).html(obj1.type); 
                                    $('#document_'+id).html(obj1.document); 
                                    $('#status_'+id).html(obj1.status); 
                                    $('#action_'+id).html(obj1.action);
                                    $(".loader").hide();
                                } 
                            });   
                        }else if(obj.st == 2){
                            $.toaster({priority:'warning',title:'Warning',message:obj.msg});
                        }else{
                            $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
            // alert("last");
        });
    });

    function delete_general_studies_Data(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Content/previous_question_and_syllabus__delete/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            var obj = JSON.parse(data);
                                if(obj.st == 1){
                                    $.toaster({priority:'success',title:'Success',message:obj.msg});
                                    $('#row_'+id).empty();  
                                    $(".loader").hide(); 
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
    function get_general_studies_Data(id){
        $("#edit_document_error").empty();
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Content/previous_question_and_syllabus_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                // alert(response);
                var obj = JSON.parse(response);
                $("#edit_school").val(obj.school_id);
                getCategory(obj.school_id,obj.category_id);
                $("#category_edit").val(obj.category_id);
                $("#type_edit").val(obj.type);
                if(obj.type == 'general_studies'){
                    $("#topic_div_edit").html('<label><?php echo $this->lang->line('topic_title');?> <span class="req redbold">*</span></label><input type="text" name="topic_title" id="edit_topic_title" class="form-control" value="'+obj.topic_title+'" />');
                }else{
                    $("#topic_div_edit").empty();
                }
                $("#document_view").html('<br><label>'+obj.topic_attachment+'</label>');
                $('#edit_gs').modal({
                    show: true
                });
                $("#id").val(obj.id);
                $(".loader").hide();
            }
        });
    }

    function edit_gs_status(id, status, school_id, category_id, type) {
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
                        $.post('<?php echo base_url();?>backoffice/Content/edit_previous_question_and_syllabus_status/', {
                            id: id,status: status, school_id:school_id, category_id:category_id, type:type,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            if(data == 1){
                                $.toaster({priority:'success',title:'Success',message:'Status changed successfuly.!'});
                            }else if(data == 0){
                                $.toaster({priority:'warning',title:'Invalid',message:'Content already exist. Can\'t change status.!'});
                            }
                            
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Content/load_previous_question_and_syllabus_ajaxExtra/'+id,
                                type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) {  
                                    var obj1 = JSON.parse(response); 
                                    $('#school_'+id).html(obj1.school); 
                                    $('#category_'+id).html(obj1.category); 
                                    $('#type_'+id).html(obj1.type); 
                                    $('#document_'+id).html(obj1.document); 
                                    $('#status_'+id).html(obj1.status); 
                                    $('#action_'+id).html(obj1.action);
                                    $(".loader").hide();
                                } 
                            });  
                        });
                    }
                },
                cancel: function() {
                },
            }
        });
    }
</script>