<?php
include("../../include/include.funciones.php");

session_start(); 

if ($action == "listar_productos") {
    include("include/include.productos.php");
	listar_productos(); 
}elseif ($action == "insertar_productos") {
	include("include/include.productos.php");
	insertar_productos(); 
}elseif ($action == "insertar_productos_ok") {
	include("include/include.productos.php");
	insertar_productos_ok(); 
}elseif ($action == "editar_productos") {
	include("include/include.productos.php");
	editar_productos(); 
}elseif ($action == "editar_productos_ok") {
	include("include/include.productos.php");
	editar_productos_ok(); 
}elseif ($action == "eliminar_productos") {
	include("include/include.productos.php");
	eliminar_productos(); 
}elseif ($action == "eliminar_productos_ok") {
	include("include/include.productos.php");
	eliminar_productos_ok(); 
}elseif ($action == "listar_tipoproducto") {
    include("include/include.tipoproducto.php");
	listar_tipoproducto(); 
} elseif ($action == "insertar_tipoproducto") {
    include("include/include.tipoproducto.php");
	insertar_tipoproducto(); 
} elseif ($action == "insertar_tipoproducto_ok") {
    include("include/include.tipoproducto.php");
	insertar_tipoproducto_ok(); 
}  elseif ($action == "editar_tipoproducto") {
    include("include/include.tipoproducto.php");
	editar_tipoproducto(); 
} elseif ($action == "editar_tipoproducto_ok") {
    include("include/include.tipoproducto.php");
	editar_tipoproducto_ok(); 
} elseif ($action == "eliminar_tipoproducto") {
    include("include/include.tipoproducto.php");
	eliminar_tipoproducto(); 
} elseif ($action == "eliminar_tipoproducto_ok") {
    include("include/include.tipoproducto.php");
	eliminar_tipoproducto_ok(); 
}elseif ($action == "listar_comentariosxproductos") {
    include("include/include.comentariosxproductos.php");
	listar_comentariosxproductos(); 
} elseif ($action == "insertar_comentariosxproductos") {
    include("include/include.comentariosxproductos.php");
	insertar_comentariosxproductos(); 
} elseif ($action == "insertar_comentariosxproductos_ok") {
    include("include/include.comentariosxproductos.php");
	insertar_comentariosxproductos_ok(); 
}  elseif ($action == "editar_comentariosxproductos") {
    include("include/include.comentariosxproductos.php");
	editar_comentariosxproductos(); 
} elseif ($action == "editar_comentariosxproductos_ok") {
    include("include/include.comentariosxproductos.php");
	editar_comentariosxproductos_ok(); 
} elseif ($action == "eliminar_comentariosxproductos") {
    include("include/include.comentariosxproductos.php");
	eliminar_comentariosxproductos(); 
} elseif ($action == "eliminar_comentariosxproductos_ok") {
    include("include/include.comentariosxproductos.php");
	eliminar_comentariosxproductos_ok(); 
}else{
	include("include/include.productos.php");
	listar_productos(); 
}
?>