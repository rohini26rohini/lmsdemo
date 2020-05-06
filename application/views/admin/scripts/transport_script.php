<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaV04M40_H5Nrq2AwjahlQaMGO4-YhwFo&libraries=places&callback=initMap" async defer></script>
<script>
// register jQuery extension
jQuery.extend(jQuery.expr[':'], {
    focusable: function (el, index, selector) {
        return $(el).is('a, button, :input, [tabindex]');
    }
});

$(document).on('keypress', 'input,select', function (e) {
    if (e.which == 13) {
        e.preventDefault();
        // Get all focusable elements on the page
        var $canfocus = $(':focusable');
        var index = $canfocus.index(this) + 1;
        if (index >= $canfocus.length) index = 0;
        $canfocus.eq(index).focus();
    }
});
var map;
var markersArray = [];
function initMap(counter){
    var lat_page = $("#lat_"+counter).val();
    var lon_page = $("#lon_"+counter).val();
    if (lat_page === "") {
        lat_page = "8.524139";
    }
    if (lon_page === "") {
        lon_page = "76.936638";
    }
    var latlng = new google.maps.LatLng(lat_page, lon_page);
    var myOptions = {
        zoom: 10,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    placeMarker(latlng);
    google.maps.event.addListener(map, "click", function (event)
    {
        placeMarker(event.latLng);
        document.getElementById("lat_"+counter).value = event.latLng.lat();
        document.getElementById("lon_"+counter).value = event.latLng.lng();
        var geocoder = new google.maps.Geocoder();
    });
    var markers = [];
    var pacinput = "<input id='pac-input' style='background-color: #fff;font-family: Roboto;font-size: 15px;font-weight: 300;margin-left: 12px;padding: 0 11px 0 13px;text-overflow: ellipsis; width: 300' class='controls' type='text' placeholder='Search Box' />";
    $('#search_box').html("");
    $('#search_box').append(pacinput);
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });
    searchBox.addListener('places_changed', function () {
        var places = searchBox.getPlaces();
        if (places.length === 0) {
            return;
        }
        codeAddress(counter);
        markers.forEach(function (marker) {
            marker.setMap(null);
        });
        markers = [];
        var bounds = new google.maps.LatLngBounds();
        var i =0;
        places.forEach(function (place) {
            i++;
            markers.push(new google.maps.Marker({
                map: map,
                title: place.name,
                position: place.geometry.location
            }));
            if (place.geometry.viewport) {
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });
}
function codeAddress(counter) {
    var geocoder = new google.maps.Geocoder();
    var address = document.getElementById("pac-input").value;
    geocoder.geocode({'address': address}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            placeMarker(results[0].geometry.location);
            var lat_val = results[0].geometry.location.lat();
            var lon_val = results[0].geometry.location.lng();
            document.getElementById("lat_"+counter).value = lat_val;
            document.getElementById("lon_"+counter).value = lon_val;
        } else {
            alert("Geocode was not successful for the following reason: " + status);
        }
    });
}

function placeMarker(location) {
    deleteOverlays();
    markersArray = [];
    var marker = new google.maps.Marker({
        position: location,
        map: map
    });
    markersArray.push(marker);
}
function deleteOverlays() {
    if (markersArray) {
        for (i in markersArray) {
            markersArray[i].setMap(null);
        }
        markersArray.length = 0;
    }
}

$(document).ready(function(){
    $("form#add_bus_form").validate({
        rules: {
            vehicle_number: {
                            required: true,
                            remote: {    
                                    url: '<?php echo base_url();?>backoffice/Transport/check_bus_number',
                                    type: 'POST',
                                    data: {
                                            vehicle_number: function() {
                                            return $("#busno").val();
                                            },
                                             <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                          }
                                    }
                            },
            vehicle_made: {required: true},
            vehicle_seat: {required: true}
        },
        messages: {
            vehicle_number: {required:"Please enter vehicle number",
                             remote:"This vehicle already exist",},
            vehicle_made: {required:"Please enter vehicle model/brand"},
            vehicle_seat: {required:"Please enter vehicle seating capacity"}
        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Transport/bus_add',
                type: 'POST',
                data: $("#add_bus_form").serialize(),
                success: function(response) {
                    if (response != 2 && response != 0) {
                        $('#add_bus').modal('toggle');
                        $('#add_bus_form' ).each(function(){
                            this.reset();
                        });
                        $.toaster({ priority : 'success', title : 'Success', message : 'Succesfully Added' });
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Transport/load_bus_ajax',
                                type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) {  
                                $('#syllabus_data').DataTable().destroy();
                                $("#syllabus_data").html(response);
                                $("#syllabus_data").DataTable({
                                    "searching": true,
                                    "bPaginate": true,
                                    "bInfo": true,
                                    "pageLength": 10,
                            //      "order": [[4, 'asc']],
                                    "aoColumnDefs": [
                                        {
                                            'bSortable': false,
                                            'aTargets': [0]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [1]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [2]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [3]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [4]
                                        }
                                    ]
                                });    
                                $(".loader").hide();
                            } 
                        }); 
                    }else if(response == 2){
                        $.toaster({ priority : 'danger', title : 'Error', message : 'Bus already exist' });
                    }
                    $(".loader").hide();
                }
            });
        }
    });

    $("form#edit_bus_form").validate({
        rules: {
            vehicle_number: {
                              required: true,
                              remote: {    
                                    url: '<?php echo base_url();?>backoffice/Transport/edit_check_bus_number',
                                    type: 'POST',
                                    data: {
                                            vehicle_number: function() {
                                            return $("#edit_vehicle_number").val();
                                            },
                                          id: function() {
                                            return $("#edit_bus_id").val();
                                            },
                                             <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                          }
                                    }
                            },
           
            vehicle_made: {required: true},
            vehicle_seat: {required: true}
        },
        messages: {
            vehicle_number: {required:"Please enter vehicle number",
                            remote:"This vehicle already exist"},
            vehicle_made: {required:"Please enter vehicle model/brand"},
            vehicle_seat: {required:"Please enter vehicle seating capacity"}
        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Transport/bus_edit',
                type: 'POST',
                data: $("#edit_bus_form").serialize(),
                success: function(response) {
                    if (response == 1) {
                        $('#edit_bus').modal('toggle');
                        $.toaster({ priority : 'success', title : 'Success', message : 'Bus Details Updated Successfully' });
                        $.ajax({
                                url: '<?php echo base_url();?>backoffice/Transport/load_bus_ajax',
                                type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) {  
                                $('#syllabus_data').DataTable().destroy();
                                $("#syllabus_data").html(response);
                                $("#syllabus_data").DataTable({
                                    "searching": true,
                                    "bPaginate": true,
                                    "bInfo": true,
                                    "pageLength": 10,
                            //      "order": [[4, 'asc']],
                                    "aoColumnDefs": [
                                        {
                                            'bSortable': false,
                                            'aTargets': [0]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [1]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [2]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [3]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [4]
                                        }
                                    ]
                                });    
                                $(".loader").hide();
                            } 
                        });
                    }
                    $(".loader").hide();
                }
            });
        }
    });


    $("form#add_route_form").validate({       //route
        rules: {
            route_name: {required: true},
            route_number: {required: true},
            role: {required: true},
            bus_id: {required: true}
        },
        messages: {
            route_name: {required: "Please enter route name"},
            route_number: {required: "Please enter route number"},
            role: {required: "Please choose a driver"},
            bus_id: {required: "Please choose a vehicle number"}
        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Transport/route_add',
                type: 'POST',
                data: $("#add_route_form").serialize(),
                success: function(response) {
                    if(response == 1){
                        // alert(response);
                        $.toaster({ priority : 'Warning', title : 'Warning', message : 'Please enter all fields' });
                    } else if (response != 2 && response != 0) {
                        $('#add_route').modal('toggle');
                        $('#add_route_form' ).each(function(){
                            this.reset();
                        });
                        $.toaster({ priority : 'success', title : 'Success', message : 'Succesfully Added' });
                        $.ajax({
                            url: '<?php echo base_url();?>backoffice/Transport/load_route_ajax',
                            type: 'POST',
                            data: {
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            },
                            success: function(response) {  
                                $('#syllabus_data').DataTable().destroy();
                                $("#syllabus_data").html(response);
                                $("#syllabus_data").DataTable({
                                    "searching": true,
                                    "bPaginate": true,
                                    "bInfo": true,
                                    "pageLength": 10,
                            //      "order": [[4, 'asc']],
                                    "aoColumnDefs": [
                                        {
                                            'bSortable': false,
                                            'aTargets': [0]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [1]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [2]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [3]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [4]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [5]
                                        }
                                    ]
                                });    
                                $(".loader").hide();
                            } 
                        });
                    }else if(response == 2){
                        $.toaster({ priority : 'danger', title : 'Error', message : 'Route already exist' });
                    }
                    $(".loader").hide();
                }
            });
        }
    });

    $("form#edit_route_form").validate({
        rules: {
            route_name: {required: true},
            route_number: {required: true},
            role: {required: true},
            bus_id: {required: true}
        },
        messages: {
            route_name: {required: "Please enter route name"},
            route_number: {required: "Please enter route number"},
            role: {required: "Please choose a driver"},
            bus_id: {required: "Please choose a vehicle number"}
        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Transport/route_edit',
                type: 'POST',
                data: $("#edit_route_form").serialize(),
                success: function(response) {
                    $(".loader").hide();
                    if (response == 1) {
                        $('#edit_route').modal('toggle');
                        $.toaster({ priority : 'success', title : 'Success', message : 'Route Details Updated Successfully' });
                        $.ajax({
                            url: '<?php echo base_url();?>backoffice/Transport/load_route_ajax',
                            type: 'POST',
                            data: {
                                <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                            },
                            success: function(response) {  
                                $('#syllabus_data').DataTable().destroy();
                                $("#syllabus_data").html(response);
                                $("#syllabus_data").DataTable({
                                    "searching": true,
                                    "bPaginate": true,
                                    "bInfo": true,
                                    "pageLength": 10,
                            //      "order": [[4, 'asc']],
                                    "aoColumnDefs": [
                                        {
                                            'bSortable': false,
                                            'aTargets': [0]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [1]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [2]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [3]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [4]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [5]
                                        }
                                    ]
                                });    
                                $(".loader").hide();
                            } 
                        });
                    } else {
                        $.toaster({ priority : 'warning', title : 'Warning', message : "Fee definition and amount can't edit, Route already assign to students" }); 
                    }
                    
                }
            });
        }
    });

     $("form#add_maintenance_form").validate({
        rules: {
            bus_id: {required: true},
            description: {required: true},
            date: {required: true},
            amount: {required: true}
        },
        messages: {
            bus_id: {required:"Please enter vehicle number"},
            description: {required:"Please enter description"},
            date: {required:"Please choose date"},
            amount: {required:"Please enter amount"}
        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Transport/maintenance_add',
                type: 'POST',
                data: $("#add_maintenance_form").serialize(),
                success: function(response) {
                    if (response != 2 && response != 0) {
                        $('#add_maintenance').modal('toggle');
                        $('#add_maintenance_form' ).each(function(){
                            this.reset();
                        });
                        $.toaster({ priority : 'success', title : 'Success', message : 'Succesfully Added' });
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Transport/load_maintenance_ajax',
                                type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) {  
                                $('#syllabus_data').DataTable().destroy();
                                $("#syllabus_data").html(response);
                                $("#syllabus_data").DataTable({
                                    "searching": true,
                                    "bPaginate": true,
                                    "bInfo": true,
                                    "pageLength": 10,
                            //      "order": [[4, 'asc']],
                                    "aoColumnDefs": [
                                        {
                                            'bSortable': false,
                                            'aTargets': [0]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [1]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [2]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [3]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [4]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [5]
                                        }
                                    ]
                                });    
                                $(".loader").hide();
                            } 
                        }); 
                    }else if(response == 2){
                        $.toaster({ priority : 'danger', title : 'Error', message : 'Maintenance details already exist' });
                    }
                    $(".loader").hide();
                }
            });
        }
    });

    $("form#edit_maintenance_form").validate({
        rules: {
            bus_id: {required: true},
            description: {required: true},
            date: {required: true},
            amount: {required: true}
        },
        messages: {
            bus_id: {required:"Please enter vehicle number"},
            description: {required:"Please enter description"},
            date: {required:"Please choose date"},
            amount: {required:"Please enter amount"}
        },
        submitHandler: function(form) {
            $(".loader").show();
            $.ajax({
                url: '<?php echo base_url();?>backoffice/Transport/maintenance_edit',
                type: 'POST',
                data: $("#edit_maintenance_form").serialize(),
                success: function(response) {
                    if (response == 1) {
                        $('#edit_maintenance').modal('toggle');
                        $.toaster({ priority : 'success', title : 'Success', message : 'Maintenance Details Updated Successfully' });
                        $.ajax({
                                url: '<?php echo base_url();?>backoffice/Transport/load_maintenance_ajax',
                                type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) {  
                                $('#syllabus_data').DataTable().destroy();
                                $("#syllabus_data").html(response);
                                $("#syllabus_data").DataTable({
                                    "searching": true,
                                    "bPaginate": true,
                                    "bInfo": true,
                                    "pageLength": 10,
                            //      "order": [[4, 'asc']],
                                    "aoColumnDefs": [
                                        {
                                            'bSortable': false,
                                            'aTargets': [0]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [1]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [2]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [3]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [4]
                                        },
                                        {
                                            'bSortable': false,
                                            'aTargets': [5]
                                        }
                                    ]
                                });    
                                $(".loader").hide();
                            } 
                        });
                    }
                    $(".loader").hide();
                }
            });
        }
    });

    createNewTextBox();
    $('#addButtonNewId').tooltipster();
    $('.minusButton').tooltipster();
    $('#add_route_form input,select,textarea').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        positionTracker: true,
        contentAsHTML: true,
        interactive: true,
        interactiveTolerance: 350,
        theme: 'tooltipster-punk',
        position: 'bottom',
    });

    $("#add_route_form").validate({
        errorPlacement: function (error, element) {
            $(element).tooltipster('update', $(error).text());
            $(element).tooltipster('show');
        },
        success: function (label, element) {
            $(element).tooltipster('hide');
        },
    });
    validation();
    //start new textbox dynamic
    $( "#new_textbox" ).on( "click", ".addButtonNewId", function() {
        $('#add_route_form input,select,textarea').tooltipster({
            trigger: 'custom',
            onlyOne: false,
            positionTracker: true,
            contentAsHTML: true,
            interactive: true,
            interactiveTolerance: 350,
            theme: 'tooltipster-punk',
            position: 'bottom',
        });
        $('.minusButton').tooltipster();
    });
    //end new textbox dynamic

    $('#edit_addButtonNewId').tooltipster();
    $('.minusButton').tooltipster();
    $('#edit_route_form input,select,textarea').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        positionTracker: true,
        contentAsHTML: true,
        interactive: true,
        interactiveTolerance: 350,
        theme: 'tooltipster-punk',
        position: 'bottom',
    });

    $("#edit_route_form").validate({
        errorPlacement: function (error, element) {
            $(element).tooltipster('update', $(error).text());
            $(element).tooltipster('show');
        },
        success: function (label, element) {
            $(element).tooltipster('hide');
        },
    });
    //start new edit textbox dynamic
    $( "#edit_new_textbox" ).on( "click", ".addButtonNewId", function() {
        // edit_createNewTextBox();
        $('#edit_route_form input,select,textarea').tooltipster({
            trigger: 'custom',
            onlyOne: false,
            positionTracker: true,
            contentAsHTML: true,
            interactive: true,
            interactiveTolerance: 350,
            theme: 'tooltipster-punk',
            position: 'bottom',
        });
        $('.minusButton').tooltipster();
    });
    //end new edit textbox dynamic
});

     
function delete_bus(id) {
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
                    $.post('<?php echo base_url();?>backoffice/Transport/delete_bus/', {
                        id: id,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    }, function(data) {
                        if (data == 1) {
                            $.toaster({priority:'success',title:'Success',message:'Successfully Deleted..!'});
                          
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Transport/load_bus_ajax',
                                type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) {  
                                    $('#syllabus_data').DataTable().destroy();
                                    $("#syllabus_data").html(response);
                                    $("#syllabus_data").DataTable({
                                        "searching": true,
                                        "bPaginate": true,
                                        "bInfo": true,
                                        "pageLength": 10,
                                //      "order": [[4, 'asc']],
                                        "aoColumnDefs": [
                                            {
                                                'bSortable': false,
                                                'aTargets': [0]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [1]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [2]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [3]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [4]
                                            }
                                        ]
                                    });    
                                    $(".loader").hide();
                                } 
                            });
                        }
                    });
                }
            },
            cancel: function() {
            },
        }
    });
}

function delete_route(id) {
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
                    $.post('<?php echo base_url();?>backoffice/Transport/delete_route/', {
                        id: id,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    }, function(data) {
                        var obj = JSON.parse(data);
                        if (obj.st == 1) {
                            $.toaster({priority:'success',title:'Success',message:obj.msg});
                            $.ajax({
                            url: '<?php echo base_url();?>backoffice/Transport/load_route_ajax',
                            type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) {  
                                    $('#syllabus_data').DataTable().destroy();
                                    $("#syllabus_data").html(response);
                                    $("#syllabus_data").DataTable({
                                        "searching": true,
                                        "bPaginate": true,
                                        "bInfo": true,
                                        "pageLength": 10,
                                //      "order": [[4, 'asc']],
                                        "aoColumnDefs": [
                                            {
                                                'bSortable': false,
                                                'aTargets': [0]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [1]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [2]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [3]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [4]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [5]
                                            }
                                        ]
                                    });    
                                    $(".loader").hide();
                                } 
                            });
                        }else if(obj.st == 2){
                            $.toaster({priority:'warning',title:'Warning',message:obj.msg});
                        }else{
                            $.toaster({priority:'danger',title:'Invalid',message:obj.msg});
                        }
                    });
                }
            },
            cancel: function() {
            },
        }
    });
}

function delete_maintenance(id) {
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
                    $.post('<?php echo base_url();?>backoffice/Transport/delete_maintenance/', {
                        id: id,
                        <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                    }, function(data) {
                        if (data == 1) {
                            $.toaster({priority:'success',title:'Success',message:'Successfully Deleted..!'});
                            $("#row_"+id).remove();
                            $.ajax({
                                url: '<?php echo base_url();?>backoffice/Transport/load_maintenance_ajax',
                                type: 'POST',
                                data: {
                                    <?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'
                                },
                                success: function(response) {  
                                    $('#syllabus_data').DataTable().destroy();
                                    $("#syllabus_data").html(response);
                                    $("#syllabus_data").DataTable({
                                        "searching": true,
                                        "bPaginate": true,
                                        "bInfo": true,
                                        "pageLength": 10,
                                //      "order": [[4, 'asc']],
                                        "aoColumnDefs": [
                                            {
                                                'bSortable': false,
                                                'aTargets': [0]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [1]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [2]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [3]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [4]
                                            },
                                            {
                                                'bSortable': false,
                                                'aTargets': [5]
                                            }
                                        ]
                                    });    
                                    $(".loader").hide();
                                } 
                            });
                        }
                    });
                }
            },
            cancel: function() {
            },
        }
    });
}

function get_busdata(id){
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Transport/get_bus_by_id/'+id,
        type: 'POST',
        data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(response) {
            var obj = JSON.parse(response);
            $("#edit_bus_id").val(obj.bus_id);
            $("#edit_vehicle_number").val(obj.vehicle_number);
            $("#edit_vehicle_made").val(obj.vehicle_made);
            $("#edit_vehicle_seat").val(obj.vehicle_seat);
            $("#edit_description").val(obj.description);
            $('#edit_bus').modal({
                show: true
            });
            $(".loader").hide();
        }
    });
}


function get_details(id){
         $("#stop_id").val(id);
        $(".loader").show();
        $.ajax({
        url: '<?php echo base_url();?>backoffice/Transport/view_route_by_id/'+id,
        type: 'POST',
        data:{stop_id:id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(response) {
            var obj = JSON.parse(response);
          
               // $("#view_route_number").html(obj.route_details.route_number);
                $("#view_route_number").html(obj.route_details.route_number);
                $("#view_route_name").html(obj.route_details.route_name);
                $("#view_vehicle_number").html(obj.route_details.vehicle_number);
                $("#view_driver").html(obj.route_details.name);
                //$("#view_route_fare").html(obj.stop_details.route_fare);
                $("#view_route_description").html(obj.route_details.description);
                $("#fees").html(obj.fees);
                $("#feeDef").html(obj.feeDef);
                var table = "<div class= 'table-responsive table_language'><table class='table table_followup table-sm table-bordered table-striped'>";
                table += "<tr><th>Sl. No.</th><th>Stop Name</th><th>Distance (KM)</th><th>Route Fare (INR)</th></tr>";
                var j = 0;
                $.each(obj.stop_details, function (i, v) {
                    j++;
                    table += "<tr><td>"+j+"</td><td>"+v.name+"</td><td>"+v.distance+"</td><td>"+v.route_fare+"</td></tr>";
                });
                table += "<table></div>";
                $("#stop_view").html(table);
            $('#view_route').modal({
                show: true
            });
            $(".loader").hide();
        }
    });
}

function get_maintenancedata(id){
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Transport/get_maintenance_by_id/'+id,
        type: 'POST',
        data:{<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(response) {
            var obj = JSON.parse(response);
            $("#edit_maintenance_id").val(obj.maintenance_id);
            $("#edit_bus_id").val(obj.bus_id);
            $("#edit_description").val(obj.description);
            $("#edit_date").val(obj.date);
            $("#edit_amount").val(obj.amount);
            $('#edit_maintenance').modal({
                show: true
            });
            $(".loader").hide();
        }
    });
}

function get_routedata(id){
    $("#edit_transport_id").val(id);
    $(".loader").show();
    $("#edit_loaddeposits").html('');
    $.ajax({
        url: '<?php echo base_url();?>backoffice/Transport/get_route_by_id/'+id,
        type: 'POST',
        data:{edit_transport_id:id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(response) {
            var obj = JSON.parse(response);
            $("#edit_transport_id").val(obj.route_details.transport_id);
            $("#edit_route_name").val(obj.route_details.route_name);
            $("#edit_role").val(obj.route_details.role);
            $("#edit_bus_id").val(obj.route_details.bus_id);
            $("#edit_route_number").val(obj.route_details.route_number);
            $("#edit_description").val(obj.route_details.description);
            $("#edit_fee_definition").val(obj.route_details.fee_definition);
            $("#edit_loaddeposits").html(obj.fees);
            var table = '<div class = "table-responsive table_language"><table class="table table-bordered table-striped table-sm" id="edit_no-more-tables">';
            table += '<thead><tr><th>Stop Name<span class="req redbold">*</span></th><th>Distance (KM)<span class="req redbold">*</span></th><th>Route Fare/Monthly<span class="req redbold">*</span></th><th>Location</th><th>Latitude<span class="req redbold">*</span></th><th>Longitude<span class="req redbold">*</span></th><th>Action</th></tr></thead><tbody>';
            var j = 0;
            $.each(obj.stop_details, function (i, v) {
                j++;
                table += '<tr id="edit_stop_tr_' + j + '" class="tr"><input  type="hidden" name="stop_id[' + j + ']" id="stop_id[' + j + ']" value="'+v.stop_id+'" />';
                table += '<td><input  type="text" name="name[' + j + ']" placeholder="Stop Name" class="stopname form-control" id="name_[' + j + ']" value="'+v.name+'" onclick="getstopname(this.id)" autocomplete="off"/></td>';
                table += '<td><input type="number" min="0" name="distance[' + j + ']"  placeholder="Distance"  class="form-control distance numberswithdecimal" value="'+v.distance+'" ></td>';
                table += '<td><input type="number" min="0" name="route_fare[' + j + ']"  placeholder="Route Fare/Monthly" class="form-control route_fare numberswithdecimal" value="'+v.route_fare+'" ></td>';
                table += '<td><input type="button" name="geo[' + j + ']"  name="geo[' + j + ']" id="geo_'+ j + '" placeholder="Location" class="btn btn-info btn-sm exclude-status" value="Geo Map" data-toggle="modal" data-target="#myModal" onclick="initMap('+ j + ');"></td>';
                table += '<td><div class="form_zero"><input  type="text" name="lat[' + j + ']" class="form-control numberswithdecimal" id="lat_'+ j + '" value="'+v.latitude+'"  placeholder="Latitude" readonly="readonly"/></div></td>';
                table += '<td><div class="form_zero"><input  type="text" name="lon[' + j + ']" class="form-control numberswithdecimal" id="lon_'+ j + '" value="'+v.longitude+'"  placeholder="Longitude" readonly="readonly" /></div></td>';
                table += '<td><button type="button" rel="tooltip" title="Click here to remove the stop" class="btn btn-default add_wrap_pos add_action minusButton btn btn-danger btn-xs" id="'+v.stop_id+'" value="'+v.stop_id+'" onclick="deletefunction(this.id,'+ j +');"><i class="fa fa-remove"></i></button></td>';
                table += '</tr>';
            });
            table += '</tbody><table></div>';
            $("#stop_edit").html(table);
            $('#edit_route').modal({
                show: true
            });
            $(".loader").hide();
        }
    });
}
/**
* This function will add dynamic textboxes to adding vessels
*/
var counter = 1;
function createNewTextBox() {
    var newTextBoxDiv = $(document.createElement('div')).attr("id", 'new_textbox' + counter);
    var markup = '';
    markup += '<tr id="stop_tr_' + counter + '" class="tr">';
    markup += '<td data-title="Stop Name"><input type="text"  class="stopname form-control" name="name[' + counter + ']" id="name_' + counter + '"  value="" placeholder="Stop name"  onclick="getstopname(this.id)" /></td>';
    markup += '<td><input type="number" min="0" name="distance[' + counter + ']" placeholder="Distance" class="form-control distance numberswithdecimal"></td>';
    markup += '<td><input type="number" min="0" name="route_fare[' + counter + ']" placeholder="Route Fare/Monthly" class="form-control route_fare numberswithdecimal"></td>';
    markup += '<td><input type="button"  name="geo[' + counter + ']" id="geo_'+ counter + '" placeholder="Location" class="btn btn-info btn-sm exclude-status geo" value="Geo Map" data-toggle="modal" data-target="#myModal" onclick="initMap('+counter+');"></td>';
    markup += '<td data-title="geolocation"> <div class="form_zero"><input type="text" class="form-control latitude numberswithdecimal " name="lat[' + counter + ']" id="lat_' + counter + '" placeholder="Latitude" readonly="readonly"/></div></td><td data-title="geolocation"> <div class="form_zero"><input type="text" class="form-control longitude numberswithdecimal longitude"  name="lon[' + counter + ']" id="lon_' + counter + '" placeholder="Longitude" readonly="readonly"/></div></td>';
    markup += '<td data-title=""><button  class="btn btn-default add_wrap_pos add_action minusButton btn btn-danger btn-xs" id="removeButton' + counter + '" onclick="removeTextbox(' + counter + ');" title="Click here to remove the stop" ><i class="fa fa-remove"></i></button></td>';
    markup += '</tr>';
    $('#no-more-tables > tbody').append(markup);
    counter++;
    validation();
}

/*
* This function will remove the dynamic textbox
*/
function removeTextbox(counter_value) {
    $('#stop_tr_' + counter_value).remove();
    return false;
}

var editcounter = 111;
function edit_createNewTextBox() {
    var newTextBoxDiv = $(document.createElement('div')).attr("id", 'edit_new_textbox' + editcounter);
    var markup = '';
    markup += '<tr id="edit_stop_tr_' + editcounter + '" class="tr">';
    markup += '<td><input type="text" class="stopname form-control" name="name[' + editcounter + ']" id="edit_name_' + editcounter + '"  value="" placeholder="Stop name"  onclick="getstopname(this.id)" /></td>';
    markup += '<td><input type="number" min="0" name="distance[' + editcounter + ']" placeholder="Distance" class="form-control distance numberswithdecimal"></td>';
    markup += '<td><input type="number" min="0" name="route_fare[' + editcounter + ']" placeholder="Route Fare/Monthly" class="form-control route_fare numberswithdecimal"></td>';
    markup += '<td><input type="button" name="geo[' + editcounter + ']" id="geo_'+ editcounter + '" placeholder="Location" class="btn btn-info btn-sm exclude-status geo" value="Geo Map" data-toggle="modal" data-target="#myModal" onclick="initMap('+editcounter+');"></td>';
    markup += '<td><div class="form_zero"><input type="text" class="form-control numberswithdecimal latitude" name="lat[' + editcounter + ']" id="lat_' + editcounter + '" placeholder="Latitude" readonly="readonly"/></div></td><td><div class="form_zero"><input type="text" class="form-control numberswithdecimal longitude"  name="lon[' + editcounter + ']" id="lon_' + editcounter + '" placeholder="Longitude" readonly="readonly"/></div></td>';
    markup += '<td><button class="btn btn-default add_wrap_pos add_action minusButton btn btn-danger btn-xs" id="edit_removeButton' + editcounter + '" onclick="edit_removeTextbox(' + editcounter + ');" title="Click here to remove the stop" ><i class="fa fa-remove"></i></button></td>';
    markup += '</tr>';
    $('#edit_no-more-tables > tbody').append(markup);
    editcounter++;
}
/*
* This function will remove the dynamic textbox
*/
function edit_removeTextbox(counter_value) {
    $('#edit_stop_tr_' + counter_value).remove();
    return false;
}

function deletefunction(stop_id, j) {
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>backoffice/Transport/delete_stop',
        data:{stop_id:stop_id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
        success: function(result) {
            if (result == 1) {
                var remove_id = $('#' + stop_id).val();
                $('#stop_tr_' + remove_id).remove();
                edit_removeTextbox(j);
            } else if(result == 2){
                $.toaster({priority:'warning',title:'Warning',message:'Sorry, Can\'t delete this stop. already assigned to student'});
            } else{
                $.toaster({priority:'danger',title:'Invalid',message:'Something went wrong,Please try again later..!'});
            }
        },
    });
}

    
function validation() {
    $('.stopname').each(function() {
        $(this).rules('add', {
            required: true,

            messages: {
                required: "Please enter Stop name"

            }
        });
    });
    $('.distance').each(function() {
        $(this).rules('add', {
            required: true,

            messages: {
                required: " Please enter distance"
            }
        });
    });
    $('.route_fare').each(function() {
        $(this).rules('add', {
            required: true,

            messages: {
                required: " Please enter route fare/monthly"
            }
        });
    });
    $('.latitude').each(function() {
        $(this).rules('add', {
            required: true,

            messages: {
                required: " Please select location from Geo Map"
            }
        });
    });
    $('.longitude').each(function() {
        $(this).rules('add', {
            required: true,

            messages: {
                required: " Please select location from Geo Map"
            }
        });
    });
}

$(document).ready(function() {
$("#fee_definition").change(function(){
      var fd_id= $(this).val();
      $('#loaddeposits').html('');
        if(fd_id>0) {
            $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>backoffice/Transport/get_fee_heads',
            data:{fd_id:fd_id,<?php echo $this->security->get_csrf_token_name();?>: '<?php echo $this->security->get_csrf_hash();?>'},
            success: function(response) {
                var obj = JSON.parse(response);
                if (obj.status == 1) {
                    $('#loaddeposits').html(obj.data);
                } else {
                    $('#loaddeposits').html(obj.message);
                }

            },

        });
        }
        
    });
});




</script>
