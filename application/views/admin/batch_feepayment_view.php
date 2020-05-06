<?php   
$paidstatus = '';
if($verification==1) { //print_r($batch_fee);
if(!empty($batch_fee) && $batch_fee->batch_id!='') {
    $instituteCourseMappingId = $batch_fee->institute_course_mapping_id;
	$config['SGST'] = $batch_fee->sgst;
	$config['CGST']	= $batch_fee->cgst;
    if($seats=='available') {
        if($discnt!='Pending') {
        $early_fee          = $this->common->get_early_fee_bystudent($student_id, $batch_fee->batch_id);
?>
<div class="row">
    <?php 
     $totaldiscount = 0;
     $otherfees = 0;
     $splitpaid = $this->common->get_paidstatus($batch_fee->student_id, $batch_fee->institute_course_mapping_id);  $splittype = '';
     if(!empty($splitpaid) && $splitpaid[0]->payment_type=='split') { $splittype = 'split'; }
    if($batch_fee->course_paymentmethod == 'onetime' || $splittype == 'split') {
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
                        <th>Amount [INR]</th>
                    </tr>
                    <?php //echo '<pre>'; 
					$slno = 1; 
					$nontaxableFees 		= 0;
					$taxableFees	= 0;
					if(!empty($feeheads)) {
						foreach($feeheads as $fees) { 
						$taxableFees += $fees->fee_amount;
//						if($fees->ph_taxable==1) {
//						$taxableFees += $fees->fee_amount;	
//						} else {	
//						$nontaxableFees += $fees->fee_amount;
//						}
					?>
                    <tr>
                        <td><?php echo $slno;?></td>
                        <td><?php echo $fees->ph_head_name; //if($fees->ph_taxable==1) { echo ' *'; }?></td>
                        <td class="text-right"><?php echo numberformatwithout($fees->fee_amount);?></td>
                    </tr>
                    <?php
                    $slno++;
						}
					}
                    if($hostel!='') {
                        //$otherfees += $hostel;
                        ?>
                     <!-- <tr>
                        <td><?php echo $slno++;?></td>
                        <td>Hostel Fee</td>
                        <td class="text-right"><?php echo numberformatwithout($hostel);?><input type="hidden" name="hostelamt" value="<?php echo $hostel;?>"/></td>
                    </tr> -->
                    <?php } ?>
                    <?php if($transport!='') {
                        //$otherfees += $transport;
                        ?>
                     <!-- <tr>
                        <td><?php echo $slno++;?></td>
                        <td>Transport Fee</td>
                        <td class="text-right"><?php echo numberformatwithout($transport);?><input type="hidden" name="transamt" value="<?php echo $transport;?>"/></td>
                    </tr> -->
                    <?php } 
						$totaltaxable = $otherfees + $taxableFees; 
						$taxableAmt = taxcalculation($totaltaxable, $config, $nontaxableFees);  
                        ?>
                    <?php if(empty($feepaid)) { ?> 
                         
                    <tr>
                        <td><?php echo $slno++;?></td>
                        <td>CGST</td>
                        <td class="text-right"><?php 
							if(!empty($taxableAmt)) {
								echo numberformatwithout($taxableAmt['cgst']);
							}?></td>
                    </tr> 
                    <tr>
                        <td><?php echo $slno++;?></td>
                        <td>SGST</td>
                        <td class="text-right"><?php if(!empty($taxableAmt)) {
								echo numberformatwithout($taxableAmt['sgst']);
							}?></td>
                    </tr> 
                    <?php 
                    if(!empty($config) && $config['cess']==1) {
                        ?>
                    <tr>
                        <td><?php echo $slno++;?></td>
                        <td>Cess [<?php echo $config['cess_value'];?>%]</td>
                        <td class="text-right"><?php if(!empty($taxableAmt)) {
								echo numberformatwithout($taxableAmt['cess']);
							}?></td>
                    </tr>
                        <?php } ?>

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
                                echo '-'.numberformatwithout($disnt->discount_amount);
                                 }
                            ?>
                        </td>
                    </tr>
                        <?php $slno++; ?>
                            <?php } ?>
                        
                                <input type="hidden" name="discount_amt" value="<?php echo $totaldiscount;?>" />
                         <tr class="totalFeeBg">
                            <td colspan="2" class="text-right" style="font-family:bold;">Total Discount</td>
                            <td class="text-right"><?php echo numberformatwithout($totaldiscount);?></td>
                        </tr>
                            <?php } ?>
                       <tr class="totalFeeBg">
                                <td colspan="2" class="text-right" style="font-family:bold;">Total Fee</td>
                                <td class="text-right"><?php 
									if(!empty($taxableAmt)) {
										echo numberformatwithout($taxableAmt['totalAmt']);
									}
									?></td>
                            </tr>
                            <tr class="totalFeeBg">
                                <td colspan="2" class="text-right" style="font-family:bold;">Payable Fee</td>
                                <td class="text-right"><?php 
                            if($totaldiscount>0) {
								if(!empty($taxableAmt)) {
										echo numberformatwithout($taxableAmt['totalAmt']-$totaldiscount); 
									}
                             
                            } else {
                            echo numberformatwithout($taxableAmt['totalAmt']);
                            }
                            ?></td>
                            </tr>

                        <?php } else { ?>
                            <tr>
                        <td><?php echo $slno++;?></td>
                        <td>CGST</td>
                        <td class="text-right"><?php 
							if(!empty($batch_fee)) {
								echo numberformatwithout($batch_fee->course_cgst);
							}?></td>
                    </tr> 
                    <tr>
                        <td><?php echo $slno++;?></td>
                        <td>SGST</td>
                        <td class="text-right"><?php if(!empty($batch_fee)) {
								echo numberformatwithout($batch_fee->course_sgst);
							}?></td>
                    </tr> 
                    <?php 
                    if(!empty($batch_fee) && $batch_fee->cess>0) {
                        ?>
                    <tr>
                        <td><?php echo $slno++;?></td>
                        <td>Cess [<?php echo $batch_fee->cess;?>%]</td>
                        <td class="text-right"><?php
								echo numberformatwithout($batch_fee->course_cess);
							?></td>
                    </tr>
                        <?php } ?>   
                        <?php 
                            $paidamt = 0;
                            $balance = 0;
                            $payment_id = '';
                            $total_amount_show = 0;
                            $discount_applied = 0;
                            foreach($feepaid as $paid) {
                            $payment_id = $paid->payment_id;    
                            $payable_amount = $paid->payable_amount;
                            $balance    =    $paid->balance;
                            $paidamt += $paid->paid_amount;
                            $discount_applied    =    $paid->discount_applied;
                            $total_amount_show    =    $paid->total_amount;
                            }
                        ?>
                        <tr class="totalFeeBg">
                                <td colspan="2" class="text-right" style="font-family:bold;">Total</td>
                                <td class="text-right"><?php echo numberformatwithout($total_amount_show);?></td>
                            </tr>
                        <?php if($discount_applied!=0) { ?>
                        <tr class="totalFeeBg">
                                <td colspan="2" class="text-right" style="font-family:bold;">Discount</td>
                                <td class="text-right"><?php echo numberformatwithout($discount_applied);?></td>
                            </tr>
                        <?php } ?>
                        <tr class="totalFeeBg">
                                <td colspan="2" class="text-right" style="font-family:bold;">Payable Amount</td>
                                <td class="text-right"><?php echo numberformatwithout($payable_amount);?></td>
                            </tr>
                        <tr class="totalFeeBg">
                                <td colspan="2" class="text-right" style="font-family:bold;">Total Amount Paid</td>
                                <td class="text-right"><?php echo numberformatwithout($paidamt);?></td>
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
                <table class="table table_register table_register_fee table-bordered table-striped receiptbutton">
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
                            if($splittype!='split') {
                        ?>
                        <tr>
                            <td>Paid date</td>
                            <td><label><?php echo date('d-m-Y', strtotime($paid->createddate));?></label></td>
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
                            <td>Card Details</td>
                            <td><label><?php echo $paid->card_type.', <br>'.$paid->card_holder_name.', <br>'.$paid->bank_name;?></label></td>
                        </tr>
                        <?php } else if($paid->paymentmode=='Cheque') { ?>
                        <tr>
                            <td>Card Details</td>
                            <td><label><?php echo 'Cheque No. '.$paid->cheque_no.', <br>'.$paid->card_holder_name.', <br>'.$paid->bank_name;?></label></td>
                        </tr>
                        <?php } else if($paid->paymentmode=='Online') { ?>
                        <tr>
                            <td>Transaction Details</td>
                            <td><label><?php echo $paid->card_type.', Transaction ID. '.$paid->transaction_id;?></label></td>
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
                            <!-- <tr>
                                <td>Receipt</td>
                                <td><label><a id="download_receipt" onclick="download_receipt('<?php echo $student_id;?>','<?php echo $paid->institute_course_mapping_id;?>','0','<?php echo $paid->payment_id;?>')"><img src="<?php echo base_url();?>direction_v2/images/receipt.png"/></a></label></td>
                            </tr> -->
                            <?php } 
                            $splitsec = 0;
                            $splitArr = $this->common->get_from_tableresult('pp_student_payment_split', array('payment_id'=>$feepaid[0]->payment_id));
                            if(!empty($splitArr)) {
                                $splitsec = 1;
                                ?>
                             <tr>
                                <td colspan="2">
                                <table class="table table-bordered table-striped table-sm">
                                <tbody>
                                    <th>Date</th>
                                    <th>Amount[INR]</th>
                                    <th>Mode</th>
                                    <th>Details</th>
                                    <th>Receipt</th>
                                </tbody>
                            <?php
                            $splitArrins = $this->common->get_from_tableresult('pp_student_payment_installment', array('payment_id'=>$feepaid[0]->payment_id));
                            if(!empty($splitArrins)) {
                                foreach($splitArrins as $splitArrin) { 
                                $detailstr = '';
                                if($splitArrin->paid_payment_mode=='Online') {
                                    $detailstr .= $splitArrin->card_type;
                                    if($splitArrin->bank_name!='') {
                                    $detailstr .= '<br>'.$splitArrin->bank_name; 
                                    }
                                    $detailstr .= '<br>Txn ID: '.$splitArrin->transaction_id; 
                                }
                                if($splitArrin->paid_payment_mode=='Cheque') {
                                    $detailstr .= $splitArrin->card_holder_name;
                                    if($splitArrin->bank_name!='') {
                                    $detailstr .= '<br>'.$splitArrin->bank_name; 
                                    }
                                    $detailstr .= '<br>Chq.no: '.$splitArrin->cheque_no; 
                                }
                                if($splitArrin->paid_payment_mode=='Card') {
                                    $detailstr .= $splitArrin->card_holder_name;
                                    if($splitArrin->bank_name!='') {
                                    $detailstr .= '<br>'.$splitArrin->bank_name; 
                                    }
                                    $detailstr .= '<br>'.$splitArrin->card_type; 
                                }
                            ?>
                            <tr>
                                <td><?php echo date('d-m-Y', strtotime($splitArrin->createddate));?></td>
                                <td class="text-right"><?php echo number_format($splitArrin->installment_paid_amount,2);?></td>
                                <td><?php echo $splitArrin->paid_payment_mode;?></td>
                                <td><?php echo $detailstr;?></td>
                                <td>
                                <label><a id="download_receipt" onclick="download_receipt('<?php echo $student_id;?>','<?php echo $paid->institute_course_mapping_id;?>','<?php echo $splitArrin->paid_install_id;?>')"><img src="<?php echo base_url();?>direction_v2/images/receipt.png"/></a></label>
                                </td>
                            </tr>
                            <?php } ?>
                                <?php } ?>
                            <?php   
                                foreach($splitArr as $split) { 
                                    $detailstr = '';
                                   if($split->paid_payment_mode == 'Online') {
                                    $detailstr .= $split->card_type;
                                    if($split->bank_name!='') {
                                    $detailstr .= '<br>'.$split->bank_name; 
                                    }
                                    $detailstr .= '<br>Txn ID: '.$split->transaction_id; 
                                }
                                if($split->paid_payment_mode=='Cheque') {
                                    $detailstr .= $split->card_holder_name;
                                    if($split->bank_name!='') {
                                    $detailstr .= '<br>'.$split->bank_name; 
                                    }
                                    $detailstr .= '<br>Chq.no: '.$split->cheque_no; 
                                }
                                if($split->paid_payment_mode=='Card') {
                                    $detailstr .= $split->card_holder_name;
                                    if($split->bank_name!='') {
                                    $detailstr .= '<br>'.$split->bank_name; 
                                    }
                                    $detailstr .= '<br>'.$split->card_type; 
                                }
                            ?>
                            <tr>
                                <td><?php echo date('d-m-Y', strtotime($split->createddate));?></td>
                                <td class="text-right"><?php echo number_format($split->split_amount,2);?></td>
                                <td><?php echo $split->paid_payment_mode;?></td>
                                <td><?php echo $detailstr;?></td>
                                <td>
                                <label><a id="download_receipt" onclick="download_splitreceipt('<?php echo $student_id;?>','<?php echo $paid->institute_course_mapping_id;?>','0','<?php echo $paid->payment_id;?>', '<?php echo $split->paid_split_id;?>' )"><img src="<?php echo base_url();?>direction_v2/images/receipt.png"/></a></label>
                                <!-- <label><?php //print_r($split);?><a id="download_receipt" onclick="download_receipt('<?php echo $student_id;?>','<?php echo $paid->institute_course_mapping_id;?>','0','<?php echo $paid->payment_id;?>')"><img src="<?php echo base_url();?>direction_v2/images/receipt.png"/></a></label> -->
                                </td>
                            </tr>
                            <?php 
                                }
                                ?>
                                </table>
                            </td>
                             </tr>   
                            <?php }
                            ?>
                            <tr>
                                <td style="color:green;">Total amount paid</td>
                                <td><label style="color:green;"><?php echo numberformatwithout($paidamt);?></label></td>
                            </tr>
                            <?php if(!empty($feepaid) && $splitsec ==0) { ?>
                            <tr>
                                <td style="color:green;">Receipt</td>
                                <td><label><a id="download_receipt" onclick="download_receipt('<?php echo $student_id;?>','<?php echo $paid->institute_course_mapping_id;?>','0','<?php echo $paid->payment_id;?>')"><img src="<?php echo base_url();?>direction_v2/images/receipt.png"/></a></label></td>
                            </tr>
                            <?php } ?>
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
                            <option value="Online">Online</option>
                          </select>

                    </div>
                </div>
                <div class="col-12 onlineclass" style="display:none;">
                    <div class="form-group">
                        <label>Transaction Type <span class="req redbold">*</span></label>
                        <select class="form-control" name="cardtype" id="transactiontypeidone" disabled>
                            <option value="">Select</option>
                            <?php
                            $transTypearr = $this->common->get_basic_entity('Online Transaction');
                            foreach($transTypearr as $row){?>
                                <option value="<?php echo $row->entity_name?>"><?php echo $row->entity_name?></option>
                            <?php } ?>
                          </select>
                    </div>
                </div>

                <div class="col-12 onlineclass" style="display:none;">
                    <div class="form-group">
                        <label>Transaction Id <span class="req redbold">*</span></label>
                        <input type="text" class="form-control" value="" name="transactionid" onkeypress="return blockSpecialChar(event);"/>
                    </div>
                </div>

                <div class="col-12 cardclass" style="display:none;">
                    <div class="form-group">
                        <label>Card Type</label>
                        <select class="form-control" name="cardtype" id="cardclassidone" disabled>
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
                        <input class="form-control" value="<?php echo $balance;?>" id="payablebalance" name="payablebalance" readonly="readonly" />
                        <input class="form-control" type="hidden" value="<?php echo $batch_fee->course_totalfee;?>" name="payableamount" readonly="readonly" />
                        <?php
                        if($payment_id!='') {
                            echo '<input type="hidden" value="'.$paidamt.'" name="amtpaid"/>';
                            echo '<input type="hidden" value="'.$payment_id.'" name="payment_id"/>';
                        }   
                        ?>
                    </div>
                </div>
                <div class="col-12 ">
                    <div class="form-group"><input type="hidden" class="form-check-input splictclass" name="splitvalue" value="split">
                        <label>Split Amount<span class="req redbold">*</span></label>
                        <input type="text" class="form-control splictamtchk" status="<?php echo $balance;?>" name="splitamount" id="splitpay" onkeypress="return isNumberKey(this, event);">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-info btn_save paynow" id="paynowbutton">Paynow</button>

                    </div>
                </div>
                <?php } ?>
                <?php } else { ?>
<!--
				<div class="col-12">
					
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="payment_type" id="paytype2" value="onetime" checked="checked">
					  <label class="form-check-label" for="inlineRadio2">Onetime</label>
					</div>
                    <div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="payment_type" id="paytype1" value="installment" data-toggle="modal" data-target="#edit_fee_head">
					  <label class="form-check-label" for="inlineRadio1" >Installment</label>
					</div>
                </div>
-->
                <div class="col-12">
                    <div class="form-group">
                        <label>Payment Mode</label>
                        <select class="form-control modeofpaytwo" name="modeofpay">
                            <option value="Cash">Cash</option>
                            <option value="Card">Card</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Online">Online</option>
                          </select>

                    </div>
                </div>

                <div class="col-12 onlineclasstwo" style="display:none;">
                    <div class="form-group">
                        <label>Transaction Type <span class="req redbold">*</span></label>
                        <select class="form-control" name="cardtype" id="transactiontypeid" disabled>
                            <option value="">Select</option>
                            <?php
                            $transTypearr = $this->common->get_basic_entity('Online Transaction');
                            foreach($transTypearr as $row){?>
                                <option value="<?php echo $row->entity_name?>"><?php echo $row->entity_name?></option>
                            <?php } ?>
                          </select>
                    </div>
                </div>

                <div class="col-12 onlineclasstwo" style="display:none;">
                    <div class="form-group">
                        <label>Transaction Id <span class="req redbold">*</span></label>
                        <input type="text" class="form-control" value="" name="transactionid" onkeypress="return blockSpecialChar(event);"/>
                    </div>
                </div>

                <div class="col-12 cardclasstwo" style="display:none;">
                    <div class="form-group">
                        <label>Card Type</label>
                        <select class="form-control" name="cardtype" id="cardclassid" disabled>
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
                        <input class="form-control" type="hidden" value="<?php echo $taxableAmt['totalFee'];?>" name="fee_amount_without_gst" />
                        <input class="form-control" type="hidden" value="<?php echo $taxableAmt['totalAmt'];?>" name="fee_paid_amount" />
                        <input class="form-control" value="<?php if($totaldiscount>0) {
                             echo number_format($taxableAmt['totalAmt']-$totaldiscount, 2, '.', '');
                            } else {
                            echo number_format($taxableAmt['totalAmt'], 2, '.', '');
                            }?>" name="payableamount" readonly="readonly" />


                    </div>
                </div>
                <div class="col-12">


                    <div class="form-check-inline mt-3">
                    <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input splictclass" name="splitvalue" checked="checked" value="onetime">Pay Total Amount
                            </label>
                        </div>
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input splictclass" name="splitvalue" value="split">Pay Split Amount 
                        </label>
                        </div>
                        
                        <div class="form-group" id="splittxtdiv" style="display:none;">
                            <label for="usr">Split Amount :</label>
                            <input type="text" class="form-control splictamtchk" status="<?php if($totaldiscount>0) {
                             echo number_format($taxableAmt['totalAmt']-$totaldiscount, 2, '.', '');
                            } else {
                            echo number_format($taxableAmt['totalAmt'], 2, '.', '');
                            }?>" name="splitamount" id="splitpay" onkeypress="return isNumberKey(this, event);">
                        </div> 

                    <div class="form-group">
                        <button class="btn btn-info btn_save paynow" id="paynowbutton">Paynow</button>

                    </div>
                </div>
                <div class="col-12">

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
		<h6>Payment Details</h6>
		<div class="table-responsive table_language">
                    <table class="table table_register_fee table-bordered table-striped table-sm">
                    <tbody><tr>
                        <th>Sl no.</th>
                        <th>Title</th>
                        <th class="text-right">Amount [INR]</th>
                    </tr>
                    <?php 
					$slno = 1; 
					$nontaxableFees 		= 0;
					$taxableFees	= 0;
					if(!empty($feeheads)) {
						foreach($feeheads as $fees) { //print_r($fees);
						$taxableFees += $fees->fee_amount;		
//						if($fees->ph_taxable==1) {
//						$taxableFees += $fees->fee_amount;	
//						} else {	
//						$nontaxableFees += $fees->fee_amount;
//						}
					?>
                    <tr>
                        <td><?php echo $slno;?></td>
                        <td><?php echo $fees->ph_head_name; //if($fees->ph_taxable==1) { echo ' *'; }
							?></td>
                        <td class="text-right"><?php echo numberformatwithout($fees->fee_amount);?></td>
                    </tr>
                    <?php
                    $slno++;
						}
					}
		?>
			</tbody>
		</table>
		</div>
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
            <li><label class="custom_checkbox <?php if(!empty($paidinstall) && $paidinstall->installment_paid_amount>0){ echo 'instComplete'; } ?>" style="color: #787878 !important;">Installment <?php echo $x;?>  Amount : <?php echo numberformat($install->installment_amount);?>
                        <input type="checkbox" id="installmentdis<?php echo $install->installment_id; ?>" name="installment[]" value="<?php echo $x;?>" class="hostel installmentchk" <?php echo (!empty($paidinstall) && $paidinstall->installment_paid_amount>0)?'checked="checked" disabled="disabled"':'';?> >  
                        <?php
                        if(empty($paidinstall)) {
                        ?>
                        <input type="hidden" name="installment_id[]" value="<?php echo $install->installment_id;?>">
                        <input type="hidden" name="installment_amt[]" value="<?php echo $install->installment_amount;?>">
                        <?php } ?>
                              <span class="checkmark" <?php if($x==1) { ?> id="firstinstallslct" <?php } ?> onclick="feepayinstallment('<?php echo $install->installment_amount; ?>','<?php echo $install->installment_id; ?>');"></span>
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
                ?>
                <!-- <input type="hidden" name="hostelamt" value="<?php echo $hostel;?>"/><input type="hidden" name="otherfee" value="1"/> -->
                <?php } ?>
                <?php
                if($transport!='') {
                ?>
                <!-- <input type="hidden" name="transamt" value="<?php echo $transport;?>"/><input type="hidden" name="otherfee" value="1"/> -->
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
                                <th width="15%" class="text-center">Installment Amount[INR]</th>
								<th width="15%" class="text-center">Amount Paid[INR]</th>
<!--								<th width="15%" class="text-center">Balance</th>-->
                                <th width="15%" class="text-center">Mode of Pay</th>
                                <th width="20%" class="text-center">Date of Pay</th>
                                <th width="30%">Card Details</th>
                                <th width="5%">Action</th>
                            </tr>
                            <?php 
                        if(!empty($installment)) {
                            $i = 1;
                        foreach($installment as $install) { 
                            if(!empty($paidfee)) {
                            $paidinstall =  $this->common->paidinstallment($i, $paidfee->payment_id); 
                            if(!empty($paidinstall)) { 
                                $paidstatus = 1; ?>
                            <tr>
                                <td><span class="payment_align_right"><?php echo $paidinstall->installment; //if($paidinstall->installment_amount>0) { echo '<br/><span style="color:red;"> Discount applied</span>';}?></span></td>
                                <td><span class="payment_align_right" style="float:right"><?php echo numberformatwithout($paidinstall->installment_amount);?></span></td>
								<td><span class="payment_align_right" style="float:right"><?php echo numberformatwithout($paidinstall->installment_paid_amount);?></span></td>
<!--								<td class="text-center"><span class="payment_align_right"><?php echo $paidinstall->installment_amount_balance;?></span></td>-->
                                <td class="text-center"><span class="payment_align_right"><?php echo $paidinstall->paid_payment_mode;?></span></td>
                                <td class="text-center"><span class="payment_align_right"><?php echo date('d M Y', strtotime($paidinstall->createddate));?></span></td>
                                <td><span class="payment_align_right"><?php if($paidinstall->paid_payment_mode!='Cash') { if($paidinstall->paid_payment_mode=='Online') { echo $paidinstall->card_type;} else {echo $paidinstall->card_holder_name; } echo ',</br> '.$paidinstall->bank_name; if($paidinstall->paid_payment_mode=='Card') { echo '</br>Card type : '.$paidinstall->card_type;} else if($paidinstall->paid_payment_mode=='Cheque') { echo '</br>Cheque No : '.$paidinstall->cheque_no;} else if($paidinstall->paid_payment_mode=='Online') {echo ' Transaction ID : '.$paidinstall->transaction_id; }} else { echo ' NIL';} ?></span></td>
                                <td class="text-center"><a id="download_receipt" onclick="download_receipt('<?php echo $student_id;?>','<?php echo $install->institute_course_mapping_id;?>','<?php echo $paidinstall->paid_install_id;?>')"><img src="<?php echo base_url();?>direction_v2/images/receipt.png"/></a></td>
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
                                    <div class="col-sm-12 receiptbutton" id="receiptbutton">
                                        <div class="table-responsive table_language">
                                            <table class="table table-bordered table-striped table-sm">
                                                <tbody><tr>
                                                    <th>Sl no.</th>
                                                    <th >Title</th>
                                                    <th class="text-right">Amount [INR]</th>

                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Fee</td>
                                                    <td class="text-right"><?php echo numberformatwithout($batch_fee->course_tuitionfee);?></td>
                                                </tr>
                                                <?php
												$e =2;
                                                if($hostel!='') {
                                                //$otherfees += $hostel;
                                                ?>
                                                <!-- <tr>
                                                    <td><?php echo $e++;?></td>
                                                    <td>Hostel Fee</td>
                                                    <td class="text-right"><?php echo numberformatwithout($hostel);?><input type="hidden" name="hostelamt" value="<?php echo $hostel;?>"/></td>
                                                </tr> -->
                                                <?php } ?>
                                                <?php
                                                if($transport!='') {
                                               // $otherfees += $transport;
                                                ?>
                                                <!-- <tr>
                                                    <td><?php echo $e++;?></td>
                                                    <td>Transport Fee</td>
                                                    <td class="text-right"><?php echo numberformatwithout($transport);?><input type="hidden" name="transamt" value="<?php echo $transport;?>"/></td>
                                                </tr> -->
                                                <?php } ?>
                                                <tr>
                                                    <td><?php echo $e++;?></td>
                                                    <td>CGST</td>
                                                    <td class="text-right"><?php echo numberformatwithout($batch_fee->course_cgst);?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $e++;?></td>
                                                    <td>SGST</td>
                                                    <td class="text-right"><?php echo numberformatwithout($batch_fee->course_sgst);?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $e++;?></td>
                                                    <td>Cess [<?php echo $batch_fee->cess;?>%]</td>
                                                    <td class="text-right"><?php echo numberformatwithout($batch_fee->course_cess);?></td>
                                                </tr>
                                                 <?php 
                                                    $discount = $this->common->get_student_discount_details($student_id,$course_id);
                                                    if(!empty($discount)) {
                                                        $slno = $e;
                                                    foreach($discount as $disnt) { 
                                                    ?>
                                                    <tr>
                                                    <td><?php echo $e++;?></td>
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
                                                                echo '-'.numberformatwithout($disnt->discount_amount);
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
                                                        <td class="text-right"><?php echo numberformatwithout($otherfees+$batch_fee->course_totalfee);?></td>
                                                    </tr>
                                                    <?php if(!empty($discount)) { ?>
                                                    <tr class="totalFeeBg">
                                                        <td colspan="2" class="text-right" style="font-family:bold;">Total discount</td>
                                                        <td class="text-right"><?php echo numberformatwithout($totaldiscount);?></td>
                                                    </tr>
                                                    <?php } ?>
                                                     <tr class="totalFeeBg">
                                                        <td colspan="2" class="text-right" style="font-family:bold;">Payable Fee</td>
                                                        <td class="text-right">
                                                         <?php 
                                                        $amtwithdiscnt = 0;
                                                        if($totaldiscount>0) { 
                                                         echo numberformatwithout($otherfees+$batch_fee->course_totalfee-$totaldiscount);
                                                            $amtwithdiscnt = $otherfees+$batch_fee->course_totalfee-$totaldiscount;
                                                            echo '<input type="hidden" value="'.$amtwithdiscnt.'" name="payableamount" />';
                                                        } else { 
                                                        echo numberformatwithout($otherfees+$batch_fee->course_totalfee);
                                                            $payableamont = $otherfees+$batch_fee->course_totalfee;
                                                            echo '<input type="hidden" value="'.$payableamont.'" name="payableamount" />';
                                                        }
                                                        ?>
                                                         </td>
                                                    </tr>
                                                    <?php if(!empty($paidfee)) { ?>
                                                    <tr class="totalFeeBg">
                                                        <td colspan="2" class="text-right" style="font-family:bold;">Paid Fee</td>
                                                        <td class="text-right"><?php echo (!empty($paidfee) && $paidfee->paid_amount!='')?numberformatwithout($paidfee->paid_amount):'';?></td>
                                                    </tr>
                                                    <?php if($paidfee->balance>0) { ?>
                                                     <tr class="totalFeeBg">
                                                        <td colspan="2" class="text-right" style="font-family:bold;">Balance</td>
                                                        <td class="text-right"><?php echo numberformatwithout($paidfee->balance);?></td>
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
<!--                            2-->
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<div id="edit_fee_head" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Installment Setup</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form enctype="multipart/form-data" id="installmentsetup" method="post">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="ph_id" id="ph_id" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label><?php echo $this->lang->line('number_of_instalment');?> <span class="req redbold">*</span></label>
                                <select class="form-control"  data-validate="required" name="number_of_instalment" id="number_of_instalment">
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
                            </div>
                        </div>
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Installment 1<span class="req redbold">*</span></label>
                                <input type="text" name="installment[]" class="form-control"  data-validate="required" name="number_of_instalment" id="number_of_instalment" />
                            </div>
                        </div>
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Installment 2<span class="req redbold">*</span></label>
                                <input type="text" name="installment[]" value="" class="form-control"  data-validate="required" name="number_of_instalment" id="number_of_instalment" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php if($paidstatus != 1) { 
    $orderArr = $this->common->get_from_tablerow('pp_onlinepayment_approval', array('student_id'=>$batch_fee->student_id,'institute_course_mapping_id'=>$instituteCourseMappingId));
   if(!empty($orderArr)) {
        $alertmsg = 'Online payment mail has been send already. Do you want to send again?';
   } else {
        $alertmsg = 'Do you want to allow online payment for this student?';
   }
   ?>
    <div><button type="button" class="btn btn-info btn_save paynow onlineallow" id="allowonlinepayment" status="<?php echo $alertmsg;?>" alt="<?php echo $batch_fee->student_id;?>">Allow Online Payment</button>
    <input type="hidden" value="<?php echo $instituteCourseMappingId; ?>" name="instituteCourseMappingIdpayment" id="instituteCourseMappingIdpayment" />
</div>
<?php }  
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
                $(".onlineclass").hide();
                $("#cardclassidone").prop("disabled", false);
                $("#transactiontypeidone").prop("disabled", true);
            } else if (mode == "Cheque") {
                $(".cardclass").hide();
                $(".chequeclass").show();
                $(".onlineclass").hide();
                $("#cardclassidone").prop("disabled", true);
                $("#transactiontypeidone").prop("disabled", true);
            } else if(mode=="Online") {
                $(".cardclass").hide();
                $(".chequeclass").hide();
                $(".onlineclass").show();
                $("#cardclassid").prop("disabled", true);
                $("#transactiontypeidone").prop("disabled", false);
            } else {
                $(".cardclass").hide();
                $(".chequeclass").hide();
                $(".onlineclass").hide();
                $("#cardclassidone").prop("disabled", true);
                $("#transactiontypeidone").prop("disabled", true);
            }
        });

        $(".modeofpaytwo").change(function() {
            var mode = $(this).val();
            if (mode == "Card") {
                $(".cardclasstwo").show();
                $(".chequeclasstwo").hide();
                $(".onlineclasstwo").hide();
                $("#cardclassid").prop("disabled", false);
                $("#transactiontypeid").prop("disabled", true);
            } else if (mode == "Cheque") {
                $(".cardclasstwo").hide();
                $(".chequeclasstwo").show();
                $(".onlineclasstwo").hide();
                $("#cardclassid").prop("disabled", true);
                $("#transactiontypeid").prop("disabled", true);
            } else if(mode=="Online") {
                $(".cardclasstwo").hide();
                $(".chequeclasstwo").hide();
                $(".onlineclasstwo").show();
                $("#cardclassid").prop("disabled", true);
                $("#transactiontypeid").prop("disabled", false);
            }else {
                $(".cardclasstwo").hide();
                $(".chequeclasstwo").hide();
                $(".onlineclasstwo").hide();
                $("#cardclassid").prop("disabled", true);
                $("#transactiontypeid").prop("disabled", true);
            }
        });

        $(".splictclass").click(function() {
            val = $(this).val();
            if(val=='split') {
                $('#splittxtdiv').show();
            } else {
                $('#splittxtdiv').hide();
            }
        }); 
        
        $('.numbersOnly').keyup(function () {
        if (this.value != this.value.replace(/[^0-9]/g, '')) {
            this.value = this.value.replace(/[^0-9]/g, '');
        }
        var amt = $(this).val();
        var value = $(this).attr('status'); 
        if(parseInt(amt) > parseInt(value)) {
            $(this).val(value);
        }
    });

    $('.splictamtchk').keyup(function () {
       var amt = $(this).val();
        var value = $(this).attr('status'); 
        if(parseInt(amt) > parseInt(value)) {
            $(this).val(value);
        }
    });
        // function'll allow user to pay online fee
        // @params student id
        // @author GBS-R

    $("#allowonlinepayment").click(function() {
        var msgtxt = $('#allowonlinepayment').attr('status');
        $.confirm({
            title: 'Alert message',
            content: msgtxt,
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {                   
                        var student_id = $('#allowonlinepayment').attr('alt');
                            var instituteCourseMappingIdpayment = $('#instituteCourseMappingIdpayment').val();
                            $('#allowonlinepayment').attr("disabled", "disabled");
                        $.ajax({
                            url: '<?php echo base_url();?>backoffice/Students/online_pay_approve',
                            type: 'POST',
                            data: {
                                student_id: student_id,
                                instituteCourseMappingIdpayment: instituteCourseMappingIdpayment,
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            },
                            success: function(response) {
                                if (response == 1) {
                                    $.toaster({
                                        priority: 'success',
                                        title: 'message',
                                        message: 'Online payment approved. Please inform to check registered mail for payment link..!'
                                    });
                                } else if ( response == 2){
                                    $.toaster({
                                        priority: 'danger',
                                        title: 'Error',
                                        message: ' Link already sended to the registered mail. Please inform to check..!'
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
                        
                    }
                },
                cancel: function() {
                    //$.alert(' <strong>cancelled</strong>');
                },
            }
        });
        
    });


function isNumberKey(txt, evt) {
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode == 46) {
        //Check if the text already contains the . character
        if (txt.value.indexOf('.') === -1) {
          return true;
        } else {
          return false;
        }
      } else {
        if (charCode > 31 &&
          (charCode < 48 || charCode > 57))
          return false;
      }
      return true;
}
    </script>
