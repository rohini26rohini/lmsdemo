
<div style="width: 768px;margin: auto;float: none;" id="containerprint">
     <div style="float: left;width: 100%;">
        <div style="float: left;width: 668px;text-align: center;">
            <h3 style="margin: 26px auto;font-size: 24px;font-family: 'Open Sans', sans-serif;font-weight: 400;">Student Report</h3>
        </div>
    </div>
    <table class="table table-bordered" cellpadding="5" style="border-collapse:collapse;width:750px;">
        <thead style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center;">Sl.No.</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center;">Application.No.</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Name</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">School</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Centre</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Batch</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center">Contact Number</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center">Address</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Location</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center">Status</th>
            </tr>
        </thead>
        <tbody>
        <?php $sl = 1 ;
        foreach($studentArr as $row){?>
        <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <td align="center" style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo $sl;?></td> 
            <td align="center" style="font-size: 11px;border:1px solid #ccc;text-align: center">
                <?php echo $row['registration_number'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;"><?php echo $row['name'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;">
                <?php echo $this->common->get_name_by_id('am_schools','school_name',array("school_id"=>$row['school_id']));?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center">
                <?php echo $this->common->get_name_by_id('am_institute_master','institute_name',array("institute_master_id"=>$row['center_id']));?>
            </td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;">
                <?php echo $this->common->get_name_by_id('am_batch_center_mapping','batch_name',array("batch_id"=>$row['batch_id']));?>
            </td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center">
                <?php echo $row['contact_number'];?>
            </td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center">
                <?php echo $row['address'];?>
            </td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center">
                <?php echo $row['street'];?>
            </td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center">
            <?php 
            $ccstatus = '';
            if($row['caller_id']>0) { 
                $callcentre = $this->common->get_from_tablerow('cc_call_center_enquiries', array('call_id'=>$row['caller_id']));
                if(!empty($callcentre['call_status'])){
                    $ccstatus = $callcentre['call_status'];
                } 
            }
            if ($row['student_status']==1) { echo 'Admitted';}
            else if($row['student_status']==2) { echo 'Fee Paid';}
            else if($row['student_status']==4) { echo 'Batch Changed';}
            else if($row['student_status']==5) { echo 'Inactive';}
            else if($row['student_status']==0 && $row['verified_status']==1) { echo 'Payment Pending';}
            else  { echo 'Payment Pending';}
            if($ccstatus==4) { echo 'Blacklist';}
                    ?>
            </td>
        </tr>
        <?php 
        $sl++;
        } ?>
        </tbody>
    </table>
</div>
    