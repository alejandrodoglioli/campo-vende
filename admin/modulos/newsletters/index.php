<?php
include("../../include/include.funciones.php");

session_start(); 
if ($action == "listar_newsletters") {
    include("include/include.newsletters.php");
	listar_newsletters(); 
}elseif ($action == "insertar_newsletters") {
	include("include/include.newsletters.php");
	insertar_newsletters(); 
}elseif ($action == "insertar_newsletters_ok") {
	include("include/include.newsletters.php");
	insertar_newsletters_ok(); 
}elseif ($action == "editar_newsletters") {
	include("include/include.newsletters.php");
	editar_newsletters(); 
}elseif ($action == "editar_newsletters_ok") {
	include("include/include.newsletters.php");
	editar_newsletters_ok(); 
}elseif ($action == "eliminar_newsletters") {
	include("include/include.newsletters.php");
	eliminar_newsletters(); 
}elseif ($action == "eliminar_newsletters_ok") {
	include("include/include.newsletters.php");
	eliminar_newsletters_ok(); 
}elseif ($action == "enviar_newsletters") {
	include("include/include.newsletters.php");
	enviar_newsletters(); 
} elseif ($action == "enviar_newsletters_ok") {
	include("include/include.newsletters.php");
	enviar_newsletters_ok(); 
}elseif ($action == "listar_grupos_contactos") {
    include("include/include.grupos_contactos.php");
	listar_grupos_contactos(); 
}elseif ($action == "insertar_grupos_contactos") {
	include("include/include.grupos_contactos.php");
	insertar_grupos_contactos(); 
}elseif ($action == "insertar_grupos_contactos_ok") {
	include("include/include.grupos_contactos.php");
	insertar_grupos_contactos_ok(); 
}elseif ($action == "editar_grupos_contactos") {
	include("include/include.grupos_contactos.php");
	editar_grupos_contactos(); 
}elseif ($action == "editar_grupos_contactos_ok") {
	include("include/include.grupos_contactos.php");
	editar_grupos_contactos_ok(); 
}elseif ($action == "eliminar_grupos_contactos") {
	include("include/include.grupos_contactos.php");
	eliminar_grupos_contactos(); 
}elseif ($action == "eliminar_grupos_contactos_ok") {
	include("include/include.grupos_contactos.php");
	eliminar_grupos_contactos_ok(); 
}elseif ($action == "listar_contactos") {
    include("include/include.contactos.php");
	listar_contactos(); 
}elseif ($action == "insertar_contactos") {
	include("include/include.contactos.php");
	insertar_contactos(); 
}elseif ($action == "insertar_contactos_ok") {
	include("include/include.contactos.php");
	insertar_contactos_ok(); 
}elseif ($action == "editar_contactos") {
	include("include/include.contactos.php");
	editar_contactos(); 
}elseif ($action == "editar_contactos_ok") {
	include("include/include.contactos.php");
	editar_contactos_ok(); 
}elseif ($action == "eliminar_contactos") {
	include("include/include.contactos.php");
	eliminar_contactos(); 
}elseif ($action == "eliminar_contactos_ok") {
	include("include/include.contactos.php");
	eliminar_contactos_ok(); 
} else{
	include("include/include.newsletters.php");
	listar_newsletters(); 
}
?>