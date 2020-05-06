<style>
    @font-face {
        font-family: "light";
        src: url(fonts/OpenSans-Light.ttf)
    }

    @font-face {
        font-family: "regular";
        src: url(fonts/OpenSans-Regular.ttf)
    }

    @font-face {
        font-family: "bold";
        src: url(fonts/OpenSans-Bold.ttf)
    }

    @font-face {
        font-family: "e-bold";
        src: url(fonts/OpenSans-ExtraBold.ttf)
    }


    @font-face {
        font-family: "s-bold";
        src: url(fonts/OpenSans-SemiBold.ttf)
    }

</style>

    <div style="float: left;width: 100%;">
        <div style="display:inline-block;width:50%;float: left;">
            <div style="background-image: url('<?php echo base_url('inner_assets'); ?>/images/bg.png');box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);max-width: 300px;margin: auto;text-align: center;background-size: cover;background-position: center;position: relative;overflow: hidden;padding: 60px 30px;">
                <div style="position: absolute;content: '';right: 0;left: 0;height: 40px; background: #f29120; width: 300px; margin: auto; border-radius: 30px;bottom: -20px;max-width: 80%;"></div>
                <div style="position: absolute;content: '';right: 0;left: 0;height: 40px; background: #0a5491; width: 300px; margin: auto; border-radius: 30px;top: -20px;max-width: 80%;"></div>
                <img src="<?php echo base_url('inner_assets'); ?>/images/logo_inner.png"  style="width: 150px;margin: auto;">
                <div style="background-image: url('<?php echo base_url($staffArr['staff_image']);?>');height: 150px;width: 150px;background-position: center;background-size: cover;margin: 30px auto;border: 4px solid #00add8;border-radius: 50%;">

                </div>

                <h1 style="font-size: 20px;font-family:bold;margin-bottom: .5rem;"><?php echo $staffArr['name'];?></h1>
                <p style="color: grey;font-size: 16px;margin-bottom: 5px;font-family: regular">ID Number: <?php echo $staffArr['registration_number'];?></p>
                <h6 style="color: #000;font-family: bold;font-size: 14px;margin-top: 10px;margin-bottom: 0px;border-bottom: 2px solid #0a5491;padding-bottom: 5px;margin: auto;"><?php echo $staffArr['role_name'];?>
                    <!-- <small style="margin: 5px 0;display: block;color: #454f59;font-family: s-bold;font-size: 80%;font-weight: 400;">Direction IAS Study Circle</small> -->
                </h6>
            </div>
        </div>
        <div style="display:inline-block;width:50%;">
            <div style="background-image: url('<?php echo base_url('inner_assets'); ?>/images/bg.png');box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);max-width: 300px;margin: auto;text-align: center;background-size: cover;background-position: center;position: relative;overflow: hidden;padding: 60px 30px;">
                <div style="position: absolute;content: '';right: 0;left: 0;height: 40px; background: #f29120; width: 300px; margin: auto; border-radius: 30px;bottom: -20px;max-width: 80%;"></div>
                <div style="position: absolute;content: '';right: 0;left: 0;height: 40px; background: #0a5491; width: 300px; margin: auto; border-radius: 30px;top: -20px;max-width: 80%;"></div>
                <table style="width: 100%;text-align: left;">
                    <tr>
                        <th style="width: 90px;font-family: bold;height: 30px;font-size: 14px;">Contact No.</th>
                        <td style="font-family: s-bold;font-size: 14px;">:</td>
                        <td style="font-family: s-bold;font-size: 14px;"><?php echo $staffArr['mobile'];?></td>
                    </tr>
                    <tr>
                        <th style="width: 90px;font-family: bold;height: 30px;font-size: 14px;">Blood Group</th>
                        <td style="font-family: s-bold;font-size: 14px;">:</td>
                        <td style="font-family: s-bold;font-size: 14px;"><?php echo $staffArr['blood_group'];?></td>
                    </tr>
                </table>
                <div style="position: relative;margin: 60px 0;float: left;width: 100%;">
                    <div style="background-color: #00add8;color: #fff;position: absolute;left: -30px;right: -30px;margin: auto;padding: 5px;font-family: s-bold;top: 0;bottom: 0;height: 20px;">
                        <span> If found please inform : +0495 4040796</span></div>
                </div>
                <ul style="float: left; width: 100%;padding-left: 0;margin: 0;text-align: left;list-style: none;font-family: s-bold;">
                    <li style="position: relative;padding-left: 40px;font-size: 14px;"><img src="<?php echo base_url('inner_assets'); ?>/images/pdf/general/location.png" style="position: absolute;left: 0;width: 25px;" />Direction Group of Institutions Pvt LTD
							IVth Floor,Skytower building, Bank road,
							Mavoor Road Junction, Calicut, 673001, Kerala, India<br></li>
                    <li style="position: relative;padding-left: 40px;font-size: 14px;height: 45px;"><img src="<?php echo base_url('inner_assets'); ?>/images/pdf/general/email.png" style="position: absolute;left: 0;width: 25px;" />info@direction.org.in</li>
                    <li style="position: relative;padding-left: 40px;font-size: 14px;height: 45px;"><img src="<?php echo base_url('inner_assets'); ?>/images/pdf/general/mob.png" style="position: absolute;left: 0;width: 25px;" />0495 4040796</li>
                    <li style="position: relative;padding-left: 40px;font-size: 14px;height: 45px;"><img src="<?php echo base_url('inner_assets'); ?>/images/pdf/general/web.png" style="position: absolute;left: 0;width: 25px;" />www.direction.school</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <br><br>
            <button type="submit" class="btn btn-info btn_save pull-right" id="download_pdf" style="margin-top:40px;">Download ID card</button>
        </div>
    <div style="clear:both"></div>
    <script>
    $("#download_pdf").click(function(){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/Staff/download_idcard/<?php echo $staffArr['personal_id'];?>',
            type: 'POST',
            data: {
                    'ci_csrf_token':csrfHash
                },
            success: function(response) {
                var obj = JSON.parse(response);
                if(obj.st==1){
                    window.open(obj.url);
                    $(".loader").hide();
                }
                $(".loader").hide();
            }
        });
    });
</script>
