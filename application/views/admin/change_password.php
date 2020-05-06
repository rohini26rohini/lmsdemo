<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card ">
        <h6><?php echo $this->lang->line('change_password'); ?></h6>
        <hr>
        <form id="password_form" type="post">
        <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
             <div class="form-group">
                  <label><?php echo $this->lang->line('old_password'); ?><span class="req redbold">*</span></label>
                      <input type="password" class="form-control" name="old" id="old">
             </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
             <div class="form-group">
                  <label><?php echo $this->lang->line('new_password'); ?><span class="req redbold">*</span></label>
                      <input type="password" class="form-control" name="new" id="new">
             </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
             <div class="form-group">
                  <label><?php echo $this->lang->line('confirm_password'); ?><span class="req redbold">*</span></label>
                      <input type="password" class="form-control" name="confirm">
             </div>
        </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="form-group">
                    <button type="submit" class="btn btn-info btn_save"><?php echo $this->lang->line('change_password'); ?></button>
                   
                </div>
            </div>

        </div>
        </form>
    </div>
</div>
<?php $this->load->view("admin/scripts/change_password_script");?>
