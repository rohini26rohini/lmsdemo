<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
                <h6>Syllabus</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->     
                         <button class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal" onclick="formclear('add_syllabus_form')">
                                    Add Syllabus
                                </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
           <table id="syllabus_data" class="table table-striped table-sm" style="width:100%">
               <thead> 
                   <tr>
                        <th><?php echo $this->lang->line('sl_no');?></th>
                        <th >Title</th>
                        <th>Description</th>
                        <th>Document</th>
                        <th >Action</th>
                       

                    </tr>
                </thead>
           
                <?php $i=1; foreach($syllabusArr as $syllabus){?>
                <tr id="row_<?php echo $syllabus['syllabus_id'];?>">

                    <td >
                        <?php echo $i;?>
                    </td>
                    <td id="name_<?php echo $syllabus['syllabus_id'];?>">
                        <?php echo $syllabus['syllabus_name'];?>
                    </td>
                    <td id="description_<?php echo $syllabus['syllabus_id'];?>">
                        <?php echo $syllabus['syllabus_description'];?>
                    </td>
                    <td id="file_name_<?php echo $syllabus['syllabus_id'];?>">
                   <a target="_blank" class="btn mybutton" href=" <?php echo base_url();?>uploads/syllabus/<?php echo $syllabus['file_name']?>">View document</a>      
                    </td>

                    <td>
                        <button class="btn btn-default option_btn " title="Edit" onclick="get_syllabusdata(<?php echo $syllabus['syllabus_id'];?>)">
                            <i class="fa fa-pencil "></i>
                        </button>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_syllabus(<?php echo $syllabus['syllabus_id'];?>)">
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
<div id="edit_syllabus" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Syllabus</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
<form enctype="multipart/form-data" id="edit_syllabus_form" method="post">
            <div class="modal-body">
                
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="syllabus_id" id="edit_syllabus_id" />
                        <input type="hidden" name="files" id="files"  />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Title<span class="req redbold">*</span></label>
                                <input type="text" name="title" class="form-control" id="edit_title" /></div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Description</label>
                                <input type="text" name="description" class="form-control" id="edit_description" />
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Upload File<span class="req redbold">*</span></label><br>
                                <label>current file:<span id="edit_filename"></span></label>
                                <input type="file" class="form-control" name="file_name" id="edit_file" onchange="editreadURL(this);">
                                <p>Upload .pdf,.docx files only  (Max Size:5MB).</p>
                            </div>
                        </div>

                    </div>
                
            </div>
             <div class="modal-footer ">
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
                <h4 class="modal-title">Add Syllabus</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
             <form enctype="multipart/form-data" id="add_syllabus_form" method="post">
            <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Title <span class="req redbold">*</span></label>
                                <input type="text" name="title" class="form-control" id="title"/></div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Description</label>
                                <input type="text" name="description" class="form-control" />
                            </div>
                        </div>
                         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Upload File<span class="req redbold">*</span></label>
                                <input type="file" class="form-control" id="file" name="file_name" onchange="readURL(this);">
                                <p>Upload .pdf,.docx files only  (Max Size:5MB).</p>
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
<?php $this->load->view("admin/scripts/syllabus_script");?>
