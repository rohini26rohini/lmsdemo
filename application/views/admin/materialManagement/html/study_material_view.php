<!-- <form id="filter_form" method="post" action="<?php echo base_url('backoffice/download-study-material');?>"> -->
<form id="filter_form" method="post" action="download-study-material/<?php echo $data['id'];?>">

<?php if(!empty($data['description'])){ ?>
<div class="row">
<input type="hidden"  class ="exclude-status" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
<input type="hidden" id="id" name="id" value="<?php echo $data['id'];?>"/>

    <div class="col-sm-12">
        <div class="title-header">
            &nbsp;&nbsp;Description
        </div>
        <div class=' col-sm-12'>
            <?php echo $data['description']; ?>
            <br>
            <br>
        </div>
    </div>
</div>
<?php } ?>
<?php if(!empty($data['text_content'])){ ?>
<div class="row">
    <div class="col-sm-12">
        <div class="title-header">
            &nbsp;&nbsp;Study note
            <!-- <button class="btn btn-default option_btn pull-right" onclick="download_study_material(<?php echo  $data['id'];?>);"> -->
            <button class="btn btn-default option_btn pull-right">
                <i class="fa fa-download"> Download PDF</i>
            </button>
        </div>
        <div class='passage-view col-sm-12'>
            <!-- <h3>sssss</h3> -->
            <?php echo $data['text_content']; ?>
        </div>
    </div>
</div>
<?php } ?>
<?php if(!empty($data['video_content'])){ ?>
<div class="row">
    <div class="col-sm-6">
        <div class="title-header">&nbsp;&nbsp;Video lecture</div>
        <video id="video_player" height="200" width="100%" align="center" controls controlsList="nodownload">
            <source src="<?php echo base_url($data['video_content']);?>" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
        <!-- <div id="buttonbar">
            <button id="restart" onclick="restart();">[]</button> 
            <button id="rew" onclick="skip(-10)">&lt;&lt;</button>
            <button id="play" onclick="vidplay()">&gt;</button>
            <button id="fastFwd" onclick="skip(10)">&gt;&gt;</button>
        </div>   
        <script type="text/javascript">
            function vidplay() {
            var video = document.getElementById("video_player");
            var button = document.getElementById("play");
            if (video.paused) {
                video.play();
                button.textContent = "||";
            } else {
                video.pause();
                button.textContent = ">";
            }
            }

            function restart() {
                var video = document.getElementById("Video1");
                video.currentTime = 0;
            }

            function skip(value) {
                var video = document.getElementById("Video1");
                video.currentTime += value;
            }      
        </script> -->
    </div>
<?php } ?>
<?php if(!empty($data['audio_content'])){ ?>
    <div class="col-sm-6">
        <div class="title-header">&nbsp;&nbsp;Audio lecture</div>
        
    </div>
</div>
<?php } ?>

<?php if(!empty($data['youtube_notes'])){ ?>
    <div class="col-sm-12">
        <div class="title-header">&nbsp;&nbsp;youtube lecture</div>
        <iframe  width="100%" height="315" style="width:100%"
        src="<?php echo $data['youtube_notes'];?>" allowfullscreen>
        </iframe>
    </div>
</div>
<?php } ?>
</form>