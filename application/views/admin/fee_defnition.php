<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6><?php echo $this->lang->line('fee_defnition');?></h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_feedeff" onclick="formclear('add_feedef_form')">
            Add Fee Definition
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th width="10%"><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('title');?></th>
                        <th ><?php echo $this->lang->line('type');?></th>
                        <th ><?php echo $this->lang->line('status');?></th>
                        <th width="15%"><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php                 //echo "<pre>"; print_r($feeDeff); exit;
                $i=1; foreach($feeDeff as $fee){?>
                <tr>
                    <td>
                        <?php echo $i;?>
                    </td>
                    <td>
                        <?php echo $fee->fee_definition;?>
                    </td>
                    <td>
                        <?php echo $fee->fee_type;?>
                    </td>
                    <td>
                        <?php if($fee->fee_definition_status == 1) {?> 
                            <span class="btn mybutton  mybuttonActive" onclick="statusChange('<?php echo $fee->fee_definition_id;?>','<?php echo $fee->fee_definition_status; ?>')">Active</span>
                        <?php }else if($fee->fee_definition_status == 0){?>
                            <span class="btn mybutton mybuttonInactive" onclick="statusChange('<?php echo $fee->fee_definition_id;?>','<?php echo $fee->fee_definition_status; ?>')">Inactive</span>
                        <?php } ?>
                    </td>
                    <td width="15%">
                        <button  type="button" class="btn btn-default option_btn " onclick="view_feedef('<?php echo $fee->fee_definition_id;?>')" title="Click here to view the details" data-toggle="modal" data-target="#view_fee" style="color:blue;cursor:pointer;">
                            <i class="fa fa-eye "></i>
                        </button>
                        <button class="btn btn-default option_btn " title="Edit" onclick="edit_feedef('<?php echo $fee->fee_definition_id;?>')">
                            <i class="fa fa-pencil "></i>
                        </button>
                    </td>
                </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<!--add route modal-->
<div id="add_feedeff" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Fee Definition</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_feedef_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Title<span class="req redbold">*</span></label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Title" autocomplete="off"/>
                                <input type="hidden" name="counter" id="counter" value="" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Type<span class="req redbold">*</span></label>
                                <select name="type" id="type" class="form-control" autocomplete="off">
                                    <option value="" selected="selected">Select Fee</option>    
                                    <option value="Course Fee">Course Fee</option>
                                    <option value="Hostel Fee">Hostel Fee</option>
                                    <option value="Transport Fee">Transport Fee</option>
                                </select>
                              </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="table-responsive table_language">
                                <table class="table table-bordered table-striped table-sm" id="no-more-tables">
                                    <thead>
                                        <tr>
                                            <th>Fee Head<span class="req redbold">*</span></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div id="new_textbox">
                                <button type="button" class="btnNewAdd pull-right btn btn-info btn-sm addButtonNewId" id="addButtonNewId" title="Click here to add more" onclick="createNewTextBox()">  <i class="fa fa-plus"></i>Add More</button>
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

<!--edit route modal-->
<div id="edit_fee" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Fee Definition</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="edit_fee_form" method="post" >
                <div class="modal-body" >
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="edit_fee_id" id="edit_fee_id" value=""/>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Title<span class="req redbold">*</span></label>
                                <input type="text" name="title" id="edit_title" class="form-control" placeholder="Title" autocomplete="off"/>
                                <input type="hidden" name="counter" id="counter" value="" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Type<span class="req redbold">*</span></label>
                                <select name="type" id="edit_type" class="form-control" autocomplete="off">
                                    <option value="" selected="selected">Select Fee</option>     
                                    <option value="Course Fee">Course Fee</option>
                                    <option value="Hostel Fee">Hostel Fee</option>
                                    <option value="Transport Fee">Transport Fee</option>
                                </select>
                              </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="table-responsive table_language">
                                <table class="table table-bordered table-striped table-sm" id="no-more-tables">
                                    <thead>
                                        <tr>
                                            <th>Fee Head<span class="req redbold">*</span></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div id="new_textbox">
                                <button type="button" class="btnNewAdd pull-right btn btn-info btn-sm addButtonNewId" id="addButtonNewId" title="Click here to add more" onclick="createNewTextBox()">  <i class="fa fa-plus"></i>Add More</button>
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

<!--view route modal-->
<div id="view_fee" class="modal fade form_box" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Fee Definition</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive table_view_model">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th width="50%">
                                    <div class="media">
                                    Title :
                                        <div class="media-body">
                                            <label class="mt-0 ml-2 mb-0"><span id="view_title"></span></label>
                                        </div>
                                    </div>    
                                </th>
                                <th width="50%">
                                    <div class="media">
                                    Type :
                                        <div class="media-body">
                                            <label class="mt-0 ml-2 mb-0"><span id="view_type"></span></label>
                                        </div>
                                    </div>    
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="table-responsive table_language" id="defnition_view"></div>
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
<?php $this->load->view("admin/scripts/fee_definition_script");?>
