<h3>Study Materials</h3>
<hr class="hrCustom">
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="Dboard">
            <div class="table-responsive">
                <table class="table table-bordered table-sm ExaminationList">
                    <thead>
                        <tr>
                            <th class="text-left">Material name</th>
                            <th class="text-left">Module</th>
                            <th>Type</th>
                            <th class="text-left">View</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // show($learningModule);
                        if(!empty($materials)) {
                            foreach($materials as $material){ //echo '<pre>';print_r($section); ?>
                                <tr>
                                    <td class="text-left"><?php echo $material->material_name;?></td>
                                    <td class="text-left"><?php echo $material->subject_name?></td>
                                    <td><?php 
                                    if($material->text_content!='') {
                                        echo 'Text';
                                    } else if($material->video_content!='') {
                                        echo 'Video';
                                    } else if($material->audio_content!='') {
                                        echo 'Audio';
                                    } else if($material->youtube_notes!='') {
                                        echo 'Youtube';
                                    }
                                    //echo $material->text_content?></td>
                                    <td class="text-left">
                                        <?php
                                        if($material->text_content!='') {
                                            echo '<a target="_blank" href="'.base_url().'user/Student/view_study_material/'.$material->id.'" class="learningmoduleDwld btn btn-info btn_save">
                                            <i class="fa fa-eye text-right"></i>
                                            </a>';
                                        } else if($material->video_content!='') {
                                            echo '<a style="color:#fff;" class="btn btn-info btn_save" onclick="view_study_material('.$material->id.')">
                                            <i class="fa fa-play-circle-o text-right"></i>
                                            </a>';
                                        } else if($material->audio_content!='') {
                                            echo '<a style="color:#fff;" class="btn btn-info btn_save"  onclick="view_study_material('.$material->id.')">
                                            <i class="fa fa-play-circle-o text-right"></i>
                                            </a>';
                                        } else if($material->youtube_notes!='') {
                                            echo '<a style="color:#fff;" class="btn btn-info btn_save"  onclick="view_study_material('.$material->id.')">
                                            <i class="fa fa-play-circle-o text-right"></i>
                                            </a>';
                                        }
                                        ?>
                                        
                                        <!-- <button type="submit" class="btn btn-info btn_save pull-right" id="download_pdf" style="margin-top:40px;">Download ID card</button> -->
                                    </td>
                                    <!-- <td><span class="dwdicon"><i class="fa fa-download text-right"></i></span></td> -->
                                </tr>
                        <?php } ?>
                    <?php }else{?>
                        <tr><th colspan="5" al="">No Data Found!!</th></tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
        <div class="Reg">
            
        </div>
    </div> -->
</div>
<div id="view_study_material" class="modal fade form_box modalCustom" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="body">
                <div class="row">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function view_study_material(id){
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('user/Student/show_study_material'); ?>",
            type: "post",
            data: {'id':id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.st == 1) {
                    $('#body').html(obj.html);
                    $('#title').html(obj.title);
                    $('#view_study_material').modal('toggle');
                }else{
                    $.toaster({priority:'warning',title:'Error',message:obj.message});
                }
                $(".loader").hide();
            },
            error: function () {
                $(".loader").hide();
                $.toaster({priority:'danger',title:'Error',message:'Technical error please try again later'});
            }
        });
    }  
</script>