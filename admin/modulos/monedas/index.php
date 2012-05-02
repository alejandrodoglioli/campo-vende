<?php

include("../../include/include.funciones.php");

session_start(); 
if ($action == "listar_monedas") {
    include("../monedas/include/include.monedas.php");
	listar_monedas(); 
}elseif ($action == "insertar_monedas") {
	include("../monedas/include/include.monedas.php");
	insertar_monedas(); 
}elseif ($action == "insertar_monedas_ok") {
	include("../monedas/include/include.monedas.php");
	insertar_monedas_ok(); 
}elseif ($action == "editar_monedas") {
	include("../monedas/include/include.monedas.php");
	editar_monedas(); 
}elseif ($action == "editar_monedas_ok") {
	include("../monedas/include/include.monedas.php");
	editar_monedas_ok(); 
}elseif ($action == "eliminar_monedas") {
	include("../monedas/include/include.monedas.php");
	eliminar_monedas(); 
}elseif ($action == "eliminar_monedas_ok") {
	include("../monedas/include/include.monedas.php");
	eliminar_monedas_ok(); 
} else{
	include("../monedas/include/include.monedas.php");
	listar_monedas(); 
}
?>