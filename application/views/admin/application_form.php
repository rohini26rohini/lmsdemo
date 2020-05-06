<style>
    ul {
        list-style-type: none;
    }

    body {
        border-radius: 10px;
    }

    @page {
        size: auto;
        odd-header-name: html_myHeader1;
        even-header-name: html_myHeader2;
        odd-footer-name: html_myFooter1;
        even-footer-name: html_myFooter2;
    }

    @page chapter2 {
        odd-header-name: html_Chapter2HeaderOdd;
        even-header-name: html_Chapter2HeaderEven;
        odd-footer-name: html_Chapter2FooterOdd;
        even-footer-name: html_Chapter2FooterEven;
    }

    @page noheader {
        odd-header-name: _blank;
        even-header-name: _blank;
        odd-footer-name: _blank;
        even-footer-name: _blank;
    }

    div.chapter2 {
        page-break-before: right;
        page: chapter2;
    }

    div.noheader {
        page-break-before: right;
        page: noheader;
    }

    .left-col {
        float: left;
        width: 50%;
    }

    .right-col {
        float: right;
        width: 50%;
    }

    .mytitle {
        font-weight: bold;
        border: 1px solid black;
        border-radius: 10px;
        width: 33%;
        padding: 10px;
        font-size: 25px;
    }
</style>

<div class="row">
    <div class="left-col">
        <span style="border: 1p solid #000;border-radius: 5px;font-size: 18px;padding:15px;">Sl No</span>
        <span style="border: 1p solid #000;border-radius: 5px;font-size: 18px;color:Red;"><?php echo $studentArr['registration_number'];?></span>
    </div>
    <div class="right-col"><img src="<?php echo base_url();?>direction_v2/images/logo/logo.png" style="width:150px;float: right;text-align: right;display: block;margin-right: 0;"></div>
</div>
<div style="text-align:center;">
    <h3 style="text-align:center;font-size:16px;disply:block;text-transform: uppercase;padding:0px 15px;margin:0px;margin-bottom:5px;"><u>Application Form</u></h3>
    <span style="text-align:center;font-size:14px;disply:block;margin:0px;displlay:block;"><?php echo $studentArr['school_name'];?></span>
</div>
<div class="row">
    <table style="vertical-align:top;margin-top:30px;">
        <tr>
            <td width="20%" style="font-size:14px;color:#000;">Name :</td>
            <td width="80%" style="font-size:14px;color:#333;border-bottom: 1px dotted #000;"><?php echo $studentArr['name'];?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="font-size:14px;color:#000;">Address :</td>
            <td style="font-size:14px;color:#333;border-bottom: 1px dotted #000;"><?php echo $studentArr['address'];?></td>
        </tr>
    </table>
    <table style="vertical-align:top;width:100%;margin-top:30px;">
        <tr>
            <td style="font-size:14px;width:33.33%">Contact Number</td>
            <td style="font-size:14px;width:33.33%">Whatsapp No</td>
            <td style="font-size:14px;width:33.33%">Mobile</td>
        </tr>
        <tr>
            <td style="color:#333;font-size:14px;border-bottom: 1px dotted #000;width:33.33%"><?php echo $studentArr['contact_number'];?></td>
            <td style="color:#333;font-size:14px;border-bottom: 1px dotted #000;width:33.33%"><?php echo $studentArr['whatsapp_number'];?></td>
            <td style="color:#333;font-size:14px;border-bottom: 1px dotted #000;width:33.33%"><?php echo $studentArr['mobile_number'];?></td>
        </tr>
    </table>
    <table style="vertical-align:top;width:100%;margin-top:30px;">
        <tr>
            <td style="font-size:14px;color:000;width:33.33%">Name of Guardian</td>
            <td style="font-size:14px;color:000;width:33.33%">Guardian's Contact Number</td>
            <td style="font-size:14px;color:000;width:33.33%">Date Of Birth</td>

        </tr>
        <tr>
            <td style="color:#333;font-size:14px;border-bottom: 1px dotted #000;width:33.33%"><?php echo $studentArr['guardian_name'];?></td>
            <td style="color:#333;font-size:14px;border-bottom: 1px dotted #000;width:33.33%"><?php echo $studentArr['guardian_number'];?></td>
            <td style="color:#333;font-size:14px;border-bottom: 1px dotted #000;width:33.33%"><?php echo $studentArr['date_of_birth'];?></td>
        </tr>
    </table>
    <tr>
        <table style="vertical-align:top;width:100%;margin-top:30px;">
            <tr>
                <td style="color:#333;font-size:14px;width:20%;">Email</td>
                <td style="color:#333;font-size:14px;width:80%;border-bottom: 1px dotted #000;"><?php echo $studentArr['email'];?></td>
            </tr>
        </table>
</div>
<br><br>
</div>
<div class="row">
    <hr>
    <div style=width:33.33%;float:left;>
        <span style="font-size:14px;">Educational Qualification:</span>
    </div>
    <div style=width:33.33%;float:left;>
        <table>
            <?php foreach($qualificationArr as $row){?>
                <tr>
                    <td style="width:50%;font-size:14px;color:#000;border-bottom: 1px dotted #000;"><?php echo $row['qualification'];?></td>
                    <td style="width:50%;font-size:14px;color:#000;border-bottom: 1px dotted #000;">(<?php echo $row['marks'];?>%)</td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <?php 
    // show($studentArr);
    if($studentArr['student_image']!=''){ ?>
        <div style="width:33.33%;float:none;text-align: right;display: block;">
            <img src="<?php echo base_url();?><?php echo $studentArr['student_image'];?>" style="width:120px;margin: auto;text-align: center;display: block;">
        </div>
    <?php }else{ ?>
        <div style="width:33.33%;float:none;text-align: right;display: block;">
            <img src="<?php echo base_url();?>assets/images/user_3_Artboard_1-512.png" style="width:120px;margin: auto;text-align: center;display: block;">
        </div>
    <?php } ?>
    <hr>
    <div style="width:100%">
        <table>
            <tr>
                <td>Hostel Required ?</td>
                <?php if($studentArr['hostel']=='yes'){?>
                    <td>
                        <img src="<?php echo base_url();?>assets/images/checklist-checked-box.png" style="width:18px;"> 
                    </td>
                <?php }else{ ?>
                    <td>
                        <img src="<?php echo base_url();?>assets/images/uncheck.png" style="width:18px;"> 
                    </td>
                <?php } ?>
            </tr>
            <tr>
                <td>Transportation Required ?</td>
                <?php if($studentArr['transportation']=='yes'){?>
                    <td>
                        <img src="<?php echo base_url();?>assets/images/checklist-checked-box.png" style="width:18px;"> 
                    </td>
                <?php }else{ ?>
                    <td>
                        <img src="<?php echo base_url();?>assets/images/uncheck.png" style="width:18px;"> 
                    </td>
                <?php } ?>
            </tr>
        </table>
    </div>
    <hr>
</div>
<div class="row">
    <div style="text-align:center;">
        <span style="font-size:16px;color:#000"><b><u>Declaration</u></b></span>
    </div>
    <br>
    <table style="vertical-align:top;">
        <tr>
            <td><img src="<?php echo base_url();?>assets/images/checklist-checked-box.png" style="width:18px;"></td>
            <td></td>
            <td>
            <p style="font-size:14px;color:#000;">
                I hereby declare that,details furnished above are true to that best of my knowledge and belief. I assure fully cooperation in the coaching, which I understand is essential for its success. I also willingly agree that this programme is cardinal in my preparation for the selection and thus have no objection in my name or photo being used in the promotion group of institutions.
            </p>
            </td>
        </tr>
        <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><img src="<?php echo base_url();?>assets/images/checklist-checked-box.png" style="width:18px;"></td>
                <td></td>
                <td>
                    <p style="font-size:14px;color:#000;">For students who only needs materials no classes required.</p>
                </td>
            </tr>
            <tr>
                <td><img src="<?php echo base_url();?>assets/images/checklist-checked-box.png" style="width:18px;"></td>
                <td></td>
                <td><p style="font-size:14px;color:#000;">Fees are not refundable.</p></td>
            </tr>

        </tr>
    </table>
    <div style="clear:both;"></div>
</div>
<br><br>
