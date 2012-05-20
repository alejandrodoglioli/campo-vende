<?
global $idioma;

function setearTraducciones(&$t){
	global $idioma;
	
	include_once($idioma.".php");
	
	//Traducciones Template
	$t->set_var("traduccion_categorias", $traduccion_categorias);
	$t->set_var("traduccion_idiomas", $traduccion_idiomas);
	$t->set_var("traduccion_contacto", $traduccion_contacto);
	$t->set_var("traduccion_mapaweb", $traduccion_mapaweb);
	$t->set_var("traduccion_buscar", $traduccion_buscar);
	$t->set_var("traduccion_secciones", $traduccion_secciones);
	$t->set_var("traduccion_etiquetas", $traduccion_etiquetas);
	$t->set_var("traduccion_copyright", $traduccion_copyright);
	$t->set_var("traduccion_disenadopor", $traduccion_disenadopor);
	$t->set_var("traduccion_slogannewsletter", $traduccion_slogannewsletter);
	$t->set_var("traduccion_comercios", $traduccion_comercios);
	
	//Traducciones Contacto
	$t->set_var("traduccion_nombre", $traduccion_nombre);
	$t->set_var("traduccion_email", $traduccion_email);
	$t->set_var("traduccion_comentario", $traduccion_comentario);
	$t->set_var("traduccion_enviar", $traduccion_enviar);
	
	//Traducciones Buscar
	$t->set_var("traduccion_vermas", $traduccion_vermas);
	
	//Traducciones GraciasContacto
	$t->set_var("traduccion_graciascontacto", $traduccion_graciascontacto);
	
	//Traducciones Secciones
	$t->set_var("traduccion_camposrequeridos", $traduccion_camposrequeridos);
	$t->set_var("traduccion_enlacesrelacionados", $traduccion_enlacesrelacionados);
	$t->set_var("traduccion_escribasucomentario", $traduccion_escribasucomentario);
	
	//Traducciones Noticias
	$t->set_var("traduccion_publicadoel", $traduccion_publicadoel);
	
	//Traducciones Home
	$t->set_var("traduccion_destacados_ferries", $traduccion_destacados_ferries);
	$t->set_var("traduccion_destacados_hostales", $traduccion_destacados_hostales);
	$t->set_var("traduccion_noticias", $traduccion_noticias);
	}


?>
