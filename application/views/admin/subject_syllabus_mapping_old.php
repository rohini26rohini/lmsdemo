<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="transparent_card ">
        <!-- Data Table Plugin Section Starts Here -->
        <div class="row ">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right flex-row-reverse ">
                <button class="btn btn-default add_row btn_map" data-toggle="modal" data-target="#add_mapping">
                                    Subject Syllabus Mapping
                                </button>


            </div>
        </div>
        <div class="table-responsive table_language" style="margin-top:15px;">
        <table id="institute_data" class="table table-striped table-sm" style="width:100%">
        <thead>
            <tr>
                <th>Sl. No.</th>
                <th>Course</th>
                <th>Subject</th>
                <th>Syllabus</th>
                <th>Action</th>
            </tr>
        </thead>
          <?php $i=1;//echo "<pre>"; print_r($mappingArr);
            foreach($mappingArr as $mapping){?>
            <tr id="row_<?php echo $mapping['subject_id'];?>">
                <td id="slno_<?php echo $mapping['subject_id'];?>"><?php echo $i;?></td>
                <td id="course_<?php echo $mapping['subject_id'];?>"><?php echo $mapping['class_name'];?></td>
                <td id="subject_<?php echo $mapping['subject_id'];?>"><?php echo $mapping['subname'];?></td>
                <td id="syllabus_<?php echo $mapping['subject_id'];?>"><?php echo $mapping['syllabus_name'];?></td>
                <td>
                <button class="btn btn-default option_btn "  title="Edit" onclick="get_mappingdata(<?php echo $mapping['subject_id'];?>)">
                                    <i class="fa fa-pencil "></i>
                                    </button>


                    <a class="btn btn-default option_btn" title="Delete" onclick="delete_mapping(<?php echo $mapping['subject_id'];?>)">
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

<div id="add_mapping" class="modal fade form_box" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Subject Syllabus Mapping</h4>
                <button type="button" class="close add_modal_close" data-dismiss="modal" >&times;</button>

            </div>
            <div class="modal-body">
                <form id="add_mapping_form" type="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                         <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="form-group"><label>Course<span class="req redbold">*</span></label>
                            <select class="form-control" name="course_master_id" >
                                      <option value="">Select</option>

                                       <?php
                                foreach($coursesArr as $course){?>
                                <option value="<?php echo $course['class_id']; ?>"><?php echo $course['class_name']; ?></option>

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
                        <a class="btn btn-info" data-target="#sub-service-modal" data-toggle="modal">Add Modules</a>
                          <ul class="sub_category_control selected_service"></ul>

                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group"><label>Syllabus<span class="req redbold">*</span></label>
                            <select class="form-control" name="syllabus_master_id" >
                                      <option value="">Select</option>
                                <?php
                                foreach($syllabusArr as $syllabus){?>
                                <option value="<?php echo $syllabus['syllabus_id']; ?>"><?php echo $syllabus['syllabus_name']; ?></option>

                                <?php } ?>
                                      </select></div>
                    </div>
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Upload File</label>

                                <input type="file" class="form-control" name="file_name">
                                <p>Upload PDF file only (Max Size:100MB).</p>
                            </div>
                        </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">

                        <button class="btn btn-info" type="submit">Save</button>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">

                        <button class="btn btn-default add_modal_close" data-dismiss="modal">Cancel</button>

                    </div>

                </div>
                    </form>
            </div>

        </div>

    </div>
</div>
<div id="edit_mapping" class="modal fade form_box" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Subject Syllabus Mapping</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <form id="edit_mapping_form" enctype="multipart/form-data" >
                <div class="row">
                     <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <input type="hidden" name="subject_id" id="edit_id"/>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group"><label>Course<span class="req redbold">*</span></label>
                            <select class="form-control" name="course_master_id" id="edit_course">
                                      <option value="">Select</option>
                                       <?php
                                foreach($coursesArr as $course){?>
                                <option value="<?php echo $course['class_id']; ?>"><?php echo $course['class_name']; ?></option>

                                <?php } ?>
                                      </select></div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group"><label>Subject<span class="req redbold">*</span></label>
                            <input type="hidden"  name="subject_master_id" id="subject_id"/>
                            <select class="form-control" name="subject_master_ids" id="edit_subject" disabled>

                                      <option value="">Select</option>
                                       <?php
                                foreach($subjectArr as $subject){?>
                                <option value="<?php echo $subject['subject_id']; ?>"><?php echo $subject['subject_name']; ?></option>

                                <?php } ?>
                                      </select></div>
                    </div>
                     <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <a class="btn btn-info" id="show_modules" data-target="#sub-service-modal" data-toggle="modal">Add Modules</a>
                          <ul class="sub_category_control selected_service" id="edit_modules"></ul>

                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group"><label>Syllabus<span class="req redbold">*</span></label>
                            <select class="form-control" name="syllabus_master_id" id="edit_syllabus">

                                      <option value="">Select</option>
                                <?php
                                foreach($syllabusArr as $syllabus){?>
                                <option value="<?php echo $syllabus['syllabus_id']; ?>"><?php echo $syllabus['syllabus_name']; ?></option>

                                <?php } ?>
                                      </select></div>
                    </div>
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Upload File</label>
                                <br><label>Uploaded syllabus:<span id="edit_syllabusfile"></span></label>
                                <input type="file" class="form-control" name="file_name">
                                <p>Upload PDF file only (Max Size:100MB).</p>

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

<div id="sub-service-modal" class="modal fade form_box" role="dialog">
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
<script>


</script>

<?php $this->load->view("admin/scripts/subject_syllabus_mapping_script");?>
