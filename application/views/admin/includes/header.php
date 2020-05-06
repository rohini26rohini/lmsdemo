<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/images/apple-icon-57x57.png');?>">
        <link rel="icon" type="image/png" href="<?php echo base_url('assets/images/favicon-32x32.png');?>">
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.ico');?>" type="image/ico" sizes="16x16">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="google" content="notranslate">
    <title> IIHRM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('includes/common_header.php'); ?>
    <link rel="stylesheet" href="<?php echo base_url();?>inner_assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>inner_assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>inner_assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>inner_assets/css/custom_ver2.0.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>inner_assets/css/developer.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>inner_assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>inner_assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>inner_assets/css/jquery-confirm.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>inner_assets/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>inner_assets/css/tooltipster.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link href='<?php echo base_url();?>inner_assets/css/fullcalendar.min.css' rel='stylesheet' />
    <link href='<?php echo base_url();?>inner_assets/css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
    <link rel="stylesheet" href="<?php echo base_url();?>inner_assets/css/bootstrap-treeview.css" />

    <link href='<?php echo base_url();?>inner_assets/css/select2/select2.min.css' rel='stylesheet' type='text/css'>
    <link href='<?php echo base_url();?>inner_assets/css/okayNav.css' rel='stylesheet' type='text/css'>
    <link href='<?php echo base_url();?>inner_assets/css/blueimp-gallery.css' rel='stylesheet' type='text/css'>
    <link href='<?php echo base_url();?>inner_assets/css/blueimp-gallery-indicator.css' rel='stylesheet' type='text/css'>

    <!-- Script Section Starts here -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
    <script src="<?php echo base_url();?>inner_assets/js/jquery.validate.min.js"></script>
    <script src="<?php echo base_url();?>inner_assets/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>inner_assets/css/bootstrap-multiselect.css" />
    <script src="<?php echo base_url();?>inner_assets/js/popper.min.js"></script>
    <script src="<?php echo base_url();?>inner_assets/js/bootstrap.min.js "></script>
    <script src="<?php echo base_url();?>inner_assets/js/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>inner_assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo base_url();?>inner_assets/js/jquery-confirm.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('inner_assets/js/ckeditor_full/ckeditor.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('inner_assets/js/ckeditor_full/plugins/simage/plugin.js'); ?>"></script>
    <script src="<?php echo base_url();?>inner_assets/js/jquery.toaster.js"></script>
    <script src="<?php echo base_url();?>inner_assets/js/custom.js "></script>    
    <script src="<?php echo base_url();?>inner_assets/js/jquery.tooltipster.js"></script>
    <script src="<?php echo base_url();?>inner_assets/js/fullcalendar.min.js"></script>
    <script src="<?php echo base_url();?>inner_assets/js/bootstrap-treeview.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url();?>inner_assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url();?>inner_assets/js/dataTables.bootstrap4.min.js"></script>
    <script src='<?php echo base_url();?>inner_assets/js/select2/select2.min.js' type='text/javascript'></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url();?>inner_assets/js/scrollBar.js"></script>
    <script src="<?php echo base_url();?>inner_assets/js/all.js?v=<?php echo time();?>" type="text/javascript"></script>
    <script src="<?php echo base_url();?>inner_assets/js/jquery.okayNav.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>inner_assets/js/jquery.nicescroll.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>inner_assets/js/blueimp-gallery.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>inner_assets/js/jquery.blueimp-gallery.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>inner_assets/js/jquery.dragndrop.js" type="text/javascript"></script>


    <script>
      
        $(document).ready(function() {
            $('#cc_iprogresstable').DataTable({
                "language": {
                    "infoEmpty": "No records available.",
                }
            });
            $('#institute_data').DataTable({
                "language": {
                    // "infoEmpty": "No records available.",
                }
            });
            $('#subject_data').DataTable({
                "language": {
                    "infoEmpty": "No records available.",
                }
            });
            $('#syllabus_data').DataTable({
                "language": {
                    "infoEmpty": "No records available.",
                }
            });
            $('#institute_data1').DataTable({
                "language": {
                    "infoEmpty": "No records available.",
                }
            });
            $('#studentdatatable').DataTable({
                "language": {
                    "infoEmpty": "No records available.",
                }
            });
            $('#schedule_datatable').DataTable({
                "language": {
                    "infoEmpty": "No records available.",
                    
                },
                 "searching": false,
            });
            $('#faculty_data').DataTable({
                'aoColumnDefs': [
                    {
                        'bSortable': false,
                        'aTargets': [-1] /* 1st one, start by the right */
                    },
                ]
            });
        });

        (function($){

	blueimp.Gallery(
		document.getElementById('links').getElementsByTagName('a'),
		{
			container: '#blueimp-gallery',
			carousel: true,
			onslide: function (index, slide) {
                var unique_id = this.list[index].getAttribute('data-unique-id');
                console.log(unique_id);
			}
		}
  );
});
    </script>
    <style>
        .select2-container{
            width: 100% !important;
        }
    </style>
    </head>
