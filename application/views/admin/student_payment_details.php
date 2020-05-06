<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  <div class="table-responsive table_language">
        <table class="table table_register_fee table-bordered table-striped table-sm">
            <tr>
                <th colspan="2">Payment Details</th>
            </tr>
            <?php
            if(!empty($paymentdet)) {
                foreach($paymentdet as $payment) {  
                    if($payment->payment_type=='onetime'){    ?>
                    <tr>
                        <td>Total Fee</td>
                        <td><?php echo numberformat($payment->total_amount);?></td>
                    </tr>
            <?php
            if($payment->discount_applied>0) {
                ?>
            <tr>
                <td>Discount</td>
                <td><?php echo numberformat($payment->discount_applied);?></td>
          </tr> 
          <tr>
                <td>Payable Fee</td>
                <td><?php echo numberformat($payment->payable_amount);?></td>
          </tr>
            <?php } ?>   
            <tr>
                <td>Amount Paid</td>
                <td><?php echo numberformat($payment->paid_amount);?></td>
          </tr>
            <?php if($payment->balance>0) { ?>
            <tr>
                <td>Balance</td>
                <td><?php echo numberformat($payment->balance);?></td>
          </tr>
            <?php } ?>
            <tr>
                <td>Date of Pay</td>
                <td><?php echo date('d M Y', strtotime($payment->createddate));?></td>
          </tr>
            <tr>
                <td>Mode of Pay</td>
                <td><?php echo $payment->paymentmode;?></td>
          </tr>
            <?php if($payment->paymentmode=='Card' || $payment->paymentmode=='Cheque') { ?>
            <tr>
                <td>Details</td>
                <td>
                    <?php if($payment->paymentmode=='Card') { ?>
                Card Type : <?php echo $payment->card_type;?>
            <?php } else { ?>
                    Cheque No : <?php echo $payment->cheque_no;?>
                   <?php  } ?><br>
                    Name : <?php echo $payment->card_holder_name;?><br>
                    Bank : <?php echo $payment->bank_name;?></td>
          </tr>  
            <?php } ?>
            <?php if($payment->paymentmode=='Online') { ?>
            <tr>
                <td>Transaction Id </td>
                <td><?php echo $payment->transaction_id;?></td>
            </tr>   
            <?php } ?>
            <tr>
                <td>Status</td>
                <td><?php if($payment->status==1) { echo 'Completed'; } else { echo 'Failed'; }?></td>
            </tr>   
            <?php } else { ?>
            <tr>
                <td>Total Fee</td>
                <td><?php echo numberformat($payment->payable_amount+$payment->discount_applied);?></td>
          </tr>
            <?php if($payment->discount_applied>0) { ?>
            <tr>
                <td>Discount</td>
                <td><?php echo numberformat($payment->discount_applied);?></td>
          </tr>
            <tr>
                <td>Payable Fee</td>
                <td><?php echo numberformat($payment->payable_amount);?></td>
          </tr>
            <?php } ?>
            <tr>
                <td>Amount Paid</td>
                <td><?php echo numberformat($payment->paid_amount);?></td>
          </tr>
            <?php if($payment->balance>0) { ?>
            <tr>
                <td>Balance</td>
                <td><?php echo numberformat($payment->balance);?></td>
          </tr>
            <?php } ?>
            <tr>
                <td colspan="2">
                    <?php
                          $installment = $this->common->student_installment_payment_details($payment->payment_id); 
                          if(!empty($installment)) {?>
                    <div class="table-responsive table_language">
                        <table class="table table_register table_register_fee table-sm table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th width="15%">Installment</th>
                                <th width="15%" class="text-center">Amount</th>
                                <th width="15%" class="text-center">Date of Pay</th>
                                <th width="15%" class="text-center">Mode of Pay</th>
                                <th width="40%">Details</th>
                            </tr>
                            </tbody>
                            <?php 
                              foreach($installment as $install) { 
                                if($install->installment_paid_amount > 0.00){ ?>
                             <tr>
                                <td><?php echo $install->installment; //if($install->installment_amount>0) { echo '<span style="color:red;"> Discount Applied</span>'; }?></td>
                                <td class="text-right"><?php echo numberformat($install->installment_paid_amount);?></td>
                                <td class="text-center"><?php echo date('d M Y', strtotime($install->createddate));?></td>
                                <td class="text-center"><?php echo $install->paid_payment_mode;?></td>
                                <td><?php if($install->paid_payment_mode!='Cash') { echo $install->card_holder_name,',</br> '.$install->bank_name; if($install->paid_payment_mode=='Card') { echo '</br>Card type : '.$install->card_type;} else if($install->paid_payment_mode=='Cheque') { echo '</br>Cheque No : '.$install->cheque_no;} else {echo 'Transaction ID : '.$install->transaction_id; }} ?></td>
                            </tr> 
                          <?php 
                              }}
                            ?></table>
                    </div>
                    <?php
                          }
                          ?>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
            <?php } ?>
        </table> 
 </div>
</div>