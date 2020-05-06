<form id="all_qualification_form" method="post" enctype="multipart/form-data">
    <div id="section_duplicates2">
        <hr class="no_hr" />
        <div class="add_wrap">
            <div class="row" id="result">
            <input type="hidden" name="stud_id" id="stud_id" value="<?php echo $studentArr['student_id']; ?>" />
                <input type="hidden" name="course_id" id="course_id" value="<?php if(!empty($studentcourse)) { echo $studentcourse['student_id']; } ?>" />

            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            <?php 
            $allqualificationArr = $this->common->get_all_student_others($studentArr['student_id']);
            $i=1; 
            $query = array();
            foreach($allqualificationArr as $rows){?>
                <input type="hidden" name="qualification_id[]" id="qualification_id" value="<?php echo !empty($rows)?$rows['qualification_id']:''; ?>" />
                <?php $query=  $this->common->get_student_docs($rows['student_id'],$rows['qualification_id']); ?>
                <input type="hidden" name="files" id="files" value="<?php echo !empty($query)?$query['file']:''; ?>" />
            <?php if($rows['category']=="sslc"){ ?>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Class X or Below</label>
                        <input type="hidden" name="category[]" value="<?php echo !empty($rows)?$rows['category']:''; ?>"/>
                        <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="<?php echo !empty($rows)?$rows['qualification']:''; ?>" placeholder="Document Name" />
                    </div>
                </div>
            <?php }else if($rows['category']=="plustwo"){ ?>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>+2/VHSE</label>
                        <input type="hidden" name="category[]" value="<?php echo !empty($rows)?$rows['category']:''; ?>"/>
                        <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="<?php echo !empty($rows)?$rows['qualification']:''; ?>" placeholder="Document Name" />
                    </div>
                </div>
            <?php }else if($rows['category']=="degree"){ ?>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Degree</label>
                        <input type="hidden" name="category[]" value="<?php echo !empty($rows)?$rows['category']:''; ?>"/>
                        <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="<?php echo !empty($rows)?$rows['qualification']:''; ?>" placeholder="Document Name" />
                    </div>
                </div>
            <?php }else if($rows['category']=="pg"){ ?>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>PG</label>
                        <input type="hidden" name="category[]" value="<?php echo !empty($rows)?$rows['category']:''; ?>"/>
                        <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="<?php echo !empty($rows)?$rows['qualification']:''; ?>" placeholder="Document Name" />
                    </div>
                </div>
            <?php }else { ?>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Additional Qualification</label>
                        <input class="form-control"  type="text" id="document_name1" readonly="readonly" name="document_name1[]"  value="<?php echo !empty($rows)?$rows['qualification']:''; ?>" placeholder="Document Name" />
                    </div>
                </div>
            <?php } ?>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Upload File
                        <?php if(!empty($query)){ echo " : ".$query['document_name'];} ?>
                        </label>
                        <input type="file"  id="file" class="form-control doc_upload myFile"   name="file_name1[]"  multiple="multiple" value="" onchange="validate(this.files)"/>
                        <p>Upload .pdf,.docx,.jpg files only  (Max Size:10MB).</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label style="display:block">Verified</label>
                        <select class="form-control"  id="document_verification1" name="verification1[]" value= "">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>
            <?php $i++;}?>
            <?php //if($i!=0){ ?>
                <div class="col-sm-12">
                    <div class="form-group">
                        <button type="button" id= "submit" onclick="all_qualification_form();"  class="btn btn-info btn_save">Save</button>
                    </div>
                </div>
            <?php// } ?>
            </div>
        </div>
    </div>
</form>


<form id="document_form" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div id="section_duplicate2">
                <h6>Other Documents</h6>
                <hr/>
                <div class="add_wrap">
                    <div class="row">
                        <input type="hidden" name="student_id" id="student_id" value="<?php echo $studentArr['student_id']; ?>" />
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Document Name</label>
                                <input class="form-control" type="text" id="document_name" name="document_name" placeholder="Document Name" />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Upload File</label>
                                <?php if(!empty($query)){ echo " : ".$query['document_name'];} ?>
                                <input type="file" class="form-control myFile" id="docfile" name="file_name" onchange="validate(this.value)"/>
                                <p>Upload .pdf,.docx,.jpg files only  (Max Size:10MB).</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label style="display:block">Verified</label>
                                <select class="form-control" id="document_verification" name="verification">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label style="display:block">&nbsp;</label>
                                <button type="submit" id="submitted" class="btn btn-info btn_save">Save Other Documents</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div> 
</form>

<div class="row">
    <div class="col-12">
        <ul class="data_table " id="student_document_table">
            <li class="data_table_head ">
                <div class="col">Qualification name</div>
                <div class="col">Document file</div>
                <div class="col">Verified</div>
                <div class="col actions">Actions</div>
            </li>
            <?php 
            if(!empty($documents)) {
               
            foreach($documents as $row){ if($row->file!='') { ?>
            <li id="row_<?php echo $row->student_documents_id;?>">
                <?php if(!empty($row->qualification_id)){?>
                <div class="col">
                    <?php echo $row->qualification;?>
                </div>
            <?php }else{ ?>
                <div class="col">
                    <?php echo $row->document_name;?>
                </div>
           <?php } ?>
                <div class="col">
                    <a target="_blank" href="<?php echo base_url($row->file);?>">Download document</a>
                </div>
                <div class="col">
                    Yes &nbsp;<input type="radio" name="verfied<?php echo $row->student_documents_id;?>" <?php if($row->verification==1){echo 'checked="checked"';}?> value="1" onclick="verify_document(
                    <?php echo $row->student_documents_id;?>);"> &nbsp;&nbsp;&nbsp; No &nbsp;<input type="radio" name="verfied<?php echo $row->student_documents_id;?>" <?php if($row->verification==0){echo 'checked="checked"';}?> value="0" onclick="unverify_document(
                    <?php echo $row->student_documents_id;?>);">
                </div>
                <div class="col actions">
                    <button class="btn btn-default btn_details_view" title="Delete" onclick="delete_fromtable('<?php echo $row->student_documents_id;?>')">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </li>
                    <?php } ?>
            <?php }}else { ?>
            <li>Please add some documents.</li>
            <?php } ?>
        </ul>
    </div>
</div>
