<div class="content_wrapper relative col-lg-10 col-md-10 col-sm-10 col-xs-12 ">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
             <div class="white_card">
        <h6><?php echo $this->lang->line('messenger');?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->     
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_gs" onclick="formclear('conversationform')">
        <?php echo $this->lang->line('start_new_conversation');?>
        </button>
        <div class="row">
            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="white_card ">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link personal_details active show" data-toggle="pill" href="#Unread">Unread</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link educational_qualification" data-toggle="pill" href="#Read" onclick="readTable('Read')">Read</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link work_experience" data-toggle="pill" href="#Archive" onclick="readTable('Archive')">Archive</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane  active" id="Unread">
                            <table class="table table-striped table-sm dataTable no-footer">
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <th>Subject</th>
                                        <th>Date &amp; Time</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php $id=$this->session->userdata('user_id'); if(!empty($conversations)){foreach($conversations as $conv){if($conv['status']==0 && $conv['archieved']==0){?>
                                        <tr>
                                            <td>
                                                <?php if($conv['from']==$id){$name = $conv['to_name'];}else{$name = $conv['from_name'];} ?>
                                                <?php echo $name;?>
                                            </td>
                                            <td><?php echo $conv['subject'];?></td>
                                            <td><?php echo date('M-d h:i a',strtotime($conv['started_date']));?></td>
                                            <td><button onClick='showMessage(<?php echo $conv['id']; ?>)' class="fa fa-eye" data-toggle="tooltip" title="View Message"></button></td>
                                        </tr>
                                    <?php }}} ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane  fade" id="Read">
                            
                        </div>
                        <div class="tab-pane  fade" id="Archive">
                            
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
    <div class="white_card" id="chat_box">
    
    </div>
    <div id="conversation_identifier"></div>
</div> 



<!--add discount modal-->
<div id="add_gs" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Start a new conversation</h4>
            </div>
            <form id="conversationform" method="post" enctype="multipart/form-data">
                <?php //echo form_open_multipart('backoffice/Messanger/start_conversation',array('id'=>'conversationform')) ?>
            <div class="modal-body">
                <div class="darkblue_card ">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('batch');?></label>
                            <select class="form-control" name="batch_id" id="filter_batch">
                                <option value=""><?php echo $this->lang->line('select'); ?>
                                </option>
                                <?php
                                foreach($batches as $row){ ?>
                                <option value="<?php echo $row['batch_id']; ?>"><?php echo $row['batch_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group studentconversation">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                            <label>To</label><span class="req redbold"> *</span>
                            <select required name='to[]' placeholder='Select another user' class='form-control multi-select' multiple="multiple" data-bv-notempty="true"
                                        data-bv-notempty-message="Please select user" id="students">
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Subject</label><span class="req redbold"> *</span>
                            <input type='text' name='subject' placeholder='Conversation Subject' class='form-control' data-bv-notempty="true"
                                        data-bv-notempty-message="The subject is required and cannot be empty">
                        </div>
                        <div class="form-group">
                            <label>Message</label><span class="req redbold"> *</span>
                            <textarea rows='7' name='message' placeholder='Type your message here' class='form-control' rows="10" data-bv-notempty="true"
                                        data-bv-notempty-message="The message is required and cannot be empty"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Attachment (Max File Size 5MB)</label>
                            <input type='file' name='attachment' id='userfile' class='form-control'><br>
                            <small>valid format: pdf,png,xlsx,docx,xls,jpg,doc & jpeg</small>
                            <div id="attachment_error" style="color:red;"> </div>
                        </div>
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <div class="col-lg-12 col-md-2 col-sm-2 col-xs-2">
                <!-- <a id='but_im' class="btn btn-success pull-right"> <span class="fa fa-paper-plane"></span></a> -->
                <button id='sub_im' type='submit' class="btn btn-success pull-right"> <span class="fa fa-paper-plane"></span></button>
            </div>
          </div>
          </form>
        </div>
    </div>
</div>

<script>
    $("#filter_batch").change(function(){
        var batch_id = $('#filter_batch').val();
        if (batch_id != "") {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Messanger/get_students_by_batchid',
                type: 'POST',
                data: {
                    batch_id: batch_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    // alert(response);
                     $("#students").html(response);
                    // $("#filter_batch").html("");
                    $(".loader").hide();
                }
            });
        }
    });


    $(".loader").hide();
    $("#chat_box").show();
    function showMessage(id){
        // alert(id);
        $(".loader").show();
        $("#chat_box").hide();
        var ci = "<input type='hidden' value='"+id+"' id='c_id'>";
        $.ajax({
            url: "<?php echo base_url('backoffice/Messanger/get_messages') ?>",
            type: "POST",
            data: {id:id,from:<?php echo $this->session->userdata['user_id']; ?>,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function (response)
            {
                readTable('Unread');
                // alert(response);
                $(".loader").hide();
                $("#chat_box").show();
                $("#chat_box").html(response);
                $("#conversation_identifier").html(ci);
            }
        });
    }
    function sendMessage(){
        var message = $('#message_text').val();
        var conv_id = $('#c_id').val();
        $.ajax({
                url: "<?php echo base_url('backoffice/Messanger/send_message') ?>",
                type: "POST",
                data: {message: message,conv_id:conv_id,from:<?php echo $this->session->userdata['user_id']; ?>,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function (data)
                {
                    $("#boxscroll").prepend(data);
                    $("#message_text").val('');
                }
            });
    }
    $(document).ready(function() {
        $("#but_im").hide();
        $('#userfile').bind('change', function () {
            if (this.files[0].size > 26214400) {
                $("#img_err").show();
                $("#img_err").html("<span style='color:red'>*Maximum allowed file size is 25MB. Please select another file</span>");
                $("#but_im").show();
                $("#sub_im").hide();
            } else {
                $("#img_err").html("");
                $("#but_im").hide();
                $("#sub_im").show();
                $("#img_err").hide();
            }
        });
        $('.multi-select').select2();
    });
    var add_validation = 0;
        $("form#conversationform").validate({
            rules: {
                "to[]": {required: true},
                "subject": {required: true},
                "message": {required: true}
            },
            messages: {
                "to[]": {required: "Please select a recipient"},
                "subject": {required: "Please enter a subject"},
                "message": {required: "Please enter a message"}
            },
            submitHandler: function(form) {
                $(".loader").show();
                add_validation = 1;
                if($("#userfile").val() != ''){
                    var file=$("#userfile").get(0).files[0].name;
                    if(file){
                        var file_size = $("#userfile").get(0).files[0].size/1024;
                        if(file_size < <?php echo UPLOAD_IMAGE_SIZE; ?>){
                            var ext = file.split('.').pop().toLowerCase();
                            if(ext!='pdf' && ext!='png' && ext!='xlsx' && ext!='docx' && ext!='doc' && ext!='xls' && ext!='jpg' && ext!='jpeg'){
                                $("#attachment_error").html('<br><span>Invalid file format</span>');
                                add_validation = 0;
                                $(".loader").hide();
                                return;
                            }
                            add_validation = 1;
                        }else{
                            $("#attachment_error").html('<br><span>file size is too large. Maximum allotted size <?php $size=UPLOAD_IMAGE_SIZE;echo $size/(1024).' MB'; ?></span>');
                            add_validation = 0;
                            $(".loader").hide();
                            return;
                        }
                    }
                }
            }
        });
        $("form#conversationform").submit(function(e) {
            e.preventDefault();
            // alert(add_validation);
            if (add_validation == 1) {
            $.ajax({
                    url: '<?php echo base_url();?>backoffice/Messanger/start_conversation',
                    type: 'POST',
                    data: new FormData(this),
                    success: function(response) {
                        add_validation = 0;
                        // alert(response);
                        $('#add_gs').modal('toggle');
                        $(".loader").hide();
                        var obj = JSON.parse(response);
                        if(obj.st == 1){
                            $.toaster({priority:'success',title:'Success',message:obj.msg});
                            $("#students").val('').trigger('change');
                            showMessage(obj.id); 
                        }else if(obj.st == 0){
                            $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                        }else if(obj.st == 2){
                            $.toaster({priority:'success',title:'Success',message:obj.msg});
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });
        function readTable(id){
            $(".loader").show();
            $.ajax({
                url: "<?php echo base_url('backoffice/Messanger/get_conversation') ?>",
                type: "POST",
                data: {id:id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function (response)
                {
                    // alert(response);
                    $(".loader").hide();
                    if(id == 'Read'){
                        $("#Read").html(response);
                    }
                    else if(id == 'Archive'){
                        $("#Archive").html(response);
                    }else if(id == 'Unread'){
                        $("#Unread").html(response);
                    }
                }
            });
        }
        function msgarchive(id){
            $(".loader").show();
            $.ajax({
                url: "<?php echo base_url('backoffice/Messanger/archive_conversation') ?>",
                type: "POST",
                data: {id:id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
                success: function (response){
                    $(".loader").hide();
                    var obj = JSON.parse(response);
                    if(obj.st == 1){
                        $.toaster({priority:'success',title:'Success',message:obj.msg});
                        readTable('Read');
                    }else if(obj.st == 0){
                        $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                    }
                }
            });
        }
</script>
<?php $this->load->view("admin/scripts/general_studies_script");?>

