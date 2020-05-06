<form method="Post" id="attendancesheetupdate">
<input type="hidden" value="<?php echo $schedule_id;?>" name="schedule_id" />   
<input type="hidden" value="<?php echo $batch_id;?>" name="batch_id" />
<input type="hidden" value="<?php echo $type;?>" name="type" />
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />    
<div class="AttendanceStatus">
                                    <ul class="nav nav-bar">
                                        <li><h6>Present <i class="fa fa-check" style="color:#28a745;"></i></h6></li>
                                        <li><h6>Absent <i class="fa fa-times" aria-hidden="true" style="color:red;"></i></h6></li>
                                    </ul>



                                </div>
                                
                                <?php //echo '<pre>';print_r($students);
                                $totalstudent = 1;
                                if(!empty($students)) { 
								if(count($students)>=2) {
                                $totalstudent = count($students)/2;  
								}	
                                    
                                ?>    
                                <div class="AttendanTabl">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-sm">
                                                    <tbody>
                                                        <tr style="background: #28a745;color: #fff;">
                                                            <th>Roll No</th>
                                                            <th>Name</th>
                                                            <th>Attendance</th>
                                                        </tr>
                                                        <?php
                                                            $i = 1;
                                                            foreach($students as $student) {  //echo '<pre>';print_r($student);
                                                            if(strtotime($student->admitted_date) <= strtotime($student->att_date)){
                                                        ?>
                                                        <input type="hidden" name="att_id[]" value="<?php echo $student->att_id;?>" />
                                                        <tr>
                                                            <td><?php echo $student->registration_number;?></td>
                                                            <td><?php echo $student->name;?></td>
                                                            <td>
                                                                <div class="absentPresent">
                                                                    <input type="checkbox" <?php if($student->attendance==1) { echo 'checked="checked"'; } ?> class="chkPassport" name="attendance_<?php echo $student->att_id;?>" value="1">
                                                                    <div class="dvAbsent" <?php if($student->attendance==1) { echo 'style="display:none"'; } ?>>

                                                                        <i class="fa fa-times fingercursor" aria-hidden="true" style="color:red;"></i>
                                                                    </div>
                                                                    <div class="dvPresent" <?php if($student->attendance==0) { echo 'style="display:none"'; } ?>>
                                                                            <i class="fa fa-check fingercursor"></i>
                                                                    </div>
                                                                </div>
                                                               </td>
                                                        </tr>
                                                        <?php 
                                                            if($i%$totalstudent==0) {
                                                                break;
                                                            }
                                                                $i++;
                                                              }
                                                            } 
                                                       
                                                        ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-sm">
                                                    <tbody>
                                                        <tr style="background: #28a745;color: #fff;">
                                                            <th>Roll No</th>
                                                            <th>Name</th>
                                                            <th>Attendance</th>
                                                        </tr>
                                                        <?php
                                                            $x = 1;
                                                            foreach($students as $student) { //echo '<pre>';print_r($student);
                                                                if($x>$i) { 
                                                             if(strtotime($student->admitted_date) <= strtotime($student->att_date)){ 
                                                        ?>
                                                        <input type="hidden" name="att_id[]" value="<?php echo $student->att_id;?>" />
                                                        <tr>
                                                            <td><?php echo $student->registration_number;?></td>
                                                            <td><?php echo $student->name;?></td>
                                                            <td>
                                                            <div class="absentPresent">
                                                                <input type="checkbox" <?php if($student->attendance==1) { echo 'checked="checked"'; } ?> class="chkPassport" name="attendance_<?php echo $student->att_id;?>" value="1">
                                                                <div class=" dvAbsent" <?php if($student->attendance==1) { echo 'style="display:none"'; } ?>>
                                                                    <i class="fa fa-times fingercursor" aria-hidden="true" style="color:red;"></i>
                                                                </div>
                                                                <div class="dvPresent" <?php if($student->attendance==0) { echo 'style="display:none"'; } ?>>
                                                                        <i class="fa fa-check fingercursor"></i>
                                                                </div>
                                                            </div>
                                                            </td>
                                                        </tr>
                                                        <?php 
                                                            }
                                                                //$x++;
                                                                //$i++;
                                                                }
                                                                $x++;
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    <button type="submit" class="btn btn-info btn_save">Save</button>
<?php }  ?>
    </form>
<script>
    $(function() {
        $(".chkPassport").click(function() {
            if ($(this).is(":checked")) {
                $(this).parent(".absentPresent").find(".dvPresent").show();
                $(this).parent(".absentPresent").find(".dvAbsent").hide();
            } else {
                $(this).parent(".absentPresent").find(".dvPresent").hide();
                $(this).parent(".absentPresent").find(".dvAbsent").show();
            }
        });
    });

$("form#attendancesheetupdate").submit(function(e) {
        e.preventDefault();
        var dateval = $('#date').val(); 
        $(".loader").show();
        $('.btn_save').attr('disabled', true);
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Attendance/update_attendance/'+dateval,
            type: 'POST',
            data: {<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            data: $("#attendancesheetupdate").serialize(),
            success: function(response) {
                  $(".loader").hide();  
                 var obj=JSON.parse(response);
                    if(obj['status'] == 1)
                    {
                        $('.btn_save').attr('disabled', false);
                        $.toaster({priority:'success',title:'message',message:obj['message']});
                    } else {
                        $.toaster({ priority : 'danger', title : 'Error', message : obj['message'] });  
                    }
            }
      });
    });     
    
</script>