<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
           <h6><?php echo $this->lang->line('manage_discount_approval');?></h6>
        <hr>
   
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table  id="subject_data" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?>

                        </th>
                        <th><?php echo $this->lang->line('student_name');?>

                        </th>
                        <th><?php echo $this->lang->line('course');?>

                        </th>
                        <th><?php echo $this->lang->line('place');?>

                        </th>
                        <th><?php echo $this->lang->line('centre');?>

                        </th>
                        <th><?php echo $this->lang->line('status');?>

                        </th>
                        <th><?php echo $this->lang->line('action');?>

                        </th>
                    </tr>
                </thead>
                    <?php
                    if(!empty($list)) {
                        $i =1;
                        foreach($list as $row) { 
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $row->name;?></td>
                        <td><?php echo $row->class_name;?></td>
                        <td><?php echo $row->street.', '.$row->city;?></td>
                        <td><?php echo $row->institute_name;?></td>
                        <td><?php if($row->discount_status==1) { echo '<span class="admitted">Approved</span>'; }
                            else if($row->discount_status==2) { echo '<span class="declined">Declined</span>';}
                            else { echo '<span class="inactivestatus">Pending</span>';};?></td>
                        <td><span class="btn mybutton " onclick="getapprovaldetails('<?php echo $row->student_id;?>','<?php echo $row->course_id;?>')" data-toggle="modal" data-target="#show" >Manage</span></td>
                    </tr>
                    <?php 
                        $i++;
                        } ?>
                    <?php } ?>
                
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>
<div id="show" class="modal fade form_box" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Approval Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="loaddata">
            </div>
        </div>
    </div>
</div>
<!--modal-->

<?php $this->load->view("admin/scripts/approval_script");?>
