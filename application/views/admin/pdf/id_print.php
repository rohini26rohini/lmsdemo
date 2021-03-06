<!DOCTYPE html>
<html lang="en">
<?php 
    $color='';
    if($studentcard['school_code']=='I'){$color='#d01f2f';}
    if($studentcard['school_code']=='N'){$color='#E15C22';}
    if($studentcard['school_code']=='P'){$color='#6E9E7A';}
    if($studentcard['school_code']=='S'){$color='#AFBC34';}
    if($studentcard['school_code']=='A'){$color='#009FC7';}
?>

<body style="background: #fff;float: left;width: 100%;">
    <div style="float: left;width: 100%;">
        <div style="display:inline-block;width:100%;float:left;position:relative;">
            <div style="background-image:url('./inner_assets/images/bg.png');max-width:350px;margin:auto;text-align:center;background-size:cover;background-position: center;position:relative;background-repeat:no-repeat;float:left;width:350px;text-align:center;display:block;border:1px solid #8a8a8a;padding-bottom:20px;padding-top:30px; ">
                <div class="float:left;width:100%;">
                    <div style="height: 20px; background: <?php echo $color;?>; width: 300px; margin: auto; border-radius: 0 0 50% 50%;max-width: 80%;float:left;margin-top:-30px;"></div>
                </div>
                <div class="float:left;width:100%;display:block">
                    <img src="./inner_assets/images/logo_inner.png" style="width:150px;margin:30px auto;text-align:center;">
                </div>
                <div style="position:relative!important;">

                    <div style="height: 150px;width: 150px;background-position: top;background-size: cover;margin: auto;border: 4px solid #00add8;border-radius: 50%;margin-bottom :60px;background-repeat:no-repeat;background-image: url('<?php echo FCPATH.$studentArr['student_image']; ?>');max-width: 100%;display:block; position:relative!important;"></div>
                </div>
                <div class="float:left;width:100%;">
                    <h1 style="font-size: 20px;font-family:bold;margin-bottom:0;float:left;">
                        <?php echo $studentArr['name'];?>
                        <br>
                        <small style="color: grey;font-size: 16px;margin-bottom: 0;font-family: regular;float:left;display:block;width:100%;">ID Number:
                            <?php echo $studentArr['registration_number'];?>
                        </small>
                    </h1>
                </div>
                <div class="float:left;width:100%;">

                    <h6 style="color: #000;font-family: bold;font-size: 14px;margin-top: 10px;margin-bottom: 30px;float:left;width:100%;">
                        <?php echo $studentcard['class_name'];?><br>
                        <small style="margin:5px 0;display:block;color:#454f59;font-family:s-bold;font-size:80%;font-weight:400;float:left;"><?php echo $studentcard['school_name'];?></small>
                    </h6>

                </div>
                <div class="float:left;width:100%;">
                    <div style="height: 20px; background: <?php echo $color;?>; width: 300px; margin: auto; border-radius:50% 50% 0 0;max-width: 80%;float:left;margin-bottom:-60px;"></div>
                </div>
            </div>
        </div>
        <pagebreak>
            <div style="display:inline-block;width:100%;float:left;position:relative;">
                <div style="background-image: url('./inner_assets/images/bg.png');max-width:350px;margin:auto;text-align:center;background-size:cover;background-position: top;position:relative;background-repeat:no-repeat;float:left;width:350px;text-align:center;display:block;border:1px solid #8a8a8a;padding-bottom:20px;padding-top:30px;">
                    <div class="float:left;width:100%;">
                        <div style="height: 20px; background: <?php echo $color;?>; width: 300px; margin: auto; border-radius: 0 0 50% 50%;max-width: 80%;float:left;margin-top:-30px;margin-bottom:30px;"></div>
                    </div>
                    <div class="float:left;width:100%;">
                        <table style="width: 100%;text-align: left;float:left;">
                            <tr>
                                <th style="width: 120px;font-family: bold;height: 30px;font-size: 14px;">Contact No.</th>
                                <td style="font-family: s-bold;font-size: 14px;">:</td>
                                <td style="font-family: s-bold;font-size: 14px;">
                                    <?php echo $studentArr['contact_number'];?>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 120px;font-family: bold;height: 30px;font-size: 14px;">Blood Group</th>
                                <td style="font-family: s-bold;font-size: 14px;">:</td>
                                <td style="font-family: s-bold;font-size: 14px;"><?php echo $studentArr['blood_group'];?></td>
                            </tr>
                        </table>
                    </div>
                    <div style="position: relative;margin: 30px 0;float: left;width: 100%;float:left;">
                        <div style="background-color: #00add8;color: #fff;margin: auto;padding: 5px;font-family: s-bold;top: 0;bottom: 0;height: 20px;">
                            <span> If found please inform : +0495 4040796</span>
                        </div>
                    </div>
                    <table style="width: 100%;text-align: left;float:left;padding:15px;">
                        <tr>
                            <td style="font-family: s-bold;font-size: 14px;vertical-align:top;height: 115px;"> <img src="./inner_assets/images/pdf/general/location.png" style="width: 25px;" /></td>
                            <td style="font-family: s-bold;font-size: 13px;padding-left:15px;vertical-align:top;">Direction Group of Institutions Pvt LTD
							IVth Floor,Skytower building, Bank road,
							Mavoor Road Junction, Calicut, 673001, Kerala, India</td>
                        </tr>
                        <tr>
                            <td style="font-family: s-bold;font-size: 14px;vertical-align:top;height: 45px;"><img src="./inner_assets/images/pdf/general/email.png" style="width: 25px;" /> </td>
                            <td style="font-family: s-bold;font-size: 14px;padding-left:15px;vertical-align:top;">info@direction.org.in</td>
                        </tr>
                        <tr>
                            <td style="font-family: s-bold;font-size: 14px;vertical-align:top;height: 45px;"> <img src="./inner_assets/images/pdf/general/mob.png" style="width: 25px;" /> </td>
                            <td style="font-family: s-bold;font-size: 14px;padding-left:15px;vertical-align:top;">0495 4040796</td>
                        </tr>
                        <tr>
                            <td style="font-family: s-bold;font-size: 14px;vertical-align:top;height: 45px;"> <img src="./inner_assets/images/pdf/general/web.png" style="width: 25px;" /> </td>
                            <td style="font-family: s-bold;font-size: 14px;padding-left:15px;vertical-align:top;">www.direction.school</td>
                        </tr>
                    </table>

                    <div class="float:left;width:100%;">
                        <div style="height: 20px; background: <?php echo $color;?>; width: 300px; margin: auto; border-radius:50% 50% 0 0;max-width: 80%;float:left;margin-bottom:-60px;"></div>
                    </div>
                </div>
            </div>


    </div>

</body>

</html>
