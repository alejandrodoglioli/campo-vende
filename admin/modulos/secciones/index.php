<?php
include("../../include/include.funciones.php");

session_start(); 

if ($action == "listar_secciones") {
    include("include/include.secciones.php");
	listar_secciones(); 
}elseif ($action == "insertar_secciones") {
	include("include/include.secciones.php");
	insertar_secciones(); 
}elseif ($action == "insertar_secciones_ok") {
	include("include/include.secciones.php");
	insertar_secciones_ok(); 
}elseif ($action == "editar_secciones") {
	include("include/include.secciones.php");
	editar_secciones(); 
}elseif ($action == "editar_secciones_ok") {
	include("include/include.secciones.php");
	editar_secciones_ok(); 
}elseif ($action == "eliminar_secciones") {
	include("include/include.secciones.php");
	eliminar_secciones(); 
}elseif ($action == "eliminar_secciones_ok") {
	include("include/include.secciones.php");
	eliminar_secciones_ok(); 
}elseif ($action == "listar_tiposeccion") {
    include("include/include.tiposeccion.php");
	listar_tiposeccion(); 
} elseif ($action == "insertar_tiposeccion") {
    include("include/include.tiposeccion.php");
	insertar_tiposeccion(); 
} elseif ($action == "insertar_tiposeccion_ok") {
    include("include/include.tiposeccion.php");
	insertar_tiposeccion_ok(); 
}  elseif ($action == "editar_tiposeccion") {
    include("include/include.tiposeccion.php");
	editar_tiposeccion(); 
} elseif ($action == "editar_tiposeccion_ok") {
    include("include/include.tiposeccion.php");
	editar_tiposeccion_ok(); 
} elseif ($action == "eliminar_tiposeccion") {
    include("include/include.tiposeccion.php");
	eliminar_tiposeccion(); 
} elseif ($action == "eliminar_tiposeccion_ok") {
    include("include/include.tiposeccion.php");
	eliminar_tiposeccion_ok(); 
}elseif ($action == "listar_comentariosxsecciones") {
    include("include/include.comentariosxsecciones.php");
	listar_comentariosxsecciones(); 
} elseif ($action == "insertar_comentariosxsecciones") {
    include("include/include.comentariosxsecciones.php");
	insertar_comentariosxsecciones(); 
} elseif ($action == "insertar_comentariosxsecciones_ok") {
    include("include/include.comentariosxsecciones.php");
	insertar_comentariosxsecciones_ok(); 
}  elseif ($action == "editar_comentariosxsecciones") {
    include("include/include.comentariosxsecciones.php");
	editar_comentariosxsecciones(); 
} elseif ($action == "editar_comentariosxsecciones_ok") {
    include("include/include.comentariosxsecciones.php");
	editar_comentariosxsecciones_ok(); 
} elseif ($action == "eliminar_comentariosxsecciones") {
    include("include/include.comentariosxsecciones.php");
	eliminar_comentariosxsecciones(); 
} elseif ($action == "eliminar_comentariosxsecciones_ok") {
    include("include/include.comentariosxsecciones.php");
	eliminar_comentariosxsecciones_ok(); 
}else{
	include("include/include.secciones.php");
	listar_secciones(); 
}
?>