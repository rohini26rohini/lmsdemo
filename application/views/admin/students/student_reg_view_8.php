<?php 
    $color='';
    if($studentcard['school_code']=='I'){$color='#d01f2f';}
    if($studentcard['school_code']=='N'){$color='#E15C22';}
    if($studentcard['school_code']=='P'){$color='#6E9E7A';}
    if($studentcard['school_code']=='S'){$color='#AFBC34';}
    if($studentcard['school_code']=='A'){$color='#009FC7';}
?>
<style>
.card_id::before {
    background: <?php echo $color;?> !important;
}
.card_id::after {
    background: <?php echo $color;?> !important;
}
</style>
    <!-- <form id="export_form" method="post" action="<?php //echo base_url('backoffice/download-idcard/<?php echo $studentArr['student_id'];?>');?>"> -->

<div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="card card_id" style="background-image: url('<?php echo base_url('inner_assets'); ?>/images/bg.png');">
                <img src="<?php echo base_url('inner_assets'); ?>/images/logo_inner.png" class="img-fluid" />
                <div class="avathar_id" style="background-image: url('<?php echo base_url($studentArr['student_image']); ?>')"></div>
                <h1><?php echo $studentArr['name'];?></h1>
                <p class="title">ID Number: <?php echo $studentArr['registration_number'];?></p>
                <h6><?php echo $studentcard['class_name'];?>
                    <small><?php echo $studentcard['school_name'];?></small>
                </h6>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="card card_id" style="background-image: url('<?php echo base_url('inner_assets'); ?>/images/bg.png');">
                <table class="table_id">
                    <tr>
                        <th nowrap>Contact No.</th>
                        <td>:</td>
                        <td><?php echo $studentArr['contact_number'];?></td>
                    </tr>
                    <tr>
                        <th nowrap>Blood Group</th>
                        <td>:</td>
                        <td><?php echo $studentArr['blood_group'];?></td>
                    </tr>
                </table>
                <div class="id_strip_wrap">
                    <div class="id_strip">
                        <span> If found please inform : +0495 4040796</span></div>
                </div>
                <ul class="id_list">
                    <li><img src="<?php echo base_url('inner_assets'); ?>/images/pdf/general/location.png" class="img-fluid" />Direction Group of Institutions Pvt LTD
					IVth Floor,Skytower building, Bank road,
					Mavoor Road Junction, Calicut, 673001, Kerala, India</li>
                    <li><img src="<?php echo base_url('inner_assets'); ?>/images/pdf/general/email.png" class="img-fluid" />info@direction.org.in</li>
                    <li><img src="<?php echo base_url('inner_assets'); ?>/images/pdf/general/mob.png" class="img-fluid" />8907777456</li>
                    <li><img src="<?php echo base_url('inner_assets'); ?>/images/pdf/general/web.png" class="img-fluid" />www.direction.school</li>
                </ul>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <br><br>
            <button type="submit" class="btn btn-info btn_save pull-right" id="download_pdf">Download ID card</button>
        </div>
        </div>
    <!-- </form> -->

<script>
    $("#download_pdf").click(function(){
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url();?>backoffice/students/download_idcard/<?php echo $studentArr['student_id'];?>',
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