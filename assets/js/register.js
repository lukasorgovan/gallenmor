// Initial settings
var overlay = $('.overlay'),
valid = false;

// Set the height of overlay properly to screen size
if (overlay.length !== 0) {
	overlay.css({
		height: $(document).height() + 'px',
		backgroundColor: 'rgba(0,0,0,0.73)'
	});
}

/**
 * Bind steps buttons, do sanity field check on client side
 * @param  {object} event recorded event
 * @return {void}
 */
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
		$('.step-'+prevStep).css('display', 'none');
		$('.step-'+nextStep).css('display', 'block');
	}
	
});

// Do sanity field check on focus IN/OUT
$("input").on('focusin focusout', function (event) {
	checkField($(this).attr('name'), this.value, event, $(this));
});

/**
 * Checks the current field based on regexp and other conditions
 * @param  {string} fieldName  name of the checked field
 * @param  {string} fieldValue current value in input
 * @param  {object} event      declared for use with css add/remove class
 * @param  {object} $element   current element itself
 * @return {bool}
 */
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

/**
 * Checks availibility of the field
 * @param  {string} requestURI API url to handle the ajax
 * @param  {JSON} dataObject key-value object
 * @param  {string} fieldName
 * @return {bool}
 */
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

/**
 * Display error input
 * @param  {string} fieldName current field name
 * @param  {mixed}  result    true OR string error message
 * @return {bool}
 */
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