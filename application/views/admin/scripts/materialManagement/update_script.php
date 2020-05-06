
    <script type="text/javascript">
        CKEDITOR.replace('question');
        CKEDITOR.replace('solution');
        <?php 
            if(!empty($data['options'])){ 
            $default = 1;
            while($default<=count($data['options'])){
        ?>
            CKEDITOR.replace("option<?php echo $default;?>");
        <?php $default++; }} ?>
        $(document).ready(function(){
            // $("#subject").change(function(){
            //     $(".loader").show();	   
            //     $.ajax({
            //         url: '<?php echo base_url();?>backoffice/Questionbank/get_module',
            //         type: 'POST',
            //         data: {
            //                 'subject':$("#subject").val(),
            //                 'ci_csrf_token':csrfHash
            //             },
            //         success: function(response) {
            //             $("#module").html(response);
            //         }
            //     });
            //     $(".loader").hide();	   
            // });
            var optionnumber = <?php echo DEFAULT_OPTIONS_COUNT;?>;
            $(".addmoreoptions").click(function(){
                optionnumber++;
                var editor = '<div class="form-group col-sm-6" id="optionContent'+optionnumber+'">'+
                                    '<input type="hidden" name="optionname[]" value="'+optionnumber+'">'+
                                    '<div class="title-header">'+
                                    ' &nbsp;&nbsp;Right answer? <input class="option-answer" type="checkbox" name="answer[]" value="'+optionnumber+'"><span title="Remove this option" id="removeoption'+optionnumber+'" class="remove-button"><i class="fa fa-times" aria-hidden="true"></i></span>'+
                                    '</div>'+
                                    '<textarea name="option[]" class="ckeditor" id="option'+optionnumber+'"></textarea>'+
                                '</div>';
                $(".option").append(editor);
                CKEDITOR.replace('option'+optionnumber);
			});

            $("#standalone").validate({
                highlight: function(element) {
                    $(element).removeClass("error");
                },
                rules: {
                    question_set: "required"
                },
                messages: {
                    question_set: "Please select a question set"
                },
                submitHandler: function (form) {
                    $(".saveQuestion").prop('disabled',true); 
                    $(".loader").show();	  
                    for (instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    } 
                    jQuery.ajax({
                        url: "<?php echo base_url('backoffice/questionbank/save_single_question'); ?>",
                        type: "post",
                        data: $(form).serialize(),
                        success: function (data) {
                            var obj = JSON.parse(data);
                            if (obj.st == 1) {
                                if($("#question_id").length == 0) {
                                    var question_set = $("#question_set").val();
                                    $('#standalone').trigger('reset');
                                    $("#question_set").val(question_set).prop('selected','selected');
                                    for (instance in CKEDITOR.instances) {
                                        CKEDITOR.instances[instance].setData('');
                                    } 
                                }
                                $.toaster({priority:'success',title:'Message',message:obj.message});
                                $('.saveQuestion').prop('disabled', false);
                            }else{
                                $('.saveQuestion').prop('disabled', false);  
                                $.toaster({priority:'warning',title:obj.message,message:''});
                            }
                            $(".loader").hide();
                        },
                        error: function () {
                            $(".loader").hide();
                            $('.saveQuestion').prop('disabled', false);   
                            $.toaster({priority:'danger',title:'Error',message:'Network error please try again later'});
                        }
                        //Your code for AJAX Ends
                    });
                }
            });
            
        });

		$(document).on('click', '.remove-button', function () {
			var idstr = $(this).attr('id');
			var id = idstr.substr(12, idstr.length);
            var editor = "option"+id;
            CKEDITOR.instances[editor].destroy();
			$("#optionContent"+id).remove();
		});
		
    </script>
 
