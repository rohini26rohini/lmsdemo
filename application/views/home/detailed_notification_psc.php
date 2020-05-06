<div class="abtbanner BgGrdOrange ">
    <div class="container maincontainer">
        <h3>Upcoming Exams & Notifications</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Upcoming Exams & Notifications</li>
        </ol>
    </div>
</div>
<section class="inner_page_wrapper">
    <div class="container maincontainer">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                <div class="noti" id="accordion">
                    <div class="card ">
                         <div class="card-header ">
                            <a class="card-link collapsed " data-toggle="collapse" href="" aria-expanded="false">
                            Direction School for PSC Examinations
                            </a>
                        </div>
                        <div id="collapseOne" class="collapse show" data-parent="#accordion" style="">
                            <div class="card-body">
                                <ul class=" list-unstyled ">
                                    <?php $notifications= $this->common->get_notifications(3); 
                                    if(!empty($notifications)) {
                                        foreach($notifications as $not) {
                                            echo '<li><a href="'.base_url('detailed-notification-psc/'.$not['notification_id']).'">'.$not['name'].'</a></li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-8 col-12">
                <?php if(!empty($detailedArr)){ 
                    foreach ($detailedArr as $row){?>
                        <div class="grow_wrap">
                            <h1 class="grow_header"><?php echo $row->name;?></h1>
                            <p><?php echo $row->description;?></p>
                            <h1 class="inner_head">Details of Post</h1>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm table_exam_details table_smallfont_custom">
                                    <tr>
                                        <th>Post</th>
                                        <th>Stream</th>
                                        <th>Pay Scale </th>
                                        <th>No. Of Vacancy
                                        </th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $row->post;?></td>
                                        <td><?php echo $row->stream;?></td>
                                        <td><?php echo $row->pay_scale;?></td>
                                        <td><?php echo $row->vacancy;?></td>
                                    </tr>
                                </table>
                            </div>
                            <h1 class="inner_head">Important Dates</h1>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm table_exam_details table_smallfont_custom">
                                    <tr>
                                        <th width="50%">Online Application Start Date</th>
                                        <td><?php echo $row->start_date;?></td>
                                    </tr>
                                    <tr>
                                        <th>Online Application End Date </th>
                                        <td><?php echo $row->end_date;?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    <?php   
                    }
                } 
                ?>
            </div>
        </div>
    </div>
</section>

