
<div style="width: 768px;margin: auto;float: none;" id="containerprint">
     <div style="float: left;width: 100%;">
        <!-- <div style="float: left;width: 100px;">
            <img src="inner_assets/images/logo.png" style="width:90px;margin: 10px 0px;" />
        </div> -->
        <div style="float: left;width: 668px;text-align: center;">
            <h3 style="margin: 26px auto;font-size: 24px;font-family: 'Open Sans', sans-serif;font-weight: 400;">Staff Leave Report</h3>
        </div>
    </div>
    <table class="table table-bordered" cellpadding="5" style="border-collapse:collapse;width:750px;">
        <thead style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center;"><?php echo $this->lang->line('sl_no');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center;"><?php echo $this->lang->line('staff');?></th>
                <?php $leaveHeads = $this->common->get_alldata('leave_heads',array("status"=>1));
                        foreach($leaveHeads as $head){
                            echo '<th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center;">'.$head['head'].'</th>';
                }?>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center;"><?php echo $this->lang->line('total');?></th>
            </tr>
        </thead>
        <tbody>
        <?php $sl = 1 ;
        foreach($report as $row){ ?>
        <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <td align="center" style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo $sl;?></td> 
            <td align="center" style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo $row['name']; ?></td>
            <?php $leaveHeads = $this->common->get_alldata('leave_heads',array("status"=>1));
            foreach($leaveHeads as $head){?>
                <td align="center" style="font-size: 11px;border:1px solid #ccc;text-align: center">
                <?php echo $this->common->get_leaveBystaff($row['personal_id'], $head['id'],$start_date,$end_date);?></td>
            <?php } ?>
            <td align="center" style="font-size: 11px;border:1px solid #ccc;text-align: center">
                <?php echo $this->common->get_leaveBystaff_total($row['personal_id'],$start_date,$end_date);?></td>
        </tr>
        <?php 
        $sl++;
        } ?>
        </tbody>
    </table>
</div>
    