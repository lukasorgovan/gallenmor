var overlay = $('.overlay'),
valid = false;

if (overlay.length !== 0) {
	overlay.css({
		height: $(document).height() + 'px',
		backgroundColor: 'rgba(0,0,0,0.73)'
	});
}
$("a[class*='step']").on('click', function(event) {
	
	event.preventDefault();
	
	var nextStep = $(this).data('step'),
	prevStep = nextStep - 1;
	
	$('input.step-'+prevStep).each(function() {
		var $self = $(this);
		valid = checkField($self.attr('name'), this.value, {type: 'focusout'}, $self);
		console.log(valid);
		return valid;
	});
	if (valid) {
		$('.step-'+prevStep).hide(400);
		$('.step-'+nextStep).show(400);
	}
	
});

$("input").on('focusin focusout', function (event) {
	checkField($(this).attr('name'), this.value, event, $(this));
});

function checkField(fieldName, fieldValue, event, $element) {
	switch (fieldName) {
		case 'username':
			var reg = /^[a-zľščťžýáíéúäňôö]{2,}[0-9]{0,2}$/i,
			result = reg.test(fieldValue) ? (fieldValue.length <= 20 ? true : 'username') : 'username';
			if (result === true && event.type == 'focusout') {
				checkAvailibility('/api/checkUserNameAvailibility', {username: fieldValue}, fieldName);
			}
			break;
		case 'date':
			var reg = /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/;
			result = reg.test(fieldValue) ? true : 'date';
			break;
		case 'password':
			var reg = /^[0-9a-z]{6,}$/i,
			result = reg.test(fieldValue) ? true : 'password';
			break;
		case 'password-check':			
			result = (fieldValue === $("input[name='password']").val()) ? true : 'password-check';
			break;
		case 'email':
			var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
			result = reg.test(fieldValue) ? true : 'email';
	}
	if (event.type == 'focusin') {
		$element.removeClass('shake error');
	}
	else {
		return checkResult(fieldName, result);
	}
}

function checkAvailibility(requestURI, dataObject, fieldName) {
	var request = $.ajax({
		type: "POST",
		url: requestURI,
		data: dataObject
	}).done(function ( msg ) {
		var result = (msg === 0) ? true : 'username_taken';
		return checkResult(fieldName, result);
	});
}

function checkResult(fieldName, result) {
	if (result !== true) {
			$("input[name='"+fieldName+"']").addClass('shake error');
			$('#msg-'+fieldName).html(result).show(400);
			return false;
		}
		else {
			$('#msg-'+fieldName).hide(400);
			return true;
		}
}

/*
var reg = /^([a-zľščťžýáíéúäňôö']{2,} '?[a-zľščťžýáíéúäňôö']{2,}( ?'?[a-zľščťžýáíéúäňôö']{2,})?)$/i;
	if (reg.test(formName))
*/