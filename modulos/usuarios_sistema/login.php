<?PHP

error_reporting(E_ALL);

	error_reporting(0);

	include("index.php");
	require_once("../../include/checkSession.php");
	//echo "edee";exit;
	/****************** LISTADO (SI ESTA LOGUEADO PAGINA POR DEFECTO) **************/
	mostrar_login();
	/*********************************************************************************************/
?>
