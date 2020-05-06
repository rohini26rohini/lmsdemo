<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6><?php echo $this->lang->line('manage_route');?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_route" onclick="formclear('add_route_form')">
            Add Routes
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th >Route Number</th>
                        <th >Route Name</th>
                        <th ><?php echo $this->lang->line('vehicle_number');?></th>
                        <th ><?php echo $this->lang->line('description');?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; foreach($routeArr as $route){?>
                <tr id="row_<?php echo $route['transport_id'];?>">
                    <td>
                        <?php echo $i;?>
                    </td>
                    <td id="route_number_<?php echo $route['transport_id'];?>">
                        <?php echo $route['route_number'];?>
                    </td>
                    <td id="route_name_<?php echo $route['transport_id'];?>">
                        <?php echo $route['route_name'];?>
                    </td>
                    <td id="vehicle_number_<?php echo $route['transport_id'];?>">
                        <?php echo $route['vehicle_number'];?>
                    </td>
                    <td id="description_<?php echo $route['transport_id'];?>">
                        <?php echo $route['description'];?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-default option_btn " onclick="get_details('<?php echo $route['transport_id'];?>')" title="Click here to view the details" data-toggle="modal" data-target="#view_route" style="color:blue;cursor:pointer;">
                            <i class="fa fa-eye "></i>
                        </button>
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_routedata(<?php echo $route['transport_id'];?>)">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_route(<?php echo $route['transport_id'];?>)">
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


<!--edit route modal-->
<div id="edit_route" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Route</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="edit_route_form" method="post" >
                <div class="modal-body" >
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="edit_transport_id" id="edit_transport_id" value=""/>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Route Number<span class="req redbold">*</span></label>
                                <input type="text" name="edit_route_number" id="edit_route_number" class="form-control" placeholder="Route Number"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Route Name <span class="req redbold">*</span></label>
                                <input type="text" name="edit_route_name" id="edit_route_name"  class="form-control" placeholder="Route Name" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Driver<span class="req redbold">*</span></label>
                                <select class="form-control" name="edit_role" id="edit_role">
                                    <option value="">Select Driver</option>
                                    <?php foreach($driverArr as $driver){?>
                                    <?php  if($driver['role']=='driver'){ ?>
                                    <option value="<?php echo $driver['personal_id'] ?>"><?php  echo $driver['name'] ?></option>
                                    <?php } }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Vehicle Number<span class="req redbold">*</span></label>
                                <select class="form-control" name="edit_bus_id" id="edit_bus_id">
                                    <option value="">Select Vehicle Number</option>
                                    <?php foreach($busArr as $bus){
                                          echo '<option value="'.$bus['bus_id'].'" >'.$bus['vehicle_number'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Initial Fee/Deposits<span class="req redbold"></span></label>
                                <select class="form-control" name="fee_definition" id="edit_fee_definition" data-validate="required">
                                    <option value="0" selected="selected">Not applicable</option>
                                    <?php 
                                    $fees = $this->common->get_from_tableresult('am_fee_definition', array('fee_type'=>'Transport Fee', 'fee_definition_status'=>1));
                                    foreach($fees as $fee){
                                            echo '<option value="'.$fee->fee_definition_id.'">'.$fee->fee_definition.'</option>';
                                       
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="edit_loaddeposits">
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="edit_description" id="edit_description" placeholder="Description"></textarea>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" >
                            <div class="table-responsive table_language" id="stop_edit"> 
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
                            <div id="edit_new_textbox">
                                <button type="button" class="btnNewAdd pull-right btn btn-info btn-sm edit_addButtonNewId tooltipstered" id="edit_addButtonNewId" title="Click here to add more stop" style="margin-bottom: 15px;" onclick="edit_createNewTextBox()">  <i class="fa fa-plus"></i>Add More Stops</button>
                            </div>
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

<!--add route modal-->
<div id="add_route" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Route</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_route_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Route Number<span class="req redbold">*</span></label>
                                <input type="text" name="route_number" class="form-control numbersOnly" placeholder="Route Number" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Route Name <span class="req redbold">*</span></label>
                                <input type="text" name="route_name" class="form-control" placeholder="Route Name" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Driver<span class="req redbold">*</span></label>
                                <select class="form-control" name="role" id="role">
                                    <option value="">Select Driver</option>
                                    <?php foreach($driverArr as $key => $value){?>
                                    <?php  if($driverArr[$key]['role']=='driver'){ ?>
                                    <?php $drivers = $this->transport_model->check_driver_exists($driverArr[$key]['personal_id']); 
                                    if($drivers >0){ } else{
                                        echo '<option value="'.$driverArr[$key]['personal_id'].'">'.$driverArr[$key]['name'].'</option>';
                                    } } }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Vehicle Number<span class="req redbold">*</span></label>
                                <select class="form-control" name="bus_id" id="bus_id" data-validate="required">
                                    <option value="">Select Vehicle Number</option>
                                        <?php 
                                        foreach($busArr as $key => $value){
                                            $vehicle = $this->transport_model->check_vehicle_number_exists($busArr[$key]['bus_id']);
                                            if ($vehicle>0) { }else{
                                                echo '<option value="'.$busArr[$key]['bus_id'].'">'.$busArr[$key]['vehicle_number'].'</option>';
                                            } 
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Initial Fee/Deposits<span class="req redbold"></span></label>
                                <select class="form-control" name="fee_definition" id="fee_definition" data-validate="required">
                                    <option value="0" selected="selected">Not applicable</option>
                                        <?php 
                                        $fees = $this->common->get_from_tableresult('am_fee_definition', array('fee_type'=>'Transport Fee', 'fee_definition_status'=>1));
                                        foreach($fees as $fee){
                                                echo '<option value="'.$fee->fee_definition_id.'">'.$fee->fee_definition.'</option>';
                                        }
                                        ?>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="loaddeposits">
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description" placeholder="Description" autocomplete="off"></textarea>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="table-responsive table_language">
                                <table class="table table-bordered table-striped table-sm" id="no-more-tables">
                                    <thead>
                                        <tr>
                                            <th>Stop Name<span class="req redbold">*</span></th>
                                            <th>Distance (KM)<span class="req redbold">*</span></th>
                                            <th>Route Fare/ Monthly<span class="req redbold">*</span></th>
                                            <th>Location</th>
                                            <th>Latitude<span class="req redbold">*</span></th>
                                            <th>Longitude<span class="req redbold">*</span></th>
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
                                <button type="button" class="btnNewAdd pull-right btn btn-info btn-sm addButtonNewId" id="addButtonNewId" title="Click here to add more stop" onclick="createNewTextBox()">  <i class="fa fa-plus"></i>Add More Stops</button>
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

<!--view route modal-->
<div id="view_route" class="modal fade form_box" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Route Details</h4>
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
                                    Route Number :
                                        <div class="media-body">
                                            <label class="mt-0 ml-2 mb-0"><span id="view_route_number"></span></label>
                                        </div>
                                    </div>    
                                </th>
                                <th width="50%">
                                    <div class="media">
                                    Route Name :
                                        <div class="media-body">
                                            <label class="mt-0 ml-2 mb-0"><span id="view_route_name"></span></label>
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
                                            <label class="mt-0 ml-2 mb-0"><span id="view_route_description"></span></label>
                                        </div>
                                    </div>    
                                </th>
                                <th width="50%">
                                    <div class="media">
                                    Initial/deposit fee :
                                        <div class="media-body">
                                            <label class="mt-0 ml-2 mb-0"><span id="feeDef"></span></label>
                                        </div>
                                    </div>    
                                </th>
                            </tr>

                            <tr>
                                <th width="50%" id="fees">
                                         
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


<style>
    .map{width: 100%;height: auto;overflow: hidden;padding-top: 30px}
    #map_canvas {height:350px;width:100%}
    .controls {margin-top: 10px;border: 1px solid transparent;border-radius: 2px 0 0 2px;box-sizing: border-box;-moz-box-sizing: border-box;height: 32px;outline: none;box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);}
    #pac-input {background-color: #fff;font-family: Roboto;font-size: 15px;font-weight: 300;margin-left: 12px;padding: 0 11px 0 13px;text-overflow: ellipsis;width: 300px;}
    #pac-input:focus {border-color: #4d90fe;}
    .pac-container {font-family: Roboto;z-index: 10000 !important}
    #type-selector {color: #fff;background-color: #4d90fe;padding: 5px 11px 0px 11px;}
    #type-selector label {font-family: Roboto;font-size: 13px;font-weight: 300;}
</style>
<!--google map search modal-->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="max-width: 600px !important;">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Select Location</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="map_body">
                <div id="search_box"></div>
                <div id="map_canvas" style="height: 350px; width: 100%;" class="map"></div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-warning" data-dismiss="modal" value="OK"/>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/transport_script");?>
