<script>
    $(document).ready(function(){
        var add_validation = 0;
        $("form#gallary_form").validate({
            rules: {
                "name": {required: true},
                "image[]": {required: true}
            },
            messages: {
                "name": {required: "Please enter a name"},
                "image[]": {required: "Please select at least one image"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                var file=$("#image")[0].files;
                // var files = $('#images')[0].files;
                for(var i = 0; i<file.length; i++){
                    // alert(file[i].name);
                    if(file[i]){
                        var file_size = file[i].size/1024;
                        if(file_size < <?php echo UPLOAD_IMAGE_SIZE; ?>){
                            var ext = file[i].name.split('.').pop().toLowerCase();
                            if(ext!='jpg' && ext!='png' && ext!='jpeg'){
                                $("#image_error").html('<br>Invalid file format, only jpeg png and jpg files accepted');
                                add_validation = 0;
                                $(".loader").hide();
                                return;
                            }
                            add_validation = 1;
                        }
                        else{
                            $("#image_error").html('<br>One of the file size is too large. Maximum allotted size <?php $size=UPLOAD_IMAGE_SIZE;echo $size/(1024).' MB'; ?>');
                            add_validation = 0;
                            $(".loader").hide();
                            return;
                        }
                    }
                }
            }
        });
        $("form#gallary_form").submit(function(e) {
            e.preventDefault();
            // alert(add_validation);
            if (add_validation == 1) {
            $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/gallery_add',
                    type: 'POST',
                    data: new FormData(this),
                    success: function(response) {
                        add_validation = 0;
                        // $('#gallary_form').validate.resetForm()
                        $('#add_gallery').modal('toggle');
                        $(".loader").hide();
                        var obj = JSON.parse(response);
                        if(obj.st == 1){
                            $.toaster({priority:'success',title:'Success',message:obj.msg});
                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Content/load_gallery_ajax',
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
        $("form#edit_gallery_form").validate({ 
            rules: {
                name: {required: true}
            },
            messages: {
                name: {required: "Please enter a name"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                if($("#image1").val() != ''){
                    var file=$("#image1").get(0).files[0].name; 
                    //alert(file);
                    if(file){
                        var file_size = $("#image1").get(0).files[0].size/1024;
                        if(file_size < <?php echo UPLOAD_IMAGE_SIZE; ?>){
                            var ext = file.split('.').pop().toLowerCase();
                            if(ext!='jpg' && ext!='png' && ext!='jpeg'){
                                $("#image_error1").html('<br>Invalid file format, only jpeg png and jpg files accepted');
                                add_validation = 0;
                                $(".loader").hide();
                                return;
                            }
                            add_validation = 1;
                        }else{ 
                            $("#image_error1").html('<br>Image file size is too large. Maximum allotted size <?php $size=UPLOAD_IMAGE_SIZE;echo $size/(1024).' MB'; ?>');
                            add_validation = 0;
                            $(".loader").hide();
                            return;
                        }
                    }
                }
                edit_validation = 1;
                // alert(edit_validation);
            }
        });
        $("form#edit_gallery_form").submit(function(e) {
            //prevent Default functionality
            e.preventDefault();
            // alert(edit_validation);
            if (edit_validation == 1) {
            $.ajax({
                    url: '<?php echo base_url();?>backoffice/Content/gallery_edit',
                    type: 'POST',
                    data: new FormData(this),
                    success: function(response) {
                        // alert(response);
                        $('#edit_gallery').modal('toggle');
                        $(".loader").hide();
                        var obj = JSON.parse(response);
                        var id = obj.id;
                        // alert(obj.st);
                        if(obj.st == 1){
                            $.toaster({priority:'success',title:'Success',message:obj.msg});
                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Content/load_gallery_ajaxExtra/'+id,
                                    type: 'POST',
                                    data: {
                                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                    },
                                    success: function(response) {  
                                    var obj = JSON.parse(response);
                                    $('#name_'+id).html(obj.name);    
                                    $('#school_'+id).html(obj.school); 
                                    $('#image_'+id).html(obj.image); 
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

    function delete_gallerydata(id) {
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
                        $.post('<?php echo base_url();?>backoffice/Content/gallery_delete/', {
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
    function get_galleryData(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Content/get_gallery_id/'+id,
            type: 'POST',
            data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                // alert(response);
                var obj = JSON.parse(response);
                $("#edit_name").val(obj.gallery_name);
                $("#edit_school").val(obj.school_id);
                $("#image_view").html('<img  src="<?php echo base_url() ?>/uploads/gallery/' + obj.gallery_image + '"style="width:200px;height:200px;">');
                $('#edit_gallery').modal({
                    show: true
                });
                $("#id").val(obj.gallery_id);
                $(".loader").hide();
            }
        });
    }

//------------------------------------------Success Stories-------------------------------------------//
</script>