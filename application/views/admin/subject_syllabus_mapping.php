<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card ">
        <!-- Data Table Plugin Section Starts Here -->
        <div class="row ">
             <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 ">
                    <div class="form-group">
                        <label>Syllabus</label>
                        <select class="form-control search_syllabus_mapp" id="search_syllabus">
                            <option value="">Select</option>
                            <?php 
                            if(!empty($syllabusArr)) {
                                foreach($syllabusArr as $syllabus) {
                                echo '<option value="'.$syllabus['syllabus_id'].'">'.$syllabus['syllabus_name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 ">
                    <div class="form-group">
                        <label>Subject</label>
                        <select class="form-control search_syllabus_mapp" id="search_subject">
                        <option value="">Select</option>
                            <?php 
                            if(!empty($subjectArr)) {
                                foreach($subjectArr as $subject){
                                echo '<option value="'.$subject['subject_id'].'">'.$subject['subject_name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                        </div>
                    </div>
                 </div>


            </div>
    
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right flex-row-reverse ">
                <button class="btn btn-default add_row btn_map" data-toggle="modal" data-target="#add_mapping" onclick="formclear('add_syllabus_mapping_form')">
                                    Subject Syllabus Mapping
                                </button>


            </div>
        </div>
        <div class="table-responsive table_language" style="margin-top:15px;">
        <table id="institute_data" class="table table-striped table-sm" style="width:100%">
        <thead>
            <tr>
                <th>Sl. No.</th>
                <th>Syllabus</th>
                <th>Subject</th>
                <th>Module</th>
                <th>Action</th>
            </tr>
        </thead>
          <?php $i=1;
            if(!empty($mappingArr)) {
            foreach($mappingArr as $mapping){
            $subject = $this->common->get_from_tablerow('mm_subjects', array('subject_id'=>$mapping->subject_master_id)); 
            ?>  
            <tr id="row_<?php echo $mapping->syllabus_master_detail_id;?>">
                <td id="slno_<?php echo $mapping->syllabus_master_detail_id;?>"><?php echo $i;?></td>
                <td id="course_<?php echo $mapping->syllabus_master_detail_id;?>"><?php echo $mapping->syllabus_name;  ?></td>
                <td id="subject_<?php echo $mapping->syllabus_master_detail_id;?>"><?php echo (!empty($subject))?$subject['subject_name']:'';?></td>
                <td id="module_<?php echo $mapping->syllabus_master_detail_id;?>"><?php echo $mapping->subject_name;?></td>
                <td>
                <button  type="button" class="btn btn-default option_btn getcoursedetails" id="<?php echo $mapping->syllabus_master_detail_id;?>" title="Click here to view the details" data-toggle="modal" data-target="#show" >
                            <i class="fa fa-eye "></i>
                        </button>    
                <button class="btn btn-default option_btn " title="Edit" onclick="get_mappingdata(<?php echo $mapping->syllabus_master_detail_id;?>)">
                                    <i class="fa fa-pencil "></i>
                                    </button>


                    <a class="btn btn-default option_btn" title="Delete" onclick="delete_mapping(<?php echo $mapping->syllabus_master_detail_id;?>)">
                                    <i class="fa fa-trash-o"></i>
                                    </a>
                </td>
            </tr>
            <?php $i++; } } ?>
        </table>
    </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<div id="add_mapping" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Subject Syllabus Mapping</h4>
                <button type="button" class="close add_modal_close" data-dismiss="modal" >&times;</button>

            </div>
                 <form id="add_syllabus_mapping_form" type="post" enctype="multipart/form-data">
            <div class="modal-body">
           
                <div class="row">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group"><label>Syllabus<span class="req redbold">*</span></label>
                            <select class="form-control" name="syllabus_master_id" id="syllabus_master_id" onchange="loadparentmodule()">
                                      <option value="">Select</option>
                                <?php
                                foreach($syllabusArr as $syllabus){?>
                                <option value="<?php echo $syllabus['syllabus_id']; ?>"><?php echo $syllabus['syllabus_name']; ?></option>
                                      
                                <?php } ?>
                                      </select></div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group"><label>Subject<span class="req redbold">*</span></label>
                            <select class="form-control" name="subject_master_id" id="subject">
                                      <option value="">Select</option>
                                       <?php 
                                foreach($subjectArr as $subject){?>
                                <option value="<?php echo $subject['subject_id']; ?>"><?php echo $subject['subject_name']; ?></option>

                                <?php } ?>
                                      </select></div>
                    </div>
                    
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group"><label>Modules<span class="req redbold">*</span></label>
                            <select class="form-control" name="module_master_id" id="modulesname">
                                      <option value="">Select</option>
                                      </select></div>
                    </div>
                    
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group"><label>Parent Module</label>
                            <select class="form-control" name="parent_module_master_id" id="parent_module_master_id">
                                      <option value="">Select parent module</option>
                                        <?php
                                            if(!empty($mappingArr)) {
                                                foreach($mappingArr as $mapping){
                                                   echo '<option value="'.$mapping->syllabus_master_detail_id.'">'.$mapping->subject_name.'</option>'; 
                                                }
                                            }
                                        ?>
                                      </select>
                        </div>
                    </div>
                    
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group"><label>Modules Content<span class="req redbold">*</span></label>
                        <textarea name="modulecontent" id="modulecontent"></textarea>    
                        </div>
                    </div>
                    
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">

                    </div>


                </div>
              
            </div>
                     <div class="modal-footer">
                     
                        <button class="btn btn-success" type="submit">Save</button>
                          <button class="btn btn-default add_modal_close" data-dismiss="modal">Cancel</button>
                     </div>
      </form>
        </div>

    </div>
</div>
<div id="edit_mapping" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Subject Syllabus Mapping</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
              <form id="edit_mapping_form" enctype="multipart/form-data" >
            <div class="modal-body">
              
                <div class="row">
                     <input type="hidden" name="syllabus_master_detail_id" id="editsyllabus_master_detail_id" value="" />
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group"><label>Syllabus<span class="req redbold">*</span></label>
                            <select class="form-control" name="syllabus_master_id" id="editsyllabus_master_id" onchange="edit_loadparentmodule()">
                                      <option value="">Select</option>
                                <?php
                                foreach($syllabusArr as $syllabus){?>
                                <option value="<?php echo $syllabus['syllabus_id']; ?>"><?php echo $syllabus['syllabus_name']; ?></option>
                                      
                                <?php } ?>
                                      </select></div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group"><label>Subject<span class="req redbold">*</span></label>
                            <select class="form-control" name="subject_master_id" id="editsubject" onchange="edit_loadparentmodule()">
                                      <option value="">Select</option>
                                       <?php 
                                foreach($subjectArr as $subject){?>
                                <option value="<?php echo $subject['subject_id']; ?>"><?php echo $subject['subject_name']; ?></option>

                                <?php } ?>
                                      </select></div>
                    </div>
                    
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group"><label>Modules<span class="req redbold">*</span></label>
                            <select class="form-control" name="module_master_id" id="editmodulesname">
                                      <option value="">Select</option>
                                      </select></div>
                    </div>
                    
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group"><label>Parent Module</label>
                            <select class="form-control" name="parent_module_master_id" id="editparent_module_master_id">
                                      <option value="0">Select parent module</option>
                                        
                                      </select>
                        </div>
                    </div>
                    
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group"><label>Modules Content<span class="req redbold">*</span></label>
                        <textarea name="modulecontent" id="editmodulecontent"></textarea>    
                        </div>
                    </div>
                    
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">

                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">


                    </div>

                </div>
        
            </div>
                  <div class="modal-footer">
                  <span id="save_div" class="req redbold"></span>
                      <span id="show_div">
                        <button class="btn btn-success exist" type="submit" id="edit_save">Save</button>
                      <button class="btn btn-default add_modal_close exist" data-dismiss="modal">Cancel</button>
                        </span>
                  </div>
            </form>
        </div>

    </div>
</div>

<div id="sub-service-modal" class="modal fade form_box modalCustom" role="dialog">
        <div class="modal-dialog" style="max-width: 500px;">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Choose Modules</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body category_list">
                    <table class="table  table-striped category_list table-sm">
                        <tbody class="modules">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
<div id="show" class="modal fade form_box" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Subject syllabus mapping details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills ">
                    <table class="table table_register_view ">
                        <tbody>
                            <tr>
                                <th  colspan="2" ><h6 id="coursedet_view"></h6>
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                <div class="media">
                                Syllabus :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="syllabus_view"></span></label>
                                    </div>
                                 </div>    
                                </th>
                                <th width="50%">
                                <div class="media">
                                Subject :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="subject_view"></span></label>
                                    </div>
                                 </div>     
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                <div class="media">
                                Module :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="module_view"></span></label>
                                    </div>
                                 </div>      
                       
                                </th>
                                <th width="50%">
                                   
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2" width="100%">
                                <div class="media">
                                Module Content :
                                    <div class="media-body">
                                        <label class="mt-0 ml-2 mb-0"><span id="content_view"></span></label>
                                    </div>
                                 </div>     
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("admin/scripts/subject_syllabus_mapping_script");?> 
