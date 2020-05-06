<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6>Manage External Batch</h6>
        <hr>
        <button type="button" class="btn btn-default add_row add_new_btn btn_add_call addBtnPosition" onclick="add_ext_batch()">
            Add External Batch
        </button>
        <div class="table-responsive table_language" style="margin-top:15px;">
            <table id="external_candidates" class="table table-striped table-sm dirstudent-list" style="width:100%">
                <thead>
                    <tr>
                        <th width="10%">Sl.No.</th>
                        <th width="45%">Batch Name</th>
                        <th width="15%">Batch Code</th>
                        <th width="20%">Created Date</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody id="external_candidates_body">
                    <tr>
                        <td></td>
                        <td>Loading please wait</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="add_edit" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="add_edit_title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
             <form enctype="multipart/form-data" id="add_edit_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>External Batch Name<span class="req redbold">*</span></label>
                                <input type="text" name="batch_name" id="batch_name"class="form-control" />
                            </div>
                        </div>
                        <input type="hidden" name="batch_id" id="batch_id"/>
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
<?php $this->load->view("admin/scripts/students/external_batch_script");?>
