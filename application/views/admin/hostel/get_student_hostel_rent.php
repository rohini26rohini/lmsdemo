<?php
    $fee_details = $this->Hostel_model->get_student_hostel_rent($student_id,$booking_id); 
    $payed_rent = $this->Hostel_model->get_student_hostel_rent_payments($booking_id); 
    $batch_details = $this->Hostel_model->get_student_batch_details($student_id); 
    $monthly_fees = $fee_details['monthly_fees'];
    $onetime_fees = $fee_details['onetime_fees'];
    if(empty($monthly_fees) || empty($onetime_fees)){
        $html = 'Fees is not defined for this hostel room type';
        print_r(json_encode($html));
        exit;
    }
    $html = '<div class="col-md-8">
                <h6>Hostel Rent details</h6>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm dirstudent-list dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="studentlist_table_info">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Title</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                
    $i = 1;
    $total_onetimefee = 0;
    if(!empty($onetime_fees)){
        foreach($onetime_fees as $row){
            $total_onetimefee += $row['amount'];
            $html .= '<tr><td>'.$i.'</td><td>'.$row['ph_head_name'].'</td><td>'.number_format((float)$row['amount'], 2, '.', '').'</td><td>Onetime</td></tr>';
            $i++;
        }
    }
    $html .= '<tr><td>'.$i.'</td><td>Monthly Rent</td><td>'.$monthly_fees['fees'].'</td><td>Monthly</td></tr>';
    $html .= '<tr><td colspan="2">Total one time fee</td><td>'.number_format((float)$total_onetimefee, 2, '.', '').'</td><td></td></tr>';
    $html .= '</tbody></table></div></div>';
    
    $html .= '<div class="col-md-12"><h6 class="dirtransporttitle">Monthly Payment</h6>
                <div class="table-responsive">
                    <form id="pay_hostel_rent">
                    <input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" />
                        
                    <table class="table table-striped table-sm dirstudent-list dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="studentlist_table_info">
                        <tr>
                            <th>Pay</th>
                            <th>Month - Year</th>
                            <th>Payable Amount</th>
                            <th> </th>
                        </tr>';
    $total_days = (int)date('t', time());
    // $daysRemaining = (int)date('t', time()) - (int)date('j', time());
    $daysRemaining = ((int)date('t', time()) - (int)date('j', time())) + 1;
    $current_month_fee = ($monthly_fees['fees']/$total_days)*$daysRemaining;
    $total_onetimefee += $current_month_fee;
    $total_onetimefee = number_format((float)$total_onetimefee, 2, '.', '');
    $start_year = date('Y',time());
    $start_month = date('m',time());
    $start_day = $start_year.'-'.$start_month.'-01';
    $end_year = date('Y',strtotime($batch_details['batch_dateto']));
    $end_month = date('m',strtotime($batch_details['batch_dateto']));
    $end_day = $end_year.'-'.$end_month.'-01';

    $html .= '<tr>';
    if(!empty($payed_rent)){
        $html .= '<td><div class="form-check"><input class="form-check-input" checked disabled type="checkbox"> - Paid</div></td>';
    }else{
        $html .= '<td><div class="form-check"><input class="form-check-input" name="initial_rent" onclick="trans_payment()" type="checkbox" 
                    value="'.date('M',strtotime($start_day)).'-'.
                            $total_onetimefee.'-'.
                            $student_id.'-'.
                            date('Y',strtotime($start_day)).'-'.
                            $booking_id.'"> - Initial Payment</div></td>';
    }      
    $html .= '<td><label class="form-check-label" for="inlineCheckbox1">'.date('M',strtotime($start_day)).' - '.date('Y',strtotime($start_day)).'</label></td>';
    if(!empty($payed_rent)){     
        $total_onetimefee = 0;
        foreach($payed_rent as $rent){
            $payed_month = date('M',strtotime($rent['from_date']));
            $payed_year = date('Y',strtotime($rent['from_date']));
            if($rent['payment_type']==1){
                $total_onetimefee += $rent['payed_amount'];
            }
            if($rent['payment_type']==2 && $payed_month==date('M',strtotime($start_day)) && $payed_year==date('Y',strtotime($start_day))){
                $total_onetimefee += $rent['payed_amount'];
                break;
            }
        }
        $html .= '<td>'.$total_onetimefee.'</td>';
        $html .= '<td><a title="Click to view invoive" style="cursor:pointer" onclick="download_receipt('.$student_id.','.$payed_rent[0]['hostel_payment_invoices_id'].')"><img src="'.base_url("direction_v2/images/receipt.png").'"></a></td>';
    }else{
        $html .= '<td>'.$total_onetimefee.'</td>';
        $html .= '<td> </td>';
    }
    $html .= '</tr>';

    $start_day = date("Y-m-d", strtotime("+1 month", strtotime($start_day)));
    while(strtotime($end_day)>=strtotime($start_day)){
        $html .= '<tr>';
        if(!empty($payed_rent)){
            $payed=0;
            $payed_amount = 0;
            foreach($payed_rent as $rent){
                $payed_month = date('M',strtotime($rent['from_date']));
                $payed_year = date('Y',strtotime($rent['from_date']));
                if($rent['payment_type']==2 && $payed_month==date('M',strtotime($start_day)) && $payed_year==date('Y',strtotime($start_day))){
                    $payed=1;
                    $payed_amount = $rent['payed_amount'];
                    $hostel_payment_invoices_id = $rent['hostel_payment_invoices_id'];
                    break;
                }
            }
            if($payed){
                $html .= '<td><div class="form-check"><input class="form-check-input" checked disabled type="checkbox"> - Paid</div></td>';
                $html .= '<td><label class="form-check-label" for="inlineCheckbox1">'.date('M',strtotime($start_day)).' - '.date('Y',strtotime($start_day)).'</label></td>';
                $html .= '<td>'.$payed_amount.'</td>';
                $html .= '<td><a title="Click to view invoive" style="cursor:pointer" onclick="download_receipt('.$student_id.','.$hostel_payment_invoices_id.')"><img src="'.base_url("direction_v2/images/receipt.png").'"></a></td>';
            }else{
                if($monthly_fees['hl_room_booking_status']=='checkout'){
                    break;
                }else{
                    $html .= '<td><div class="form-check"><input class="form-check-input" name="monthly_rent[]" onclick="trans_payment()" type="checkbox" 
                                value="'.date('M',strtotime($start_day)).'-'.
                                        $monthly_fees['fees'].'-'.
                                        $student_id.'-'.
                                        date('Y',strtotime($start_day)).'-'.
                                        $booking_id.'"> - Payment Pending</div></td>';
                    // $html .= '<td><div class="form-check"><input class="form-check-input" name="monthly_rent[]" onclick="trans_payment()" type="checkbox" value="'.date('M',strtotime($start_day)).'-'.$monthly_fees['fees'].'-'.$student_id.'-'.date('Y',strtotime($start_day)).'"></div></td>';
                }
                $html .= '<td><label class="form-check-label" for="inlineCheckbox1">'.date('M',strtotime($start_day)).' - '.date('Y',strtotime($start_day)).'</label></td>';
                $html .= '<td>'.$monthly_fees['fees'].'</td>';
                $html .= '<td> </td>';
            }
        }else{
            $html .= '<td><div class="form-check"><span class="success">Initial Payment Pending</span></div></td>';
            $html .= '<td><label class="form-check-label" for="inlineCheckbox1">'.date('M',strtotime($start_day)).' - '.date('Y',strtotime($start_day)).'</label></td>';
            $html .= '<td>'.$monthly_fees['fees'].'</td>';
            $html .= '<td> </td>';
        }
        $html .= '</tr>';
        $start_day = date("Y-m-d", strtotime("+1 month", strtotime($start_day)));
    }
    $html .= '</table></form></div></div></div></div>';
    $html .= '<div class="col-md-4" id="loadtransfeesummary"></div>';
    echo $html;
?>