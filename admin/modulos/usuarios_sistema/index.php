<?php
include("../../include/include.funciones.php");

if ($action == "listar_usuarios_sistema") {
    include("include/include.usuarios_sistema.php");
	listar_usuarios_sistema(); 
}elseif ($action == "insertar_usuarios_sistema") {
	include("include/include.usuarios_sistema.php");
	insertar_usuarios_sistema(); 
}elseif ($action == "insertar_usuarios_sistema_ok") {
	include("include/include.usuarios_sistema.php");
	insertar_usuarios_sistema_ok(); 
}elseif ($action == "editar_usuarios_sistema") {
	include("include/include.usuarios_sistema.php");
	editar_usuarios_sistema(); 
}elseif ($action == "editar_usuarios_sistema_ok") {
	include("include/include.usuarios_sistema.php");
	editar_usuarios_sistema_ok(); 
}elseif ($action == "eliminar_usuarios_sistema") {
	include("include/include.usuarios_sistema.php");
	eliminar_usuarios_sistema(); 
}elseif ($action == "eliminar_usuarios_sistema_ok") {
	include("include/include.usuarios_sistema.php");
	eliminar_usuarios_sistema_ok(); 
}elseif ($action == "listar_tipousuario") {
    include("include/include.tipousuario.php");
	listar_tipousuario(); 
} elseif ($action == "insertar_tipousuario") {
    include("include/include.tipousuario.php");
	insertar_tipousuario(); 
} elseif ($action == "insertar_tipousuario_ok") {
    include("include/include.tipousuario.php");
	insertar_tipousuario_ok(); 
}  elseif ($action == "editar_tipousuario") {
    include("include/include.tipousuario.php");
	editar_tipousuario(); 
} elseif ($action == "editar_tipousuario_ok") {
    include("include/include.tipousuario.php");
	editar_tipousuario_ok(); 
} elseif ($action == "eliminar_tipousuario") {
    include("include/include.tipousuario.php");
	eliminar_tipousuario(); 
} elseif ($action == "eliminar_tipousuario_ok") {
    include("include/include.tipousuario.php");
	eliminar_tipousuario_ok(); 
}else{
	include("include/include.usuarios_sistema.php");
	listar_usuarios_sistema(); 
}
?>