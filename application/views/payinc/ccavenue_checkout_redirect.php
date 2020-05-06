<title> Direction fee payment processing </title>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/styles/style.css">
<link rel="stylesheet"
      href="<?php echo base_url() ?>assets/css/style.css" />
<link rel="stylesheet"
      href="<?php echo base_url() ?>assets/css/bootstrap.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css">
        <script src="<?php echo base_url();?>direction_v2/js/jquery.min.js "></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
</head>
<style>
.loader {
    /* position: fixed;
    bottom: 0px;
    left: 0px;
    top: 0px;
    right: 0px;
    margin: auto;
    width: 100%;
    height: 100%;
    z-index: 100000000;
    background: rgba(0, 0, 0, 0.5); */
}
</style>
<body>
<center>
    <div class="col-md-12" style="margin:0px auto;-moz-box-shadow: 0 3px 15px rgba(0,0,0,0.1);
         -webkit-box-shadow: 0 3px 15px rgba(0,0,0,0.1);
         box-shadow: 0 3px 15px rgba(0,0,0,0.1);">
        <div id="logo">

        </div>

    </div>
    <br clear="all"/>

    <br clear="all" />
    <div id="container" class="mainContent">
        <div style="width:70%; height:80px;padding-top: 20px;padding-bottom: 20px;">
                <h4 style="text-align: center;"><strong style="color:#beb8b8;">Please do not refresh or reload the page.</strong></h4>
                <h6 style="color:#beb8b8;">Please wait until we redirect to payment gateway. </h6>
                <div class="loader">
                        <!-- <img src="<?php echo base_url();?>direction_v2/images/loader.svg">
                        <img src="<?php echo base_url();?>direction_v2/images/loader_logo.png"> -->
                        <img src="<?php echo base_url();?>direction_v2/images/loader-select.svg">

                    </div>
                <form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction">  
                    <?php
                    echo "<input type=hidden name=encRequest value=$encrypted_data>";
                    echo "<input type=hidden name=access_code value=$access_code>";
                    ?>
                    <!-- <input type="submit" />  -->
                </form>
            
        </div>
    </div>
</center>


<script language='javascript'>
    
    jQuery(document).ready(function() {
           setTimeout(document.redirect.submit(),6000);
        }); 
</script>
</body>
</html>

