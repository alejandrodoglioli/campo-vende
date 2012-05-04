$(function() {	
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		var titulo = $( "#titulo_es" ),	
		//var categoria = $( "#nombre_padre" ),	
		//var contenido = $( "#contenido_es" ),	
		
		//	pass = $( "#password_usuario" ),
			tips = $( ".validateTips" );
			
	function checkEmpty( o, m ) {
			if ( o.val().length < 1 ) {
				o.addClass( "ui-state-error" );
				updateTips( "El campo " + m + " no puede ser vacio." );
				return false;
			} else {
				return true;
			}
	}		
	
	function checkCategoria(cat,nombre){
		if(cat.value==0){
			cat.addClass( "ui-state-error" );
		    updateTips( "El campo " + nombre + " no puede ser vacio." );
		    return false;
		}
		else return true;
	}
	
	function validarform(){
  		var bValid = true;
		titulo.removeClass("ui-state-error");	
		//categoria.removeClass("ui-state-error");
		//contenido.removeClass("ui-state-error");
		
		bValid = bValid && checkLength(titulo,"'Titulo'",5,40);
		//	bValid = bValid && checkCategoria(categoria,"'Categoria'");
		//	bValid = bValid && checkEmpty(contenido,"'Contenido'");
                
				if ( bValid ) {
					$( "#forminsertarproducto" ).submit();
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

		
		function checkLength( campo, nombrecampo, min, max ) {
			if ( campo.val().length > max || campo.val().length < min ) {
				campo.addClass( "ui-state-error" );
				updateTips( "La longitud de " + nombrecampo + " debe estar entre " +
					min + " y " + max + "." );
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
		

		$( "#boton_nuevo_producto" )
			
			.click(function() {
			
				validarform();
			});

		
		});
		