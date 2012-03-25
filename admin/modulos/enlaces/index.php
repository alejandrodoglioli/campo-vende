<?php

include("../../include/include.funciones.php");

session_start(); 
if ($action == "listar_enlaces") {
    include("../enlaces/include/include.enlaces.php");
	listar_enlaces(); 
}elseif ($action == "insertar_enlaces") {
	include("../enlaces/include/include.enlaces.php");
	insertar_enlaces(); 
}elseif ($action == "insertar_enlaces_ok") {
	include("../enlaces/include/include.enlaces.php");
	insertar_enlaces_ok(); 
}elseif ($action == "editar_enlaces") {
	include("../enlaces/include/include.enlaces.php");
	editar_enlaces(); 
}elseif ($action == "editar_enlaces_ok") {
	include("../enlaces/include/include.enlaces.php");
	editar_enlaces_ok(); 
}elseif ($action == "eliminar_enlaces") {
	include("../enlaces/include/include.enlaces.php");
	eliminar_enlaces(); 
}elseif ($action == "eliminar_enlaces_ok") {
	include("../enlaces/include/include.enlaces.php");
	eliminar_enlaces_ok(); 
} else{
	include("../enlaces/include/include.enlaces.php");
	listar_enlaces(); 
}
?>