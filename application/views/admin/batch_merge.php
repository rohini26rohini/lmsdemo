<div class="content_wrapper relative col-lg-10 col-md-9 col-sm-9 col-xs-12 ">
    <div class="white_card">
        <h6>Batch Merging</h6>
        <hr>
        <input type="hidden"  class ="exclude-status" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
        <div class="row">
            <div class="col-md-4 batchs-boxs">
                <div class="form-group">
                    <label for="sel1">From batch:</label> <span class="req redbold"> *</span>
                    <select class="form-control selectcentre" id="fbatch" name="fbatch">
                        <option value="">Select</option>
                        <?php
                        if(!empty($batchArr)) {
                            foreach($batchArr as $row){
                        echo '<option value="'.$row['batch_id'].'">'.$row['batch_name'].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="studentListWapper" id="studentListWapper">
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="form-group">
                    <label for="sel1">To batch:</label> <span class="req redbold"> *</span>
                    <select class="form-control selectbatch" id="tbatch" name="tbatch">
                        <option value="">Select</option>
                        <?php
                        if(!empty($batchArr)) {
                            foreach($batchArr as $row){
                                echo '<option value="'.$row['batch_id'].'">'.$row['batch_name'].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4 filerPad mergeBtn">
                <div class="form-group text-center">
                    <button class="btn btn-sm btn-success" id="transfer">Merge</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("admin/scripts/batch_merging_script");?>
