<?

session_start();
error_reporting(0);
include("../include/class.Template.php");
include("../include/config.php");
include("../include/conexion.php");
include("include/include.funciones.php");


require("include/checkSession.php");

/****************** LISTADO (SI ESTA LOGUEADO PAGINA POR DEFECTO) **************/
	mostrar_home();
/*********************************************************************************************/


?>
