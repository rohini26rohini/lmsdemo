<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6>Mentors Meeting List</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here --> 
        <!-- <div class="addBtnPosition">
            <button type="button" class="btn btn-default add_row add_new_btn btn_add_call mentorReferences " onClick="redirect('backoffice/mentors-meeting');">
                Mentors Meeting Schedule
            </button>  
        </div> -->
        <div class="addBtnPosition">
            <button class="btn btn-default add_row add_new_btn btn_add_call" data-toggle="modal" data-target="#add_feedback" onclick="formclear('add_feedback_form')">
               Feedback
            </button>
        </div>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th ><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('application.no');?></th>
                        <th ><?php echo $this->lang->line('student_name');?></th>
                        <th >Feedback</th>

                    </tr>
                </thead>
                <?php 
                $i=1;  
                foreach($studentArr as $stud){ ?>
                    <tr id="row_<?php echo $stud['details_id'];?>">
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td id="registration_number_<?php echo $stud['details_id'];?>">
                            <?php echo $stud['registration_number'];?>
                        </td>
                        <td id="name_<?php echo $stud['details_id'];?>">
                            <?php echo $stud['name'];?>
                        </td>
                        <td id="comment_<?php echo $stud['details_id'];?>">
                            <?php echo $stud['comment'];?>
                        </td>
                        <!-- <td>
                            <button  type="button" class="btn btn-default option_btn " onclick="get_details('<?php echo $stud['details_id'];?>')" title="Click here to view the details" data-toggle="modal" data-target="#view_meeting" style="color:blue;cursor:pointer;">
                                <i class="fa fa-eye "></i>
                            </button>
                            <button class="btn btn-default option_btn " onclick="get_meetingdata(<?php echo $stud['details_id'];?>)">
                                <i class="fa fa-pencil "></i>
                            </button>
                        </td> -->
                        
                    </tr>
                <?php $i++; } //} ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>



<!--add leave modal-->
<div id="add_feedback" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Feedback</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_feedback_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                         <input type="hidden" class ="exclude-status" name="meeting_id" value="<?php if(!empty($staff_id['meeting_id'])) {echo $staff_id['meeting_id']; }?>" />
                       <!-- <input type="hidden" class ="exclude-status" name="reporting_head" value="<?php if(!empty($staff_id['reporting_head'])) {echo $staff_id['reporting_head']; }?>" /> -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Student<span class="req redbold">*</span></label>
                                <select class="form-control" name="student_id" id="student_id">
                                <option value="All" selected="selected">All Students</option>
                                    <?php foreach($studentArr as $row){
                                        // $selected = '';
                                        // if($typeArr['id'] == $type['id']){
                                        //     $selected = 'selected="selected"';
                                        // }
                                        echo '<option value="'.$row['student_id'].'" >'.$row['name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Feedback<span class="req redbold">*</span></label>
                                <textarea class="form-control" name="comment" placeholder="Feedback"></textarea>
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
<?php $this->load->view("admin/scripts/mentors_meeting_script");?>
