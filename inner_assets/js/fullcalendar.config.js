$('#dashcalendar').fullCalendar({
        schedulerLicenseKey: '0646661195-fcs-1511542805',
        defaultView: dashcalview,
        defaultDate: dashcaldate,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'agendaDay,agendaWeek,month'
        },
        navLinks: true,
		navLinkDayClick: function(date, jsEvent) {

           //console.log('day', date.format()); // date is a moment

		   var dtaa = date.format();

		   $('#dashcalendar').fullCalendar('changeView', 'agendaDay', dtaa);

            $.post(base_url + 'Dashboard/day_appointments', {
				therapy_csrf_token: csrfHash,
                day: date.format()

            }, function (data) {

                console.log(JSON.parse(data));

                var obj = JSON.parse(data);

                var seldate = obj.date.split(' ');

//                seldate = seldate.replace('/','-');

                var datestr = '';

                for(i=0;i<seldate.length;i++) {

                    datestr += seldate[i];

                    if(i < (seldate.length-1)) {

                        datestr += '-';

                    }

                }

//                alert(obj.date);

//                alert(datestr);

                $("#ql_dash_seldate").html(obj.date);

                $("#total-appointments").html(obj.total_apnts);

//                $("#total-appointments").closest('tr').on('click', function() {

//                    window.location = base_url + 'Appointments/index/' + datestr;

//                });

                $("#total-appointments").closest('tr').attr('onclick','location.href="'+base_url+'Appointments/index/'+datestr+'"');

                $("#completed-appointments").html(obj.apntCompleted);

//                $("#completed-appointments").closest('tr').on('click', function() {

//                    window.location = base_url + 'Appointments/index/' + datestr;

//                });

                $("#completed-appointments").closest('tr').attr('onclick','location.href="'+base_url+'Appointments/index/'+datestr+'"');

                $("#in-progress").html(obj.apntInprogress);

//                $("#in-progress").closest('tr').on('click', function() {

//                    window.location = base_url + 'Appointments/index/' + datestr;

//                });

                $("#in-progress").closest('tr').attr('onclick','location.href="'+base_url+'Appointments/index/'+datestr+'"');      

                var nshw = obj.apntNoshow;

                var cncl = obj.apntStat;

                $("#cnclnshw-appointments").html(nshw+cncl);

//                $("#cnclnshw-appointments").closest('tr').on('click', function() {

//                    window.location = base_url + 'Appointments/cancellednoshow/' + seldate.replace('/','-');

//                });

                $("#cnclnshw-appointments").closest('tr').attr('onclick','location.href="'+base_url+'Appointments/cancellednoshow/'+datestr+'"');

                $("#pending-appointments").html(obj.total_apnts-(obj.apntCompleted+obj.apntInprogress+(nshw+cncl)));   

            });

        },
		slotDuration: '00:30:00',
        snapDuration: '00:15:00',
        views: {
            agendaWeek: {
                columnFormat: 'ddd DD MMM',
            },
            agendaDay: {

                // views that are more than a day will NOT do this behavior by default
                // so, we need to explicitly enable it
                groupByResource: true,
                titleFormat: 'dddd DD MMMM YYYY',
                //// uncomment this line to group by day FIRST with resources underneath
                //groupByDateAndResource: true
            }
        },
        minTime: '07:00:00',
        maxTime: '19:00:00',
        height: 655,
        editable: true,
        eventDurationEditable: false,
        droppable: true, // this allows things to be dropped onto the calendar
        eventDragStart: function (event, jsEvent, ui, view) {

        },

        eventDrop: function (event, delta, revertFunc, jsEvent, ui, view) { //alert(view); 

            sessionStorage.setItem('dragapntid', event.apntidstr);
            var dragapntid = sessionStorage.getItem('dragapntid');
            console.log(dragapntid);
            //            var clres = confirm('Are you sure to reschedule this appointment');
            var dt = event.start.format();
            var time = moment(dt).format('HH:mm:ss');
            var Ddate = moment(dt).format("YYYY-MM-DD");
            $("#dash_reason_error").hide();
            $("#reschedule_apntIdstr").val(event.apntidstr);
            $("#reschedule_newTime").val(time);
            $("#reschedule_newDur").val(event.duration);
            $("#reschedule_newDate").val(Ddate);
            $("#reschedule_cid").val(event.cid);
            $("#reschedule_chksts").val(event.chksts);

            $("#dash_reschedule").modal({
                backdrop: 'static',
                keyboard: false
            });


            $('#dash_btncancel').on('click', function (e) {
                revertFunc();
            });
            $('#dash_reschedule .close').on('click', function (e) {
                revertFunc();
                $("#dshresch_reasontext").val('');
            });
            $('#rechedule_log').on('hidden.bs.modal', function (e) {
                revertFunc();
                $("#dshresch_reasontext").val('');
            });

            //          
        },
        eventClick: function (event, jsEvent, view) {
            $("#caldasheventshow .modal-header").css('background-color', event.backgroundColor);
            // $('#modalTitle').html(event.time);
            // var htmlstr = '<label>Appointment With: </label>'+'<label>'+event.with+'</label><br><label>Appointment For: </label>'+'<label>'+event.modaltitle+'</label><br><label>Mother Name: </label>'+'<label>'+event.moname+'</label><br><label>Contact Number: </label>'+'<label>'+event.mophone+'</label><br><label>Description: </label>'+'<label>'+event.desc+'</label> <br><label>Discipline: </label>'+'<label>'+event.dgnation+'</label> <br><label>Room: </label>'+'<label>'+event.room+'</label>';
            var datee = event.start.format('dddd DD MMM YYYY');
            if (event.desc == null) {
                var descrip = "";
            } else {
                var descrip = event.desc;
            }

            if (event.typeName == null) {
                var typeName = '';
            } else {
                var typeName = event.typeName;
            }

				
										if (event.chksts == '1') {
										var appntaStatus = 'Booked';
										} else if (event.chksts == '2') {
										//var appntaStatus = 'Checked In';
	 var appntaStatus = '<button type="button" class="btn btn-danger glyphicon glyphicon-time pull-right3 checkedin checkinstat" id="checkinstat'+ event.apntidstr +'" data-stat="'+ event.chksts +'">Checked In</button>';
									
										} else if (event.chksts == '3') {
										//var appntaStatus = 'In Progress';
	var appntaStatus = '<button type="button" class="btn btn-info pull-right3 glyphicon glyphicon-time ainprogress checkinstat" id="checkinstat'+ event.apntidstr +'" data-stat="'+ event.chksts +'">In Progress</button>';
										} else if (event.chksts == '4') {
										//var appntaStatus = 'Completed';
	var appntaStatus = '<button type="button" class="btn btn-grey glyphicon glyphicon-ok pull-right3 acompleted checkinstat" id="checkinstat'+ event.apntidstr +'" data-stat="'+ event.chksts +'">Completed</button>';
										} else if (event.chksts == '5') {
										//var appntaStatus = 'No Show';
										
	var appntaStatus = '<button type="button" class="btn btn-info anoshow pull-right3" id="checkinstat'+ event.apntidstr +'" data-stat="'+ event.chksts +'">No Show</button>';
										}
										

            $('#modalTitle').html(datee + ', ' + event.time);
            if (event.chkchildid == RESERVED_CHILD) {
                var htmlstr = '<div class="row"><label class="col-md-3 col-lg-3 col-sm-3 col-xs-12">Description: </label>' + '<label class="col-md-9 col-lg-9 col-sm-9 col-xs-12">' + descrip + '</label></div><div class="row"><label class="col-md-3 col-lg-3 col-sm-3 col-xs-12">Meeting With: </label>' + '<label class="col-md-9 col-lg-9 col-sm-9 col-xs-12">' + event.trpwith + '</label></div><div class="row"><label class="col-md-3 col-lg-3 col-sm-3 col-xs-12">Contact Number: </label>' + '<label class="col-md-9 col-lg-9 col-sm-9 col-xs-12">' + event.mophone + '</label></div><div class="row"><label class="col-md-3 col-lg-3 col-sm-3 col-xs-12">Room: </label>' + '<label class="col-md-9 col-lg-9 col-sm-9 col-xs-12">' + event.room + '</label></div>';
            } else {
                var htmlstr = '<div class="row"><label class="col-md-3 col-lg-3 col-sm-3 col-xs-12">Appointment With: </label>' + '<label class="col-md-9 col-lg-9 col-sm-9 col-xs-12">' + event.trpwith + '</label></div><div class="row"><label class="col-md-3 col-lg-3 col-sm-3 col-xs-12"><b>Child : </b> </label>' + '<label class="col-md-9 col-lg-9 col-sm-9 col-xs-12"><a style="background-color:grey;color:white;padding:3px;" href="' + base_url + 'Members/view/' + event.cid + '">' + event.child + '</a></label></div><div class="row"><label class="col-md-3 col-lg-3 col-sm-3 col-xs-12">Mother Name: </label>' + '<label class="col-md-9 col-lg-9 col-sm-9 col-xs-12">' + event.moname + '</label></div><div class="row"><label class="col-md-3 col-lg-3 col-sm-3 col-xs-12">Contact Number: </label>' + '<label class="col-md-9 col-lg-9 col-sm-9 col-xs-12">' + event.mophone + '</label></div><div class="row"><label class="col-md-3 col-lg-3 col-sm-3 col-xs-12">Description: </label>' + '<label class="col-md-9 col-lg-9 col-sm-9 col-xs-12">' + descrip + '</label></div><div class="row"><label class="col-md-3 col-lg-3 col-sm-3 col-xs-12">Type </label>' + '<label class="col-md-9 col-lg-9 col-sm-9 col-xs-12">' + typeName + '</label></div><div class="row"><label class="col-md-3 col-lg-3 col-sm-3 col-xs-12">Discipline: </label>' + '<label class="col-md-9 col-lg-9 col-sm-9 col-xs-12">' + event.dgnation + '</label> </div><div class="row"><label class="col-md-3 col-lg-3 col-sm-3 col-xs-12">Room: </label>' + '<label class="col-md-9 col-lg-9 col-sm-9 col-xs-12">' + event.room + '</label></div><div class="row"><label class="col-md-3 col-lg-3 col-sm-3 col-xs-12">Status: </label>' + '<label class="col-md-9 col-lg-9 col-sm-9 col-xs-12">' + appntaStatus + '</label></div>';
            }
            if (event.chksts < 2) {
                htmlstr += event.rshcncl
            }
            $('#caleventdash').html(htmlstr);
            $('#caldasheventshow').modal({
                backdrop: 'static',
                keyboard: false
            });
            if (event.eventtype == 2) {
                $('<a class="btn btn-success pull-left" id="dashcnfrmapnt" >Confirm Appointment</a>').insertBefore('.dashrshapnt');
            }
			
        },
        viewRender: function (view, element) {
			$('#dashcalendar button.fc-today-button').removeClass('fc-state-disabled').prop('disabled', false);
            $('#dashcalendar').fullCalendar('removeResource');
            var d = view.start;
            var date = d._d;
            var date = $('#dashcalendar').fullCalendar('getDate');
            var ssdate = $('#dashcalendar').fullCalendar('getView').intervalStart;
            var eedate = $('#dashcalendar').fullCalendar('getView').intervalEnd;
            var Ddate = moment(ssdate).format("YYYY-MM-DD");
            var Dedate = moment(eedate).format("YYYY-MM-DD");
            var curdate = moment().format("YYYY-MM-DD");
			//alert(curdate);
            var user = [];
            $("input:checkbox[name=trpcon]:checked").each(function () {
                user.push($(this).val());
            });
            var selview = view.type;
            $("#dashcalview").val(selview);
            $("#dashcaldate").val(Ddate);
            sessionStorage.setItem('dashcalview', selview);
            sessionStorage.setItem('dashcaldate', Ddate);
            //console.log(user);

            if (view.type != 'agendaDay') {
                if ($.inArray('all', user) !== -1) {

                    $.post(base_url + 'Appointments/appointmentsofdate', {
							therapy_csrf_token: csrfHash,
                            date: Ddate,
                            curView: selview
                        },
                        function (data) {

                            if (!data) {
                                $('#dashcalendar').fullCalendar('removeEvents');
                            } else {
                                //console.log(data);
                                var obj = JSON.parse(data);

                                var events = [];
                                $.each(obj, function (i, value) {
                                    if (obj[i]['eventtype'] == 1) {
                                        var cal_title = obj[i]['description'];
                                    } else if (obj[i].eventtype == 0) {
                                        var cal_title = obj[i]['cfname'] + ' ' + obj[i]['clname'];
                                    } else {
                                        var cal_title = obj[i]['cfname'] + ' ' + obj[i]['clname'];
                                    }
									 if (obj[i]['apntdate'] == curdate && obj[i]['eventtype'] != 1) {
										 var checkinButton = '<button type="button" class="btn btn-info pull-right checkin checkinstat" id="checkinstat'+ obj[i]['apntIdstr'] +'" data-stat="'+ obj[i]['checkinstat'] +'">Check In</button>';
									} else { var checkinButton = ''; }
										
									 
                                    events.push({
                                        //                                    
                                        title: cal_title,
                                        chksts: obj[i]['checkinstat'],
                                        child: obj[i]['cfname'] + ' ' + obj[i]['clname'],
                                        time: obj[i]['apnttime_event'] + ' - ' + obj[i]['etime_event'],
                                        //with: $(".doctor-list > li > div > span#"+obj[i].appointmentwith).text(),
                                        eventtype: obj[i]['eventtype'],
                                        chkchildid: obj[i]['appointmentfor'],
                                        trpwith: obj[i]['apntwithname'],
                                        start: moment(obj[i]['apntdate'] + "T" + obj[i]['apnttime']),
                                        end: moment(obj[i]['apntdate'] + "T" + obj[i]['etime']),
                                        backgroundColor: obj[i]['trpcolor'],
                                        moname: obj[i]['nm_mthr'],
                                        mophone: obj[i]['mthr_ph'],
                                        room: obj[i]['rdesc'],
                                        desc: obj[i]['description'],
                                        dgnation: obj[i]['th_name'],
                                        apntidstr: obj[i]['apntIdstr'],
                                        cid: obj[i]['cid'],
                                        duration: obj[i]['duration'],
                                        className: 'appstatus' + obj[i]['checkinstat'] + ' ' + obj[i]['classname'],
                                        typeName: obj[i]['typeName'],
                                        rshcncl: '<div><a data-direct="pagestat_dash" data-href="' + base_url + 'Appointments/reschedule/' + obj[i]['apntIdstr'] + '" class="btn btn-warning pull-right  dashrshapnt" >Re-Schedule</a><a class="btn btn-danger pull-right" id="dashcnclapnt" >Cancel</a>'+ checkinButton +'</div><br><br><div id="dashcalapnt_cancel" style="display:none;"><form action="' + base_url + 'Appointments/reschedule/" method="post" enctype="multipart/form-data" id="cancelreason" ><input type="hidden" value="' + obj[i]['apntIdstr'] + '" name="aptcancel_id" id="aptcancel_id"/><input type="hidden" value="' + obj[i]['apntdate'] + '" name="aptcancel_dat" id="aptcancel_dat"/><input type="hidden" name="redirect_page" value="dashboard"><input type="hidden" name="appointmentofchild" id="appointmentofchild" value="' + obj[i]['cid'] + '"><p id="reasonErr" style="color:#FF0000;"></p><span id="cancelApp"><div class="row"><div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><label class="label-user" for="role">Reason<font style="color: red;"> *</font></label></div><div class="col-lg-8 col-md-8  col-sm-8 col-xs-12"><div class="form-group"><select name="reasontext" id="reasontext" class="form-control" ><option value="Travelling">Travelling</option><option value="Sick">Sick</option><option value="Wrong Booking">Wrong Booking</option><option value="Correction">Correction</option><option value="Therapist Not Available">Therapist Not Available</option><option value="Others">Others</option></select><br><textarea class="form-control nodisp" name="reasontextOthers" id="reasontextOthers" placeholder="Specify Reason..."></textarea></div></div></div></span><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><button type="submit" class="btn btn-success btn-add ">Submit</button><button class="btn btn-warning btn-add" data-dismiss="modal">Cancel</button></div></div><input type="hidden" name="' + csrfName + '" value="' + csrfHash + '" /> </form></div><div id="dashcalapnt_confirm" style="display:none;"><form action="' + base_url + 'Appointments/confirm/" method="post" enctype="multipart/form-data" id="confirm" ><input type="hidden" value="' + obj[i]['apntIdstr'] + '" name="aptconfirm_id" id="aptconfirm_id"/><input type="hidden" value="' + obj[i]['apntdate'] + '" name="aptconfirm_dat" id="aptconfirm_dat"/><input type="hidden" name="appointmentofchild" id="appointmentofchild" value="' + obj[i]['cid'] + '"><input type="hidden" name="pagestat_apnttype" id="pagestat_apnttype" value="dashboard"><span id="confirmApp"></span><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><button type="submit" class="btn btn-success btn-add ">Submit</button><button class="btn btn-warning btn-add" data-dismiss="modal">Cancel</button></div></div><input type="hidden" name="' + csrfName + '" value="' + csrfHash + '" /> </form></div>'
                                    });
                                });
								
                                $('#dashcalendar').fullCalendar('removeEvents');
                                $('#dashcalendar').fullCalendar('removeEventSource', events);
                                $('#dashcalendar').fullCalendar('addEventSource', events);
                                //                        $('#dashcalendar').fullCalendar( 'renderEvents', events );
                            }

                        });
                } else {
                    //                
                    $.post(base_url + 'Appointments/appointmentsofdate', {
							therapy_csrf_token: csrfHash,
                            date: Ddate,
                            user: JSON.stringify(user),
                            curView: selview
                        },
                        function (data) {
                            //                    //console.log(data);
                            if (!data) {
                                $('#dashcalendar').fullCalendar('removeEvents');
                            } else {
                                var obj = JSON.parse(data);
                                //  //console.log(obj);
                                var events = [];
                                $.each(obj, function (i, value) {
                                    if (obj[i]['eventtype'] == 1) {
                                        var cal_title = obj[i]['description'];
                                    } else if (obj[i].eventtype == 0) {
                                        var cal_title = obj[i]['cfname'] + ' ' + obj[i]['clname'];
                                    } else {
                                        var cal_title = obj[i]['cfname'] + ' ' + obj[i]['clname'];
                                    }
                                    events.push({
                                        //                                id: (i+1),
                                        //                                resourceId: obj[i].appointmentwith,
                                        //								
                                        title: cal_title,
                                        chksts: obj[i]['checkinstat'],
                                        child: obj[i]['cfname'] + ' ' + obj[i]['clname'],
                                        time: obj[i]['apnttime_event'] + ' - ' + obj[i]['etime_event'],
                                        //with: $(".doctor-list > li > div > span#"+obj[i].appointmentwith).text(),
                                        eventtype: obj[i]['eventtype'],
                                        chkchildid: obj[i]['appointmentfor'],
                                        trpwith: obj[i]['apntwithname'],
                                        start: moment(obj[i]['apntdate'] + "T" + obj[i]['apnttime']),
                                        end: moment(obj[i]['apntdate'] + "T" + obj[i]['etime']),
                                        backgroundColor: obj[i]['trpcolor'],
                                        moname: obj[i]['nm_mthr'],
                                        mophone: obj[i]['mthr_ph'],
                                        room: obj[i]['rdesc'],
                                        desc: obj[i]['description'],
                                        dgnation: obj[i]['th_name'],
                                        apntidstr: obj[i]['apntIdstr'],
                                        cid: obj[i]['cid'],
                                        duration: obj[i]['duration'],
                                        className: 'appstatus' + obj[i]['checkinstat'] + ' ' + obj[i]['classname'],
                                        typeName: obj[i]['typeName'],
                                        rshcncl: '<div><a data-direct="pagestat_dash" data-href="' + base_url + 'Appointments/reschedule/' + obj[i]['apntIdstr'] + '" class="btn btn-warning pull-right  dashrshapnt" >Re-Schedule</a><a class="btn btn-danger pull-right" id="dashcnclapnt" >Cancel</a><button type="button" class="btn btn-info pull-right checkin checkinstat" id="checkinstat'+ obj[i]['apntIdstr'] +'" data-stat="'+ obj[i]['checkinstat'] +'">Check In</button></div><br><br><div id="dashcalapnt_cancel" style="display:none;"><form action="' + base_url + 'Appointments/reschedule/" method="post" enctype="multipart/form-data" id="cancelreason" ><input type="hidden" value="' + obj[i]['apntIdstr'] + '" name="aptcancel_id" id="aptcancel_id"/><input type="hidden" value="' + obj[i]['apntdate'] + '" name="aptcancel_dat" id="aptcancel_dat"/><input type="hidden" name="redirect_page" value="dashboard"><input type="hidden" name="appointmentofchild" id="appointmentofchild" value="' + obj[i]['cid'] + '"><p id="reasonErr" style="color:#FF0000;"></p><span id="cancelApp"><div class="row"><div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><label class="label-user" for="role">Reason<font style="color: red;"> *</font></label></div><div class="col-lg-8 col-md-8  col-sm-8 col-xs-12"><div class="form-group"><select name="reasontext" id="reasontext" class="form-control" ><option value="Travelling">Travelling</option><option value="Sick">Sick</option><option value="Wrong Booking">Wrong Booking</option><option value="Correction">Correction</option><option value="Therapist Not Available">Therapist Not Available</option><option value="Others">Others</option></select><br><textarea class="form-control nodisp" name="reasontextOthers" id="reasontextOthers" placeholder="Specify Reason..."></textarea></div></div></div></span><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><button type="submit" class="btn btn-success btn-add ">Submit</button><button class="btn btn-warning btn-add" data-dismiss="modal">Cancel</button></div></div><input type="hidden" name="' + csrfName + '" value="' + csrfHash + '" /> </form></div><div id="dashcalapnt_confirm" style="display:none;"><form action="' + base_url + 'Appointments/confirm/" method="post" enctype="multipart/form-data" id="confirm" ><input type="hidden" value="' + obj[i]['apntIdstr'] + '" name="aptconfirm_id" id="aptconfirm_id"/><input type="hidden" value="' + obj[i]['apntdate'] + '" name="aptconfirm_dat" id="aptconfirm_dat"/><input type="hidden" name="appointmentofchild" id="appointmentofchild" value="' + obj[i]['cid'] + '"><input type="hidden" name="pagestat_apnttype" id="pagestat_apnttype" value="dashboard"><span id="confirmApp"></span><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><button type="submit" class="btn btn-success btn-add ">Submit</button><button class="btn btn-warning btn-add" data-dismiss="modal">Cancel</button></div></div><input type="hidden" name="' + csrfName + '" value="' + csrfHash + '" /> </form></div>'
                                    });
                                });
                                $('#dashcalendar').fullCalendar('removeEvents');
                                $('#dashcalendar').fullCalendar('removeEventSource', events);
                                $('#dashcalendar').fullCalendar('addEventSource', events);
                                //                        $('#dashcalendar').fullCalendar( 'renderEvents', events );
                            }
                        });
                }
                $('.doctor-list').show();
            } else {
                //alert(view.type);

                //               $.post(base_url + 'Appointments/appointmentsofdate_day', {
				//						  therapy_csrf_token: csrfHash,
                //                        date: Ddate,
                //                        edate: Dedate,
                //                        curView: selview
                //                    }, 
                //                    function (data) {
                //
                //                        if(!data){
                //                            $('#dashcalendar').fullCalendar( 'removeEvents');
                //                        } else{
                //                            //console.log(data);
                //                            var obj = JSON.parse(data);
                //
                //                            var events = [];
                //                            $.each(obj, function (i, value) {
                //                                events.push({
                //                                    id: (i+1),
                //                                    resourceId: obj[i].appointmentwith,
                //									chkchildid: obj[i].appointmentfor,
                //									eventtype: obj[i].eventtype,
                //                                    title: obj[i].cfname + ' ' + obj[i].clname,
                //                                    chksts: obj[i].checkinstat,
                //                                    modaltitle: '<a href="'+base_url+'Members/view/'+obj[i].cid+'">'+obj[i].cfname + ' ' + obj[i].clname+'</a>',
                //                                    time: obj[i].apnttime_event + ' - ' + obj[i].etime_event,
                //                                    room: obj[i].rdesc,
                //                                    appointmentid: obj[i].apntid,
                //                                    duration: obj[i].duration,
                //                                    room_id: obj[i].room,
                //                                    with: $(".doctor-list > li > div > span#"+obj[i].appointmentwith).text(),
                //                                    start: moment(obj[i].apntdate+"T"+obj[i].apnttime),
                //                                    end: moment(obj[i].apntdate+"T"+obj[i].etime),
                //                                    apntidstr: obj[i].apntIdstr,
                //                                    backgroundColor:$('#trpcon'+obj[i].appointmentwith).data('color'),
                //                                    cid: obj[i].cid,
                //                                    moname: obj[i].nm_mthr,
                //                                    mophone: obj[i].mthr_ph,
                //                                    desc: obj[i].description,
                //                                    dgnation: obj[i].th_name,
                //									jsessions: obj[i].jsessions,
                //									className: 'meetingtype'+obj[i].eventtype,
                //                                    rshcncl: '<div><a href="'+base_url + 'Appointments/reschedule/'+obj[i].apntIdstr+'" class="btn btn-warning pull-right" >Re-Schedule</a><a class="btn btn-danger pull-right" id="dashcnclapnt" >Cancel</a></div><br><br><div id="dashcalapnt_cancel" style="display:none;"><form action="'+base_url+'Appointments/reschedule/" method="post" enctype="multipart/form-data" id="cancelreason" ><input type="hidden" value="'+obj[i].apntIdstr+'" name="aptcancel_id" id="aptcancel_id"/><input type="hidden" name="redirect_page" value="dashboard"><input type="hidden" name="appointmentofchild" id="appointmentofchild" value="'+obj[i].cid+'"><p id="reasonErr" style="color:#FF0000;"></p><span id="cancelApp"><div class="row"><div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><label class="label-user" for="role">Reason<font style="color: red;"> *</font></label></div><div class="col-lg-8 col-md-8  col-sm-8 col-xs-12"><div class="form-group"><textarea class="form-control" name="reasontext" id="reasontext" data-bv-notempty="true" data-bv-notempty-message="Reason is required and cannot be empty"></textarea></div></div></div></span><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><button type="submit" class="btn btn-success btn-add ">Submit</button><button class="btn btn-warning btn-add" data-dismiss="modal">Cancel</button></div></div><input type="hidden" name="' + csrfName + '" value="' + csrfHash + '" /> </form></div>'
                //                                });
                //                            });
                //                            $('#dashcalendar').fullCalendar( 'removeEvents');
                //                            $('#dashcalendar').fullCalendar( 'removeEventSource', events );
                //                            $('#dashcalendar').fullCalendar( 'addEventSource', events );
                //    //                        $('#dashcalendar').fullCalendar( 'renderEvents', events );
                //                        }
                //
                //                    });      



                $.post(base_url + 'Appointments/appointmentsofdate_day', {
						therapy_csrf_token: csrfHash,
                        date: Ddate,
                        //                    curView: selview
                    },
                    function (data) {

                        if (!data) {
                            $('#dashcalendar').fullCalendar('removeEvents');
                        } else {
                            //console.log(data);
                            var obj = JSON.parse(data);

                            var events = [];
                            $.each(obj, function (i, value) {
                                if (obj[i]['typeName'] != null) {
                                    var typname = ' / ' + obj[i]['typeName'];
                                } else {
                                    var typname = "";
                                }
                                if (obj[i]['eventtype'] == 1) {

                                    var cal_title = obj[i]['description'] + ' - ' + typname;
                                } else if (obj[i].eventtype == 0) {
                                    var cal_title = obj[i]['cfname'] + ' ' + obj[i]['clname'] + typname;
                                } else {
                                    var cal_title = obj[i]['cfname'] + ' ' + obj[i]['clname'] + typname;
                                }
                                events.push({
                                    id: (i + 1),
                                    resourceId: obj[i]['appointmentwith'],
                                    title: cal_title,
                                    chksts: obj[i]['checkinstat'],
                                    child: obj[i]['cfname'] + ' ' + obj[i]['clname'],
                                    time: obj[i]['apnttime_event'] + ' - ' + obj[i]['etime_event'],
                                    //with: $(".doctor-list > li > div > span#"+obj[i].appointmentwith).text(),
                                    eventtype: obj[i]['eventtype'],
                                    chkchildid: obj[i]['appointmentfor'],
                                    trpwith: obj[i]['apntwithname'],
                                    start: moment(obj[i]['apntdate'] + "T" + obj[i]['apnttime']),
                                    end: moment(obj[i]['apntdate'] + "T" + obj[i]['etime']),
                                    backgroundColor: obj[i]['trpcolor'],
                                    moname: obj[i]['nm_mthr'],
                                    mophone: obj[i]['mthr_ph'],
                                    room: obj[i]['rdesc'],
                                    desc: obj[i]['description'],
                                    dgnation: obj[i]['th_name'],
                                    apntidstr: obj[i]['apntIdstr'],
                                    cid: obj[i]['cid'],
                                    duration: obj[i]['duration'],
                                    className: 'appstatus' + obj[i]['checkinstat'] + ' ' + obj[i]['classname'],
                                    typeName: obj[i]['typeName'],
                                    rshcncl: '<div><a data-direct="pagestat_dash" data-href="' + base_url + 'Appointments/reschedule/' + obj[i]['apntIdstr'] + '" class="btn btn-warning pull-right dashrshapnt" >Re-Schedule</a><a class="btn btn-danger pull-right" id="dashcnclapnt" >Cancel</a><button type="button" class="btn btn-info pull-right checkin checkinstat" id="checkinstat'+ obj[i]['apntIdstr'] +'" data-stat="'+ obj[i]['checkinstat'] +'">Check In</button></div><br><br><div id="dashcalapnt_cancel" style="display:none;"><form action="' + base_url + 'Appointments/reschedule/" method="post" enctype="multipart/form-data" id="cancelreason" ><input type="hidden" value="' + obj[i]['apntIdstr'] + '" name="aptcancel_id" id="aptcancel_id"/><input type="hidden" value="' + obj[i]['apntdate'] + '" name="aptcancel_dat" id="aptcancel_dat"/><input type="hidden" name="redirect_page" value="dashboard"><input type="hidden" name="appointmentofchild" id="appointmentofchild" value="' + obj[i]['cid'] + '"><p id="reasonErr" style="color:#FF0000;"></p><span id="cancelApp"><div class="row"><div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><label class="label-user" for="role">Reason<font style="color: red;"> *</font></label></div><div class="col-lg-8 col-md-8  col-sm-8 col-xs-12"><div class="form-group"><select name="reasontext" id="reasontext" class="form-control" ><option value="Travelling">Travelling</option><option value="Sick">Sick</option><option value="Wrong Booking">Wrong Booking</option><option value="Correction">Correction</option><option value="Therapist Not Available">Therapist Not Available</option><option value="Others">Others</option></select><br><textarea class="form-control nodisp" name="reasontextOthers" id="reasontextOthers" placeholder="Specify Reason..."></textarea></div></div></div></span><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><button type="submit" class="btn btn-success btn-add ">Submit</button><button class="btn btn-warning btn-add" data-dismiss="modal">Cancel</button></div></div><input type="hidden" name="' + csrfName + '" value="' + csrfHash + '" /> </form></div><div id="dashcalapnt_confirm" style="display:none;"><form action="' + base_url + 'Appointments/confirm/" method="post" enctype="multipart/form-data" id="confirm" ><input type="hidden" value="' + obj[i]['apntIdstr'] + '" name="aptconfirm_id" id="aptconfirm_id"/><input type="hidden" value="' + obj[i]['apntdate'] + '" name="aptconfirm_dat" id="aptconfirm_dat"/><input type="hidden" name="appointmentofchild" id="appointmentofchild" value="' + obj[i]['cid'] + '"><input type="hidden" name="pagestat_apnttype" id="pagestat_apnttype" value="dashboard"><span id="confirmApp"></span><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><button type="submit" class="btn btn-success btn-add ">Submit</button><button class="btn btn-warning btn-add" data-dismiss="modal">Cancel</button></div></div><input type="hidden" name="' + csrfName + '" value="' + csrfHash + '" /> </form></div>'
                                });
                            });
                            $('#dashcalendar').fullCalendar('removeEvents');
                            $('#dashcalendar').fullCalendar('removeEventSource', events);
                            $('#dashcalendar').fullCalendar('addEventSource', events);
                            //                        $('#dashcalendar').fullCalendar( 'renderEvents', events );
                        }

                    });

				$.post(base_url + 'Dashboard/day_appointments', {
					therapy_csrf_token: csrfHash,
                    day: date.format()
                }, function (data) {
                    console.log(JSON.parse(data));
                    var obj = JSON.parse(data);
                    var seldate = obj.date.split(' ');
                    var datestr = '';
                    for(i=0;i<seldate.length;i++) {
                        datestr += seldate[i];
                        if(i < (seldate.length-1)) {
                            datestr += '-';
                        }
                    }
    
                    $("#ql_dash_seldate").html(obj.date);
                    $("#total-appointments").html(obj.total_apnts);
    
                    $("#total-appointments").closest('tr').attr('onclick','location.href="'+base_url+'Appointments/index/'+datestr+'"');
                    $("#completed-appointments").html(obj.apntCompleted);
    
                    $("#completed-appointments").closest('tr').attr('onclick','location.href="'+base_url+'Appointments/index/'+datestr+'"');
                    $("#in-progress").html(obj.apntInprogress);
    
                    $("#in-progress").closest('tr').attr('onclick','location.href="'+base_url+'Appointments/index/'+datestr+'"');       
                    var nshw = obj.apntNoshow;
                    var cncl = obj.apntStat;
                    $("#cnclnshw-appointments").html(nshw+cncl);
    
                    $("#cnclnshw-appointments").closest('tr').attr('onclick','location.href="'+base_url+'Appointments/cancellednoshow/'+datestr+'"'); 
                    $("#pending-appointments").html(obj.total_apnts-(obj.apntCompleted+obj.apntInprogress+(nshw+cncl)));    
                });
                $('.doctor-list').hide();
            }
			
			$.post(base_url + 'Office/get_weekly_lv_vac', {
				therapy_csrf_token: csrfHash,
                sdate: Ddate,
                edate: Dedate
            }, function (data) {
                var obj = JSON.parse(data);
//                console.log(obj);
                $.each(obj, function (i) {
                    if (obj[i].date != null) {
                        trpstvacdate.push(moment(obj[i].date).format('YYYY-MM-DD'));
                        trpstvacnames.push(obj[i].uname);
                        trpstcolors.push(obj[i].ucolor);
                        trpstuid.push(obj[i].uid);
                    }
                });
                
                $.each(trpstvacdate, function(i){
                    var day = moment(trpstvacdate[i]).format('dddd');
//                    console.log(day);
                    if(view.type == 'agendaWeek'){
                        var cntnt = $(".fc-agendaWeek-view > table > .fc-body > tr > td.fc-widget-content > div.fc-unselectable > div.fc-week > div.fc-bg > table > tbody > tr > td[data-date='" + trpstvacdate[i] + "']").html();
                    } else if(view.type == 'agendaDay'){
                        
                        var cntnt = $(".fc-agendaDay-view > table > .fc-body > tr > td.fc-widget-content > div.fc-unselectable > div.fc-week > div.fc-bg > table > tbody > tr > td[data-date='" + trpstvacdate[i] + "']").html();
                        
                    } else if(view.type == 'month'){
                        var cntnt = $(".fc-month-view > table > .fc-body > tr > td.fc-widget-content > div.fc-day-grid-container > div.fc-unselectable > div.fc-week > div.fc-bg > table > tbody > tr > td[data-date='" + trpstvacdate[i] + "']").html();
                    }
                    var unames = trpstvacnames[i].split(',');
                    var ucolors = trpstcolors[i].split(',');
                    var uids = trpstuid[i].split(',');
                    var lvstr = '';
                    $.each(unames, function(i) {
                        lvstr += '<span style="background-color:'+ucolors[i]+'; color:white;">'+unames[i]+'</span><br>';
                    });
                    if(cntnt == '' && day != 'Friday') {
                        $(".fc-agendaWeek-view > table > .fc-body > tr > td.fc-widget-content > div.fc-unselectable > div.fc-week > div.fc-bg > table > tbody > tr > td[data-date='" + trpstvacdate[i] + "']").html(lvstr).css('text-align', 'center');
                        $.each(uids, function(i) {
                            lvstr = '<span style="background-color:'+ucolors[i]+'; color:white;">'+unames[i]+'</span><br>';
                            $(".fc-agendaDay-view > table > .fc-body > tr > td.fc-widget-content > div.fc-unselectable > div.fc-week > div.fc-bg > table > tbody > tr > td[data-resource-id='" + uids[i] + "']").html(lvstr).css('text-align', 'center'); 
                        });
                        
                        
                        $(".fc-month-view > table > .fc-body > tr > td.fc-widget-content > div.fc-day-grid-container > div.fc-unselectable > div.fc-week > div.fc-bg > table > tbody > tr > td[data-date='" + trpstvacdate[i] + "']").html(lvstr).css('text-align', 'center');
                    }
                    
                
                });
               
            });
			
            $.post(base_url + 'Office/get_weekly_public_holidays', {
				therapy_csrf_token: csrfHash,
                holDate: moment(date).format('YYYY-MM-DD')
            }, function (data) {
                if (data) {

                    //                    alert(hdate);
                    var obj = JSON.parse(data);
                    $.each(obj, function (i) {
                        //                        alert(i);
                        if (obj[i].dates != null) {
                            dashHdate.push(moment(obj[i].dates).format('YYYY-MM-DD'));
                            datedescrip.push(obj[i].description);
                        }

                        if (obj[i].days != null) {
                            if (obj[i].days == 0) {
                                $(".fc-sun").addClass('fc-holiday');
                            } else if (obj[i].days == 1) {
                                $(".fc-mon").addClass('fc-holiday');
                            } else if (obj[i].days == 2) {
                                $(".fc-tue").addClass('fc-holiday');
                            } else if (obj[i].days == 3) {
                                $(".fc-wed").addClass('fc-holiday');
                            } else if (obj[i].days == 4) {
                                $(".fc-thu").addClass('fc-holiday');
                            } else if (obj[i].days == 5) {
                                $(".fc-fri").addClass('fc-holiday');
                            } else if (obj[i].days == 6) {
                                $(".fc-sat").addClass('fc-holiday');
                            }
                        }
                    });

                }
            });
        },


        eventRender: function (event, eventElement) {
            if (event.eventtype == 0) {
                var eres = event.apntidstr;
                var echil = event.title;
                var estart = event.start;
                var ejsessionst = event.jsessions;
                //alert(eres);
                var has_hyphen = eres.indexOf("-") > -1;
                if (has_hyphen === true) {

                    eventElement.addClass('jointsess');
                    eventElement.addClass(ejsessionst);
                }


            } else {
                event.disableDragging = true;
            }


        },
        //        loading: function (bool) {
        //            if (bool) {
        //                var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character 
        //                var hash1 = hash.split('-')[0];
        //                var hash2 = hash.split('-')[1] + '-' + hash.split('-')[2] + '-' + hash.split('-')[3];
        //                //alert (hash1);
        //                if (hash) {
        //                    setTimeout(function () {
        //                        $('#dashcalendar').fullCalendar('changeView', hash1, hash2);
        //                    }, 1000);
        //                }
        //            }
        //        },
        eventAfterAllRender(view) {

        },
        resources: function (callback, start, end, timezone) {
            var date = $('#dashcalendar').fullCalendar('getDate');
            var Ddate = moment(date).format("YYYY-MM-DD");
            var user = $("[name='trpcon']:checked").val();
            if (user == 'all') {
                $.post(base_url + 'Appointments/appointmentsofdate_resources', {
					therapy_csrf_token: csrfHash,
                    date: Ddate,
                    trpcons: 1,
                }, function (data) {
                    ////console.log('resources');
                    ////console.log(data);
                    if (data) {
                        var trpObj = JSON.parse(data);
                        var resources = [];
                        $.each(trpObj, function (i, value) {
                            resources.push({
                                id: trpObj[i]['id'],
                                title: trpObj[i]['name'],
                                eventColor: trpObj[i]['color']
                            });
                        });
                        ////console.log(resources);
                        callback(resources);
                    }
                });
            }
        },
        dayClick: function (date, jsEvent, view) {
            var time = moment(date).format('HH:mm:ss');
            var Ddate = moment(date).format("YYYY-MM-DD");
            //            //console.log(time+'-------'+Ddate);
            var confMsg = 'Do you want to book an appointment at ' + moment(date).format('hh:mm A') + ' on ' + moment(date).format("dddd") + ', ' + moment(date).format("DD/MMM/YYYY");
            $("#conf_msg_text").html(confMsg);
            $("#fortime").val(time);
            $("#fordate").val(Ddate);
            var user = [];
            $("input:checkbox[name=trpcon]:checked").each(function () {
                user.push($(this).val());
            });
            $("#withtrpsts").val(JSON.stringify(user))
            $("#bookConfirm").modal({
                backdrop: 'static',
                keyboard: false
            });
        },
        dayRender: function (date, cell) {
            //            alert(moment(date).format('YYYY-MM-DD'));
            var hdate = moment(date).format('YYYY-MM-DD');
            if ($.inArray(hdate, dashHdate) !== -1) {
                var index = dashHdate.indexOf(hdate);
                $('td[data-date="' + hdate + '"]').addClass('fc-pholiday');
                $(".fc-agendaWeek-view > table > .fc-body > tr > td.fc-widget-content > div.fc-unselectable > div.fc-week > div.fc-bg > table > tbody > tr > td[data-date='" + hdate + "']").html(datedescrip[index]).css('text-align', 'center');
                $(".fc-agendaDay-view > table > .fc-body > tr > td.fc-widget-content > div.fc-unselectable > div.fc-week > div.fc-bg > table > tbody > tr > td[data-date='" + hdate + "']").html(datedescrip[index]).css('text-align', 'center');
                $(".fc-month-view > table > .fc-body > tr > td.fc-widget-content > div.fc-day-grid-container > div.fc-unselectable > div.fc-week > div.fc-bg > table > tbody > tr > td[data-date='" + hdate + "']").html(datedescrip[index]).css('text-align', 'center');
                //                            cell.addClass('fc-pholiday');
            }

        }
    });