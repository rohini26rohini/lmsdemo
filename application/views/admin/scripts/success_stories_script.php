<script>
    $(document).ready(function(){
        $("#document_type").change(function(){
            var document_type= $(this).val();
            $('#document_input').empty();
            // alert(document_type);
            if(document_type !=""){
                if(document_type == 1){
                    $('#document_input').append('<div class="form-group">'+
                    '<label><?php echo $this->lang->line('description');?><span class="req redbold">*</span></label>'+
                    '<textarea class="form-control custumArea" name="description" id="description" rows="5" cols="40"></textarea>'+'</div><label><?php echo $this->lang->line('image');?></label><span class="req redbold"> * </span><small><?php echo " ( ". $this->lang->line('restriction_image_format');?>)</small><input class="form-control" id="image" name="file_name" type="file">');
                    CKEDITOR.replace('description');
                }else if(document_type == 2){
                    $('#document_input').append('<label><?php echo $this->lang->line('link');?></label><input class="form-control" id="link" name="link" type="url" pattern="https://.*">');
                }
            }
        });
        $("#edit_document_type").change(function(){
            var document_type= $(this).val();
            $('#document_input_edit').empty(); 
            // alert(document_type);
            if(document_type !=""){
                if(document_type == 1){
                    $('#document_input_edit').append('<div class="form-group">'+
                    '<label><?php echo $this->lang->line('description');?><span class="req redbold">*</span></label>'+
                    '<textarea class="form-control custumArea" name="description" id="edit_description" rows="5" cols="40"></textarea></div><label><?php echo $this->lang->line('image');?></label><span class="req redbold"> * </span><small><?php echo " ( ". $this->lang->line('restriction_image_format');?>)</small><input class="form-control" id="image1" name="file_name" type="file">');
                    CKEDITOR.replace('edit_description');
                }else if(document_type == 2){
                    $('#document_input_edit').append('<label><?php echo $this->lang->line('link');?></label><input class="form-control" id="link" name="link" type="url" pattern="https://.*">');
                }
            }
        });
        var add_validation = 0;
        $("form#success_stories_form").validate({
            rules: {
                name: {
                    required: true,
                    remote: {
                                url: '<?php echo base_url();?>backoffice/Content/successNamecheck',
                                type: 'POST',
                                data: {
                                name: function() {
                                      return $("#name").val();
                                      },
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    }
                            }
                },
                description: {minlength: 80},
                document_type: {required: true},
                school: {required: true},
                location: {required: true},
                file_name: {required: true}
            },
            messages: {
                name: {
                    required: "Please enter a name",
                    remote:"This success story already exist"
                },
                document_type: {required: "Please select a document type"},
                school: {required: "Please select a school"},
                location: {required: "Please enter a location"},
                file_name: {required: "Please select an image"}
            }
            ,
            submitHandler: function(form) {
                $(".loader").show();
                add_validation = 1;
                if($("#document_type").val() == 1){
                    var file=$("#image").get(0).files[0].name; 
                    if(file){
                        var file_size = $("#image").get(0).files[0].size/1024;
                        if(file_size < <?php echo UPLOAD_IMAGE_SIZE; ?>){
                            var ext = file.split('.').pop().toLowerCase();
                            if(ext!='jpg' && ext!='png' && ext!='jpeg'){
                                $("#image_error").html('<br>Invalid file format, only jpeg png and jpg files accepted');
                                add_validation = 0;
                                $(".loader").hide();
                                return;
                            }
                            add_validation = 1;
                        }else{ 
                            $("#image_error").html('<br>Image file size is too large. Maximum allotted size <?php $size=UPLOAD_IMAGE_SIZE;echo $size/(1024).' MB'; ?>');
                            add_validation = 0;
                            $(".loader").hide();
                            return;
                        }
                    }
                }
            }
        });
        $("form#success_stories_form").submit(function(e) {
            //prevent Default functionality
            var data = new FormData(this);
            if($("#document_type").val() == 1){
                data.append('description', CKEDITOR.instances['description'].getData());
            }
            e.preventDefault();
            if (add_validation == 1) {
            $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/success_storie_add',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        add_validation = 0;
                        $('#add_stories').modal('toggle');
                        $(".loader").hide();
                        var obj = JSON.parse(response);
                        if(obj.st == 1){
                            $.toaster({priority:'success',title:'Success',message:obj.msg});
                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Content/load_success_story_ajax',
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
                    cache: false,
                contentType: false,
                processData: false
                });
            }
        });
        var edit_validation = 0;
        $("form#edit_success_stories_form").validate({
            rules: {
                name: {required: true},
                document_type: {required: true},
                school: {required: true},
                location: {required: true},
                description: {minlength: 80}
                
            },
            messages: {
                name: {required: "Please enter a name"},
                document_type: {required: "Please select a document type"},
                school: {required: "Please select a school"},
                location: {required: "Please enter a location"}
                
            },
            submitHandler: function(form) {
                $(".loader").show();
                edit_validation = 1;
                // alert($("#edit_document_type").val());
                if($("#edit_document_type").val() == 1){
                    if($("#image1").val() != ''){
                        var file=$("#image1").get(0).files[0].name; 
                        if(file){
                            var file_size = $("#image1").get(0).files[0].size/1024;
                            if(file_size < <?php echo UPLOAD_IMAGE_SIZE; ?>){
                                var ext = file.split('.').pop().toLowerCase();
                                if(ext!='jpg' && ext!='png' && ext!='jpeg'){
                                    $("#image_error1").html('<br>Invalid file format, only jpeg png and jpg files accepted');
                                    edit_validation = 0;
                                    $(".loader").hide();
                                    return;
                                }
                                edit_validation = 1;
                            }else{ 
                                $("#image_error1").html('<br>Image file size is too large. Maximum allotted size <?php $size=UPLOAD_IMAGE_SIZE;echo $size/(1024).' MB'; ?>');
                                edit_validation = 0;
                                $(".loader").hide();
                                return;
                            }
                        }
                    }
                }
            }
        });
        $("form#edit_success_stories_form").submit(function(e) {
            //prevent Default functionality
            e.preventDefault();
            var data = new FormData(this);
            if($("#edit_document_type").val() == 1){
                data.append('description', CKEDITOR.instances['edit_description'].getData());
            }
            if (edit_validation == 1) {
            $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/success_storie_edit',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        edit_validation = 0;
                        $('#edit_stories').modal('toggle');
                        $(".loader").hide();
                        var obj = JSON.parse(response);
                        var id = obj.id
                        if(obj.st == 1){
                            $.toaster({priority:'success',title:'Success',message:obj.msg});
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Content/load_success_story_ajaxExtra/'+id,
                                type: 'POST',
                                    data: {
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {  
                                    var obj = JSON.parse(response);
                                    $('#name_'+id).html(obj.name);  
                                    $('#document_'+id).html(obj.document);   
                                    $('#school_'+id).html(obj.school); 
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
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });
    });

    function delete_successdata(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Content/success_delete/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            var obj = JSON.parse(data);
                                if(obj.st == 1){
                                    $.toaster({priority:'success',title:'Success',message:obj.msg});
                                    $('#row_'+id).empty();  
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
    function get_successdata(id){
        
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Content/get_success_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                // alert(response);
                var obj = JSON.parse(response);
                $('#document_input_edit').empty();
                $('#document_input_edit1').empty();
                $("#edit_name").val(obj.name);
                $("#edit_document_type").val(obj.document_type)
                if(obj.document_type == 1){
                    $('#document_input_edit').append('<div class="form-group">'+
                    '<label><?php echo $this->lang->line('description');?><span class="req redbold">*</span></label>'+
                    '<textarea class="form-control custumArea" name="description" id="edit_description" rows="5" cols="40"></textarea></div><label><?php echo $this->lang->line('image');?></label><span class="req redbold"> * </span><small><?php echo " ( ". $this->lang->line('restriction_image_format');?>)</small><input class="form-control" id="image1" name="file_name" type="file">');
                    $('#document_input_edit1').append('<a href="'+baseUrl+'/uploads/success_stories/'+obj.document+'" target="_blank">Image View</a>');
                    CKEDITOR.replace('edit_description');
                    CKEDITOR.instances['edit_description'].setData(obj.description);
                }
                else if(obj.document_type == 2){
                    $('#document_input_edit').append('<label><?php echo $this->lang->line('link');?></label><input class="form-control" id="link" value="'+obj.description+'" name="link" type="url" pattern="https://.*">');
                    // $('#document_input_edit1').append('<a href='+obj.document+' target="_blank">Link</a>');
                }
                $("#edit_document_type").val(obj.document_type);
                $('#edit_stories').modal({
                    show: true
                });
                $("#edit_school").val(obj.school_id);
                $("#id").val(obj.success_id);
                $("#edit_location").val(obj.location);

                $(".loader").hide();
            }
        });
    }
//------------------------------------------Success Stories-------------------------------------------//
</script>