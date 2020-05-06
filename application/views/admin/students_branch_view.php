<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card ">
        <h6>Batch Details</h6>
        <!-- <div id="result"> -->
            <select class="form-control filter_class" name="batch_id" id="batch_id">
                <!-- <option value="">Select</option> -->
                <?php foreach($batchArr as $batch){?>
                    <option value="<?php echo $batch['batch_id'];?>"><?php echo $batch['batch_name'];?></option>
                <?php } ?>
            </select>
            <hr/>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#brachdetails1">Students </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#brachdetails2">Schedule</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#brachdetails3">Syllabus</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="brachdetails1" class="tab-pane active">
                    <div class="table-responsive table_language">
                        <table id="studentdatatable1" class="table table-bordered table-striped table-sm">
                            <tr>
                                <th width="50">Sl no.</th>
                                <th>Name</th>
                                <th>Student ID</th>
<!--                                <th>Action</th>-->
                            </tr>
                            <tr>
                            <?php $i=1; if(!empty($studentArr)){
                                foreach($studentArr as $student){ ?>
                                <td><?php echo $i;?></td>
                                <td> <?php echo $student->student_name;?></td>
                                <td><?php echo $student->registration_number;?></td>
<!--
                                <td><?php echo '<a href ="'.base_url('backoffice/view-student/'.$student->student_id).'" id="#view_student" ><button title="View" class="btn btn-default option_btn " onclick="view_studentdata('.$student->student_id.')">
                            <i class="fa fa-eye "></i>
                        </button></a>';?>
                                </td>
-->
                            </tr>
                            <?php $i++;} }else{ ?>
                                        <tr>
                                            <td colspan="4">No data available</td>
                                        </tr>
                            <?php }?> 
                        </table>
                    </div>
                </div>
                <div id="brachdetails2" class="tab-pane fade">
                    <div id='calendar' class="full_calender_wrap"></div>
                </div>
                <div id="brachdetails3" class=" tab-pane fade">
<!--                    <div id="default-tree"></div>-->
                    <div class="table-responsive table_language">
                        <table class="table  table-bordered table-striped text-center table-sm">
                            <tr>
                                <th class="text-left" style="background-color: rgb(0, 123, 255);">Sessions</th>
                            </tr>
                        <?php if(!empty($coursedet)) {
                                    foreach($coursedet as $course) {
                                        ?>
                                      <tr><td class="text-left"><?php echo $course->subject_name.'['.$course->subjectname.']<br/>'.$course->module_content;?></td>
                                      <?php      
                                    }
                            }
                            ?>
                           </table></div>
                </div>
            </div>
        <!-- </div> -->
    </div>
</div>
</div>
    </div>
</div>
<!-- Script Section Starts here -->
<?php $this->load->view("admin/scripts/students_branch_script");?>
<!-- Script Section Ends here -->
