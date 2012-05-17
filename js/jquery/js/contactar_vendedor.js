$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		//$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
		$( "#dialog-form-contacto" ).dialog({
			autoOpen: false,
			height: 250,
			width: 500,
			modal: false,
			resizable: false,


			buttons: {
				"Aceptar": function() {
					 $( "#contactar_form" ).submit();
						$( this ).dialog( "close" );
				}
			},
			close: function() {
				//allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$("#contactar").click(function(){
				   $( "#dialog-form-contacto" ).dialog( "open" );
			});
		
	});