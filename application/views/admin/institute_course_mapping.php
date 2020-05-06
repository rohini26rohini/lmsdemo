<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6>Centre Course Mapping</h6>
        <hr>
        <!-- <div class="row ">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right flex-row-reverse ">
                <button class="btn btn-default add_row btn_map" onclick="redirect('admin-course');">
                    Course
                </button>
                <button class="btn btn-default add_row btn_map" onclick="clear_id(); formclear('institute_course_formadd');" data-toggle="modal" data-target="#myModal">
                   Add Center Course mapping
                </button>
            </div>
        </div> -->
        <div class="addBtnPosition text-right flex-row-reverse">
            <button class="btn btn-default add_row btn_map" onclick="redirect('admin-course');">
                Course
            </button>
            <button class="btn btn-default add_row btn_map" onclick="clear_id(); formclear('institute_course_formadd');" data-toggle="modal" data-target="#myModal">
                Add Centre Course mapping
            </button>
        </div>
       
        <!-- <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 "> -->
                <div class="table-responsive table_language" style="margin-top:15px;">
                    <table id="institute_data" class="table table-striped table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th >Sl. No.</th>
                                <th>Centre</th>
                                <th>Course</th>
                                <th>Total Fee</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <?php $i=1; foreach($mappingArr as $map){  ?>
                            <tr id="row_<?php echo $map['institute_course_mapping_id'];?>">
                                <td><?php echo $i;?></td>
                                <td><?php echo $map['institute_name'];?></td>
                                <td><?php echo $map['class_name'];?></td>
                                <td><?php echo $map['course_totalfee'];?></td>
                                <td>
                                <!-- <a href="javascript: edit_mapping(<?php echo $map['institute_course_mapping_id'];?>);">
                                        <i class="fa fa-edit"></i>
                                    </a> -->
                                    <?php 
                                    $save = 0;                                 
                                    if($map['institute_course_mapping_id']>0) {
                                        $save = 0;
                                       // $started = $this->common->get_from_tableresult('am_student_course_mapping', array('institute_course_mapping_id'=>$map['institute_course_mapping_id']));
                                        $exist = $this->common->check_if_dataExist('am_student_course_mapping',array("institute_course_mapping_id"=>$map['institute_course_mapping_id']));
                                        //if(!empty($started)) {
                                        if(!empty($exist!=0)) {
                                            $save = 1;   
                                        }
                                    } 
                                    if($save==0) {
                                    ?>
                                    <span class="btn mybutton" onclick="edit_mapping(<?php echo $map['institute_course_mapping_id'];?>);">Edit</span>
                                    <span class="btn mybutton" onclick="delete_mapping(<?php echo $map['institute_course_mapping_id'];?>);">Delete</span>
                                    <?php } else { ?>
                                    <span class="btn mybutton" onclick="view_mapping(<?php echo $map['institute_course_mapping_id'];?>);" data-toggle="modal" data-target="#show">View</span>
                                    <?php } ?>
                                    <?php if($map['status'] != 1) { ?>
                                    <span class="btn mybutton" onclick="renew_fee(<?php echo $map['institute_course_mapping_id'];?>);">Renew fee</span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php $i++;} ?>
                    </table>
                </div>    
            <!-- </div>
        </div> -->
    </div>
        <!-- Data Table Plugin Section Starts Here -->
</div>

<div id="myModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Course and fee management</h4>
                <button type="button" class="close" onclick="clear_id()" data-dismiss="modal">&times;</button>
            </div>
            <form autocomplete="off" id="institute_course_formadd" method="post">
                <div class="modal-body">
                    <!--<div id="toastCode"></div>-->
                        <div class="row">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Group<span class="req redbold">*</span></label>
                                    <input name="institute_course_mapping_id" id="mapping_id" type="hidden" value=""/>
                                    <input name="institute_course_fee_renew" id="fee_renew" type="hidden" value=""/>
                                    <select class="form-control" name="group_master_id" id="group">
                                        <option value="">Select</option>
                                        <?php 
                                        foreach($groupArr as $group){?>
                                        <option value="<?php  echo $group['institute_master_id'] ?>"><?php  echo $group['institute_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Branch<span class="req redbold">*</span></label>
                                    <select class="form-control" name="branch_master_id" id="branch">
                                        <option value="">Select</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Centre<span class="req redbold">*</span></label>
                                    <select class="form-control" name="institute_master_id" id="center">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Course<span class="req redbold">*</span></label>
                                    <select class="form-control" name="course_master_id" id="course">
                                        <option value="">Select</option>
                                        <?php foreach($classesArr as $course){?>
                                        <option value="<?php echo $course['class_id']; ?>"><?php echo $course['class_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>Fee definitions<span class="req redbold">*</span></label>
                                    <select class="form-control" name="fee_definition" id="fee_definition">
                                        <option value="">Select a fee definition</option>
                                        <?php 
                                            if(!empty($fee_def)){
                                                foreach($fee_def as $row){
                                                    echo '<option value="'.$row->fee_definition_id.'">'.$row->fee_definition.'</option>';
                                                }
                                            } 
                                         ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="fee_heads_container"> </div>
                        <div class="row">
                            <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>Total Fee<span class="req redbold">*</span></label>
                                    <input readonly class="form-control" type="text" name="course_tuitionfee" id="tuition_fee" placeholder="Tuition Fee">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>CGST <?php echo $config['CGST'].'%';?></label>
                                    <input class="form-control" type="text" name="course_cgst" id="cgst" placeholder="CGST" value="" readonly>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>SGST <?php echo $config['SGST'].'%';?></label>
                                    <input class="form-control" type="text" name="course_sgst" id="sgst" placeholder="SGST" value="" readonly>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>Total Fee</label>
                                    <input class="form-control" type="text" name="course_totalfee" id="totalfee" placeholder="Total Fee" value="" readonly>
                                </div>
                            </div> -->
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>Payment method<span class="req redbold">*</span></label>
                                    <select class="form-control" name="course_paymentmethod" id="paymentmethod">
                                        <option value="">Select</option>
                                        <option value="onetime">One Time</option>
                                        <option value="installment">Installment</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12" id="installmentnosdiv">
                                <div class="form-group"><label>Number of installments<span class="req redbold">*</span></label>
                                    <input class="form-control numbersOnly"  type="text" name="installmentnos" id="installmentnos" placeholder="Number of installments" value="">
                                    <label id="installmentnos_error" class="error"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="installments"> </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="insticentremappsave">Save</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div> 
            </form>
        </div>
    </div>
</div>
<div id="show" class="modal fade form_box" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Center Course Mapping Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills ">
                    <table class="table table_register_view ">
                        <tbody>
                            <tr>
                                <th  colspan="2" ><h6 id="coursedet_view"></h6>
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                <div class="media">
                                Course :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="course_view"></span></label>
                                    </div>
                                 </div>    
                                </th>
                                <th width="50%">
                                <div class="media">
                                Branch :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="branch_view"></span></label>
                                    </div>
                                 </div>     
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                <div class="media">
                                Center :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="center_view"></span></label>
                                    </div>
                                 </div>      
                       
                                </th>
                                <th width="50%">
                                    <div class="media">
                                Mode of Pay :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="mode_fee_view"></span></label>
                                    </div>
                                 </div> 
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                <div class="media">
                                Tuition Fee :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="tuition_fee_view"></span></label>
                                    </div>
                                 </div>      
                       
                                </th>
                                <th width="50%">
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                <div class="media">
                                CGST            :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="cgst_fee_view"></span></label>
                                    </div>
                                 </div>      
                       
                                </th>
                                <th width="50%">
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                <div class="media">
                                SGST          :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="sgst_fee_view"></span></label>
                                    </div>
                                 </div>      
                       
                                </th>
                                <th width="50%">
                                </th>
                            </tr>
                            <tr id="cessrow">
                                <th width="50%">
                                <div class="media">
                                Cess [<span id="cess_fee_val"></span>]          :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="cess_fee_view"></span></label>
                                    </div>
                                 </div>      
                       
                                </th>
                                <th width="50%">
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                <div class="media">
                                Total Fee     :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="total_fee_view"></span></label>
                                    </div>
                                 </div>      
                       
                                </th>
                                <th width="50%">
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table_register table-bordered table-striped text-center" id="installmentload">
                        
                    </table>

                </ul>

                <div class="tab-content">
                    <div id="head1" class="tab-pane active">
                    <p id="errormsg"></p>
                        <form id="history" type="post">
                            <div class="row">
                                <input type="hidden" class ="exclude-status" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <input type="hidden" name="call_id" class="form-control exclude-status" id="history_call_id"/>

                              
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="table-responsive table_language" id="history_view"></div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div id="head2" class="tab-pane">
                    <p id="errormsg"></p>
                        <form id="add_followup" type="post">
                            <div class="row">
                            <input type="hidden" class ="exclude-status" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                            <input type="hidden" name="call_id" class="form-control exclude-status" id="follow_call_id" />
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Date & Time<span class="req redbold">*</span></label>
                                        <input class="form-control datetime" type="text" name="date" placeholder="Date & Time" id="date" data-validate="required" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Status<span class="req redbold">*</span></label>
                                        <select class="form-control" name="status" id="status" data-validate="required">
                                            <option value="">Select Status</option>
                                            <option value="1">Answered</option>
                                            <option value="2">No Answer</option>
                                            <option value="3">Busy</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group"><label> Comments</label>
                                        <input class="form-control" type="text" name="comment" placeholder="Comments" id="comment" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <button class="btn btn-info">Update</button>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/institute_course_mapping_script");?>
