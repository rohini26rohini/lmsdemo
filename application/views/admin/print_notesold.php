<html>
    <head>
        <style>
            body{
                border-radius: 10px;
            }
            @page {
                size: auto;
                odd-header-name: html_myHeader1;
                even-header-name: html_myHeader2;
                odd-footer-name: html_myFooter1;
                even-footer-name: html_myFooter2;
            }

            @page chapter2 {
                odd-header-name: html_Chapter2HeaderOdd;
                even-header-name: html_Chapter2HeaderEven;
                odd-footer-name: html_Chapter2FooterOdd;
                even-footer-name: html_Chapter2FooterEven;
            }

            @page noheader {
                odd-header-name: _blank;
                even-header-name: _blank;
                odd-footer-name: _blank;
                even-footer-name: _blank;
            }

            div.chapter2 {
                page-break-before: right;
                page: chapter2;
            }

            div.noheader {
                page-break-before: right;
                page: noheader;
            }

            .left-col {
                float: left;
                width: 50%;
            }

            /* .center-col {
            float: left;
            width: 50%;
            } */
            .right-col {
                float: right;
                width: 50%;
            }

            .mytitle {
                font-weight: bold;
                border: 1px solid black;
                border-radius: 10px;
                width: 25%;
                padding: 10px;
            }
        </style>
    </head>

    <body>
        <div class="row">
            <div class="left-col"></div>
            <div class="right-col"><img src="assets/images/ssc.png"></div>
        </div>

        <div class="row">
            <div class="left-col mytitle">RRB/SSC JE 2019</div>
            <div class="right-col"></div>
        </div>

        <div class="row">
            <div class="left-col "></div>
            <div class="right-col mytitle">
                <div  style="display: flex;margin-left: 20px;justify-content: space-between;align-items: center;align-content: center;">
                    <span style="display: flex;flex-direction: column;font-size: 24px;font-weight: 700;padding-left:15px;border-right: 1px solid #000;padding-right: 15px;">LM</span>
                    <span style="display: flex;margin-left: 10px;font-family:'Times New Roman', Times, serif; line-height: 100%;font-weight: 700;letter-spacing: 2px;font-size: 18px;">LEARNING
                        <br> MODULE
                    </span>
                    <span class="bg" style="font-size: 40px;background-color: #000;color: #fff;border-radius: 5px;padding: 2px 30px;font-family:'Times New Roman', Times, serif;font-weight: 900;position: relative;left: 1px;">4</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="left-col"></div>
            <div class="right-col ">
                <div style="position: absolute;width: auto;z-index: 999;transform: rotate(-90deg);left: -35px;top: 70px;">
                    <span style="font-size: 14px;font-weight: 600;">CONTENTS</span>
                </div>
                <div style="">
                    <ol style="font-size: 14px;padding-top: 20px;line-height: 24px;font-weight: 600;padding-left: 60px;">
                        <li>Simplification</li>
                        <li>Surds and Indices</li>
                        <li>Arithmetic and Geometric Progression</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="left-col"></div>
            <div class="right-col ">
                <p style="font-size: 14px;font-weight: 700;margin-bottom: 25px;">
                    <span style="border-bottom: 1px solid #000;line-height: 32px;display: block;font-size: 16px;">Direction School for SSC Examinations </span>
                    <span style="font-style: italic;font-weight: 700;display: block;font-size: 12px;">A venture of
                        Direction Group of Institutions Plt.Ltd.
                    </span>
                    Savithry Building, Bank Road
                    Kozhikode. Ph:0495-4040792
                </p>
            </div>
        </div>

        <div class="row">
            <div class="left-col" style="width: 10%">Name</div>
            <div class="right-col mytitle" style="border:1px solid black; width: 89%"> &nbsp; </div>
        </div><br>

        <div class="row">
            <div class="left-col" style="width: 10%">Batch</div>
            <div class="right-col mytitle" style="border:1px solid black; width: 50%"> &nbsp; </div>
        </div>

        <div class="row">
            <div class="left-col" style="width: 10%">Signature</div>
        </div>

        <div style="border:1px solid #e4e4e4;">
            <table style="width:100%; font-family: 'Open Sans', sans-serif;">
                <tr>
                    <td>
                    <?php  $i=1; 
                    foreach($questionArr as $question){  ?>
                        <ul>
                            <li  style="float:left;">
                                <p style="margin-bottom: 20px;margin-top: 20px; font-size:190px;">
                                    <?php echo $i;?>
                                    <?php echo $question['question'];?>
                                </p>
                                <ul type="none" style="list-style: none;margin: 0;padding: 0;">
                                    <li type="none" style="list-style: none;margin: 0;padding: 0;float: left;margin-bottom: 10px;font-family: 'Open Sans', sans-serif;width: 50%;">
                                        <span style="font-family: 'Open Sans', sans-serif; font-size:80px;">a)</span>
                                        <span style="font-family: 'Open Sans', sans-serif; font-size:80px;"><?php echo $question['question_option_a'];?></span>
                                    </li>
                                    <li type="none" style="list-style: none;margin: 0;padding: 0;float: left;margin-bottom: 10px;font-family: 'Open Sans', sans-serif;width: 50%;">
                                        <span style="font-family: 'Open Sans', sans-serif; ">b)</span>
                                        <span style="font-family: 'Open Sans', sans-serif;"><?php echo $question['question_option_b'];?></span>
                                    </li>
                                    <li type="none" style="list-style: none;margin: 0;padding: 0;float: left;margin-bottom: 10px;font-family: 'Open Sans', sans-serif;width: 50%;">
                                        <span style="font-family: 'Open Sans', sans-serif;">c)</span>
                                        <span style="font-family: 'Open Sans', sans-serif;"><?php echo $question['question_option_c'];?></span>
                                    </li>
                                    <li type="none" style="list-style: none;margin: 0;padding: 0;float: left;margin-bottom: 10px;font-family: 'Open Sans', sans-serif;width: 50%;">
                                        <span style="font-family: 'Open Sans', sans-serif;">d)</span>
                                        <span style="font-family: 'Open Sans', sans-serif;"><?php echo $question['question_option_d'];?></span>
                                    </li>
                                </ul>
                            </li>
                            <div style="clear:both;"></div>
                        </ul>
                    <?php $i++; } ?>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>