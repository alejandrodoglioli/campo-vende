$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var nombre_usuario = $( "#nombre_usuario" ),
		    apellido_usuario = $( "#apellido_usuario" ),
		    ciudad = $( "#ciudad" ),
		    email = $( "#email" ),
		    password = $( "#password" ),
		    password_conf = $( "#password_conf" ),
		    es_comercio = $( "#es_comercio" ),
			captcha = $( "#captcha" ),
			captcha_texto_session = $( "#captcha_texto_session" ),
			allFields = $( [] ).add( nombre_usuario ).add( apellido_usuario ).add( ciudad ).add( email ).add( password ).add( password_conf ).add( es_comercio ),
			
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
			var comp = captcha_texto_session.val();
			if ( o.val().toLowerCase()!= comp.toLowerCase()) {
				o.addClass( "ui-state-error" );
				updateTips( "El captcha no coincide");
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
		
		function checkSamePassword(p1,p2){
		
			if(p1.val() != p2.val()){	
				p1.addClass( "ui-state-error" );
				p2.addClass( "ui-state-error" );
				updateTips( "Las Passwords ingresadas no coinciden");
				return false;
			}
			else{
				return true;
			}
		}
		
		function checkLongPassword(p){
			if(p < 6){
				p.addClass( "ui-state-error" );
				updateTips( "La Password debe contener al menos 6 caracteres");
				return false;
			}
			else {
				return true;
			}
		}
		

		
		$( "#dialog-form" ).dialog({
			autoOpen: false,
			height: 490,
			width: 700,
			modal: true,
			
			buttons: {
				"Registrarse": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );
						
					bValid = bValid && checkLength( nombre_usuario, "'Nombre'", 3, 50 );
					bValid = bValid && checkRegexp( nombre_usuario, /^[a-z-A-Z\ ]([a-zA-Z_\ ])+$/i, "Nombre debe contener solo letras." );
				
					bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "La direccion de 'Email' es invalida" );
					
					bValid = bValid && checkRegexp( password, /^([a-zA-Z0-9]{6,20})$/i, "El Password debe contener solo letras y numeros entre 6 y 20 caracteres" );
					bValid = bValid && checkRegexp( password_conf, /^([a-zA-Z0-9]{6,20})$/i, "El Password debe contener solo letras y numeros entre 6 y 20 caracteres" );
					bValid = bValid && checkSamePassword(password,password_conf);
					
					bValid = bValid && checkCaptcha( captcha );

				
					if ( bValid ) {
						$( "#users tbody" ).append( "<tr>" +
							"<td>" + nombre_usuario.val() + "</td>" + 
							"<td>" + apellido_usuario.val() + "</td>" + 
							"<td>" + ciudad.val() + "</td>" +
							"<td>" + email.val() + "</td>" +
							"<td>" + password.val() + "</td>" +
							"<td>" + password_conf.val() + "</td>" +
							"<td>" + es_comercio.val() + "</td>" +
							"<td>" + captcha.val() + "</td>" +
						"</tr>" ); 
						
						$( "#formRegistrarse" ).submit();
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

		$( "#registrarse" )
			.button()
			.click(function() {
				$( "#dialog-form" ).dialog( "open" );
			});
	});
