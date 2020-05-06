
    <script type="text/javascript">
    
    $(document).ready(function(){
        $(".addBtnPosition").click(function(){
            $('#generate_exam_model').trigger('reset');
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
                                            '<option value="0">Easy</option>'+
                                            '<option selected value="1">Medium</option>'+
                                            '<option value="2">Hard</option>'+
                                            '</select></td></tr>';
                            });
                            html += '</tbody></table>';
                            $("#exam_model_modules").html(html);
                            $("#question_paper_error").html('');
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
                // $(".loader").show();
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
                            $('#question_paper_define').trigger('reset');
                            $("#question_paper_error").html('');
                            console.log(obj.data);
                        }else{
                            if(obj.st == 2){
                                $("#question_paper_error").html(obj.data);
                            }
                            $('.btn_save').prop('disabled', false);
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
            }
        });

        $("#question_paper_define").validate({
            rules: {
                question_name: "required",
                exam_model: "required"
            },
            messages: {
                question_name: "Please give a name for this question paper",
                exam_model: "Please select an exam model"
            },
            submitHandler: function (form) {
                $(".loader").show();
                $('.btn_save').prop('disabled', true);
                jQuery.ajax({
                    url: "<?php echo base_url('backoffice/exam/create_question_paper'); ?>",
                    type: "post",
                    data: $(form).serialize(),
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if (obj.st == 1) {
                            $('.btn_save').prop('disabled', false);
                            $.toaster({priority:'success',title:'Notice',message:obj.message});
                            $('#question_paper_define').trigger('reset');
                            setTimeout(function(){
                                redirect('backoffice/question-paper?id='+obj.data); 
                            },2000);
                        }else{
                            $('.btn_save').prop('disabled', false);
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
            }
        });
    });
    
        function delete_question_paper(id) {
            $.confirm({
                title: 'Do you want to delete this question paper',
                content:'',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Proceed',
                        btnClass: 'btn-blue',
                        action: function() {
                            $(".loader").show();
                            $.post('<?php echo base_url();?>backoffice/exam/delete_question_paper/', {
                                question_paper_id: id,
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            }, function(data) {
                                var obj=JSON.parse(data);
                                if (obj['st'] == true) {
                                    $("#paper"+id).remove();
                                    $.alert('Successfully <strong>Deleted..!</strong>');
                                }else{
                                    $.alert('<strong>Invalid Request</strong>');  
                                }
                                $(".loader").hide();
                            });
                        }
                    },
                    cancel: function() { },
                }
            });
        }

        function view_question_paper(id, roleback = null) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/exam/save_preview_exam_paper',
                type: 'POST',
                data: {
                        'exam_id':id,
                        'view':1,
                        'ci_csrf_token':csrfHash
                    },
                success: function(response) {
                    var obj = JSON.parse(response);
                    $("#finishmodal_body").html(obj.data.body);
                    $("#finishmodal_title").html('View question paper');
                    $("#finishmodal_footer").html('<button class="btn btn-info close" data-dismiss="modal">Cancel</button>');
                    $(".loader").hide();
                    if(roleback == null){
                        $('#finishmodal').modal('show');
                    }
                },
                error: function () {
                    $(".loader").hide();
                    $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                }
            });
        }
        function getQuestionEP(id, epId){
            $("#finishmodal_body").empty();
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/exam/get_questionEP',
                type: 'POST',
                data: {
                        'question_id':id,
                        'epId':epId,
                        'ci_csrf_token':csrfHash
                    },
                success: function(response) {
                    var obj = JSON.parse(response);
                    // $("#modal_body").html(obj.body);
                    $("#finishmodal_body").html(obj.body);
                    // $("#modal_title").html(obj.title);
                    $(".loader").hide();
                    // $('#modal').modal('show');
                },
                error: function () {
                    $(".loader").hide();
                    $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                }
            });
        }
        function view_approve_status(id){
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/exam/get_approve_status',
                type: 'POST',
                data: {
                    id : id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    $("#view_approval_status_table").html(response);
                    $('#view_approval_status').modal({
                        show: true
                    });
                    $(".loader").hide();
                }
            });
        }
    </script>
