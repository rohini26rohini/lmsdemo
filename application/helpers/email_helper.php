<?php 
//registration
function email_header()
{
    $baseurl=base_url();
    $header='<!DOCTYPE html>
<html lang="en">

<head>
    <title>IIHRM</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body style="margin: 0px;">
	<table border="0" width="700" style="margin:0 auto;">
		<tr>
			<td><img src="'.$baseurl.'assets/images/email_banner.png"></td>
		</tr>';
    return $header;
}

function email_footer()
{
    $baseurl=base_url();
    $footer='<tr style="background: url('.$baseurl.'assets/images/email_bg_line.png) no-repeat #00ADD8; background-size: contain;background-position: right;">
			<td style="font-family:"Open Sans", sans-serif;font-size: 14px; padding: 10px 50px;text-align: center;color: #fff">
				<h5>Direction Group of Institutions Pvt LTD.</h5> 
				<p>IVth Floor,Skytower building, Bank road,<br>
				Mavoor Road Junction, Calicut ,673001,Kerala , India</p>
			</td>
		</tr>
	</table>
</body>
</html>';
    return $footer;
}

function forgot_password_Email_header()
{
    $baseurl=base_url();
    $header='<!DOCTYPE html>
<html lang="en">

<head>
     <title>IIHRM</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="margin: 0px;">
	<table border="0" width="700" style="margin:0 auto;">
		<tr>
			<td style="padding:13px 26px;"><img src="'.$baseurl.'assets/images/logo.png"></td>
		</tr>
		<tr style="background:#f2f2f2">';
    return $header;
}
function forgot_password_Email_footer()
{
    $baseurl=base_url();
    $footer='</tr>
		<tr>

		</tr>
		<tr style="background: url('.$baseurl.'assets/images/footer_bg.jpg) no-repeat;">
			<td style=" padding: 0px 26px;">
            <table>
            <tr>
          
				<td style="float: left; padding: 34px 0px;width: :40%;">
					<ul style="padding: 0px;">
						<li style="list-style: none;float: left;padding: 0px 15px;">
							<a href="#"><img src="'.$baseurl.'assets/images/facebook-logo.png"></a>
						</li>
						<li style="list-style: none;float: left;padding: 0px 15px;">
							<a href="#"><img src="'.$baseurl.'assets/images/twitter_email.png"></a>
						</li>
						<li style="list-style: none;float: left;padding: 0px 15px;">
							<a href="#"><img src="'.$baseurl.'assets/images/youtube-play-button.png"></a>
						</li>
						<li style="list-style: none;float: left;padding: 0px 15px;">
							<a href="#"><img src="'.$baseurl.'assets/images/blogger-letter-logotype.png"></a>
						</li>
					</ul>
				</td>
				<tr style="width: 59%;font-family: Open Sans, sans-serif;font-size: 12px;text-align: right;color: #fff; float: right;">
					<h5 style="width: 59%;font-family: Open Sans, sans-serif;font-size: 12px;text-align: right;color: #fff; float: right;">Direction Group of Institutions Pvt LTD.</h5> 
					<p style="width: 59%;font-family: Open Sans, sans-serif;font-size: 12px;text-align: right;color: #fff; float: right;">IVth Floor,Skytower building, Bank road, <br>
					Mavoor Road Junction, Calicut ,673001,Kerala , India</p>
				</td>
				  
            </tr>
            </table>
			</td>
		</tr>
	</table>
</body>
</html>';
    return $footer;
}

?>
