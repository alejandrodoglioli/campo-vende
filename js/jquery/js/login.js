$(function() {	
		var id;
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		var email = $( "#email_usuario" ),		
			pass = $( "#password_usuario" ),
			tips = $( ".validateTips" );
			
	function validarusuario(email){
	    id = jsrsExecute("../../modulos/usuarios_sistema/include/include.remotescriptinglogin.php", parsear_error, "recuperarEmail",email.val(),true);
    }

	function parsear_error(retorno){
		if (retorno==0){
			validartodo(false,null); 		
		 }else{
			validartodo(true,retorno);
		 }
		}
		
	function checkmailvalid(valido,mail,passdb,passin){
		if(!valido){
      	     mail.addClass( "ui-state-error" );
			 updateTips( " '"+mail.val()+"'" + " no se encuentra registrado");
			 return false;
		     }
		else{
		      if(passdb.val()==passin){
		          return true;
		       }
		   else{
		   	 passdb.addClass( "ui-state-error" );
			 updateTips( " El password es incorrecto");
		     return false
		   }
	}
}	
	
	function validartodo(mailvalido,retorno){
  		var bValid = true;
		email.removeClass("ui-state-error");		
		pass.removeClass("ui-state-error");		
		   
		        bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "La direccion de 'Email' es invalida" );
				
				bValid = bValid && checkmailvalid(mailvalido,email,pass,retorno);
                
				if ( bValid ) {
				//	$( "#users tbody" ).append( "<tr>" +
					//	"<td>" + email.val() + "</td>" +
			//		"</tr>" ); 
				
					$( "#ingresarUsuario" ).submit();
					//$( this ).dialog( "close" );
				}		
		}	
	

		function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
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
		

		$( "#boton_enviar" )
			
			.click(function() {
			
				validarusuario(email);
			});

		
		});
		