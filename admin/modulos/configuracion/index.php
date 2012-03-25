<?php

include("../../include/include.funciones.php");

session_start(); 
if ($action == "editar_configuracion") {
	include("../configuracion/include/include.configuracion.php");
	editar_configuracion(); 
}elseif ($action == "editar_configuracion_ok") {
	include("../configuracion/include/include.configuracion.php");
	editar_configuracion_ok(); 
}else{
include("../configuracion/include/include.configuracion.php");
	editar_configuracion(); 
}
?>