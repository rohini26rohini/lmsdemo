<div style="width: 768px;margin: auto;float: none;" id="containerprint">
    <div style="float: left;width: 100%;">
        <div style="float: left;width: 100px;">
            <img src="inner_assets/images/logo.png" style="width:90px;margin: 10px 0px;" />
        </div>
        <div style="float: left;width: 668px;text-align: center;">
            <h3 style="margin: 26px auto;font-size: 24px;font-family: 'Open Sans', sans-serif;font-weight: 400;">Hall Ticket Report</h3>
        </div>
    </div>
    <table class="table table-bordered" cellpadding="5" style="border-collapse:collapse;width:750px;">
        <thead style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center;">Sl.No.</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Name</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Exam</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center">Contact Number</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Course</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center">Hall Ticket</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center">Status</th>
            </tr>
        </thead>
        <tbody>
        <?php $sl = 1 ;
        // show($examArrpdf);
          foreach($examArrpdf as $exam){?>
        <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <td align="center" style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo $sl;?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;"><?php echo $exam['student_name'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;"><?php echo $exam['exam_name'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo $exam['contact_number'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;"><?php echo $exam['class_name'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo $exam['hall_tkt'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center">
            <?php 
            if($exam['status'] != '') {
                if($exam['status'] == 1){
                    echo "Passed";
                } else if($exam['status'] == 0) {
                    echo "Failed";
                }
            }else{
                echo "-";
            }
                    ?>
            </td>
        </tr>
        <?php 
        $sl++;
        } ?>
        </tbody>
    </table>
</div>