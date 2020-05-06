

<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <form id="filter_form" method="post" action="<?php echo base_url('backoffice/print-notes');?>">
        <div class="white_card ">
            <h6>Download & Print Notes</h6>
            <hr>
            <input type="hidden"  class ="exclude-status" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
        </div>
        <!-- Data Table Plugin Section Starts Here -->
        <div class="white_card">
            <div id="result">
                <div class="form-group">
                    <label style="display:block;">Column</label>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="single" value="single">Single Column
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="single" value="double">Double Column
                        </label>
                    </div>
                </div>
                <button class="btn btn-default add_row btn_map btn_print" id="download" name="download" type="submit">
                    <i class="fa fa-download"></i> Download
                </button>
                <button class="btn btn-default add_row btn_map btn_print" formtarget="_blank" id="print" name="print" type="submit">
                    <i class="fa fa-file-pdf-o"></i> Print
                </button>
            </div>
        </div>
    </form>
</div>
