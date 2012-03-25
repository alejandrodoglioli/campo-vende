<?php
include("../../include/include.funciones.php");

session_start(); 

if ($action == "listar_noticias") {
    include("include/include.noticias.php");
	listar_noticias(); 
}elseif ($action == "insertar_noticias") {
	include("include/include.noticias.php");
	insertar_noticias(); 
}elseif ($action == "insertar_noticias_ok") {
	include("include/include.noticias.php");
	insertar_noticias_ok(); 
}elseif ($action == "editar_noticias") {
	include("include/include.noticias.php");
	editar_noticias(); 
}elseif ($action == "editar_noticias_ok") {
	include("include/include.noticias.php");
	editar_noticias_ok(); 
}elseif ($action == "eliminar_noticias") {
	include("include/include.noticias.php");
	eliminar_noticias(); 
}elseif ($action == "eliminar_noticias_ok") {
	include("include/include.noticias.php");
	eliminar_noticias_ok(); 
} else{
	include("include/include.noticias.php");
	listar_noticias(); 
}
?>