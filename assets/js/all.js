$(window).on("load", function () {
   $(".loader").hide();

});
$(function () {
    $('.numberswithdecimal').keyup(function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        }
    });
    $('.numbersOnly').keyup(function () {
        if (this.value != this.value.replace(/[^0-9]/g, '')) {
            this.value = this.value.replace(/[^0-9]/g, '');
        }
    });
    $('.txtOnly').keypress(function (e) { 
        var regex = new RegExp("^[a-zA-Z]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);  
        if(e.which==8 || e.which==32 || e.which==0) {
            return true; 
        } else {
            if (regex.test(str)) {
                return true;
            }
            else{
                e.preventDefault();
                // $('.error').show();
	    		// $('.error').text('Please Enter Alphabate');
                return false;
            }
        }
    });
    
    $('.calendarclass').datetimepicker({
        format:'DD/MM/YYYY',
        useCurrent:false
    });
    

    $('.datetime').datetimepicker({
        defaultDate: new Date(),
        // format:'DD/MM/YYYY HH:mm:ss',
    });

    $('.year').datetimepicker({
        defaultDate: new Date(),
        format:'YYYY',
    });

    
    
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z ]+$/i.test(value);
    }, "Letters only please");
    
    $.validator.addMethod("emailValidate", function(value, element) {
       // return this.optional(element) || /^[a-z0-9-.@]+$/i.test(value);
         return this.optional(element) || /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{0,9})$/i.test(value);
    }, "name must contain only letters, numbers and .");
});

function url(val){
    window.location.href = val;  
}

// number validation
function valNum(event){
    var regex = new RegExp("^[0-9]+$");
    var str = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if(event.which==8 || event.which==32 || event.which==0) {
        return true;
    } else {
        if (regex.test(str)) {
            return true;
        }else{
            event.preventDefault();
            return false;
        }
    }
}

/*only allow alphabets*/
function valNames(event) {
    var regex = new RegExp("^[a-zA-Z]+$");
    var str = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if(event.which==8 || event.which==32 || event.which==0) {  
        return true; 
    } else {
        if (regex.test(str)) {
            return true;
        }else{
            event.preventDefault();
            // $('.error').show();
            // $('.error').text('Please Enter Alphabate');
            return false;
        }
    }
}


/*allow alphabets and numbers but no special char*/
function blockSpecialChar(e){
    var k;
    document.all ? k = e.keyCode : k = e.which;
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
}
/*number and backwerd slash for date field*/
function ValDate(event){
    var regex = new RegExp("^[0-9/ ]+$");
    var str = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if(event.which==8 || event.which==32 || event.which==0) {  
        return true; 
    } else {
        if (regex.test(str)) {
            return true;
        }else{
            event.preventDefault();
            return false;
        }
    }
}

/*number and decimal*/
function decimalNum(event){
    var regex = new RegExp("^[0-9.]+$");
    var str = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if(event.which==8 || event.which==32 || event.which==0) {  
        return true; 
    } else {
        if (regex.test(str)) {
            return true;
        }else{
            event.preventDefault();
            return false;
        }
    }
}

//accepts only alphabets,numbers,comma,hiphen and slash
function addressValidation(e) {
    var regex = new RegExp("^[a-zA-Z0-9 ,-/']+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if(e.which==8 || e.which==32 || e.which==0) {
        return true; 
    } else {
        if (regex.test(str)) {
            return true;
        }else{
            e.preventDefault();
            return false;
        }
    }
}



function validatePhone(phone) {
    var a = document.getElementById(phone).value;
    var filter = /[1-9]{1}[0-9]{9}/;
    if (filter.test(a)) {
        return true;
    }else {
        return false;
    }
}


$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9]/g, '')) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
});

  $(function () {
      $('#marquee-vertical').marquee();
      $('#marquee-horizontal').marquee({ direction: 'horizontal', delay: 0, timing: 50 });

    });