<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
     <h6>
                  <?php echo (isset($coursedet) && $coursedet->class_name!='')?$coursedet->class_name:'';?> [<?php echo (isset($coursedet) && $coursedet->mode!='')?$coursedet->mode:'';?>]
                  </h6>
    <hr>
  <div class="table-responsive table_language"> <?php //print_r($batchdet);?>
      
      <style>
          .head_h4{
              font-size: 16px;
          }
          .head_h4 small{
                  display: block;
    margin-bottom: 15px;
    color: #777;
          }
      </style>
      
      <div class="table-responsive table_language">
                        <table class="table  table-bordered table-striped text-center table-sm">
                            <tr>
                                <th class="text-left" style="background-color: rgb(0, 123, 255);">Sessions</th>
                            </tr>
                        <?php if(!empty($course_syllabusdet)) {
                                    foreach($course_syllabusdet as $course) {
                                        ?>
                            <tr><td class="text-left" style="padding:15px;"><h3 class="moduleH3"><?php echo $course->subject_name.'&nbsp;<small>['.$course->subjectname.']</small></h3><hr><p>'.$course->module_content;?></p></td>
                                      <?php      
                                    }
                            }
                            ?>
                           </table></div>
 </div></div>
</div>
