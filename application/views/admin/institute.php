<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6>Manage Institute</h6>
        <hr>
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal" onclick="formclear('add_institute_form')">
            Add Institute
        </button>   
  
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="institute_table" class="table table-striped table-sm" style="width:100%">
        <thead>
            <tr>
                <th><?php echo $this->lang->line('sl_no');?></th>
                <th><?php echo $this->lang->line('institute_name');?></th>
                <th><?php echo $this->lang->line('institute_type');?></th>
                <th><?php echo $this->lang->line('parent_institute');?></th>
                <th><?php echo $this->lang->line('action');?></th>
            </tr>
        </thead>
                <?php 
                // echo "<pre>";print_r($instituteArr);
            $i=1; foreach($instituteArr as $institute){?>
                <tr id="row_<?php echo $institute['institute_master_id'];?>">
                <td><?php echo $i;?></td>
                <td> <?php echo $institute['institute_name'];?></td>
                <td><?php echo $institute['institute_type'];?></td>
                <td><?php $CI =& get_instance();
                          $parent_institute=$CI->get_instituteby_id($institute['parent_institute']);
                                                       echo $parent_institute;
                    ?></td>
                <td>
                    <?php if($institute['institute_type_id']==1){?>
                        <a href ="<?php echo base_url('backoffice/view-hierarchy/'.$institute['institute_master_id']);?>" id="#view_hierarchy" >
                            <button class="btn btn-default option_btn " title="View" onclick="view_hierarchydata(<?php echo $institute['institute_master_id'];?>)">
                                <i class="fa fa-eye "></i>
                            </button>
                        </a>
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_institutedata(<?php echo $institute['institute_master_id'];?>)">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_institute(<?php echo $institute['institute_master_id'];?>)">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    <?php  }else{?>
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_institutedata(<?php echo $institute['institute_master_id'];?>)">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_institute(<?php echo $institute['institute_master_id'];?>)">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    <?php }?>
                    </td>
                </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>
<div id="myModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Institute</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
              <form id="add_institute_form" type="post">
            <div class="modal-body">
              
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Institute Name<span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="institute_name" placeholder="Institute Name" onkeypress="return valNames(event);"></div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Type<span class="req redbold">*</span></label>
                                <select class="form-control" name="institute_type_id" id="type">
                                <option value="">Select</option>
                                    <?php foreach($typeArr as $type){?>
                                <option value="<?php echo $type['institute_type_id'];?>"><?php echo $type['institute_type'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="parent_div">

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
<div id="edit_institute" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Institute</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div> 
            <form id="edit_institute_form" type="post">
            <div class="modal-body">
             
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <input type="hidden" name="institute_master_id" id="edit_instituteid" />
                            <div class="form-group"><label>Institute Name<span class="req redbold">*</span></label>
                                <input class="form-control" type="text" name="institute_name" placeholder="Institute Name" id="edit_institutename" onkeypress="return valNames(event);"></div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Type<span class="req redbold">*</span></label>
                                <select class="form-control" name="institute_type_id" id="edit_type">
                                <option value="">Select</option>
                                    <?php foreach($typeArr as $type){?>
                                <option value="<?php echo $type['institute_type_id'];?>"><?php echo $type['institute_type'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="edit_div">

                        </div>

                       

                    </div>
                
            </div>
             <div class="modal-footer ">
         <button class="btn btn-success">Save</button>
         <button class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div> 
       </form>
        </div>

    </div>
</div>
<?php $this->load->view("admin/scripts/institute_script");?>
