<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <!-- Data Table Plugin Section Starts Here-->
    <div class="white_card">
        <div class="centerWise">
            <h6><?php echo $this->lang->line('application_log');?></h6>
            <hr>
            <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="applicationlog_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('user');?></th>
						<th ><?php echo $this->lang->line('activity');?></th>
                        <th ><?php echo $this->lang->line('date');?></th>
                    </tr>
                </thead>
                <?php 
                $x = 1;
                if(!empty($list)) {
                    foreach($list as $row) {  
                        $users = explode('/', $row->log_who);
                        if (array_key_exists(0,$users) && $users[0]=='') {
                            $user = 'Admin';
                        } else if(array_key_exists(1,$users) && $users[1]=='student') {
                            //$user = 'Student';
                            $user_id = $users[0];
                            if($user_id>0) {
                                $userdet = $this->common->get_from_tablerow('am_students',array('student_id'=>$user_id));
                                $user = 'Student : '.$userdet['name'].'['.$userdet['registration_number'].']';
                            }
                        }else {
                            $user = '';
                            $user_id = $users[0];
                            if($user_id>0) {
                                $userdet = $this->common->get_from_tablerow('am_staff_personal',array('personal_id'=>$user_id));
                                $user = $userdet['name'].'['.$userdet['registration_number'].']';
                            }
                        }
                    if($row->log_action=='Login' || $row->log_action=='Logout') {
                        $activity = $row->log_objecttype;
                        if($row->log_objecttype=='Login failed') {
                            $user = $users[0];
                        }
                    } else {
                        if($row->log_message!='') {
                            $activity = $row->log_message;
                        } else {
                            $activity = $row->log_objecttype;
                        }
                    }   
                        
                ?>
                <tr>
                    <td><?php echo $slno++;?></td>
                    <td ><?php echo $user;?></td>
                    <td ><?php echo $activity;?></td>
                    <td ><?php echo date('F j, Y, g:i a', strtotime($row->log_when));?></td>
                </tr>
                <?php $x++; ?>
                <?php } ?>
                    <?php } ?> 
                    <tr><td class="align-left"><p><?php echo $links; ?></p></td></tr>
            </table>
        </div>
        </div>
    </div>
</div>
