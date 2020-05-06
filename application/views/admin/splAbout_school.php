<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="white_card">
        <h6><?php echo $this->lang->line('special_about_school');?></h6>
        <hr>
        <div class="row">
        <form id="spl_form" class="splform" method="post">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">  
                <div class="form-group">
                    <label><?php echo $this->lang->line('school');?> <span class="req redbold">*</span></label>
                    <select class="form-control" name="school" id="school" onchange="change_special(this.value)">
                        <?php 
                        if(!empty($school)) {
                            foreach($school as $schools){?>
                                        <option value="<?php echo $schools->school_id?>"<?php if($schools->school_id == $special_school_id){ echo "selected"; }?>><?php echo $schools->school_name;?></option>';
                            <?php  } 
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div id="keywords">
                <?php  
                $j =0;
                    if(!empty($single_school)) {
                        foreach($single_school as $Sschools){ $j++;?>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">  
                                <div class="form-group Commentsboxs"> 
                                    <div class="row">
                                        <div class="col-md-1 text-center justify-content-sm-center d-sm-flex">
                                            <span class="Commentno"><?php echo $j ?></span>
                                        </div>
                                        <div class="col-md-11">
                                            <input type="text" name="keyword<?php echo $j ?>" id="keyword<?php echo $j ?>" class="form-control" value="<?php echo $Sschools->keywords ?>"/>
                                            <input type="hidden" name="id<?php echo $j ?>" id="id<?php echo $j ?>" value="<?php echo $Sschools->about_id ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">  
                <button class="btn btn-success sasupdate" type="submit">Update</button>
            </div>
        </form>
        </div>   
    </div>
</div> 
<?php $this->load->view("admin/scripts/splAbout_school_script");?>