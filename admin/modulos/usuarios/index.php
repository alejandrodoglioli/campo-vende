<?php
include("../../include/include.funciones.php");

if ($action == "listar_usuarios") {
    include("include/include.usuarios.php");
	listar_usuarios(); 
}elseif ($action == "insertar_usuarios") {
	include("include/include.usuarios.php");
	insertar_usuarios(); 
}elseif ($action == "insertar_usuarios_ok") {
	include("include/include.usuarios.php");
	insertar_usuarios_ok(); 
}elseif ($action == "editar_usuarios") {
	include("include/include.usuarios.php");
	editar_usuarios(); 
}elseif ($action == "editar_usuarios_ok") {
	include("include/include.usuarios.php");
	editar_usuarios_ok(); 
}elseif ($action == "eliminar_usuarios") {
	include("include/include.usuarios.php");
	eliminar_usuarios(); 
}elseif ($action == "eliminar_usuarios_ok") {
	include("include/include.usuarios.php");
	eliminar_usuarios_ok(); 
} else{
	include("include/include.usuarios.php");
	listar_usuarios(); 
}
?>