$(document).ready(function(){

			//Examples of how to assign the ColorBox event to elements

			$("a[rel='opendialog']").colorbox({transition:"fade",width:"600px", height:"600px"});

			//Example of preserving a JavaScript event for inline calls.

			$("#click").click(function(){ 

				$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");

				return false;

			});

		});

$(document).ready(function() {
			$("#gallery_output img").not(":first").hide();
 
			$("#gallery a").click(function() {
				if ( $("#" + this.rel).is(":hidden") ) {
					$("#gallery_output img").slideUp();
					$("#" + this.rel).slideDown();
				}
			});
		});
 