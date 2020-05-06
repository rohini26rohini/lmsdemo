
    <div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 " id="expandBoard">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <div class="white_card">
                    <h6>
                     <b>Edit learning module</b></h6>
                    <hr>
                    <div class="addBtnPosition">
                        <button class="btn btn-default add_row add_new_btn btn_add_call mybuttonActive" onclick="approve_entity_job(<?php echo $entityID;?>, <?php echo $jobId;?>, <?php echo $flowDetailId;?>);">
                            Approve
                        </button>
                        <button class="btn btn-default add_row add_new_btn btn_add_call mybuttonInactive" onclick="reject_entity_job(<?php echo $entityID;?>, <?php echo $jobId;?>, <?php echo $flowDetailId;?>);">
                            Reject
                        </button>
                        <button class="btn btn-default add_row add_new_btn btnExpand" id="btnExpand">
                            <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-default add_row add_new_btn btnCompress" id="btnCompress">
                            <i class="fa fa-compress" aria-hidden="true"></i>
                        </button>
                    </div>
                   <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <h6>Course <i class="fa fa-angle-double-right"></i> <?php echo $this->common->get_name_by_id('am_classes','class_name',array('class_id'=>$learningModule->course));?></h6>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <h6>Subject <i class="fa fa-angle-double-right"></i> <?php echo $this->common->get_name_by_id('mm_subjects','subject_name',array('subject_id'=>$learningModule->subject));?></h6>
                            </div>
                        </div>
                    </div>
                   <div class="row">
                        <div class="col-10">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" type="text" id="name" name="name" value="<?php echo $learningModule->learning_module_name; ?>">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label style="display: block">&nbsp;</label>
                                <button class="btn btn-info btn_save_name pull-right">Save</button>
                            </div>
                        </div>
                    </div>
                    <div class="relative" id="question_select_section">
                        <button class="btn btn-info btn_ques save_selected">
                            <i class="fa fa-angle-double-right"></i>
                        </button>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <!-- <p style="text-align:left;">
                                    <span style="color:green;font-weight:bold;font-size:15px;">E</span> - Easy &nbsp;&nbsp;&nbsp;
                                    <span style="color:blue;font-weight:bold;font-size:15px;">M</span> - Medium &nbsp;&nbsp;&nbsp;
                                    <span style="color:red;font-weight:bold;font-size:15px;">H</span> - Hard
                                </p> -->
                                <div class="table-responsive table_language padding_right_15" style="/*overflow: scroll;height: 500px;*/">
                                    <table class="table table-bordered table-striped table-sm" id="section_questions">
                                        <tr>
                                            <th colspan="3">Select Questions</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 50px;">Sl No.</th>
                                            <th>Question</th>
                                            <th></th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="table-responsive table_language padding_left_15" style="/*overflow: scroll;height: 500px;*/">
                                    <table class="table table-bordered table-striped table-sm" id="selected_questions">
                                        <tr>
                                            <th colspan="3">Selected Questions</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 50px;">Sl No.</th>
                                            <th>Question</th>
                                            <th style="width: 50px;">
                                            </th>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="reject_entity_job" class="modal fade modalCustom" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo $this->lang->line('approvel_reject');?></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="reject_entity_job_form" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="id" id="id"/>
                        <input type="hidden" name="jobId" id="jobId"/>
                        <input type="hidden" name="flowDetailId" id="flowDetailId"/>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">  
                            <div class="form-group"> 
                                <label><?php echo $this->lang->line('remark');?> <span class="req redbold">*</span></label>
                                <textarea name="remark" id="remark" class="form-control" rows="4" cols="50" style="height:unset!important"></textarea>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit">Save</button>
                        <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="modal" class="modal fade form_box modalCustom questionbank-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Title</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="modal_body"></div>
            </div>
        </div>
    </div>
    <div id="finishmodal" class="modal fade form_box modalCustom" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="text-align: center;" class="modal-title" id="finishmodal_title">Title</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="finishmodal_body"></div>
                <div class="modal-footer" id="finishmodal_footer"></div> 
            </div>
        </div>
    </div>
    <script type="text/javascript">
    function reject_entity_job(entityID,jobId,flowDetailId){
        formclear('reject_entity_job_form');
        $('#id').val(entityID);
        $('#jobId').val(jobId);
        $('#flowDetailId').val(flowDetailId);
        $('#reject_entity_job').modal({
            show: true
        });
    }
    $(document).ready(function(){
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
        var add_validation = 0;
        $("form#reject_entity_job_form").validate({
            rules: {
                remark: {required: true}
            },
            messages: {
                remark: {required: "Please enter a remark"}  
            },
            submitHandler: function(form) {
                $(".loader").show();
                add_validation = 1;
            }
        });
        $("form#reject_entity_job_form").submit(function(e) {
            //prevent Default functionality
            e.preventDefault();
            if (add_validation == 1) {
            $.ajax({
                    url: '<?php echo base_url();?>backoffice/Employee/reject_entity_job',
                    type: 'POST',
                    data: new FormData(this),
                    success: function(response) { 
                        add_validation = 0;
                        $('#reject_entity_job').modal('toggle');
                        $(".loader").hide();
                        var obj = JSON.parse(response);
                        if(obj.st == 1){
                            $.toaster({priority:'success',title:'Success',message:obj.msg}); 
                            setTimeout(function () {
                                window.location.href = "<?php echo base_url(); ?>approve-jobs/"+$('#flowDetailId').val(); 
                            }, 2000); 
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

    function get_question(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Employee/get_question',
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
            url: '<?php echo base_url();?>backoffice/Employee/save_selected_questions',
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
                url: '<?php echo base_url();?>backoffice/Employee/get_subject_questions',
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
    function delete_selected_question(id){
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/Employee/delete_selected_questions'); ?>",
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
            url: '<?php echo base_url();?>backoffice/Employee/save_learning_module_name',
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
                    // setTimeout(function(){
                    //     redirect('backoffice/learning-module'); 
                    // },1000);
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
    function approve_entity_job(entityID,jobId,flowDetailId){
        $.confirm({
            title: 'Alert message',
            content: 'Do you want to approve this material?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {   
                        $(".loader").show();	  
                        $.ajax({
                            url: '<?php echo base_url();?>backoffice/Employee/approve_entity_job',
                            type: 'POST',
                            data: {
                                    'entityID':entityID,
                                    'jobId':jobId,
                                    'flowDetailId':flowDetailId,
                                    'ci_csrf_token':csrfHash
                                },
                            success: function(response) {
                                var obj = JSON.parse(response);
                                if(obj.st == 1){
                                    $.toaster({priority:'success',title:'Success',message:obj.msg}); 
                                    setTimeout(function () {
                                        window.location.href = "<?php echo base_url(); ?>approve-jobs/"+flowDetailId; 
                                    }, 2000); 
                                }else if(obj.st == 2){
                                    $.toaster({priority:'warning',title:'Warning',message:obj.msg});
                                }else{
                                    $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                                }
                                $(".loader").hide();
                            }
                        });
                    }
                },
                cancel: function() {
                    //$.alert(' <strong>cancelled</strong>');
                },
            }
        }); 
    }
</script>