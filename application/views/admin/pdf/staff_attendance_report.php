
<div style="width: 768px;margin: auto;float: none;" id="containerprint">
     <div style="float: left;width: 100%;">
        <div style="float: left;width: 100px;">
            <img src="inner_assets/images/logo.png" style="width:90px;margin: 10px 0px;" />
        </div>
        <div style="float: left;width: 668px;text-align: center;">
            <h3 style="margin: 26px auto;font-size: 24px;font-family: 'Open Sans', sans-serif;font-weight: 400;">Staff Attendance Report</h3>
        </div>
    </div>
    <table class="table table-bordered" cellpadding="5" style="border-collapse:collapse;width:750px;">
        <thead style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center;">Sl.No.</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: center;">Name</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Role</th>
                <th style="font-size: 11px;border:1px solid #ccc;background: #e8e8e8;text-align: left;">Attendance</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        foreach($date_array as $row){?>
            <tr><td colspan="4" style="background: #c6e4ff,font-size: 12px;font-family: 'Open Sans', sans-serif;text-align:center;font-weight: 900; vertical-align: middle;border: 1px solid #c6e4ff;">
                <?php  echo date('d-m-Y',strtotime($row)); ?>
                </td>
            <tr> 
                <?php $sl=1;
                foreach($attendance_data as $val)
                {
                    
                  if($val['date'] == $row)
                  {
                      if($val['attendance'] == 0)
                     {
                         $attendance="<span class='idpending'>Absent</span>";
                       
                     }
                    else
                    {
                       $attendance="<span class='admitted'>Present</span>";  
                    }
                ?>
        <tr style="font-size: 11px;font-family: 'Open Sans', sans-serif;font-weight: 400;">
            <td align="center" style="font-size: 11px;border:1px solid #ccc;text-align: center">
                <?php echo $sl;?></td> 
            <td align="center" style="font-size: 11px;border:1px solid #ccc;text-align: center">
                <?php echo $val['name'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;">
                <?php echo $val['role_name'];?></td>
            <td style="font-size: 11px;border:1px solid #ccc;text-align: left;">
                <?php echo $attendance;?></td>
            
        </tr>
        <?php 
        $sl++;
        } 
                }}?>
        </tbody>
    </table>
</div>
    