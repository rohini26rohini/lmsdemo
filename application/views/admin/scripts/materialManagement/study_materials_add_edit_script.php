<script>
    var file_validation_error = 0;
    $(document).ready(function(){

        //show the modules under the subject
        $("#subject").change(function(){
            if($("#subject").val() != ""){
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Questionbank/get_modules',
                    type: 'POST',
                    data: {
                            'parent_subject':$("#subject").val(),
                            'ci_csrf_token':csrfHash
                        },
                    success: function(response) {
                        var obj=JSON.parse(response);
                        $(".loader").hide();
                        $("#modules").html(obj['modules']);
                    }
                });
            }
        });

        //show the materails under the subject
        $("#modules").change(function(){
            if($("#modules").val() != ""){
                $(".loader").show();
                $.ajax({
                    url: '<?php echo base_url();?>backoffice/Questionbank/get_material_subjectId',
                    type: 'POST',
                    data: {
                            'id':$("#modules").val(),
                            'type':'study material',
                            'ci_csrf_token':csrfHash
                        },
                    success: function(response) {
                        var obj=JSON.parse(response);
                        $(".loader").hide();
                        $("#material").html(obj['material']);
                    }
                });
            }
        });

        $("#study_material_form").validate({
            highlight: function(element) {
                $(element).removeClass("error");
            },
            rules: {
                subject: "required",
                modules: "required",
                material: "required",
                description: "required"
            },
            messages: {
                subject: "Please select a subject",
                modules: "Please select a module",
                material: "Please select a material",
                material: "Please select a material"
            },
            submitHandler: function (form) {
                if(!check_video_files()){return false;}
                if(!check_audio_files()){return false;}
                for(instance in CKEDITOR.instances){
                    CKEDITOR.instances[instance].updateElement();
                }
               var study_notes = CKEDITOR.instances.study_notes.document.getBody().getText();
                if(file_validation_error && study_notes == ''){
                    $.toaster({priority:'warning',title:'Please provide a study material',message:''});
                    return false;
                }
                $(".save_study_material").prop('disabled',true);
                $(".loader").show();
                var data = new FormData(form);
                data.append('<?php echo $this->security->get_csrf_token_name();?>','<?php echo $this->security->get_csrf_hash();?>');
                jQuery.ajax({
                    url: "<?php echo base_url('backoffice/questionbank/save_study_material'); ?>",
                    type: "post",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if (obj.st == 1) {
                            $.toaster({priority:'success',title:'Message',message:obj.message});
                            $('.save_study_material').prop('disabled', false);
                            setTimeout(function () {
                                window.history.back();
                            }, 2000);
                        }else{
                            $('.save_study_material').prop('disabled', false);
                            $.toaster({priority:'warning',title:'Error',message:obj.message});
                        }
                        $(".loader").hide();
                    },
                    error: function () {
                        $(".loader").hide();
                        $('.save_study_material').prop('disabled', false);
                        $.toaster({priority:'danger',title:'Error',message:'There is an error while submit'});
                    }
                    //Your code for AJAX Ends
                });
            }
        });
    });

    function check_video_files(){
        $("#video_notes").html('');
        if($("#video_notes").val()!=''){
            var file=$("#video_notes").get(0).files[0].name;
            if(file){
                var file_size = $("#video_notes").get(0).files[0].size/1024;
                if(file_size < <?php echo VIDEO_LECTURE_SIZE; ?>){
                    var ext = file.split('.').pop().toLowerCase();
                    if($.inArray(ext,['mp4'])===-1){
                        $("#video_error").html('<br>Invalid file format only mp4 video files are accepted');
                        return false;
                    }
                    return true;
                }else{
                    $("#video_error").html('<br>Video file size is too large. Maximum allotted size <?php $size=VIDEO_LECTURE_SIZE;echo $size/(1024).' MB'; ?>');
                    return false;
                }
            }else{
                file_validation_error = 1;
                return true;
            }
        }else{
            file_validation_error = 1;
            return true;
        }
    }

    function check_audio_files(){
        $("#audio_error").html('');
        if($("#audio_notes").val()!=''){
            var file=$("#audio_notes").get(0).files[0].name;
            if(file){
                var file_size = $("#audio_notes").get(0).files[0].size/1024;
                if(file_size < <?php echo AUDIO_LECTURE_SIZE; ?>){
                    var ext = file.split('.').pop().toLowerCase();
                    if($.inArray(ext,['mp3'])===-1){
                        $("#audio_error").html('<br>Invalid file format only mp3 audio files are accepted');
                        return false;
                    }
                    return true;
                }else{
                    $("#audio_error").html('<br>Video file size is too large. Maximum allotted size <?php $size=AUDIO_LECTURE_SIZE;echo $size/(1024).' MB'; ?>');
                    return false;
                }
            }else{
                file_validation_error = 1;
                return true;
            }
        }else{
            file_validation_error = 1;
            return true;
        }
    }

    function delete_video_material(id){
        $.confirm({
            title: 'Notice',
            content: 'Are you sure you want to delete this video lecture',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Delete',
                    btnClass: 'btn-blue',
                    action: function() {
                        delete_file_material(id,'video');
                    }
                },
                cancel: function() {},
            }
        });
    }

    function delete_audio_material(id){
        $.confirm({
            title: 'Notice',
            content: 'Are you sure you want to delete this audio lecture',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Delete',
                    btnClass: 'btn-blue',
                    action: function() {
                        delete_file_material(id,'audio');
                    }
                },
                cancel: function() {},
            }
        });
    }

    function delete_file_material(id,type){
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/questionbank/delete_study_material'); ?>",
            type: "post",
            data: {'id':id,'type':type,'ci_csrf_token':csrfHash},
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.st == 1) {
                    $.toaster({priority:'success',title:'Message',message:obj.message});
                    if(type=='video'){$("#empty_video_message").html('No video lecture uploaded');}
                    if(type=='audio'){$("#empty_audio_message").html('No audio lecture uploaded');}
                }else{
                    $.toaster({priority:'warning',title:'Error',message:obj.message});
                }
                $(".loader").hide();
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'danger',title:'Error',message:'Technical error please try again later'});
            }
            //Your code for AJAX Ends
        });
    }
</script>
