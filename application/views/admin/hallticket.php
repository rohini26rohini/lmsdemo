<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <form id="filter_form" method="post" action="<?php echo base_url('backoffice/export-hallticket');?>">
        <div class="white_card ">
            <h6>View Hall Ticket</h6>
            <hr>
            <input type="hidden"  class ="exclude-status" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            <div class="row filter">
                <div class="col-sm-4 col-12">
                    <div class="form-group">
                        <label>Course</label>
                        <select class="form-control filter_change" name="filter_course" id="filter_course"  onchange="get_exam()">
                            <option value="">Select Course</option>
                            <?php foreach($courseArr as $course){?>
                            <?php  if($course['status']==1) {?>
                            <option value="<?php  echo $course['class_id'] ?>"><?php  echo $course['class_name'] ?></option>
                            <?php } }?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4 col-12">
                    <div class="form-group">
                        <label>Exam</label>
                        <select class="form-control filter_change" name="filter_exam" id="filter_exam">
                        <option value="">Select Exam</option>
                            <?php //foreach($notificationArr as $notification){?>
                            <!-- <option value="<?php  echo $notification['notification_id'] ?>"><?php  echo $notification['name'] ?></option> -->
                            <?php // }?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
        <div class="white_card">
            <div id="result">
                <div class="table-responsive table_language" style="margin-top:15px;">
                    <table id="hallticket_table" class="table table-striped table-sm selectstatus" style="width:100%">
                        <thead>
                            <tr>
                                <th width="8%"><?php echo $this->lang->line('sl_no');?></th>
                                <th><?php echo $this->lang->line('exam');?></th>
                                <th><?php echo $this->lang->line('name');?></th>
                                <th width="10%"><?php echo $this->lang->line('contact.no');?></th>
                                <th><?php echo $this->lang->line('course');?></th>
                                <th width="10%"><?php echo $this->lang->line('hallticket');?></th>
                                <!-- <th></th> -->
                                <th><?php echo $this->lang->line('status');?></th>
                            </tr>
                        </thead>
                        <?php 
                        $i=1; 
                        // show($examArr);
                        foreach($examArr as $exam){ ?>
                        <tr>
                            <td>
                                <?php echo $i;?>
                            </td>
                            <td>
                                <?php echo $exam['exam_name'];?>
                            </td>
                            <td>
                                <?php echo $exam['student_name'];?>
                            </td>
                            <td>
                                <?php echo $exam['contact_number'];?>
                            </td>
                            <td>
                                <?php echo $exam['class_name'];?>
                            </td>
                            <td>
                                <?php echo $exam['hall_tkt'];?>
                            </td>
                            <td>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="form-control" name="status" id="status_<?php echo $exam['examlist_id'];?>" onchange="get_val(<?php echo $exam['examlist_id'];?>)">
                                            <?php 
                                    if($exam['status'] != '') {
                                        if($exam['status'] == 1) {
                                            echo ' <option selected value="1">Passed</option>
                                            <option value="0">Failed</option>';
                                        } else if($exam['status'] == 0) {
                                            echo '<option value="1">Passed</option>
                                            <option selected value="0">Failed</option>';
                                        }
                                    } else {
                                        echo '<option selected value="">Select Status</option>
                                        <option value="1">Passed</option>
                                        <option value="0">Failed</option>';
                                    }
                                    ?>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php $i++; } ?>
                    </table>
                </div>
                <!-- Data Table Plugin Section Starts Here -->
                <button class="btn btn-default add_row btn_map btn_print " id="export" type="submit">
                    <i class="fa fa-upload"></i> Export
                </button>
            </div>
        </div>
    </form>
</div>

<?php $this->load->view("admin/scripts/studentlist_script");?>
