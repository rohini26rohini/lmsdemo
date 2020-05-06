<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card ">
        <h6>Manage Courses</h6>
        <hr>
        <!-- Data Table Plugin Section Starts Here -->
        <div class="addBtnPosition">
            <button class="btn btn-default add_row btn_map" onClick="redirect('institute-course-mapping');">
                Center Course mapping
            </button>
            <!-- <button class="btn btn-default add_row btn_map" data-toggle="modal" data-target="#add_class" onclick="formclear('add_class_form')"> -->
            <button class="btn btn-default add_row btn_map" data-toggle="modal" data-target="#add_class" onclick="courseColor('color-pallete')">
                Add Course
            </button>
        </div>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="institute_data" class="table table-striped table-sm" style="width:100%">
                <thead>  
                    <tr>
                        <th width="50px"><?php echo $this->lang->line('sl_no');?> </th>
                        <th> Course</th>
                        <th> Code</th>
                        <th>Syllabus</th>
                        <th>School</th>
                        <th>Mode </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php 
                $i=1;
                foreach($classesArr as $class){?>
                    <tr id="row_<?php echo $class['class_id'];?>">
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td id="class_name_<?php echo $class['class_id'];?>">
                            <?php echo $class['class_name'];?>
                        </td>
                        <td id="class_code_<?php echo $class['class_id'];?>">
                            <?php echo $class['classcode'];?>
                        </td>
                        <td id="syllabus_name_<?php echo $class['class_id'];?>">
                            <?php echo $class['syllabus_name'];?>
                        </td>
                        <td id="school_name_<?php echo $class['class_id'];?>">
                            <?php echo $class['school_name'];?>
                        </td>
                        <td id="mode_name_<?php echo $class['class_id'];?>">
                            <?php echo $class['mode_name'];?>
                        </td>
                        <td>
                            <button class="btn btn-default option_btn add_new_btn" title="Edit" onclick="get_editdata(<?php echo $class['class_id'];?>)">
                                <i class="fa fa-pencil "></i>
                            </button>
                            <a class="btn btn-default option_btn  " title="Delete" onclick="delete_classes(<?php echo $class['class_id'];?>)">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                <?php $i++;} ?>
            </table>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>


        <div id="add_class" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Add New Course</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="add_class_form" method="post">
            <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="color" id="color" value="#E62"/>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Name<span class="req redbold">*</span></label>
                                <input type="text" name="class_name" class="form-control" placeholder="Course Name" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>School<span class="req redbold">*</span></label>
                                <select class="form-control" name="school_id">             
                                    <option value="">Select</option>
                                        <?php foreach($schoolArr as $school) {
                                            ?>
                                    <option value="<?php echo $school['school_id'] ;?>"><?php echo $school['school_name'] ;?></option>
                                        <?php } ?>
                                    </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Syllabus<span class="req redbold">*</span></label>
                                <select name="syllabus_id" class="form-control">
                                                    <option value="">Select</option>
                                                        <?php foreach($syllabusArr as $syllabus) {?>
                                                     <option value="<?php echo $syllabus['syllabus_id'] ;?>"><?php echo $syllabus['syllabus_name'] ;?></option>
                                                        <?php } ?>
                                                    </select>

                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Mode<span class="req redbold">*</span></label>
                                <select class="form-control" name="batch_mode_id" id="batch_mode_id">
                                    <option value="">Select a mode</option>
                                    <?php 
                                        $modes = $this->common->get_modes();
                                        foreach($modes as $mode) {
                                        echo '<option value="'.$mode['mode_id'].'">'.$mode['mode'].'</option>' ;
                                    }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Basic Qualification<span class="req redbold">*</span></label>
                                <select class="form-control" name="basic_qualification">
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                   <option value="sslc">Class X or Below</option>
                                   <option value="plustwo">Plus Two</option>
                                   <option value="degree">Degree</option>
                                   <option value="pg">PG</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Result Publish<span class="req redbold">*</span></label>
                            <br>
                            <input type="hidden" name=""  class="form-control" placeholder="" />
                            <label>Immediate</label> <input type="radio" name="result_publish"  value="0" placeholder="" />
                            <label>After Publish</label> <input type="radio" name="result_publish"  value="1" placeholder="" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Active Exam<span class="req redbold">*</span></label>
                            <br>
                            <input type="hidden" name=""  class="form-control" placeholder="" />
                            <label>Immediate</label> <input type="radio" name="active_exam"  value="1" placeholder="" />
                            <label>After Study</label> <input type="radio" name="active_exam"  value="0" placeholder="" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <label style="display:block">Pick a color for Course</label>
                            <div class="form-group" id="courseColor">
                                            <div style="background-color: #E62" data-color="#E62" class="color-pallete active" title="Don"></div>
                                            <div style="background-color: #9c27b0" data-color="#9c27b0" class="color-pallete "></div>
                                            <div style="background-color: #00BCD4" data-color="#00BCD4" class="color-pallete "></div>
                                            <div style="background-color: #b9a709" data-color="#b9a709" class="color-pallete"></div>


                                            <div style="background-color: #0AF" data-color="#0AF" class="color-pallete"></div>
                                            <div style="background-color: #05A" data-color="#05A" class="color-pallete"></div>
                                            <div style="background-color: #E91E63" data-color="#E91E63" class="color-pallete "></div>
                                            <div style="background-color: #FF9800" data-color="#FF9800" class="color-pallete "></div>


                                            <div style="background-color: #191" data-color="#191" class="color-pallete  <"></div>
                                            <div style="background-color: #FD0" data-color="#FD0" class="color-pallete "></div>
                                            <div style="background-color: #607D8B" data-color="#607D8B" class="color-pallete"></div>
                                            <div style="background-color: #CDDC39" data-color="#CDDC39" class="color-pallete"></div>


                                            <div style="background-color: #305eb1" data-color="#305eb1" class="color-pallete "></div>
                                            <div style="background-color: #913535" data-color="#913535" class="color-pallete  "></div>
                                            <div style="background-color: #fa68db" data-color="#fa68db" class="color-pallete  "></div>
                                            <div style="background-color: #005020" data-color="#005020" class="color-pallete  "></div>

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
 <!--edit class modal-->
            <div id="edit_class" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Edit Course</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
                            <form autocomplete="off" id="edit_class_form" method="post">
            <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="class_id" class="form-control" id="edit_class_id"/>
                        <input type="hidden" name="color" class="form-control" id="edit_color"/>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Name<span class="req redbold">*</span></label>
                                <input type="text" name="class_name" class="form-control" id="edit_class_name"/></div>
                                
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>School<span class="req redbold">*</span></label>
                                <select class="form-control" name="school_id" id="edit_school_id">
                                                        
                                                    <option value="">Select</option>
                                                        <?php foreach($schoolArr as $school) {?>
                                                    <option  value="<?php echo $school['school_id'] ;?>"><?php echo $school['school_name'] ;?></option>
                                                        <?php } ?>
                                                    </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Syllabus<span class="req redbold">*</span></label>
                                <select name="syllabus_id" class="form-control" id="edit_syllabus_id">
                                    <option value="">Select</option>
                                        <?php foreach($syllabusArr as $syllabus) {?>
                                     <option value="<?php echo $syllabus['syllabus_id'] ;?>"><?php echo $syllabus['syllabus_name'] ;?></option>
                                        <?php } ?>
                                    </select>

                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Mode<span class="req redbold">*</span></label>
                                <select class="form-control" name="batch_mode_id" id="edit_batch_mode_id">
                                    <option value="">Select a mode</option>
                                    <?php 
                                        $modes = $this->common->get_modes();
                                        foreach($modes as $mode) {
                                        echo '<option value="'.$mode['mode_id'].'">'.$mode['mode'].'</option>' ;
                                    }?>
                                </select>
                            </div>
                        </div>
                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Basic Qualification<span class="req redbold">*</span></label>
                                <select class="form-control" name="basic_qualification" id="qualification">
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                   <option value="sslc">Class X or Below</option>
                                   <option value="plustwo">Plus Two</option>
                                   <option value="degree">Degree</option>
                                   <option value="pg">PG</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Result Publish<span class="req redbold">*</span></label>
                            <br>
                            <input type="hidden" name=""  class="form-control" placeholder="" />
                            <label>Immeidate</label> <input type="radio" name="result_publish" id="result_publish" value="0"  value="" placeholder="" />
                            <label>Immeidate after study</label> <input type="radio" name="result_publish"  id="result_publish1"  value="1" placeholder="" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label>Active Exam<span class="req redbold">*</span></label>
                            <br>
                            <input type="hidden" name=""  class="form-control" placeholder="" />
                            <label>Immeidate</label> <input type="radio" name="active_exam" id="active_exam"  value="1" placeholder="" />
                            <label>Immeidate after study</label> <input type="radio" name="active_exam" id="active_exam1"  value="0" placeholder="" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group"><label style="display:block">Pick a color for Course</label>
                                            <div style="background-color: #E62" data-color="#E62" class="color-pallete-edit "></div>
                                            <div style="background-color: #9c27b0" data-color="#9c27b0" class="color-pallete-edit "></div>
                                            <div style="background-color: #00BCD4" data-color="#00BCD4" class="color-pallete-edit "></div>
                                            <div style="background-color: #b9a709" data-color="#b9a709" class="color-pallete-edit"></div>


                                            <div style="background-color: #0AF" data-color="#0AF" class="color-pallete-edit"></div>
                                            <div style="background-color: #05A" data-color="#05A" class="color-pallete-edit"></div>
                                            <div style="background-color: #E91E63" data-color="#E91E63" class="color-pallete-edit "></div>
                                            <div style="background-color: #FF9800" data-color="#FF9800" class="color-pallete-edit"></div>


                                            <div style="background-color: #191" data-color="#191" class="color-pallete-edit  "></div>
                                            <div style="background-color: #FD0" data-color="#FD0" class="color-pallete-edit "></div>
                                            <div style="background-color: #607D8B" data-color="#607D8B" class="color-pallete-edit"></div>
                                            <div style="background-color: #CDDC39" data-color="#CDDC39" class="color-pallete-edit"></div>


                                            <div style="background-color: #305eb1" data-color="#305eb1" class="color-pallete-edit  "></div>
                                            <div style="background-color: #913535" data-color="#913535" class="color-pallete-edit  "></div>
                                            <div style="background-color: #fa68db" data-color="#fa68db" class="color-pallete-edit  "></div>
                                            <div style="background-color: #005020" data-color="#005020" class="color-pallete-edit  "></div>

                    </div>
                        </div>
                         

                    </div>
        
              
            </div>          <div class="modal-footer">
         <button class="btn btn-success">Save</button>
         <button class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
</form>
        </div>  

    </div>
</div>

<?php $this->load->view("admin/scripts/classes_script");?>

