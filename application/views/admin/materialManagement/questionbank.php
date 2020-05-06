
    <div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
        <div class="white_card ">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                    <a href="<?php echo base_url('backoffice/create-question-set-group');?>">
                        <div class="dash_box custom_box">
                            <!-- <i class="fa fa-file-text-o box_icon"></i> -->
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h6 class="text-center">Add comprehension question</h6>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                    <a href="<?php echo base_url('backoffice/create-question-set-single');?>">
                        <div class="dash_box custom_box">
                            <!-- <i class="fa fa-file-text-o box_icon"></i> -->
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h6 class="text-center">Add objective question</h6>
                        </div>
                    </a>
                </div>
                 <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                    <a href="<?php echo base_url('backoffice/upload-question-set-excel');?>">
                        <div class="dash_box custom_box">
                            <!-- <i class="fa fa-file-text-o box_icon"></i> -->
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <h6 class="text-center">Bulk upload</h6>
                        </div>
                    </a>
                </div>
            </div>
            <br><hr>
            <div class="row">
                <div class='form-group col-sm-5'>
                    <label>Materials<span class="req redbold">*</span></label>
                    <select class="form-control" name="material" id="material">
                        <option value="">Please select a material</option>
                        <?php 
                            if(!empty($materials)){
                                foreach($materials as $row){
                        ?>
                            <option value="<?php echo $row->material_id;?>"><?php echo $row->material_name;?></option>
                        <?php }} ?>
                    </select>
                </div>
                <div class='form-group col-sm-5'>
                    <label>Question set<span class="req redbold">*</span></label>
                    <select class="form-control" name="question_set" id="question_set">
                        <option value="">Please select a material</option>
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-info btnFocus form-control" id="viewquestions">View Questions</button>
                </div>
            </div>   
            <div class="questions">
            </div>
        </div>
    </div>
    <div id="modal" class="modal fade form_box modalCustom questionbank-modal" role="dialog">
        <div class=" modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Title</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="modal_body">


                </div>
            </div>
        </div>
    </div>
    <div id="modal1" class="modal fade form_box modalCustom" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title1">Title</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="modal_body1">


                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('admin/scripts/materialManagement/questionbank_script'); ?>
