$(function() {	

$( "#dialog-form-registro-forzado" ).dialog({
	autoOpen: false,
	height: 350,
	width: 500,
	modal: true,
	resizable: false,


	buttons: {
		"Login/Registro": function() {
			    $( "#ingresarUsuario" ).submit();
				$( this ).dialog( "close" );
			
		},
		"Cancelar": function() {
			$( this ).dialog( "close" );
		}
	},
	close: function() {
		//allFields.val( "" ).removeClass( "ui-state-error" );
	}
});
		
		

		$( "#hacer-pregunta2" )
		.button()
		.click(function() {
			$( "#dialog-form-registro-forzado" ).dialog( "open" );
		});

		
		});
		