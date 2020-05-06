<style>
    ul {
        list-style-type: none;
    }

    body {
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

    .right-col {
        float: right;
        width: 50%;
    }

    .left-col-inner {
        float: left;
        width: 15%;
        font-size: 40px;
        font-weight: bold;
        padding-top: 5px;
    }

    .mid-col-inner {
        float: left;
        width: 64%;
        font-size: 22px;
        text-align: center;
        padding-top: 5px;
    }

    .right-col-inner {
        float: right;
        padding-left: 2px;
        width: 20%;
        padding-top: 5px;
        background-color: #000;
        color: #fff;
        border-radius: 5px;
    }

    .mytitle {
        font-weight: bold;
        border: 1px solid black;
        border-radius: 10px;
        width: 33%;
        padding: 10px;
        font-size: 25px;
    }

    .ra-s {
        font-weight: bold;
        font-size: 25px;
        background: #000;
        color: #fff;
        border: 1px solid black;
        border-radius: 10px;
    }

    .my-row {
        border: 1px solid black;
        border-radius: 10px;
    }

    .sep {
        font-weight: normal;
    }
</style>

<div class="row">
    <div class="left-col"></div>
    <div class="right-col"><img src="direction_v2/images/logo/logo.png" style="width:150px;height:200px;"></div>
</div>
<br>
<div class="row">
    <div class="left-col mytitle"><?php echo $batchName; ?></div>
    <div class="right-col"></div>
</div>

<div class="row">
    <div class="left-col"></div>

    <div class="right-col">
        <span class="ra-s" > <?php echo $learningModuleName; ?></span>
        <div style="display: flex;margin-left: 20px;justify-content: space-between;align-items: center;align-content: center;">
            <!-- <span style="display: flex;flex-direction: column;font-size: 24px;font-weight: 700;padding-left:15px;border-right: 1px solid #000;padding-right: 15px;">LM</span>
            <span style="display: flex;margin-left: 10px;font-family:'Times New Roman', Times, serif; line-height: 100%;font-weight: 700;letter-spacing: 2px;font-size: 18px;">LEARNING
                <br> MODULE
            </span> -->
            <div class="row my-row">
                <div class="left-col-inner"><span>LM</span> <span class="sep"> | </span></div>
                <div class="mid-col-inner"><span>LEARNING <br> MODULE</span></div>
                <div class="right-col-inner"><span class="ra-s" style="font-size: 45px;width: auto;"><?php echo $sequenceNo; ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="row">
    <div class="left-col "></div>

    <div class="right-col mytitle">
        <span style="display: inline-block;font-size: 20px;background-color: #000;color: #fff;border-radius: 5px;text-align: center;font-weight: bold;padding: 5px 15px;">RA-S</span>

        <div style="display: flex;margin-left: 20px;justify-content: space-between;align-items: center;align-content: center;">
            <span style="display: flex;flex-direction: column;font-size: 24px;font-weight: 700;padding-left:15px;border-right: 1px solid #000;padding-right: 15px;">LM</span>
            <span style="display: flex;margin-left: 10px;font-family:'Times New Roman', Times, serif; line-height: 100%;font-weight: 700;letter-spacing: 2px;font-size: 18px;">LEARNING
                <br> MODULE
            </span>
            <span class="bg" style="font-size: 40px;background-color: #000;color: #fff;border-radius: 5px;padding: 2px 30px;font-family:'Times New Roman', Times, serif;font-weight: 900;position: relative;left: 1px;">4</span>
        </div>
    </div>
</div> -->


<div class="row">
<br>
    <div class="left-col"></div>
    <div class="right-col ">
        <div style="position: absolute;width: auto;z-index: 999;transform: rotate(-90deg);left: -35px;top: 70px;">
            <span style="text-transform:capitalize;
                    transform: rotate(340deg);
                    transform-origin: left bottom 20px; "><b>CONTENTS</b></span>
        </div>
        <?php if($moduleContent){?>
            <div style="">
                <ol style="font-size: 14px;padding-top: 20px;line-height: 18px;font-weight: 600;padding-left: 60px;">
                    <?php echo $moduleContent; ?>
                </ol>
            </div>
        <?php }?>
    </div>
</div>
<br><br>
<div class="row">
    <div class="left-col"></div>
    <div class="right-col ">
        <p style="font-size: 14px;font-weight: 700;margin-bottom: 25px;">
            <span style="border-bottom: 1px solid #000;line-height: 32px;display: block;font-size: 16px;"><b><?php echo $this->common->get_name_by_id('am_schools','school_name',array('school_id'=>$getSchool));?></b></span>
            <span style="font-style: italic;font-weight: 700;display: block;font-size: 12px;"><br>A venture of
                Direction Group of Institutions Plt.Ltd.
            </span>
            <b>Savithry Building, Bank Road
                Kozhikode. Ph:0495-4040792</b>
        </p>
    </div>
</div>
<br><br>
<div class="row">
    <div class="left-col" style="width: 10%;">Name</div>
    <div class="right-col" style="border:1px solid black; font-size:20px;  width: 89%; border-radius: 10px;"> &nbsp; </div>
</div><br>
<div class="row">
    <div class="left-col" style="width: 11%">Batch</div>
    <div class="left-col " style="border:1px solid black; font-size:20px;  width: 50%; border-radius: 10px;"> &nbsp; </div>
    <div class="right-col" style="width: 10%"><br>Signature</div>

</div>
<pagebreak>
