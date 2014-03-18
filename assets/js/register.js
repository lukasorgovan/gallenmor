(function($) {
	// Initial settings
	var overlay = $('.overlay'),
	selectedRace = 'svetli-elfovia',
	generatorPosition = 0,
	valid = false;

	// Set the height of overlay properly to screen size
	if (overlay.length !== 0) {
		overlay.css({
			height: $(document).height() + 'px',
			backgroundColor: 'rgba(0,0,0,0.73)'
		});
	}
	// Try to get races.
	getApiData('/api/races', 'races', 'racesReady');
	// Uppon succesfull retrieval of races, change race desc. in modal
	$('body').one('racesReady', function() {
		$('#modal').html('<h1>' + races['svetli-elfovia'].name + '</h1>' + races['svetli-elfovia'].description);
	});
	$('body').one('initScroller', function() {
		window.myScroll = new IScroll('#scroll-wrapper', {
			scrollX: true, 
			scrollY: false,
			snap: 'div'
		});
		myScroll.on('scrollEnd', function() {
		
			// select second class from active scroller element
			var race = this.scroller.children[this.currentPage.pageX].classList[1];
			
			// transform erb-juzania to juzania and set as value of hidden field
			selectedRace = race.substring(4);
			$('#race').val(selectedRace);
			
			if (window.races) {
				var currentRace = window.races[selectedRace];
				$('#race-headline').html(currentRace.name);
				$('#modal').html('<h1>' + currentRace.name + '</h1>' + currentRace.description);
			}
		}); // myScroll.on
	});

	$('.erb').on('click', function() {
		$('#modal').reveal();
	});

	$("input[name='username']").on('focusin', function() {
		$('.hint').show(400);
	});
	$("input[type='range']").on('change', function() {
		$('#age-output').html(this.value);
	});

	/**
	 * Bind steps buttons, do sanity field check on client side
	 * @param  {object} event recorded event
	 * @return {void}
	 */
	$("a[class*='step']").on('click', function(event) {
		
		event.preventDefault();
		if ($(this).data('back')) {
			// rever
			var showStep = $(this).data('step'),
				  hideStep = showStep + 1,
				  valid = true;
		}
		else {
			var showStep = $(this).data('step'),
			 	  hideStep = showStep - 1;
		
			$('input.step-'+hideStep).each(function() {
				var $self = $(this);
				valid = checkField($self.attr('name'), this.value, {type: 'focusout'}, $self);
				return valid;
			});	
		}
		
		if (valid) {
			$('.step-'+hideStep).css('display', 'none');
			$('.step-'+showStep).css('display', 'block');
			// Trigger custom event to initialize iScroll on race pick
			
			if (showStep === 2) {
				
				// Try to get races data if the first call was unsuccessfull
				(window.races) ? {} :	getApiData('/api/races', 'races', 'racesReady');
				
				var e = jQuery.Event('initScroller');
				$('body').trigger(e);
				window.generatedNames = undefined;
				generatorPosition = 0;
				$('#generator').css('visibility', 'hidden');
			}
			else if (showStep === 3) {
				getApiData('/api/generator/' + selectedRace, 'generatedNames', 'namesReady');
				var $ageInput = $('input[type="range"]'),
				    maxage = parseInt(window.races[selectedRace].maxage),
				    minage = parseInt(window.races[selectedRace].minage),
				    rangeVal = Math.round((maxage-minage) / 2 + minage);

				$ageInput.attr({
					min: minage,
					max: maxage
				});
				$ageInput[0].value = rangeVal;
				$('#age-output').html(rangeVal);
			}
		}

	});
	// Bind race pick arrows
	$('.scroller-arrow').on('click', function() {
		$(this).data('dir') === 'left' ? myScroll.prev() : myScroll.next();
	});

	// Do sanity field check on focus IN/OUT
	$("input").on('focusin focusout', function (event) {
		checkField($(this).attr('name'), this.value, event, $(this));
	});

	$('#generator').on('click', function() {
		if (window.generatedNames) {
			var max = window.generatedNames.length - 1;
			$('#charname').val(window.generatedNames[generatorPosition].nickname);
			generatorPosition = generatorPosition === max ? 0 : ++generatorPosition;
			$('input[name="charname"]').trigger('focusin');
		}
	});
	$('body').on('namesReady', function() {
		$('#generator').css('visibility', 'visible')
	})

})(jQuery);


/**
 * General method for getting data via GET method from API
 * @param  {string} url          url to get
 * @param  {string} storeVar     if set, stores data in window object
 * @param  {string} triggerEvent if set, triggers event on body element
 * @return {response}              data
 */
function getApiData(url, storeVar, triggerEvent) {
	// Get races data and make 
	$.get(url, function(data) {
		(storeVar) ? window[storeVar] = data : {};
		if (triggerEvent) {
			var e = jQuery.Event(triggerEvent);
			$('body').trigger(e);
		}
		return data;
	});
}
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
				checkAvailibility('/api/checkAvailibility/users/username', {username: fieldValue}, fieldName);
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
			result = (fieldValue === $("input[name='password']").val()) ? true : 'passwordCheck';
			break;
		case 'email':
			var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
			result = reg.test(fieldValue) ? true : 'email';
			if (result === true) {
				checkAvailibility('/api/checkAvailibility/users/email', {email: fieldValue}, fieldName);
			}
			break;
		case 'race':
			var allowedRaces = Object.keys(window.races),
			result = allowedRaces.indexOf(fieldValue) !== -1 ? true : 'race';
			break;
		case 'charname': 
			var reg = /^([a-zľščťžýáíéúäňôö']{2,} '?[a-zľščťžýáåäíéúňôö']{2,}( ?'?[a-zľščťžýäáäíéúňôö']{2,})?)$/i,
			result = reg.test(fieldValue) ? true : 'charname';
			if (result === true) {
				checkAvailibility('/api/checkAvailibility/characters/name', {name: fieldValue}, fieldName);
			}
			break;
		case 'age':
			var reg = /^[0-9]{1,4}$/,
			result = reg.test(fieldValue) ? true : 'age';
			break;
		case 'gender':
			var result = (fieldValue === 'male' || fieldValue === 'female') ? true : 'gender';
			break;
		default:
			result = 'unknown';
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
		var result = (msg === 0) ? true : fieldName + '_taken';
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
	if (result === true) {
			$('#msg-'+fieldName).hide(400);
			return true;
		}
		else {
			$("input[name='"+fieldName+"']").addClass('shake error');
			$('#msg-'+fieldName).html(systemMessages.register[result]).show(400);
			return false;
		}
}
/**
 * Move carousel
 * @param  {number} distance  How much should carousel be moved
 * @param  {string} dir 			Direction left/right
 * @return {void}           	Moves scroller-wrapper
 */
function moveScroller($elem, distance, dir) {
	var offset = $elem.offset().left;
	if (dir === "left") {
		$elem.offset({left: offset + distance});
	}
	else {
		$elem.offset({left: offset - distance});
	}
}