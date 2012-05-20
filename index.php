<?php
include_once("include/class.Template.php");
include_once("include/include.funciones.php");
include_once("include/config.php");
include_once("include/lib.inc.php");
include_once("include/conexion.php");
include_once("modulos/albums/auth.php");

session_start();

$action=$_GET['action'];

if ($action == "listar_albums") {
    include("modulos/albums/index.php");
	listar_albums(); 
	break;	
}elseif ($action == "mostrar_album") {
    include("modulos/albums/index.php");
	mostrar_album(); 
	break;
}elseif ($action == "mostrar_foto") {
    include("modulos/albums/index.php");
	mostrar_foto(); 
	break;
}elseif ($action == "mostrar_seccion") {
	include("modulos/secciones/index.php");
    mostrar_seccion(); 
	break;
}elseif ($action == "gracias_consulta") {
	include("modulos/secciones/index.php");
    insertar_comentario(); 
	break;	
}elseif ($action == "mostrar_producto") {
	include("modulos/productos/index.php");
    mostrar_producto(); 
	break;	
}elseif ($action == "gracias_comentario_producto") {
	include("modulos/productos/index.php");
    insertar_comentario(); 
	break;	
}elseif ($action == "mostrar_modulo") {
		if(isset($noticia)){
			include("modulos/noticias/index.php");
			mostrar_detalle_noticias(); 
			break;			
		}elseif (($modulo=="noticias") or ($modulo=="news") or ($modulo=="nouvelles")){
			$modulo="noticias";
			include("modulos/".$modulo."/index.php");
			$funcion="mostrar_".$modulo;
			$funcion(); 
			break;			
		}elseif (($modulo=="enlaces") or ($modulo=="links")){
				$modulo="enlaces";
				include("modulos/".$modulo."/index.php");
				$funcion="mostrar_".$modulo;
				$funcion(); 
			break;
		}
}/*elseif ($action == "gracias-newsletter") {
	include("modulos/newsletter/index.php");
	subscribirse_newsletter($nombre_contacto,$apellido_contacto,$email_contacto); 
}*/elseif ($action == "mostrar_mapaweb") {
	include("include/include.mapaweb.php");
	if(isset($id_seccion)){
		mostrar_mapaweb_seccion($id_seccion);
			break;
		}
	else{
		mostrar_mapaweb();
			break;
		}
}elseif ($action == "buscar") {
	include("include/include.buscar.php");
	$texto=$_POST['texto'];
	mostrar_busqueda($texto); 
		break;
}elseif ($action == "mostrar_contacto") {
	include("include/include.contacto.php");
    mostrar_contacto(); 
		break;
}elseif ($action == "enviar_contacto") {
	include("include/include.contacto.php");
    enviar_contacto(); 
		break;
}elseif ($action == "gracias_contacto") {
	include("include/include.contacto.php");
    gracias_contacto(); 
		break;
}elseif (($action == "login" or $action == "listar_productoxusuario")&& !isset($_SESSION[user_sistema])) {
	include("modulos/usuarios_sistema/login.php");
    #mostrar_login(); 
		break;
}elseif ($action == "registrar_usuario_sistema") {
	include("modulos/usuarios_sistema/index.php");
    registrar_usuario_sistema(); 
		break;
}elseif ($action == "insertar_usuarios_sistema_ok") {
	include("modulos/usuarios_sistema/index.php");
    insertar_usuarios_sistema_ok(); 
		break;
}elseif ($action == "modificar_usuario_sistema_ok") {
	include("modulos/usuarios_sistema/index.php");
    modificar_usuario_sistema_ok();     
		break;
}elseif (($action == "login" or $action == "listar_productoxusuario") && isset($_SESSION[user_sistema])) {
	include("modulos/usuarios_sistema/index.php");
	mostrar_usuario_sistema(); 
		break;
}elseif (($action == "mostrar_datos_usuario") && isset($_SESSION[user_sistema])) {
	include("modulos/usuarios_sistema/index.php");
	mostrar_datos_usuario(); 
		break;
}elseif ($action == "insertar_productoxusuario") {
	include("modulos/usuarios_sistema/index.php");
 	insertar_productoxusuario(); 
		break;
}elseif ($action == "insertar_productoxusuario_ok") {
	include("modulos/usuarios_sistema/index.php");
 	insertar_productoxusuario_ok(); 
		break;
}elseif ($action == "editar_productoxusuario") {
	include("modulos/usuarios_sistema/index.php");
 	editar_productoxusuario(); 
		break;
}elseif ($action == "editar_productoxusuario_ok") {
	include("modulos/usuarios_sistema/index.php");
	editar_productoxusuario_ok(); 
		break;
}elseif ($action == "eliminar_productoxusuario") {
	include("modulos/usuarios_sistema/index.php");
	eliminar_productoxusuario(); 
		break;
}elseif ($action == "eliminar_productoxusuario_ok") {
	include("modulos/usuarios_sistema/index.php");
 	eliminar_productoxusuario_ok(); 
		break;
}elseif ($action == "listarpregunta_productoxusuario") {
	include("modulos/usuarios_sistema/index.php");
 	mostrarpregunta_productoxusuario(); 
		break;
}elseif ($action == "editarpregunta_productoxusuario") {
	include("modulos/usuarios_sistema/index.php");
 	editarpregunta_productoxusuario(); 
		break;
}elseif ($action == "editarpregunta_productoxusuario_ok") {
	include("modulos/usuarios_sistema/index.php");
	editarpregunta_productoxusuario_ok(); 
		break;
}elseif ($action == "eliminarpregunta_productoxusuario") {
	include("modulos/usuarios_sistema/index.php");
	eliminarpregunta_productoxusuario(); 
		break;
}elseif ($action == "eliminarpregunta_productoxusuario_ok") {
	include("modulos/usuarios_sistema/index.php");
 	eliminarpregunta_productoxusuario_ok(); 
		break;
}elseif ($action == "logout_productoxusuario") {
 	require_once("modulos/usuarios_sistema/login.php");
		break;
}elseif ($action == "recuperar_password") {
 	require_once("modulos/usuarios_sistema/index.php");
 	recuperar_password();
		break;
}if ($action == "mostrar_comercios") {
    include("modulos/comercios/index.php");
	mostrar_comercios(); 
		break;
}elseif ($action == "mostrar_comercio") {
    include("modulos/comercios/index.php");
	mostrar_comercio(); 
		break;
}else{
	mostrarHome();
		break;
}
?>
