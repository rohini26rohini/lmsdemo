<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <form id="discount_form" action="POST">
            <input type="hidden" id="discount_student_id" name="student_id" value="<?php echo $studentArr['student_id'];?>" />
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            <span id="student_discount_table">
        <ul class="data_table" style="margin-top:0;">
        <li class="data_table_head ">
            <div class="col">Category</div>
            <div class="col">Description</div>
            <div class="col">Discount</div>
            <div class="col actions">Actions</div>
        </li>
        <?php
                $course_id = '';
            if(!empty($studentcourse)) {
                $course_id = $studentcourse['course_id'];
                $batch_id = $studentcourse['batch_id'];
            }
            if($batch_id!='')
            {
            //$payment_detail = $this->common->get_from_tablerow('pp_student_payment', array('student_id'=>$studentArr['student_id'],'batch_id'=>$batch_id));
               // print_r($paymentd_detail);
               // echo $studentArr['student_id']."<br>";
               // echo $batch_id;

            }
            $applieddiscount = array();
            if(!empty($discounts)) {
            foreach($discounts as $row){ 
            if($course_id!='') {
            $applieddiscount = $this->common->get_from_tablerow('pp_student_discount', array('student_id'=>$studentArr['student_id'],'course_id'=>$course_id,'package_id'=>$row->package_id));
            }
            ?>
                <li id="row_<?php echo $row->package_id;?>">
                    <div class="col"><?php echo $row->package_name;?></div>
                    <div class="col"><?php echo $row->package_desc;?></div>
                    <div class="col">
                    <?php 
                        if($row->package_type==2) {
                            echo $row->package_amount.'%'; 
                        } else {
                            echo 'Rs.'.$row->package_amount; 
                        }
                       ?>
                    </div>
                    <div class="col actions">
                        <input type="checkbox" class="dicountsave" name="discounts[]" value="<?php echo $row->package_id;?>" <?php if(!empty($applieddiscount)) { ?> checked="checked" <?php } ?>
                        <?php if(!empty($payment_detail)) { if($payment_detail['status'] == "1"){?> disabled <?php } } ?>/>
                    </div>
                </li>
<?php }?>

    </ul>

        <div class="form-group"  <?php if(!empty($payment_detail)) { if($payment_detail['status'] == "1"){ ?> style="display:none" <?php }} ?>>
            <label style="display:block">&nbsp;</label>
            <button type="submit" class="btn btn-info btn_save">Save</button>
        </div>


<?php }else { ?>
<span>Discount package not added.</span>
            <?php } ?>
            </span>
            <ul class="data_table ">
                <li id="student_discount_hide" style="display:none;">Batch allocation not completed</li>
            </ul>
        </form>
    </div>
</div>
