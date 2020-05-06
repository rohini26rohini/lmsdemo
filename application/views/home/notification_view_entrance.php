
<div class="abtbanner BgGrdOrange ">
    <div class="container maincontainer">
        <h3>Upcoming Exams & Notifications</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('direction-school-for-entrance-examinations'); ?>">Direction School for entrance examinations </a></li>
            <li class="breadcrumb-item active" aria-current="page">Upcoming Exams & Notifications</li>
        </ol>
    </div>
</div>
<section class="inner_page_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="grow_wrap">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table_exam_details">
                            <tr>
                                <th>Sl.No</th>
                                <th>Name</th>
                            </tr>
                            <tr>
                            <?php
                            $i =1;
                            if(!empty($notificationArr)){ 
                            foreach ($notificationArr as $notification){
                            ?>
                                <td><?php echo $i;?></td>
                                <td>
                                <a href="<?php echo base_url('detailed-notification-entrance/'.$notification['notification_id']);?>">
                                <?php echo $notification['name']?></a></td>
                            </tr>
                            <?php $i++;  }} else{?>
                                <td colspan="2"><center>No data found</center></td>
                          <?php  } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>