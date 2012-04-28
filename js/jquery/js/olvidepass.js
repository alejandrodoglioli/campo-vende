$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		var email = $( "#email_rec" ),
		
			allFields = $( [] ).add( email ),
			captcha = $( "#captcha" ),
			captcha_texto_session = $( "#captcha_texto_session" ),
			tips = $( ".validateTips" );
			
		
	function validar_email(email){
	    jsrsExecute("../../modulos/usuarios_sistema/include.remotescripting.php", parsear_error, "recuperarEmail",email.val(),true);
    }
	
	function checkmailvalid(valido,o){
		if(!valido){
      	   o.addClass( "ui-state-error" );
			 updateTips( " '"+o.val()+"'" + " no se encuentra registrado");
			 return false;
		}else{return true;}
}	
	
	function validartodo(mailvalido){
  		var bValid = true;

		email.removeClass("ui-state-error");		
		captcha.removeClass("ui-state-error");		
		   
		        bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "La direccion de 'Email' es invalida" );
				
				bValid = bValid && checkmailvalid( mailvalido,email );
		       	bValid = bValid && checkCaptcha( captcha );
		       	
                
				if ( bValid ) {
					$( "#users tbody" ).append( "<tr>" +
						"<td>" + email.val() + "</td>" +
					"</tr>" ); 
					
					$( "#formOlvidePass" ).submit();
					$( this ).dialog( "close" );
				}		
		}	
	

	function parsear_error(retorno){
		if (retorno==1){
			 existe = true;		
		 }else{
			existe = false;
		 }
		validartodo(existe);
 	}

		function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
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
		
		
		$( "#dialog-form-pass" ).dialog({
			autoOpen: false,
			resizable: false,
			height: 350,
			width: 500,
			modal: true,
			
			buttons: {
				"Enviar": function() {
					validar_email(email);
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
			
			.click(function() {
				$( "#dialog-form-pass" ).dialog( "open" );
			});
	
	});

