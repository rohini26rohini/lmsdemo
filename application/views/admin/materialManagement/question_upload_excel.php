<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12">
    <div class="white_card ">
        <form id="excelform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
            <div class="row ">
                <div class='form-group col-sm-6'>
                    <label>Question set<span class="mandatory-asterisk">*</span></label>
                    <select class="form-control" name="question_set" id="question_set">
                        <option value="">Select</option>
                        <?php
                                if(!empty($questionsets)){
                                    foreach($questionsets as $row){
                            ?>
                        <option value="<?php echo $row->question_set_id;?>"><?php echo $row->question_set_name;?></option>
                        <?php }} ?>
                    </select>
                </div>
                <div class='form-group col-sm-6'>

                    <div class="form-group"><label>Questions<span class="req redbold">*</span></label>
                        <input class="form-control" type="file" name="question">
                       <!-- <p style="margin-bottom:5px;">Upload .xls,.xlsx,csv files only.</p>-->
                        <a href="<?php echo base_url(); ?>uploads/samples/Question_set_sample.ods" download="">Click Here to download sample</a>
                    </div>

                </div>
                <div class="form-group col-sm-12">
                    <button type="submit" class="btn btn-info btn_save">save</button>
                </div>

            </div>
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
        </form>

    </div>
</div>
<?php $this->load->view('admin/scripts/materialManagement/question_upload_excel_script'); ?>
