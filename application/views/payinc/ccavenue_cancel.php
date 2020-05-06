<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/styles/style.css">
<title>Vibha India</title>
<link rel="stylesheet"
	href="<?php echo base_url() ?>assets/css/style.css" />
<link rel="stylesheet"
	href="<?php echo base_url() ?>assets/css/bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css">
<style>

.menu, .menu ul {
	list-style: none;
	padding: 0;
	margin: 0;
}
.menu {
	height: 58px;
	background-color:#fff;
}
.menu li {
	background-color:#fff;
}
.menu > li {
	display: block;
	float: left;
	position: relative;
}
.menu > li:first-child {
}
.menu a {
	border-left: 3px solid rgba(0, 0, 0, 0);
	color: #444;
	display: block;
	font-family:Arial, Helvetica, sans-serif;
	font-size: 14px;
	line-height: 56px;
	padding: 0 25px;
	text-decoration: none;
	text-transform: uppercase;
}
.menu li:hover > a {
	border-radius: 5px 0 0 0;
	border-bottom: 2px solid #1fbba6;
	color: #C4302B;
}
/* submenu styles */
.submenu {
	left: 0;
	max-height: 0;
	position: absolute;
	top: 100%;
	z-index: 0;
	min-width: 330px;
	-webkit-perspective: 400px;
	-moz-perspective: 400px;
	-ms-perspective: 400px;
	-o-perspective: 400px;
	perspective: 400px;
}
.submenu li {
	background-color:#333;
	opacity: 0;
	-webkit-transform: rotateY(90deg);
	-moz-transform: rotateY(90deg);
	-ms-transform: rotateY(90deg);
	-o-transform: rotateY(90deg);
	transform: rotateY(90deg);
 -webkit-transition: opacity .4s, -webkit-transform .5s;
 -moz-transition: opacity .4s, -moz-transform .5s;
 -ms-transition: opacity .4s, -ms-transform .5s;
 -o-transition: opacity .4s, -o-transform .5s;
 transition: opacity .4s, transform .5s;
}
.menu .submenu li a {
	border-bottom: 1px solid #4a4b4b;
	color:#eee;
	text-transform:capitalize;
	font-size:12px;
}
.menu .submenu li:hover a {
	
	border-radius: 0;
	color: #fff;
}
.menu > li:hover .submenu, .menu > li:focus .submenu {
	max-height: 2000px;
	z-index: 10;
}
.menu > li:hover .submenu li, .menu > li:focus .submenu li {
	opacity: 1;
	-webkit-transform: none;
	-moz-transform: none;
	-ms-transform: none;
	-o-transform: none;
	transform: none;
}


/* CSS3 delays for transition effects */
.menu li:hover .submenu li:nth-child(1) {
 -webkit-transition-delay: 0s;
 -moz-transition-delay: 0s;
 -ms-transition-delay: 0s;
 -o-transition-delay: 0s;
 transition-delay: 0s;
}
.menu li:hover .submenu li:nth-child(2) {
 -webkit-transition-delay: 50ms;
 -moz-transition-delay: 50ms;
 -ms-transition-delay: 50ms;
 -o-transition-delay: 50ms;
 transition-delay: 50ms;
}
.menu li:hover .submenu li:nth-child(3) {
 -webkit-transition-delay: 100ms;
 -moz-transition-delay: 100ms;
 -ms-transition-delay: 100ms;
 -o-transition-delay: 100ms;
 transition-delay: 100ms;
}
.menu li:hover .submenu li:nth-child(4) {
 -webkit-transition-delay: 150ms;
 -moz-transition-delay: 150ms;
 -ms-transition-delay: 150ms;
 -o-transition-delay: 150ms;
 transition-delay: 150ms;
}
.menu li:hover .submenu li:nth-child(5) {
 -webkit-transition-delay: 200ms;
 -moz-transition-delay: 200ms;
 -ms-transition-delay: 200ms;
 -o-transition-delay: 200ms;
 transition-delay: 200ms;
}
.menu li:hover .submenu li:nth-child(6) {
 -webkit-transition-delay: 250ms;
 -moz-transition-delay: 250ms;
 -ms-transition-delay: 250ms;
 -o-transition-delay: 250ms;
 transition-delay: 250ms;
}
.menu li:hover .submenu li:nth-child(7) {
 -webkit-transition-delay: 300ms;
 -moz-transition-delay: 300ms;
 -ms-transition-delay: 300ms;
 -o-transition-delay: 300ms;
 transition-delay: 300ms;
}
.menu li:hover .submenu li:nth-child(8) {
 -webkit-transition-delay: 350ms;
 -moz-transition-delay: 350ms;
 -ms-transition-delay: 350ms;
 -o-transition-delay: 350ms;
 transition-delay: 350ms;
}
 .submenu li:nth-child(1) {
 -webkit-transition-delay: 350ms;
 -moz-transition-delay: 350ms;
 -ms-transition-delay: 350ms;
 -o-transition-delay: 350ms;
 transition-delay: 350ms;
}
.submenu li:nth-child(2) {
 -webkit-transition-delay: 300ms;
 -moz-transition-delay: 300ms;
 -ms-transition-delay: 300ms;
 -o-transition-delay: 300ms;
 transition-delay: 300ms;
}
.submenu li:nth-child(3) {
 -webkit-transition-delay: 250ms;
 -moz-transition-delay: 250ms;
 -ms-transition-delay: 250ms;
 -o-transition-delay: 250ms;
 transition-delay: 250ms;
}
.submenu li:nth-child(4) {
 -webkit-transition-delay: 200ms;
 -moz-transition-delay: 200ms;
 -ms-transition-delay: 200ms;
 -o-transition-delay: 200ms;
 transition-delay: 200ms;
}
.submenu li:nth-child(5) {
 -webkit-transition-delay: 150ms;
 -moz-transition-delay: 150ms;
 -ms-transition-delay: 150ms;
 -o-transition-delay: 150ms;
 transition-delay: 150ms;
}
.submenu li:nth-child(6) {
 -webkit-transition-delay: 100ms;
 -moz-transition-delay: 100ms;
 -ms-transition-delay: 100ms;
 -o-transition-delay: 100ms;
 transition-delay: 100ms;
}
.submenu li:nth-child(7) {
 -webkit-transition-delay: 50ms;
 -moz-transition-delay: 50ms;
 -ms-transition-delay: 50ms;
 -o-transition-delay: 50ms;
 transition-delay: 50ms;
}
.submenu li:nth-child(8) {
 -webkit-transition-delay: 0s;
 -moz-transition-delay: 0s;
 -ms-transition-delay: 0s;
 -o-transition-delay: 0s;
 transition-delay: 0s;
}
.icon-down{
	font-size:9px;
	color:#999;
}
</style>        



<!--[if lt IE 9]>


    <style type="text/css">
    .chromeframe {
	    margin: 0.2em 0;
	    background: #000;
	    color: #FFF;
	    padding: 0.2em 0;
	    position:fixed;
	    z-index:999;
	}

   
    </style>
    
    
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Using current browser will prevent you from accessing features of this website. Please <a href="http://browsehappy.com/">upgrade your browser</a>  to improve your experience. We strongly recommend to use any of following browsers <strong>Internet Explorer-10/Google Chrome/Firefox</strong>. </p>
    
    
<![endif]-->
  <style type="text/css">
  
  .feeClass{
  
  background-color: #EEEEEE;
  
  }
  </style>
    
</head>
<body>

	<div id="container"  style="margin:0px auto; width:80%; padding:20px;">
		<div class="col-md-12">
            <?php 
                echo $message; 
                if($platform != 'android')
                {
            ?> 
                <div align="center">
                    <a href="<?php echo base_url() ?>" class="btn btn-warning" style="align: center;">Go to Home Page</a>
                </div>
            <?php 
                } 
                if($platform == 'android')
                {
            ?>
                <div align="center">
                    <a href="<?php echo base_url().'payment/appendurl/'.$status ?>" class="btn btn-warning" style="align: center;">Try Again</a>
                </div>
            <?php 
                }
            ?>
		</div>
		
		<br clear="all" />
	</div>
</html>