<form method="Post" id="attendancesheetform">

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />    
<div class="AttendanceStatus">
                                    <ul class="nav nav-bar">
                                        <li><h6>Present <i class="fa fa-check" style="color:#28a745;"></i></h6></li>
                                        <li><h6>Absent <i class="fa fa-times" aria-hidden="true" style="color:red;"></i></h6></li>
                                    </ul>



                                </div>
                                
                                <?php //print_r($staffArr);
								$totalstudent = 1;
                                if(!empty($staffArr)) { 
								if(count($staffArr)>=2) {
                                $totalstudent = count($staffArr)/2;  
								}								
                                ?>    
                                <div class="AttendanTabl">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-sm">
                                                    <tbody>
                                                         <tr style="background: #007bff;color: #fff;" class="mark_attendance">
                                                            <th>Name</th>
                                                            <th>Role</th>
                                                            <th>Attendance</th>
                                                        </tr>
                                                        <?php
                                                            $i = 1;
                                                            foreach($staffArr as $row) {  
                                                        ?>
                                                        <input type="hidden" name="staff_id[]" value="<?php echo $row['personal_id'];?>" />
                                                        <tr>
                                                            <td><?php echo $row['name'];?></td>
                                                            <td><?php echo $row['role_name'];?></td>
                                                            <td>
                                                                <div class="absentPresent">
												<input type="checkbox" checked class="chkPassport" name="attendance_<?php echo $row['personal_id'];?>" value="1">
												<div class=" dvAbsent" style="display: none">
												
													<i class="fa fa-times fingercursor" aria-hidden="true" style="color:red;"></i>
												</div>
												<div class="dvPresent">
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
                                                       
                                                        ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-sm">
                                                    <tbody>
                                                         <tr style="background: #007bff;color: #fff;" class="mark_attendance">
                                                            <th>Name</th>
                                                            <th>Role</th>
                                                            <th>Attendance</th>
                                                        </tr>
                                                        <?php
                                                            $x = 1;
                                                            foreach($staffArr as $row) { 
                                                                if($x>$i) {
                                                        ?>
                                                        <input type="hidden" name="staff_id[]" value="<?php echo $row['personal_id'];?>" />
                                                        <tr>
                                                            <td><?php echo $row['name'];?></td>
                                                            <td><?php echo $row['role_name'];?></td>
                                                            <td>
                                                            <div class="absentPresent">
                                                                <input type="checkbox" checked class="chkPassport" name="attendance_<?php echo $row['personal_id'];?>" value="1">
                                                                <div class=" dvAbsent" style="display: none">
                                                                    <i class="fa fa-times fingercursor" aria-hidden="true" style="color:red;"></i>
                                                                </div>
                                                                <div class="dvPresent">
                                                                        <i class="fa fa-check fingercursor"></i>
                                                                </div>
                                                            </div>
                                                            </td>
                                                        </tr>
                                                        <?php 
                                                            }
                                                                $x++;
                                                                //$i++;
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

$("form#attendancesheetform").submit(function(e) {
        e.preventDefault();
        var dateval = $('#date').val(); 
        $(".loader").show();
      $('.btn_save').attr('disabled', true);
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Staff/save_attendance/'+dateval,
            type: 'POST',
            data: {<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            data: $("#attendancesheetform").serialize(),
            success: function(response) {
                  $(".loader").hide();  
                 var obj=JSON.parse(response);
                    if(obj['status'] == 1)
                    {
                        $(".mark_attendance").css("background-color", " #28a745");
                         $('.btn_save').attr('disabled', false);
                        $.toaster({priority:'success',title:'message',message:obj['message']});
						$.ajax({
							url: '<?php echo base_url();?>backoffice/Staff/load_attendance_by_date',
							type: 'POST',
							data: {date:dateval,
								<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
							},
							success: function(response) {
								 $(".loader").hide();
								 $('#loadattendancesheet').html(response);
							}
						});
                    } else {
                        $.toaster({ priority : 'danger', title : 'Error', message : obj['message'] });  
                    }
            }
      });
    });     
    
</script>