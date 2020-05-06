<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6>Manage learning module</h6>
        <hr>
        <div class="addBtnPosition">
            <?php if (check_module_permission('create_learning_module')){?>
                <button class="btn btn-default add_row add_new_btn btn_add_call" data-toggle="modal" data-target="#myModal">Add learning module</button>
            <?php }?>
            <?php if (check_module_permission('schedule_learning_module')){?>
                <a class="btn btn-default add_row add_new_btn btn_add_call " href="<?php echo base_url();?>backoffice/schedule-learning-module">Schedule learning module</a>
            <?php }?>
        </div>
        <!-- Data Table Plugin Section Starts Here -->

        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th width="50"><?php echo $this->lang->line('sl_no');?></th>
                        <th><?php echo $this->lang->line('name');?></th>
                        <th>Course</th>
                        <th>Subject</th>
                        <th><?php echo $this->lang->line('approval_status');?></th>
                        <th><?php echo $this->lang->line('status');?></th>
                        <th width="12%"><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php $i=1; foreach($learningModule as $module){ ?>
                <tr>
                    <td>
                        <?php echo $i;?>
                    </td>
                    <td>
                        <?php echo $module->learning_module_name;?>
                    </td>
                    <td>
                        <?php echo $this->common->get_name_by_id('am_classes','class_name',array('class_id'=>$module->course));?>
                    </td>
                    <td>
                        <?php echo $this->common->get_name_by_id('mm_subjects','subject_name',array('subject_id'=>$module->subject));?>
                    </td>
                    <td>
                        <?php $approvalCheck = $this->common->get_approvalCheckExists($module->id); //show($approvalCheck);
                        if($approvalCheck != 0){ 
                        $AorR = $this->common->get_approvalAorR($module->id); //print_r($AorR);?>
                            <?php if($module->status == '100'){?>
                                <span class="btn mybutton mybuttonnew" onclick="view_approve_status('<?php echo $module->id; ?>')">Pending</span>
                            <?php }else if($module->status == '1' && $AorR == 2){?>
                                <span class="btn mybutton  mybuttonActive" onclick="view_approve_status('<?php echo $module->id; ?>')">Approved</span>
                            <?php }else if($module->status == '101' && $AorR == 3){?>
                                <span class="btn mybutton  mybuttonInactive" onclick="view_approve_status('<?php echo $module->id; ?>')">Rejected</span>
                            <?php }else if($AorR == 3){?>
                                <span class="btn mybutton  mybuttonInactive" onclick="view_approve_status('<?php echo $module->id; ?>')">Rejected</span>
                            <?php }else if($AorR == 2){?>
                                <span class="btn mybutton  mybuttonActive" onclick="view_approve_status('<?php echo $module->id; ?>')">Approved</span>
                        <?php }}?>
                    </td>
                    <td>
                        <?php 
                        if($module->status == '1'){?>
                            <span class="btn mybutton  mybuttonActive" onclick="edit_lm_status('<?php echo $module->id; ?>','<?php echo $module->status; ?>')">Active</span>
                        <?php }else if($module->status != '100'){ ?>
                            <span class="btn mybutton mybuttonInactive" onclick="edit_lm_status('<?php echo $module->id; ?>','<?php echo $module->status; ?>')">Inactive</span>
                        <?php }
                        ?>
                    </td>
                    <td>
                        <a class="btn btn-default option_btn " title="View" onclick="view_learning_module(<?php echo  $module->id; ?>);">
                            <i class="fa fa-eye "></i>
                        </a>
                        <?php if($module->status != '1'){
                            // $approvalCheck1 = $this->common->get_approvalCheckExistsEdit($module->id);
                            $approvalCheck1 = $this->common->get_approvalCheckExists($module->id); //show($approvalCheck1);
                            if($approvalCheck1 <= 1){
                                if (check_module_permission('create_learning_module')){ ?>
                                    <a class="btn btn-default option_btn " title="Edit" href="<?php echo base_url(); ?>backoffice/create-learning-module?id=<?php echo  $module->id;?>">
                                        <i class="fa fa-pencil "></i>
                                    </a>
                         <?php    }
                            
                        } }
                        if (check_module_permission('create_learning_module')){ ?>
                        <a class="btn btn-default option_btn mybuttonCopy copybutton" onclick="learning_module_copy('<?php echo $module->id; ?>','<?php echo $module->learning_module_name;?>','<?php echo $module->course; ?>','<?php echo $module->subject; ?>','<?php echo $module->learning_module_code; ?>')">
                            Copy
                        </a>
                        <?php }?>
                    </td>
                </tr>
                <?php $i++; } ?>
            </table>
        </div>
    </div>
</div>

<!--edit syllabus modal-->
<div id="view_study_material" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="body">
                <div class="row">
                </div>
            </div>
        </div>
    </div>
</div>
    <div id="myModal" class="modal fade modalCustom" role="dialog">
        <div class="modal-dialog" style="max-width: 767px">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create new learning module</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form autocomplete="off" id="learning_module_define" method="post" accept-charset="utf-8">
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <div class="row">
                         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                             <div class="form-group">
                                 <label>Learning module name<span class="req redbold">*</span></label>
                                 <input name="learning_module_name" id="learning_module_name" type="text" placeholder="Learning module name" class="form-control" />
                             </div>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                             <div class="form-group">
                                 <label>Select a course<span class="req redbold">*</span></label>
                                 <select id="course" name="course" class="form-control">
                                    <option value="">Select a course</option>
                                    <?php
                                        if(!empty($course)){
                                            foreach($course as $row){
                                                echo '<option value="'.$row->class_id.'">'.$row->class_name.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                             </div>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                             <div class="form-group">
                                <label>Select a subject</label><span class="req redbold">*</span></label>
                                <select id="subject" name="subject" class="form-control">
                                    <option value="">Select a subject</option>
                                </select>
                             </div>
                         </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <div class="custom-control custom-checkbox MargLeft25">
                                <input type="checkbox" name="approval_chk" class="custom-control-input" id="approval_chk" value="1">
                                <label class="custom-control-label" for="approval_chk"> Approval</label>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" id="approve_user_div">
                                        
                        </div>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn_save">Continue</button>
                        <button type="button" data-dismiss="modal" class="btn btn-default btn_cancel">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="view_learning_module" class="modal fade form_box modalCustom" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="text-align: center;" class="modal-title" id="learning_module_namem">Title</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="finishmodal_body">

                </div>
                <div class="modal-footer" id="finishmodal_footer"></div> 
            </div>
        </div>
    </div>
    <div id="view_approval_status" class="modal fade form_box modalCustom" role="dialog">
        <div class="modal-dialog ">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo $this->lang->line('status');?></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="career_form" method="post" enctype="multipart/form-data">
                    <div class="modal-body"> 
                        <div class="table-responsive"  id="view_approval_status_table">
                                        
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="copy_approval" class="modal fade form_box modalCustom" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Copy learning module</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- <form id="learning_module_copy" method="post" accept-charset="utf-8"> -->
                <form id="learning_module_copy" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <b>Do you want to create a copy of this?</b><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                        <!-- <div class="custom-control custom-checkbox MargLeft25"></div> -->
                            <div class="custom-control custom-checkbox MargLeft25">
                                <input type="checkbox" name="approval_chk" class="custom-control-input" id="approval_chk_cpy" value="1">
                                <label class="custom-control-label" for="approval_chk_cpy"> Approval</label>
                            </div>
                        </div>
                        <input name="moduleId" id="moduleId" type="hidden"/>
                        <input name="moduleName" id="moduleName" type="hidden"/>
                        <input name="moduleCourse" id="moduleCourse" type="hidden"/>
                        <input name="moduleSubject" id="moduleSubject" type="hidden"/>
                        <input name="learningModuleCode" id="learningModuleCode" type="hidden"/>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" id="approve_user_div_cpy">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn_save">Continue</button>
                    <button type="button" data-dismiss="modal" class="btn btn-default btn_cancel">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#learning_module_copy").validate({
            rules: {
                approve_users: "required"
            },
            messages: {
                approve_users: "Please select a user"
            },
            submitHandler: function (form) {
                $(".loader").show();
                $('.btn_save').prop('disabled', true);
                jQuery.ajax({
                    url: "<?php echo base_url('backoffice/Questionbank/learning_module_copy'); ?>",
                    type: "post",
                    data: $(form).serialize(),
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if (obj.st == 1) {
                            $.toaster({priority:'success',title:'Notice',message:obj.message});
                            setTimeout(function(){
                                redirect('backoffice/create-learning-module?id='+obj.data); 
                            },2000);
                        }else{
                            $.toaster({priority:'danger',title:'Sorry',message:obj.message});
                        }
                        $(".loader").hide();
                    },
                    error: function () {
                        alert('Error');
                    }
                });
            }
        });
        $("#course").change(function(){
            update_subject();
        });
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
        $("#learning_module_define").validate({
            rules: {
                learning_module_name: "required",
                course: "required",
                subject: "required",
                approve_users: "required"
            },
            messages: {
                learning_module_name: "Please give a name for this learning module",
                course: "Please select a course",
                subject: "Please select a subject",
                approve_users: "Please select a user"
            },
            submitHandler: function (form) {
                $(".loader").show();
                $('.btn_save').prop('disabled', true);
                jQuery.ajax({
                    url: "<?php echo base_url('backoffice/Questionbank/create_question_paper'); ?>",
                    type: "post",
                    data: $(form).serialize(),
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if (obj.st == 1) {
                            $('.btn_save').prop('disabled', false);
                            $.toaster({priority:'success',title:'Notice',message:obj.message});
                            $('#question_paper_define').trigger('reset');
                            setTimeout(function(){
                                redirect('backoffice/create-learning-module?id='+obj.data); 
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
    function view_learning_module(id, roleback = null){
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('backoffice/Questionbank/get_single_learning_module'); ?>",
            type: "post",
            data: {id:id,'ci_csrf_token':csrfHash},
            success: function (response) {
                var obj = JSON.parse(response);
                $("#learning_module_namem").html(obj.data.title);
                $("#finishmodal_body").html(obj.data.body);
                $("#finishmodal_title").html(obj.data.title);
                $("#finishmodal_footer").html('<button class="btn btn-info close" data-dismiss="modal">Cancel</button>');
                $(".loader").hide();
                $(".loader").hide();
                if(roleback == null){
                    $('#view_learning_module').modal({
                        show: true
                    });
                }
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'warning',title:'Error',message:'Technical error please try again later'});
            }
            //Your code for AJAX Ends
        });
    }
    function edit_lm_status(id, status) {
        $.confirm({
            title: 'Alert message',
            content: 'Do you want to change status?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.post('<?php echo base_url();?>backoffice/Questionbank/edit_learning_module_status/', {
                            id: id,status: status,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            $.toaster({priority:'success',title:'Success',message:'Status changed successfuly.!'});
                            $.ajax({
                                    url: '<?php echo base_url();?>backoffice/Questionbank/load_learning_module_ajax',
                                    type: 'POST',
                                        data: {
                                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                        },
                                        success: function(response) {  
                                        $('#syllabus_data').DataTable().destroy();
                                        $("#syllabus_data").html(response);
                                        $("#syllabus_data").DataTable({
                                            "searching": true,
                                            "bPaginate": true,
                                            "bInfo": true,
                                            "pageLength": 10,
                                            "aoColumnDefs": [
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [0]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [1]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [2]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [3]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [4]
                                                },
                                                {
                                                    'bSortable': false,
                                                    'aTargets': [5]
                                                }
                                            ]
                                        });    
                                        $(".loader").hide();
                                    } 
                                });  
                        });
                    }
                },
                cancel: function() {
                },
            }
        });
    }
    function learning_module_copy(id, name, course, subject, learningModuleCode) {
        $(".loader").show();
        $('#copy_approval').modal({
            show: true
        });
        $("#moduleId").val(id);
        $("#moduleName").val(name);
        $("#moduleCourse").val(course);
        $("#moduleSubject").val(subject);
        $("#learningModuleCode").val(learningModuleCode);
        $(".loader").hide();
    }
    $('#approval_chk').change(function() {
        $('#approve_user_div').empty();
        if(this.checked) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Questionbank/get_levelOne_user',
                type: 'POST',
                data: {'ci_csrf_token':csrfHash,'id':2},
                success: function(response) {
                    $('#approve_user_div').html(response);
                    $(".loader").hide();
                }
            });
        }else{
            $('#approve_user_div').empty();
        }
    });

    $('#approval_chk_cpy').change(function() {
        $('#approve_user_div_cpy').empty();
        if(this.checked) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Questionbank/get_levelOne_user',
                type: 'POST',
                data: {'ci_csrf_token':csrfHash,'id':2},
                success: function(response) {
                    $('#approve_user_div_cpy').html(response);
                    $(".loader").hide();
                }
            });
        }else{
            $('#approve_user_div_cpy').empty();
        }
    });
    function view_approve_status(id){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Employee/get_approve_status',
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
    function getQuestion(id, lmId){
        $("#finishmodal_body").empty();
        // view_learning_module(lmId, 1);
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Questionbank/get_questionLM',
            type: 'POST',
            data: {
                    'question_id':id,
                    'lmId':lmId,
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                $("#modal_body").html(obj.body);
                $("#finishmodal_body").html(obj.body);
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
    </script>