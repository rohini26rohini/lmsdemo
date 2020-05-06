
<div style="width: 768px;margin: auto;float: none;" id="containerprint">
     <div style="float: left;width: 100%;">
        <!-- <div style="float: left;width: 100px;">
            <img src="inner_assets/images/logo.png" style="width:90px;margin: 10px 0px;" />
        </div> -->
        <div style="float: left;width: 668px;text-align: center;">
            <h3 style="margin: 26px auto;font-size: 24px;font-family: 'Open Sans', sans-serif;font-weight: 400;">Exam Schedule Report</h3>
        </div>
    </div>
    <table class="table table-bordered" cellpadding="5" style="border-collapse:collapse;width:750px;">
        <thead style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;"><?php echo $this->lang->line('sl_no');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;"><?php echo $this->lang->line('batch');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;"><?php echo $this->lang->line('exam_name');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;"><?php echo $this->lang->line('date');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;"><?php echo $this->lang->line('start_time');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;"><?php echo $this->lang->line('end_time');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left"><?php echo $this->lang->line('status');?></th>
            </tr>
        </thead>
        <tbody>
        <?php $sl = 1 ;
        foreach($report as $row){ ?>
        <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left"><?php echo $sl;?></td> 
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left"><?php echo $this->common->get_name_by_id('am_batch_center_mapping','batch_name',array("batch_id"=>$row['batch_id']));?> </td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left"><?php echo $row['examName'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;"><?php echo date('d-m-Y',strtotime($row['schedule_date']));?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;">
                <?php echo date("g:i a", strtotime($row['schedule_start_time'])); ?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left">
                <?php echo date("g:i a", strtotime($row['schedule_end_time'])); ?>
            </td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left">
                <?php 
                if($row['st'] == 0){
                    echo 'CREATED';
                }else if($row['st'] == 1){
                    echo 'SCHEDULED';
                }else if($row['st'] == 2){
                    echo 'STARTED';
                }else if($row['st'] == 3){
                    echo 'FINISHED';
                }else if($row['st'] == 4){
                    echo 'RESULT PUBLISHED';
                }else if($row['st'] == 5){
                    echo 'CLOSED';
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
    