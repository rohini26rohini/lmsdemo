
<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6><?php echo $this->lang->line('assets'); ?> </h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->     
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#add_assets" onclick="formclear('add_assets_form')">
            <?php echo $this->lang->line('add_assets'); ?>
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
                <thead> 
                    <tr>
                        <th width="50"><?php echo $this->lang->line('sl_no');?></th>
                        <th ><?php echo $this->lang->line('category');?></th>
                        <th ><?php echo $this->lang->line('total_num');?></th>
                        <th ><?php echo $this->lang->line('status');?></th>
                        <th ><?php echo $this->lang->line('price_per_unit')." (INR)";?></th>
                        <th ><?php echo $this->lang->line('action');?></th>
                    </tr>
                </thead>
                <?php 
                $i=1; 
                foreach($assets as $row){ 
                ?>
                    <tr >
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td>
                            <?php echo $this->common->get_name_by_id('assets_category','name',array("id"=>$row['category']))
                    ;?>
                        </td>
                        <td >
                            <?php echo $row['total_number'];?>
                        </td>
                        <td >
                            <?php echo $row['item_status'];?>
                        </td>
                          <td >
                            <?php echo $row['price_per_unit'];?>
                        </td>
                         
                        <td>
                            <button class="btn btn-default option_btn " title="Edit" onclick="get_asset_data(<?php echo $row['id'];?>)">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn" title="Delete" onclick="delete_assets(<?php echo $row['id'];?>)">
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

<!--add leavetype modal-->
<div id="add_assets" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('add_assets'); ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_assets_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('category'); ?><span class="req redbold">*</span></label>
                                <select class="form-control" name="category">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    <?php if(!empty($category))
                                            foreach($category as $row)
                                            {
                                            {?>
                                       <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                                      <?php } }?>
                                    </select>
                        </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('total_num'); ?><span class="req redbold">*</span></label>
                                <input class="form-control numbersOnly" name="total_no" type="text"/>
                                       
                                    
                        </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('status'); ?><span class="req redbold">*</span></label>
                                <select class="form-control" name="status">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                       <option value="Working">Working</option>
                                       <option value="Damaged">Damaged</option>
                                       <option value="Dropped">Dropped</option>
                                      
                                    </select>
                        </div>
                        </div>
                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('price_per_unit'); ?></label>
                                <input class="form-control numbersOnly" name="price" type="text"/>
                                       
                                    
                        </div>
                        </div>
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

<!--edit leavetype modal-->
<div id="edit_assets" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('edit_assets'); ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="edit_assets_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" id="edit_id" name="id"/>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('category'); ?><span class="req redbold">*</span></label>
                                <select class="form-control" name="category" id="category" readonly>
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    <?php if(!empty($category))
                                            foreach($category as $row)
                                            {
                                            {?>
                                       <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                                      <?php } }?>
                                    </select>
                        </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('total_num'); ?><span class="req redbold">*</span></label>
                                <input class="form-control numbersOnly" name="total_no" type="text" id="total_no"/>
                                       
                                    
                        </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('status'); ?><span class="req redbold">*</span></label>
                                <select class="form-control" name="status" id="status" readonly>
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                       <option value="Working">Working</option>
                                       <option value="Damaged">Damaged</option>
                                       <option value="Dropped">Dropped</option>
                                      
                                    </select>
                        </div>
                        </div>
                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('price_per_unit'); ?></label>
                                <input class="form-control numbersOnly" name="price" type="text" id="price"/>
                                       
                                    
                        </div>
                        </div>
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
<?php $this->load->view("admin/scripts/asset_script");?>
