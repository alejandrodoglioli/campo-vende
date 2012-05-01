$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var nombre_cliente = $( "#nombre_cliente" ),
		    fecha_publicacion = $( "#fecha_publicacion" ),
		    pregunta_cliente = $( "#pregunta_cliente" ),
		    respuesta_usuario = $( "#respuesta_usuario" ),
			allFields = $( [] ).add( nombre_cliente ).add( fecha_publicacion ).add( pregunta_cliente ).add( respuesta_usuario ),	
			tips = $( ".validateTips" );

		function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
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

			

		
		$( "#dialog-form" ).dialog({
			autoOpen: false,
			height: 490,
			width: 700,
			modal: true,
			
			buttons: {
				"Salvar Respuesta": function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );
						
						
					bValid = bValid && checkEmpty(respuesta_usuario,"respuesta" );

				
					if ( bValid ) {
						$( "#users tbody" ).append( "<tr>" +
							"<td>" + nombre_cliente.val() + "</td>" + 
							"<td>" + fecha_publicacion.val() + "</td>" + 
							"<td>" + pregunta_cliente.val() + "</td>" +
							"<td>" + respuesta_usuario.val() + "</td>" +							
						"</tr>" ); 
						
						$( "#responderPregunta" ).submit();
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

		$( ".responder" )
			.click(function() {
				$( "#dialog-form" ).dialog( "open" );
			});
	});
