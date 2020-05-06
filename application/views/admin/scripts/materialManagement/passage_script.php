
    <script type="text/javascript">
        $(document).ready(function(){
            $('.existingpassage').hide();
            $('.newpassage').hide();
            $('#passage-view-div').hide();

            $("#paragraphform").validate({
                highlight: function(element) {
                    $(element).removeClass("error");
                },
                rules: {
                    question_set: "required",
                    passagetype: "required"
                },
                messages: {
                    question_set: "Please select a question set",
                    passagetype: "Please select a passage"
                },
                submitHandler: function (form) {
                    // event.preventDefault();
                    $(".loader").show();
                    for (instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                    jQuery.ajax({
                        url: "<?php echo base_url('backoffice/questionbank/save_passage'); ?>",
                        type: "post",
                        data: $(form).serialize(),
                        success: function (data) {
                            var obj = JSON.parse(data);
                            if (obj.st == 1) {
                                $('#paragraphform').trigger('reset');
                                for (instance in CKEDITOR.instances) {
                                    CKEDITOR.instances[instance].setData('');
                                }
                                $("#questionPageTag").html(obj.data);
                                $.toaster({priority:'success',title:'Notice',message:obj.message});
                            }else{
                                $('.saveParagraph').prop('disabled', false);
                                $.toaster({priority:'warning',title:obj.message,message:''});
                            }
                            $(".loader").hide();
                        },
                        error: function () {
                            $(".loader").hide();
                            $('.saveParagraph').prop('disabled', false);
                            $.toaster({priority:'danger',title:'Error',message:'Technical error please try again later'});
                            $(".loader").hide();
                        }
                        //Your code for AJAX Ends
                    });
                }
            });

        });
        
		$(document).on('change', '#question_set', function () {
            $('#passage-view-div').hide();
            get_passage_by_set_id();
        });
        
		$(document).on('change', '#passagetype', function () {
            $('#passage-view-div').hide();
			var passagetype = $(this).val();
            if(passagetype != ''){
                if(passagetype == 'existing'){
                    get_passage_by_set_id();
                    $('.existingpassage').show();
                    $('.newpassage').hide();
                }if(passagetype == 'new'){
                    $('.existingpassage').hide();
                    $('#passage-view-div').hide();
                    $('.newpassage').show();
                }
            }else{
                $('.existingpassage').hide();
                $('.newpassage').hide();
            }

        });

		$(document).on('change', '#passage_id', function () {
            $(".loader").show();
            jQuery.ajax({
                url: "<?php echo base_url('backoffice/questionbank/get_passage'); ?>",
                type: "post",
                data: {passage_id: $("#passage_id").val(),ci_csrf_token: csrfHash},
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.st == 1) {
                        $('#passage-view-div').show();
                        $("#passage-view").html(obj.data);
                    }else{
                        $.toaster({priority:'warning',title:'Error',message:obj.message});
                    }
                    $(".loader").hide();
                },
                error: function () {
                    $(".loader").hide();
                    $.toaster({priority:'danger',title:'Error',message:'Technical error please try again later'});
                    $(".loader").hide();
                }
                //Your code for AJAX Ends
            });
        });
        
        function get_passage_by_set_id(){
            $(".loader").show();
            jQuery.ajax({
                url: "<?php echo base_url('backoffice/questionbank/get_existing_passage'); ?>",
                type: "post",
                data: {question_set: $("#question_set").val(),ci_csrf_token: csrfHash},
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.st == 1) {
                        if(obj.data != ''){
                            var passages = '<option value="">Select an already saved passage</option>';
                            $.each(obj.data,function(i,v){
                                passages += '<option value="'+v.id+'">'+v.paragraph_content+'</option>';
                            });
                            $("#passage_id").html(passages);
                        }else{
                            $.toaster({priority:'warning',title:'No existing passage available please add a new one',message:''});
                        }
                    }else{
                        $.toaster({priority:'warning',title:'Error',message:obj.message});
                    }
                    $(".loader").hide();
                },
                error: function () {
                    $(".loader").hide();
                    $.toaster({priority:'danger',title:'Error',message:'Technical error please try again later'});
                    $(".loader").hide();
                }
                //Your code for AJAX Ends
            });
        }

    </script>

