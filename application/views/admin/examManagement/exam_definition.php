
                <div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
                    <div class="white_card ">
                        <h6>Manage Exam Model</h6>
        <hr>
                        <!-- Data Table Plugin Section Starts Here -->




                                <button onClick="resetform();" class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" data-toggle="modal" data-target="#myModal"  onclick="formclear('add_institute_form')">
                                    Add Model
                                </button>



                       <div class="table-responsive table_language" style="margin-top:15px;">
                           <table id="institute_data" class="table table-striped table-sm" style="width:100%">

                                <thead><tr>
                                    <th width="70">Sl.No.</th>
                                    <th>Exam Model</th>
                                    <th>Exam Duration</th>
                                    <th>Exam Type</th>
                                    <th>No. of Sections</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr></thead>
                                <?php $i=1; if(!empty($templates)){ foreach($templates as $row){ ?>
                                <tr id="exam<?php echo $row->id;?>">
                                    <td width="50"><?php echo $i; ?></td>
                                    <td width="50"><?php echo $row->exam_name; ?></td>
                                    <td><?php echo $row->duration_in_min; ?> Mins</td>
                                    <?php
                                        if($row->follow_section_sequnce){
                                            $type = "Multi Sectioned and Sequential";
                                        }else{
                                            if($row->sections>1){
                                                $type = "Multiple Sections Only";
                                            }else{
                                                $type = "Single";
                                            }
                                        }
                                    ?>
                                    <td><?php echo $type; ?></td>
                                    <td><?php echo $row->sections; ?></td>
                                    <td>
                                        <?php
                                            if($row->record_status==2){
                                                echo '<span style="color:green;">Active</span>';
                                            }
                                            if($row->record_status==1){
                                                echo '<span style="color:red;">Session definitions are pending</span>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-default option_btn" title="Edit" onclick="edit_exam(<?php echo $row->id;?>)">
                                            <i class="fa fa-pencil "></i>
                                        </button>
                                        <button class="btn btn-default option_btn" title="Delete" onclick="delete_exam('<?php echo $row->id;?>')">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>

                                </tr>
                                <?php $i++; } }  ?>
                                
                            </table>
                        </div>

                    </div>
                </div>



    <div id="myModal" class="modal fade modalCustom" role="dialog">
        <div class="modal-dialog" style="max-width: 767px">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Exam Model</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                   <form autocomplete="off" id="examdefine" method="post" accept-charset="utf-8">
                <div class="modal-body">
                 
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                       <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Exam Model Name<span class="req redbold">*</span></label>
                                    <input name="examname" id="examname" type="text" placeholder="Exam Model Name" class="form-control" />
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Exam Duration (in minutes)<span class="req redbold">*</span></label>
                                    <input name="examduration" id="examduration" onkeypress="return valNum(event)" type="text" placeholder="Exam Duration (in minutes)" class="form-control" />
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Exam Section Type<span class="req redbold">*</span></label>
                                    <select name="examtype" id="examtype" class="form-control">
                                        <option value="">Select type</option>
                                        <option value="1">Single</option>
                                        <option value="2">Multiple Sections Only</option>
                                        <option value="3">Multi Sectioned and Sequential</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 noofsections">
                                <div class="form-group">
                                    <label>No. of Sections</label>
                                    <input name="noofsections" id="noofsections" placeholder="No. of Sections" onkeypress="return valNum(event)" type="text" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row" id="sections">
                        </div>
                        
				
                </div>
                       <div class="modal-footer">
                            <button type="submit" class="btn btn-success ">Continue</button>
                            <button type="button" data-dismiss="modal" class="btn btn-default btn_cancel" onClick="resetform();">Cancel</button>
                       </div>
	</form>
            </div>

        </div>
    </div>
    <?php $this->load->view('admin/scripts/examManagement/exam_definition_script'); ?>
