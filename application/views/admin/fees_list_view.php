<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="transparent_card ">
        <!-- Data Table Plugin Section Starts Here -->
        <div class="row " id="showmsg">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                <button class="btn btn-default pagination_nav ">
                                    <i class="fa fa-caret-left "></i>
                                </button>
                <button class="btn btn-default pagination_nav ">
                                    <i class="fa fa-caret-right "></i>
                                </button>
                <span class="number_records ">
<!--                                    Showing 1-10 of 103 records.-->
                                </span>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right flex-row-reverse ">
                
                <button class="btn btn-default add_row add_new_btn" data-toggle="modal" data-target="#myModal">
                                    <i class="fa fa-plus "></i>
                                </button>

            </div>
        </div>
        <ul class="data_table " id="institute_data">
            <li class="data_table_head ">
                <div class="col sl_no ">Sl. No.
                    <div class="sort_option ">
                        <button class="btn btn-default sort_up ">
                                            <i class="fa fa-caret-left "></i>
                                        </button>
                        <button class="btn btn-default sort_down ">
                                            <i class="fa fa-caret-right "></i>
                                        </button>
                    </div>
                </div>
                <div class="col  ">Batch<div class="sort_option ">
                        <button class="btn btn-default sort_up ">
                                            <i class="fa fa-caret-left "></i>
                                        </button>
                        <button class="btn btn-default sort_down ">
                                            <i class="fa fa-caret-right "></i>
                                        </button>
                    </div></div>
                <div class="col ">Batch code
                    <div class="sort_option ">
                        <button class="btn btn-default sort_up ">
                                            <i class="fa fa-caret-left "></i>
                                        </button>
                        <button class="btn btn-default sort_down ">
                                            <i class="fa fa-caret-right "></i>
                                        </button>
                    </div>

                </div>
                <div class="col ">Centre
                    <div class="sort_option ">
                        <button class="btn btn-default sort_up ">
                                            <i class="fa fa-caret-left "></i>
                                        </button>
                        <button class="btn btn-default sort_down ">
                                            <i class="fa fa-caret-right "></i>
                                        </button>
                    </div>

                </div>
                <div class="col ">Fees
                    <div class="sort_option ">
                        <button class="btn btn-default sort_up ">
                                            <i class="fa fa-caret-left "></i>
                                        </button>
                        <button class="btn btn-default sort_down ">
                                            <i class="fa fa-caret-right "></i>
                                        </button>
                    </div>

                </div>
                <div class="col actions">Action
                    <div class="sort_option ">
                        <button class="btn btn-default sort_up ">
                                            <i class="fa fa-caret-left "></i>
                                        </button>
                        <button class="btn btn-default sort_down ">
                                            <i class="fa fa-caret-right "></i>
                                        </button>
                    </div>

                </div>

            </li>
            <?php  
            if(!empty($batchArr)) {
            $i=1; foreach($batchArr as $batch){?>
            <li id="row_<?php echo $batch['batch_id'];?>">

                <div class="col sl_no " >
                    <?php echo $i;?>
                </div>
                <div class="col">
                    <?php echo $batch['batch_name'];?>
                </div>
                <div class="col">
                    <?php echo $batch['batch_code'];?>
                </div>
                <div class="col">
                     <?php echo $batch['institute_name'];?>
                </div>
                 <div class="col">
                     <?php echo $batch['institute_name'];?>
                </div>
                <div class="col actions ">
                    <button class="btn btn-default option_btn getbatchdetails" title="Edit" data-toggle="modal" data-target="#myModal"  id="<?php echo $batch['batch_id'];?>">
                                    <i class="fa fa-pencil "></i>
                                    </button>

                    
                    <a class="btn btn-default option_btn" title="Delete" onclick="delete_fromtable('<?php echo $batch['batch_id'];?>')">
                                    <i class="fa fa-trash-o"></i>
                                    </a>


                </div>
            </li>

            <?php $i++; } 
            } else {
            ?>
            <li>No batch added</li>
            <?php } ?>

        </ul>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<!--modal-->

<div id="myModal" class="modal fade form_box" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Course fee</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                
                
                <p id="errormsg"></p>
                 <form id="add_batch_form" type="post">
                <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Group<span class="req redbold">*</span></label>
                                <select class="form-control" name="group_name" id="group_name">
                                    <?php 
                                    foreach($groupArr as $row) {
                                        echo '<option value="'.$row['institute_master_id'].'">'.$row['institute_name'].'</option>';
                                    }
                                    ?>
                                </select>
                        </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Branch<span class="req redbold">*</span></label>
                                <select class="form-control" name="branch_name" id="branch">
                                   <option value="">Select</option> 
                                </select>
                        </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Centre<span class="req redbold">*</span></label>
                                <select class="form-control" name="center_name" id="center">
                                    <option value="">Select</option>
                                </select>
                        </div>
                        </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Courses<span class="req redbold">*</span></label>
                                <select class="form-control" name="course_name" id="courses">
                                    <option value="">Select</option>
                                    <?php 
                                    //foreach($classesArr as $class) {
                                       //echo '<option value="'.$class['class_id'].'">'.$class['class_name'].'</option>' ;
                                    //}?>
                                </select>
                        </div>
                        </div>
                        <input class="form-control" type="text" name="batch_id" id="batch_id">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Batch Name<span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="batch_name" id="batch_name" placeholder="Batch Name"></div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Mode<span class="req redbold">*</span></label>
                                <select class="form-control" name="mode" id="mode">
                                    <option value="">Select</option>
                                    <?php 
                                    $modes = $this->common->get_modes();
                                    foreach($modes as $mode) {
                                       echo '<option value="'.$mode['mode_id'].'">'.$mode['mode'].'</option>' ;
                                    }?>
                                </select>
                        </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>Start Date<span class="req redbold">*</span></label>
                                    <input class="form-control calendarclass" type="text" name="start_date" id="start_date" placeholder="Start Date"></div>
                            </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group"><label>End date<span class="req redbold">*</span></label>
                                    <input class="form-control calendarclass" type="text" name="end_date" id="end_date"  placeholder="End date"></div>
                            </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group"><label>Total No of Student<span class="req redbold">*</span></label>
                                    <input class="form-control" type="text" name="no_student" id="no_student" placeholder="Total No of Student"></div>
                            </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"  id="parent_div">
                            
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">

                            <button class="btn btn-info">Save</button>
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
<div id="edit_institute" class="modal fade form_box" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Institute</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                 <form id="edit_institute_form" type="post">
                <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <input type="hidden" name="institute_master_id" id="edit_instituteid"/>
                            <div class="form-group"><label>Institute Name<span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="institute_name" placeholder="Institute Name" id="edit_institutename"></div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Type<span class="req redbold">*</span></label>
                                <select class="form-control" name="institute_type_id" id="edit_type" >
                                <option value="">Select</option>
                                    <?php foreach($typeArr as $type){?>
                                <option value="<?php echo $type['institute_type_id'];?>"><?php echo $type['institute_type'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="edit_div">
                           
                        </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">

                            <button class="btn btn-info">Save</button>
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
<?php $this->load->view("admin/scripts/institute_course_mapping_script.php");?>
