
<div style="width: 768px;margin: auto;float: none;" id="containerprint">
     <div style="float: left;width: 100%;">
        <!-- <div style="float: left;width: 100px;">
            <img src="inner_assets/images/logo.png" style="width:90px;margin: 10px 0px;" />
        </div> -->
        <div style="float: left;width: 668px;text-align: center;">
            <h3 style="margin: 26px auto;font-size: 24px;font-family: 'Open Sans', sans-serif;font-weight: 400;">Batch Schedule Report</h3>
        </div>
    </div>
    <table class="table table-bordered" cellpadding="5" style="border-collapse:collapse;width:750px;">
        <thead style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center;"><?php echo $this->lang->line('sl_no');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center;"><?php echo $this->lang->line('batch');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center;"><?php echo $this->lang->line('subject');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;"><?php echo $this->lang->line('date');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;"><?php echo $this->lang->line('start_time');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;"><?php echo $this->lang->line('end_time');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;"><?php echo $this->lang->line('module_name');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;"><?php echo $this->lang->line('staff');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center"><?php echo $this->lang->line('status');?></th>
            </tr>
        </thead>
        <tbody>
        <?php $sl = 1 ;
        foreach($report as $row){ ?>
        <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <td align="center" style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo $sl;?></td> 
            <td align="center" style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo $this->common->get_name_by_id('am_batch_center_mapping','batch_name',array("batch_id"=>$row['batch_id']));?> </td>
            <td align="center" style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo $this->common->get_name_by_id('mm_subjects','subject_name',array("subject_id"=>$row['subject_master_id']));?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;"><?php echo date('d-m-Y',strtotime($row['schedule_date']));?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;">
                <?php echo date("g:i a", strtotime($row['schedule_start_time'])); ?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center">
                <?php echo date("g:i a", strtotime($row['schedule_end_time'])); ?>
            </td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;">
                <?php echo $this->common->get_module_fromschedule_idname_by_id($row['module_id']); ?> 
            </td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;">
                <?php echo $this->common->get_name_by_id('am_staff_personal','name',array("personal_id"=>$row['staff_id'])); ?>
            </td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center">
                <?php if($row['class_taken'] == 1){
                    echo 'Completed';
                }else{
                    echo 'Pending';
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
    