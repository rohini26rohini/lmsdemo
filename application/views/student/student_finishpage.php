
<div class="clearfix"></div>
    <div  class="series-wapper quiz">
        <div class="container">
          <div class="series-wapper-header d-flex justify-space-between align-self  mb-30">
                <h3 class="cus-title">Finish Exam <span></span></h3>
                <div class="d-flex align-items-center">
                    <a  href="<?php echo base_url();?>student-dashboard"  class="btn"> <i class="fa fa-long-arrow-left"></i> Back to Course </a>
                </div>
            </div>
       <?php if($result_publish == 1){ ?>
            <div class="quiz-body qz_item">
            <div class="row">
            <div class="col-md-12">
                    <div class="card dash-box-shadow">
                        <div class="card-body pzero">
                            <!-- <h4 class="card-title">Chemistry</h4> -->
                            <!-- <p class="card-text">This course is one of several courses designed for Algebra Based AP Physics 1 and Regents Physics. In this course we will cover the topics of one and two dimensional motion.</p> -->
                            <h5>Successfully finished exam</h5>
                            <div class="card-text lessons finished">
                                <div class="totQues d-flex">
                                    <h6>You can find the result later in your dashboard</h6>
                                </div>
                              
                            </div>

                            <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
           <?php } else {?>
             <div class="quiz-body qz_item">
                <div class="row">
                <div class="col-md-12">
                        <div class="card dash-box-shadow">
                            <div class="card-body pzero"> <?php //print_r($exam); print_r($examgrade);?>
                                <!-- <h4 class="card-title">Chemistry</h4> -->
                                <!-- <p class="card-text">This course is one of several courses designed for Algebra Based AP Physics 1 and Regents Physics. In this course we will cover the topics of one and two dimensional motion.</p> -->
                                <h5>Successfully finished exam</h5>
                                <div class="card-text lessons finished">
                                    <div class="totQues d-flex">
                                        <p>Total question</p><span><?php echo $questioncount->count?></span>
                                    </div>
                                    <div class="corrAns d-flex">
                                        <p>correct answer</p><span><?php echo $exam->correct?></span>
                                    </div>
                                    <div class="grad d-flex">
                                        <p>grade</p><span class="text-danger"><?php echo (!empty($examgrade) && $examgrade->grade!='')?$examgrade->grade:'';?></span>
                                    </div>
                                </div>

                                <!-- <a href="#" class="btn btn-primary stretched-link">See Profile</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
                       
        </div>
    </div>
    <script>
         $("#questionform").validate({
        
        submitHandler: function(form) {
             $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>user/Student/add_question_details',
                type: 'POST',
                data: $("#questionform").serialize(),
                success: function(response) {

                    var obj=JSON.parse(response);

                      if (obj.st == 1)
                      {
                         $('#questionform').each(function(){ this.reset();});

                        $.toaster({priority:'success',title:'Success',message:obj.message});

                      }
                    else if (obj.st == 0)
                    {
                         $.toaster({priority:'danger',title:'INVALID',message:obj.message});
                    }

                    $(".loader").hide();
                }
            });
        }
    });
        $('.circlechart').circlechart();
        $(document).ready(function () {

            var qzbox = document.getElementsByClassName("qz_item");
                for (var i = 0; i < qzbox.length; i++) 
                {
                     if(i===0)
                     {
                        qzbox[i].style.display="block"; 
                     }
                     else
                     {
                        qzbox[i].style.display="none";
                     }
                }

            $(".next_btn").on('click', function (event) {
                event.stopPropagation();
                event.stopImmediatePropagation();
                var index = $(".next_btn").index(this);
                index+=1;
                var qzbox = document.getElementsByClassName("qz_item");
                for (var i = 0; i < qzbox.length; i++) 
                {
                     if(index===i)
                     {
                        qzbox[i].style.display="block"; 
                     }
                     else
                     {
                        qzbox[i].style.display="none";
                     }
                }

            });

            $(".pre_btn").on('click', function (event) {
                event.stopPropagation();
                event.stopImmediatePropagation();
                var index = $(".pre_btn").index(this);
                if(index===0)
                {
                    index=0;
                }
                else
                {
                    index-=1;
                }
                
                var qzbox = document.getElementsByClassName("qz_item");
                for (var i = 0; i < qzbox.length; i++) 
                {
                     if(index===i)
                     {
                        qzbox[i].style.display="block"; 
                     }
                     else
                     {
                        qzbox[i].style.display="none";
                     }
                }

            });
        });

       
    </script>
