<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6>Manage study materials</h6>
        <hr>
        <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" onclick="redirect('backoffice/add-study-material');">
            Add study materials
        </button>
        <!-- Data Table Plugin Section Starts Here -->

        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="institute_data" class="table table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th width="50">
                            <?php echo $this->lang->line('sl_no');?>
                        </th>
                        <th>Material Name</th>
                        <th>Module </th>
                        <th>Subject</th>
                        <th>Description</th>
                        <th width="12%">Action</th>
                    </tr>
                </thead>
                <?php $i=1; foreach($study_materials as $material){ ?>
                <tr id="study_material_data<?php echo  $material['id'];?>">
                    <td>
                        <?php echo $i;?>
                    </td>
                    <td>
                        <?php echo $material['material_name'];?>
                    </td>
                    <td>
                        <?php echo $material['module_name'];?>
                    </td>
                    <td>
                        <?php echo $material['subject_name'];?>
                    </td>
                    <td>
                        <?php echo ucfirst($material['description']);?>
                    </td>
                    <td>
                        <button class="btn btn-default option_btn " title="View" onclick="view_study_material(<?php echo  $material['id'];?>);">
                            <i class="fa fa-eye "></i>
                        </button>
                        <button class="btn btn-default option_btn " title="Edit" onclick="redirect('backoffice/add-study-material?id=<?php echo  $material['id'];?>');">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_study_material(<?php echo  $material['id'];?>)">
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

<!--edit syllabus modal-->
<div id="view_study_material" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="body">
                <div class="row">
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/materialManagement/study_materials_script");?>
