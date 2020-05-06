<!DOCTYPE html>
<html lang="en">

<head>
    <title>IIHRM</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700i" rel="stylesheet">

    <style>
        html,
        body,
        div,
        span,
        applet,
        object,
        iframe,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        blockquote,
        pre,
        a,
        abbr,
        acronym,
        address,
        big,
        cite,
        code,
        del,
        dfn,
        em,
        img,
        ins,
        kbd,
        q,
        s,
        samp,
        small,
        strike,
        strong,
        sub,
        sup,
        tt,
        var,
        b,
        u,
        i,
        center,
        dl,
        dt,
        dd,
        ol,
        ul,
        li,
        fieldset,
        form,
        label,
        legend,
        table,
        caption,
        tbody,
        tfoot,
        thead,
        tr,
        th,
        td,
        article,
        aside,
        canvas,
        details,
        embed,
        figure,
        figcaption,
        footer,
        header,
        hgroup,
        menu,
        nav,
        output,
        ruby,
        section,
        summary,
        time,
        mark,
        audio,
        video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }

        /* HTML5 display-role reset for older browsers */
        article,
        aside,
        details,
        figcaption,
        figure,
        footer,
        header,
        hgroup,
        menu,
        nav,
        section {
            display: block;
        }

        body {
            line-height: 1;
        }

        ol,
        ul {
            list-style: none;
        }

        blockquote,
        q {
            quotes: none;
        }

        blockquote:before,
        blockquote:after,
        q:before,
        q:after {
            content: '';
            content: none;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }
    </style>
</head>

<body> 
    <div style="border: 1px solid #b5b2b2;padding: 20px; width:800px;margin:auto;background-color: #fff;">
        <div style="font-family: 'Open Sans', sans-serif;float: left; width:38%;">
            <img src="<?php echo FCPATH;?>/direction_v2/images/logo/logo.png" alt="logo" style="width:80px;">
            <p style="font-size: 13px;font-family: 'Open Sans', sans-serif;margin-bottom: 1rem;font-size: 14px;display:block;line-height:20px;">
                <?php echo $this->common->get_name_by_id('am_config','value',array("key"=>"company_registration"));?><br>
                <span><?php echo $this->common->get_name_by_id('am_config','value',array("key"=>"company_gst_code"));?></span></p>
            <div style="width: 100%;border: 1px solid #989898;border-left: 1px solid #989898;padding: 3px 7px;">
                <p style="font-family: 'Open Sans', sans-serif;font-weight: 100;font-size: 14px;">FORM NO</p>
                <span></span>
            </div>
        </div>
        <div style="font-family: 'Open Sans', sans-serif;float: right; width:60%;">
            <div>
                <h4 style="font-size: 13px;margin-bottom: 10px;font-family: 'Open Sans', sans-serif;font-weight: bold;"><u>DIRECTION GROUP OF  
                    INSTITUTIONS Pvt. Ltd.</u></h4>
                <p style="font-size: 13px;font-family: 'Open Sans', sans-serif;margin-bottom: 1rem;text-transform:uppercase;">Four square building, 2nd and 3rd Floor
                NH66, Near Star Care Hospital,Thondayad Calicut, Kerala, India
                    <span> Phone: 8907777456, 0495-4040792, 94, 95, 96 </span></p>
                <table style="border: 1px solid #989898;padding:15px;width:100%;">
                    <tbody> <?php 
                    $inv_no = '';
                    $inv_amt= '';
                    $date = '';
                    
                        $invoice = $this->common->get_from_tablerow('hl_hostel_payment_invoices', array('id'=>$invoice_id)); 
                        if(!empty($invoice)) {
                            $inv_no = $invoice['invoice_no'];
                            $inv_amt = $invoice['total_payable_amount'];
                            $date = date('d-m-Y', strtotime($invoice['payed_date']));
                        }
                    ?>
                        <tr style="border: 1px solid #989898;">
                            <th style="border: 1px solid #989898;text-align: left;font-family: 'Open Sans', sans-serif;font-weight: bold;padding:5px 10px;font-size: 14px;">Invoice No. </th>
                            <td style="border: 1px solid #989898;text-align: left;font-family: 'Open Sans', sans-serif;font-weight: 100;padding:5px 10px;font-size: 14px;"><?php echo $inv_no; ?></td>
                        </tr>
                        <tr style="border: 1px solid #989898;">
                            <th style="border: 1px solid #989898;text-align: left;font-family: 'Open Sans', sans-serif;font-weight: bold;padding:5px 10px;font-size: 14px;">Date</th>
                            <td style="border: 1px solid #989898;text-align: left;font-family: 'Open Sans', sans-serif;font-weight: 100;padding:5px 10px;font-size: 14px;"><?php echo $date; ?></td>
                        </tr>
                        <tr>
                            <th style="border: 1px solid #989898;text-align: left;font-family: 'Open Sans', sans-serif;font-weight: bold;padding:5px 10px;font-size: 14px;">Course</th>
                            <td style="border: 1px solid #989898;text-align: left;font-family: 'Open Sans', sans-serif;font-weight: 100;padding:5px 10px;font-size: 14px;"><?php echo $studentcard['class_name'];?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div style="clear: both;"></div>
        <div>
            <h4 style="text-align: center;font-family: 'Open Sans', sans-serif;font-weight: bold;padding:5px 10px;font-size: 14px;margin-top: 25px;text-transform: uppercase;">Invoice</h4>
            <h6 style="margin: 0px; padding: 4px 8px;font-size: 13px;text-align: left;font-family: 'Open Sans', sans-serif;font-weight: bold;margin-top: 25px;">Name
                <span style="padding: 4px 8px;font-size: 13px;text-align: left;font-family: 'Open Sans', sans-serif;font-weight: normal;"><?php echo $studentArr['name'];?></span>
            </h6>
            
            <p style="margin: 0px;padding: 4px 8px;font-size: 13px;text-align: left;font-family: 'Open Sans', sans-serif;font-weight: 100;font-style: italic;"><i>
            Hostel Rent
            </i></p>
            <table style="width:100%;">
                <thead>
                    <tr style="border: 1px solid #989898;border-bottom:transparent;border-top: 1px solid #989898;;">
                        <th style="border-right: 1px solid #989898;font-size:14px;padding:5px;text-align: left;font-family: 'Open Sans', sans-serif;font-weight: bold;">Sl NO</th>
                        <th style="border-right: 1px solid #989898;font-size:14px;padding:5px;text-align: left;font-family: 'Open Sans', sans-serif;font-weight: bold;">Particulars of Fees</th>
                        <th style="border-right: 1px solid #989898;font-size:14px;padding:5px;text-align: right;font-family: 'Open Sans', sans-serif;font-weight: bold;">Amount (INR)</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($feespaid)) {
                    $i = 1;
                    foreach($feespaid as $fee) { 
                        if($fee->payment_type == 1) {
                            $heads = $this->common->get_from_tablerow('am_payment_heads', array('ph_id'=>$fee->ph_id)); 
                            $fee_heads = $heads['ph_head_name'];
                        } else {
                            $fee_heads = 'Hostel Rent Of Month '.date('F', strtotime($fee->from_date)).' - '.date('Y', strtotime($fee->from_date));   
                        }
                ?>
                    <tr style="border: 1px solid #989898;border-bottom:transparent;border-top: 1px solid #989898;">
                        <td style="border-right: 1px solid #989898;font-size:14px;padding:5px;text-align: left;font-family: 'Open Sans', sans-serif;font-weight: 100;"><?php echo $i;?></td>
                        <td style="border-right: 1px solid #989898;font-size:14px;padding:5px;text-align: left;font-family: 'Open Sans', sans-serif;font-weight: 100;"><?php echo $fee_heads ;?></td>
                        <td style="border-right: 1px solid #989898;font-size:14px;padding:5px;text-align: right;font-family: 'Open Sans', sans-serif;font-weight: 100;"><?php echo number_format((float)$fee->payable_amount,2);?></td>
                    </tr>
                    <?php $i++; ?>
                    <?php } ?>
                <?php } ?>
                    
                    <tr style="border: 1px solid #989898;border-bottom: 1px solid #989898;border-top: 1px solid #989898;border-right:transparent;">
                        <td colspan="2" style="border-right: 1px solid #989898;text-align:right; font-size: 14px;padding: 5px;font-family: 'Open Sans', sans-serif;font-weight: bold;">
                            <strong>Total</strong></td>
                        <td style="border-right: 1px solid #989898; text-align:right;"><?php echo ((!empty($invoice) && $invoice['total_payable_amount'])?number_format((float)$invoice['total_payable_amount'],2):''); ?></td>
                        
                    </tr>
                </tbody>
            </table>
            <table style="margin:25px 0px;width:300px;">
            </table>
            <p style="margin: 0px;border: 1px solid #000;padding: 3px 8px;text-align: left;font-family: 'Open Sans', sans-serif;font-weight:500;font-size: 14px;margin-top:25px;width:55%;float: left">Fee once paid will not be refunded at anyground</p>
            <p style="margin: 0px;padding: 3px 8px;text-align: right;font-family: 'Open Sans', sans-serif;font-weight:100;font-size: 14px;margin-top:25px;float: right">Manager</p>
            <div style="clear:both"></div>
        </div>
    </div>
</body>

</html>