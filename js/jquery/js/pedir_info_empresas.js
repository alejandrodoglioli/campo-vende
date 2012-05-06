$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		//$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
		$( "#dialog-form-empresa" ).dialog({
			autoOpen: false,
			height: 250,
			width: 500,
			modal: false,
			resizable: false,


			buttons: {
				"Si": function() {
					mas_info=true;
					 $( "#es_empresa_form" ).submit();
						$( this ).dialog( "close" );
				},
				"No": function() {
					mas_info=false;
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				//allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$("#tipo_usuario").click(function(){
			   if($(this).is(":checked")){
				  
				   $( "#dialog-form-empresa" ).dialog( "open" );
			    }
			});
		
	});
