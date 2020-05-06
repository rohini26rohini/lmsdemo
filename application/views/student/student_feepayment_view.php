<?php   
$paidstatus = '';
    $instituteCourseMappingId = $batch_fee->institute_course_mapping_id;
	$config['SGST'] = $batch_fee->sgst;
	$config['CGST']	= $batch_fee->cgst;
    $early_fee          = $this->common->get_early_fee_bystudent($student_id, $batch_fee->batch_id);
?>
<div class="row">
    <div class="col-md-12">
        <div class="payment-wapper">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#feepaymenttab">Fee payment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#paymenttab">Payment History</a>
                </li>
            </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div id="feepaymenttab" class=" tab-pane active"><br>
                <h3>Fee payment</h3>
                <input type="hidden" value="dashboard" name="payfrom" />
                <input type="hidden" value="<?php echo $batch_fee->course_paymentmethod;?>" name="paymentmethod" />
                <p>
                <?php 
     $totaldiscount = 0;
     $otherfees = 0;
     $splitpaid = $this->common->get_paidstatus($batch_fee->student_id, $batch_fee->institute_course_mapping_id);  $splittype = '';
     if(!empty($splitpaid) && $splitpaid[0]->payment_type=='split') { $splittype = 'split'; }
    if($batch_fee->course_paymentmethod == 'onetime' || $splittype == 'split') {
        $feepaid = $this->common->get_paidstatus($batch_fee->student_id, $batch_fee->institute_course_mapping_id);
     ?>
     <input type="hidden" value="<?php echo $batch_fee->student_id;?>" name="student_id" />
    <input type="hidden" value="<?php echo $batch_fee->student_id;?>" name="student_id" />
    <input type="hidden" value="<?php echo $batch_fee->batch_id;?>" name="batch_id" />
    <input type="hidden" value="<?php echo $batch_fee->institute_course_mapping_id;?>" name="institute_course_mapping_id" />
    <input type="hidden" value="<?php echo $batch_fee->course_paymentmethod;?>" name="payment_type" />
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="row">
            <div class="col-12">                
                <div class="table-responsive table_language">
                <h6>Payment Details</h6>    
                <table class="table table-bordered table-striped table-sm table-bordered ExaminationList">
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
            if(empty($feepaid)) { 
            ?>         
            


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

                    <div class="form-group">
                        <button class="btn btn-info btn_save " type="submit">Paynow</button>

                    </div>
                </div> 
                        <?php } else {
                            $balanceat = $feepaid[0]->balance;
                            if($balanceat>0) { 
                                ?>
                            <div class="col-12">
                            <div class="form-group">
                                <label>Amount Payable</label>
                                <input class="form-control" type="hidden" value="<?php echo $taxableAmt['totalFee'];?>" name="fee_amount_without_gst" />
                                <input class="form-control" type="hidden" value="<?php echo $taxableAmt['totalAmt'];?>" name="fee_paid_amount" />
                                <input class="form-control" type="hidden" value="<?php echo $feepaid[0]->payment_id;?>" name="payment_id" />
                                <input class="form-control" value="<?php echo $balanceat;?>" name="paid_amount" readonly="readonly" />


                            </div>
                        </div>
                        <div class="col-12">

                            <div class="form-group">
                                <button class="btn btn-info btn_save " type="submit">Paynow</button>

                            </div>
                        </div>     
                           <?php } else {
                            echo '<span class="error">All fee payment has completed.</span>';
                            }
                        } ?>
                
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
                    <table class="table table_register_fee table-bordered table-striped  table-bordered table-sm ExaminationList">
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
        <ul class="checkbox_list list-group" id="paymentcheckbox">
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
                            if(empty($paidinstall)) {
                        ?>
                    <li class="list-group-item"><label class="custom_checkbox <?php if(!empty($paidinstall) && $paidinstall->installment_paid_amount>0){ echo 'instComplete'; } ?>" style="color: #787878 !important;">Installment <?php echo $x;?>  Amount : <?php echo numberformat($install->installment_amount);?>
                        <input type="checkbox" id="installmentdis<?php echo $install->installment_id; ?>" name="installment[]" value="<?php echo $x;?>" class="hostel installmentchk"  >  
                        <?php
                        if(empty($paidinstall)) {
                        ?>
                        <input type="hidden" name="installment_id[]" value="<?php echo $install->installment_id;?>">
                        <input type="hidden" name="installment_amt[]" value="<?php echo $install->installment_amount;?>">
                        <?php } ?>
                            <span class="checkmark" <?php if($x==1) { ?> id="firstinstallslct" <?php } ?> onclick="feepayinstallment('<?php echo $install->installment_amount; ?>','<?php echo $install->installment_id; ?>');"></span>
                            </label>
                    </li>
                    <?php } ?>

            <!-- <li><label class="custom_checkbox <?php if(!empty($paidinstall) && $paidinstall->installment_paid_amount>0){ echo 'instComplete'; } ?>" style="color: #787878 !important;">Installment <?php echo $x;?>  Amount : <?php echo numberformat($install->installment_amount);?>
                        <input type="checkbox" id="installmentdis<?php echo $install->installment_id; ?>" name="installment[]" value="<?php echo $x;?>" class="hostel installmentchk" <?php echo (!empty($paidinstall) && $paidinstall->installment_paid_amount>0)?'checked="checked" disabled="disabled"':'';?> >  
                        <?php
                        if(empty($paidinstall)) {
                        ?>
                        <input type="hidden" name="installment_id[]" value="<?php echo $install->installment_id;?>">
                        <input type="hidden" name="installment_amt[]" value="<?php echo $install->installment_amount;?>">
                        <?php } ?>
                              <span class="checkmark" <?php if($x==1) { ?> id="firstinstallslct" <?php } ?> onclick="feepayinstallment('<?php echo $install->installment_amount; ?>','<?php echo $install->installment_id; ?>');"></span>
                            </label>
            </li> -->
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
            <li class="list-group-item" id="loadfeeamt"></li>
        </ul>
    </div>   
    <?php } ?>
                </p>
            </div>
            <div id="paymenttab" class=" tab-pane fade"><br>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <h6>Payment History</h6>
        <div class="table-responsive table_language">
                    <table class="table table_register_fee table-bordered table-striped table-bordered table-sm ExaminationList">
                        <tbody>
                            <tr>
                                <th width="15%">Payment Type</th>
                                <th width="15%" class="text-center">Amount[INR]</th>
<!--								<th width="15%" class="text-center">Balance</th>-->
                                <th width="15%" class="text-center">Mode of Pay</th>
                                <th width="20%" class="text-center">Date of Pay</th>
                                <th width="30%">Card Details</th>
                                <th width="5%">Action</th>
                            </tr>
                            <?php 
                            if(!empty($transactions)) {
                                foreach($transactions as $trans) { 
                            ?>
                            <tr>
                                <td><span class="payment_align_right"><?php echo $trans['type'];?></span></td>
                                <td><span class="payment_align_right" style="float:right"><?php echo number_format($trans['amount'],2);?></span></td>
<!--								<td class="text-center"><span class="payment_align_right">0.00</span></td>-->
                                <td class="text-center"><span class="payment_align_right"><?php echo $trans['mode'];?></span></td>
                                <td class="text-center"><span class="payment_align_right"><?php echo $trans['date'];?></span></td>
                                <td><span class="payment_align_right"><?php echo $trans['transtype'];?></td>
                                <?php if($trans['method'] == 'installment') { ?>
                                <td class="text-center"><a id="download_receipt" onclick="download_receipt('<?php echo $trans['student_id'];?>','<?php echo $trans['institute_course_mapping_id'];?>','<?php echo $trans['install_id'];?>')"><img src="<?php echo base_url();?>direction_v2/images/receipt.png"></a></td>
                                <?php } ?>
                                <?php if($trans['method'] == 'onetime') { ?>
                                <td class="text-center"><a id="download_receipt" onclick="download_receipt('<?php echo $trans['student_id'];?>','<?php echo $trans['institute_course_mapping_id'];?>','0','<?php echo $trans['payment_id'];?>')"><img src="<?php echo base_url();?>direction_v2/images/receipt.png"></a></td>
                                <?php } ?>
                                <?php if($trans['method'] == 'split') { ?>
                                <td class="text-center"><a id="download_receipt" onclick="download_splitreceipt('<?php echo $trans['student_id'];?>','<?php echo $trans['institute_course_mapping_id'];?>','0', '<?php echo $trans['payment_id'];?>','<?php echo $trans['install_id'];?>')"><img src="<?php echo base_url();?>direction_v2/images/receipt.png"></a></td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                            <?php } else { ?>
                            <tr>
                                <td colspan="7">Transaction details not available.</td>
                            </tr>
                            <?php } ?>
                                                                                                                                                                    </tbody>
                    </table>
                </div>
    </div>
            </div>

        </div>
    </div>
</div>

    
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
        var student_id = $(this).attr('alt');
        var instituteCourseMappingIdpayment = $('#instituteCourseMappingIdpayment').val();
        // alert(instituteCourseMappingIdpayment);
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
               alert(response);
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


function download_receipt(id, insti_course_mid, install_id = NULL, payment_id = 0){
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Receipt/download_receipt/'+id+'/'+insti_course_mid+'/'+install_id+'/'+payment_id,
            type: 'POST',
            data: {
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                if(obj.st==1){
                    window.open(obj.url);
                    $(".loader").hide();
                }
                $(".loader").hide();
            }
        });
    }


    function download_splitreceipt(id, insti_course_mid, install_id = NULL, payment_id = 0, split = 0){
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Receipt/download_splitreceipt/'+id+'/'+insti_course_mid+'/'+install_id+'/'+payment_id+'/'+split,
            type: 'POST',
            data: {
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                if(obj.st==1){
                    window.open(obj.url);
                    $(".loader").hide();
                }
                $(".loader").hide();
            }
        });
    }


    </script>
