
<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <?php if(isset($cce)){ //print_r($total);//print_r($staff);?>
    <div class="header_card">
        <h4>Dashboard</h4>
        <input class="form-control year filter_class batch_drop" type="text"  id="created_on" name="created_on" value="<?php echo date('Y'); ?>" placeholder="Pick a Date">
    </div>            
    <div class="white_card" id="by_year">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <div class="row" >
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="div1">
                        <!-- <a href="<?php echo base_url('backoffice/call-received-today');?>">
                            <div class="dash_box dash_box_in">
                                <p>Call Received Today</p>
                                <h4><?php echo (isset($total))?$total['today_received_call']:'';?></h4>
                            </div>
                        </a> -->
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="div2">
                        <!-- <a href="<?php echo base_url('backoffice/call-admitted-today');?>">
                            <div class="dash_box dash_box_in">
                                <p>Total Admitted Today</p>
                                <h4><?php echo (isset($total))?$total['today_converted_call']:'';?></h4>
                            </div>
                        </a> -->
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="div3">
                        <!-- <a href="<?php echo base_url('backoffice/manage-calls');?>">
                            <div class="dash_box dash_box_in">
                                <p>Total Call Received</p>
                                <h4><?php echo (isset($total))?$total['totalcall_received']:'';?></h4>
                            </div>
                        </a> -->
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="div4">
                        <!-- <a href="<?php echo base_url('backoffice/admitted-call-list');?>">
                            <div class="dash_box dash_box_in">
                                <p>Total Admitted</p>
                                <h4><?php echo (isset($total))?$total['totalcall_converted']:'';?></h4>
                            </div>
                        </a> -->
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12" id="div5">
                        <!-- <a href="<?php echo base_url('backoffice/in-progress-call-list');?>">
                            <div class="dash_box dash_box_in">
                                <p>Calls In Progress</p>
                                <h4><?php echo $inprogress;?></h4>
                            </div>
                        </a> -->
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12" id="div6">
                        <!-- <a href="<?php echo base_url('backoffice/closed-call-list');?>">
                            <div class="dash_box dash_box_in">
                                <p>Calls Closed</p>
                                <h4><?php echo $closed;?></h4>
                            </div>
                        </a> -->
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" id="div7">
                        <!-- <a href="<?php echo base_url('backoffice/unnecessary-call-list');?>">
                            <div class="dash_box dash_box_in">
                                <p>Blacklisted Calls</p>
                                <h4><?php echo $unnecessary;?></h4>
                            </div>
                        </a> -->
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12" id="div8">
                        <!-- <a href="<?php echo base_url('backoffice/registered-call-list');?>">
                            <div class="dash_box dash_box_in">
                                <p>Registered Calls</p>
                                <h4><?php echo $register;?></h4>
                            </div>
                        </a> -->
                    </div>

                </div>
            </div>
        </div>
        
    </div>
<?php 
if($this->session->userdata('role')!='cce') {
?>
<div class="header_card">
<h4>Conversion Ratio</h4>
<select class="form-control batch_drop ccexecutiveratio">
                           <option>Select call center executive</option>
                        <?php 
                          if(!empty($cce)) {
                          foreach($cce as $staff) {
                              if($userid == $staff['personal_id']) { $selected = 'selected="selected"';} else { $selected = '';}
                            echo '<option value="'.$staff['personal_id'].'" '.$selected.'>'.$staff['name'].'</option>';
                                } 
                              }
                           ?>
                       </select>
                    </div>
<div class="white_card">
                       
                <div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12" >  
        <?php 
           $convertrate = 0;
           if(!empty($myrate)) {
           if($myrate['totalcall_converted']>0) {       
           $rate =   $myrate['totalcall_converted']/$myrate['totalcall_received'];  
           $convertrate =   $rate*100; 
           }
           }
        ?>
        <a href="<?php echo base_url('backoffice/unnecessary-call-list');?>"><div class="dash_box dash_box_in">
                    <p>Total Call Received </p>
                    <h4 id="totalreceiveddash"><?php echo(isset($myrate))?$myrate['totalcall_received']:'';?></h4>
                    </div></a>
            </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12" >
        <a href="<?php echo base_url('backoffice/registered-call-list');?>"><div class="dash_box dash_box_in">
                    <p>Total Admitted</p>
                    <h4 id="totalconvertdash"><?php echo(isset($myrate))?$myrate['totalcall_converted']:'';?></h4>
                </div></a>
            </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12" >
                    <a href="#"><div class="dash_box dash_box_in">
                        <p>Conversion Ratio</p>
                        <h4 style="font-size: 18px;" id="ratiodash"><b style="color:#cb4040;">Total <?php echo(isset($myrate))?$myrate['totalcall_converted']:'';?>/<?php echo(isset($myrate))?$myrate['totalcall_received']:'';?> </b>- Rate : <?php echo $convertrate;?>%</h4>
                    </div></a>
                </div>
                
                </div>

            </div>
    <?php } ?>
    <div class="header_card">
<h4>Course Details</h4>
    </div>
<div class="white_card">
        <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    <h5>Running Course </h5>
                <div class="table-responsive">
                                <div class="accordion accordion_branch" id="accordionExample">
                                    <?php
                                 
                                  foreach($running_batchArr as $course) {
                                  // echo "<pre>"; print_r($course['batch_details']); die();
                                    ?>
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne_running_<?php echo $course['class_id'];?>" aria-expanded="true" aria-controls="collapseOne">
                                                   <?php echo $course['class_name'];?>
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseOne_running_<?php echo $course['class_id'];?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                           <div class="card-body">
                                   <?php 
                                    foreach($course['batch_details'] as $batch)
                                      { 
                                            
                                       $batch['allocated_seats']=$this->common->get_total_student($batch['batch_id']);
                                        $start_time=date('h:i A',strtotime($batch['batch_start_time']));
                                        $end_time=date('h:i A',strtotime($batch['batch_end_time']));
                                        $from=date('d-M-Y',strtotime($batch['batch_datefrom']));
                                        $to=date('d-M-Y',strtotime($batch['batch_dateto']));
                                        $last_date=date('d-M-Y',strtotime($batch['last_date']));
                                        
                                        $remaining_seats=$batch['batch_capacity'] - $batch['allocated_seats'];
                                        $days="";
                                        if($batch['monday'] == "1")
                                        {
                                            $days.="Monday,";
                                        }
                                       if($batch['tuesday'] == "1")
                                        {
                                             $days.= "Tuesday,";
                                        } 
                                        if($batch['wednesday'] == "1")
                                        {
                                             $days.= "Wednesday,";
                                        }
                                        if($batch['thursday'] == "1")
                                        {
                                             $days.= "Thursday,";
                                        } 
                                        if($batch['friday'] == "1")
                                        {
                                             $days.= "Friday,";
                                        }
                                        if($batch['saturday'] == "1")
                                        {
                                             $days.= "Saturday,";
                                        } 
                                        if($batch['sunday'] == "1")
                                        {
                                             $days.= "Sunday,";
                                        }
                                               ?>
                                                    <div class="batch">
                                                        <h3><?php echo ucfirst($batch['batch_name'])?></h3>
                                                        <p><b>Duration:</b>&nbsp;<?php echo $from."  to  "  .$to;?></p>
                                                        <p><b>Timing:</b>&nbsp;<?php echo $start_time."  to  ".$end_time;?></p>
                                                        <p><b>Days:</b>&nbsp;<?php echo $days; ?></p>
                                                        <?php 
                                                         $today = date('d-M-Y');  
                                                        if($last_date < $today)
                                                        { ?>

                                                         <p><b>Admission Closed</b>&nbsp;<?php //if($last_date != "01-Jan-1970"){ echo $last_date; }?></p>
                                                        <?php
                                                        }
                                                        else
                                                        {
                                                        ?>
                                                        <p><b>Last Date of Admission:</b>&nbsp;<?php if($last_date != "01-Jan-1970"){ echo $last_date; }?></p>
                                                        <?php
                                                        }
                                                        ?>
                                                        

                                                        <p><b>Seats:</b></p>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width:<?php echo $batch['allocated_seats'];?>%"><?php echo $batch['allocated_seats'];?></div>

                                                            <span><?php echo $batch['allocated_seats'];?>/<?php echo $batch['batch_capacity'];?></span>
                                                        </div>
                                                        <p><b>Available Seats:</b>&nbsp;<?php echo $remaining_seats; ?></p>
                                                        <p><b>Fees:</b>&nbsp;<?php echo $batch['course_totalfee']."Rs/-";?></p>
                                                        <a href="<?php echo base_url();?>backoffice/view-branch-students/<?php echo $course['class_id'];?>/<?php echo $batch['institute_master_id'];?>"><button class="btn btn-info">More Details</button></a>
                                                    </div>

                                                    <hr>
                                                   <?php } ?>
                                                </div>


                                        </div>
                                    </div>
                                    <?php }  ?>
                                    </div>
                                </div>
    </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                 <h5>Upcomming Course </h5>
                <div class="table-responsive">
                                <div class="accordion accordion_branch" id="accordionExample">
                                    <?php
                                 
                                  foreach($upcomming_batchArr as $course) {
                                  // echo "<pre>"; print_r($course['batch_details']); die();
                                    ?>
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne_<?php echo $course['class_id'];?>" aria-expanded="true" aria-controls="collapseOne">
                                                   <?php echo $course['class_name'];?>
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseOne_<?php echo $course['class_id'];?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                           <div class="card-body">
                                   <?php 
                                    foreach($course['batch_details'] as $batch)
                                      { 
                                            
                                       $batch['allocated_seats']=$this->common->get_total_student($batch['batch_id']);
                                        $start_time=date('h:i A',strtotime($batch['batch_start_time']));
                                        $end_time=date('h:i A',strtotime($batch['batch_end_time']));
                                        $from=date('d-M-Y',strtotime($batch['batch_datefrom']));
                                        $to=date('d-M-Y',strtotime($batch['batch_dateto']));
                                        $last_date=date('d-M-Y',strtotime($batch['last_date']));
                                        $remaining_seats=$batch['batch_capacity'] - $batch['allocated_seats'];
                                        $days="";
                                        if($batch['monday'] == "1")
                                        {
                                            $days.="Monday,";
                                        }
                                       if($batch['tuesday'] == "1")
                                        {
                                             $days.= "Tuesday,";
                                        } 
                                        if($batch['wednesday'] == "1")
                                        {
                                             $days.= "Wednesday,";
                                        }
                                        if($batch['thursday'] == "1")
                                        {
                                             $days.= "Thursday,";
                                        } 
                                        if($batch['friday'] == "1")
                                        {
                                             $days.= "Friday,";
                                        }
                                        if($batch['saturday'] == "1")
                                        {
                                             $days.= "Saturday,";
                                        } 
                                        if($batch['sunday'] == "1")
                                        {
                                             $days.= "Sunday,";
                                        }
                                               ?>
                                                    <div class="batch">
                                                        <h3><?php echo ucfirst($batch['batch_name'])?></h3>
                                                        <p><b>Duration:</b>&nbsp;<?php echo $from."  to  "  .$to;?></p>
                                                        <p><b>Timing:</b>&nbsp;<?php echo $start_time."  to  ".$end_time;?></p>
                                                        <p><b>Days:</b>&nbsp;<?php echo $days; ?></p>
                                                        <p><b>Last Date of Admission:</b>&nbsp;<?php if($last_date != "01-Jan-1970"){ echo $last_date; }?></p>

                                                       <!-- <p><b>Seats:</b></p>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width:<?php echo $batch['allocated_seats'];?>%"><?php echo $batch['allocated_seats'];?></div>

                                                            <span><?php echo $batch['allocated_seats'];?>/<?php echo $batch['batch_capacity'];?></span>
                                                        </div>-->
                                                        <p><b>Available Seats:</b>&nbsp;<?php echo $remaining_seats; ?></p>
                                                        <p><b>Fees:</b>&nbsp;<?php echo $batch['course_totalfee']."Rs/-";?></p>
                                                       <a href="<?php echo base_url();?>backoffice/view-branch-students/<?php echo $course['class_id'];?>/<?php echo $batch['institute_master_id'];?>"><button class="btn btn-info">More Details</button></a>
                                                    </div>

                                                    <hr>
                                                   <?php } ?>
                                                </div>


                                        </div>
                                    </div>
                                    <?php }  ?>
                                    </div>
                                </div>
                            </div>
    </div>
    </div>
</div>
   
    </div>  
<?php }else{?>

<?php }?>

<script>
    $(document).ready(function(){ 
        $(".ccexecutiveratio").change(function(){
        var user_id = $(this).val();
        $(".loader").show();    
        if(user_id) { 
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Call_center/get_cc_executiveratio',
                type: 'POST',
                data: {
                    user_id: user_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    var  convert = 0;
                    var obj = JSON.parse(response);
                    if(obj.totalcall_converted) {
                    ratio = obj.totalcall_converted/obj.totalcall_received;
                    convert = ratio*100;
                    }
                    $("#totalconvertdash").html(obj.totalcall_converted);
                    $("#totalreceiveddash").html(obj.totalcall_received);
                    $('#ratiodash').html('<b style="color:#cb4040;">Total '+obj.totalcall_converted+'/'+obj.totalcall_received+' </b>- Rate : '+convert+'%');
                    $(".loader").hide();
                }
            });
        }
        else{
            $(".loader").hide();
            $("#course_related").css("display","none");
        }
    });
 });        
</script>
<?php $this->load->view("admin/scripts/student_view_script");?>

