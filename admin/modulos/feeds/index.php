<?php
include("../../include/include.funciones.php");

session_start(); 

if ($action == "listar_feeds") {
    include("include/include.feeds.php");
	listar_feeds(); 
}elseif ($action == "insertar_feeds") {
	include("include/include.feeds.php");
	insertar_feeds(); 
}elseif ($action == "insertar_feeds_ok") {
	include("include/include.feeds.php");
	insertar_feeds_ok(); 
}elseif ($action == "editar_feeds") {
	include("include/include.feeds.php");
	editar_feeds(); 
}elseif ($action == "editar_feeds_ok") {
	include("include/include.feeds.php");
	editar_feeds_ok(); 
}elseif ($action == "eliminar_feeds") {
	include("include/include.feeds.php");
	eliminar_feeds(); 
}elseif ($action == "eliminar_feeds_ok") {
	include("include/include.feeds.php");
	eliminar_feeds_ok(); 
}else{
	include("include/include.feeds.php");
	listar_feeds(); 
}
?>