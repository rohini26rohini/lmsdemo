<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="ProgressReports">
                                <h5>Overall marks obtained in each of the exams</h5>
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
                                </tr>
                            </thead>
                            <?php 
							$percentile = 0;
                            if(count($myexams)>0) {
                            $examcount = count($myexams);
                            $prograssbarwidth = 150*$examcount;
							$sectionprograssbarwidth = 300*$examcount;	
                            } else {
                            $prograssbarwidth = 150;
							$sectionprograssbarwidth = 300;		
                            }
                            $percentilegroupStr = '';
                                if(!empty($myexams)) { 
                                    $i=1; 
                                    $outof = '';
                                    foreach($myexams as $mark) { 
										                    $percentile = 0;
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
									<td><?php if(!empty($average)) { echo number_format($average['average'], 2);} ?></td>
									<td><?php echo $minscore->total_mark;?></td>
									<td><?php echo $topscore->total_mark;?></td>
                                </tr>
                            </tbody>
                                    <?php 
                                    $percentilegroupStr .= "['".$mark->name."[A".$mark->attempt."]', ".number_format($percentile)."],";    
                                    }

                                    } 
                                    else {
                                    echo '<tr><th colspan="9" al>No Data Found!!</th></tr>';
                                    } 
                                    ?>
                        </table>
                    </div>
                            </div>
                        </div>
						 <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="ProgressReports">
                                <h5>Percentile score</h5>
								<div style="overflow:auto">
                                <div id="container" style="height: 600px; width:<?php echo $prograssbarwidth;?>px;"></div>
								</div>
                            </div>
                        </div>
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="ProgressReports">
                                <h5>Section wise score</h5>
								<div style="overflow:auto">
                                <div id="containersession" style="height: 400px; width:<?php echo $sectionprograssbarwidth;?>px;"></div>
								</div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="ProgressReports">
                                <h5>Overall section wise performance</h5>
                                <div id="pie" style="height: 400px"></div>
                            </div>
                        </div>

                    </div>
    <script src="<?php echo base_url();?>assets/js/highcharts.js"></script>
    <script src="<?php echo base_url();?>assets/js/highcharts-3d.js"></script>
   <script src="<?php echo base_url();?>assets/js/exporting.js"></script>
    <script src="<?php echo base_url();?>assets/js/export-data.js"></script>

<script>
		
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: 0,
            style: {
                fontSize: '9px',
                fontFamily: 'Verdana, sans-serif',
                display:'block',
                textOverflow:'ellipsis'

            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Percentile score'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Percentile score: <b>{point.y:.1f} </b>'
    },
    series: [{
        name: 'Population',
        data: [
            <?php echo substr($percentilegroupStr, 0, -1); ?>
          //  ['Exam 1', 24.2],
          //  ['Exam 2', 20.8],
          //  ['Exam 3', 70.9],
          //  ['Exam 4', 56.7],
          //  ['Exam 54543534543534543543 45 43543543 435 54543543543 543543 543', 90.1],
          //  ['Exam 6', 78.7],
          //  ['Exam 7', 40.4],
          //  ['Exam 8', 76.2],
          //  ['Exam 9', 48.0],
          //  ['Exam 110', 56.7]
        ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:.1f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
    
// 3d pie
Highcharts.chart('pie', {
    chart: {
      type: 'pie',
      options3d: {
        enabled: true,
        alpha: 45,
        beta: 0
      }
    },
    title: {
      text: ''
    },
    tooltip: {
      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        depth: 35,
        dataLabels: {
          enabled: true,
          format: '{point.name}'
        }
      }
    },
    colors: [
           <?php echo substr($color, 0, -1); ?>   
//        '#7cb5ec', 
//        '#434348', 
//        '#90ed7d'
        ],
    series: [{
      type: 'pie',
      name: 'Percentage',
      data: [
          <?php echo $sectionpie;?>
//        ['English Language', 45.0],
//        ['Numerical Ability', 26.8],
//        {
//          name: 'Reasoning Ability',
//          y: 12.8,
//          sliced: true,
//          selected: true
//        }
      ]
    }]
  });

  //bar chart

  var chart = Highcharts.chart('containersession', {

  chart: {
    type: 'column'
  },

  title: {
    text: ' '
  },

  subtitle: {
    text: ' '
  },

  legend: {
    align: 'right',
    verticalAlign: 'middle',
    layout: 'vertical'
  },

  xAxis: {
    //categories: ['Exam 1', 'Exam 2', 'Exam 3'],
    categories: [<?php echo $exams;?>], 
    labels: {
      x: -10
    }
  },

  yAxis: {
    allowDecimals: false,
    title: {
      text: 'Mark'
    }
  },
      colors: [
        <?php echo substr($color, 0, -1); ?>  
        ],
  series: [
//      {
//    name: 'English Language',
//    data: [11, 20, 20]
//  }, {
//    name: 'Numerical Ability',
//    data: [9, 13, 23]
//  }, {
//    name: 'Reasoning Ability',
//    data: [24, 17, 21]
//  }
      <?php echo $sectionStr;?>
  ],

  responsive: {
    rules: [{
      condition: {
        maxWidth: 500
      },
      chartOptions: {
        legend: {
          align: 'center',
          verticalAlign: 'bottom',
          layout: 'horizontal'
        },
        yAxis: {
          labels: {
            align: 'left',
            x: 0,
            y: -5
          },
          title: {
            text: null
          }
        },
        subtitle: {
          text: null
        },
        credits: {
          enabled: false
        }
      }
    }]
  }
});
    

