<?PHP

error_reporting(E_ALL);

	error_reporting(0);

//	include("modulos/usuarios_sistema/index.php");
	require_once("include/checkSession.php");
	
	/****************** LISTADO (SI ESTA LOGUEADO PAGINA POR DEFECTO) **************/
	mostrar_login();
	/*********************************************************************************************/
?>
