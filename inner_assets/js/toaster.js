var interval;
var codetmpl = "<code>%codeobj%</code><br><code>%codestr%</code>";

$(document).ready(function (){
	randomToast();
	$('#btnstart').click(start);
	$('#btnstop').click(stop);
	$('#preptoast').on('submit', maketoast);
	start();
});

function start(){
	if (!interval){
		interval = setInterval(function ()
		{
			randomToast();
		}, 5000);
	}
	this.blur();//this.hide();

}

function stop(){
	if (interval){
		clearInterval(interval);
		interval = false;
	}
	this.blur();
    this.remove();
}

function maketoast(evt){
	evt.preventDefault();
	var options = {
					priority : $('#toastPriority').val() || null,
					title    : $('#toastTitle').val() || null,
					message  : $('#toastMessage').val() || 'A message is required'
				};

	if (options.priority === '<use default>'){
		options.priority = null;
	}

	var codeobj = [];
	var codestr = [];

	var labels = ['message', 'title', 'priority'];
	for (var i = 0, l = labels.length; i < l; i += 1){
		if (options[labels[i]] !== null){
			codeobj.push([labels[i], "'" + options[labels[i]] + "'"].join(' : '));
		}
		codestr.push((options[labels[i]] !== null) ? "'" + options[labels[i]] + "'" : 'null');
	}

	if (codestr[2] === 'null'){
		codestr.pop();
		if (codestr[1] === 'null'){
			codestr.pop();
		}
	}

	codeobj = "$.toaster({ " + codeobj.join(", ") + " });"
	codestr = "$.toaster(" + codestr.join(", ") + ");"

	$('#toastCode').html(codetmpl.replace('%codeobj%', codeobj).replace('%codestr%', codestr));
	$.toaster(options);
}
