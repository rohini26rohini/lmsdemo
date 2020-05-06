
<div style="width: 768px;margin: auto;float: none;" id="containerprint">
     <div style="float: left;width: 100%;">
        <div style="float: left;width: 668px;text-align: center;">
            <h3 style="margin: 26px auto;font-size: 24px;font-family: 'Open Sans', sans-serif;font-weight: 400;">Student Attendance Report</h3>
        </div>
    </div>
    <table class="table table-bordered" cellpadding="5" style="border-collapse:collapse;width:750px;">
        <thead style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Sl.No.</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Student</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Subject / Exam</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Attendance</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Staff</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Date</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Type</th>
            </tr>
        </thead>
        <tbody>
        <?php $sl = 1 ;
        foreach($studentArr as $row){?>
        <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <td align="center" style="font-size: 11px;border:1px solid #ccc;text-align: left;"><?php echo $sl;?></td> 
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;">
                <?php echo $row['name'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;"><?php  if($att_type == 'class') { echo $this->common->get_module_fromschedule_idname_by_id($row['module_id']);}
                            else { echo $row['examName'].'</td>';}?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;">
                <?php if($row['attendance'] == 1){echo 'P';} else { echo 'A'; }?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;">
                <?php if($att_type == 'class') {echo $this->common->get_name_by_id('am_staff_personal','name',array('personal_id'=>$row['staff_id']));}
                else{
                    echo '';
                }?>
            </td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;">
                <?php echo date('d-m-Y',strtotime($row['att_date']));?>
            </td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;">
                <?php echo ucfirst($row['type']);?>
            </td>
        </tr>
        <?php 
        $sl++;
        } ?>
        </tbody>
    </table>
</div>
    