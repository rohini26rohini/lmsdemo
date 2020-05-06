<div class="dirtransportation scroller">
        <div class="row">
            <div class="col-md-8">
            <h6><?php echo $this->lang->line('transport_fee_details');?></h6>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm dirstudent-list dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="studentlist_table_info">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th><?php echo $this->lang->line('title');?></th>
                                        <th class="text-right"><?php echo $this->lang->line('amount');?>[INR]</th>
                                        <th><?php echo $this->lang->line('type');?></th>
                                    </tr>
                                </thead>
                                <?php 
                                $i = 0; 
                                $total = 0;
                                ?>
                                <tbody>
                                <?php
                                $paidmonth = array();
                                $paid = $this->common->get_from_tablerow('tt_payments', array('student_id'=>$student_id));
                                if(!empty($paid)) {
                                    $pay_id = $paid['pay_id'];
                                    $paidmonth = $this->common->paid_students_trans(array('pay_id'=>$paid['pay_id'],'fee_type'=>'onetime'));
                                }
                                ?>
                                <?php if(!empty($paidmonth)) { ?>
                                    <?php $i = 1; ?>
                                <?php foreach($paidmonth as $fee) {?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $fee->ph_head_name; if($fee->ph_refund==1){ echo '[Refundable]';}?></td>
                                        <td class="text-right"><?php echo numberformatwithout($fee->feeamount); $total += $fee->feeamount;?></td>
                                        <td>Onetime</td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php } ?>
                                
                                <?php } else { ?>
                                <?php if(!empty($fees)) { ?>
                                <?php $i = 1; ?>
                                <?php foreach($fees as $fee) {?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $fee->ph_head_name;?></td>
                                        <td class="text-right"><?php echo numberformatwithout($fee->fee_amount); $total += $fee->fee_amount;?></td>
                                        <td>Onetime</td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php } ?>
                                <?php } ?>
                                <?php } ?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td><?php echo $this->lang->line('transport_fee');?></td>
                                        <td class="text-right"><?php if(!empty($data) && $data->route_fare) { echo $data->route_fare;  } ?></td>
                                        <td>Monthly</td>
                                    </tr>
                                    <!-- <tr>
                                        <td colspan="2"><?php echo $this->lang->line('total');?></td>
                                        <td><strong><?php echo numberformat($total);?></strong></td>
                                        <td></td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                                <h6 class="dirtransporttitle"><?php echo $this->lang->line('payment_details');?><?php if($student_status == 'Active') { ?><span class="paymentcompleted" style="float:right; cursor:pointer;" onclick="canceltrans('<?php echo $student_id;?>','<?php echo $st_id;?>')" >Cancel</span><?php } ?></h6>
                        <div class="table-responsive">
                        <form id="recurringpayment" >
                        <input type="hidden" value="<?php echo $st_id;?>" id="get_st_id" name="st_id" />
                        <input type="hidden" value="<?php echo $student_id;?>" id="get_student_id" name="student_id" />
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                            <table class="table table-striped table-sm dirstudent-list dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="studentlist_table_info">
                            <tr>
                                        <th><?php echo $this->lang->line('month');?></th>
                                        <th class="text-right"><?php echo $this->lang->line('payable_amount');?>[INR]</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                <?php 
                                $batch_dateto = '';
                                if(!empty($batch)) {
                                    $batch_dateto = $batch['batch_dateto'];
                                }
                                $dateArr = get_month_between_dates($data->trans_start_date, $batch_dateto); //echo '<pre>';print_r($dateArr);
                               $m = 1;
                               $pay_id = '';
                               $invoice_id = '';
                               $cnt = 1;
                               $monthcnt = count($dateArr);
                                foreach($dateArr as $month) { //echo '<pre>';print_r($month);
                                    $paidmonth_status = 0;
                                    $paid = $this->common->get_from_tablerow('tt_payments', array('student_id'=>$student_id));
                                    if(!empty($paid)) {
                                        $pay_id = $paid['pay_id'];
                                        $paidmonth = $this->common->get_from_tablerow('tt_payment_details', array('pay_id'=>$paid['pay_id'],'fee_id'=>$month['month'],'fee_type'=>'monthly', 'year'=>$month['year']));
                                        if(!empty($paidmonth)) { 
                                            $paidmonth_status = 1;
                                            $invoice_id = $paidmonth['invoice_id'];
                                        }
                                    }
                                    if($student['transportation']=='yes' || ($paidmonth_status==1 && $student['transportation']=='no')) {
                                ?>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                        <?php
                                        $recurring = 0;
                                            if(!empty($data) && $data->route_fare) { 
                                                $route_fare = $data->route_fare;  
                                                if($m==1) {
                                                if($cnt==1 || $cnt==$monthcnt) {
                                                    $daysArr = get_remaining_days($data->trans_start_date, $batch['batch_dateto'], $cnt, $month['year'], $month['month'],$data->route_fare);
                                                    if(!empty($daysArr) && $daysArr['days']>0) {
                                                        $recurring = $total+$daysArr['amount']; 
                                                        $route_fare = $daysArr['amount'];
                                                    } else {
                                                        $recurring = $total+$data->route_fare;  
                                                    }
                                                } else {
                                                $recurring = $total+$data->route_fare;
                                                }
                                                } else {
                                                    if($cnt==1 || $cnt==$monthcnt) {
                                                        $daysArr = get_remaining_days($data->trans_start_date, $batch['batch_dateto'], $cnt, $month['year'], $month['month'],$data->route_fare);
                                                        if(!empty($daysArr) && $daysArr['days']>0) {
                                                            $recurring = $daysArr['amount']; 
                                                            $route_fare = $daysArr['amount'];
                                                        } else {
                                                            $recurring = $data->route_fare;
                                                        }
                                                    } else {
                                                        $recurring = $data->route_fare;
                                                    }
                                                }
                                            } else { $recurring = 0; }
                                            if($m==1) {
                                                if($paidmonth_status != 1) {
                                                foreach($fees as $fee) {
                                        ?>
                                            
                                            <input type="hidden" name="fee_id[]" value="<?php echo $fee->fee_id; ?>" />
                                            <input type="hidden" name="feeamount<?php echo $fee->fee_id; ?>" value="<?php echo $fee->fee_amount; ?>" />
                                            <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <input type="hidden" name="pay_id" value="<?php echo $pay_id; ?>" />
                                                <input type="hidden" name="monthly<?php echo $month['month'].$month['year'];?>" value="<?php echo $route_fare; ?>" />    
                                            <input type="hidden" name="recurring<?php echo $month['month'].$month['year'];?>" value="<?php echo $recurring; ?>" />
                                            <input type="hidden" name="month<?php echo $month['month'].$month['year'];?>" value="<?php echo $month['month'];?>" />
                                            <input type="hidden" name="year<?php echo $month['month'].$month['year'];?>" value="<?php echo $month['year'];?>" />
                                            <input class="form-check-input" <?php if($student_status == 'Cancelled' || $paidmonth_status == 1) { echo 'disabled="disabled"'; if($paidmonth_status == 1){ echo 'checked="checked"'; } } ?> onclick="trans_payment()" type="checkbox" name="month[]" id="selectedpaymonth<?php echo $month['month'].$month['year'];?>" value="<?php echo $month['month'].$month['year'];?>">
                                            <label class="form-check-label" for="inlineCheckbox1"><strong><?php echo date('F', strtotime($month['date']));?> - <?php echo $month['year'];?></strong></label>
                                        </div>
                                    </td>
                                    <td class="text-right"><?php if($paidmonth_status == 1) { if($m==1) { echo numberformat($total+$paidmonth['feeamount'],2);} else { echo numberformat($paidmonth['feeamount'],2);}} else {echo numberformat($recurring); }?></td>
                                    <td><?php if($paidmonth_status == 1) { echo '<a title="Paid" style="cursor:pointer"><span class="admitted">Paid</span></a>'; } ?></td>
                                    <td><?php if($paidmonth_status == 1) { echo '<a title="Click to view invoive" style="cursor:pointer" onclick=download_receipt("'.$student_id.'","'.$invoice_id.'","'.$pay_id.'")><img src="'.base_url().'direction_v2/images/receipt.png"/></a>';}?></td>
                                </tr>
                                        <?php $m++; ?>
                                        <?php $cnt++; ?>
                                    <?php } ?>
                                    <?php } ?>
                            </table>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-4">
            <h6>Payment Summary</h6>
            <form id="recurringpaymentprocees" >                            
                <div class="table-responsive" id="loadtransfeesummary">
                    
                </div>
            </form>
                
            </div>
        </div>
    </div>