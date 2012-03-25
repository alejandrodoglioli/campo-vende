<?php
include("../../include/include.funciones.php");

session_start(); 
if ($action == "listar_albums") {
    include("include/include.albums.php");
	listar_albums(); 
}elseif ($action == "insertar_albums") {
	include("include/include.albums.php");
	insertar_albums(); 
}elseif ($action == "insertar_albums_ok") {
	include("include/include.albums.php");
	insertar_albums_ok(); 
}elseif ($action == "editar_albums") {
	include("include/include.albums.php");
	editar_albums(); 
}elseif ($action == "editar_albums_ok") {
	include("include/include.albums.php");
	editar_albums_ok(); 
}elseif ($action == "eliminar_albums") {
	include("include/include.albums.php");
	eliminar_albums(); 
}elseif ($action == "eliminar_albums_ok") {
	include("include/include.albums.php");
	eliminar_albums_ok(); 
} elseif ($action == "listar_fotos") {
    include("include/include.fotos.php");
	listar_fotos(); 
}elseif ($action == "insertar_fotos") {
	include("include/include.fotos.php");
	insertar_fotos(); 
}elseif ($action == "insertar_fotos_ok") {
	include("include/include.fotos.php");
	insertar_fotos_ok(); 
}elseif ($action == "editar_fotos") {
	include("include/include.fotos.php");
	editar_fotos(); 
}elseif ($action == "editar_fotos_ok") {
	include("include/include.fotos.php");
	editar_fotos_ok(); 
}elseif ($action == "eliminar_fotos") {
	include("include/include.fotos.php");
	eliminar_fotos(); 
}elseif ($action == "eliminar_fotos_ok") {
	include("include/include.fotos.php");
	eliminar_fotos_ok(); 
}else{
	include("include/include.albums.php");
	listar_albums(); 
}
?>