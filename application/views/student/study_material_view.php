<form id="filter_form" method="post" action="download-study-material/<?php echo $data['id'];?>">

<?php if(!empty($data['description'])){ ?>
<div class="row">
<input type="hidden"  class ="exclude-status" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
<input type="hidden" id="id" name="id" value="<?php echo $data['id'];?>"/>
</div>
<?php } ?>


<?php if(!empty($data['text_content'])){ ?>
    <div style="width:100%">
        <div class="title-header">&nbsp;&nbsp;Study notes  </div>    
        <br> 
        <div class="passage-view col-sm-12">
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
        <!-- <audio controls preload="auto">
  <source src="https://api.twilio.com/2010-04-01/Accounts/ACaa255ecd514b787c2f0358486f07a106/Recordings/REf5c1e1f1e048894182132ba0ce763183.wav">
</audio> -->
        <audio controls preload="auto">
            <source  src="<?php echo base_url($data['audio_content']);?>"  type="audio/mpeg">
            Your browser does not support the audio element.
            <source  src="<?php echo base_url($data['audio_content']);?>"  type="audio/wav">
            Your browser does not support the audio element.
        </audio>
    </div>
</div>
<?php } ?>

<?php if(!empty($data['youtube_notes'])){ ?>
    <div style="width:100%">
        <div class="title-header">&nbsp;&nbsp;Video lecture echo </div>
      
                <!-- <iframe  width="100%" height="315" style="width:100%"
        src="https://www.youtube.com/watch?v=HNIgsVTei2o" allowfullscreen>
        </iframe> -->
        <iframe  width="100%" height="315" style="width:100%"
        src="<?php echo $data['youtube_notes'];?>" allowfullscreen>
        </iframe>
    </div>
</div>
<?php } ?>
</form>