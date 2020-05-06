
<div style="width: 768px;margin: auto;float: none;" id="containerprint">
     <div style="float: left;width: 100%;">
        <!-- <div style="float: left;width: 100px;">
            <img src="inner_assets/images/logo.png" style="width:90px;margin: 10px 0px;" />
        </div> -->
        <div style="float: left;width: 668px;text-align: center;">
            <h3 style="margin: 26px auto;font-size: 24px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <?php if($courseorbatch == 1){
                    echo 'Centre Wise Batch Fee Report';
                }else{
                    echo 'Centre Wise Course Fee Report';
                }?>
            </h3>
        </div>
    </div>
    <table class="table table-bordered" cellpadding="5" style="border-collapse:collapse;width:750px;">
        <thead style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center;"><?php echo $this->lang->line('sl_no');?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;"><?php if($courseorbatch == 1){
                            echo 'Batch Name'; }else{ echo 'Course Name'; }?></th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: right;">Total Fee Collected</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: right;">Cash</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: right;">Card</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: right;">Cheque</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: right;">Online</th>
            </tr>
        </thead>
        <tbody>
        <?php $sl = 1 ;$totalFeeCollected = $Cash = $Card = $Cheque = $Online = 0;
        foreach($report as $row){ 
            $totalFeeCollected += $row['total_fee_collected'];
            $Cash += $row['Cash'];
            $Card += $row['Card'];
            $Cheque += $row['Cheque'];
            $Online += $row['Online'];?>
        <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <td style="font-size: 11px;border:1px solid #ccc;text-align: center"><?php echo $sl;?></td> 
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left">
            <?php if($courseorbatch == 1){
                echo $row['batch_name'];
            }else{
                echo $row['class_name'];
            }?>
            </td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: right"><?php echo numberformat($row['total_fee_collected']);?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: right;"><?php echo numberformat($row['Cash']);?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: right;">
                <?php echo numberformat($row['Card']); ?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: right">
                <?php echo numberformat($row['Cheque']); ?>
            </td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: right">
                <?php echo numberformat($row['Online']); ?>
            </td>
        </tr>
        <?php 
        $sl++;
        } ?>
        <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center;">#</th>
            <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: right;">Total</th>
            <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: right;"><?php echo numberformat($totalFeeCollected);?></th>
            <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: right;"><?php echo numberformat($Cash);?></th>
            <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: right;"><?php echo numberformat($Card);?></th>
            <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: right;"><?php echo numberformat($Cheque);?></th>
            <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: right;"><?php echo numberformat($Online);?></th>
        </tr>
        </tbody>
    </table>
</div>
    