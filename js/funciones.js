// JavaScript Document

function mostrarSubmenu(submenu){
	document.getElementById(submenu).style.display="block";
}

function ocultarSubmenu(submenu){
	document.getElementById(submenu).style.display="none";
}

function validarFormulario(){

	if(document.getElementById('nombre').value !='')
		if(document.getElementById('comentario').value !=''){
			document.getElementById('submit_comment').value="formOK";
			document.getElementById('formComentario').submit();
			}
		else
				alert("El comentario no puede estar vacio.");
	else
		alert("Debe indicar un nombre.");
		
	return false;
}

    function initialize(origen, destino) {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map_canvas"));
       // map.setCenter(new GLatLng(37.4419, -122.1419), 13);
//		map.addControl(new GSmallMapControl());
		map.setUIToDefault();

        geocoder = new GClientGeocoder();
		if (origen!=""){
			map.setCenter(new GLatLng(40.111689,22.697754,7.173256,19.775391), 5);
			//directionsPanel = document.getElementById("route");

		  directions = new GDirections(map, directionsPanel);
	    	 directions.load("from: "+origen+" to: "+destino);
		}else{
			showAddress(destino);
		}
      }
    }

    function showAddress(address) {
      if (geocoder) {
	        geocoder.getLatLng(
          address,
          function(point) {
            if (point) {
              map.setCenter(point, 5);
              var marker = new GMarker(point);
              map.addOverlay(marker);
              marker.openInfoWindowHtml(address);
            }
          }
        );
      }
    }
	
function isEmailAddress(theElement)
{
var s = theElement.value;
var filter=/^[A-Za-z_.][A-Za-z0-9_.]*@[A-Za-z0-9_]+\.[A-Za-z0-9_.]+[A-za-z]$/;
if (s.length == 0 ) theElement.focus();
if (filter.test(s))
return true;
else
theElement.className="success";

return false;
}

function validarForm(){
	var error="";
	if (document.getElementById("nombre").value==""){
		document.getElementById("nombre").className="succes";
		error+="El nombre no puede estar vacio.\n";
	}
	
	if (document.getElementById("email").value==""){
		document.getElementById("email").className="succes";
		error+="El email no puede estar vacio.\n";
		}else if(!isEmailAddress(document.getElementById("email"))){
			document.getElementById("email").className="succes";
			error+="Ingrese una dirección de correo válida.\n";
	}
	
	if (document.getElementById("comentario").value==""){
		document.getElementById("comentario").className="succes";
		error+="El comentario no puede estar vacio.\n";
	}
	
	if (error=="")
		document.getElementById("formcontacto").submit();
	else
		alert(error);
}

function validarFormNewsletter(){
	var error="";
	if (document.getElementById("nombre_contacto").value==""){
		document.getElementById("nombre_contacto").className="succes";
		error+="El nombre no puede estar vacio.\n";
	}
	
	if (document.getElementById("email_contacto").value==""){
		document.getElementById("email_contacto").className="succes";
		error+="El email no puede estar vacio.\n";
		}else if(!isEmailAddress(document.getElementById("email_contacto"))){
			document.getElementById("email_contacto").className="succes";
			error+="Ingrese una dirección de correo válida.\n";
	}
	
	if (error=="")
		document.getElementById("formnewsletter").submit();
	else
		alert(error);
}

function validarFormularioComentario(captcha_texto_session){
var texto_ingresado = document.getElementById("texto_ingresado").value;
var captcha_texto = captcha_texto_session;
	var error="";

	if (document.getElementById("nombre").value==""){
		document.getElementById("nombre").className="succes";
		error+="El nombre no puede estar vacio.\n";
	}

	if (document.getElementById("email").value!=""){
		if(!isEmailAddress(document.getElementById("email"))){
			document.getElementById("email").className="succes";
			error+="Ingrese una dirección de correo válida.\n";
			}
	}

	if (document.getElementById("comentario").value==""){
		document.getElementById("comentario").className="succes";
		error+="El comentario no puede estar vacio.\n";
	}


	if (texto_ingresado != captcha_texto) {
		document.getElementById("texto_ingresado").className="succes";
		error+= "El texto del captcha ingresado no coincide. Por favor intentelo de nuevo!";
	} 

	if (error=="")
		document.getElementById("formComentario").submit();
	else{
		document.getElementById("dialog").innerHTML=error;
		$( "#dialog" ).dialog( "open" );
			return false;
		//alert(error);
		
	}
}

function validarFormularioInsertarUsuario(){
	var error="";

	if (document.getElementById("nombre_usuario").value==""){
		document.getElementById("nombre_usuario").className="succes";
		error+="El nombre no puede estar vacio.\n";
	}

	if (document.getElementById("email_usuario").value!=""){
		if(!isEmailAddress(document.getElementById("email_usuario"))){
			document.getElementById("email_usuario").className="succes";
			error+="Ingrese una dirección de correo válida.\n";
			}
	}else{
			document.getElementById("email_usuario").className="succes";
			error+="Ingrese una dirección de correo válida.\n";
	
	}

	if (document.getElementById("password_usuario").value==""){
		document.getElementById("password_usuario").className="succes";
		error+="El password no puede estar vacio.\n";
	}
	
	if (document.getElementById("password_usuario").value.length < 6){
		document.getElementById("password_usuario").className="succes";
		error+="El password mas grande.\n";
	}
	
	if (document.getElementById("password_usuario").value!=document.getElementById("confirmar_password_usuario").value){
		document.getElementById("confirmar_password_usuario").className="succes";
		error+="El password no y la confirmación del password son distintos.\n";
	}

	if (error=="")
		document.getElementById("formInsertarUsuario").submit();
	else
		alert(error);
}
		 
function validarFormularioInsertarProductoxusuario(){

	var error="";

	if (document.getElementById("titulo_es").value==""){
		document.getElementById("titulo_es").className="succes";
		error+="- El nombre no puede estar vacio.<br /><br />";
	}

	/*if (document.getElementById("contenido_es").value==""){
		document.getElementById("contenido_es").className="succes";
		error+="La descripci�n no puede estar vacia.\n";
	}*/
	
	if (document.getElementById("nombre_padre").value=="0"){
		document.getElementById("nombre_padre").className="succes";
		error+="- Debe elegir una categor&iacute;a para el producto.<br /><br />";
	}
	
	/*
	if (document.getElementById("cant_destacados").value+document.getElementById("destacado").value > document.getElementById("max_destacados").value){
		error+="Ya tiene demasiados productos destacados. Para ampliar los servicios de campo-vende contáctenos.\n";
	}*/

	if (document.getElementById("cant_productos").value+1>document.getElementById("max_productos").value){
		error+="- Ya tiene demasiados productos cargados. Su categor&iacute;a de usuario le permite cargar "+document.getElementById("max_productos").value+" como m&aacute;ximo. Para ampliar los servicios de campo-vende cont&aacute;ctenos.<br />";
	}


	if (error=="")
		document.getElementById("forminsertarproducto").submit();
	else{
		//alert(error);
	
		document.getElementById("dialog").innerHTML=error;
		$( "#dialog" ).dialog( "open" );
			return false;
	}
}

function validarFormularioEditarProductoxusuario(){

	var error="";

	if (document.getElementById("titulo_es").value==""){
		document.getElementById("titulo_es").className="succes";
		error+="- El nombre no puede estar vacio.<br /><br />";
	}
	if (document.getElementById("nombre_padre").value=="0"){
		document.getElementById("nombre_padre").className="succes";
		error+="- Debe elegir una categor&iacute;a para el producto.<br /><br />";
	}
	if (error=="")
		document.getElementById("formeditarproducto").submit();
	else{
		document.getElementById("dialog").innerHTML=error;
		$( "#dialog" ).dialog( "open" );
			return false;
	}
}

