<script type="text/javascript">
    $(document).ready(function(){

        $('#question_select_section').hide();

        $("#section").change(function(){
            $('#question_select_section').hide();
            update_section_modules();
        });
        
        $("#module").change(function(){
            if($("#section").val()=="" || $("#module").val()==""){
                $('#question_select_section').hide();
            }else{
                update_question_selection_fields();
                $('#question_select_section').show();
            }
        });

        $(".save_selected").click(function(){
            save_selected_questions();
        });

        $(".btn_save").click(function(){
            preview_exam_paper();
        });

        $(".close_btn").click(function () {
            $(this).hide();
            $("#chartBlock").removeClass(("show"));
        });

    });

    function preview_exam_paper(){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/exam/save_preview_exam_paper',
            type: 'POST',
            data: {
                    'exam_id':<?php echo $_GET['id'];?>,
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                if(obj.status!=1){
                    // $.toaster({priority:'danger',title:'Notice',message:obj.message});
                }
                $("#finishmodal_body").html(obj.data.body);
                $("#finishmodal_title").html(obj.data.title);
                $("#finishmodal_footer").html(obj.data.footer);
                $(".loader").hide();
                $('#finishmodal').modal('show');
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
            }
        });
    }

    function reorder_paper(){
        $(".loader").show();
        $('#finishmodal').modal('hide');
        $.ajax({
            url: '<?php echo base_url();?>backoffice/exam/reorder_exam_paper',
            type: 'POST',
            data: {
                    'exam_id':<?php echo $_GET['id'];?>,
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                $('#questions_list').html(obj.data);
                $('.exam_paper_questions').dragndrop();
                $("#chartBlock").addClass("show");
                $(".close_btn").fadeIn("200");
                $(".loader").hide();
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
            }
        });
    }

    function save_reordered_questions(){
        var exam_paper_question_id = $("input[name='exam_paper_question_id[]']").map(function(){return $(this).val();}).get();
        console.log(exam_paper_question_id);
        $(".loader").show();
        $('#finishmodal').modal('show');
        $.ajax({
            url: '<?php echo base_url();?>backoffice/exam/save_reordered_questions_exam_paper',
            type: 'POST',
            data: {
                    'exam_id':<?php echo $_GET['id'];?>,
                    'exam_paper_question_id':exam_paper_question_id,
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                $("#chartBlock").removeClass(("show"));
                preview_exam_paper();
                $(".loader").hide();
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
            }
        });
    }

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
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
            }
        });
    }

    function save_selected_questions(){ 
        var selected = [];
        var unselected = [];
        $("input:checkbox[name=selected_question]:checked").each(function(){
            selected.push($(this).val());
        });
        $("input:checkbox[name=selected_question]").each(function(){
            if(selected != ''){
                if($.inArray($(this).val(),selected) == -1){
                    unselected.push($(this).val());
                }
            }
        });
        if($("#section").val()==''){
            $.toaster({priority:'danger',title:'Error',message:'Please select a section'});
            return false;
        }
        if(selected.length===0){
            $.toaster({priority:'danger',title:'Error',message:'Please select atleast one question to add in this section'});
            return false;
        }
        $(".loader").show();	   
        $.ajax({
            url: '<?php echo base_url();?>backoffice/exam/save_selected_questions',
            type: 'POST',
            data: {
                    'question_ids':selected,
                    'unselected_question_ids':unselected,
                    'exam_id':<?php echo $_GET['id'];?>,
                    'section_id':$("#section").val(),
                    'module_id':$("#module").val(),
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                if(obj.st==1){
                    update_question_selection_fields(1);
                    $('#sectioncount'+$("#section").val()).html(obj.data);
                    $.toaster({priority:'success',title:'Notice',message:obj.message});
                }else{
                    $.toaster({priority:'danger',title:'Error',message:obj.message});
                }
                $(".loader").hide();
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
            }
        });
    }

    function update_question_selection_fields(save=''){
        if($("#section").val()!='' && $("#module").val()!=''){
            $(".loader").show();
            var section_questions = '<thead><tr>'+
                                        '<th colspan="7">Select Questions</th>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<th width="5%">Difficulty</th>'+
                                        '<th width="5%">Type</th>'+
                                        '<th width="5%">Passage availability</th>'+
                                        '<th>Question set</th>'+
                                        '<th>Question</th>'+
                                        '<th width="5%">Select</th>'+
                                    '</tr></thead>';
            var selected_questions = '<thead><tr>'+
                                        '<th colspan="6">Selected Questions</th>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<th width="5%">Sl No.</th>'+
                                        '<th width="5%">Difficulty</th>'+
                                        '<th width="5%">Type</th>'+
                                        '<th width="5%">Passage availability</th>'+
                                        '<th>Question</th>'+
                                        '<th width="5%">Action</th>'+
                                    '</tr></thead>';
                jQuery.ajax({
                    url: "<?php echo base_url('backoffice/exam/get_section_selected_questions'); ?>",
                    type: "post",
                    data: {section_id:$("#section").val(),
                            module_id:$("#module").val(),
                            exam_id:<?php echo $_GET['id'];?>,
                            'ci_csrf_token':csrfHash
                        },
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if (obj.st == 1) {
                            section_questions = section_questions+'<tbody>';
                            selected_questions = selected_questions+'<tbody>';
                            $.each(obj.questions.questions, function( index, value ) {
                                if(value.selected==1){
                                    var checkbox='<td><input name="selected_question" type="checkbox" checked="true" value="'+value.question_id+'" id="selected_question'+value.question_id+'"></td>';
                                }else{
                                    var checkbox='<td><input name="selected_question" class="save_selected" type="checkbox" value="'+value.question_id+'" id="selected_question'+value.question_id+'"></td>';
                                }
                                var passageId = '<td title="Non passaged"><b>No</b></td>';
                                if(value.paragraph_id!=0){
                                    passageId = '<td title="Passaged"><b>Yes</b></td>';
                                }
                                var question_type = '';
                                if(value.question_type==1){
                                    var question_type = '<td title="Objective"><b>Objective</b></td>';
                                }
                                if(value.question_type==2){
                                    var question_type = '<td title="Descriptive"><b>Descriptive</b></td>';
                                }
                                var difficulty = '<td title="Difficulty-Medium" style="color:blue;font-weight:bold;font-size:12px;">Medium</td>';
                                if(value.question_difficulty==1){difficulty='<td title="Difficulty-Easy" style="color:green;font-weight:bold;font-size:12px;">Easy</td>'}
                                if(value.question_difficulty==3){difficulty='<td title="Difficulty-Hard" style="color:red;font-weight:bold;font-size:12px;">Hard</td>'}
                                section_questions = section_questions+'<tr>'+
                                                                            // '<td>'+parseInt(parseInt(index)+parseInt(1))+'</td>'+
                                                                            difficulty+
                                                                            question_type+
                                                                            passageId+
                                                                            '<td title="'+value.question_set_name+'">'+value.question_set_name+'</td>'+
                                                                            '<td><a href="javascript:return false;" onClick="get_question('+value.question_id+');">'+value.question_content+'</a></td>'+
                                                                            checkbox+
                                                                        '</tr>';
                            });
                            section_questions = section_questions+'</tbody>';
                            $.each(obj.questions.selected_questions, function( index, value ) {
                                var passageId = '<td title="Non passaged"><b>No</b></td>';
                                if(value.paragraph_id!=0){
                                    passageId = '<td title="Passaged"><b>Yes</b></td>';
                                }
                                var question_type = '';
                                if(value.question_type==1){
                                    var question_type = '<td title="Objective"><b>Objective</b></td>';
                                }
                                if(value.question_type==2){
                                    var question_type = '<td title="Descriptive"><b>Descriptive</b></td>';
                                }
                                var difficulty = '<td title="Difficulty-Medium" style="color:blue;font-weight:bold;font-size:12px;">Medium</td>';
                                if(value.question_difficulty==1){difficulty='<td title="Difficulty-Easy" style="color:green;font-weight:bold;font-size:12px;">Easy</td>'}
                                if(value.question_difficulty==3){difficulty='<td title="Difficulty-Hard" style="color:red;font-weight:bold;font-size:12px;">Hard</td>'}
                                selected_questions = selected_questions+'<tr id="question'+value.id+'">'+
                                                                            '<td>'+parseInt(value.question_number)+'</td>'+
                                                                            difficulty+
                                                                            question_type+
                                                                            passageId+
                                                                            '<td><a href="javascript:return false;" onClick="get_question('+value.question_id+');">'+value.question_content+'</a></td>'+
                                                                            '<td>'+
                                                                                '<a onClick="delete_selected_question('+value.id+')" title="Delete" class="btn btn-default option_btn">'+
                                                                                    '<i class="fa fa-trash-o"></i>'+
                                                                                '</a>'+
                                                                            '</td>'+
                                                                        '</tr>';
                            });
                            selected_questions = selected_questions+'</tbody>';
                            if(save==''){
                                $("#section_questions").html(section_questions);
                            }
                            $("#selected_questions").html(selected_questions);
                        }else{
                            $("#section_questions").html(section_questions);
                            $("#selected_questions").html(selected_questions);
                        }
                        $(".loader").hide();
                        if(save==''){
                            $("#section_questions").dataTable().fnDestroy()
                            $('#section_questions').DataTable({
                                "language": {
                                    "infoEmpty": "No records available.",
                                }
                            });
                        }
                        $("#selected_questions").dataTable().fnDestroy()
                        $('#selected_questions').DataTable({
                            "language": {
                                "infoEmpty": "No records available.",
                            }
                        });
                    },
                    error: function () {
                        $(".loader").hide();
                        $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                    }
                    //Your code for AJAX Ends
                });
        }
    }

    function delete_selected_question(id){
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/exam/delete_selected_question'); ?>",
            type: "post",
            data: {id:id,exam_id:<?php echo $_GET['id'];?>,section_id:$("#section").val(),'ci_csrf_token':csrfHash},
            success: function (data) {
                var obj = JSON.parse(data);
                $("#question"+id).remove();
                $("#examquestion"+id).remove();
                $('#selected_question'+obj.data).prop('checked',false);
                update_question_selection_fields();
                $('#sectioncount'+$("#section").val()).html(obj.count);
                $.toaster({priority:'Success',title:'Notice',message:'Question removed'});
                $(".loader").hide();
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
            }
            //Your code for AJAX Ends
        });
    }

    function finish_paper(){
        $(".loader").show();
        var user_id = $("#approve_users").val();
        if(user_id == undefined){
            user_id = 0;
        }
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/exam/finish_question_paper'); ?>",
            type: "post",
            data: {exam_id:<?php echo $_GET['id'];?>,'ci_csrf_token':csrfHash, user_id: user_id},
            success: function (data) {
                var obj = JSON.parse(data);
                redirect('backoffice/exam-paper');
                $(".loader").hide();
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
            }
            //Your code for AJAX Ends
        });
    }

    function update_section_modules(){
        if($("#section").val()!=""){
            $(".loader").show();
            jQuery.ajax({
                url: "<?php echo base_url('backoffice/exam/get_section_modules'); ?>",
                type: "post",
                data: {section_id:$("#section").val(),'ci_csrf_token':csrfHash},
                success: function (data) {
                    var obj = JSON.parse(data);
                    if(obj.st==1){
                        var html = '<option value="">Select a module</option>';
                        $.each(obj.data, function( key, value ) {
                            html += '<option value="'+value.module_id+'">'+value.module_name+' ('+value.mark+' Mark per question)'+'</option>';
                        });
                        $("#module").html(html);
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
    }
    var approval_flag=1;
    function approval_chk(){ 
        if(approval_flag) {
            approval_flag=0;
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Exam/get_levelOne_user',
                type: 'POST',
                data: {'ci_csrf_token':csrfHash,'id':3},
                success: function(response) {
                    $('.approve_user_div').html(response);
                    $(".loader").hide();
                }
            });
        }else{
            approval_flag=1;
            $('.approve_user_div').empty();
        }
    }
</script>
     
