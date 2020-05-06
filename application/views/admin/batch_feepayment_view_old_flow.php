<?php  //print_r($batch_fee);
$paidstatus = '';
if($verification==1) {
if(!empty($batch_fee) && $batch_fee->batch_id!='') { 
    if($seats=='available') {
        if($discnt!='Pending') {
        $early_fee          = $this->common->get_early_fee_bystudent($student_id, $batch_fee->batch_id);
?>
<div class="row">
    <?php 
     $totaldiscount = 0;
     $otherfees = 0;
    if($batch_fee->course_paymentmethod == 'onetime') {
        $feepaid = $this->common->get_paidstatus($batch_fee->student_id, $batch_fee->institute_course_mapping_id);
     ?>
    <input type="hidden" value="<?php echo $batch_fee->student_id;?>" name="student_id" />
    <input type="hidden" value="<?php echo $batch_fee->batch_id;?>" name="batch_id" />
    <input type="hidden" value="<?php echo $batch_fee->institute_course_mapping_id;?>" name="institute_course_mapping_id" />
    <input type="hidden" value="<?php echo $batch_fee->course_paymentmethod;?>" name="payment_type" />
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="row">
            <div class="col-12">
                <?php //print_r($batch_fee);?>
                <?php if(!empty($early_fee)) { ?>
                 <table class="table table_register_fee table-bordered table-striped table-sm">
                     <tr>
                        <th colspan="2" style="background-color:#20c997; color:#fff;">Advance Paid</th>
                     </tr>
                     <?php
                     foreach($early_fee as $val) {
                      ?>
                     <tr>
                        <td><?php echo $val->batch_name;?></td>
                         <td><?php echo 'Paid Fee: <label>'.numberformat($val->paid_amount).'</label>';?></td>
                     </tr>
                     <?php } ?>
                 </table>
                <?php } ?>
                <div class="table-responsive table_language">
                <h6>Payment Details</h6>    
                <table class="table table-bordered table-striped table-sm">
                    <tbody><tr>
                        <th>Sl no.</th>
                        <th>Title</th>
                        <th>Amount</th>
                    </tr>
                    <?php  $slno = 1; ?>
                    <tr>
                        <td><?php echo $slno;?></td>
                        <td>Tution Fee</td>
                        <td class="text-right"><?php echo numberformat($batch_fee->course_tuitionfee);?></td>
                    </tr>
                    <?php
                    $slno++;
                    if($hostel!='') {
                        $otherfees += $hostel;
                        ?>
                     <tr>
                        <td><?php echo $slno++;?></td>
                        <td>Hostel Fee</td>
                        <td class="text-right"><?php echo numberformat($hostel);?><input type="hidden" name="hostelamt" value="<?php echo $hostel;?>"/></td>
                    </tr>
                    <?php } ?>
                    <?php if($transport!='') {
                        $otherfees += $transport;
                        ?>
                     <tr>
                        <td><?php echo $slno++;?></td>
                        <td>Transport Fee</td>
                        <td class="text-right"><?php echo numberformat($transport);?><input type="hidden" name="transamt" value="<?php echo $transport;?>"/></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td><?php echo $slno++;?></td>
                        <td>CGST</td>
                        <td class="text-right"><?php echo numberformat($batch_fee->course_cgst);?></td>
                    </tr> 
                    <tr>
                        <td><?php echo $slno++;?></td>
                        <td>SGST</td>
                        <td class="text-right"><?php echo numberformat($batch_fee->course_sgst);?></td>
                    </tr> 
                    <?php
                        $discount = $this->common->get_student_discount_details($student_id,$course_id);
                        if(!empty($discount)) {
                            foreach($discount as $disnt) { 
                        ?>
                        <tr>
                        <td><?php echo $slno;?></td>
                        <td><?php echo $disnt->package_name;
                                if($disnt->package_type==2) { echo ' ['.$disnt->st_discount.'%] '; } 
                                if($disnt->discount_status==1) {
                                    echo ' <b style="color:green;">Approved</b>';$totaldiscount += $disnt->discount_amount;  
                                } else if($disnt->discount_status==2) {
                                    echo ' <b style="color:red;">Declined</b>';
                                }
                                ?></td>
                        <td class="text-right">
                            <?php
                                 if($disnt->discount_status==1) {
                                echo '-'.numberformat($disnt->discount_amount);
                                 }
                            ?>
                        </td>
                    </tr>
                        <?php $slno++; ?>
                            <?php } ?>
                        
                                <input type="hidden" name="discount_amt" value="<?php echo $totaldiscount;?>" />
                         <tr class="totalFeeBg">
                            <td colspan="2" class="text-right" style="font-family:bold;">Total Discount</td>
                            <td class="text-right"><?php echo numberformat($totaldiscount);?></td>
                        </tr>
                            <?php } ?>
                       <tr class="totalFeeBg">
                                <td colspan="2" class="text-right" style="font-family:bold;">Total Fee</td>
                                <td class="text-right"><?php echo numberformat($batch_fee->course_totalfee);?></td>
                            </tr>
                            <tr class="totalFeeBg">
                                <td colspan="2" class="text-right" style="font-family:bold;">Payable Fee</td>
                                <td class="text-right"><?php 
                            if($totaldiscount>0) {
                             echo numberformat($otherfees+$batch_fee->course_totalfee-$totaldiscount);
                            } else {
                            echo numberformat($otherfees+$batch_fee->course_totalfee);
                            }
                            ?></td>
                            </tr>
                        <?php if(!empty($feepaid)) { ?>
                        <?php  
                            $paidamt = 0;
                            $balance = 0;
                            $payment_id = '';
                            foreach($feepaid as $paid) {
                            $payment_id = $paid->payment_id;    
                            $payable_amount = $paid->payable_amount;
                            $balance    =    $paid->balance;
                            $paidamt += $paid->paid_amount;
                            }
                        ?>
                        <tr class="totalFeeBg">
                                <td colspan="2" class="text-right" style="font-family:bold;">Total amount paid</td>
                                <td class="text-right"><?php echo numberformat($paidamt);?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </div>
            </div>
            <?php
                        if(!empty($feepaid)) { 
                        $paidstatus = 1;
                        ?>
            <div class="col-12">
                <h6>Payment History</h6>
                <table class="table table_register table_register_fee table-bordered table-striped">
                    <input type="hidden" name="parent_payment_id" value="<?php echo $feepaid[0]->payment_id;?>" />
                    <tbody>
                        <?php  
                            $paidamt = 0;
                            $balance = 0;
                            $payment_id = '';
                            foreach($feepaid as $paid) {
                            $payment_id = $paid->payment_id;    
                            $payable_amount = $paid->payable_amount;
                            $balance    =    $paid->balance;
                            $paidamt += $paid->paid_amount;
                        ?>
<!--
                        <tr>
                            <td>Paid Amount</td>
                            <td><label><?php echo numberformat($paid->paid_amount);?></label></td>
                        </tr>
-->
                        <tr>
                            <td>Paid date</td>
                            <td><label><?php echo $paid->createddate;?></label></td>
                        </tr>
                        <tr>
                            <td>Payment mode</td>
                            <td><label><?php echo $paid->paymentmode;?></label></td>
                        </tr>
                        <?php 
                        if($paid->paymentmode!='Cash') {        
                        if($paid->paymentmode=='Card') {
                        ?>
                        <tr>
                            <td>Details</td>
                            <td><label><?php echo $paid->card_type.', <br>'.$paid->card_holder_name.', <br>'.$paid->bank_name;?></label></td>
                        </tr>
                        <?php } else if($paid->paymentmode=='Cheque') { ?>
                        <tr>
                            <td>Details</td>
                            <td><label><?php echo 'Cheque No. '.$paid->cheque_no.', <br>'.$paid->card_holder_name.', <br>'.$paid->bank_name;?></label></td>
                        </tr>
                        <?php } else { ?>
                        <tr>
                            <td>Details</td>
                            <td><label><?php echo 'Transaction ID. '.$paid->transaction_id;?></label></td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                        <?php
                        if($paid->balance>0) {
                        ?>
                            <tr>
                                <td>Balance</td>
                                <td><label><?php echo numberformat($paid->balance);?></label></td>
                            </tr>
                            <?php } ?>
                            <?php } ?>
                            <tr>
                                <td style="color:green;">Total amount paid</td>
                                <td><label style="color:green;"><?php echo numberformat($paidamt);?></label></td>
                            </tr>
                    </tbody>
                </table>
            </div>
                <?php 
                        if($payable_amount>$paidamt) { 
                        ?>
                <div class="col-12">
                    <div class="form-group">
                        <label>Payment Mode</label>
                        <select class="form-control modeofpay" name="modeofpay">
                            <option value="Cash">Cash</option>
                            <option value="Card">Card</option>
                            <option value="Cheque">Cheque</option>
                          </select>

                    </div>
                </div>
                <div class="col-12 cardclass" style="display:none;">
                    <div class="form-group">
                        <label>Card Type</label>
                        <select class="form-control" name="cardtype">
                            <option value="Visa">Visa</option>
                            <option value="MasterCard">MasterCard</option>
                            <option value="Maestro">Maestro</option>
                            <option value="Discover">Discover</option>
                            <option value="American Express">American Express</option>
                          </select>
                    </div>
                </div>
                <div class="col-12 cardclass" style="display:none;">
                    <div class="form-group">
                        <label>Card Holder Name<span class="req redbold">*</span></label>
                        <input type="text" class="form-control txtOnly" value="" name="cardholdername" />
                    </div>
                </div>
                <div class="col-12 cardclass" style="display:none;">
                    <div class="form-group">
                        <label>Bank Name<span class="req redbold">*</span></label>
                        <input type="text" class="form-control txtOnly" value="" name="bankname" />
                    </div>
                </div>
                <div class="col-12 chequeclass" style="display:none;">
                    <div class="form-group">
                        <label>Bank Name<span class="req redbold">*</span></label>
                        <input type="text" class="form-control txtOnly" value="" name="bankaccount" />
                    </div>
                </div>
                <div class="col-12 chequeclass" style="display:none;">
                    <div class="form-group">
                        <label>Account Holder Name<span class="req redbold">*</span></label>
                        <input type="text" class="form-control" value="" name="accholdername" />
                    </div>
                </div>
                <div class="col-12 chequeclass" style="display:none;">
                    <div class="form-group">
                        <label>Cheque No<span class="req redbold">*</span></label>
                        <input type="text" class="form-control numbersOnly" value="" name="chequeno" maxlength="6" />
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label>Payable Balance</label>
                        <input class="form-control" type="hidden" value="<?php echo $batch_fee->course_totalfee;?>" name="fee_paid_amount" />
                        <input class="form-control" value="<?php echo $balance;?>" name="payablebalance" readonly="readonly" />
                        <input class="form-control" type="hidden" value="<?php echo $batch_fee->course_totalfee;?>" name="payableamount" readonly="readonly" />
                        <?php
                        if($payment_id!='') {
                            echo '<input type="hidden" value="'.$paidamt.'" name="amtpaid"/>';
                            echo '<input type="hidden" value="'.$payment_id.'" name="payment_id"/>';
                        }   
                        ?>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-info btn_save paynow" id="paynowbutton">Paynow</button>

                    </div>
                </div>
                <?php } ?>
                <?php } else { ?>

                <div class="col-12">
                    <div class="form-group">
                        <label>Payment Mode</label>
                        <select class="form-control modeofpaytwo" name="modeofpay">
                            <option value="Cash">Cash</option>
                            <option value="Card">Card</option>
                            <option value="Cheque">Cheque</option>
                          </select>

                    </div>
                </div>

                <div class="col-12 cardclasstwo" style="display:none;">
                    <div class="form-group">
                        <label>Card Type</label>
                        <select class="form-control" name="cardtype">
                            <option value="Visa">Visa</option>
                            <option value="MasterCard">MasterCard</option>
                            <option value="Maestro">Maestro</option>
                            <option value="Discover">Discover</option>
                            <option value="American Express">American Express</option>
                          </select>
                    </div>
                </div>
                <div class="col-12 cardclasstwo" style="display:none;">
                    <div class="form-group">
                        <label>Card Holder Name<span class="req redbold">*</span></label>
                        <input type="text" class="form-control txtOnly" value="" name="cardholdername" />
                    </div>
                </div>
                <div class="col-12 cardclasstwo" style="display:none;">
                    <div class="form-group">
                        <label>Bank Name<span class="req redbold">*</span></label>
                        <input type="text" class="form-control txtOnly" value="" name="bankname" />
                    </div>
                </div>
                <div class="col-12 chequeclasstwo" style="display:none;">
                    <div class="form-group">
                        <label>Bank Name<span class="req redbold">*</span></label>
                        <input type="text" class="form-control" value="" name="bankaccount" />
                    </div>
                </div>
                <div class="col-12 chequeclasstwo" style="display:none;">
                    <div class="form-group">
                        <label>Account Holder Name<span class="req redbold">*</span></label>
                        <input type="text" class="form-control txtOnly" value="" name="accholdername" />
                    </div>
                </div>
                <div class="col-12 chequeclasstwo" style="display:none;">
                    <div class="form-group">
                        <label>Cheque No<span class="req redbold">*</span></label>
                        <input type="text" class="form-control numbersOnly" value="" name="chequeno" maxlength="6" />
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label>Amount Payable</label>
                        <input class="form-control" type="hidden" value="<?php echo $batch_fee->course_totalfee;?>" name="fee_paid_amount" />
                        <input class="form-control" value="<?php if($totaldiscount>0) {
                             echo number_format($otherfees+$batch_fee->course_totalfee-$totaldiscount, 2, '.', '');
                            } else {
                            echo number_format($otherfees+$batch_fee->course_totalfee, 2, '.', '');
                            }?>" name="payableamount" readonly="readonly" />


                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-info btn_save paynow" id="paynowbutton">Paynow</button>

                    </div>
                </div>

                <?php } ?>

        </div>
    </div>
    <?php } else { 
                        $installment = $this->common->get_batch_installment($batch_fee->institute_course_mapping_id);
                  ?>
    <input type="hidden" value="<?php echo $batch_fee->student_id;?>" name="student_id" />
    <input type="hidden" value="<?php echo $batch_fee->batch_id;?>" name="batch_id" />
    <input type="hidden" value="<?php echo $batch_fee->institute_course_mapping_id;?>" name="institute_course_mapping_id" />
    <input type="hidden" value="<?php echo $batch_fee->course_paymentmethod;?>" name="payment_type" />
    <input type="hidden" value="<?php echo $batch_fee->course_totalfee;?>" name="payableamount" />
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <ul class="checkbox_list" id="paymentcheckbox">
            <?php 
                        if(!empty($installment)) {
                        $x =1;
                        $paidinstall = array();
                        $discntApplied = 0;
                        $hosteltrans = 0;
                        $paidfee = $this->common->get_paidinstallment($batch_fee->student_id, $batch_fee->institute_course_mapping_id); 
                        foreach($installment as $install) {
                            if(!empty($paidfee)) {
                            $paidinstall =  $this->common->paidinstallment($x, $paidfee->payment_id); 
                            echo '<input type="hidden" value="'.$paidfee->payment_id.'" name="payment_id" />';    
                            }
                            if(!empty($paidinstall) && $paidinstall->installment_amount>0) {
                                $discntApplied = 1;
                            }
                     ?>
            <li><label class="custom_checkbox <?php if(!empty($paidinstall) && $paidinstall->installment_paid_amount>0){ echo 'instComplete'; } ?>">Installment <?php echo $x;?>  Amount : <?php echo numberformat($install->installment_amount);?>
                        <input type="checkbox" name="installment[]" value="<?php echo $x;?>" class="hostel installmentchk" <?php echo (!empty($paidinstall) && $paidinstall->installment_paid_amount>0)?'checked="checked" disabled="disabled"':'';?> >  
                        <?php
                        if(empty($paidinstall)) {
                        ?>
                        <input type="hidden" name="installment_id[]" value="<?php echo $install->installment_id;?>">
                        <input type="hidden" name="installment_amt[]" value="<?php echo $install->installment_amount;?>">
                        <?php } ?>
                              <span class="checkmark" <?php if($x==1) { ?> id="firstinstallslct" <?php } ?> onclick="feepayinstallment();"></span>
                            </label>
            </li>
            <?php $x++; ?>
            <?php } ?>
            <?php 
                    $totaldiscountin = 0;  
                    $discountstatus  = 0;         
                    $discount = $this->common->get_student_discount_details($student_id,$course_id); 
                    if(!empty($discount)) {
                    foreach($discount as $disnt) { 
                        if($disnt->discount_status==1) {
                            //$totaldiscount += $disnt->discount_amount;  
                            $totaldiscountin += $disnt->discount_amount;  
                            $discountstatus = 1;
                        } else if($disnt->discount_status==2) {

                        }
                     } 
                    if($discntApplied!=1) {  
                        if($discountstatus==1) {
                    ?>

            <li class="apply_box">
                <label class="apply_box_label">Apply Discount <b><?php echo numberformat($totaldiscountin);?></b></label>
                <input type="hidden" name="discountAmt" value="<?php echo $totaldiscountin;?>" />
                <div class="form-check-inline">
                    <label class="form-check-label custom_radio">
                            <input type="radio" class="form-check-input" name="discountapply" id="discountapplyyes" value="1" checked="checked">Yes
                                      <span class="radiomark" onclick="feepayinstallment();"></span>
                          </label>
                </div>
                <div class="form-check-inline ">
                    <label class="form-check-label custom_radio">
                            <input type="radio" class="form-check-input" name="discountapply" id="discountapplyno" value="0">No
                                      <span class="radiomark" onclick="feepayinstallment();"></span>
                          </label>
                </div>
            </li>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            <?php if(empty($paidfee)) { ?>
            <li>
            <?php
                if($hostel!='') {
                ?><input type="hidden" name="hostelamt" value="<?php echo $hostel;?>"/><input type="hidden" name="otherfee" value="1"/>
                <?php } ?>
                <?php
                if($transport!='') {
                ?><input type="hidden" name="transamt" value="<?php echo $transport;?>"/><input type="hidden" name="otherfee" value="1"/>
                <?php } ?>
            </li>
            <?php } else { echo '<input type="hidden" name="otherfee" value="0"/>';} ?>
            <?php } else { echo '<li>No installment plan</li>'; } ?>
            <li id="loadfeeamt"></li>
        </ul>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="row">
            <div class="col-12">
                <?php //print_r($batch_fee);?>
                <?php if(!empty($early_fee)) { ?>
                 <table class="table table_register_fee table-bordered table-striped table-sm">
                     <tr>
                        <th colspan="2" style="background-color:#20c997; color:#fff;">Advance Paid</th>
                     </tr>
                     <?php
                     foreach($early_fee as $val) {
                      ?>
                     <tr>
                        <td><?php echo $val->batch_name;?></td>
                         <td><?php echo 'Paid Fee: <label>'.numberformat($val->paid_amount).'</label>';?></td>
                     </tr>
                     <?php } ?>
                 </table>
                <?php } ?>
                <div class="tab-content">
                            <div id="brachdetails1" class="tab-pane active">
                                <?php
        $paidfee = $this->common->get_paidinstallment($batch_fee->student_id, $batch_fee->institute_course_mapping_id);
        if(!empty($paidfee)) {
        ?>
                                <div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <h6>Payment History</h6>
        <div class="table-responsive table_language">
                    <table class="table table_register_fee table-bordered table-striped table-sm">
                        <tbody>
                            <tr>
                                <th width="15%">Installment</th>
                                <th width="15%" class="text-center">Amount</th>
                                <th width="15%" class="text-center">Mode of Pay</th>
                                <th width="15%" class="text-center">Date of Pay</th>
                                <th width="40%">Details</th>
                            </tr>
                            <?php 
                        if(!empty($installment)) {
                            $i = 1;
                        foreach($installment as $install) {
                            if(!empty($paidfee)) {
                            $paidinstall =  $this->common->paidinstallment($i, $paidfee->payment_id); 
                            if(!empty($paidinstall)) {
                                $paidstatus = 1;
                        ?>
                            <tr>
                                <td><span class="payment_align_right"><?php echo $paidinstall->installment; if($paidinstall->installment_amount>0) { echo '<br/><span style="color:red;"> Discount applied</span>';}?></span></td>
                                <td><span class="payment_align_right" style="float:right"><?php echo numberformat($paidinstall->installment_paid_amount);?></span></td>
                                <td class="text-center"><span class="payment_align_right"><?php echo $paidinstall->paid_payment_mode;?></span></td>
                                <td class="text-center"><span class="payment_align_right"><?php echo date('d M Y', strtotime($paidinstall->createddate));?></span></td>
                                <td><span class="payment_align_right"><?php if($paidinstall->paid_payment_mode!='Cash') { echo $paidinstall->card_holder_name,',</br> '.$paidinstall->bank_name; if($paidinstall->paid_payment_mode=='Card') { echo '</br>Card type : '.$paidinstall->card_type;} else if($paidinstall->paid_payment_mode=='Cheque') { echo '</br>Cheque No : '.$paidinstall->cheque_no;} else {echo 'Transaction ID : '.$paidinstall->transaction_id; }} else { echo ' NIL';} ?></span></td>
                            </tr>
                            <?php } ?>
                            <?php } ?>
                            <?php $i++;?>
                            <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
    </div></div>
    <?php } ?>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="Shipto">
                                            <h6>Payment Details</h6>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="table-responsive table_language">
                                            <table class="table table-bordered table-striped table-sm">
                                                <tbody><tr>
                                                    <th>Sl no.</th>
                                                    <th>Title</th>
                                                    <th>Amount</th>

                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Tution Fee</td>
                                                    <td class="text-right"><?php echo numberformat($batch_fee->course_tuitionfee);?></td>
                                                </tr>
                                                <?php
                                                if($hostel!='') {
                                                $otherfees += $hostel;
                                                ?>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Hostel Fee</td>
                                                    <td class="text-right"><?php echo numberformat($hostel);?><input type="hidden" name="hostelamt" value="<?php echo $hostel;?>"/></td>
                                                </tr>
                                                <?php } ?>
                                                <?php
                                                if($transport!='') {
                                                $otherfees += $transport;
                                                ?>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Transport Fee</td>
                                                    <td class="text-right"><?php echo numberformat($transport);?><input type="hidden" name="transamt" value="<?php echo $transport;?>"/></td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td>2</td>
                                                    <td>CGST</td>
                                                    <td class="text-right"><?php echo numberformat($batch_fee->course_cgst);?></td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>SGST</td>
                                                    <td class="text-right"><?php echo numberformat($batch_fee->course_sgst);?></td>
                                                </tr>
                                                 <?php 
                                                    $discount = $this->common->get_student_discount_details($student_id,$course_id);
                                                    if(!empty($discount)) {
                                                        $slno = 4;
                                                    foreach($discount as $disnt) { 
                                                    ?>
                                                    <tr>
                                                    <td><?php echo $slno;?></td>
                                                    <td><?php echo $disnt->package_name;
                                                        if($disnt->package_type==2) { echo ' ['.$disnt->st_discount.'%] '; } 
                                                            echo ' - ';
                                                            if($disnt->discount_status==1) {
                                                                echo ' <b style="color:green;">Approved</b>';
                                                            } else if($disnt->discount_status==2) {
                                                                echo ' <b style="color:red;">Declined</b>';
                                                            }
                                                        ?>
                                                        </td>
                                                    <td class="text-right">
                                                        <?php if($disnt->discount_status==1) { 
                                                                echo '-'.numberformat($disnt->discount_amount);
                                                                $totaldiscount += $disnt->discount_amount;  
                                                            } 
                                                        ?>
                                                        </td>
                                                </tr>
                                                    <?php $slno++;?>
                                                            <?php } ?>
                                                            <?php } ?> 
                                                    
                                                    <tr class="totalFeeBg">
                                                        <td colspan="2" class="text-right" style="font-family:bold;">Total Fee</td>
                                                        <td class="text-right"><?php echo numberformat($batch_fee->course_totalfee);?></td>
                                                    </tr>
                                                    <?php if(!empty($discount)) { ?>
                                                    <tr class="totalFeeBg">
                                                        <td colspan="2" class="text-right" style="font-family:bold;">Total discount</td>
                                                        <td class="text-right"><?php echo numberformat($totaldiscount);?></td>
                                                    </tr>
                                                    <?php } ?>
                                                     <tr class="totalFeeBg">
                                                        <td colspan="2" class="text-right" style="font-family:bold;">Payable Fee</td>
                                                        <td class="text-right">
                                                         <?php 
                                                        $amtwithdiscnt = 0;
                                                        if($totaldiscount>0) {
                                                         echo numberformat($otherfees+$batch_fee->course_totalfee-$totaldiscount);
                                                            $amtwithdiscnt = $otherfees+$batch_fee->course_totalfee-$totaldiscount;
                                                            echo '<input type="hidden" value="'.$amtwithdiscnt.'" name="payableamount" />';
                                                        } else { 
                                                        echo numberformat($batch_fee->course_totalfee);
                                                            $payableamont = $otherfees+$batch_fee->course_totalfee;
                                                            echo '<input type="hidden" value="'.$payableamont.'" name="payableamount" />';
                                                        }
                                                        ?>
                                                         </td>
                                                    </tr>
                                                    <?php if(!empty($paidfee)) { ?>
                                                    <tr class="totalFeeBg">
                                                        <td colspan="2" class="text-right" style="font-family:bold;">Paid Fee</td>
                                                        <td class="text-right"><?php echo (!empty($paidfee) && $paidfee->paid_amount!='')?numberformat($paidfee->paid_amount):'';?></td>
                                                    </tr>
                                                    <?php if($paidfee->balance>0) { ?>
                                                     <tr class="totalFeeBg">
                                                        <td colspan="2" class="text-right" style="font-family:bold;">Balance</td>
                                                        <td class="text-right"><?php echo numberformat($paidfee->balance);?></td>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="brachdetails2" class="tab-pane fade">
                            2
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php
if($paidstatus != 1) {
?>
    <div><button type="button" class="btn btn-info btn_save paynow onlineallow" id="allowonlinepayment" alt="<?php echo $batch_fee->student_id;?>">Allow Online Payment</button></div>
    <?php } ?>
    <?php 
    } else {
       echo 'Discount approval is pending.';     
    }
    } else {
        echo 'Maximum student allotted in this batch.';
    }
    } else {
        echo 'Batch allocation pending.';
    }
} else {
    echo 'Please verify document before proceeding to payment';
}
 ?>

    <script>
        $(".modeofpay").change(function() {
            var mode = $(this).val();
            if (mode == "Card") {
                $(".cardclass").show();
                $(".chequeclass").hide();
            } else if (mode == "Cheque") {
                $(".cardclass").hide();
                $(".chequeclass").show();
            } else {
                $(".cardclass").hide();
                $(".chequeclass").hide();
            }
        });

        $(".modeofpaytwo").change(function() {
            var mode = $(this).val();
            if (mode == "Card") {
                $(".cardclasstwo").show();
                $(".chequeclasstwo").hide();
            } else if (mode == "Cheque") {
                $(".cardclasstwo").hide();
                $(".chequeclasstwo").show();
            } else {
                $(".cardclasstwo").hide();
                $(".chequeclasstwo").hide();
            }
        });

        // function'll allow user to pay online fee
        // @params student id
        // @author GBS-R

        $("#allowonlinepayment").click(function() {
            var student_id = $(this).attr('alt');
            $('#allowonlinepayment').attr("disabled", "disabled");
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Students/online_pay_approve',
                type: 'POST',
                data: {
                    student_id: student_id,
                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                },
                success: function(response) {
                    if (response) {
                        $.toaster({
                            priority: 'success',
                            title: 'message',
                            message: 'Online payment approved.'
                        });
                    } else {
                        $.toaster({
                            priority: 'danger',
                            title: 'Error',
                            message: 'Error while updating data!'
                        });
                    }
                }
            });
        });

    </script>
