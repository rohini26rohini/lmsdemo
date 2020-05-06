<html>
<head>
    <title>IIHRM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/common.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery.jConveyorTicker.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom_version_1.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style.css">
<style>
.Errorbg{
    background: url("<?php echo base_url();?>assets/images/404.png") no-repeat #e7e7e7;
    background-size: 100%;
    height: 100%;
    background-position: top;
}

.Error {
    position: fixed;
    top: 130px;
    left: 0px;
    right: 0px;
    margin: auto;
    height: 340px;
    text-align: center;
    width: 50%;
}
.Error h3 {
    font-size: 30px;
    margin-top: 30px;
    color: #19b8df;
    font-family: "bold";
    margin-bottom: 0px;
}
.Error h3 span {
    display: block;
    font-size: 40px;
}
.Error p {
    display: block;
    font-size: 25px;
    color: #7E7E7E;
    font-family: "light";
    margin-top: 15px;
}
.Error a{
    background: #00add8;
    border-radius: 3px;
    color: #fff;
    width: 170px;
    display: block;
    margin: auto;
    padding: 10px 0px;
    font-family: "bold";
    font-size: 18px;
    margin-top: 20px;
}
    </style>
</head>

<body class="Errorbg">
    <div class="Error">
        <img src="<?php echo base_url();?>assets/images/Errorlogo.png">
        <h3><span>404</span>Page Not Found.....</h3>
        <p>We're unable to find page you're looking for.</p>
        <a href="<?php echo base_url();?>">Back to Home</a>
    </div>
</body>

</html>