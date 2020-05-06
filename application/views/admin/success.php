<div class="content_wrapper relative col-lg-10 col-md-8 col-sm-8 col-xs-12 ">
    <div class="transparent_card ">
        <!-- Data Table Plugin Section Starts Here -->
        <div class="row ">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                <button class="btn btn-default pagination_nav ">
                    <i class="fa fa-caret-left "></i>
                </button>
                <button class="btn btn-default pagination_nav ">
                    <i class="fa fa-caret-right "></i>
                </button>
                <span class="number_records ">Showing 1-10 of 103 records.</span>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right flex-row-reverse ">
                <button class="btn btn-default option_btn list_option ">
                    <i class="fa fa-th-list "></i>
                </button>
                <button class="btn btn-default option_btn grid_option ">
                    <i class="fa fa-th-large "></i>
                </button>
                <button class="btn btn-default option_btn filter_btn">
                    <i class="fa fa-sliders"></i>
                </button>
                <button class="btn btn-default add_row add_new_btn" data-toggle="modal" data-target="#myModal">
                    <i class="fa fa-plus "></i>
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <ul class="data_table ">
                <li class="data_table_head ">
                    <div class="col sl_no ">Sl. No.
                        <div class="sort_option ">
                            <button class="btn btn-default sort_up ">
                            <i class="fa fa-caret-left "></i>
                        </button>
                            <button class="btn btn-default sort_down ">
                            <i class="fa fa-caret-right "></i>
                        </button>
                        </div>
                    </div>
                    <div class="col avatar ">Name</div>
                    <div class="col ">Description
                        <div class="sort_option ">
                            <button class="btn btn-default sort_up ">
                            <i class="fa fa-caret-left "></i>
                        </button>
                            <button class="btn btn-default sort_down ">
                            <i class="fa fa-caret-right "></i>
                        </button>
                        </div>
                    </div>
                    <div class="col actions">Action
                        <div class="sort_option ">
                            <button class="btn btn-default sort_up ">
                            <i class="fa fa-caret-left "></i>
                        </button>
                            <button class="btn btn-default sort_down ">
                            <i class="fa fa-caret-right "></i>
                        </button>
                        </div>
                    </div>
                </li>
                <?php $i=1; foreach($successArr as $success){?>
                <li>
                    <div class="col sl_no ">
                        <?php echo $i;?>
                    </div>
                    <div class="col">
                        <?php echo $success['name'];?>
                    </div>
                    <div class="col ">
                        <?php echo $success['description'];?>
                    </div>
                    <div class="col actions ">
                        <a href="#" title="Edit" class="btn btn-default option_btn  edit_syllabus_btn">
                        <i class="fa fa-pencil "></i>
                    <!--edit success stories-->
                    </a>
                        <a class="btn btn-default option_btn" title="Delete" onclick="delete_success_stories(<?php echo $success['success_id'];?>)">
                        <i class="fa fa-trash-o"></i>
                    </a>
                    </div>
                </li>
                <?php $i++; } ?>
            </ul>
        </div>
        <!-- Data Table Plugin Section Starts Here -->
    </div>
</div>
<div id="myModal" class="modal fade form_box" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Success Stories</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" id="add_success_form" method="post">
                    <div class="row">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" id="name" class="form-control" />
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="description" id="description" class="form-control" />
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group"><label>Upload File</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <button class="btn btn-info" type="submit">Save</button>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <a class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var validation = 0;
    $("form#add_success_form").validate({
        rules: {
            name: {
                required: true
            },
            image: {
                required: true
            }
        },
        messages: {
            name: "Please Enter a Name",
            image: "Please upload Image",
        },
        submitHandler: function(form) {
            validation = 1;
        }
    });
    $("form#add_success_form").submit(function(e) {
        //prevent Default functionality
        e.preventDefault();
        //var formData = new FormData(this);
        // debugger;
        if (validation == 1) {
            $.ajax({
                url: '<?php echo base_url();?>admin/Success/upload_image', 
                type: "post",
                data: new FormData(this), //$("#addingtaskdetailsform").serialize(),
                beforeSend: function(data) {
                    // Show image container
                },
                success: function(data) {
                    console.log(data); //return false;
                    location.reload();
                },
                complete: function(data) {
                    // Hide image container
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });

    function delete_success_stories(id) {
        $.confirm({
            title: 'Alert message',
            content: 'Do you want to remove this Information?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Proceed',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.post('<?php echo base_url();?>admin/Success/delete_stories/', {
                            id: id,
                            <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                        }, function(data) {
                            if (data == "1") {
                                location.reload();
                            }
                        });
                        $.alert('Successfully <strong>Deleted..!</strong>');
                    }
                },
                cancel: function() {
                    //$.alert(' <strong>cancelled</strong>');
                },
            }
        });
    }

</script>