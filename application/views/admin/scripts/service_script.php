<script>
CKEDITOR.replace('service_content');
CKEDITOR.replace('edit_service_content');
var add_validation = 0;
var edit_validation = 0;
        $("#title").change(function(){
            var title= $(this).val();
            $('#mentorImg').empty();
            // alert(document_type);
            if(title != ""){
                if(title == 'IAS-Mentor'){
                    $('#mentorImg').append('<div class="form-group">'+
                    '<label><?php echo $this->lang->line('image');?></label><input class="form-control" id="image" name="file_name" type="file"></div>');
                }else{
                    $('#mentorImg').empty();
                }
            }
        });
        $("#edit_title").change(function(){
            var title= $(this).val();
            $('#edit_mentorImg').empty();
            // alert(document_type);
            if(title != ""){
                if(title == 'IAS-Mentor'){
                    $('#edit_mentorImg').append('<div class="form-group">'+
                    '<label><?php echo $this->lang->line('image');?></label><input class="form-control" id="image" name="file_name" type="file"></div>');
                }else{
                    $('#edit_mentorImg').empty();
                }
            }
        });
    $(document).ready(function(){
        $("form#add_services_form").validate({
            rules: {
                // school_id: {required: true},
                title: {required: true},
                service_content: {required: true}
            },
            messages: {
                // school_id: {required:"Please Choose School"},
                title: {required:"Please Enter Title"},
                service_content: {required: "Please Enter Content"}

            },
            submitHandler: function(form) {
                $(".loader").show();
                add_validation = 1;
                // alert(add_validation);
            }
            
        });

        $("form#add_services_form").submit(function(e) {
            //prevent Default functionality
            e.preventDefault();
            var data = new FormData(this);
            //add the content
            // CKEDITOR.instances["txtFT_Content"].getData();
            data.append('service_content', CKEDITOR.instances['service_content'].getData());
            if (add_validation == 1) {
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/services_add',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        var obj = JSON.parse(response);
                        if(obj.st == 1){
                            $('#add_services').modal('toggle');
                            $('#add_services_form' ).each(function(){
                                this.reset();
                            });
                            $.toaster({ priority : 'success', title : 'Success', message : 'Service Added Succesfully ' });
                            // $("#discount_data").append(response);
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Content/load_services_ajax',
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
                                //      "order": [[4, 'asc']],
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


        $("form#edit_services_form").validate({
            rules: {
                // school_id: {required: true},
                title: {required: true},
                // image: {required: true}
            },
            messages: {
                // school_id: {required:"Please Choose School"},
                title: {required:"Please Enter Title"},
                // image: {required:"Please select an image"}

            },
        submitHandler: function(form) {
            $(".loader").show();
            edit_validation = 1;
            
            if($('#edit_title').val() == 'Honorary-Director'){
                
                if($("#image").val() != ''){
                    // alert($('#edit_title').val());
                    var file=$("#image").get(0).files[0].name; 
                    //alert(file);
                    if(file){
                        var file_size = $("#image").get(0).files[0].size/1024;
                        if(file_size < <?php echo UPLOAD_IMAGE_SIZE; ?>){
                            var ext = file.split('.').pop().toLowerCase();
                            if(ext!='jpg' && ext!='png' && ext!='jpeg'){
                                $("#image_error").html('<br>Invalid file format only jpg,jpeg and png files are accepted');
                                edit_validation = 0;
                                $(".loader").hide();
                                return;
                            }
                            edit_validation = 1;
                        }else{ 
                            $("#image_error").html('<br>Image file size is too large. Maximum allotted size <?php $size=UPLOAD_IMAGE_SIZE;echo $size/(1024).' MB'; ?>');
                            edit_validation = 0;
                            $(".loader").hide();
                            return;
                        }
                    }
                }
            }
            // alert(edit_validation);
        }
    });
    $("form#edit_services_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault();
        var data = new FormData(this);
        data.append('service_content', CKEDITOR.instances['edit_service_content'].getData());
        if (edit_validation == 1) {
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Content/services_edit',
            type: 'POST',
            data: data,
            success: function(response) {
                var obj = JSON.parse(response);
                if(obj.st == 1){
                    $('#edit_services').modal('toggle');
                    $.toaster({ priority : 'success', title : 'Success', message : 'Service Updated Successfully' });
                    $.ajax({
                        url: '<?php echo base_url();?>backoffice/Content/load_services_ajax',
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
                    //             "order": [[4, 'asc']],
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

    function delete_services(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Content/services_delete/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(response) {
                            if (response != "2" && response != "0") {
                                    $.alert('Successfully <strong>Deleted..!</strong>');
                                    $("#row_"+id).remove();
                                    $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Content/load_services_ajax',
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
                                    //      "order": [[4, 'asc']],
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
                            });
                    }
                },
                cancel: function() {
                },
            }
        });
    }

    function get_servicesdata(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Content/get_services_by_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj = JSON.parse(response);
                $("#edit_service_id").val(obj.service_id);
                // $("#edit_school_id").val(obj.school_id);
                $("#edit_title").val(obj.title);
                $("#edit_service_content").val(obj.service_content);
                $('#edit_mentorImg').empty();
                if(obj.title == 'Honorary-Director'){
                    $('#edit_mentorImg').append('<div class="form-group">'+
                    '<label><?php echo $this->lang->line('image');?></label><small> ( Only jpg , jpeg &amp; png format supported. Maximum size is 5 MB)</small><input class="form-control" id="image" name="image" type="file"></div><div style="color:red;" id="image_error"></div>');
                    $("#image_view").html('<img  src="<?php echo base_url() ?>uploads/IAS-director/' + obj.mentor_image + '"style="width:200px;height:200px;">');
                }else{
                    $('#edit_mentorImg').empty();
                    $("#image_view").empty();
                }
                $('#edit_services').modal({
                    show: true
                });
                CKEDITOR.instances['edit_service_content'].setData(obj.service_content);
                $(".loader").hide();
            }
        });
    }
</script>