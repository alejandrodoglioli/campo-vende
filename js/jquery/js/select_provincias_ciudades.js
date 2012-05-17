$(function() {

	var ciudad_usuario = $("#ciudad_usuario"), provincia_usuario = $("#provincia_usuario");

	function cargar_provincias() {
		$.get("/js/php/cargar_provincias.php", function(provincias) {
			if (provincias == false) {
				alert("Error");
			} else {
				provincia_usuario.append(provincias);
			}
		});
	}

	function cargar_ciudades() {
		var code = provincia_usuario.val();
		$.get("/js/php/cargar_ciudades.php", {
			code : code
		}, function(ciudades) {
			if (ciudades == false) {
				alert("Error ");
			} else {
				ciudad_usuario.attr("disabled", false);
				document.getElementById("ciudad_usuario").options.length = 1;
				ciudad_usuario.append(ciudades);
			}
		});
	}

	$(document).ready(function() {
		cargar_provincias();
		provincia_usuario.change(function() {
			cargar_ciudades();
		});
		//ciudad_usuario.attr("disabled", true);
	});

});