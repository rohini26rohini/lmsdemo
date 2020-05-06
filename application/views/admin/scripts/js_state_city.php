<script>

   $(document).ready(function(){ 
		 var country_id = $("#hidden_country").val();
		// alert(country_id);
		 if(country_id == '' || country_id == 'undefined'){
		  $("#country").val(101);
		 }else{
			 $("#country").val(country_id);
		 }
         $("#country").trigger('change');
		 
		    get_state_on_load();  
			get_city_on_load(); 



     $("#country").val('101');
      $("#country").trigger('change');
     <?php
		if(!empty($state)){?>
        $("#state").val('<?php echo $state ?>');
		<?php } ?>
        $("#state").trigger('change');
		<?php
		if(!empty($city)){?>
        $("#city").val('<?php echo $city ?>');
		<?php } ?>
   




    }); 

   $(document).ready(function(){ 
         var country_id = $("#hidden_country").val();
        // alert(country_id);
         if(country_id == '' || country_id == 'undefined'){
          $("#country").val(101);
          country_id=101;
         }else{
             $("#country").val(country_id);
         }
         $("#country").trigger('change');
          
            get_state_on_load(country_id);    
            get_city_on_load(); 
    }); 

   $(document).ready(function(){ 
         var present_country_id = $("#hidden_present_country").val();
        // alert(country_id);
         if(present_country_id == '' || present_country_id == 'undefined'){
              $("#present_country").val(101);
              present_country_id=101;
         }else{
             $("#present_country").val(present_country_id);
         }
         $("#present_country").trigger('change');
         $("#pcountry").trigger('change');
         
           get_present_state_on_load(present_country_id);    
           get_present_city_on_load(); 
    }); 
	
	
	
      $("#country").change(function () { 
        var country = $(this).val();
		var state_id = $("#hidden_state").val();
        // alert(state_id);   
        $.ajax({// ajax call starts
            type: "POST",
            async:false,
            url: "<?php echo base_url(); ?>backoffice/Call_center/ajax_get_state",
            data: {'country': country},
            dataType: 'json',
            async: false,
            success: function (data)
            {

                if (data != 0)
                {
                    var d_down = "";
                    d_down += "<option value=''>Select state</option>";
                    $.each(data, function (index, state) {
						//make already selected
						var selected_state = '';
						if(state_id == state.id){
							selected_state += 'selected="selected"';
						}//
                        d_down += "<option value='" + state.id + "'"+selected_state+">" + state.name + "</option>";
                    });
                    d_down += "";
                }//if data !=0
                else
                {
                    var d_down = "";
                    d_down += "<option value=''>Select state </option>";
                    d_down += "";
                }//end else
                $("#state").html(d_down);
            }//success
        }); //ajax 
        $("#state").trigger('change');
    });

       $("#country").change(function () { 
        var country = $(this).val();
        var state_id = $("#hidden_state").val();
        // alert(state_id);   
        $.ajax({// ajax call starts
            type: "POST",
            async:false,
            url: "<?php echo base_url(); ?>backoffice/Call_center/ajax_get_state",
            data: {'country': country},
            dataType: 'json',
            async: false,
            success: function (data)
            {

                if (data != 0)
                {
                    var d_down = "";
                    d_down += "<option value=''>Select state</option>";
                    $.each(data, function (index, state) {
                        //make already selected
                        var selected_state = '';
                        if(state_id == state.id){
                            selected_state += 'selected="selected"';
                        }//
                        d_down += "<option value='" + state.id + "'"+selected_state+">" + state.name + "</option>";
                    });
                    d_down += "";
                }//if data !=0
                else
                {
                    var d_down = "";
                    d_down += "<option value=''>Select state </option>";
                    d_down += "";
                }//end else
                $("#state").html(d_down);
            }//success
        }); //ajax 
        $("#state").trigger('change');
    }); 
       $("#present_country").change(function () { 
        var present_country = $(this).val();
        var present_state_id = $("#hidden_present_state").val();
        // alert(state_id);   
        $.ajax({// ajax call starts
            type: "POST",
            async:false,
            url: "<?php echo base_url(); ?>backoffice/Call_center/ajax_get_state",
            data: {'country': present_country},
            dataType: 'json',
            async: false,
            success: function (data)
            {

                if (data != 0)
                {
                    var d_down = "";
                    d_down += "<option value=''>Select state</option>";
                    $.each(data, function (index, state) {
                        //make already selected
                        var selected_state = '';
                        if(present_state_id == state.id){
                            selected_state += 'selected="selected"';
                        }//
                        d_down += "<option value='" + state.id + "'"+selected_state+">" + state.name + "</option>";
                    });
                    d_down += "";
                }//if data !=0
                else
                {
                    var d_down = "";
                    d_down += "<option value=''>Select state </option>";
                    d_down += "";
                }//end else
                $("#present_state").html(d_down);
            }//success
        }); //ajax 
        $("#present_state").trigger('change');
    });
    
    $("#state").change(function () {
        var state = $(this).val();
		var city_id = $("#hidden_city").val();
         //alert(city_id);   
        $.ajax({// ajax call starts
            type: "POST",
            async:false,
            url: "<?php echo base_url(); ?>backoffice/Call_center/ajax_get_city",
            data: {'state_code': state},
            dataType: 'json',
            async: false,
            success: function (data)
            {

                if (data != 0)
                {
                    var d_down = "";
                    d_down += "<option value=''>Select place</option>";
                    $.each(data, function (index, city) {
						//make already selected
						var selected_city = '';
						if(city_id == city.id){
							selected_city += 'selected="selected"';
						}//
                        d_down += "<option value='" + city.id + "'"+selected_city+">" + city.name + "</option>";
                    });
                    d_down += "";
                }//if data !=0
                else
                {
                    var d_down = "";
                    d_down += "<option value='0'>Select place</option>";
                    d_down += "";
                }//end else
                $("#city").html(d_down);
            }//success
        }); //ajax 
    });
      $("#state").change(function () {
        var state = $(this).val();
        var city_id = $("#hidden_city").val();
         //alert(city_id);   
        $.ajax({// ajax call starts
            type: "POST",
            async:false,
            url: "<?php echo base_url(); ?>backoffice/Call_center/ajax_get_city",
            data: {'state_code': state},
            dataType: 'json',
            async: false,
            success: function (data)
            {

                if (data != 0)
                {
                    var d_down = "";
                    d_down += "<option value=''>Select place</option>";
                    $.each(data, function (index, city) {
                        //make already selected
                        var selected_city = '';
                        if(city_id == city.id){
                            selected_city += 'selected="selected"';
                        }//
                        d_down += "<option value='" + city.id + "'"+selected_city+">" + city.name + "</option>";
                    });
                    d_down += "";
                }//if data !=0
                else
                {
                    var d_down = "";
                    d_down += "<option value='0'>Select place</option>";
                    d_down += "";
                }//end else
                $("#city").html(d_down);
            }//success
        }); //ajax 
    });
        $("#present_state").change(function () {
        var present_state = $(this).val();
        var present_city_id = $("#hidden_present_city").val();
         //alert(city_id);   
        $.ajax({// ajax call starts
            type: "POST",
            async:false,
            url: "<?php echo base_url(); ?>backoffice/Call_center/ajax_get_city",
            data: {'state_code': present_state},
            dataType: 'json',
            async: false,
            success: function (data)
            {

                if (data != 0)
                {
                    var d_down = "";
                    d_down += "<option value=''>Select place</option>";
                    $.each(data, function (index, city) {
                        //make already selected
                        var selected_city = '';
                        if(present_city_id == city.id){
                            selected_city += 'selected="selected"';
                        }//
                        d_down += "<option value='" + city.id + "'"+selected_city+">" + city.name + "</option>";
                    });
                    d_down += "";
                }//if data !=0
                else
                {
                    var d_down = "";
                    d_down += "<option value='0'>Select place</option>";
                    d_down += "";
                }//end else
                $("#present_city").html(d_down);
            }//success
        }); //ajax 
    });
/*
*  Permanaet address
*/	
      $("#country").change(function () { 
        var country = $(this).val();
		var state_id = $("#hidden_state").val();
        // alert(state_id);   
        $.ajax({// ajax call starts
            type: "POST",
            async:false,
            url: "<?php echo base_url(); ?>backoffice/Call_center/ajax_get_state",
            data: {'country': country},
            dataType: 'json',
            async: false,
            success: function (data)
            {

                if (data != 0)
                {
                    var d_down = "";
                    d_down += "<option value=''>Select state</option>";
                    $.each(data, function (index, state) {
						//make already selected
						var selected_state = '';
						if(state_id == state.id){
							selected_state += 'selected="selected"';
						}//
                        d_down += "<option value='" + state.id + "'"+selected_state+">" + state.name + "</option>";
                    });
                    d_down += "";
                }//if data !=0
                else
                {
                    var d_down = "";
                    d_down += "<option value=''>Select state </option>";
                    d_down += "";
                }//end else
                $("#pstate").html(d_down);
            }//success
        }); //ajax 
        $("#pstate").trigger('change');
    });
	
	
	$("#pstate").change(function () {
        var state = $(this).val();
		var city_id = $("#hidden_pcity").val();
         //alert(city_id);   
        $.ajax({// ajax call starts
            type: "POST",
            async:false,
            url: "<?php echo base_url(); ?>backoffice/Call_center/ajax_get_city",
            data: {'state_code': state},
            dataType: 'json',
            async: false,
            success: function (data)
            {

                if (data != 0)
                {
                    var d_down = "";
                    d_down += "<option value=''>Select place</option>";
                    $.each(data, function (index, city) {
						//make already selected
						var selected_city = '';
						if(city_id == city.id){
							selected_city += 'selected="selected"';
						}//
                        d_down += "<option value='" + city.id + "'"+selected_city+">" + city.name + "</option>";
                    });
                    d_down += "";
                }//if data !=0
                else
                {
                    var d_down = "";
                    d_down += "<option value=''>Select place</option>";
                    d_down += "";
                }//end else
                $("#pcity").html(d_down);
            }//success
        }); //ajax 
    });
	
$("#sameas").click(function () {
	if (this.checked) {
		var address	=	$("#address").val(); 
		$("#paddress").val(address);
		var street	=	$("#street").val();
		$("#pstreet").val(street);
		var pin	=	$("#pin").val();
		$("#ppin").val(pin);
		var country	=	$("#country").val();
		$("#pcountry").val(country);
		$("#pcountry").trigger('change');
		var state	=	$("#state").val();
		$("#pstate").val(state);
		$("#pstate").trigger('change');
		var city	=	$("#city").val();
		$("#pcity").val(city);
	} else {
		$("#paddress").val("");
		$("#pcity").val('');
		$("#pstate").val('');
		$("#pcountry").val('');
		$("#ppin").val('');
		$("#pstreet").val('');
	}
	});
	
	 function get_state_on_load(country_id){ 
        var country = country_id;
		var state_id = $("#hidden_state").val();
        $.ajax({// ajax call starts
            type: "POST",
            async:false,
            url: "<?php echo base_url(); ?>backoffice/Call_center/ajax_get_state",
            data: {'country': country},
            dataType: 'json',
            async: false,
            success: function (data)
            {

                if (data != 0)
                {
                    var d_down = "";
                    d_down += "<option value=''>Select state</option>";
                    $.each(data, function (index, state) {
						//make already selected
						var selected_state = '';
						if(state_id == state.id){
							selected_state += 'selected="selected"';
						}//
                        d_down += "<option value='" + state.id + "'"+selected_state+">" + state.name + "</option>";
                    });
                    d_down += "";
                }//if data !=0
                else
                {
                    var d_down = "";
                    d_down += "<option value=''>Select state </option>";
                    d_down += "";
                }//end else
                $("#state").html(d_down);
            }//success
        }); //ajax 
        $("#state").trigger('change');
    }
	 function get_city_on_load(){
        var state = $("#hidden_state").val();
		var city_id = $("#hidden_city").val();
         //alert(city_id);   
        $.ajax({// ajax call starts
            type: "POST",
            async:false,
            url: "<?php echo base_url(); ?>backoffice/Call_center/ajax_get_city",
            data: {'state_code': state},
            dataType: 'json',
            async: false,
            success: function (data)
            {

                if (data != 0)
                {
                    var d_down = "";
                    d_down += "<option value=''>Select place</option>";
                    $.each(data, function (index, city) {
						//make already selected
						var selected_city = '';
						if(city_id == city.id){
							selected_city += 'selected="selected"';
						}//
                        d_down += "<option value='" + city.id + "'"+selected_city+">" + city.name + "</option>";
                    });
                    d_down += "";
                }//if data !=0
                else
                {
                    var d_down = "";
                    d_down += "<option value=''>Select place</option>";
                    d_down += "";
                }//end else
                $("#city").html(d_down);
            }//success
        }); //ajax 
    }
	
     function get_present_state_on_load(present_country_id){ 
        var present_country = present_country_id;
        var present_state_id = $("#hidden_present_state").val();
        // alert(state_id);   
        $.ajax({// ajax call starts
            type: "POST",
            async:false,
            url: "<?php echo base_url(); ?>backoffice/Call_center/ajax_get_state",
            data: {'country': present_country},
            dataType: 'json',
            async: false,
            success: function (data)
            {

                if (data != 0)
                {
                    var d_down = "";
                    d_down += "<option value=''>Select state</option>";
                    $.each(data, function (index, state) {
                        //make already selected
                        var selected_state = '';
                        if(present_state_id == state.id){
                            selected_state += 'selected="selected"';
                        }//
                        d_down += "<option value='" + state.id + "'"+selected_state+">" + state.name + "</option>";
                    });
                    d_down += "";
                }//if data !=0
                else
                {
                    var d_down = "";
                    d_down += "<option value=''>Select state </option>";
                    d_down += "";
                }//end else
                $("#present_state").html(d_down);
            }//success
        }); //ajax 
        $("#present_state").trigger('change');
    }
     function get_present_city_on_load(){
        var present_state = $("#hidden_present_state").val();
        var present_city_id = $("#hidden_present_city").val();
         //alert(city_id);   
        $.ajax({// ajax call starts
            type: "POST",
            async:false,
            url: "<?php echo base_url(); ?>backoffice/Call_center/ajax_get_city",
            data: {'state_code': present_state},
            dataType: 'json',
            async: false,
            success: function (data)
            {

                if (data != 0)
                {
                    var d_down = "";
                    d_down += "<option value=''>Select place</option>";
                    $.each(data, function (index, city) {
                        //make already selected
                        var selected_city = '';
                        if(present_city_id == city.id){
                            selected_city += 'selected="selected"';
                        }//
                        d_down += "<option value='" + city.id + "'"+selected_city+">" + city.name + "</option>";
                    });
                    d_down += "";
                }//if data !=0
                else
                {
                    var d_down = "";
                    d_down += "<option value=''>Select place</option>";
                    d_down += "";
                }//end else
                $("#present_city").html(d_down);
            }//success
        }); //ajax 
    }
	 function get_state_on_load(){
		  
        var country =  $("#hidden_country").val();
		var state_id = $("#hidden_state").val();
         //alert(state_id);   
        $.ajax({// ajax call starts
            type: "POST",
            async:false,
            url: "<?php echo base_url(); ?>backoffice/Call_center/ajax_get_state",
            data: {'country': country},
            dataType: 'json',
            async: false,
            success: function (data)
            {

                if (data != 0)
                {
                    var d_down = "";
                    d_down += "<option value=''>Select state</option>";
                    $.each(data, function (index, state) {
						//make already selected
						var selected_state = '';
						if(state_id == state.id){
							selected_state += 'selected="selected"';
						}//
                        d_down += "<option value='" + state.id + "'"+selected_state+">" + state.name + "</option>";
                    });
                    d_down += "";
                }//if data !=0
                else
                {
                    var d_down = "";
                    d_down += "<option value=''>Select state </option>";
                    d_down += "";
                }//end else
                $("#state").html(d_down);
            }//success
        }); //ajax 
        $("#state").trigger('change');
    
	 }
	 
	 function get_city_on_load(){
        var state = $("#hidden_state").val();
		var city_id = $("#hidden_city").val();
         //alert(city_id);   
        $.ajax({// ajax call starts
            type: "POST",
            async:false,
            url: "<?php echo base_url(); ?>backoffice/Call_center/ajax_get_city",
            data: {'state_code': state},
            dataType: 'json',
            async: false,
            success: function (data)
            {

                if (data != 0)
                {
                    var d_down = "";
                    d_down += "<option value=''>Select place</option>";
                    $.each(data, function (index, city) {
						//make already selected
						var selected_city = '';
						if(city_id == city.id){
							selected_city += 'selected="selected"';
						}//
                        d_down += "<option value='" + city.id + "'"+selected_city+">" + city.name + "</option>";
                    });
                    d_down += "";
                }//if data !=0
                else
                {
                    var d_down = "";
                    d_down += "<option value=''>Select place</option>";
                    d_down += "";
                }//end else
                $("#city").html(d_down);
            }//success
        }); //ajax 
    }
    
</script>    