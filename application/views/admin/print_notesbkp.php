
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        
        <style>
            @page{
                size: 10in 11in;
            }
            </style>
    </head>
    <body>
        <div style="padding:0px 50px;border:1px solid #e4e4e4;width:650px;margin:auto;">
            <table style="width:100%; font-family: 'Open Sans', sans-serif;">
                <tr>
                    <td style="width:50%"></td>
                    <td><img src="images/ssc.png" style="text-align:right"></td>
                </tr>
                <tr>
                    <td style="padding: 50px 0px;">
                        <span
                            style="border: 1px solid #000;border-radius: 5px;padding: 7px;font-weight: 900;font-size: 20px;">SSC
                            CGL TIER
                            I MISSION+ 2019
                        </span>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <span
                            style="display: inline-block;font-size: 20px;background-color: #000;color: #fff;border-radius: 5px;text-align: center;font-weight: bold;padding: 5px 15px;">QA-S
                        </span>
                        <div style="border-radius: 5px;border: 1px solid #000;line-height: 50px;position: relative;">
                            <img src="images/arrow.png"
                                style="position: absolute;background: #fff;border-radius: 100%;width: 12px;height: 12px;border: 1px solid #000;padding:5px;text-align: center;left: -10px;top: 0;bottom: 0;margin: auto;">
                            <div style="display: flex;margin-left: 20px;justify-content: space-between;align-items: center;align-content: center;">
                                <span
                                    style="display: flex;flex-direction: column;font-size: 24px;font-weight: 700;padding-left:15px;border-right: 1px solid #000;padding-right: 15px;">LM
                                </span>
                                <span
                                    style="display: flex;margin-left: 10px;font-family:'Times New Roman', Times, serif; line-height: 100%;font-weight: 700;letter-spacing: 2px;font-size: 18px;">LEARNING
                                    <br> MODULE
                                </span>
                                <span class="bg"
                                    style="font-size: 40px;background-color: #000;color: #fff;border-radius: 5px;padding: 2px 30px;font-family:'Times New Roman', Times, serif;font-weight: 900;position: relative;left: 1px;">6
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="position: relative;padding-top: 40px;">
                        <div
                            style="position: absolute;width: auto;z-index: 999;transform: rotate(-90deg);left: -35px;top: 70px;">
                            <span style="font-size: 14px;font-weight: 600;">CONTENTS</span>
                        </div>
                        <div>
                            <ol style="font-size: 14px;padding-top: 20px;line-height: 24px;font-weight: 600;padding-left: 60px;">
                                <li>Simplification</li>
                                <li>Surds and Indices</li>
                                <li>Arithmetic and Geometric Progression</li>
                            </ol>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <span style="border-left: 2px solid #000;height: 80px;display: block;margin: 50px 0;"></span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <p style="font-size: 14px;font-weight: 700;margin-bottom: 25px;">
                            <span  style="border-bottom: 1px solid #000;line-height: 32px;display: block;font-size: 16px;">Direction
                                School for SSC Examinations 
                            </span>
                            <span style="font-style: italic;font-weight: 700;display: block;font-size: 12px;">A venture of
                                Direction Group of Institutions Plt.Ltd.
                            </span>
                            Savithry Building, Bank Road
                            Kozhikode. Ph:0495-4040792
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top: 20px;">
                        <span style="line-height: 38px;">Name </span>
                        <span
                            style="border: 1px solid #000;border-radius: 5px;font-weight: 900;width: 80%;display: inline-block; float: right; padding: 20px;">
                        </span>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td style="padding: 20px 0;">
                        <span style="line-height: 38px;">Batch </span>
                        <span
                            style="border: 1px solid #000;border-radius: 5px;font-weight: 900;width: 60%;display: inline-block; float: right; padding: 20px;">
                        </span>
                    </td>
                    <td style="text-align: right;">Signature</td>
                </tr>
            </table>
            <div style="clear:both;"></div>
        </div>













        <div style="border:1px solid #e4e4e4;">
            <table style="width:100%; font-family: 'Open Sans', sans-serif;">
                <tr>
                    <td>
                    <?php 
                $i=1; 
                foreach($questionArr as $question){ 
                ?>
                        <!-- <ul>
                            <li  style="float:left;">
                                <p style="font-family: 'Open Sans', sans-serif;margin-bottom: 20px;margin-top: 20px;">
                                <?php echo $i;?>
                                <?php echo $question['question'];?>
                                </p>
                                <ul type="none" style="list-style: none;margin: 0;padding: 0;">
                                    <li
                                        style="list-style: none;margin: 0;padding: 0;float: left;margin-bottom: 10px;font-family: 'Open Sans', sans-serif;width: 50%;">
                                        <span style="font-family: 'Open Sans', sans-serif;">a)</span>
                                        <span style="font-family: 'Open Sans', sans-serif;"><?php echo $question['question_option_a'];?></span>
                                    </li>
                                    <li
                                        style="list-style: none;margin: 0;padding: 0;float: left;margin-bottom: 10px;font-family: 'Open Sans', sans-serif;width: 50%;">
                                        <span style="font-family: 'Open Sans', sans-serif;">b)</span>
                                        <span style="font-family: 'Open Sans', sans-serif;"><?php echo $question['question_option_b'];?></span>
                                    </li>
                                    <li
                                        style="list-style: none;margin: 0;padding: 0;float: left;margin-bottom: 10px;font-family: 'Open Sans', sans-serif;width: 50%;">
                                        <span style="font-family: 'Open Sans', sans-serif;">c)</span>
                                        <span style="font-family: 'Open Sans', sans-serif;"><?php echo $question['question_option_c'];?></span>
                                    </li>
                                    <li
                                        style="list-style: none;margin: 0;padding: 0;float: left;margin-bottom: 10px;font-family: 'Open Sans', sans-serif;width: 50%;">
                                        <span style="font-family: 'Open Sans', sans-serif;">d)</span>
                                        <span style="font-family: 'Open Sans', sans-serif;"><?php echo $question['question_option_d'];?></span>
                                    </li>
                                </ul>
                            </li>
                            <div style="clear:both;"></div>
                            </ul> -->
                            <ul>
                                <li>Test</li>
                </ul>
                        <?php $i++; } ?>

                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>