<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6>Upcoming Exams & Notifications</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->     
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_exams" onclick="formclear('add_exams_form')">
            Add Upcoming Exams & Notifications
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th><?php echo $this->lang->line('school');?></th>
                        <th>Exam</th>
                        <th>Post</th>
                        <th>Vacancy</th>
                        <th><?php echo $this->lang->line('start_date');?></th>
                        <th><?php echo $this->lang->line('end_date');?></th>
                        <th><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($examArr as $row){ 
                ?>
                    <tr id="row_<?php echo $row['notification_id'];?>">
                        <td >
                            <?php echo $i;?>
                        </td>
                        <td id="school_<?php echo $row['notification_id'];?>">
                            <?php echo $row['school_name'];?>
                        </td>
                        <td id="name_<?php echo $row['notification_id'];?>">
                            <?php echo $row['name'];?>
                        </td>
                        <td id="post_<?php echo $row['notification_id'];?>">
                            <?php echo $row['post'];?>
                        </td>
                        <td id="vacancy_<?php echo $row['notification_id'];?>">
                            <?php echo $row['vacancy'];?>
                        </td>
                        <td id="start_date_<?php echo $row['notification_id'];?>">
                            <?php echo $row['start_date'];?>
                        </td>
                        <td id="end_date_<?php echo $row['notification_id'];?>">
                            <?php echo $row['end_date'];?>
                        </td>
                        <td>
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_examdata(<?php echo $row['notification_id'];?>)">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_exam(<?php echo $row['notification_id'];?>)">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                <?php $i++; } ?>
            </table>
        </div>
    <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<!--add Upcoming Exams & Notifications modal-->
<div id="add_exams" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Upcoming Exams & Notifications</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_exams_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('school');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="school_id">
                                    <option value="">Select School</option>
                                    <?php foreach($schoolArr as $school){
                                        echo '<option value="'.$school['school_id'].'" >'.$school['school_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Exam<span class="req redbold">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Exam" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Description<span class="req redbold">*</span></label>
                                <textarea class="form-control" name="description" placeholder="Description" autocomplete="off"></textarea>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Post</label>
                                <input type="text" name="post" class="form-control" placeholder="Post" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Stream</label>
                                <input type="text" name="stream" class="form-control" placeholder="Stream" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Pay Scale</label>
                                <input type="text" name="pay_scale" class="form-control nospecialChar"  placeholder="Pay Scale" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Vacancy</label>
                                <input type="text" value="0" name="vacancy" class="form-control numbersOnly" placeholder="Vacancy" maxlength="3" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Start Date<span class="req redbold">*</span></label>
                                <input class="form-control calendarclass startdate" type="text" name="start_date" id="start_date" placeholder="Start Date" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>End Date<span class="req redbold">*</span></label>
                                <input class="form-control calendarclass" type="text" name="end_date" id="end_date"  placeholder="End date" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Online Application Link</label>
                                <input class="form-control" type="text" name="file" placeholder="Online Application Link" autocomplete="off">
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

<!--edit Upcoming Exams & Notifications modal-->
<div id="edit_exams" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Upcoming Exams & Notifications</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form enctype="multipart/form-data" id="edit_exams_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="notification_id" id="notification_id" />
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('school');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="school_id" id="edit_school_id">
                                    <option value="">Select School</option>
                                    <?php foreach($schoolArr as $school){
                                        echo '<option value="'.$school['school_id'].'" >'.$school['school_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Exam<span class="req redbold">*</span></label>
                                <input type="text" name="name" id="edit_name" class="form-control" placeholder="Exam" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Description<span class="req redbold">*</span></label>
                                <textarea class="form-control" name="description" id="edit_description" placeholder="Description" autocomplete="off"></textarea>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Post</label>
                                <input type="text" name="post" id="edit_post" class="form-control" placeholder="Post" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Stream</label>
                                <input type="text" name="stream" id="edit_stream" class="form-control" placeholder="Stream" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Pay Scale</label>
                                <input type="text" name="pay_scale" id="edit_pay_scale" class="form-control nospecialChar"  placeholder="Pay Scale" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Vacancy</label>
                                <input type="text" name="vacancy" id="edit_vacancy" class="form-control numbersOnly" placeholder="Vacancy" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Start Date<span class="req redbold">*</span></label>
                                <input type="text" name="start_date" id="edit_start_date" class="form-control calendarclass startdate" placeholder="Start Date" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>End Date<span class="req redbold">*</span></label>
                                <input type="text" name="end_date" id="edit_end_date" class="form-control calendarclass" placeholder="End Date" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Online Application Link</label>
                                <input class="form-control" type="text" name="file" id="edit_file" placeholder="Online Application Link" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view("admin/scripts/exams_notifications_script");?>
