<div class="clearfix"></div>
    <div class="quiz">
        <div class="container">
          <div class="series-wapper-header d-flex justify-space-between align-self mb-30">
                <h3 class="cus-title">Exam Overview <span></span></h3>
                <div class="d-flex align-items-center cus-back">
                    <a class="btn" id="backtoresult"> <i class="fa fa-long-arrow-left"></i>&nbsp;Back to Course </a>
                </div>
            </div>
       
          
             <div class="quiz-body qz_item">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card dash-box-shadow">
                            <div class="card-body pzero">
                                <!-- <h4 class="card-title">Chemistry</h4> -->
                                <h5>  Course Name  :  <?php echo  $this->common->get_name_by_id('am_classes','class_name',array('class_id' => $course_id));?></h5>
                                <h5>  Total Attempt  :  <?php  if(!empty($attempt->attempt)){ echo $attempt->attempt;}?></h5>

                                <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl.no</th>
                                        <th>Total Questions</th>
                                        <th>Correct Answers</th>
                                        <th>Grade</th>
                                        <th>Attempt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; if(!empty($results)){
                                      foreach($results as $row){?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <th><?php echo $questioncount->count; ?></th>
                                        <td><?php echo  $this->common->get_name_by_id('orido_exam_answers','correct',array('emp_id' => $this->session->userdata('user_id'),
                                    'attempt'=>$row->attemptcount,'assessment_id'=>$row->id));?></td>
                                        <td><?php echo $row->grade;?></td>
                                        <td><?php echo $row->attemptcount;?></td>
                                    
                                    </tr>
                                       <?php $i++; } }else{?>
                                         <tr>
                                         <td colspan="5">No result...!</td>
                                       
                                     
                                     </tr>   
                                     <?php   }?>
                                   
                                </tbody>
                            </table>
                        </div> 


                                <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center justify-space-between">
                                    <!-- <a class="btn btn-light pre_btn">Previous</a> -->
                                    <!-- <button type="submit" class="btn btn-success next_btn">Finish</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
                        </form>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#backtoresult').on('click', function() {
            $(".loader").show();
                    $("#loadattmpt").hide();
                    $("#loadexamrslt").show();
                    $(".loader").hide();
        });
    });
    </script>