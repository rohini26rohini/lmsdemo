<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card">
        <div class="row filter">
            <div class="col-sm-4 col-12">
                <div class="form-group">
                <label> From Date</label>
                    <input type="text" name="filter_sdate" id="filter_sdate" class="form-control filter_class dates" placeholder="Search..."/>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="form-group">
                <label> To Date</label>
                    <input type="text" name="filter_edate" id="filter_edate" class="form-control filter_class dates" placeholder="Search..."/>
                </div>
            </div>
            <div class="col-sm-4 col-12">
                <div class="form-group">
                <label> Staff</label>
                    <select name="staff" id="staff" class="form-control">
                        <option value="">Select staff</option>
                        <?php
                        if(!empty($users)) {
                          foreach($users as $user) {
                              echo '<option value="'.$user->personal_id.'">'.$user->name.'</option>';
                          }  
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
        <!-- Data Table Plugin Section Starts Here -->
    <div class="white_card">
       <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th><?php echo $this->lang->line('staff');?></th>
                        <th><?php echo $this->lang->line('total_received');?></th>
                        <th><?php echo $this->lang->line('total_inprogress');?></th>
                        <th><?php echo $this->lang->line('total_admitted');?></th>
                        <th><?php echo $this->lang->line('ratio');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($calls as $call){
                ?>
                    <tr id="row_<?php echo $call['user_id'];?>">
                        <td><?php echo $i;?></td>
                        <td id="name_<?php echo $call['user_id'];?>"><?php echo $call['name']; ?></td>
                        <td><?php echo (isset($call['class']))?$call['class']['totalcall_received']:'';?></td>
                        <td><?php echo (isset($call['class']))?$call['class']['received_inprogress']:'';?></td>
                        <td><?php echo (isset($call['class']))?$call['class']['totalcall_converted']:'';?></td>
                        <td>
                        <?php if(isset($call['class'])) {
                            if($call['class']['totalcall_converted']>0) {
                                $count = $call['class']['totalcall_converted']/$call['class']['totalcall_courserelated'];
                                $ratio = $count*100;
                                echo 'Course related calls: <b>'.$call['class']['totalcall_courserelated'].'</b> <br>Ratio: <b>'.number_format($ratio,2).'%</b>';
                            }
                        } 
                        ?>
                        </td>
                    </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>



<?php $this->load->view("admin/scripts/call_summary_script");?>
