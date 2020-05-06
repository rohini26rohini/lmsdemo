
        <div class="abtbanner BgGrdOrange ">
            <div class="container maincontainer">
                <h3>How to Prepare</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('direction-school-for-ssc-examinations');?>">Direction School for SSC Examinations </a></li>
                    <li class="breadcrumb-item active" aria-current="page">How to Prepare</li>
                </ol>
            </div>
        </div>
        <section class="inner_page_wrapper howto">
        <div class="container maincontainer">
            <div class="row ">
                <div class="col-xl-12 col-lg-12 col-md-4s col-sm-12 col-12 ">
                    <h4 class="title">HOW TO PREPARE FOR SSC CGL & CHSL</h4>
                    <!-- <img src="images/about_img.jpg" class="img-fluid img_about "> -->
                    <?php 
                        $i =1;
                        foreach ($prepareArr as $prepare):
                        ?>
                        <p>
                        <?php echo $prepare['content']?>

                        <!-- SSC CGL and CHSL exams have similar patterns. Preparing for SSC CGL will automatically equip you
                        for
                        SSC CHSL as well. Total time you get for solving the Tier-I paper is 60 minutes. On an average,
                        36 seconds
                        per question. There is no sectional time limit and sectional cut offs. -->
                    </p>
                    <!-- <h4 class="title">QUANTITATIVE APTITUDE</h4>
                    <p>The most difficult and time-consuming part of the exam.
                        Learn all the important formulae by heart and time yourself while practicing.
                        Use unconventional approaches to reduce the time taken per question. Think out of
                        the box.
                        Solve as many different types of questions and topics as you can to know your strong
                        and weak areas.
                        Solve at least 200 questions a day to improve your speed.
                        Make use of the options to arrive at the solution.
                        Identify the key link in the question and unlock the question.
                        In the exam, don't spend more than 25 minutes to this section.
                    </p>
                    <h4 class="title">ENGLISH LANGUAGE</h4>
                    <p>Main topics to emphasize are Vocabulary, Grammar and Comprehension.
                        Comprehension: Practice at least 5 comprehension passages daily. The trick here is
                        to read the
                        questions before you read the passage, as then while reading the passage you will
                        know exactly what
                        you are looking for.
                        Vocabulary: Whenever you come across a new word, check the meaning of the word and
                        try to reuse it
                        and its synonyms and antonyms in sentences. Grammar: Just like vocabulary, your
                        grammar will also
                        improve if you read more sincerely. Try to quickly scan across
                        newspapers like 'The Hindu' daily.-</p>
                    <h4 class="title"> GENERAL AWARENESS</h4>
                    <p>
                        The most scoring section of the exam.
                        If you prepare this section thoroughly now, it will not take more than 10 minutes of
                        your time during the
                        exam. You can utilize the time you save here for doing calculations in Quantitative
                        Aptitude.
                        Instead of cramming mindlessly, make notes and use mnemonics to remember facts, a
                        chronology of
                        events, cause and effect, etc.
                        Practice at least 20-30 questions of GA everyday within 15 minutes.
                        When it comes to General Awareness, revision is the key to success.
                    </p>
                    <h4 class="title">GENERAL INTELLIGENCE</h4>
                    <p>While practicing, your aim is to be able to attempt at least 20 questions in 18-20 minutes
                        with
                        reasonable accuracy. In the exam also, try to solve this section in not more than 20
                        minutes.</p>
                    <h4 class="title">DAILY STRATEGY</h4>
                    <ul class="abtlist">
                        <li>Solve at least one mock paper every day.</li>
                        <li>Time yourself section-wise.</li>
                        <li>After you solve a mock test, review it in and out. Analyze your errors, time taken, accuracy
                            and approach.</li>
                        <li> Try different time-management strategies as to which section to attempt first and adopt
                            the one that suits you the best.</li>
                        <li>Remember that there are no sectional time limits and no sectional cut off. So your job is to
                            simply maximize your score however you can.</li>
                    </ul> -->
                    <?php $i++; endforeach; ?>

                </div>
            </div>
        </div>
    </section>
    </body>
</html>