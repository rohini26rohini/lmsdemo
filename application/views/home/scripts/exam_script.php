<script>
var nextQuestion = <?php echo $this->session->userdata('sample_currentquestionnumber'.$school);?>;
var questions = <?php if(!empty($questions)){echo $questions;} ?>;
$(document).ready(function(){
    var examtime = <?php echo $this->session->userdata('sample_currenttime'.$school); ?>;
    var countDownDate = new Date().getTime() + (1000 * examtime);
    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)) * 60;
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)) + hours;
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        if (seconds % 10 == 0) {
            var school = <?php echo $school; ?>;
            var remainingtime = (minutes * 60) + seconds;
            $.ajax({
                url: base_url + 'Home/update_timer',
                type: "POST",
                data: {
                    time: remainingtime,
                    school: school,
                    ci_csrf_token: csrfHash
                },
                success: function(data) {}
            });
        }
        if (distance <= 1000) {
            clearInterval(x);
            submit_exam();
        }
        document.getElementById("timer").innerHTML = minutes + " : " + seconds;
        var progressbar = ((minutes*60)+seconds)*100/<?php echo $this->session->userdata('sample_currentMaxtime'.$school); ?>;
        $('#progressbar').prop('style','width:'+progressbar+'%;');
    }, 1000);

    $("#nextQuestion").click(function(){
        nextQuestion++;
        $("#nextQuestion").prop('disabled',true);
        if(nextQuestion>=10){submit_exam();} 
        if(nextQuestion==9){$("#nextQuestion").html('Submit');} 
        $(".loader").show();
        jQuery.ajax({
            url: "<?php echo base_url('Home/nextQuestion'); ?>",
            type: "post",
            data: {
                question: questions[nextQuestion-1],
                answer: $("input[name='optradio']:checked").val(),
                school: <?php echo $school; ?>,
                nextQuestion: questions[nextQuestion],
                nextQuestionNumber: nextQuestion,
                ci_csrf_token: csrfHash
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.st == 1) {
                    $('#nextQuestion').prop('disabled', false);  
                    if(obj.data != ''){
                        
//                console.log(obj);
                        $(".question").html(nextQuestion+1 + '.Question');
                        $(".question_index").html(obj.data.question);
                        $("#option1").html(obj.data.opt1);
                        $("#option2").html(obj.data.opt2);
                        $("#option3").html(obj.data.opt3);
                        $("#option4").html(obj.data.opt4);
                        $("input[name='optradio']:checked").prop('checked',false);
                    }
                }else{
                    $('#nextQuestion').prop('disabled', false);   
                }
                $(".loader").hide();
            },
            error: function () {
                $(".loader").hide();
                $('#nextQuestion').prop('disabled', false);   
            }
            //Your code for AJAX Ends
        });
    });
    if(nextQuestion==9){$("#nextQuestion").html('Submit');} 
});

function submit_exam(){
    $(".loader").show();
    redirect('exam-result?id=<?php echo $school; ?>');
    // jQuery.ajax({
    //     url: "<?php echo base_url('/Home/exam_submit'); ?>",
    //     type: "GET",
    //     data: [],
    //     success: function (data) {
    //         window.location.reload();
    //     }
    //     //Your code for AJAX Ends
    // });
}
</script>