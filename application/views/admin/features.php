<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card ">
        <h6><?php echo $this->lang->line('activate_feature');?></h6>
        <hr>
        
        <!-- Data Table Plugin Section Starts Here -->

        <div class="table-responsive">
            <form id="permission" type="post">
               
                 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
           <table class="table table-bordered scrolling table-sm Tblcategory table-striped">
        <tbody>
        <!-- <thead> -->
            <tr class="bg-warning text-white">
                <th><?php echo $this->lang->line('sl_no');?></th>
                <th><?php echo $this->lang->line('menu');?></th>
                <th>
                    <div class="custom-control custom-checkbox">
                         <?php $check=$this->common->check_if_dataExist('am_backoffice_modules',array("status"=>"0")); ?>
                        <input type="checkbox" class="custom-control-input"  id="main_view" onclick="check_all_view()" <?php if($check == 0){ echo "Checked";} ?>>

                        <label class="custom-control-label white" for="main_view">
                            <?php echo $this->lang->line('enable/disable');?></label>
                    </div>
                </th>

            </tr>
        <!-- </thead> -->
            <?php  
        //    echo "<pre>"; print_r($modules);
            if(!empty($modules)) {
          
            $i=1; foreach($modules as $key=>$row)
            {
                $mainmodule= $this->common->get_name_by_id('am_backoffice_modules','module',array("backoffice_modules_id"=>$key));
                $mainstatus= $this->common->get_name_by_id('am_backoffice_modules','status',array("backoffice_modules_id"=>$key));
                // show($key)
                if($key == 8){continue;}
            ?>
            <tr class="TblMinCategory">
                <td class="TblSubCategoryLabel">
                     <?php echo $i;?>

                </td>
                
                
                <td class="TblSubCategoryLabel">
                    <?php
                    echo $this->common->get_name_by_id('am_backoffice_modules','module_name',array("backoffice_modules_id"=>$key));

                    ?>
                </td>
                <td>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="module[]" class="custom-control-input main_menu_view" id="main_menu_view_<?php echo $key;?>" onclick="main_menu_view(<?php echo $key;?>)" value="<?php echo $mainmodule;?>" <?php if($mainstatus == 1){ echo "Checked";}?>>
                        <label class="custom-control-label" for="main_menu_view_<?php echo $key;?>"><?php echo $this->lang->line('enable/disable'); ?></label>
                    </div>
                </td>
                

            </tr>
             <?php if(!empty($key))
                    {
                   $j=1; foreach($row as $k=>$val)
                   {
                       $module= $this->common->get_name_by_id('am_backoffice_modules','module',array("backoffice_modules_id"=>$val));
                       $substatus= $this->common->get_name_by_id('am_backoffice_modules','status',array("backoffice_modules_id"=>$val));
                      
            ?>
            <tr class="TblSubCategory">
                <td class="TblSubCategoryLabel">
                   <?php echo $i.".".$j;?>

                </td>
                <td class="TblSubCategoryLabel">
                    <?php //echo $key;
                    echo $this->common->get_name_by_id('am_backoffice_modules','module_name',array("backoffice_modules_id"=>$val));
                    ?>
                </td>
                <td>

                    <div class="custom-control custom-checkbox MargLeft25">
                        <input type="checkbox" name="module[]" class="custom-control-input sub_menu_view sub_menu_view_<?php echo $key;?>" id="sub_menu_view_<?php echo $val;?>" value="<?php echo $module;?>"  <?php if($substatus == 1){ echo "Checked";}?> onclick="sub_menu_view(<?php echo $key;?>,<?php echo $val;?>)">
                        <label class="custom-control-label" for="sub_menu_view_<?php echo $val;?>"><?php echo $this->lang->line('enable/disable'); ?></label>
                    </div>
                </td>

            </tr>
             <?php
                
                $j++;}}
                                                 
               
             $i++;}
            }
            ?>
            
            
                  </tbody>
    </table>
          <div class="col-md-12 col-sm-12 col-12 ">
                <!-- <button class="btn btn-info btn_save"><?php echo $this->lang->line('activate_feature'); ?></button>
                <a class="btn btn-default btn_save" id="cancelEdit">Cancel</a> -->
            </div>
            </form>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>

<!--modal-->



<?php $this->load->view("admin/scripts/features_script");?>
