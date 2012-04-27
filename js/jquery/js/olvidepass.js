$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		var bValid = true;		
		var emailexiste=false;
		
		var email = $( "#email_rec" ),
		 	
			allFields = $( [] ).add( email ),
			captcha = $( "#captcha" ),
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
			var comp = '{captcha_texto_session}';
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
				o.addClass( "ui-state-error" );
				updateTips( "La Password debe contener al menos 6 caracteres");
				return false;
			}
			else {
				return true;
			}
		}
		
		
		function showInvalidEmail(o) {
			 o.addClass( "ui-state-error" );
			 updateTips( o.val()+" no se corresponde a un usuario válido.");
			 return false;
		}
		
		$( "#dialog-form-pass" ).dialog({
			autoOpen: false,
			height: 550,
			width: 500,
			modal: false,
			
			buttons: {
				"Enviar": function() {
					
					allFields.removeClass( "ui-state-error" );
						
					bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "La direccion de 'Email' es invalida" );
					
					validar_email(email.val());
					bValid = bValid && checkCaptcha( captcha );
					alert($( "#emailExiste" ).val());
					if ( bValid ) {
						$( "#users tbody" ).append( "<tr>" +
							"<td>" + email.val() + "</td>" +
						"</tr>" ); 
						
						$( "#formOlvidePass" ).submit();
						$( this ).dialog( "close" );
					}else if(	  document.getElementById("emailExiste").innerHTML==0){
						
						showInvalidEmail(email);
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

		$( "#olvidepass" )
			.button()
			.click(function() {
				$( "#dialog-form-pass" ).dialog( "open" );
			});
		
		
	
	});


