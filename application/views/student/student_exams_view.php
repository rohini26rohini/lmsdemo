<div class="table-responsive">
                        <table class="table table-bordered table-sm ExaminationList">
                            <thead>
                                <tr>
                                    <th>Sl.no</th>
                                    <th>Exam</th>
									<th>Date</th>
                                    <th>Mark obtained</th>
                                    <th>Percentage score</th>
									<th>Percentile score</th>
                                    <th>Average</th>
									<th>Min</th>
									<th>Max</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <?php
                                if(!empty($myexams)) {
                                    $i=1;
                                    $outof = '';
                                    foreach($myexams as $mark) {
                                        $topscore = $this->common->get_topscore($mark->attempt, $mark->exam_id);
                                        $minscore = $this->common->get_minscore($mark->attempt, $mark->exam_id);
                                        $average = $this->common->get_average($mark->attempt, $mark->exam_id);
                                        $questionDet = $this->common->get_exam_details_by_scheduleid($mark->exam_id);
                                        if(!empty($questionDet)) {
                                            $outof = $questionDet['totalmarks'];
                                        }
                                    ?>
                            <tbody>
                                <tr>
                                    <td><?php echo $i++;?></td>
                                    <td><?php echo $mark->name;?></td>
                                    <td><?php echo date('d/m/Y', strtotime($mark->start_date_time));?></td>
                                    <td><?php if($outof!=''){ echo $mark->total_mark.'/'.$outof; } ?></td>
                                    <td><?php 
                                        $markby = $mark->total_mark/$outof;
                                        $percentage = $markby*100;
                                        echo number_format($percentage).'%';
                                        ?></td>
									<td><?php 
                                        if($topscore->total_mark>0) {
                                        $markby = $mark->total_mark/$topscore->total_mark;
                                        $percentile = $markby*100;
                                        echo number_format($percentile).'%';
                                        } else {
                                            echo '0%';
                                        }
                                        ?></td>
									<td><?php if(!empty($average)) { echo number_format($average['average'],2);} ?></td>
									<td><?php echo $minscore->total_mark;?></td>
									<td><?php echo $topscore->total_mark;?></td>
                                    <td>
                                    <button class="btn btn-success smallbutton indiexamdetails" alt="<?php echo $mark->attempt;?>" id="<?php echo $mark->exam_id;?>">View</button>
                                    <button class="btn btn-success smallbutton timedistribution" alt="<?php echo $mark->attempt;?>" id="<?php echo $mark->exam_id;?>">Time Distribution</button>
                                    </td>
                                </tr>
                            </tbody>
                                    <?php
                                    }

                                    }
                                    else {
                                        echo '<tr><td colspan="10" ><b>No Data Found!!</b></td></tr>';
                                    }
                                    ?>
                        </table>
                    </div>
