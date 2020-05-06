
                <div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
                    <div class="white_card ">
                        <form autocomplete="off" id="savePreviewExamModel" method="post" accept-charset="utf-8">
                            <div class="row">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                <div class="col-sm-2">
                                    <h6>Exam model creation</h6>
                                    <!-- <?php echo strtoupper($exam->exam_name);?> -->
                                </div>
                                <div class="col-sm-4"> </div>
                                <div class="col-sm-4">
                                    <input name="examname" id="examname" type="text" placeholder="Exam Model Name" class="form-control" value="<?php echo $exam->exam_name;?>"/>
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-info btn_save_preview pull-right">Save & Preview</button>
                                </div>
                            </div>
                        </form>
                        <hr/>
                        <div class="table-responsive">
                            
                            <div class="accordion accordion_branch" id="accordionExample">
                            <?php 
                                if(!empty($sections)){ 
                                    foreach($sections as $row){
                            ?>
                                <div class="card">
                                    <div class="card-header" id="heading<?php echo $row->id;?>" onClick="getSection(<?php echo $row->id;?>)">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $row->id;?>" aria-expanded="true" aria-controls="collapse<?php echo $row->id;?>">
                                                <?php echo $row->section_name;?>
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapse<?php echo $row->id;?>" class="collapse" aria-labelledby="heading<?php echo $row->id;?>" data-parent="#accordionExample">
                                        
                                    </div>
                                </div>
                            <?php }} ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="finishmodal" class="modal fade form_box show modalCustom" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <h4 style="text-align: center;" class="modal-title" id="finishmodal_title">Title</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form id="exam_finishmodal" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <div class="modal-body" id="finishmodal_body"></div>
                        <div class="modal-footer" id="finishmodal_footer"></div>
                    </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var section = new Array();
        <?php 
            if(!empty($sections)){ 
                foreach($sections as $row){
        ?>
            section[<?php echo $row->id;?>] = 0;
        <?php }} ?>
    </script>
    <?php $this->load->view('admin/scripts/examManagement/exam_definition_section_list_script'); ?>
