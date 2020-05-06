<div class="series-body">
                <div class="row">
               <?php  if(!empty($materials)) { 
                            foreach($materials as $material){  ?>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="cardImg">
                             <?php
                                        if($material->text_content!='') {
                                            echo '<a target="_blank" href="'.base_url().'user/Student/view_study_material/'.$material->id.'" class="learningmoduleDwld matimg btn btn-info btn_save">
                                            <i class="fa fa-eye text-right"></i>
                                            </a>';
                                        } else if($material->video_content!='') {
                                            echo '<a style="color:#fff;" class="btn btn-info btn_save matimg" onclick="view_study_material('.$material->id.')">
                                            <i class="fa fa-play-circle-o text-right"></i>
                                            </a>';
                                        } else if($material->audio_content!='') {
                                            echo '<a style="color:#fff;" class="btn btn-info btn_save matimg"  onclick="view_study_material('.$material->id.')">
                                            <i class="fa  fa-file-sound-o text-right"></i>
                                            </a>';
                                        } else if($material->youtube_notes!='') {
                                            echo '<a style="color:#fff;" class="btn btn-info btn_save matimg"  onclick="view_study_material('.$material->id.')">
                                            <i class="fa fa fa-youtube text-right"></i>
                                            </a>';
                                        }
                                        ?>
                                <!-- <img class="card-img-top" src="<?php echo base_url();?>assets/images/dashboard/course_lms.jpg" alt="Card image"> -->
                            </div>
                            <div class="card-body">
                                <!-- <h4 class="card-title">Chemistry</h4> -->
                                <!-- <p class="card-text">This course is one of several courses designed for Algebra Based AP Physics 1 and Regents Physics. In this course we will cover the topics of one and two dimensional motion.</p> -->
                                <h5><?php echo $material->material_name;?></h5>
                                <div class="card-text d-flex justify-space-between">
                                    <p><?php echo $material->subject_name?> </p>
                                    <p><?php 
                                    if($material->text_content!='') {
                                        echo 'Text';
                                    } else if($material->video_content!='') {
                                        echo 'Video';
                                    } else if($material->audio_content!='') {
                                        echo 'Audio';
                                    } else if($material->youtube_notes!='') {
                                        echo 'Youtube';
                                    }?>
                                        </p>
                                </div>
                                <!-- <div class="card-text d-flex justify-space-between lessons">
                                    <a href="#">Test</a>
                                    <a href="#">Practice</a>
                                </div> -->
                                <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php }else{?>
                        No Data Found!!
                    <?php } ?>

                </div>
            </div>