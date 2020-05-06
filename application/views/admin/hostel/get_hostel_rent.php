<?php 
$html = '';
if($this->input->post('initial_rent')){
    $data = explode('-',$this->input->post('initial_rent'));
    $student_id = $data[2];
    $fee_details = $this->Hostel_model->get_student_hostel_rent($student_id,$data[4]); 
    $monthly_fees = $fee_details['monthly_fees'];
    $onetime_fees = $fee_details['onetime_fees'];
    $total_days = (int)date('t', time());
    $daysRemaining = ((int)date('t', time()) - (int)date('j', time())) + 1;
    $current_month_fee = ($monthly_fees['fees']/$total_days)*$daysRemaining;
    $current_month_fee = number_format((float)$current_month_fee, 2, '.', '');
    $html = '<h6>Rent Summary</h6>
            <div class="table-responsive">
                <form id="pay_hostel_rent_summary">
                <input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />
                <table class="table table-striped table-sm dirstudent-list dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="studentlist_table_info">';
    $html .= '<tr>
                <th>Particulars</th>
                <th>Rent</th>
            </tr>';
    if(!empty($onetime_fees)){
        foreach($onetime_fees as $row){
            $hidden = '<input type="hidden" name="ph_id[]" value="'.$row['ph_id'].'">';
            $hidden .= '<input type="hidden" name="amount[]" value="'.$row['amount'].'">';
            $html .= '<tr><td>'.$hidden.$row['ph_head_name'].'</td><td>'.number_format((float)$row['amount'],2).'</td></tr>';
        }
    }    
    $hidden = '<input type="hidden" name="month[]" value="'.$data[0].'">';
    $hidden .= '<input type="hidden" name="year[]" value="'.$data[3].'">';
    $hidden .= '<input type="hidden" name="month_amount[]" value="'.(float)$current_month_fee.'">';
    $html .= '<tr>
                <td>'.$hidden.$data[0].' - '.$data[3].'</td>
                <td>'.number_format((float)$current_month_fee,2).'</td>
            </tr>
            <tr>
                <th>Payable Amount</th>
                <td><input class="form-control" type="hidden" value="'.$data[1].'" name="payable_amount" readonly/>
                '.number_format((float)$data[1],2).'</td>
            </tr>
            <tr>
                <td></td>
                <td><button type="button" onclick="payInitialFees('.$data[2].','.$data[4].')" class="btn btn-info btn_save">Pay Rent</button></td>
            </tr>
        </table>
        </form>
    </div>';
}else{
    if($this->input->post('monthly_rent')){
        $monthly_rent = $this->input->post('monthly_rent');
        if(!empty($monthly_rent)){
            $html = '<h6>Rent Summary</h6>
                    <div class="table-responsive">
                        <form id="pay_hostel_rent_summary">
                        <input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />
                        <table class="table table-striped table-sm dirstudent-list dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="studentlist_table_info">';
            $html .= '<tr>
                        <th>Particulars</th>
                        <th>Rent</th>
                    </tr>
                    ';
            $payable_amount = 0.00;
            foreach($monthly_rent as $rent){
                $data = explode('-',$rent);
                $hidden = '<input type="hidden" name="month[]" value="'.$data[0].'">';
                $hidden .= '<input type="hidden" name="year[]" value="'.$data[3].'">';
                $hidden .= '<input type="hidden" name="month_amount[]" value="'.$data[1].'">';
                $html .= '<tr>
                            <td>'.$hidden.$data[0].' - '.$data[3].'</td>
                            <td>'.number_format((float)$data[1],2).'</td>
                        </tr>';
                $payable_amount += $data[1];
            }
        }
        $html .= '<tr>
                        <th>Payable Amount</th>
                        <td><input class="form-control" type="hidden" value="'.$payable_amount.'" name="payable_amount" readonly/>
                        '.number_format((float)$payable_amount,2).'</td>
                    </tr>
                    <tr class="dirbtntransport">
                        <td></td>
                        <td><button type="button" onclick="payInitialFees('.$data[2].','.$data[4].')" class="btn btn-info btn_save">Pay Rent</button></td>
                    </tr>
                </table>
                </form>
            </div>';
    }
}
echo $html;
?>