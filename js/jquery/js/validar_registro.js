$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var nombre_usuario = $( "#nombre_usuario" ),
		    apellido_usuario = $( "#apellido_usuario" ),
		    ciudad = $( "#ciudad" ),
		    email = $( "#email" ),
		    email_conf = $( "#email_conf" ),
		    password = $( "#password" ),
		    password_conf = $( "#password_conf" ),
		    tipo_us = $( "#es_comercio" ),
		    ciudad = $( "#ciudad_usuario" ),
		    cp = $( "#cp_usuario" ),
		    telefono = $( "#telefono_usuario" ),
		    tipo_usuario = $( "#tipo_usuario" ),
			captcha = $( "#captcha" ),
			captcha_texto_session = $( "#captcha_texto_session" ),
			allFields = $( [] ).add( captcha ).add( captcha_texto_session ).add( nombre_usuario ).add( apellido_usuario ).add( ciudad ).add( email ).add( email_conf ).add( cp ).add( tipo_us ).add( password ).add( password_conf ),
			
			tips = $( ".mostrar_error" );


		function validarform(){
            alert(mas_info.val());
			var bValid = true;
			allFields.removeClass( "ui-state-error" );
				
			bValid = bValid && checkLength( tips, nombre_usuario, "'Nombre'", 3, 50 );
			bValid = bValid && checkRegexp( tips, nombre_usuario, /^[a-z-A-Z\ ]([a-zA-Z_\ ])+$/i, "Nombre debe contener solo letras." );
			
			bValid = bValid && checkLength( tips, apellido_usuario, "'Apellido'", 3, 50 );
			bValid = bValid && checkRegexp( tips, apellido_usuario, /^[a-z-A-Z\ ]([a-zA-Z_\ ])+$/i, "Apellido debe contener solo letras." );
		
			bValid = bValid && checkRegexp(tips, email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "La direccion de 'Email' es invalida" );
			
			bValid = bValid && checkRegexp(tips, password, /^([a-zA-Z0-9]{6,20})$/i, "El Password debe contener solo letras y numeros entre 6 y 20 caracteres" );
			bValid = bValid && checkRegexp(tips, password_conf, /^([a-zA-Z0-9]{6,20})$/i, "El Password debe contener solo letras y numeros entre 6 y 20 caracteres" );
			bValid = bValid && checkSame(tips,email,email_conf,"Los Emails no coinciden");
			bValid = bValid && checkSame(tips,password,password_conf,"Las Passwords no coinciden");
			
			//bValid = bValid && checkCaptcha(tips, captcha, captcha_texto_session );

		
		          
					if ( bValid ) {
						$( "#formRegistrarse" ).submit();
					}		
			}	
		

		$( "#boton_registrar" )
		
		.click(function() {
		
			validarform();
		});
		
	});
