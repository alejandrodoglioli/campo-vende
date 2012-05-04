function checkLength(tips, campo, nombrecampo, min, max ) {
			if ( campo.val().length > max || campo.val().length < min+1 ) {
				campo.addClass( "ui-state-error" );
				updateTips(tips, "La longitud de " + nombrecampo + " debe estar entre " +
					min + " y " + max + "." );
				return false;
			} else {
				return true;
			}
		}

function updateTips( tips, t ) {
	tips.text( t ).addClass( "ui-state-highlight" );
	setTimeout(function() {
		tips.removeClass( "ui-state-highlight", 1500 );
	}, 500 );
}