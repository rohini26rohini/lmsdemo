
<?php
                        //if(!empty($firstmod)) { 
                        ?><div class="title-header">&nbsp;&nbsp;<strong><?php echo $data['description'];?> </strong> </div>    
                        <br> 
                        <?php 
                        if($data['youtube_notes']!='') {
                            ?>
                        <iframe class="w-100 vid-section" src="<?php echo $data['youtube_notes'];?>"
                            frameborder="0"
                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                        <?php } else if($data['video_content']!=''){ ?>
                            <video id="video_player" height="400" width="100%" align="center" controls controlsList="nodownload">
                                <source src="<?php echo base_url($data['video_content']);?>" type="video/mp4">
                                Your browser does not support HTML5 video.
                            </video>
                        <?php } else if($data['audio_content']!=''){ ?>
                            <audio controls preload="auto" style="width: 100%;">
                                <source  src="<?php echo base_url($data['audio_content']);?>"  type="audio/mpeg">
                                Your browser does not support the audio element.
                                <source  src="<?php echo base_url($data['audio_content']);?>"  type="audio/wav">
                                Your browser does not support the audio element.
                            </audio>
                        <?php } else { ?>
                            <div style="width:100%">
                               
                                <div class="passage-view col-sm-12">
                                    <?php echo $data['text_content']; ?>
                                </div>
                            </div>  
                      <?php  } ?>
                        <?php //} ?>