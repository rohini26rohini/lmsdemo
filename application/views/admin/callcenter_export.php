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
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Primary Course</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Secondary Course</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center">Primary Contact</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center">Email</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Street</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center">Enquiry Type</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center">Status</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center">Date</th>
            </tr>
        </thead>
        <tbody>
        <?php $sl = 1 ;
        $seccourseArr = [];
        $courseArr=$this->call_center_model->getall_list();
        foreach($call_centerArr as $calls){
            $seccourseArr = explode(',', $calls['seccourse_id']);  
            $seccoursenam = '';
            if(!empty($courseArr)) {
                foreach($courseArr as $row) {
                    if(in_array($row['class_id'], $seccourseArr)) { 
                        $seccoursenam .= $row['class_name'].', ';
                    } 
                    }
            }
            if($calls['class_id']!= ''){
                $class = $calls['class_name'];
            }else{
                $class = $calls['other_course'];
            }
            ?>
        <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <td align="center" style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo $sl;?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;"><?php echo $calls['name'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;"><?php echo $class;?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;"><?php echo $seccoursenam;?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo $calls['primary_mobile'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo $calls['email_id'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;"><?php echo $calls['street'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo $calls['enquiry_type'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php if($calls['call_status']==1){
                     echo "Call Received";
                    } else if($calls['call_status']==2){
                        echo "In Progress";
                    }else if($calls['call_status']==3){
                        echo "Closed";
                    }else if($calls['call_status']==4){
                        echo "Blacklisted";
                    }else if($calls['call_status']==5){
                        echo "Registered";
                    }else if($calls['call_status']==6){
                        echo "Admitted";
                    }
                    ?>
            </td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo date('d-m-Y', strtotime($calls['timing'])); ?></td>
        </tr>
        <?php 
        $sl++;
        } ?>
        </tbody>
    </table>
</div>