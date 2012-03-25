<?php

include("../../include/include.funciones.php");

session_start(); 
if ($action == "listar_idiomas") {
    include("../idiomas/include/include.idiomas.php");
	listar_idiomas(); 
}elseif ($action == "insertar_idiomas") {
	include("../idiomas/include/include.idiomas.php");
	insertar_idiomas(); 
}elseif ($action == "insertar_idiomas_ok") {
	include("../idiomas/include/include.idiomas.php");
	insertar_idiomas_ok(); 
}elseif ($action == "editar_idiomas") {
	include("../idiomas/include/include.idiomas.php");
	editar_idiomas(); 
}elseif ($action == "editar_idiomas_ok") {
	include("../idiomas/include/include.idiomas.php");
	editar_idiomas_ok(); 
}elseif ($action == "eliminar_idiomas") {
	include("../idiomas/include/include.idiomas.php");
	eliminar_idiomas(); 
}elseif ($action == "eliminar_idiomas_ok") {
	include("../idiomas/include/include.idiomas.php");
	eliminar_idiomas_ok(); 
} else{
	include("../idiomas/include/include.idiomas.php");
	listar_idiomas(); 
}
?>