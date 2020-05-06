
        <div class="abtbanner BgGrdOrange ">
            <div class="container maincontainer">
                <h3>How to Prepare</h3>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('direction-school-for-entrance-examinations');?>">Direction School for entrance examinations </a></li>
                    <li class="breadcrumb-item active" aria-current="page">How to Prepare</li>
                </ol>
            </div>
        </div>
        <section class="inner_page_wrapper pschowto howto">
            <div class="container maincontainer">
                <div class="row ">
                    <div class="col-xl-12 col-lg-12 col-md-4s col-sm-12 col-12 ">
                        <h4 class="title">How to prepare for Entrance Exams</h4>
                        <!-- <img src="images/about_img.jpg" class="img-fluid img_about "> -->
                        <?php 
                        $i =1;
                        foreach ($prepareArr as $prepare):
                        ?>
                        <p>
                        <?php echo $prepare['content']?>
                            <!-- Kerala Public Service Commission has published the University Assistant exam date on 15 th June
                            2019.
                            The cutoff mark for the previous University exam was 72.67.
                        </p>
                        <p>To accomplish your goals, start your studies with systematic study plan.</p>
                        <p>Make a strategy to complete the syllabus just before time. Give equal importance to all the
                            subjects.
                            Questions can be asked from every corner of the topic. You can expect questions from 10 distinct
                            topics.</p>
                        <ul class="abtlist">
                            <li>Facts about India</li>
                            <li>Facts about Kerala</li>
                            <li>General Science</li>
                            <li>Quantitative Aptitude</li>
                            <li>Mental Ability and Test of Reasoning</li>
                            <li>IT &amp; Cyber Laws</li>
                            <li>General English</li>
                            <li>Indian Constitution</li>
                            <li>Current Affairs</li>
                            <li>Malayalam</li>
                        </ul>
                        <p>10 questions can be expected from each of these topics.</p>
                        <p>Try to solve previous year question papers. This will definitely help you; you can have an idea
                            about the
                            question patterns and also figure out the common questions.</p>
                        <p>Try to attempt mock tests in an examination environment and complete previous year question
                            papers
                            within the stipulated time. By practicing the previous year question papers, you can excel in
                            your time
                            management skills.-->
                        </p>
                        <?php $i++; endforeach; ?>
 
                        <!-- <h4 class="title">Details of upcoming exam</h4> -->
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>