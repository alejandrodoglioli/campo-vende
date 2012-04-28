
$(function() {
	
	
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
	var nombre = $( "#nombre" ),
		email = $( "#email" ),
		comentario = $( "#comentario" ),
		allFields = $( [] ).add( nombre ).add( email ).add( comentario ),
		captcha = $( "#captcha" ),
		captcha_texto_session = $( "#captcha_texto_session" ),
		tips = $( ".validateTips" );
	
	
	function updateTips( t ) {
		tips
			.text( t )
			.addClass( "ui-state-highlight" );
		setTimeout(function() {
			tips.removeClass( "ui-state-highlight", 1500 );
		}, 500 );
	}

	function checkLength( o, n, min, max ) {
		if ( o.val().length > max || o.val().length < min ) {
			o.addClass( "ui-state-error" );
			updateTips( "La longitud de " + n + " debe estar entre " +
				min + " y " + max + "." );
			return false;
		} else {
			return true;
		}
	}
	
	function checkEmpty( o, m ) {
		if ( o.val().length < 1 ) {
			o.addClass( "ui-state-error" );
			updateTips( "El campo " + m + " no puede ser vacio." );
			return false;
		} else {
			return true;
		}
	}

	function checkCaptcha(o) {
		if ( o.val()!= captcha_texto_session.val()) {
			o.addClass( "ui-state-error" );
			updateTips( "El captcha no coincide (respete may&uacute;sculas y min&uacute;sculas).");
			return false;
		} else {
			return true;
		}
	}

	function checkRegexp( o, regexp, n ) {
		if ( !( regexp.test( o.val() ) ) ) {
			o.addClass( "ui-state-error" );
			updateTips( n );
			return false;
		} else {
			return true;
		}
	}
	
	
	
	$( "#dialog-form" ).dialog({
		autoOpen: true,
		resizable: false,
//		closeOnEscape: false,
		 draggable: false,
//	    position:[640,50],
//		 stack: true,
		height: 550,
		width: 500,
		modal: true,
		open: function(event, ui) { 
			//hide close button.
			$(this).parent().children().children('.ui-dialog-titlebar-close').hide();
			},
       
		buttons: {
			"Enviar Comentario": function() {
				var bValid = true;
				allFields.removeClass( "ui-state-error" );

				bValid = bValid && checkLength( nombre, "'Nombre'", 3, 75 );
				bValid = bValid && checkRegexp( nombre, /^[A-Z-a-z\ ]([0-9a-zA-Z_\ ])+$/i, "Nombre usuario debe ser caracteres A-Z a-z, 0-9 y comenzar con una letra." );
				// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
				bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "La direccion de 'Email' es invalida" );
				
				bValid = bValid && checkEmpty( comentario, "'Comentario'" );
				bValid = bValid && checkCaptcha( captcha );

				//bValid = bValid && checkRegexp( comentario, /^([0-9a-zA-Z])+$/, "comentario field only allow : a-z 0-9" );

				if ( bValid ) {
					$( "#users tbody" ).append( "<tr>" +
						"<td>" + nombre.val() + "</td>" + 
						"<td>" + email.val() + "</td>" + 
						"<td>" + comentario.val() + "</td>" +
					"</tr>" ); 
					$( "#formContacto" ).submit();
					$( this ).dialog( "close" );
				}
			},
			"Cancelar": function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			allFields.val( "" ).removeClass( "ui-state-error" );
		}
	});
    
    var container = $('.demo'),
        dialog = $('.ui-dialog');
    // get container top left corner locations
    var cx1 = container.offset().left,
        cy1 = container.offset().top;
    // get dialog size
    var dw = dialog.outerWidth(),
        dh = dialog.outerHeight();
    // get container bottom right location, then subtract the dialog size
    var cx2 = container.width() + cx1 - dw,
        cy2 = container.height() + cy1 - dh;
    dialog.draggable( "option", "containment", [cx1, cy1, cx2, cy2] );
  
    
});

