<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <form id="search_form">
            <div class="row filter">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('student_reg.no');?></label>
                        <select name="registration_number" class="form-control select2">
                        <option value="">Select</option>
                        <?php foreach($studentArr as $s) {?>
                        
                        <option value="<?php echo $s['student_id']; ?>"><?php echo $s['registration_number']; ?></option>
                        <?php } ?>
                    </select>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('contact.no');?></label>
                        <input type="text" name="contact_number" class="form-control numbersOnly" placeholder="Search.." />
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('building');?></label>
                        <select name="building_id" id="building_id" class="form-control select2">
                      <option value="">Select</option>
                        <?php foreach($buildingArr as $b) {?>
                        
                        <option value="<?php echo $b['building_id']; ?>"><?php echo $b['building_name']; ?></option>
                        <?php } ?>
                    </select>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('room_no');?></label>

                        <input type="text" name="room_id" class="form-control" placeholder="Search.." onkeypress="return addressValidation(event)"/>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('status');?></label>
                        <select name="status" id="status" class="form-control select2">
                        <option value="">Select</option>
                        <!-- <option value="alloted">Allotted</option> -->
                        <option value="checkin">Checkin</option>
                        <option value="checkout">CheckOut</option>
                        <option value="payment pending">Payment Pending</option>
                    </select>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('checkin');?></label>
                        <input type="text" class="form-control calendarclass" name="check_in" onkeypress="return ValDate(event)" autocomplete="off" onkeypress="return ValDate(event)">
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('checkout');?></label>
                        <input type="text" class="form-control calendarclass" name="check_out" onkeypress="return ValDate(event)" autocomplete="off" onkeypress="return ValDate(event)">
                    </div>
                </div>
                <div class="col-sm-12 col-12 filerPad text-right">
                    <button onclick="location.reload();" type="button" class="btn btn-info add_row add_new_btn btn_add_call ">
                        Reset
                    </button>
                    <button type="submit" class="btn btn-default add_row add_new_btn btn_add_call ">
                        <?php echo $this->lang->line('search');?>
                    </button>
                </div>

            </div>
        </form>
        <br>
        <h6>Booking Details</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->




        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="institute_data" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th width="50">
                            <?php echo $this->lang->line('sl_no');?>
                        </th>
                        <th>
                            <?php echo $this->lang->line('student_reg.no');?>
                        </th>
                        <th>
                            <?php echo $this->lang->line('contact.no');?>
                        </th>
                        <th>
                            <?php echo $this->lang->line('building');?>
                        </th>
                        <th>
                            <?php echo $this->lang->line('room_no');?>
                        </th>
                        <th>
                            <?php echo $this->lang->line('status');?>
                        </th>
                        <th>
                            <?php echo $this->lang->line('checkin');?>
                        </th>
                        <th>
                            <?php echo $this->lang->line('checkout');?>
                        </th>
                        <th>
                            <?php echo $this->lang->line('action');?>
                        </th>
                    </tr>
                </thead>
                <?php $i=1;foreach($details as $row){?>
                <tr id="row_<?php echo $row['id'];?>">
                    <td>
                        <?php echo $i;?>
                    </td>
                    <td>
                        <?php echo $row['registration_number'];?>
                    </td>
                    <td>
                        <?php echo $row['contact_number'];?>
                    </td>
                    <td>
                        <?php echo $row['building_name'];?>
                    </td>
                    <td>
                        <?php echo $row['room_number'];?>
                    </td>

                    <td>
                        <?php if($row['status'] == "alloted" && $row['check_in'] ==""){?>
                            <!-- <span class="registered">Allotted</span> -->
                            <span class="paymentcompleted">Payment Pending</span>
                        <?php } ?>
                        <?php if($row['status'] == "alloted" && $row['check_in'] !=""){?>
                            <span class="admitted">Check In</span>
                        <?php } ?>

                        <?php if($row['status'] == "checkin") {?>
                            <span class="admitted">Check In</span>
                        <?php } ?>

                        <?php if($row['status'] == "checkout") {?>
                            <span class="inactivestatus">Check Out</span>
                        <?php } ?>

                        <?php if($row['status'] == "payment pending") {?>
                            <span class="paymentcompleted">Payment Pending</span>
                        <?php } ?>
                    </td>
                    <td>
                       <?php if($row['check_in'] !="1970-01-01" && $row['check_in'] !=""){echo date('d-m-Y',strtotime($row['check_in']));}?> 
                    </td>
                    <td>   
                        <?php if($row['check_out'] !="1970-01-01" && $row['check_out'] !=""){echo date('d-m-Y',strtotime($row['check_out']));}?>
                    </td>
                    <td>
                        <?php if($row['status'] == "payment pending"){ ?>
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_roomdata(<?php echo $row['id'];?>)">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_bookedroomdata(<?php echo $row['id'];?>)"><i class="fa fa-trash-o"></i></a>
                        <?php } ?>
                        <button onclick="get_hostel_rent(<?php echo $row['student_id'];?>)" class="btn btn-primary btn-sm btn_details_view" >
                            View and Pay Hostel Rent
                        </button>
                    </td>
                </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<div class="chartBlock" id="chartBlock">
    <div class="chartBlockWrapper">
        <button class="close_btn">
            <i class="fa fa-arrow-right"></i>
        </button>
        <div class="scroller dirroombooking" id="loadalldatas">
            <h4 class="modal-title">
                Hostel Rent Payment 
            </h4>
            <div class="modal-body">
                <div class="row" id="fee_details">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">


        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo $this->lang->line('edit_alloted_roomdetails');?>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form id="change_room" type="post">
                <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="id" id="id" />
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('building');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="building_id" id="buildingid" onchange="get_rooms();">
                                        <option value=""><?php echo $this->lang->line('select_building');?></option>
                                        <?php
                                        foreach($buildingArr as $row) {
                                            echo '<option value="'.$row['building_id'].'">'.$row['building_name'].'</option>';
                                        }
                                        ?>
                                    </select>
                            </div>
                        </div>


                       <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('floor');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="floor_id" id="floor_id" onchange="get_rooms();">
                                        <option value=""><?php echo $this->lang->line('select_floor');?></option>

                                    </select>
                            </div>
                        </div>
                       <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('room_type');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="roomtype_id" id="roomtype_id" onchange="get_rooms();">
                                        <option value=""><?php echo $this->lang->line('select_roomtype');?></option>
                                        <?php
                                        foreach($roomTypeArr as $row) {
                                            echo '<option value="'.$row['roomtype_id'].'">'.$row['room_type'].'</option>';
                                        }
                                        ?>
                                    </select>
                            </div>
                        </div>
                        
                       <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('status');?></label>
                                <select class="form-control" name="status" id="edit_status" >
                                                                               
                                    </select>
                            </div>
                        </div>
                       <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12" id="show_date">
                            <div class="form-group"><label><?php echo $this->lang->line('date');?><span class="req redbold">*</span></label>
                               <input class="form-control currentdate" type="text" name="date" id="date" placeholder="Date" autocomplete="off"><span class="req redbold" id="date_msg" onkeypress="return ValDate(event)"></span>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="roomStructure">
                                <label><?php echo $this->lang->line('rooms');?><span class="req redbold">*</span></label>
                                <ul class="rooms" id="show_rooms">

                                </ul>
                                <span id="room_msg" class="error"></span>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-success"><?php echo $this->lang->line('save');?></button>
                    <button class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>

                </div>
            </form>
        </div>

    </div>
</div>



<?php $this->load->view("admin/scripts/search_roombooking_script");?>
