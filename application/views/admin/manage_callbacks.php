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
                    <label>Status</label>
                    <select class="form-control filter_class" name="filter_status" id="filter_status" >
                        <option value="">Select Status</option>
                        <option value="Received">Received</option>
                        <option value="Replied">Replied</option>
                        <option value="Un neccessary">Un neccessary</option>
                    </select>
                </div>
            </div> 
        </div>
    </div>
        <!-- Data Table Plugin Section Starts Here -->
        <div class="white_card">


        <div id="callback_result">
            <div class="table-responsive">
                <ul class="data_table " id="callback_data">
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
                        <div class="col  "> Date & Time<div class="sort_option ">
                            <button class="btn btn-default sort_up ">
                                <!-- <i class="fa fa-caret-left "></i> -->
                            </button>
                            <button class="btn btn-default sort_down ">
                                <!-- <i class="fa fa-caret-right "></i> -->
                            </button>
                            </div>
                        </div>
                        <div class="col  "> Name<div class="sort_option ">
                            <button class="btn btn-default sort_up ">
                                <!-- <i class="fa fa-caret-left "></i> -->
                            </button>
                            <button class="btn btn-default sort_down ">
                                <!-- <i class="fa fa-caret-right "></i> -->
                            </button>
                            </div>
                        </div>
                        <div class="col ">Status
                            <div class="sort_option ">
                                <button type="button" class="btn btn-default sort_up ">
                                    <!-- <i class="fa fa-caret-left "></i> -->
                                </button>
                                <button type="button" class="btn btn-default sort_down ">
                                    <!-- <i class="fa fa-caret-right "></i> -->
                                </button>
                            </div>
                        </div>
                        <div class="col actions">Action
                            <div class="sort_option ">
                                <button class="btn btn-default sort_up ">
                                    <!-- <i class="fa fa-caret-left "></i> -->
                                </button>
                                <button class="btn btn-default sort_down ">
                                    <!-- <i class="fa fa-caret-right "></i> -->
                                </button>
                            </div>
                        </div>
                    </li>
                    <?php 
                    $i=1; foreach($callbackArr as $query){?>
                    <li>
                        <div class="col sl_no ">
                            <?php echo $i;?>
                        </div>
                        <div class="col">
                            <?php $date=strtotime($query['created_time']); echo date("d/m/Y h:i:s a",$date);?>
                        </div>
                        <div class="col">
                            <?php echo $query['enquiry_name'];?>
                        </div>
                        <div class="col ">
                            <div class="form-group form_zero" >
                                <select class="form-control" name="call_back_status" id="call_back_status_<?php echo $query['enquiry_id'];?>" onchange="get_val(<?php echo $query['enquiry_id'];?>)">
                                    <?php 
                                    if($query['status']=="Received"){
                                        echo '<option selected value="Received">Received</option>
                                            <option value="Replied">Replied</option>
                                            <option value="Un neccessary">Blacklisted</option>';
                                    }else if($query['status']=="Replied"){
                                        echo '<option  value="Received">Received</option>
                                            <option selected value="Replied">Replied</option>
                                            <option value="Un neccessary">Blacklisted</option>';
                                    }else{
                                        echo '<option  value="Received">Received</option>
                                        <option value="Replied">Replied</option>
                                        <option selected value="Un neccessary">Blacklisted</option>';
                                    }
                                    ?>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col actions ">
                            <button class="btn btn-default option_btn " title="View" data-toggle="modal" data-target="#view_queries" onclick="get_callback(<?php echo $query['enquiry_id'];?>)">
                                <i class="fa fa-eye "></i>
                            </button>
                        </div>
                    </li>
                    <?php $i++; } ?>
                </ul>
            </div>
        </div>

        <!-- <ul class="data_table ">
            <li class="data_table_head ">
                <div class="col  ">Sl. No.
                    <div class="sort_option ">
                        <button class="btn btn-default sort_up ">
                            <i class="fa fa-caret-left "></i>
                        </button>
                        <button class="btn btn-default sort_down ">
                            <i class="fa fa-caret-right "></i>
                        </button>
                    </div>
                </div>
                <div class="col  "> Date & Time<div class="sort_option ">
                    <button class="btn btn-default sort_up ">
                        <i class="fa fa-caret-left "></i>
                    </button>
                    <button class="btn btn-default sort_down ">
                        <i class="fa fa-caret-right "></i>
                    </button>
                    </div>
                </div>
                <div class="col  "> Name<div class="sort_option ">
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
            <?php //echo "<pre>";print_r($callbackArr);
            $i=1; foreach($callbackArr as $query){?>
            <li>
                <div class="col  ">
                    <?php echo $i;?>
                </div>
                <div class="col">
                    <?php $date=strtotime($query['created_time']); echo date("d-m-Y h:i:s a",$date);?>
                </div>
                <div class="col">
                    <?php echo $query['enquiry_name'];?>
                </div>
                <div class="col actions ">
                    <button class="btn btn-default option_btn " data-toggle="modal" data-target="#view_queries" onclick="get_callback(<?php echo $query['enquiry_id'];?>)">
                        <i class="fa fa-eye "></i>
                    </button>
                   
                </div>
            </li>
            <?php $i++; } ?>
        </ul> -->
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>


<div id="view_callbacks" class="modal fade form_box" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive table_view_model">
                    <table class="table table-striped">
                        <tr>
                            <th>Name:</th>
                            <td id="name"></td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td id="phone"> </td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td id="email"> </td>
                        </tr>
                        <tr>
                            <th>Message:</th>
                            <td id="location"> </td>
                        </tr>
                    </table>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="table-responsive table_language" id="history_view"></div>
                    </div>
                        <!-- <tr>
                            <th>Notes:</th>
                            <td id="notes"> </td>
                        </tr> -->
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div id="description_modal" class="modal fade form_box" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Call back</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="tab-content">
                    <form id="add_description" type="post">
                        <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="enquiry_id" class="form-control" id="enquiry_id" />
                        <input type="hidden" name="status" class="form-control" id="status" />

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group"><label> Description</label>
                                    <input class="form-control" type="text" name="description" placeholder="Description" id="description">
                                </div>
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
</div>
<?php $this->load->view("admin/scripts/manage_callback_script");?>
