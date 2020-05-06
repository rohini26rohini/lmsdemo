<script type="text/javascript">
    $(document).ready(function(){

        $("#savePreviewExamModel").validate({
            rules: {
                examname: "required"
            },
            messages: {
                examname: "Please enter an exam name"
            },
            submitHandler: function (form) {
                $(".loader").show();
                jQuery.ajax({
                    url: "<?php echo base_url('backoffice/exam/exam_model_save_preview'); ?>",
                    type: "POST",
                    data: {
                        'examname':$("#examname").val(),
                        'exam_definition_id':<?php echo $_GET['id'];?>,
                        'ci_csrf_token':csrfHash
                    },
                    success: function (response) {
                        var obj = JSON.parse(response);
                        if (obj.st == 1) {
                            $("#finishmodal_body").html(obj.data.body);
                            $("#finishmodal_title").html(obj.data.title);
                            $("#finishmodal_footer").html(obj.data.footer);
                            CKEDITOR.replace('instruction');
                            $('#finishmodal').modal('show');
                        }else{
                            $('.btn_save').prop('disabled', false);
                            $.toaster({priority:'danger',title:obj.message,message:''});
                        }
                        $(".loader").hide();
                    },
                    error: function () {
                        $(".loader").hide();
                        $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                    }
                    //Your code for AJAX Ends
                });
            }
        });

        $("#exam_finishmodal").validate({
            rules: {
                instruction: "required",
                calculator_available: "required"
            },
            messages: {
                instruction: "Please give an instruction to this exam model",
                calculator_available: "Is calculator required for this type of exam?"
            },
            submitHandler: function (form) {  
                for(instance in CKEDITOR.instances){
                    CKEDITOR.instances[instance].updateElement();
                } 
                var data = new FormData(form);
                data.append('exam_definition_id',<?php echo $_GET['id'];?>);
                data.append('examname',$("#examname").val());
                data.append('ci_csrf_token',csrfHash);
                finish_exam_model(data);
                for(instance in CKEDITOR.instances){
                    CKEDITOR.instances[instance].setData('');
                } 
            }
        });

    });

    function finish_exam_model(form){
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/exam/finish_exam_model_creation'); ?>",
            data: form,
            contentType: false,
            processData: false,
            type: "POST",
            success: function (response) {
                var obj = JSON.parse(response);
                if(obj.st == 1){
                    $.toaster({priority:'success',title:'Notice',message:obj.message});
                    redirect('backoffice/exam-template');
                }else{
                    $.toaster({priority:'danger',title:'Error',message:obj.message});
                }
                $(".loader").hide();
                
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
            }
            //Your code for AJAX Ends
        });
    }

    function getSection(id){
        if(!section[id]){
            $(".loader").show();
            jQuery.ajax({
                url: "<?php echo base_url('backoffice/exam/get_exam_section'); ?>",
                type: "GET",
                data: {'id':id},
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.st == 1) {
                        section[id] = 1;
                        $("#collapse"+id).html(obj.data);
                        $(".collapse").hide();
                        $("#collapse"+id).show();
                    }else{
                        $.toaster({priority:'danger',title:'Error',message:obj.message});
                    }
                    $(".loader").hide();
                },
                error: function () {
                    $(".loader").hide();
                    $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                }
                //Your code for AJAX Ends
            });
        }else{
            $(".collapse").hide();
            $("#collapse"+id).show();
        }
    }
</script>
     
