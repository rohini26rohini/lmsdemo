
<script type="text/javascript">
    
    $(document).ready(function(){
        $("#save_question_paper").hide();
        
        $(".addBtnPosition").click(function(){
            $('#generate_question_paper_define').trigger('reset');
            $("#exam_model_modules").html('');
            $("#question_paper_error").html('');
        });

        $("#generate_exam_model").change(function(){
            if($("#generate_exam_model").val()!=''){
                jQuery.ajax({
                    url: "<?php echo base_url('backoffice/exam/get_exam_model_modules'); ?>",
                    type: "post",
                    data: {
                            'exammodel':$("#generate_exam_model").val(),
                            'ci_csrf_token':csrfHash
                        },
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if (obj.st == 1) {
                            var html = '<table class="table table-sm table-bordered"><thead><tr style="color:white;font-family: none;background: #014e94;">'+
                                        '<th>Subject</th>'+
                                        '<th>Module</th>'+
                                        '<th>Section</th>'+
                                        '<th>Right answer mark</th>'+
                                        '<th>Wrong answer mark</th>'+
                                        '<th>Number of questions</th>'+
                                        '<th>Difficulty</th>'
                                        '</tr></thead><tbody><tr></tr>';
                            $.each( obj.data, function( key, value ) {
                                html += '<tr><td>'+value.subject_name+'</td>';
                                html += '<td>'+value.module_name+'</td>';
                                html += '<td>'+value.section_name+'</td>';
                                html += '<td>'+value.mark_per_question+'</td>';
                                html += '<td>'+value.negative_mark_per_question+'</td>';
                                html += '<td>'+value.no_of_questions+'</td>';
                                html += '<td><input type="hidden" name="exam_section_details_id[]" value="'+value.exam_section_details_id+'"><select name="difficulty[]">'+
                                            '<option value="1">Easy</option>'+
                                            '<option selected value="2">Medium</option>'+
                                            '<option value="3">Hard</option>'+
                                            '</select></td></tr>';
                            });
                            html += '</tbody></table>';
                            $("#exam_model_modules").html(html);
                            $("#preview_question_paper").html('');
                        }else{
                            $.toaster({priority:'danger',title:obj.message,message:''});
                        }
                        $(".loader").hide();
                    },
                    error: function () {
                        $(".loader").hide();
                        $('.btn_save').prop('disabled', false);
                        $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                    }
                });
            }else{
                $("#preview_question_paper").html('');
            }
        });

        $("#generate_question_paper_define").validate({
            rules: {
                generate_question_name: "required",
                generate_exam_model: "required"
            },
            messages: {
                generate_question_name: "Please give a name for this question paper",
                generate_exam_model: "Please select an exam model"
            },
            submitHandler: function (form) {
                $(".loader").show();
                $('.btn_save').prop('disabled', true);
                jQuery.ajax({
                    url: "<?php echo base_url('backoffice/exam/autogenerate_question_paper'); ?>",
                    type: "post",
                    data: $(form).serialize(),
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if (obj.st == 1) {
                            $('.btn_save').prop('disabled', false);
                            $.toaster({priority:'success',title:'Notice',message:obj.message});
                            $("#preview_question_paper").html(obj.data);
                            $("#save_question_paper").show();
                            window.location.hash = '#preview_question_paper';
                            $("#generate_question_name").prop('readOnly', true);
                            $("#generate_exam_model").prop('disabled', true);
                            $("#preview_question_paper").append('<input type="hidden" name="generate_exam_model" value="'+$("#generate_exam_model").val()+'">');
                        }else{
                            if(obj.st == 2){
                                $("#preview_question_paper").html(obj.data);
                                $("#generate_exam_model").prop('disabled', false);
                                window.location.hash = '#preview_question_paper';
                            }else{
                                $.toaster({priority:'danger',title:obj.message,message:''});
                            }
                            $("#save_question_paper").hide();
                            $('.btn_save').prop('disabled', false);
                        }
                        $(".loader").hide();
                    },
                    error: function () {
                        $(".loader").hide();
                        $('.btn_save').prop('disabled', false);
                        $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                    }
                });
            }
        });

        $("#save_question_paper").click(function(){
            $(".loader").show();	   
            $('#save_question_paper').prop('disabled', true);
            $.ajax({
                url: '<?php echo base_url();?>backoffice/exam/save_autogenerate_question_paper',
                type: 'POST',
                data: {'type':'save','ci_csrf_token':csrfHash},
                success: function(response) {
                    var obj = JSON.parse(response);
                        if (obj.st == 1) {
                            $('#save_question_paper').prop('disabled', true);
                            $.toaster({priority:'success',title:obj.message,message:''});
                            redirect('backoffice/exam-paper');
                        }else{
                            $.toaster({priority:'danger',title:obj.message,message:''});
                            $('#save_question_paper').prop('disabled', false);
                        }
                        $(".loader").hide();
                }
            });
        });

    });

    function get_question(id){
        $(".loader").show();	   
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Questionbank/get_question',
            type: 'POST',
            data: {
                    'question_id':id,
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                $("#modal_body").html(obj.body);
                $("#modal_title").html(obj.title);
                $(".loader").hide();
                $('#modal').modal('show');
            }
        });
    }
</script>
