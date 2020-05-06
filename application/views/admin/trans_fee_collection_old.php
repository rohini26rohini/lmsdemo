<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <form id="filter_form" method="post" >
        <div class="white_card ">
            <h6><?php echo $this->lang->line('manage_transport_fee');?></h6>
            <hr>
            <div class="row filter">
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('application.no');?></label>
                        <input type="text" id="applicationno" class="form-control" placeholder="Search..." />
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" id="filter_name" class="form-control" placeholder="Search..."/>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                    <label>Email</label>
                        <input type="text" id="email" class="form-control" placeholder="Search..."/>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                    <label>Contact Number</label>
                        <input type="text" id="mobileno" class="form-control" placeholder="Search..."/>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                    <label>Route</label>
                        <select id="route" class="form-control">
                            <option value="" selected="selected">Select route</option>
                            <?php
                            if(!empty($routes)) {
                                foreach($routes as $route) {
                                    echo '<option value="'.$route->transport_id.'">'.$route->route_name.'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 col-12">
                    <div class="form-group">
                        <label style="display:block;">&nbsp;</label>
                        <button type="button" id="searchbutton" class="btn btn-default add_row add_new_btn btn_add_call">
                            Search
                        </button>
                        <button type="button" id="resetbutton" class="btn btn-default add_row add_new_btn btn_add_call">
                            Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <!-- Data Table Plugin Section Starts Here -->
        <div class="white_card">
            <div class="table-responsive table_language" style="margin-top:15px;">
                <table id="institute_data" class="table table-striped table-sm dirstudent-list" style="width:100%">
                    <thead>
                        <tr>
                            <th class="dirslslno" width="50"><?php echo $this->lang->line('sl_no');?></th>
                            <th><?php echo $this->lang->line('name');?></th>
                            <th><?php echo $this->lang->line('application.no');?></th>
                            <th class="diremailli"><?php echo $this->lang->line('emailid');?></th>
                            <th><?php echo $this->lang->line('contact.no');?></th>
                            <th><?php echo $this->lang->line('route');?></th>
                            <th><?php echo $this->lang->line('status');?></th>
                            <th class="dirbaksl"><?php echo $this->lang->line('action');?></th>
                        </tr>
                    </thead>
                    <?php 
                    $i=1; foreach($studentArr as $student){  
                    if($student['transportation'] == 'no') {
                        $paid = $this->common->get_from_tablerow('tt_payments', array('student_id'=>$student['student_id'])); 
                    }    
                    $ccstatus = '';
                    if($student['caller_id']>0) { 
                    $callcentre = $this->common->get_from_tablerow('cc_call_center_enquiries', array('call_id'=>$student['caller_id']));
                    if(!empty($callcentre['call_status'])){
                    $ccstatus = $callcentre['call_status'];
                    } }

                    if($student['transportation']=='yes' || ($student['transportation']=='no' && !empty($paid))) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td>
                            <?php echo $student['registration_number'];?>
                        </td>
                        <td>
                            <?php echo $student['name'];?>
                        </td>
                        <td>
                            <?php echo $student['email'];?>
                        </td>
                        <td>
                            <?php echo $student['contact_number'];?>
                        </td>
                        <td>
                            <?php echo $student['route_name'];?>
                        </td>
                        <td><?php 
                                if ($student['transportation']== 'yes') { echo '<span class="admitted">Active</span>';}
                                else if($student['transportation']=='no') { echo '<span class="paymentcompleted">Cancelled</span>';}
                            ?>  
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm btn_details_view transpay" onclick="loadpayscreen('<?php echo $student['student_id'];?>')">
                             Pay   
                            </a>
                        </td>
                    </tr>
                    <?php $i++; } } ?>
                </table>
            </div>
            <!-- Data Table Plugin Section Starts Here -->
        </div>
    <!-- </form> -->
</div>
<div id="myModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Student</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form enctype="multipart/form-data" id="add_form" method="post">
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group"><label>Status <span class="req redbold">*</span></label>
                            <select class="form-control" name="status" id="status_change">
                                <option value="">Select</option>
                                <option value="1">Active</option>
                                <option value="5">Inactive</option>
                            </select>
                           
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="show_desc" style="display:none;">
                        <div class="form-group"><label>Description<span class="req redbold">*</span></label>
                            <input type="text" name="description" class="form-control" />
                        </div>
                    </div>
                    
                    <input type="hidden" name="id" id="status_id"/>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit">Save</button>
                <a class="btn btn-default" data-dismiss="modal">Cancel</a>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="hidden" id="videoDiv">
    <a class="videoDiv-link" href="#"></a>
</div>
<div id="imagesDiv" class="container ">
    <a class="imagesDiv-link" href="#">
    <div class="row">
        <div class="col-md-12">
            <button class="close_btn">
                <i class="fa fa-arrow-right transfeeclose"></i>
            </button>
        </div>
    </div></a>
    <span id="loadpaymentscreen"></span>
</div>
<style>
.hidden {
    background-color: #fff;
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0px;
    bottom: 0px;
    left: 0px;
    right: 0px;
    overflow: hidden;
}
#imagesDiv {
    background-color: #fff;
    width: calc(100% - 220px);
    height: 100%;
    position: fixed;
    top: 0px;
    bottom: 0px;
    right: 0px;
    overflow: hidden;
    display: none;
    z-index: 10000;
    background-size: 1000px;
    font-size: 20px;
    text-align: justify;
}
.dirtransportation{
    padding: 30px;
}
.dirtransportation h6{
    color: #000;
    font-family: bold;
    font-size: 14px;
}

.dirtransportation .table tr th {
    background-color: #014e94;
    color: #fff;
    font-family: s-bold;
}
.dirtransportation .dirtransporttitle{
    margin-top:20px;
}
</style>
<?php $this->load->view("admin/scripts/trans_studentlist_script");?>
