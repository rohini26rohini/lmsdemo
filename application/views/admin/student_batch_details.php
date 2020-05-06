
  <div class="table-responsive"> <?php //print_r($batchdet);?>
      
      <style>
          .head_h4{
              font-size: 16px;
          }
          .head_h4 small{
                  display: block;
    margin-bottom: 5px;
    color: #777;
          }
          .table_reg tr th,
          .table_reg tr td
          {
              padding: 0;
          }
      </style>
      <table class="table table_register table_reg">
          <tr>
              <td colspan="2">
              <h3 style="font-size: 18px; border-bottom: solid 1px #ccc;padding-bottom: 15px;">
                  <?php echo (isset($batchdet) && $batchdet->class_name!='')?$batchdet->class_name:'';?> [<?php echo (isset($batchdet) && $batchdet->mode!='')?$batchdet->mode:'';?>] 
                  <small style="display: block;font-weight: 300;color: #777;font-size:12px;margin-top:6px;">
                      <?php echo (isset($batchdet) && $batchdet->batch_name!='')?$batchdet->batch_name:'';?>, 
                        <span style="font-weight: 300;color: #999;font-size:12px"><?php echo (isset($batchdet) && $batchdet->institute_name!='')?$batchdet->institute_name:'';?>, </span>
                        <span style="font-weight: 300;color: #999;font-size:12px"><?php echo (isset($batchdet) && $batchdet->center!='')?$batchdet->center:'';?></span>
                  </small>
                  </h3></td>
         
          </tr>
          <tr>
            <td>                
                <h4 class="head_h4">
                    <small>
                    Duration
                    </small>                    
                    <?php echo (isset($batchdet) && $batchdet->batch_datefrom!='')?date('d M Y', strtotime($batchdet->batch_datefrom)):'';?> To <?php echo (isset($batchdet) && $batchdet->batch_dateto!='')?date('d M Y', strtotime($batchdet->batch_dateto)):'';?>
                </h4>
              </td>
            <!--<td>
              <h4  class="head_h4">
                  <small>
                      Time
                  </small>
                  <?php echo (isset($batchdet) && $batchdet->batch_start_time!='')?date('g:i a', strtotime($batchdet->batch_start_time)):'';?> To <?php echo (isset($batchdet) && $batchdet->batch_end_time!='')?date('g:i a', strtotime($batchdet->batch_end_time)):'';?>
                </h4>
              </td>-->
          </tr>
          <tr>
<!--
            <td>
                 <h4  class="head_h4">
                  <small>
                      Last Date Of Admission
                  </small>
                     <?php echo (isset($batchdet) && $batchdet->last_date!='')?date('d M Y', strtotime($batchdet->last_date)):'';?>
                </h4>
                
                </td>
-->
            <td>
              <h4  class="head_h4">
                  <small>Admitted Date
                  </small>
                  <?php if($batchdet->student_id!='') { 
    $student = $this->common->get_from_tablerow('am_students', array('student_id'=>$batchdet->student_id));
    echo (isset($student) && $student['admitted_date']!='')?date('d M Y', strtotime($student['admitted_date'])):'';
}?>
                </h4>
              </td>
          
          </tr>        
       
          
      
      </table>

              <h6>Weekly Class</h6>
    <hr>
<div class="table-responsive table_language">
                <table class="table table-sm table_register table-bordered table-striped text-center">
                    <tr>
                        <td class="text-center">Sun</td>
                        <td class="text-center">Mon</td>
                        <td class="text-center">Tue</td>
                        <td class="text-center">Wed</td>
                        <td class="text-center">Thu</td>
                        <td class="text-center">Fri</td>
                        <td class="text-center">Sat</td>
                    </tr>
                    <tr>
                        <td class="text-center"><?php echo (isset($batchdet) && $batchdet->sunday==1)?'<img src="'.base_url().'inner_assets/images/check-mark.svg" width="16"/>':'';?></td>
                        <td class="text-center"><?php echo (isset($batchdet) && $batchdet->monday==1)?'<img src="'.base_url().'inner_assets/images/check-mark.svg" width="16"/>':'';?></td>
                        <td class="text-center"><?php echo (isset($batchdet) && $batchdet->tuesday==1)?'<img src="'.base_url().'inner_assets/images/check-mark.svg" width="16"/>':'';?></td>
                        <td class="text-center"><?php echo (isset($batchdet) && $batchdet->wednesday==1)?'<img src="'.base_url().'inner_assets/images/check-mark.svg" width="16"/>':'';?></td>
                        <td class="text-center"><?php echo (isset($batchdet) && $batchdet->thursday==1)?'<img src="'.base_url().'inner_assets/images/check-mark.svg" width="16"/>':'';?></td>
                        <td class="text-center"><?php echo (isset($batchdet) && $batchdet->friday==1)?'<img src="'.base_url().'inner_assets/images/check-mark.svg" width="16"/>':'';?></td>
                        <td class="text-center"><?php echo (isset($batchdet) && $batchdet->saturday==1)?'<img src="'.base_url().'inner_assets/images/check-mark.svg" width="16"/>':'';?></td>
                    </tr>
                    <tr>
                       <td>
                                            <span style="display:block;text-align:center;" id="sunday_div">
                                                    <?php echo $sunday; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span  style="display:block;text-align:center;"  id="monday_div">
                                                           <?php echo $monday; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span  style="display:block;text-align:center;"  id="tuesday_div">
                                                       <?php echo $tuesday; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span style="display:block;text-align:center;"  id="wednesday_div">
                                                       <?php echo $wednesday; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span  style="display:block;text-align:center;"  id="thursday_div">
                                                       <?php echo $thursday; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span style="display:block;text-align:center;"  id="friday_div">
                                                       <?php echo $friday; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span style="display:block;text-align:center;"  id="saturday_div">
                                                       <?php echo $saturday; ?>
                                            </span>
                                        </td>
                    </tr>
                </table></div>
 </div>
