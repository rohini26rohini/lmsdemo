    <footer>
        <div class="container maincontainer">
            <div class="row">
                <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                            <ul class="nav nav-bar ">
                                <li><a href="#">Facebook</a></li>
                                <li><a href="#">LinkedIn</a></li>
                                <li><a href="#">YouTube</a></li>
                                <li><a href="#">Twitter</a></li>
                            </ul>
                        </div> -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                    <p class="text-center">2018 © gbs-plus.com All rights reserved. Powered By GBS PLUS</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- <div class="icon-bar ">
        <div class="msg">
            <a href="#" id="msg_click">
                <div class="fixed_msg" id="don">
                    <img src="<?php echo base_url();?>direction_v2/images/phone-solid.svg" alt="Message" class="img-fluid" id="info_msg" />
                    <img src="<?php echo base_url();?>direction_v2/images/close.svg" alt="Message" class="img-fluid" id="info_close" />
                </div>
            </a>
            <div class="box">
                <div class="box-inner">
                    <div class="panel_title">
                        <h4><i class="fas fa-phone"></i>Contact back</h4>
                    </div>
                    <form class="msgform" type="post" id="contactus_footer">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" type="text" placeholder="Enter Name" onkeypress="return valNames(event);" name="enquiry_name" id="name">
                            <input type="hidden" class="form-control"  name="enquiry_type" value="2">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" id="Phone" placeholder="Phone"  name="enquiry_phone">
                        </div>
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" class="form-control" id="Email1" placeholder="Enter email" name="enquiry_email">
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control textarea_message" placeholder="Message" rows="4" name="enquiry_note"></textarea>
                        </div>
                        <button type="submit" class="btn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <a href="" class="facebook "><i class="fab fa-facebook-f "></i></a>
        <a href=""  class="youtube "><i class="fab fa-youtube"></i></a>
    </div> -->
<div id="reschedule_modal_exam" class="modal fade form_box modalCustom" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="reschedule_modal_schedulename"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td width="50%">Exam name:</td>
                                    <td id="reschedule_modal_examname"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Exam date:</td>
                                    <td id="reschedule_modal_examdate"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Exam start time:</td>
                                    <td id="reschedule_modal_examstime"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Exam end time:</td>
                                    <td id="reschedule_modal_exametime"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Exam room:</td>
                                    <td id="reschedule_modal_examroom"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Exam type:</td>
                                    <td id="reschedule_modal_examresult"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Exam status:</td>
                                    <td id="reschedule_modal_examstatus"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Batch:</td>
                                    <td id="reschedule_modal_batch"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="reschedule_modal_exam_button" class="btn btn-success">Reschedule exam</button>
                        <button type="button" id="delete_modal_exam_button" class="btn btn-danger">Cancel exam</button>
<!--                        <button type="button" id="change_status_exam_button" class="btn btn-info"></button>-->
                   </div>
                </div>
            </div>
        </div>        
        
        <div id="reschedule_batch_modal" class="modal fade form_box modalCustom" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="reschedule_modal_batch_schedulename"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td width="50%">Center Name:</td>
                                    <td id="reschedule_modal_centername"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Batch Name:</td>
                                    <td id="reschedule_modal_batchname"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Class Topic:</td>
                                    <td id="reschedule_modal_classtopic"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Topic Content:</td>
                                    <td id="reschedule_modal_classcontent"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Faculty:</td>
                                    <td id="reschedule_modal_faculty"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Room:</td>
                                    <td id="reschedule_modal_room"></td>
                                </tr>
                                <tr>
                                    <td width="50%">Date and time:</td>
                                    <td id="reschedule_modal_datetime"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="reschedule_modal_batch_button" class="btn btn-success">Reschedule</button>
                        <button type="button" id="delete_modal_batch_button" class="btn btn-danger">Delete schedule</button>
                    </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
        $(function() {
            $(".news_tick").bootstrapNews({
                newsPerPage: 2,
                autoplay: true,
                pauseOnHover: true,
                direction: 'up',
                newsTickerInterval: 4000,
                onToDo: function() {
                    //console.log(this); 
                }
            });

        });
    <?php if(ENVIRONMENT != 'development'){ ?>
       /* document.addEventListener('contextmenu', event => event.preventDefault());
        $(document).ready(function() {
            $(".disableEvent").on("contextmenu",function(){
                return false;
            }); 
            $('.disableEvent').bind('cut copy paste', function (e) {
                e.preventDefault();
            });
        });*/
    <?php } ?>

</script>

<script type="text/javascript">
    function create_calendar(height='',url=''){
        if(url==''){
            url = base_url+"backoffice/calendar/get_calendar_events";
        }
        if(height==''){
            height = 650;
        }
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek',
            },
            buttonText: {
                today:    'Today',
                month:    'Month',
                week:     'Week',
                day:      'Day',
                list:     'List',
            },
            // titleFormat: 'DD - MM - YYYY',
            allDayText: 'All Day',
            height: height,
            navLinks: true, // can click day/week names to navigate views
            editable: false,
            eventLimit: true,
            defaultView: 'month', // allow "more" link when too many events
            eventSources: [{
                url: url,
                type: 'GET',
                cache: false
            }],
        });

        $('#calendar111').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek',
            },
            buttonText: {
                today:    'Today',
                month:    'Month',
                week:     'Week',
                day:      'Day',
                list:     'List',
            },
            // titleFormat: 'DD - MM - YYYY',
            allDayText: 'All Day',
            height: height,
            navLinks: true, // can click day/week names to navigate views
            editable: false,
            eventLimit: true,
            defaultView: 'month', // allow "more" link when too many events
            eventSources: [{
                url: url,
                type: 'GET',
                cache: false
            }],
        });

    }

    function update_calendar(url=''){
        // create_calendar();
        if(url==''){
            url = base_url+"backoffice/calendar/get_calendar_events";
        }
        $('#calendar').fullCalendar('removeEvents', function () { return true; });
        $('#calendar').fullCalendar('removeEventSource', url);
        $('#calendar').fullCalendar( 'addEventSource', url);  
    }

    function reschedule(id){
        $(".loader").show();
        $.ajax({
            url: base_url+"backoffice/calendar/reschedule_permission",
            type: "GET",
            data: {id:id},
            success: function (data) {
                var obj = JSON.parse(data);
                if(obj.data.schedule_type==1){
                    $("#reschedule_modal_examname").html(obj.data.examname);
                    $("#reschedule_modal_examdate").html(obj.data.schedule_date);
                    $("#reschedule_modal_examstime").html(obj.data.schedule_start_time);
                    $("#reschedule_modal_exametime").html(obj.data.schedule_end_time);
                    $("#reschedule_modal_examroom").html(obj.data.description);
                    $("#reschedule_modal_batch").html(obj.data.batch_name);
                    $("#reschedule_modal_schedulename").html(obj.data.schedule_description);
                    $("#reschedule_modal_examresult").html(obj.data.result_immeadiate);
                    $("#reschedule_modal_examstatus").html(obj.data.statusname);
                    $("#reschedule_modal_exam").modal('show');
                    if(obj.st){
                        $("#reschedule_modal_exam_button").show();
                        $("#delete_modal_exam_button").show();
                        $("#reschedule_modal_exam_button").val(obj.data.schedule_id);
                        $("#delete_modal_exam_button").val(obj.data.schedule_id);
                    }else{
                        $("#reschedule_modal_exam_button").hide();
                        $("#delete_modal_exam_button").hide();
                    }
                }
                if(obj.data.schedule_type==2){
                    $("#reschedule_modal_centername").html(obj.data.center_name);
                    $("#reschedule_modal_batchname").html(obj.data.batch_name);
                    $("#reschedule_modal_classtopic").html(obj.data.module_name);
                    $("#reschedule_modal_classcontent").html(obj.data.module_content);
                    $("#reschedule_modal_faculty").html(obj.data.faculty_name);
                    $("#reschedule_modal_room").html(obj.data.classroom_name);
					$("#reschedule_modal_datetime").html(obj.data.reschedule_modal_datetime);
                    $("#reschedule_modal_batch_schedulename").html(obj.data.schedule_description);
                    $("#reschedule_batch_modal").modal('show');
                    if(obj.st && obj.data.class_taken==0){
                        $("#reschedule_modal_batch_button").show();
                        $("#delete_modal_batch_button").show();
                        $("#reschedule_modal_batch_button").val(obj.data.schedule_id);
                        $("#delete_modal_batch_button").val(obj.data.schedule_id);
                    }else{
                        $("#reschedule_modal_batch_button").hide();
                        $("#delete_modal_batch_button").hide();
                    }
                }
                $(".loader").hide();
            }
        });
    }
</script>
<script>
    $("#contactus_footer").validate({

        rules: {
            enquiry_name: {
                required: true
            },
            enquiry_phone: {
                required: true, 
                number:true,
                minlength: 10,
                maxlength: 12

            },
            enquiry_email: {
                required: true,
                email:true

            },

        },
        messages: {
            enquiry_name: "Please Enter the Name",
            enquiry_phone:{
                required:"Please Enter the Phone Number",
                number:"Please Enter valid Phone Number",
            } ,
            enquiry_email: {
                           required:"Please Enter the Email",
                           email:"Please Enter Valid Email Id"},



        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>Home/enquiry_add',
                type: 'POST',
                data: $("#contactus_footer").serialize(),
                success: function(response) {
                    if(response == 1){
                        $("#contactus_footer")[0].reset();
                        $(".box").css("display", "none");
                        $("#info_msg").css("display", "inline");
                        $("#info_close").css("display", "none");
                        $("#don").attr('class', 'fixed_msg');
                        $.toaster({priority:'success',title:'Success',message:'Submitted Succesfully!'});
                    }
                    else{
                        $.toaster({priority:'danger',title:'Error',message:'Network Error! Please try agin later'});
                    }
                    $(".loader").hide();
                }
            });
        }
         });

</script>
