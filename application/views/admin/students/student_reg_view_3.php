
<form id="requirement_form" method="post">
        <input type="hidden" name="student_id" value="<?php echo $studentArr['student_id']; ?>"/>
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
        <?php 
            $room_booked = $this->db->where('student_id',$studentArr['student_id'])
                                    ->where_in('status',array('alloted','checkin'))
                                    ->where('delete_status',1)
                                    ->get('hl_room_booking')->num_rows();
            $payment_pending = $this->db->where('student_id',$studentArr['student_id'])
                                        ->where('status','payment pending')
                                        ->where('delete_status',1)
                                        ->get('hl_room_booking')->num_rows();
            $hostel_readonly = '';
            if($room_booked > 0){
                $hostel_readonly = 'disabled="disabled"';
            } 
        ?>
    <table class="table table_register">
        <tbody>
            <tr>
                <td colspan="2">Hostel Required<span class="req redbold"> *</span></td>
                <td nowrap=""><label class="custom_checkbox">Yes
                <input type="radio" <?php echo $hostel_readonly;?>   name="hostel" value="yes" class="hostel" <?php if($studentArr['hostel'] == "yes"){ echo "Checked"; } ?> >
                    <span class="checkmark"></span>
                </label>
                </td>
                <td nowrap=""><label class="custom_checkbox">No
                    <input type="radio" <?php echo $hostel_readonly;?> name="hostel" class="hostel" value="no" <?php if($studentArr['hostel']=="no"){ echo "Checked"; }?>>
                    <span class="checkmark"></span>
                </label>
                </td>
            </tr>

            <tr class="hostel_sub" <?php if($studentArr['hostel'] == "no"){?> style="display:none;" <?php } ?>>
                <td colspan="2">Whether the candidate had stayed in any hostel before <span class="req redbold"> *</span></td>
                <td><label class="custom_checkbox">Yes
                    <input type="radio" name="stayed_in_hostel" <?php echo $hostel_readonly;?> value="yes" class="stayed_in_hostel" <?php if($studentArr['stayed_in_hostel'] == "yes"){ echo "Checked"; }?>>
                    <span class="checkmark"></span>
                </label></td>
                <td><label class="custom_checkbox">No
                    <input type="radio" name="stayed_in_hostel" <?php echo $hostel_readonly;?>  value="no" class="stayed_in_hostel" <?php if($studentArr['stayed_in_hostel'] == "no"){ echo "Checked"; }?>>
                    <span class="checkmark"></span>
                </label></td>

            </tr>
            <tr  class="hostel_sub" <?php if($studentArr['hostel'] == "no"){?> style="display:none;" <?php } ?>>
                <td colspan="2">Food habit of student<span class="req redbold"> *</span>
                </td>
                <td><label class="custom_checkbox">Veg
                <input type="radio" name="food_habit" value="veg" <?php echo $hostel_readonly;?>  class="food_habit" <?php if($studentArr['food_habit']=="veg"){echo "Checked";}?>>
                    <span class="checkmark"></span>
                </label> <span id="foodhabit_msg" class="req redbold"></span></td>
                <td nowrap=""><label class="custom_checkbox">Non-Veg
                    <input type="radio" name="food_habit" value="nonveg" <?php echo $hostel_readonly;?> class="food_habit" <?php if($studentArr['food_habit']=="nonveg"){echo "Checked";}?>>
                    <span class="checkmark"></span>
                </label></td>

            </tr>
            <tr class="hostel_sub" <?php if($studentArr['hostel'] == "no"){?> style="display:none;" <?php } ?>>

                    <?php
                   // print_r($hostel_room_details);
                    if(($studentArr['hostel']) == "yes")
                    {

                            if(!empty($hostel_room_details) && ($room_booked || $payment_pending))
                            {
                               // foreach($hostel_room_details as $room_row)
                               // {
                                   $room_no=$hostel_room_details['room_number'] ;
                                   $building_name=$hostel_room_details['building_name'] ;
                                   $floor=$hostel_room_details['floor'] ;
                                   $room_type=$hostel_room_details['room_type'] ;

                                ?>
                                <td>Building : <span class="spanBold"><?php echo ucfirst($building_name) ;?></span></td>
                                <td>Floor : <span class="spanBold"><?php echo ucfirst($floor) ;?></span></td>
                                <td>Room Type :<span class="spanBold"> <?php echo ucfirst($room_type) ;?></span></td>
                                <td>Room No :<span class="spanBold"> <?php echo ucfirst($room_no) ;?></span></td>

                            <?php
                            }
                            else
                            {
                            ?> <td colspan="4">
                                <a class="hostelAllocated" href="<?php echo base_url();?>backoffice/manage-roombooking/<?php echo $studentArr['student_id']; ?> " title="Click here to check the availability of hostel" target="_blank">
                                <span>Check Hostel Availability</span></a>
                           </td>
                        <?php
                            }


                    }
                    else
                    { ?>
                     <td colspan="4">
                    <a id="please_save" class="hostelAllocated" onClick="please_save()" title="Click here to check the availability of hostel" target="_blank">
                    <span>Check Hostel Availability</span></a>
                    <a id="show_button" style="display:none" class="hostelAllocated" href="<?php echo base_url();?>backoffice/manage-roombooking/<?php echo $studentArr['student_id']; ?> " title="Click here to check the availability of hostel" target="_blank">
                    <span>Check Hostel Availability</span></a>
                    </td>
                    <?php }?>


            </tr>



              <?php if(($studentArr['hostel']) == "yes")
                    {
                    if(!empty($hostel_room_details) && $payment_pending)
                            { ?>
                    <tr>
                        <td colspan="4">
                            <a id="show_button" class="hostelAllocated" href="<?php echo base_url();?>backoffice/manage-roombooking/<?php echo $studentArr['student_id']; ?> " title="Click here to change the room" target="_blank">
                            <span>Change Room</span></a>
                        </td>
                    </tr>
            <?php } } ?>

            <!-- <tr>
                <td colspan="2">Whether the candidate has any medical history of aliment</td>
                <td><label class="custom_checkbox">Yes
                    <input type="radio" name="medical_history" class="medical_history" value="yes" <?php if($studentArr['medical_history']=="yes"){echo "Checked";}?>>
                    <span class="checkmark"></span>
                </label></td>
                <td><label class="custom_checkbox">No
                    <input type="radio" name="medical_history" class="medical_history" value="no" <?php if($studentArr['medical_history']=="no"){echo "Checked";}?>>
                    <span class="checkmark"></span>
                </label></td>
            </tr> -->
            <!-- <tr id="med" <?php if($studentArr['medical_history'] == "no" || $studentArr['medical_history'] == ""){ ?> style="display:none;" <?php }?>>
                <td colspan="2">Medical History Description<span class="req redbold">*</span></td>
                <td colspan="2" >
                    <div class="form-group">

                        <textarea  class="form-control" placeholder="Description"  name="medical_description" id="medical_description" onkeypress="return blockSpecialChar(event)"><?php echo $studentArr['medical_description']?></textarea>
                    </div><span id="medical_msg" class="req redbold"></span>
                </td>
            </tr> -->
            <tr>
                <td colspan="2">Transportation Required</td>
                <td><label class="custom_checkbox">Yes
                    <input type="radio" name="transportation" id="transyes" value="yes" <?php if($studentArr['transportation']=="yes"){echo "Checked";}?> class="transportation">
                    <span class="checkmark"></span>
                </label></td>
                <td><label class="custom_checkbox">No
                        <input type="radio" name="transportation" id="transno" value="no" <?php if($studentArr['transportation']=="yes"){ echo 'onclick="transcancel();"';}?> <?php if($studentArr['transportation']=="no"){echo "Checked";}?> class="transportation">
                        <span class="checkmark"></span>
                    </label></td>
            </tr>

            <tr id="place" <?php if($studentArr['transportation'] == "no" || $studentArr['transportation'] == ""){ ?> style="display:none;" <?php }?>>
                <td colspan="2">Route<span class="req redbold">*</span></td>
                <td colspan="2" >
                    <div class="form-group">
                        <select class="form-control" name="place" id="transport_place">
                            <option value="">Select</option>
                            <?php //print_r($routeArr);
                            if(!empty($routeArr))
                            {
                                foreach($routeArr as $row)
                                {
                                  ?>
                            <option <?php if( $studentArr['place']== $row['transport_id']) { echo "selected"; } ?> value="<?php echo $row['transport_id'];?>"><?php echo ucfirst($row['route_name']);?></option>
                               <?php
                                }
                            }
                            ?>
                        </select>
                        <!--<input type="text" class="form-control" placeholder="Place" value="<?php echo $studentArr['place']?>" name="place" id="transport_place" onkeypress="return addressValidation(event)"/>-->
                    </div><span id="pmsg" class="req redbold"></span>

                </td>
            </tr>
             <tr id="show_stop" <?php if($studentArr['transportation'] == "no" || $studentArr['transportation'] == ""){ ?> style="display:none;" <?php }?>>
                <td colspan="2">Boarding Point<span class="req redbold">*</span></td>
                <td colspan="2" >
                    <div class="form-group">
                        <select class="form-control" name="stop" id="stop" onchange="showfire(this.value)">
                            <option value="">Select</option>
                            <?php if(!empty($stopArr))
                               {
                                   print_r($stopArr);
                                   foreach($stopArr as $srow)
                                   {
                                       ?>
                                   <option <?php if(!empty($studentArr['stop'])) {if($studentArr['stop']== $srow['stop_id']) { echo "selected"; } } ?> value="<?php echo $srow['stop_id'];?>"><?php echo ucfirst($srow['name']);?></option>
                                      <?php
                                   }
                            }?>
                        </select>

                        <!--<input type="text" class="form-control" placeholder="Place" value="<?php echo $studentArr['place']?>" name="place" id="transport_place" onkeypress="return addressValidation(event)"/>-->
                    </div><span id="stop_msg" class="req redbold"></span>
                    <span id="show_fare" class="spanBold"></span>
                </td>

            </tr>

            <tr id="start_date" <?php if($studentArr['transportation'] == "no" || $studentArr['transportation'] == ""){ ?> style="display:none;" <?php }?>>
                <td colspan="2">Start Date<span class="req redbold">*</span></td>
                <td colspan="2" >
                    <div class="form-group">
                    <input type="text" class="form-control calendarclass" placeholder="Start Date" name="trans_start_date" id="trans_start_date" value="<?php echo date('d-m-Y');?>" onkeypress="return ValDate(event)" aria-required="true" aria-invalid="false">
                    </div><span id="start_date_msg" class="req redbold"></span>
                </td>

            </tr>                         

        </tbody>
    </table>

        <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="form-group">
                <button class="btn btn-info btn_save" type="submit">Save</button>
               <!-- <button class="btn btn-default btn_cancel">Cancel</button>-->
            </div>
        </div>
    </div>
</form>

<script>


function transcancel() {
    $.confirm({
        title: 'Alert message',
        content: 'Do you want to cancel transportaion?',
        icon: 'fa fa-question-circle',
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        buttons: {
            'confirm': {
                text: 'Proceed',
                btnClass: 'btn-blue',
                action: function() { }
            },
            cancel: function() { 
                $('#transyes').trigger('click');
                if($('input:radio[name=transportation]:checked').val()  == "yes")
            {
                 $("#place").show();
                 $("#show_stop").show();
                 $("#start_date").show();
            }
        else{
             //$("#transport_place").val("");
            // $("#stop").val("");
             $("#place").hide();
             $("#show_stop").hide();
             $("#start_date").hide();
        }
            },
        }
    });
}

</script>
