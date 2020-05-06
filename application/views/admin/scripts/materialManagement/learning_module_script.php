<script type="text/javascript">
    $(document).ready(function(){
        // setTimeout(function(){ }, 2000);
        update_question_selection_fields();
        
        $('#question_select_section').hide();

        $("#course").change(function(){
            $('#question_select_section').hide();
            // alert("Don");
            update_subject();
        });
        
        $("#subject").change(function(){
            if($("#course").val()=="" || $("#subject").val()==""){
                $('#question_select_section').hide();
            }else{
                update_question_selection_fields();
                $('#question_select_section').show();
            }
        });

        $(".save_selected").click(function(){
            save_selected_questions();
        });
        $(".btn_save_name").click(function(){
            save_learning_module_name();
        });

        // $(".btn_save").click(function(){
        //     $(".loader").show();
        //     $.ajax({
        //         url: '<?php //echo base_url();?>backoffice/exam/save_preview_exam_paper',
        //         type: 'POST',
        //         data: {
        //                 'exam_id':<?php //echo $_GET['id'];?>,
        //                 'ci_csrf_token':csrfHash
        //             },
        //         success: function(response) {
        //             var obj = JSON.parse(response);
        //             if(obj.status!=1){
        //                 // $.toaster({priority:'danger',title:'Notice',message:obj.message});
        //             }
        //             $("#finishmodal_body").html(obj.data.body);
        //             $("#finishmodal_title").html(obj.data.title);
        //             $("#finishmodal_footer").html(obj.data.footer);
        //             $(".loader").hide();
        //             $('#finishmodal').modal('show');
        //         },
        //         error: function () {
        //             $(".loader").hide();
        //             $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
        //         }
        //     });
        // });

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
        // if($("#course").val()==''){
        //     $.toaster({priority:'danger',title:'Error',message:'Please select a section'});
        //     return false;
        // }
        if(selected.length===0){
            $.toaster({priority:'danger',title:'Error',message:'Please select atleast one question to add in this section'});
            return false;
        }
        $(".loader").show();	   
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Questionbank/save_selected_questions',
            type: 'POST',
            data: {
                    'question_ids':selected,
                    'unselected_question_ids':unselected,
                    // 'course_id':$("#course").val(),
                    'module_id':<?php echo $_GET['id'];?>,
                    // 'subject_id':$("#subject").val(),
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                if(obj.st==1){
                    update_question_selection_fields(1);
                    // $('#sectioncount'+$("#section").val()).html(obj.data);
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
        $(".loader").show();
        var section_questions = '<thead><tr>'+
                                    '<th colspan="6">Select Questions</th>'+
                                '</tr>'+
                                '<tr>'+
                                    '<th width="5%">Module</th>'+
                                    '<th width="10%">Difficulty</th>'+
                                    '<th width="10%">Passage availability.</th>'+
                                    '<th>Question</th>'+
                                    '<th width="5%">Select</th>'+
                                '</tr></thead>';
        var selected_questions = '<thead><tr>'+
                                    '<th colspan="6">Selected Questions</th>'+
                                '</tr>'+
                                '<tr>'+
                                    '<th width="5%">QstnNo.</th>'+
                                    '<th width="10%">Difficulty</th>'+
                                    '<th width="10%">Passage availability.</th>'+
                                    '<th>Question</th>'+
                                    '<th width="5%">Action</th>'+
                                '</tr></thead>';
            jQuery.ajax({
                url: "<?php echo base_url('backoffice/Questionbank/get_subject_questions'); ?>",
                type: "post",
                data: {learning_module_id:<?php echo $_GET['id']; ?>,
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
                            var passageId = 'No';
                            if(value.paragraph_id!=0){
                                passageId = 'Yes';
                            }
                            var difficulty = '<td title="Difficulty-Medium" style="color:blue;font-weight:bold;font-size:12px;">Medium</td>';
                            if(value.question_difficulty==1){difficulty='<td title="Difficulty-Easy" style="color:green;font-weight:bold;font-size:12px;">Easy</td>'}
                            if(value.question_difficulty==3){difficulty='<td title="Difficulty-Hard" style="color:red;font-weight:bold;font-size:12px;">Hard</td>'}
                            section_questions = section_questions+'<tr>'+
                                                                        '<td title="'+value.module_name+'">'+value.module_name+'</td>'+
                                                                        difficulty+
                                                                        '<td title="Passage Id">'+passageId+'</td>'+
                                                                        '<td><a href="javascript:return false;" onClick="get_question('+value.question_id+')">'+value.question_content+'</a></td>'+
                                                                        checkbox+
                                                                    '</tr>';
                        });
                        section_questions = section_questions+'</tbody>';
                        $.each(obj.questions.selected_questions, function( index, value ) {
                            var passageId = 'No';
                            if(value.paragraph_id!=0){
                                passageId = 'Yes';
                            }
                            var difficulty = '<td title="Difficulty-Medium" style="color:blue;font-weight:bold;font-size:12px;">Medium</td>';
                            if(value.question_difficulty==1){difficulty='<td title="Difficulty-Easy" style="color:green;font-weight:bold;font-size:12px;">Easy</td>'}
                            if(value.question_difficulty==3){difficulty='<td title="Difficulty-Hard" style="color:red;font-weight:bold;font-size:12px;">Hard</td>'}
                            selected_questions = selected_questions+'<tr id="question'+value.id+'">'+
                                                                        '<td>'+parseInt(value.question_number)+'</td>'+
                                                                        difficulty+
                                                                        '<td title="Passage Id">'+passageId+'</td>'+
                                                                        '<td><a href="javascript:return false;" onClick="get_question('+value.question_id+')">'+value.question_content+'</a></td>'+
                                                                        '<td>'+
                                                                            '<a onClick="delete_selected_question('+value.id+')" class="btn btn-default option_btn" title="Delete">'+
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
                    $('#question_select_section').show();
                },
                error: function () {
                    $(".loader").hide();
                    $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                }
                //Your code for AJAX Ends
            });
    }

    function update_question_selection_fields1(save=''){
        $(".loader").show();
        var section_questions = '<thead><tr>'+
                                    '<th colspan="6">Select Questions</th>'+
                                '</tr>'+
                                '<tr>'+
                                    '<th width="5%">Module</th>'+
                                    '<th width="10%">Difficulty</th>'+
                                    '<th width="10%">Passage availability.</th>'+
                                    '<th>Question</th>'+
                                    '<th width="5%">Select</th>'+
                                '</tr></thead>';
        var selected_questions = '<thead><tr>'+
                                    '<th colspan="6">Selected Questions</th>'+
                                '</tr>'+
                                '<tr>'+
                                    '<th width="5%">Module</th>'+
                                    '<th width="10%">Difficulty</th>'+
                                    '<th width="10%">Passage availability.</th>'+
                                    '<th>Question</th>'+
                                    '<th width="5%">Action</th>'+
                                '</tr></thead>';
            jQuery.ajax({
                url: "<?php echo base_url('backoffice/Questionbank/get_subject_questions'); ?>",
                type: "post",
                data: {learning_module_id:<?php echo $_GET['id']; ?>,
                        'ci_csrf_token':csrfHash
                    },
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.st == 1) {
                        section_questions = section_questions+'<tbody>';
                        selected_questions = selected_questions+'<tbody>';
                        $.each(obj.questions.selected_question, function( index, value ) {
                            if(value.selected==1){
                                var checkbox='<td><input name="selected_question" type="checkbox" checked="true" value="'+value.question_id+'" id="selected_question'+value.question_id+'"></td>';
                            }else{
                                var checkbox='<td><input name="selected_question" class="save_selected" type="checkbox" value="'+value.question_id+'" id="selected_question'+value.question_id+'"></td>';
                            }
                            var passageId = 'Non passaged';
                            if(value.paragraph_id!=0){
                                passageId = 'Passage-'+value.paragraph_id;
                            }
                            var difficulty = '<td title="Difficulty-Medium" style="color:blue;font-weight:bold;font-size:12px;">Medium</td>';
                            if(value.question_difficulty==1){difficulty='<td title="Difficulty-Easy" style="color:green;font-weight:bold;font-size:12px;">Easy</td>'}
                            if(value.question_difficulty==3){difficulty='<td title="Difficulty-Hard" style="color:red;font-weight:bold;font-size:12px;">Hard</td>'}
                            section_questions = section_questions+'<tr>'+
                                                                        '<td title="'+value.module_name+'">'+value.module_name+'</td>'+
                                                                        difficulty+
                                                                        '<td title="Passage Id">'+passageId+'</td>'+
                                                                        '<td><a href="javascript:return false;" onClick="get_question('+value.question_id+')">'+value.question_content+'</a></td>'+
                                                                        checkbox+
                                                                    '</tr>';
                        });
                        section_questions = section_questions+'</tbody>';
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
                    $('#question_select_section').show();
                },
                error: function () {
                    $(".loader").hide();
                    $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
                }
                //Your code for AJAX Ends
            });
    }

    function delete_selected_question(id){
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/Questionbank/delete_selected_question'); ?>",
            type: "post",
            data: {id:id,module_id:<?php echo $_GET['id'];?>,'ci_csrf_token':csrfHash},
            success: function (data) {
                // alert(data);
                var obj = JSON.parse(data);
                $("#question"+id).remove();
                $("#examquestion"+id).remove();
                $('#selected_question'+obj.data).prop('checked',false);
                update_question_selection_fields();
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

    // function finish_paper(){
    //     $(".loader").show();
    //     jQuery.ajax({
    //         url: "<?php echo base_url('backoffice/exam/finish_question_paper'); ?>",
    //         type: "post",
    //         data: {exam_id:<?php //echo $_GET['id'];?>,'ci_csrf_token':csrfHash},
    //         success: function (data) {
    //             var obj = JSON.parse(data);
    //             redirect('backoffice/exam-paper');
    //             $(".loader").hide();
    //         },
    //         error: function () {
    //             $(".loader").hide();
    //             $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
    //         }
    //         //Your code for AJAX Ends
    //     });
    // }

    function update_subject(){
        // alert("Don 1");
        if($("#course").val()!=""){
            $(".loader").show();
            jQuery.ajax({
                url: "<?php echo base_url('backoffice/Questionbank/get_subject'); ?>",
                type: "post",
                data: {course_id:$("#course").val(),'ci_csrf_token':csrfHash},
                success: function (data) {
                    var obj = JSON.parse(data);
                    if(obj.st==1){
                        var html = '<option value="">Select a subject</option>';
                        $.each(obj.data, function( key, value ) {
                            html += '<option value="'+value.subject_id+'">'+value.subject_name+'</option>';
                        });
                        $("#subject").html(html);
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
    function save_learning_module_name(){
        if($("#name").val()==''){
            $.toaster({priority:'danger',title:'Error',message:'Please enter a name'});
            return false;
        }
        $(".loader").show();	   
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Questionbank/save_learning_module_name',
            type: 'POST',
            data: {
                    'name':$("#name").val(),
                    'module_id':<?php echo $_GET['id'];?>,
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                // alert(response);
                var obj = JSON.parse(response);
                if(obj.st==1){
                    $.toaster({priority:'success',title:'Notice',message:obj.msg});
                    setTimeout(function(){
                        redirect('backoffice/learning-module'); 
                    },1000);
                }else{
                    $.toaster({priority:'danger',title:'Error',message:obj.msg});
                }
                $(".loader").hide();
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
            }
        });
    }
    
</script>
     
