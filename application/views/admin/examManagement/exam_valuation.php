
<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card ">
        <h6>Exams To Evaluate</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <!-- <button onClick="resetform();" class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal"  onclick="formclear('add_institute_form')">
            Add Model
        </button> -->
        <div class="table-responsive table_language" style="margin-top:15px;">
           <table id="evaluate_data" class="table table-striped table-sm" style="width:100%">
                <thead><tr>
                    <th width="10%">Sl.No.</th>
                    <th>Exam Name</th>
                    <th>Center</th>
                    <th>Batch</th>
                    <th>Exam Start Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr></thead>
                <?php $i=1; if(!empty($exam)){ foreach($exam as $row){ ?>
                <tr id="exam<?php echo $row->id;?>">
                    <td width="10%"><?php echo $i; ?></td>
                    <td><?php echo $row->name; ?></td>
                    <td><?php echo $row->institute_name; ?></td>
                    <td><?php echo $row->batch_name; ?></td>
                    <td><?php echo date('d-M-Y h:i a', strtotime($row->start_date_time)); ?></td>
                    <td>
                        <?php 
                            if($row->status == 3){echo '<span style="color:red;">Under Evaluation</span>';}
                            if($row->status > 3){echo '<span style="color:green;">Result Published</span>';}
                        ?>
                    </td>
                    <td>
                        <button class="btn mybutton mybuttonnew" onclick="redirect('backoffice/exam-descriptive-questions/<?php echo $row->id;?>')">
                            View Descriptive Questions
                        </button>
                    </td>
                </tr>
                <?php $i++; } }  ?>
                
            </table>
        </div>
    </div>
</div>
<?php $this->load->view('admin/scripts/examManagement/exam_definition_script'); ?>
