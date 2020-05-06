<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6>Manage Materials</h6>
        <hr>
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal">
                                   Add Material Details
                                </button>
        <!-- Data Table Plugin Section Starts Here -->

        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="institute_data" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th width="50">
                            <?php echo $this->lang->line('sl_no');?>
                        </th>
                        <th>Material type</th>
                        <th>Subject</th>
                        <th>Module </th>
                        <th>Material Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php $i=1; foreach($materialArr as $material){ ?>
                <tr id="material_data<?php echo  $material['material_id'];?>">
                    <td width="5%">
                        <?php echo $i;?>
                    </td>
                    <td width="10%">
                        <?php echo ucfirst($material['material_type']);?>
                    </td>
                    <td width="15%">
                        <?php echo $material['subject_name'];?>
                    </td>
                    <td width="15%">
                        <?php echo $material['module_name'];?>
                    </td>
                    <td width="35%">
                        <?php echo $material['material_name'];?>
                    </td>
                    <td width="20%">
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_materialdata(<?php echo  $material['material_id'];?>)">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <button class="btn btn-default option_btn" title="Delete" onclick="delete_material(<?php echo  $material['material_id'];?>)">
                            <i class="fa fa-trash-o"></i>
                        </button>
                        <?php if($material['material_type']=='question'){ ?>
                        <button class="btn btn-default add_row add_new_btn btn_add_call" onclick="redirect('backoffice/question-set')">
                            Add question sets
                        </button>
                        <?php } ?>
                        <?php if($material['material_type']=='study material'){ ?>
                        <button class="btn btn-default add_row add_new_btn btn_add_call" onclick="redirect('backoffice/add-study-material?material_id=<?php echo  $material['material_id'];?>')">
                            Add study material
                        </button>
                        <?php } ?>
                    </td>
                </tr>
                <?php $i++; } ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<!--edit syllabus modal-->
<div id="edit_material" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Material Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form enctype="multipart/form-data" id="edit_material_form" method="post">
                <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="material_id" id="edit_material_id" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Material type<span class="req redbold">*</span></label>
                                <select name="material_type" id="edit_materialtype" class="form-control">
                                   <?php 
                                        foreach($materialtype as $material){
                                            if($material['material_type_name']=='question' || $material['material_type_name']=='study material'){
                                    ?>
                                   <option value="<?php echo $material['material_type_name'];?>"><?php echo ucfirst($material['material_type_name']);?></option>
                                   <?php }} ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Subject<span class="req redbold">*</span></label>
                                <select class="form-control" id="edit_subject" name="subject_id">
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Module<span class="req redbold">*</span></label>
                                <select class="form-control" id="edit_modules" name="module_id">
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Material Name<span class="req redbold">*</span></label>
                                <input type="text" name="material_name" class="form-control" id="edit_materialname"  />
                            </div>
                        </div>

                        <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="edit_upload">
                            <div class="form-group">
                                <label style="display:block">Material Link</label>
                                <span id="edit_materiallink" style="display:block"></span>
                                <input type="file" name="file_name" class="form-control" />
                            </div>
                        </div> -->
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">


                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">


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

<div id="myModal" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Material</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form enctype="multipart/form-data" id="add_material_form" method="post">
                <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Material type<span class="req redbold">*</span></label>
                                <select name="material_type" id="materialtype" class="form-control">
                                   <?php 
                                        foreach($materialtype as $material){
                                            if($material['material_type_name']=='question' || $material['material_type_name']=='study material'){
                                    ?>
                                   <option value="<?php echo $material['material_type_name'];?>"><?php echo ucfirst($material['material_type_name']);?></option>
                                   <?php }} ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Subject<span class="req redbold">*</span></label>
                                <select class="form-control" id="subject" name="subject_id">
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Module<span class="req redbold">*</span></label>
                                <select class="form-control" id="modules" name="module_id">
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Material Name<span class="req redbold">*</span></label>
                                <input type="text" name="material_name" class="form-control"  id="name"/>
                            </div>
                        </div>

                        <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="upload">
                            <div class="form-group">
                                <label style="display:block">Material Link</label>
                                
                                <input type="file" name="file_name" class="form-control"/>
                            </div>
                        </div> -->
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">

                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">



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
<?php $this->load->view("admin/scripts/materialManagement/materials_script");?>
