<?php

$pdf = new Pdftc(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Direction');
$title = "PAYSLIP FOR ".$salary['processing_time'] ." for ".$staff['staff']['name'];
$pdf->SetTitle($title);
$pdf->SetSubject('Payslip');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$headerTitle = "Salary Payslip";
$headerString = $salary['processing_time']."\nFor ".$staff['staff']['name']."\nBy Direction";
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $headerTitle, $headerString);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$logoUrl = base_url()."assets/images/logo.png";
$html = "";
$html .= '<h1>'.$staff['staff']['name'].' '.$salary['processing_time'].' Payslip</h1>';
$html .= '<table cellpadding="4" cellspacing="1" border="1" style="text-align:center;">';
$html .= '<tr style="text-align:left;">';
$html .= '<th>Staff Name</th><td><b>'.$staff['staff']['name'].'</b></td>';
$html .= '<th>Staff ID</th><td><b>'.$staff['staff']['registration_number'].'</b></td>';
$html .= '</tr><tr style="text-align:left;">';
$html .= '<th>Designation</th><td><b>'.$staff['staff']['designation'].'</b></td>';
$html .= '<th>Salary Scheme</th><td><b>'.$staff['staff']['salary_scheme'].'</b></td>';
$html .= '</tr>';
$html .= '</table>';
$html .= "<br>";
$html .= '<h4>Allowances</h4>';
$html .= '<table cellpadding="4" cellspacing="1" border="1">';
$html .= '<tr style="text-align:left;"><th><b>Sl</b></th><th><b>Allowance</b></th><th><b>Amount(INR)</b></th></tr>';
$i = 0;
$totalAmount = 0;
foreach($salary_scheme as $row){
    if($row->type == "ADD"){
        $i++;
        $totalAmount = $totalAmount + $row->amount;
        $html .= '<tr style="text-align:left;"><td>'.$i.'</td><td>'.$row->head.'</td><td style="text-align:right;">'.$row->amount.'</td></tr>';
    }
}
foreach($salary_addons as $row){
    if($row->type == "ADD"){
        $i++;
        $totalAmount = $totalAmount + $row->amount;
        $html .= '<tr style="text-align:left;"><td>'.$i.'</td><td>'.$row->description.'</td><td style="text-align:right;">'.$row->amount.'</td></tr>';
    }
}
$totalAmount = $totalAmount + $salary['extra_allowance'];
$i++;
$html .= '<tr style="text-align:left;"><td>'.$i.'</td><td>Extra Allowance</td><td style="text-align:right;">'.$salary['extra_allowance'].'</td></tr>';
$html .= '<tr style="text-align:left;"><th colspan="2"><b>Total Earnings</b></th><th style="text-align:right;"><b>'.number_format($totalAmount,2).'</b></th></tr>';
$html .= '</table>';
$html .= "<br>";
$html .= '<h4>Deductions</h4>';
$html .= '<table cellpadding="4" cellspacing="1" border="1">';
$html .= '<tr style="text-align:left;"><th><b>Sl</b></th><th><b>Deduction</b></th><th><b>Amount(INR)</b></th></tr>';
$i = 0;
$totalAmount = 0;
foreach($salary_scheme as $row){
    if($row->type == "DEDUCT"){
        $i++;
        $totalAmount = $totalAmount + $row->amount;
        $html .= '<tr style="text-align:left;"><td>'.$i.'</td><td>'.$row->head.'</td><td style="text-align:right;">'.$row->amount.'</td></tr>';
    }
}
foreach($salary_addons as $row){
    if($row->type == "DEDUCT"){
        $i++;
        $totalAmount = $totalAmount + $row->amount;
        $html .= '<tr style="text-align:left;"><td>'.$i.'</td><td>Salary Advance</td><td style="text-align:right;">'.$row->amount.'</td></tr>';
    }
}
$totalAmount = $totalAmount + $salary['salary_reduction'];
$i++;
$html .= '<tr style="text-align:left;"><td>'.$i.'</td><td>LOP</td><td style="text-align:right;">'.$salary['salary_reduction'].'</td></tr>';
$totalAmount = $totalAmount + $salary['extra_deduction'];
$i++;
$html .= '<tr style="text-align:left;"><td>'.$i.'</td><td>Extra Deduction</td><td style="text-align:right;">'.$salary['extra_deduction'].'</td></tr>';
$html .= '<tr style="text-align:left;"><th colspan="2"><b>Total Deductions</b></th><th style="text-align:right;"><b>'.number_format($totalAmount,2).'</b></th></tr>';
$html .= '</table>';
$html .= '<br/>';
$html .= '<h4 style="text-align:right;">Total Payable Salary : INR '.$salary['payable_salary'].'</h4>';
$html .= '<br/><br/><br/>';
$html .= '<h4 style="text-align:right;">Total PF taken till this salary : INR '.$total_pf_taken.'</h4>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

//Close and output PDF document
$pdf->Output('example_006.pdf', 'I');
?>