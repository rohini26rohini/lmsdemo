<div style="width: 768px;margin: auto;float: none;" id="containerprint">
    <div style="float: left;width: 100%;">
        <div style="float: left;width: 100px;">
            <img src="inner_assets/images/logo.png" style="width:90px;margin: 10px 0px;" />
        </div>
        <div style="float: left;width: 668px;text-align: center;">
            <h3 style="margin: 26px auto;font-size: 24px;font-family: 'Open Sans', sans-serif;font-weight: 400;">Call Centre Report</h3>
        </div>
    </div>
    <table class="table table-bordered" cellpadding="5" style="border-collapse:collapse;width:750px;">
        <thead style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center;">Sl.No.</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Name</th>
				<th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Assigned To</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Course</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center">Primary Contact</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Street</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center">Enquiry Type</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center">Status</th>
            </tr>
        </thead>
        <tbody>
        <?php $sl = 1 ;
        foreach($call_centerArr as $calls){?>
        <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <td align="center" style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo $sl;?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;"><?php echo $calls['name'];?></td>
			<td style="font-size: 11px;border:1px solid #ccc;text-align: left;"><?php echo $calls['assignne'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;"><?php echo $calls['class_name'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo $calls['primary_mobile'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;"><?php echo $calls['street'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo $calls['enquiry_type'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php if($calls['assign_status']==1){
                     echo "Pending";
                    } else if($calls['assign_status']==2){
                        echo "In Progress";
                    }else if($calls['assign_status']==3){
                        echo "Closed";
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