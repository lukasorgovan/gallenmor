$('#generator').on('submit', function(event) {
	event.preventDefault();
	var formName = $('#name').val(),
	formRace = $('#race').val();
	if (name.length < 50) {
		var reg = /^([a-zľščťžýáíéúäňôö']{2,} '?[a-zľščťžýáíéúäňôö']{2,}( ?'?[a-zľščťžýáíéúäňôö']{2,})?)$/i;
		if (reg.test(formName)) {
			var request = $.ajax({
				type: "POST",
				url: "/api/generator",
				data: {name: formName, race: formRace}
			}).done(function ( msg ) {

				$('#msg').removeClass('errorMessage').addClass('successMessage').html(msg);
			}).fail(function () {
				$('#msg').removeClass('successMessage').html('Pridávanie nových mien dočasne nefunguje. Skús to neskôr.');
			});	
		}
		else {
			$('#msg').removeClass('successMessage').addClass('errorMessage').html('Meno má nesprávny tvar. Musí mať 2-3 slová (každé slovo musí mať aspon 2 písmená) a môže obsahovať apostrof \'. Príklady: Alegreya Growe, Morgana la Fei, Al \'Sahib');
		}
	}
	else {
		$('#msg').removeClass('successMessage').addClass('errorMessage').html('Meno nesmie byť dlhšie ako 50 znakov');
	}
});