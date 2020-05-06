
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
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;"><?php echo $this->lang->line('student_name');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;"><?php echo $this->lang->line('exam_name');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;"><?php echo $this->lang->line('attempt');?></th>
                <?php foreach($section as $head){?>
                    <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">
                        <?php echo $head['sectionName'];?>
                    </th>
                <?php }?>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;"><?php echo $this->lang->line('mark');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left"><?php echo $this->lang->line('percentage');?> (%)</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left"><?php echo $this->lang->line('percentile_score');?> (%)</th>
            </tr>
        </thead>
        <tbody>
        <?php $sl = 1 ;
        foreach($report as $row){ ?>
        <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left"><?php echo $sl;?></td> 
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left"><?php echo $this->common->get_name_by_id('am_students','name',array("student_id"=>$row['student_id']));?> </td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left"><?php echo $this->common->get_name_by_id('gm_exam_schedule','name',array("id"=>$row['exam_id']));?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;"><?php echo $row['attempt'];?></td>
            <?php foreach($section as $head){?>
                <td style="font-size: 11px;border:1px solid #ccc;text-align: left;">
                    <?php echo $row[$head['sectionName']]; ?>
                </td>
            <?php }?>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left"> <?php echo $row['total']; ?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left"> <?php echo $row['percentage']; ?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left"> <?php echo $row['per']; ?></td>
        </tr>
        <?php 
        $sl++;
        } ?>
        </tbody>
    </table>
</div>
    