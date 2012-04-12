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
}elseif ($action == "mostrar_album") {
    include("modulos/albums/index.php");
	mostrar_album(); 
}elseif ($action == "mostrar_foto") {
    include("modulos/albums/index.php");
	mostrar_foto(); 
}elseif ($action == "mostrar_seccion") {
	include("modulos/secciones/index.php");
    mostrar_seccion(); 
}elseif ($action == "gracias_comentario") {
	include("modulos/secciones/index.php");
    insertar_comentario(); 
}elseif ($action == "mostrar_producto") {
	include("modulos/productos/index.php");
    mostrar_producto(); 
}elseif ($action == "gracias_comentario_producto") {
	include("modulos/productos/index.php");
    insertar_comentario(); 
}elseif ($action == "mostrar_modulo") {
		if(isset($noticia)){
			include("modulos/noticias/index.php");
			mostrar_detalle_noticias(); 
		}elseif (($modulo=="noticias") or ($modulo=="news") or ($modulo=="nouvelles")){
			$modulo="noticias";
			include("modulos/".$modulo."/index.php");
			$funcion="mostrar_".$modulo;
			$funcion(); 
		}elseif (($modulo=="enlaces") or ($modulo=="links")){
				$modulo="enlaces";
				include("modulos/".$modulo."/index.php");
				$funcion="mostrar_".$modulo;
				$funcion(); 
		}
}/*elseif ($action == "gracias-newsletter") {
	include("modulos/newsletter/index.php");
	subscribirse_newsletter($nombre_contacto,$apellido_contacto,$email_contacto); 
}*/elseif ($action == "mostrar_mapaweb") {
	include("include/include.mapaweb.php");
	if(isset($id_seccion)){
		mostrar_mapaweb_seccion($id_seccion);
		}
	else{
		mostrar_mapaweb();
		}
}elseif ($action == "buscar") {
	include("include/include.buscar.php");
	$texto=$_POST['texto'];
	mostrar_busqueda($texto); 
}elseif ($action == "mostrar_contacto") {
	include("include/include.contacto.php");
    mostrar_contacto(); 
}elseif ($action == "enviar_contacto") {
	include("include/include.contacto.php");
    enviar_contacto(); 
}elseif ($action == "gracias_contacto") {
	include("include/include.contacto.php");
    gracias_contacto(); 
}elseif (($action == "login" or $action == "listar_productoxusuario")&& !isset($_SESSION[user_sistema])) {
	require_once("modulos/usuarios_sistema/login.php");
}elseif ($action == "registrar_usuario_sistema") {
	include("modulos/usuarios_sistema/index.php");
    registrar_usuario_sistema(); 
}elseif ($action == "insertar_usuarios_sistema_ok") {
	include("modulos/usuarios_sistema/index.php");
    insertar_usuarios_sistema_ok(); 
}elseif (($action == "login" or $action == "listar_productoxusuario") && isset($_SESSION[user_sistema])) {
	include("modulos/usuarios_sistema/index.php");
	mostrar_usuario_sistema(); 
}elseif ($action == "insertar_productoxusuario") {
	include("modulos/usuarios_sistema/index.php");
 	insertar_productoxusuario(); 
}elseif ($action == "insertar_productoxusuario_ok") {
	include("modulos/usuarios_sistema/index.php");
 	insertar_productoxusuario_ok(); 
}elseif ($action == "editar_productoxusuario") {
	include("modulos/usuarios_sistema/index.php");
 	editar_productoxusuario(); 
}elseif ($action == "editar_productoxusuario_ok") {
	include("modulos/usuarios_sistema/index.php");
	editar_productoxusuario_ok(); 
}elseif ($action == "eliminar_productoxusuario") {
	include("modulos/usuarios_sistema/index.php");
	eliminar_productoxusuario(); 
}elseif ($action == "eliminar_productoxusuario_ok") {
	include("modulos/usuarios_sistema/index.php");
 	eliminar_productoxusuario_ok(); 
}elseif ($action == "logout_productoxusuario") {
 	require_once("modulos/usuarios_sistema/login.php");
}else{
	mostrarHome();
}
?>
