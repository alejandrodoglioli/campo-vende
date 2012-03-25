<?php
include("../../include/include.funciones.php");

if ($action == "listar_usuarios_sistema") {
    include("include/include.usuarios_sistema.php");
	listar_usuarios_sistema(); 
}elseif ($action == "insertar_usuarios_sistema") {
	include("include/include.usuarios_sistema.php");
	insertar_usuarios_sistema(); 
}elseif ($action == "insertar_usuarios_sistema_ok") {
	include("include/include.usuarios_sistema.php");
	insertar_usuarios_sistema_ok(); 
}elseif ($action == "editar_usuarios_sistema") {
	include("include/include.usuarios_sistema.php");
	editar_usuarios_sistema(); 
}elseif ($action == "editar_usuarios_sistema_ok") {
	include("include/include.usuarios_sistema.php");
	editar_usuarios_sistema_ok(); 
}elseif ($action == "eliminar_usuarios_sistema") {
	include("include/include.usuarios_sistema.php");
	eliminar_usuarios_sistema(); 
}elseif ($action == "eliminar_usuarios_sistema_ok") {
	include("include/include.usuarios_sistema.php");
	eliminar_usuarios_sistema_ok(); 
} else{
	include("include/include.usuarios_sistema.php");
	listar_usuarios_sistema(); 
}
?>