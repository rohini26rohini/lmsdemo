
    <div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 " id="expandBoard">
    <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <div class="white_card">
                    <h6><?php echo $question_paper->exam_paper_name?> - Question Paper Setup</h6>
                    <hr><input type="hidden" name="entityID" id="entityID" value="<?php echo $entityID;?>">
                        <input type="hidden" name="jobId" id="jobId" value="<?php echo $jobId;?>">
                        <input type="hidden" name="flowDetailId" id="flowDetailId" value="<?php echo $flowDetailId;?>">
                    <div class="addBtnPosition">
                        <!-- <button class="btn btn-default add_row add_new_btn btn_add_call mybuttonActive" onclick="approve_entity_job(<?php echo $entityID;?>, <?php echo $jobId;?>, <?php echo $flowDetailId;?>);">
                            Approve
                        </button>
                        <button class="btn btn-default add_row add_new_btn btn_add_call mybuttonInactive" onclick="reject_entity_job(<?php echo $entityID;?>, <?php echo $jobId;?>, <?php echo $flowDetailId;?>);">
                            Reject
                        </button> -->
                        <button class="btn btn-default add_row add_new_btn btnExpand" id="btnExpand">
                            <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-default add_row add_new_btn btnCompress" id="btnCompress">
                            <i class="fa fa-compress" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">
                            <div class="form-group">
                                <label>Exam Model</label>
                                <input readonly type="text" class="form-control" value="<?php echo $question_paper->exam_name?>">
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                            <div class="form-group">
                                <label style="display: block">&nbsp;</label>
                                <button class="btn btn-info btn_save pull-right">Save & Preview</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Select an exam section</label>
                                <select id="section" class="form-control">
                                    <option value="">Select a section</option>
                                    <?php
                                        if(!empty($sections)){
                                            foreach($sections as $row){
                                                echo '<option value="'.$row->id.'">'.$row->section_name.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Select modules</label>
                                <select id="module" class="form-control">
                                    <option value="">Select a section</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="ques_stat">
                            <?php
                                if(!empty($sections)){
                                    foreach($sections as $row){
                                        echo '<span>'.$row->section_name.' : <span id="sectioncount'.$row->id.'">'.$row->count.'</span></span>';
                                    }
                                }
                            ?>
                            </p>
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
                        <input type="hidden" name="jobId" id="jobId1"/>
                        <input type="hidden" name="flowDetailId" id="flowDetailId1"/>
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
        <div class="modal-dialog" >
            <div class="modal-content" >
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
        $('#jobId1').val(jobId);
        $('#flowDetailId1').val(flowDetailId);
        $('#reject_entity_job').modal({
            show: true
        });
        $("#finishmodal").modal("hide");
    }
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
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Employee/save_preview_exam_paper',
                type: 'POST',
                data: {
                        'exam_id':<?php echo $_GET['id'];?>,
                        'entityID':$('#entityID').val(),
                        'jobId':$('#jobId').val(),
                        'flowDetailId':$('#flowDetailId').val(),
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
            url: '<?php echo base_url();?>backoffice/Employee/get_questions',
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
            url: '<?php echo base_url();?>backoffice/Employee/save_selected_questionsexam',
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
                                        '<th colspan="6">Select Questions</th>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<th width="5%">Sl No.</th>'+
                                        '<th width="10%">Difficulty</th>'+
                                        '<th width="10%">Passage availability</th>'+
                                        '<th>Question</th>'+
                                        '<th width="5%">Select</th>'+
                                    '</tr></thead>';
            var selected_questions = '<thead><tr>'+
                                        '<th colspan="6">Selected Questions</th>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<th width="5%">Sl No.</th>'+
                                        '<th width="10%">Difficulty</th>'+
                                        '<th width="10%">Passage availability</th>'+
                                        '<th>Question</th>'+
                                        '<th width="5%">Action</th>'+
                                    '</tr></thead>';
                jQuery.ajax({
                    url: "<?php echo base_url('backoffice/Employee/get_section_selected_questions'); ?>",
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
                                var passageId = 'No';
                                if(value.paragraph_id!=0){
                                    passageId = 'Yes';
                                }
                                var difficulty = '<td title="Difficulty-Medium" style="color:blue;font-weight:bold;font-size:12px;">Medium</td>';
                                if(value.question_difficulty==1){difficulty='<td title="Difficulty-Easy" style="color:green;font-weight:bold;font-size:12px;">Easy</td>'}
                                if(value.question_difficulty==3){difficulty='<td title="Difficulty-Hard" style="color:red;font-weight:bold;font-size:12px;">Hard</td>'}
                                section_questions = section_questions+'<tr>'+
                                                                            '<td>'+parseInt(parseInt(index)+parseInt(1))+'</td>'+
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
            url: "<?php echo base_url('backoffice/Employee/delete_selected_question'); ?>",
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
    // get_section_modules
    function finish_paper(){
        $(".loader").show();
        var user_id = $("#approve_users").val();
        if(user_id == undefined){
            user_id = 0;
        }
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/Employee/finish_question_paper'); ?>",
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
                url: "<?php echo base_url('backoffice/Employee/get_section_modules'); ?>",
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