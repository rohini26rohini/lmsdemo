<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6><?php echo $this->lang->line('manage_result');?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_result" onclick="formclear('add_result_form')">
            Add results
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th ><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('exam_name');?></th>
                        <th ><?php echo $this->lang->line('school');?></th>
                        <th ><?php echo $this->lang->line('location');?></th>
                        <th ><?php echo $this->lang->line('name');?></th>
                        <th ><?php echo $this->lang->line('rank');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; foreach($resultArr as $result){?>
                <tr id="row_<?php echo $result['result_id'];?>">
                    <td>
                        <?php echo $i;?>
                    </td>
                    <td id="notification_name_<?php echo $result['result_id'];?>">
                        <?php echo $result['notification_name'];?>
                    </td>
                    <td id="school_name_<?php echo $result['result_id'];?>">
                        <?php echo $result['school_name'];?>
                    </td>
                    <td id="scity_id_<?php echo $result['result_id'];?>">
                        <?php echo $result['city_id'];?>
                    </td>
                    <td id="sname_<?php echo $result['result_id'];?>">
                        <?php echo $result['name'];?>
                    </td>
                    <td id="rank_<?php echo $result['result_id'];?>">
                        <?php echo $result['rank'];?>
                    </td>
                    <td>
                        <!-- <button  type="button" class="btn btn-default option_btn " onclick="get_details('<?php echo $result['result_id'];?>')" title="Click here to view the details" data-toggle="modal" data-target="#view_result" style="color:blue;cursor:pointer;">
                            <i class="fa fa-eye "></i>
                        </button> -->
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_resultdata(<?php echo $result['result_id'];?>)">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_result(<?php echo $result['result_id'];?>)">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>


<!--edit result modal-->
<div id="edit_result" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit result</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form enctype="multipart/form-data" id="edit_result_form" method="post" >
                <div class="modal-body" >
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="edit_result_id" id="edit_result_id" value=""/>
                        <input type="hidden" name="counter" id="edit_counter" value="" />
                        <input type="hidden" name="files" id="resultfiles"  />

                       
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('school');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="school_id" id="edit_school_id" disabled>
                                    <option value="" disabled>Select School</option>
                                    <?php foreach($schoolArr as $school){
                                        // $selected = '';
                                        // if($schoolArr['school_id'] == $school['school_id']){
                                        //     $selected = 'selected="selected"';
                                        // }
                                        echo '<option value="'.$school['school_id'].'" >'.$school['school_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('exam');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="notification_id" id="edit_notification_id" disabled>
                                    <option value="0">Select Exam</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" >
                            <div class="table-responsive table_language resTbl" id="hall_tkt_edit"> 
                                <table class="table table-bordered table-striped table-sm" id="edit_no-more-tables">
                                    <!-- <thead>
                                        <tr>
                                            <th>Stop Name<span class="req redbold">*</span></th>
                                            <th>Distance<span class="req redbold">*</span></th>
                                            <th>Route Fare/ Monthly<span class="req redbold">*</span></th>
                                            <th>Location</th>
                                            <th>Latitude<span class="req redbold">*</span></th>
                                            <th>Longitude<span class="req redbold">*</span></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  
                                            // $route =$this->common->get_from_table('tt_transport_stop',array('transport_id'=>$_POST['transport_id'])); 
                                            // foreach($routeArr as $row){ 
                                            //$stopArr=$this->transport_model->get_stop_byroute($route['transport_id']);
                                            // }
                                            //foreach ($stopArr as $stopskey =>$value) {
                                        ?>
                                            <tr id="edit_stop_tr_<?php //echo $stopskey; ?>" class="tr">
                                                <td>
                                                    <input  type="text" placeholder="Stop Name" class="stopname form-control" id="name_[<?php //echo $stopskey; ?>]" value="<?php //echo $value['name']; ?>" onclick="getstopname(this.id)" autocomplete="off"/>
                                                </td>
                                                <td>
                                                    <input type="text"  placeholder="Distance" class="form-control distance numberswithdecimal" value="<?php //echo $value['distance']; ?>" >
                                                </td>
                                                <td>
                                                    <input type="text"  placeholder="Route Fare" class="form-control route_fare numberswithdecimal" value="<?php //echo $value['route_fare']; ?>" >
                                                </td>
                                                <td>
                                                    <input type="button"   name="geo[' + counter + ']" id="geo_'+ counter + '" placeholder="Location" class="btn btn-info btn-sm exclude-status" value="Geo Map" data-toggle="modal" data-target="#myModal" onclick="initMap('+counter+');">
                                                </td>
                                                <td>
                                                    <div class="form_zero">
                                                        <input  type="text" class="form-control numberswithdecimal" id="latitude_<?php //echo $stopskey; ?>" value="<?php //echo $value['latitude']; ?>"  placeholder="Latitude" readonly="readonly"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form_zero">
                                                        <input  type="text" class="form-control numberswithdecimal" id="longitude_<?php //echo $stopskey; ?>" value="<?php //echo $value['longitude']; ?>"  placeholder="Longitude" readonly="readonly" />
                                                    </div>
                                                </td>
                                                <td data-title=""> 
                                                    <button type="button" rel="tooltip" title="Click here to remove the stop" class="btn btn-default add_wrap_pos add_action minusButton btn btn-danger btn-xs" id="<?php //echo $value['stop_id']; ?>" value="<?php //echo $stopskey; ?>" onclick="deletefunction(this.id)"><i class="fa fa-remove"></i></button>
                                                </td>
                                            </tr>
                                        <?php //} ?>
                                    </tbody> -->
                                </table>
                            </div>
                            <!-- <div id="edit_new_textbox">
                                <button type="button" class="btnNewAdd pull-right btn btn-info btn-sm edit_addButtonNewId tooltipstered" id="edit_addButtonNewId" title="Click here to add more stop" style="margin-bottom: 15px;" onclick="edit_createNewTextBox()">  <i class="fa fa-plus"></i>Add More Stops</button>
                            </div> -->
                        </div>
                    </div>
                </div> 
                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>  
            </form>
        </div>
    </div>
</div>

<!--add result modal-->
<div id="add_result" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add result</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form enctype="multipart/form-data" id="add_result_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="counter" id="counter" value="" />

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('school');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="school_id" id="school_id"  onchange="get_exams()">
                                    <option value="">Select School</option>
                                    <?php foreach($schoolArr as $school){
                                        // $selected = '';
                                        // if($schoolArr['school_id'] == $school['school_id']){
                                        //     $selected = 'selected="selected"';
                                        // }
                                        echo '<option value="'.$school['school_id'].'" >'.$school['school_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('exam');?><span class="req redbold">*</span></label>
                                <select class="form-control" name="notification_id" id="notification_id">
                                    <option value="0">Select Exam</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="table-responsive table_language resTbl">
                                <table class="table table-bordered table-striped table-sm" id="no-more-tables">
                                    <thead>
                                        <tr>
                                            <th>Hall Ticket Number<span class="req redbold">*</span></th>
                                            <th>Name<span class="req redbold">*</span></th>
                                            <th>Rank<span class="req redbold">*</span></th>
                                            <th>Upload Image<span class="req redbold">*</span></th>
                                            <th>Location<span class="req redbold">*</span></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- <tr>
                                            <td>Chaavadimukku</td>
                                            <td>450KM</td>
                                            <td><button class="btn btn-info btn-sm">Geo Location</button></td>
                                            <td>
                                                <div class="form_zero">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="Latitude">
                                                        <input type="text" class="form-control" placeholder="Longitude">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div id="new_textbox">
                                                    <button class="btn btn-default add_wrap_pos add_action addButtonNewId"  id="addButtonNewId" title="Click here to add more stop"> <i class="fa fa-plus"></i> </button>
                                                </div>
                                            </td>
                                        </tr> -->
                                        <!-- <tr>
                                            <td>Chaavadimukku</td>
                                            <td>450KM</td>
                                            <td><button class="btn btn-info btn-sm">Geo Location</button></td>
                                            <td>
                                                <div class="form_zero">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="Latitude">
                                                        <input type="text" class="form-control" placeholder="Longitude">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-info add_wrap_pos add_action"> <i class="fa fa-minus"></i> </button>
                                            </td>
                                        </tr>  -->
                                    </tbody>
                                </table>
                            </div>
                            <div id="new_textbox">
                                <button type="button" class="btnNewAdd pull-right btn btn-info btn-sm addButtonNewId" id="addButtonNewId" title="Click here to add more results" onclick="createNewTextBox()">  <i class="fa fa-plus"></i>Add More Results</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" name="submit" id="submit">Save</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div> 
            </form>
        </div>
    </div>
</div>

<!--view result modal-->
<div id="view_result" class="modal fade form_box" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View result Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive table_view_model">
                    <table class="table table-striped">
                        <input type="hidden"  name="stop_id" class="form-control exclude-status" id="stop_id"/>
                        <tbody>
                            <tr>
                                <th width="50%">
                                    <div class="media">
                                    result Number :
                                        <div class="media-body">
                                            <label class="mt-0 ml-2 mb-0"><span id="view_result_number"></span></label>
                                        </div>
                                    </div>    
                                </th>
                                <th width="50%">
                                    <div class="media">
                                    result Name :
                                        <div class="media-body">
                                            <label class="mt-0 ml-2 mb-0"><span id="view_result_name"></span></label>
                                        </div>
                                    </div>     
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                    <div class="media">
                                    Vehicle Number :
                                        <div class="media-body">
                                            <label class="mt-0 ml-2 mb-0"><span id="view_vehicle_number"></span></label>
                                        </div>
                                    </div>    
                                </th>
                                <th width="50%">
                                    <div class="media">
                                    Driver :
                                        <div class="media-body">
                                            <label class="mt-0 ml-2 mb-0"><span id="view_driver"></span></label>
                                        </div>
                                    </div>     
                                </th>
                            </tr>
                            
                             <tr>
                                <th width="50%">
                                    <div class="media">
                                    Description :
                                        <div class="media-body">
                                            <label class="mt-0 ml-2 mb-0"><span id="view_result_description"></span></label>
                                        </div>
                                    </div>    
                                </th>
                                <th width="50%">
                                         
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="table-responsive table_language" id="stop_view"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("admin/scripts/result_script");?>
